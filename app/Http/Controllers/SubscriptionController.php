<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Institute;
use Illuminate\Support\Facades\Auth;
use App\Models\Parameter;

class SubscriptionController extends Controller
{

    private function applyFilters($query, Request $request)
    {
        foreach ($request->all() as $field => $value) {
            // Use isset() instead of !empty() to allow filtering when value is 0
            if (isset($value) && \Schema::hasColumn('client', $field)) {
                $query->where($field, $value);
            }
        }

        if ($request->filled('search')) {
            $searchTerm = $request->input('search');
            $query->where('name', 'like', "%{$searchTerm}%");
        }

        return $query;
    }


    public function activeSubscriptions(Request $request)
    {
                
        $districtAccess = DB::table('usr')->where('mel', Auth::user()->mel)->value('joblvl');

        $per_page = $request->per_page ?? 10;

        $query = Institute::query()
            ->where('subscription_status', 3)
            ->orderBy('id', 'desc');

        if ($districtAccess != null) {
            $query->where('rem8', $districtAccess);
        }

        $query = $this->applyFilters($query, $request);

        $subscriptions = $query->paginate($per_page)->withQueryString();

        $subscriptions->getCollection()->transform(function ($subscription) {
            $subscription->NAME = isset($subscription->name) ? strtoupper($subscription->name) : null;
            $subscription->TYPE = isset($subscription->Type->prm) ? strtoupper($subscription->Type->prm) : null;
            $subscription->DISTRICT = isset($subscription->District->prm) ? strtoupper($subscription->District->prm) : null;
            $subscription->SUBDISTRICT = isset($subscription->Subdistrict->prm) ? strtoupper($subscription->Subdistrict->prm) : null;
            $subscription->CATEGORY = isset($subscription->Category->prm) ? strtoupper($subscription->Category->prm) : null;
            $subscription->SUBSCRIPTION_DATE = date('d-m-Y',$subscription->subscription_request_date);
            $subscription->SUBSCRIPTION_STATUS = Parameter::where('grp', 'subscriptionstatus')
                ->where('val', $subscription->subscription_status)
                ->pluck('prm', 'val')
                ->map(fn($prm, $val) => ['val' => $val, 'prm' => $prm])
                ->first();

            return $subscription;
        });

        $statuses = DB::table('type')->where('grp', 'clientstatus')->get();

        $packages = DB::table('fin_coa_item')
            ->where('type', 'sales')
            ->pluck('val', 'id') // Swap id and val correctly
            ->toArray();
        
        $parameters = $this->getCommon();

        if($districtAccess != null){
            $parameters['districts'] = Parameter::where('grp', 'district')
                ->where('code', $districtAccess)
                ->pluck('prm', 'code')
                ->toArray();
            $parameters['subdistricts'] = Parameter::where('grp', 'subdistrict')
                ->where('etc', $districtAccess)
                ->pluck('prm', 'code')
                ->toArray();
        }

        if ($request->filled('cate1')) {
            $parameters['categories'] = Parameter::where('grp', 'type_CLIENT')
                ->where('etc', $request->cate1)
                ->pluck('prm', 'code')
                ->toArray();
        }

        if ($request->filled('rem8')) {
            $parameters['subdistricts'] = Parameter::where('grp', 'subdistrict')
                ->where('etc', $request->rem8)
                ->pluck('prm', 'code')
                ->toArray();
        }

        return view('subscription.active_subscription', compact(['subscriptions', 'parameters', 'statuses', 'packages']));
    }

    public function requestSubscriptions_(Request $request)
    {
        $per_page = $request->per_page ?? 10;

        // Query builder for subscriptions with joinSub
        $query = DB::table('client')
            ->where('subscription_status', 1);

        // Apply search filter (searching by name)
        if ($request->filled('search')) {
            $query->where('name', 'like', '%' . $request->search . '%');
        }

        $subscriptions = $query->paginate($per_page)->withQueryString();

        $statuses = DB::table('type')->where('grp', 'clientstatus')->get();


            

        $packages = DB::table('fin_coa_item')
            ->where('type', 'sales')
            ->pluck('val', 'id') // Swap id and val correctly
            ->toArray();

        return view('subscription.new_subscription_application', compact(['subscriptions', 'statuses', 'daerah', 'instituteType', 'packages']));
    }

