<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;


class SubscriptionController extends Controller
{


    public function activeSubscriptions() 
    {
        $subscriptions = DB::table('client')
            ->where('isActivated', 1)
            ->paginate(10);

        $statuses = DB::table('type')->where('grp', 'clientstatus')->get();


        return view('subscription.active_subscription', compact(['subscriptions', 'statuses']));
    }

    public function requestSubscriptions()
    {
        $subscriptions = DB::table('client')
            ->where('opt1', 1)
            ->paginate(10);
        
        return view('subscription.new_subscription_application', compact('subscriptions'));
    }



}
