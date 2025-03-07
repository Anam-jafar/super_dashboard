<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;


class SubscriptionController extends Controller
{


    public function activeSubscriptions() 
    {
        $subscriptions = DB::table('client')
            ->whereNotIn('subscription_status', [0, 1]) // Exclude 0 and 1
            ->paginate(10);


        $statuses = DB::table('type')->where('grp', 'clientstatus')->get();


        return view('subscription.active_subscription', compact(['subscriptions', 'statuses']));
    }

    public function requestSubscriptions(Request $request)
    {
        $per_page = $request->per_page ?? 10;

        // Query builder for subscriptions with joinSub
        $query = DB::table('client as y')
            ->joinSub(
                DB::table('type')
                    ->select('prm', 'etc')
                    ->where('grp', 'type_CLIENT'),
                'x',
                'x.prm',
                '=',
                'y.cate'
            )
            ->where('y.subscription_status', 1);

        // Apply search filter (searching by name)
        if ($request->filled('search')) {
            $query->where('y.name', 'like', '%' . $request->search . '%');
        }

        // Apply institute type filter
        if ($request->filled('institute_type')) {
            $query->where('x.etc', $request->institute_type);
        }

        // Apply area filter
        if ($request->filled('area')) {
            $query->where('y.cate1', $request->area);
        }

        // Select necessary columns
        // $query->select('y.*', 'x.prm', 'x.etc');

        // Paginate results
        $subscriptions = $query->paginate($per_page)->withQueryString();


        // Fetch dropdown data
        $statuses = DB::table('type')->where('grp', 'clientstatus')->get();
        
        $daerah = DB::table('type')
            ->where('grp', 'clientcate1')
            ->distinct()
            ->pluck('prm')
            ->mapWithKeys(fn ($prm) => [$prm => $prm])
            ->toArray();

        // $instituteType = DB::table('type')
        //     ->where('grp', 'type_CLIENT')
        //     ->pluck('prm')
        //     ->mapWithKeys(fn ($prm) => [$prm => $prm])
        //     ->toArray();
        $instituteType = DB::table('type')
            ->where('grp', 'type_CLIENT')
            ->groupBy('etc')
            ->pluck('etc')
            ->mapWithKeys(fn ($etc) => [$etc => $etc])
            ->toArray();

            

        $packages = DB::table('fin_coa_item')
            ->where('type', 'sales')
            ->pluck('val', 'id') // Swap id and val correctly
            ->toArray();

        return view('subscription.new_subscription_application', compact(['subscriptions', 'statuses', 'daerah', 'instituteType', 'packages']));
    }


    public function outstandingSubscriptions(Request $request)
    {
        $per_page = $request->per_page ?? 10;

        // Query builder for subscriptions with joinSub
        $query = DB::table('client as y')
            ->joinSub(
                DB::table('type')
                    ->select('prm', 'etc')
                    ->where('grp', 'type_CLIENT'),
                'x',
                'x.prm',
                '=',
                'y.cate'
            )
            ->where('y.subscription_status', 2);

        // Apply search filter (searching by name)
        if ($request->filled('search')) {
            $query->where('y.name', 'like', '%' . $request->search . '%');
        }

        // Apply institute type filter
        if ($request->filled('institute_type')) {
            $query->where('x.etc', $request->institute_type);
        }

        // Apply area filter
        if ($request->filled('area')) {
            $query->where('y.cate1', $request->area);
        }

        // Select necessary columns
        // $query->select('y.*', 'x.prm', 'x.etc');

        // Paginate results
        $subscriptions = $query->paginate($per_page)->withQueryString();

        $statuses = DB::table('type')->where('grp', 'clientstatus')->get();
                // Fetch dropdown data
        
        $daerah = DB::table('type')
            ->where('grp', 'clientcate1')
            ->distinct()
            ->pluck('prm')
            ->mapWithKeys(fn ($prm) => [$prm => $prm])
            ->toArray();

        // $instituteType = DB::table('type')
        //     ->where('grp', 'type_CLIENT')
        //     ->pluck('prm')
        //     ->mapWithKeys(fn ($prm) => [$prm => $prm])
        //     ->toArray();
        $instituteType = DB::table('type')
            ->where('grp', 'type_CLIENT')
            ->groupBy('etc')
            ->pluck('etc')
            ->mapWithKeys(fn ($etc) => [$etc => $etc])
            ->toArray();

        
        return view('subscription.outstanding_list', compact(['subscriptions', 'statuses', 'daerah', 'instituteType']));
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
