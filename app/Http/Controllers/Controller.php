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
            'cities' => DB::table('client')
                ->distinct()
                ->pluck('city')
                ->mapWithKeys(fn ($city) => [$city => $city])
                ->toArray(),
            'schs' => collect(DB::select('SELECT sname, sid FROM sch'))
                ->mapWithKeys(fn ($item) => [$item->sid => $item->sname])
                ->toArray(),
            'states' => DB::table('type')->where('grp', 'state')->get(),
            'syslevels' => DB::table('type')
                ->where('grp', 'syslevel')
                ->distinct()
                ->pluck('prm')
                ->mapWithKeys(fn ($prm) => [$prm => $prm])
                ->toArray(),
            'statuses' => DB::table('type')
                ->where('grp', 'clientstatus')
                ->distinct()
                ->pluck('prm', 'val')
                ->toArray(),
            'areas' => DB::table('type')
                ->where('grp', 'clientcate1')
                ->distinct()
                ->pluck('prm')
                ->mapWithKeys(fn ($prm) => [$prm => $prm])
                ->toArray(),
            'categories' => DB::table('type')
                ->where('grp', 'type_CLIENT')
                ->distinct()
                ->pluck('prm')
                ->mapWithKeys(fn ($prm) => [$prm => $prm])
                ->toArray(),
            'institute_types' => DB::table('type')
                ->where('grp', 'clientcate1')
                ->distinct()
                ->pluck('prm')
                ->mapWithKeys(fn ($prm) => [$prm => $prm])
                ->toArray(),
            'institute_categories' => DB::table('type')
                ->where('grp', 'type_CLIENT')
                ->distinct()
                ->pluck('prm')
                ->mapWithKeys(fn ($prm) => [$prm => $prm])
                ->toArray(),
            // 'districts' => DB::table('type')
            //     ->where('grp', 'district')
            //     ->distinct()
            //     ->pluck('prm')
            //     ->mapWithKeys(fn ($prm) => [$prm => $prm])
            //     ->toArray(),
            // 'sub_districts' => DB::table('type')
            //     ->where('grp', 'sub_district')
            //     ->distinct()
            //     ->pluck('prm')
            //     ->mapWithKeys(fn ($prm) => [$prm => $prm])
            //     ->toArray(),
            'departments' => DB::table('type')
                ->where('grp', 'jobdiv')
                ->distinct()
                ->pluck('prm')
                ->mapWithKeys(fn ($prm) => [$prm => $prm])
                ->toArray(),
            'admin_positions' => DB::table('type')
                ->where('grp', 'job')
                ->distinct()
                ->pluck('prm')
                ->mapWithKeys(fn ($prm) => [$prm => $prm])
                ->toArray(),
            'user_positions' => DB::table('type')
                ->where('grp', 'externalposition')
                ->distinct()
                ->pluck('prm')
                ->mapWithKeys(fn ($prm) => [$prm => $prm])
                ->toArray(),
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


        ];
    }
}