    public function requestSubscriptions(Request $request)
    {
                
        $districtAccess = DB::table('usr')->where('mel', Auth::user()->mel)->value('joblvl');

        $per_page = $request->per_page ?? 10;

        $query = Institute::query()
            ->where('subscription_status', 1)
            ->orderBy('id', 'desc');

        if ($districtAccess != null) {
            $query->where('rem8', $districtAccess);
        }

        $query = $this->applyFilters($query, $request);

        $subscriptions = $query->paginate($per_page)->withQueryString();

        $subscriptions->getCollection()->transform(function ($subscription) {
            $subscription->NAME = isset($subscription->name) ? strtoupper($subscription->name) : null;
            $subscription->TYPE = isset($subscription->Type->prm) ? strtoupper($subscription->Type->prm) : null;
            $subscription->DISTRICT = isset($subscription->District->prm) ? strtoupper($subscription->District->prm) : null;
            $subscription->SUBDISTRICT = isset($subscription->Subdistrict->prm) ? strtoupper($subscription->Subdistrict->prm) : null;
            $subscription->CATEGORY = isset($subscription->Category->prm) ? strtoupper($subscription->Category->prm) : null;
            $subscription->SUBSCRIPTION_DATE = date('d-m-Y',$subscription->subscription_request_date);
            $subscription->SUBSCRIPTION_STATUS = Parameter::where('grp', 'subscriptionstatus')
                ->where('val', $subscription->subscription_status)
                ->pluck('prm', 'val')
                ->map(fn($prm, $val) => ['val' => $val, 'prm' => $prm])
                ->first();

            $latestSubmission = DB::table('splk_submission')
                ->where('inst_refno', $subscription->uid)
                ->where('fin_category', 'STM02')
                ->orderByDesc('fin_year')
                ->limit(1)
                ->first(['total_income', 'fin_year']);

            $subscription->COLLECTION = [
                'TOTAL_COLLECTION' => $latestSubmission->total_income ?? null,
                'FIN_YEAR' => $latestSubmission->fin_year ?? null,
            ];

            return $subscription;
        });

        $statuses = DB::table('type')->where('grp', 'clientstatus')->get();

        $packages = DB::table('fin_coa_item')
            ->where('type', 'sales')
            ->pluck('val', 'id') // Swap id and val correctly
            ->toArray();
        
        $parameters = $this->getCommon();

        if($districtAccess != null){
            $parameters['districts'] = Parameter::where('grp', 'district')
                ->where('code', $districtAccess)
                ->pluck('prm', 'code')
                ->toArray();
            $parameters['subdistricts'] = Parameter::where('grp', 'subdistrict')
                ->where('etc', $districtAccess)
                ->pluck('prm', 'code')
                ->toArray();
        }

        if ($request->filled('cate1')) {
            $parameters['categories'] = Parameter::where('grp', 'type_CLIENT')
                ->where('etc', $request->cate1)
                ->pluck('prm', 'code')
                ->toArray();
        }

        if ($request->filled('rem8')) {
            $parameters['subdistricts'] = Parameter::where('grp', 'subdistrict')
                ->where('etc', $request->rem8)
                ->pluck('prm', 'code')
                ->toArray();
        }

        return view('subscription.new_subscription_application', compact(['subscriptions', 'parameters', 'statuses', 'packages']));
    }


public function outstandingSubscriptions_(Request $request)
{
    $districtAccess = DB::table('usr')->where('mel', Auth::user()->mel)->value('joblvl');
    $per_page = $request->per_page ?? 10;

    // Start with a base query for financial data
    $financialData = DB::table('fin_ledger as inv')
        ->leftJoin('fin_ledger as rec', function ($join) {
            $join->on('inv.vid', '=', 'rec.vid')
                ->on('inv.tid', '=', 'rec.ref')
                ->where('rec.src', 'REC');
        })
        ->where('inv.src', 'INV')
        ->groupBy('inv.vid')
        ->selectRaw('inv.vid, SUM(inv.val) AS total_invoice, COALESCE(SUM(rec.val), 0) AS total_received, SUM(inv.val) - COALESCE(SUM(rec.val), 0) AS outstanding');

    // Start with a base query for institutes
    $query = Institute::query();
    
    // Join with the financial data
    $query->leftJoinSub($financialData, 'finance', function($join) {
        $join->on('client.uid', '=', 'finance.vid');
    });
    
    // Apply district filter if user has district access restriction
    if ($districtAccess != null) {
        $query->where('institutes.rem8', $districtAccess);
    }
    
    // Apply additional filters
    $query = $this->applyFilters($query, $request);
    
    // Select needed fields including the financial data
    $query->select([
        'client.*',
        'finance.total_invoice',
        'finance.total_received',
        'finance.outstanding'
    ]);

    // Paginate results
    $subscriptions = $query->paginate($per_page)->withQueryString();
    
    // Transform the collection to format and uppercase data
    $subscriptions->getCollection()->transform(function ($subscription) {
        $subscription->NAME = isset($subscription->name) ? strtoupper($subscription->name) : null;
        $subscription->TYPE = isset($subscription->Type->prm) ? strtoupper($subscription->Type->prm) : null;
        $subscription->DISTRICT = isset($subscription->District->prm) ? strtoupper($subscription->District->prm) : null;
        $subscription->SUBDISTRICT = isset($subscription->Subdistrict->prm) ? strtoupper($subscription->Subdistrict->prm) : null;
        $subscription->CATEGORY = isset($subscription->Category->prm) ? strtoupper($subscription->Category->prm) : null;
        $subscription->SUBSCRIPTION_DATE = isset($subscription->subscription_request_date) ? 
            date('d-m-Y', $subscription->subscription_request_date) : null;
        
        // Set financial values with uppercase keys
        $subscription->TOTAL_INVOICE = $subscription->total_invoice ?? 0;
        $subscription->TOTAL_RECEIVED = $subscription->total_received ?? 0;
        $subscription->TOTAL_OUTSTANDING = $subscription->outstanding ?? 0;
        
        return $subscription;
    });

    // Get parameters for filtering
    $statuses = DB::table('type')->where('grp', 'clientstatus')->get();
    
    $packages = DB::table('fin_coa_item')
        ->where('type', 'sales')
        ->pluck('val', 'id')
        ->toArray();
    
    $parameters = $this->getCommon();
    
    // Adjust parameters based on district access
    if ($districtAccess != null) {
        $parameters['districts'] = Parameter::where('grp', 'district')
            ->where('code', $districtAccess)
            ->pluck('prm', 'code')
            ->toArray();
        $parameters['subdistricts'] = Parameter::where('grp', 'subdistrict')
            ->where('etc', $districtAccess)
            ->pluck('prm', 'code')
            ->toArray();
    }
    
    // Apply additional parameter filters
    if ($request->filled('cate1')) {
        $parameters['categories'] = Parameter::where('grp', 'type_CLIENT')
            ->where('etc', $request->cate1)
            ->pluck('prm', 'code')
            ->toArray();
    }
    
    if ($request->filled('rem8')) {
        $parameters['subdistricts'] = Parameter::where('grp', 'subdistrict')
            ->where('etc', $request->rem8)
            ->pluck('prm', 'code')
            ->toArray();
    }
    
    return view('subscription.outstanding_list', compact(['subscriptions', 'parameters', 'statuses', 'packages']));
}

public function outstandingSubscriptions(Request $request)
{
    $districtAccess = DB::table('usr')->where('mel', Auth::user()->mel)->value('joblvl');
    $per_page = $request->per_page ?? 10;

    $query = DB::table('client as c');
    
    // Apply district access restriction
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
                DB::raw('COALESCE(SUM(rec.val), 0) AS total_received'),
                DB::raw('SUM(inv.val) - COALESCE(SUM(rec.val), 0) AS outstanding')
            )
            ->leftJoin('fin_ledger as rec', function ($join) {
                $join->on('inv.vid', '=', 'rec.vid')
                    ->on('inv.tid', '=', 'rec.ref')
                    ->where('rec.src', 'REC');
            })
            ->where('inv.src', 'INV')
            ->groupBy('inv.vid')
            ->having(DB::raw('SUM(inv.val) - COALESCE(SUM(rec.val), 0)'), '>', 0), // Ensure outstanding > 0
        'subquery',
        'c.uid',
        '=',
        'subquery.vid'
    )
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
    
    // Adjust parameters based on district access
    if ($districtAccess != null) {
        $parameters['districts'] = Parameter::where('grp', 'district')
            ->where('code', $districtAccess)
            ->pluck('prm', 'code')
            ->toArray();
        $parameters['subdistricts'] = Parameter::where('grp', 'subdistrict')
            ->where('etc', $districtAccess)
            ->pluck('prm', 'code')
            ->toArray();
    }
    
    // Apply additional parameter filters
    if ($request->filled('cate1')) {
        $parameters['categories'] = Parameter::where('grp', 'type_CLIENT')
            ->where('etc', $request->cate1)
            ->pluck('prm', 'code')
            ->toArray();
    }
    
    if ($request->filled('rem8')) {
        $parameters['subdistricts'] = Parameter::where('grp', 'subdistrict')
            ->where('etc', $request->rem8)
            ->pluck('prm', 'code')
            ->toArray();
    }

    return view('subscription.outstanding_list', compact(['subscriptions', 'parameters']));
}



    public function subscriptionFeeAdd(Request $request)
    {
        $subscriptionId = $request->input('subscriptionId');
        $packageId = $request->input('packageId');

        DB::table('client')
            ->where('id', $subscriptionId)
            ->update(['subscription_status' => 2]);

        // Process the subscription fee addition here
        // You might want to update the subscription record or create a new record for the fee

        return response()->json(['success' => true, 'message' => 'Subscription fee added successfully']);
    }

    public function underMaintainance()
    {
        return view('subscription.under_maintainance');
    }


}
