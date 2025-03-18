<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use App\Models\Parameter;


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

    protected function getCommon()
    {
        return [

            'types' => Parameter::where('grp', 'clientcate1')
                ->pluck('prm', 'code')
                ->toArray(),
            'categories' => Parameter::where('grp', 'type_CLIENT')
                ->pluck('prm', 'code')
                ->toArray(),
            'districts' => Parameter::where('grp', 'district')
                ->pluck('prm', 'code')
                ->toArray(),
            'subdistricts' => Parameter::where('grp', 'subdistrict')
                ->pluck('prm', 'code')
                ->toArray(),
            'cities' => Parameter::where('grp', 'city')
                ->orderBy('prm')
                ->pluck('prm', 'code')
                ->toArray(),
            'user_positions' => Parameter::where('grp', 'user_position')
                ->pluck('prm', 'code')
                ->toArray(),
            'user_statuses' => Parameter::where('grp', 'clientstatus')
                ->pluck('prm', 'val')
                ->toArray(),
            'statements' => Parameter::where('grp', 'statement')
                ->pluck('prm', 'code')
                ->toArray(),
            'audit_types' => Parameter::where('grp', 'audit_type')
                ->pluck('prm', 'code')
                ->toArray(),
            'financial_statement_statuses' => Parameter::where('grp', 'splkstatus')
                ->whereNotIn('val', [0, 1])
                ->pluck('prm', 'val')
                ->toArray(),
            'admin_departments' => Parameter::where('grp', 'jobdiv')
                ->pluck('prm', 'code')
                ->toArray(),
            'admin_positions' => Parameter::where('grp', 'job')
                ->pluck('prm', 'code')
                ->toArray(),
            'admin_groups' => Parameter::where('grp', 'syslevel')
                ->pluck('prm', 'code')
                ->toArray(),
            'statuses' => Parameter::where('grp', 'clientstatus')
                ->pluck('prm', 'val')
                ->toArray(),
            'states' => Parameter::where('grp', 'state')
                ->pluck('prm', 'code')
                ->toArray(),
            
            'countries' => Parameter::where('grp', 'country')
                ->pluck('prm', 'code')
                ->toArray(),


        ];
    }
}
