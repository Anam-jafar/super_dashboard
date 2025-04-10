<?php

namespace App\Services;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Models\Parameter;

class DistrictAccessService
{
    // Fetch district access for the logged-in user
    public function getDistrictAccess()
    {
        if (Auth::check()) {
            return DB::table('usr')
                ->where('id', Auth::id())
                ->value('joblvl');
        }

        return null;
    }

    // Fetch district parameters based on the user's district access
    public function fetchDistrictParameters(): array
    {
        $districtAccess = $this->getDistrictAccess();

        if ($districtAccess) {
            return [
                'districts' => Parameter::where('grp', 'district')
                    ->where('code', $districtAccess)
                    ->pluck('prm', 'code')
                    ->toArray(),
                'subdistricts' => Parameter::where('grp', 'subdistrict')
                    ->where('etc', $districtAccess)
                    ->pluck('prm', 'code')
                    ->toArray(),
            ];
        }

        return [];
    }
}
