<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use MongoDB\Client as MongoClient;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    private const CLIENT_BASE_QUERY = [
        'app' => 'CLIENT',
        'isdel' => 0
    ];

    // Generic database query method to reduce redundancy
    private function executeQuery($table, $constraints = [], $aggregation = null, $groupBy = null)
    {
        $query = DB::table($table);
        
        foreach ($constraints as $field => $value) {
            $query->where($field, $value);
        }
        
        if ($aggregation) {
            $query->select(DB::raw($aggregation));
        }
        
        if ($groupBy) {
            $query->groupBy($groupBy);
        }
        
        return $query;
    }

    private function getBaseClientQuery($city = null)
    {
        $constraints = self::CLIENT_BASE_QUERY;
        if ($city) {
            $constraints['city'] = $city;
        }
        return $constraints;
    }

    private function _getTotalMosques($city = null)
    {
        return $this->executeQuery('client', $this->getBaseClientQuery($city))->count();
    }

    private function _getTotalKariah($city = null)
    {
        if ($city) {
            return DB::table('report_kariah AS k')
                ->rightJoin(DB::raw('(SELECT uid, city FROM report_masjid) AS m'), 'k.uid', '=', 'm.uid')
                ->where('m.city', $city)
                ->sum('k.kariah_bil');
        }
        return DB::table('report_kariah')->sum('kariah_bil');
    }

    private function _getTotalStaff($city = null)
    {
        $constraints = $city ? ['city' => $city] : [];
        return $this->executeQuery('report_masjid', $constraints)->sum('staff_bil');
    }

    private function getDemographicData($table, $columns, $city = null)
    {
        $baseQuery = $city 
            ? DB::table($table . ' AS k')
                ->rightJoin(DB::raw('(SELECT uid, city FROM report_masjid) AS m'), 'k.uid', '=', 'm.uid')
                ->where('m.city', $city)
            : DB::table($table);

        return $baseQuery->select(DB::raw($columns))->first();
    }

    private function _getKariahMaleFemale($city = null)
    {
        $columns = 'SUM(kariah_male) AS total_male, SUM(kariah_female) AS total_female';
        $result = $this->getDemographicData('report_kariah', $columns, $city);
        
        return [
            'total_male' => $result->total_male ?? 0,
            'total_female' => $result->total_female ?? 0,
        ];
    }

    private function _getTotalKariahPerDistrict()
    {
        return DB::table('report_kariah AS k')
            ->rightJoin(DB::raw('(SELECT uid, city FROM report_masjid) AS m'), 'k.uid', '=', 'm.uid')
            ->select('m.city', DB::raw('SUM(k.kariah_bil) AS total_kariah'))
            ->groupBy('m.city')
            ->get();
    }

    private function _getTotalMosquePerCategory()
    {
        return DB::table('client as a')
            ->rightJoin('type as b', 'a.cate', '=', 'b.prm')
            ->where('b.grp', '=', 'type_CLIENT')
            ->select('b.prm', DB::raw('count(a.id) as total'))
            ->groupBy('b.prm')
            ->get();
    }

    private function _getKariahPerType($city = null)
    {
        $columns = '
            SUM(kariah_cat_1) AS warga_emas,
            SUM(kariah_cat_2) AS ibu_tunggal,
            SUM(kariah_cat_3) AS oku,
            SUM(kariah_cat_4) AS fakir_miskin,
            SUM(kariah_cat_5) AS penerima_zakat,
            SUM(kariah_cat_6) AS pprt,
            SUM(kariah_cat_7) AS penerima_jkm,
            SUM(kariah_cat_8) AS pelajar,
            SUM(kariah_cat_9) AS pengangur,
            SUM(kariah_cat_10) AS bantuan_masjid
        ';
        return $this->getDemographicData('report_kariah', $columns, $city);
    }

    private function _getKariahPerAgeRange($city = null)
    {
        $columns = '
            SUM(kariah_age_1) AS range1_15,
            SUM(kariah_age_2) AS range15_30,
            SUM(kariah_age_3) AS range31_45,
            SUM(kariah_age_4) AS range46_60,
            SUM(kariah_age_5) AS range61_75,
            SUM(kariah_age_6) AS range75_plus
        ';
        return $this->getDemographicData('report_kariah', $columns, $city);
    }

    private function _getKariahNationality($city = null)
    {
        $columns = '
            SUM(kariah_race_my) AS Malay,
            SUM(kariah_race_ind) AS Indo,
            SUM(kariah_race_ch) AS Chinese,
            SUM(kariah_race_oth) AS others
        ';
        $result = $this->getDemographicData('report_kariah', $columns, $city);
        
        return [
            'Malay' => $result->Malay ?? 0,
            'Indo' => $result->Indo ?? 0,
            'Chinese' => $result->Chinese ?? 0,
            'Others' => $result->others ?? 0
        ];
    }

    private function _getDistrictTable()
    {
        $categories = ['MASJID UTAMA', 'SURAU', 'MASJID DAERAH', 'MASJID KARIAH', 
                      'SURAU JUMAAT', 'MASJID JAMEK', 'MASJID PENGURUSAN', 'MASJID'];
        
        $selects = ['c.city'];
        
        foreach ($categories as $category) {
            $selects[] = DB::raw("(SELECT COUNT(*) FROM client WHERE cate = '$category' AND city = c.city AND app = 'CLIENT' AND isdel = 0) AS " . str_replace(' ', '_', $category));
        }
        
        $selects = array_merge($selects, [
            DB::raw("(SELECT COUNT(*) FROM client WHERE sta = 1 AND city = c.city AND app = 'CLIENT' AND isdel = 0) AS Total_Active"),
            DB::raw("(SELECT COUNT(*) FROM client WHERE sta = 0 AND city = c.city AND app = 'CLIENT' AND isdel = 0) AS Total_Inactive"),
            DB::raw("(SELECT COUNT(*) FROM client WHERE cate IN (SELECT prm FROM `type` WHERE grp='type_CLIENT') AND city = c.city AND app = 'CLIENT' AND isdel = 0) AS Total")
        ]);

        return DB::table('client AS c')
            ->select($selects)
            ->where(self::CLIENT_BASE_QUERY)
            ->groupBy('c.city')
            ->get();
    }

    // Generic listing method to handle mosque, branch, and admin listings
    private function getListingData($table, Request $request, $additionalFilters = [])
    {
        $query = DB::table($table);
        
        if ($request->filled('search')) {
            $query->where('name', 'like', '%' . $request->input('search') . '%');
        }
        
        foreach ($additionalFilters as $filter => $field) {
            if ($request->filled($filter)) {
                $query->where($field, $request->input($filter));
            }
        }
        
        return $query->paginate($request->get('recordsPerPage', 25));
    }

    public function mosquesInCityDetails(Request $request)
    {
        $city = $request['city'];
        
        $data = [
            'totalMosques' => $this->_getTotalMosques($city),
            'totalKariah' => $this->_getTotalKariah($city),
            'totalStaff' => $this->_getTotalStaff($city),
            'totalKariah_MaleFemale' => $this->_getKariahMaleFemale($city),
            'totalKariahPerDistrict' => $this->_getTotalKariahPerDistrict(),
            'kariahPerType' => $this->_getKariahPerType($city),
            'kariahPerAgeRange' => $this->_getKariahPerAgeRange($city),
            'kariahNationality' => $this->_getKariahNationality(),
            'mosqueData' => $this->_getTotalMosquePerCategory()->mapWithKeys(fn($item) => [$item->prm => $item->total]),
            'mosqueActiveInactive' => $this->_getMosqueActiveInactive($city),
            'city' => $city,
            'kariahPerMosqueType' => $this->_getKariahPerMosquesType($city)
        ];

        return view('base.mosques_in_city_details', $data);
    }

    private function _getMosqueActiveInactive($city)
    {
        $result = DB::table('client AS c')
            ->select(
                DB::raw("SUM(CASE WHEN c.sta = 1 THEN 1 ELSE 0 END) AS Total_Active"),
                DB::raw("SUM(CASE WHEN c.sta = 0 THEN 1 ELSE 0 END) AS Total_Inactive")
            )
            ->where('c.app', 'CLIENT')
            ->where('c.isdel', 0)
            ->where('c.city', $city)
            ->first();

        return [
            'Active' => $result->Total_Active ?? 0,
            'Inactive' => $result->Total_Inactive ?? 0,
        ];
    }
    private function _getKariahPerMosquesType($city)
    {
        $result = DB::table('client AS c')
            ->select(
                DB::raw("SUM(CASE WHEN c.cate = 'MASJID UTAMA' THEN 1 ELSE 0 END) AS MASJID_UTAMA"),
                DB::raw("SUM(CASE WHEN c.cate = 'SURAU' THEN 1 ELSE 0 END) AS SURAU"),
                DB::raw("SUM(CASE WHEN c.cate = 'MASJID DAERAH' THEN 1 ELSE 0 END) AS MASJID_DAERAH"),
                DB::raw("SUM(CASE WHEN c.cate = 'MASJID KARIAH' THEN 1 ELSE 0 END) AS MASJID_KARIAH"),
                DB::raw("SUM(CASE WHEN c.cate = 'SURAU JUMAAT' THEN 1 ELSE 0 END) AS SURAU_JUMAAT"),
                DB::raw("SUM(CASE WHEN c.cate = 'MASJID JAMEK' THEN 1 ELSE 0 END) AS MASJID_JAMEK"),
                DB::raw("SUM(CASE WHEN c.cate = 'MASJID PENGURUSAN' THEN 1 ELSE 0 END) AS MASJID_PENGURUSAN"),
                DB::raw("SUM(CASE WHEN c.cate = 'MASJID' THEN 1 ELSE 0 END) AS MASJID")
            )
            ->where('c.app', 'CLIENT')
            ->where('c.isdel', 0)
            ->where('c.city', $city)
            ->groupBy('c.city')
            ->first();
                
        return [
            'Masjid Utama' => $result->MASJID_UTAMA ?? 0,
            'Surau' => $result->SURAU ?? 0,
            'Masjid Daerah' => $result->MASJID_DAERAH ?? 0,
            'Masjid Kariah' => $result->MASJID_KARIAH ?? 0,
            'Surau Jumaat' => $result->SURAU_JUMAAT ?? 0,
            'Masjid Jamek' => $result->MASJID_JAMEK ?? 0,
            'Masjid Pengurusan' => $result->MASJID_PENGURUSAN ?? 0,
            'Masjid' => $result->MASJID ?? 0,
        ];
    }

    // Controller methods for web routes
    public function dashboard()
    {
        $data = [
            'totalMosques' => $this->_getTotalMosques(),
            'totalKariah' => $this->_getTotalKariah(),
            'totalStaff' => $this->_getTotalStaff(),
            'totalKariah_MaleFemale' => $this->_getKariahMaleFemale(),
            'totalKariahPerDistrict' => $this->_getTotalKariahPerDistrict(),
            'kariahPerType' => $this->_getKariahPerType(),
            'kariahPerAgeRange' => $this->_getKariahPerAgeRange(),
            'kariahNationality' => $this->_getKariahNationality(),
            'districtTable' => $this->_getDistrictTable(),
            'mosqueData' => $this->_getTotalMosquePerCategory()->mapWithKeys(fn($item) => [$item->prm => $item->total])
        ];

        return view('base.index', $data);
    }
        // Controller methods for web routes
    public function index()
    {
        // $data = [
        //     'totalMosques' => $this->_getTotalMosques(),
        //     'totalKariah' => $this->_getTotalKariah(),
        //     'totalStaff' => $this->_getTotalStaff(),
        //     'totalKariah_MaleFemale' => $this->_getKariahMaleFemale(),
        //     'totalKariahPerDistrict' => $this->_getTotalKariahPerDistrict(),
        //     'kariahPerType' => $this->_getKariahPerType(),
        //     'kariahPerAgeRange' => $this->_getKariahPerAgeRange(),
        //     'kariahNationality' => $this->_getKariahNationality(),
        //     'districtTable' => $this->_getDistrictTable(),
        //     'mosqueData' => $this->_getTotalMosquePerCategory()->mapWithKeys(fn($item) => [$item->prm => $item->total])
        // ];

        return view('base.dashboard');
    }



}