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

    public function requestSubscriptions()
    {
        $subscriptions = DB::table('client')
            ->where('subscription_status', 1) 
            ->paginate(10);

        $statuses = DB::table('type')->where('grp', 'clientstatus')->get();

        
        return view('subscription.new_subscription_application', compact(['subscriptions', 'statuses']));
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
