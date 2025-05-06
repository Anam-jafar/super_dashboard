<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Institute;
use Illuminate\Support\Facades\Auth;
use App\Models\Parameter;
use Illuminate\Support\Facades\Http;
use App\Mail\SubscriptionApprove;
use Illuminate\Support\Facades\Mail;
use App\Services\DistrictAccessService;
use App\Services\SubscriptionService;

class SubscriptionController extends Controller
{
    protected $districtAccessService;

    public function __construct(DistrictAccessService $districtAccessService, SubscriptionService $subscriptionService)
    {
        $this->subscriptionService = $subscriptionService;
        $this->districtAccessService = $districtAccessService;
    }

    public function activeSubscriptions(Request $request)
    {
        $per_page = $request->per_page ?? 10;
        $query = Institute::query()
            ->where('subscription_status', 3)
            ->orderBy('id', 'desc');
        $query = $this->subscriptionService->applyFilters($query, $request);
        $subscriptions = $query->paginate($per_page)->withQueryString();
        $subscriptions->getCollection()->transform(fn ($subscription) => $this->subscriptionService->transformRelations($subscription, true));
        $statuses = DB::table('type')->where('grp', 'clientstatus')->get();

        $packages = DB::table('fin_coa_item')
            ->where('type', 'sales')
            ->pluck('val', 'id') // Swap id and val correctly
            ->toArray();

        $parameters = $this->getCommon();
        $parameters = array_merge($parameters, $this->districtAccessService->fetchDistrictParameters());
        $filteredParameters = $this->fetchParameterOptions($request, [
            'cate1' => ['type_CLIENT', 'categories'],
            'rem8'  => ['subdistrict', 'subdistricts'],
        ]);
        $parameters = array_merge($parameters, $filteredParameters);
        return view('subscription.active_subscription', compact(['subscriptions', 'parameters', 'statuses', 'packages']));
    }

    public function requestSubscriptions(Request $request)
    {
        $per_page = $request->per_page ?? 10;
        $query = Institute::query()
            ->where('subscription_status', 1)
            ->orderBy('id', 'desc');
        $query = $this->subscriptionService->applyFilters($query, $request);

        $subscriptions = $query->paginate($per_page)->withQueryString();
        $subscriptions->getCollection()->transform(fn ($subscription) => $this->subscriptionService->transformRelations($subscription));
        $packages = DB::table('fin_coa_item')
            ->where('type', 'sales')
            ->pluck('val', 'id') // Swap id and val correctly
            ->toArray();

        $parameters = $this->getCommon();
        $parameters = array_merge($parameters, $this->districtAccessService->fetchDistrictParameters());
        $filteredParameters = $this->fetchParameterOptions($request, [
            'cate1' => ['type_CLIENT', 'categories'],
            'rem8'  => ['subdistrict', 'subdistricts'],
        ]);
        $parameters = array_merge($parameters, $filteredParameters);

        return view('subscription.new_subscription_application', compact(['subscriptions', 'parameters', 'packages']));
    }




