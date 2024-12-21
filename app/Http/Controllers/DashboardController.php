<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use MongoDB\Client as MongoClient;
use App\Reports\DashboardReport;
use Illuminate\Support\Facades\DB;



class DashboardController extends Controller
{
    
    private function _getTotalMosques($city = NULL){
        if($city != NULL){
            $totalMosques = DB::table('client')
            ->where('app', 'CLIENT')
            ->where('isdel', 0)
            ->where('city',$city)
            ->count();
        }else{
            $totalMosques = DB::table('client')
            ->where('app', 'CLIENT')
            ->where('isdel', 0)
            ->count();
        }

        return $totalMosques;
    }

    private function _getTotalKariah($city = NULL){
        if($city != NULL){
            $totalKariah = DB::table('report_kariah AS k')
                ->rightJoin(DB::raw('(SELECT uid, city FROM report_masjid) AS m'), 'k.uid', '=', 'm.uid')
                ->where('m.city', $city)
                ->sum('k.kariah_bil');
            return $totalKariah;
        } else {
            $totalKariah = DB::table('report_kariah')
                ->sum('kariah_bil');
            return $totalKariah;
        }
    }
    


    private function _getTotalStaff($city = NULL){
        if($city != NULL){
            $totalStaff = DB::table('report_masjid')
            ->where('city', $city)
            ->sum('staff_bil');
        }else{
            $totalStaff = DB::table('report_masjid')
            ->sum('staff_bil');
        }
        return $totalStaff;
    }

    private function _getKariahMaleFemale($city = NULL)
    {
        if ($city != NULL) {
            $result = DB::table('report_kariah AS k')
                ->rightJoin(DB::raw('(SELECT uid, city FROM report_masjid) AS m'), 'k.uid', '=', 'm.uid')
                ->select(DB::raw('SUM(k.kariah_male) AS total_male, SUM(k.kariah_female) AS total_female'))
                ->where('m.city', $city)
                ->first();
        } else {
            $result = DB::table('report_kariah')
                ->select(DB::raw('SUM(kariah_male) AS total_male, SUM(kariah_female) AS total_female'))
                ->first();
        }
    
        return [
            'total_male' => $result->total_male ?? 0,
            'total_female' => $result->total_female ?? 0,
        ];
    }
    

    private function _getTotalKariahPerDistrict()
    {
        $result = DB::table('report_kariah AS k')
            ->rightJoin(DB::raw('(SELECT uid, city FROM report_masjid) AS m'), 'k.uid', '=', 'm.uid')
            ->select('m.city', DB::raw('SUM(k.kariah_bil) AS total_kariah'))
            ->groupBy('m.city')
            ->get();

        return $result;
    }

