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
        
        // Query builder for subscriptions
        $query = DB::table('client')->where('subscription_status', 1);

        // Apply search filter (searching by name)
        if ($request->filled('search')) {
            $query->where('name', 'like', '%' . $request->search . '%');
        }

        // Apply institute type filter
        if ($request->filled('institute_type')) {
            $query->where('cate', $request->institute_type);
        }

        // Apply area filter
        if ($request->filled('area')) {
            $query->where('cate1', $request->area);
        }

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

        $instituteType = DB::table('type')
            ->where('grp', 'type_CLIENT')
            ->pluck('prm')
            ->mapWithKeys(fn ($prm) => [$prm => $prm])
            ->toArray();

        return view('subscription.new_subscription_application', compact(['subscriptions', 'statuses', 'daerah', 'instituteType']));
    }


    public function outstandingSubscriptions()
    {
        $subscriptions = DB::table('client')
            ->where('subscription_status', 0) 
            ->paginate(10);

        $statuses = DB::table('type')->where('grp', 'clientstatus')->get();

        
        return view('subscription.outstanding_list', compact(['subscriptions', 'statuses']));
    }



}