    public function outstandingSubscriptions(Request $request)
    {
        $districtAccess = DB::table('usr')->where('mel', Auth::user()->mel)->value('joblvl');
        $per_page = $request->per_page ?? 10;

        $query = DB::table('client as c');

        if ($districtAccess != null) {
            $query->where('c.rem8', $districtAccess);
        }

        // Apply request filters
        if ($request->filled('rem8')) {
            $query->where('c.rem8', $request->rem8);
        }

        if ($request->filled('rem9')) {
            $query->where('c.rem9', $request->rem9);
        }

        if ($request->filled('cate')) {
            $query->where('c.cate', $request->cate);
        }

        if ($request->filled('cate1')) {
            $query->where('c.cate1', $request->cate1);
        }

        if ($request->filled('search')) {
            $query->where('c.name', 'LIKE', '%' . $request->search . '%');
        }


        $subscriptions = $query->joinSub(
            DB::table('fin_ledger as inv')
                ->leftJoinSub(
                    DB::table('fin_ledger')
                        ->select('vid', DB::raw('SUM(val) AS total_received'))
                        ->where('src', 'CSL')
                        ->groupBy('vid'),
                    'payments', // Alias for the subquery
                    'inv.vid',
                    '=',
                    'payments.vid'
                )
                ->select(
                    'inv.vid',
                    DB::raw('SUM(inv.val) AS total_invoice'),
                    DB::raw('COALESCE(payments.total_received, 0) AS total_received'),
                    DB::raw('SUM(inv.val) - COALESCE(payments.total_received, 0) AS outstanding')
                )
                ->where('inv.src', 'INV')
                ->groupBy('inv.vid', 'payments.total_received')
                ->havingRaw('SUM(inv.val) - COALESCE(payments.total_received, 0) > 0'), // Ensure outstanding > 0
            'subquery',
            'c.uid',
            '=',
            'subquery.vid'
        )
        ->where('c.subscription_status', 2)
        ->select(
            'c.name as name',
            'c.cate1 as cate1',
            'c.cate as cate',
            'c.rem8 as district',
            'c.rem9 as subdistrict',
            'subquery.total_invoice',
            'subquery.total_received',
            'subquery.outstanding'
        )
        ->paginate($per_page);


        // Optimize transformations by pre-fetching necessary parameters
        $cate1Codes = $subscriptions->pluck('cate1')->filter()->unique();
        $districtCodes = $subscriptions->pluck('district')->filter()->unique();
        $subdistrictCodes = $subscriptions->pluck('subdistrict')->filter()->unique();
        $cateCodes = $subscriptions->pluck('cate')->filter()->unique();

        $parametersData = Parameter::whereIn('code', $cate1Codes->merge($districtCodes)->merge($subdistrictCodes)->merge($cateCodes))
            ->pluck('prm', 'code');

        $subscriptions->getCollection()->transform(function ($subscription) use ($parametersData) {
            $subscription->NAME = isset($subscription->name) ? strtoupper($subscription->name) : null;
            $subscription->TYPE = isset($subscription->cate1) ? strtoupper($parametersData[$subscription->cate1] ?? '') : null;
            $subscription->DISTRICT = isset($subscription->district) ? strtoupper($parametersData[$subscription->district] ?? '') : null;
            $subscription->SUBDISTRICT = isset($subscription->subdistrict) ? strtoupper($parametersData[$subscription->subdistrict] ?? '') : null;
            $subscription->CATEGORY = isset($subscription->cate) ? strtoupper($parametersData[$subscription->cate] ?? '') : null;
            $subscription->TOTAL_INVOICE = 'RM ' . number_format($subscription->total_invoice, 2);
            $subscription->TOTAL_RECEIVED = 'RM ' . number_format($subscription->total_received, 2);
            $subscription->TOTAL_OUTSTANDING = 'RM ' . number_format($subscription->outstanding, 2);

            return $subscription;
        });

        $parameters = $this->getCommon();
        $parameters = array_merge($parameters, $this->districtAccessService->fetchDistrictParameters());
        $filteredParameters = $this->fetchParameterOptions($request, [
            'cate1' => ['type_CLIENT', 'categories'],
            'rem8'  => ['subdistrict', 'subdistricts'],
        ]);
        $parameters = array_merge($parameters, $filteredParameters);


        return view('subscription.outstanding_list', compact(['subscriptions', 'parameters']));
    }

    public function subscriptionFeeAdd(Request $request)
    {
        try {
            $subscriptionId = $request->input('subscriptionId');
            $packageId = $request->input('packageId');

            $user_id = DB::table('client')->where('id', $subscriptionId)->value('uid');
            if (!$user_id) {
                return response()->json(['success' => false, 'message' => 'User not found'], 404);
            }

            $url = "https://maisdev.awfatech.com/main/app/finance/invoice_gen.php?sysapp=maisadmineboss&cli={$user_id}&item={$packageId}";
            $response = Http::get($url);
            $responseData = $response->json();
            if ($response->successful() && isset($responseData['status']) && $responseData['status'] === 'Success') {
                DB::table('client')
                    ->where('id', $subscriptionId)
                    ->update(['subscription_status' => 2]);
                $institute = DB::table('client')->where('id', $subscriptionId)->first();
                Mail::to($institute->mel)->send(new SubscriptionApprove($institute->name));
                return response()->json(['success' => true, 'message' => 'Subscription fee added successfully']);
            } else {
                return response()->json([
                    'success' => false,
                    'message' => 'Failed to process subscription fee',
                    'api_response' => $responseData
                ]);
            }
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Something went wrong',
                'error' => $e->getMessage()
            ], 500);
        }
    }



    public function underMaintainance()
    {
        return view('subscription.under_maintainance');
    }


}
