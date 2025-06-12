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
use Illuminate\Support\Facades\Log;

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
                        ->select(
                            'inv.vid',
                            DB::raw('SUM(inv.val) AS total_invoice'),
                            DB::raw('SUM(CASE WHEN inv.sta = 2 THEN inv.val ELSE 0 END) AS total_received'),
                            DB::raw('SUM(inv.val) - SUM(CASE WHEN inv.sta = 2 THEN inv.val ELSE 0 END) AS outstanding')
                        )
                        ->where('inv.src', 'INV')
                        ->groupBy('inv.vid')
                        ->havingRaw('SUM(inv.val) - SUM(CASE WHEN inv.sta = 2 THEN inv.val ELSE 0 END) > 0') // outstanding > 0
            ,
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
        ->orderBy('c.approvespm_at', 'desc')
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

            // Call the function to create invoice
            $invoiceResponse = $this->createInvoice($user_id, $packageId);

            if ($invoiceResponse['success']) {
                DB::table('client')
                    ->where('id', $subscriptionId)
                    ->update([
                        'subscription_status' => 2,
                        'approvedspm_by' => Auth::user()->uid,
                        'approvespm_at' => now(),
                    ]);

                $institute = DB::table('client')->where('id', $subscriptionId)->first();

                $to = [
                    [
                        'email' => $institute->mel,
                        'name' => $institute->name
                    ]
                ];

                $dynamicTemplateData = [
                    'institute_name' => $institute->name,
                ];

                $templateType = 'mais-subscription-approve';

                $this->sendEmail($to, $dynamicTemplateData, $templateType);
                $this->logActivity('Subscription', 'Subscription Approved. Institute: ' . $institute->name);

                return response()->json([
                    'success' => true,
                    'message' => 'Subscription fee added successfully',
                    'invoice_id' => $invoiceResponse['invoice_id']
                ]);
            } else {
                return response()->json([
                    'success' => false,
                    'message' => 'Failed to create invoice',
                    'error' => $invoiceResponse['message']
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


    private function createInvoice($userId, $packageId)
    {
        try {
            $institute = Institute::where('uid', $userId)->first();
            if (!$institute) {
                return ['success' => false, 'message' => 'Institute not found'];
            }

            $invno_count = DB::table('sch')->where('id', 1)->value('invno');
            $invno = str_pad($invno_count + 1, 6, '0', STR_PAD_LEFT);
            $tid = 'IN-TM-' . $invno;

            $invoiceData = [
                'sid' => 1,
                'sta' => 0,
                'isdelete' => 0,
                'ispaid' => 0,
                'isconfirm' => 0,
                'src' => 'IN',
                'app' => 'EBOSS',
                'ic' => $institute->ic,
                'name' => $institute->name,
                'vid' => $institute->uid,
                'addr' => $institute->addr,
                'addr1' => $institute->addr1,
                'city' => $institute->city,
                'state' => $institute->state,
                'pcode' => $institute->pcode,
                'hp' => $institute->hp,
                'fax' => $institute->fax,
                'mel' => $institute->mel,
                'country' => $institute->country,
                'dt' => now(),
                'year' => now()->year,
                'adm' => Auth::user()->uid,
                'ts' => now(),
                'tid' => $tid,
            ];

            $invoiceCreated = DB::table('fin_invoice')->insert($invoiceData);

            if (!$invoiceCreated) {
                return ['success' => false, 'message' => 'Failed to create invoice'];
            }

            DB::table('sch')->where('id', 1)->update(['invno' => $invno_count + 1]);

            $package = DB::table('fin_coa_item')->where('id', $packageId)->first();
            if (!$package) {
                return ['success' => false, 'message' => 'Package not found'];
            }

            $ledgerData = [
                'code' => $package->code,
                'ccode' => $package->ccode,
                'cate' => $package->cate,
                'type' => $package->type,
                'item' => $package->item,
                'val' => $package->val,
                'total' => $package->val,
                'qtt' => 1,
                'tid' => $tid,
                'vid' => $institute->uid,
                'vname' => $institute->name,
                'src' => 'INV',
                'sta' => 0,
                'app' => 'EBOSS',
                'sid' => 1,
                'year' => now()->year,
                'ts' => now(),
                'adm' => Auth::user()->uid,
                'dt' => now(),
            ];

            $ledgerCreated = DB::table('fin_ledger')->insert($ledgerData);

            if (!$ledgerCreated) {
                return ['success' => false, 'message' => 'Failed to create ledger entry'];
            }

            return [
                'success' => true,
                'message' => 'Invoice created successfully',
                'invoice_id' => $tid
            ];

        } catch (\Exception $e) {
            Log::channel('internal_error')->error('Exception while creating invoice', [
                'user_id' => $userId,
                'package_id' => $packageId,
                'error' => $e->getMessage(),
                'file' => $e->getFile(),
                'line' => $e->getLine(),
            ]);

            return ['success' => false, 'message' => 'Internal server error'];
        }
    }






    public function underMaintainance()
    {
        return view('subscription.under_maintainance');
    }


}
