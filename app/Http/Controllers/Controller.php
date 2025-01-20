<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class Controller extends BaseController
{
    use AuthorizesRequests, ValidatesRequests;

        public function logActivity(string $action, string $description): void
    {
        if (Auth::check()) {
            $user = Auth::user();
            $currentTime = Carbon::now();
            $logData = [
                'sid' => $user->sch_id ?? null,
                'uid' => $user->uid ?? null,
                'lvl' => $user->syslevel ?? null,
                'ip' => Request::ip(),
                'app' => 'emasjid_dashboard',
                'act' => $action,
                'des' => $description,
                'dt' => $currentTime->toDateString(),
                'tm' => $currentTime->format('H:i:s'),
            ];

            DB::table('sys_log')->insert($logData);
        }
    }
}
