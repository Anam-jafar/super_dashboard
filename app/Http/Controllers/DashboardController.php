<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use MongoDB\Client as MongoClient;
use App\Reports\DashboardReport;
use Illuminate\Support\Facades\DB;



class DashboardController extends Controller
{
    public function index(Request $request)
    {
        // Connect to MongoDB
        $client = new MongoClient('mongodb+srv://development:XT7GquBxdsk5wMru@ebossdevelopment.ekek02t.mongodb.net/?retryWrites=true&w=majority');
        $collection = $client->super_dashboard->dashboard;
    
        // Fetch all documents from the dashboard collection
        $dashboardData = $collection->find(); // Retrieves all documents
    
        // Initialize arrays to store cards, pie charts, and tables data
        $data = [];
        $pieCharts = [];
        $tables = [];
    
        // Loop through each document to extract cards, pie charts, and tables
        foreach ($dashboardData as $document) {
            // Extract cards
            if (isset($document['cards'])) {
                foreach ($document['cards'] as $card) {
                    $data[$card['name']] = [
                        $card['title'],
                        $card['value']
                    ];
                }
            }
    
            // Extract pie charts
            if (isset($document['pie_charts'])) {
                foreach ($document['pie_charts'] as $chart) {
                    $pieCharts[$chart['name']] = $chart['data'];
                }
            }
    
            // Extract tables
            if (isset($document['tables'])) {
                foreach ($document['tables'] as $table) {
                    // Add table name and relevant data
                    $tables[$table['name']] = [
                        'categories' => $table['categories'],
                        'districts' => $table['districts'],
                        'totals' => $table['totals']
                    ];
                }
            }
             // Extract other objects (e.g., total_mosque, total_kariah, etc.)
            $fieldsToExtract = [
                'total_mosque',
                'total_kariah',
                'total_staff',
                'total_male',
                'total_female',
                'members_active_percentage',
                'members_age_category',
                'members_category',
                'members_nationality_percentage',
                'total_members_each_district',
                'percentage_of_mosque_type',
            ];

            foreach ($fieldsToExtract as $field) {
                if (isset($document[$field])) {
                    $objects[$field] = $document[$field];
                }
            }
        
        
        }

        $users = DB::table('usr')->pluck('name');
    
        // Return the view with cards, pie charts, and tables data
        return view('base.index', compact('data', 'pieCharts', 'tables', 'objects', 'users'));
    }
    
    private function _getTotalMosques($city = NULL){
        if($city != NULL){
            $totalMosques = DB::table('client')
            ->where('app', 'CLIENT')
            ->where('isdel', 0)
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
            $totalKariah = DB::table('report_kariah')
            ->sum('kariah_bil');
        }else{
            $totalKariah = DB::table('report_kariah')
            ->sum('kariah_bil');
        }
        return $totalKariah;
    }


    private function _getTotalStaff($city = NULL){
        if($city != NULL){
            $totalStaff = DB::table('report_masjid')
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
            $result = DB::table('report_kariah')
                ->select(DB::raw('SUM(kariah_male) AS total_male, SUM(kariah_female) AS total_female'))
                ->where('city', $city)
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

    private function _getKariahPerType()
    {
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
                SUM(kariah_cat_10) AS bantuan_masjid'
            ))
            ->first();

        return $result;
    }

    private function _getKariahPerAgeRange()
    {
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

        return $result;
    }

    private function _getKariahNationality()
    {
        $result = DB::table('report_kariah')
            ->select(DB::raw('
                SUM(kariah_race_my) AS Malay,
                SUM(kariah_race_ind) AS Indo,
                SUM(kariah_race_ch) AS Chinese,
                SUM(kariah_race_oth) AS others'
            ))
            ->first();

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







    public function indexs(Request $request)
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
        return view('base.indexs', compact(
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
    
    
    
}