    private function _getKariahPerType($city = NULL)
    {
        if ($city) {
            $result = DB::table('report_kariah AS k')
                ->rightJoin(DB::raw('(SELECT uid, city FROM report_masjid) AS m'), 'k.uid', '=', 'm.uid')
                ->select(DB::raw('
                    SUM(k.kariah_cat_1) AS warga_emas,
                    SUM(k.kariah_cat_2) AS ibu_tunggal,
                    SUM(k.kariah_cat_3) AS oku,
                    SUM(k.kariah_cat_4) AS fakir_miskin,
                    SUM(k.kariah_cat_5) AS penerima_zakat,
                    SUM(k.kariah_cat_6) AS pprt,
                    SUM(k.kariah_cat_7) AS penerima_jkm,
                    SUM(k.kariah_cat_8) AS pelajar,
                    SUM(k.kariah_cat_9) AS pengangur,
                    SUM(k.kariah_cat_10) AS bantuan_masjid
                '))
                ->where('m.city', $city)
                ->first();
        } else {
            $result = DB::table('report_kariah')
                ->select(DB::raw('
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
                '))
                ->first();
        }
    
        return $result;
    }
    
    private function _getKariahPerAgeRange($city = NULL)
    {
        if ($city) {
            $result = DB::table('report_kariah AS k')
                ->rightJoin(DB::raw('(SELECT uid, city FROM report_masjid) AS m'), 'k.uid', '=', 'm.uid')
                ->select(DB::raw('
                    SUM(kariah_age_1) AS range1_15,
                    SUM(kariah_age_2) AS range15_30,
                    SUM(kariah_age_3) AS range31_45,
                    SUM(kariah_age_4) AS range46_60,
                    SUM(kariah_age_5) AS range61_75,
                    SUM(kariah_age_6) AS range75_plus'
                ))
                ->where('m.city', $city)
                ->first();
        } else {
            $result = DB::table('report_kariah')
                ->select(DB::raw('
                    SUM(kariah_age_1) AS range1_15,
                    SUM(kariah_age_2) AS range15_30,
                    SUM(kariah_age_3) AS range31_45,
                    SUM(kariah_age_4) AS range46_60,
                    SUM(kariah_age_5) AS range61_75,
                    SUM(kariah_age_6) AS range75_plus'
                ))
                ->first();
        }
    
        return $result;
    }

        
    private function _getKariahNationality($city = NULL)
    {
        if ($city) {
            $result = DB::table('report_kariah AS k')
                ->rightJoin(DB::raw('(SELECT uid, city FROM report_masjid) AS m'), 'k.uid', '=', 'm.uid')
                    ->select(DB::raw('
                    SUM(kariah_race_my) AS Malay,
                    SUM(kariah_race_ind) AS Indo,
                    SUM(kariah_race_ch) AS Chinese,
                    SUM(kariah_race_oth) AS others'
                ))
                ->where('m.city', $city)
                ->first();
        } else {
            $result = DB::table('report_kariah')
                ->select(DB::raw('
                    SUM(kariah_race_my) AS Malay,
                    SUM(kariah_race_ind) AS Indo,
                    SUM(kariah_race_ch) AS Chinese,
                    SUM(kariah_race_oth) AS others'
                ))
                ->first();
        }
    
        return $result;
    }
    

    private function _getDistrictTable()
    {
        $result = DB::table('client AS c')
            ->select(
                'c.city',
                DB::raw("(SELECT COUNT(*) FROM client WHERE cate = 'MASJID UTAMA' AND city = c.city AND app = 'CLIENT' AND isdel = 0) AS MASJID_UTAMA"),
                DB::raw("(SELECT COUNT(*) FROM client WHERE cate = 'SURAU' AND city = c.city AND app = 'CLIENT' AND isdel = 0) AS SURAU"),
                DB::raw("(SELECT COUNT(*) FROM client WHERE cate = 'MASJID DAERAH' AND city = c.city AND app = 'CLIENT' AND isdel = 0) AS MASJID_DAERAH"),
                DB::raw("(SELECT COUNT(*) FROM client WHERE cate = 'MASJID KARIAH' AND city = c.city AND app = 'CLIENT' AND isdel = 0) AS MASJID_KARIAH"),
                DB::raw("(SELECT COUNT(*) FROM client WHERE cate = 'SURAU JUMAAT' AND city = c.city AND app = 'CLIENT' AND isdel = 0) AS SURAU_JUMAAT"),
                DB::raw("(SELECT COUNT(*) FROM client WHERE cate = 'MASJID JAMEK' AND city = c.city AND app = 'CLIENT' AND isdel = 0) AS MASJID_JAMEK"),
                DB::raw("(SELECT COUNT(*) FROM client WHERE cate = 'MASJID PENGURUSAN' AND city = c.city AND app = 'CLIENT' AND isdel = 0) AS MASJID_PENGURUSAN"),
                DB::raw("(SELECT COUNT(*) FROM client WHERE cate = 'MASJID' AND city = c.city AND app = 'CLIENT' AND isdel = 0) AS MASJID"),

                DB::raw("(SELECT COUNT(*) FROM client WHERE sta = 1 AND city = c.city AND app = 'CLIENT' AND isdel = 0) AS Total_Active"),
                DB::raw("(SELECT COUNT(*) FROM client WHERE sta = 0 AND city = c.city AND app = 'CLIENT' AND isdel = 0) AS Total_Inactive"),

                DB::raw("(SELECT COUNT(*) FROM client WHERE cate IN (SELECT prm FROM `type` WHERE grp='type_CLIENT') AND city = c.city AND app = 'CLIENT' AND isdel = 0) AS Total")
            )
            ->where('c.app', 'CLIENT')
            ->where('c.isdel', 0)
            ->groupBy('c.city')
            ->get();

        return $result;
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
            
        // Convert result into an array of categories
        $categories = [
            'Masjid Utama' => $result->MASJID_UTAMA,
            'Surau' => $result->SURAU,
            'Masjid Daerah' => $result->MASJID_DAERAH,
            'Masjid Kariah' => $result->MASJID_KARIAH,
            'Surau Jumaat' => $result->SURAU_JUMAAT,
            'Masjid Jamek' => $result->MASJID_JAMEK,
            'Masjid Pengurusan' => $result->MASJID_PENGURUSAN,
            'Masjid' => $result->MASJID,
        ];

        
        return $categories;
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
    
        return $result;
    }
    

    private function _getTotalMosquePerCategory()
    {
        // Execute the SQL query and return the result
        return DB::table('client as a')
            ->rightJoin('type as b', 'a.cate', '=', 'b.prm')
            ->where('b.grp', '=', 'type_CLIENT')
            ->select('b.prm', DB::raw('count(a.id) as total'))
            ->groupBy('b.prm')
            ->get();
    }







    public function index()
    {
        // Fetch data using the private functions
        $totalMosques = $this->_getTotalMosques();
        $totalKariah = $this->_getTotalKariah();
        $totalStaff = $this->_getTotalStaff();
        $totalKariah_MaleFemale = $this->_getKariahMaleFemale();
        $totalKariahPerDistrict = $this->_getTotalKariahPerDistrict();
        $kariahPerType = $this->_getKariahPerType();
        $kariahPerAgeRange = $this->_getKariahPerAgeRange();
        $kariahNationality = $this->_getKariahNationality();
        $districtTable = $this->_getDistrictTable();
        $mosqueData = $this->_getTotalMosquePerCategory();
        $mosqueData = $mosqueData->mapWithKeys(function ($item) {
            return [$item->prm => $item->total];
        });
        $kariahNationality = (array) $kariahNationality;

        // Ensure all keys exist and fallback to 0 if missing
        $kariahNationality = [
            'Malay' => $kariahNationality['Malay'] ?? 0,
            'Indo' => $kariahNationality['Indo'] ?? 0,
            'Chinese' => $kariahNationality['Chinese'] ?? 0,
            'Others' => $kariahNationality['others'] ?? 0
        ];

    
        // Pass all the data to the view
        return view('base.index', compact(
            'totalMosques', 
            'totalKariah', 
            'totalStaff', 
            'totalKariah_MaleFemale',
            'totalKariahPerDistrict',
            'kariahPerType',
            'kariahPerAgeRange',
            'kariahNationality',
            'districtTable',
            'mosqueData'
        ));
    }

    public function mosquesInCityDetails(Request $request)
    {
        $city = $request['city'];
        // Fetch data using the private functions
        $totalMosques = $this->_getTotalMosques($city);
        $totalKariah = $this->_getTotalKariah($city);
        $totalStaff = $this->_getTotalStaff($city);
        $totalKariah_MaleFemale = $this->_getKariahMaleFemale($city);
        $totalKariahPerDistrict = $this->_getTotalKariahPerDistrict();
        $kariahPerType = $this->_getKariahPerType($city);
        $kariahPerAgeRange = $this->_getKariahPerAgeRange($city);
        $kariahNationality = $this->_getKariahNationality();
        $districtTable = $this->_getDistrictTable();
        $mosqueData = $this->_getTotalMosquePerCategory();
        $kariahPerMosqueType = $this->_getKariahPerMosquesType($city);

        $mosqueData = $mosqueData->mapWithKeys(function ($item) {
            return [$item->prm => $item->total];
        });
        $kariahNationality = (array) $kariahNationality;
        // Ensure all keys exist and fallback to 0 if missing
        $kariahNationality = [
            'Malay' => $kariahNationality['Malay'] ?? 0,
            'Indo' => $kariahNationality['Indo'] ?? 0,
            'Chinese' => $kariahNationality['Chinese'] ?? 0,
            'Others' => $kariahNationality['others'] ?? 0
        ];

        $mosqueActiveInactive = $this->_getMosqueActiveInactive($city);
        $mosqueActiveInactive = (array) $mosqueActiveInactive;
        $mosqueActiveInactive = [
            'Active' => $mosqueActiveInactive['Total_Active'] ?? 0,
            'Inactive' => $mosqueActiveInactive['Total_Inactive'] ?? 0,
        ];


    
        // Pass all the data to the view
        return view('base.mosques_in_city_details', compact(
            'totalMosques', 
            'totalKariah', 
            'totalStaff', 
            'totalKariah_MaleFemale',
            'totalKariahPerDistrict',
            'kariahPerType',
            'kariahPerAgeRange',
            'kariahNationality',
            'mosqueData',
            'mosqueActiveInactive',
            'city',
            'kariahPerMosqueType'
        ));
    }
    
    
    
}
