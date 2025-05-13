<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Institute;
use App\Models\FinancialStatement;
use Illuminate\Support\Facades\Auth;
use App\Models\Parameter;

class DashboardController extends Controller
{
    private const CLIENT_BASE_QUERY = [
        'app' => 'CLIENT',
        'isdel' => 0
    ];

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
            $constraints['rem8'] = $city;
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
            ->rightJoin('type as b', 'a.cate', '=', 'b.code')
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

    private function _getDistrictRow($district)
    {
        $categories = Parameter::where('grp', 'type_CLIENT')->pluck('code');

        return DB::table('client AS c')
            ->select([
                'c.rem8',
                ...array_map(function ($category) {
                    return DB::raw("SUM(CASE WHEN cate = '" . str_replace("'", "''", $category) . "' THEN 1 ELSE 0 END) AS " . str_replace(' ', '_', $category));
                }, $categories->toArray()),
                DB::raw("SUM(CASE WHEN sta = 0 THEN 1 ELSE 0 END) AS Total_Active"),
                DB::raw("SUM(CASE WHEN sta = 1 THEN 1 ELSE 0 END) AS Total_Inactive"),
                DB::raw("COUNT(*) AS Total")
            ])
            ->where(self::CLIENT_BASE_QUERY)
            ->where('app', 'CLIENT')
            ->where('isdel', 0)
            ->where('c.rem8', $district)
            ->groupBy('c.rem8')
            ->first();
    }

    private function _getDistrictTable()
    {
        $categories = Parameter::where('grp', 'type_CLIENT')->pluck('code');

        return DB::table('client AS c')
            ->select([
                'c.rem8',
                ...array_map(function ($category) {
                    return DB::raw("SUM(CASE WHEN cate = '" . str_replace("'", "''", $category) . "' THEN 1 ELSE 0 END) AS " . str_replace(' ', '_', $category));
                }, $categories->toArray()),
                DB::raw("SUM(CASE WHEN sta = 0 THEN 1 ELSE 0 END) AS Total_Active"),
                DB::raw("SUM(CASE WHEN sta = 1 THEN 1 ELSE 0 END) AS Total_Inactive"),
                DB::raw("COUNT(*) AS Total")
            ])
            ->where(self::CLIENT_BASE_QUERY)
            ->where('app', 'CLIENT')
            ->where('isdel', 0)
            ->groupBy('c.rem8')
            ->get();
    }

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
            'mosqueData' => $this->_getTotalMosquePerCategory()->mapWithKeys(fn ($item) => [$item->prm => $item->total]),
            'mosqueActiveInactive' => $this->_getMosqueActiveInactive($city),
            'districtTable' => $this->_getDistrictRow($city),
            'city' => $city,
            'kariahPerMosqueType' => $this->_getKariahPerMosquesType($city),
            'categories' => Parameter::where('grp', 'type_CLIENT')->pluck('prm', 'code')->toArray(),
            'districts' => Parameter::where('grp', 'district')->pluck('prm', 'code')->toArray()

        ];

        return view('base.mosques_in_city_details', $data);
    }

    private function _getMosqueActiveInactive($city)
    {
        $result = DB::table('client AS c')
            ->select(
                DB::raw("SUM(CASE WHEN c.sta = 0 THEN 1 ELSE 0 END) AS Total_Active"),
                DB::raw("SUM(CASE WHEN c.sta = 1 THEN 1 ELSE 0 END) AS Total_Inactive")
            )
            ->where('c.app', 'CLIENT')
            ->where('c.isdel', 0)
            ->where('c.rem8', $city)
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

    public function dashboard()
    {
        $districtAccess = DB::table('usr')->where('mel', Auth::user()->mel)->value('joblvl');

        if ($districtAccess !== null) {
            return redirect()->route('mosquesInCityDetails', ['city' => $districtAccess]);
        }

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
            'mosqueData' => $this->_getTotalMosquePerCategory()->mapWithKeys(fn ($item) => [$item->prm => $item->total]),
            'categories' => Parameter::where('grp', 'type_CLIENT')->pluck('prm', 'code')->toArray(),
            'districts' => Parameter::where('grp', 'district')->pluck('prm', 'code')->toArray()


        ];
        return view('base.index', $data);
    }

    public function getFinancialReport(Request $request)
    {
        $districtAccess = DB::table('usr')->where('mel', Auth::user()->mel)->value('joblvl');
        $year = $request->input('year', date('Y'));
        $totalClientsQuery = DB::table('client')->where('sta', 0);


        $district = $request->input('district') ?? $districtAccess;

        if (!empty($district)) {
            $totalClientsQuery->where('rem8', $district);
        }


        $totalClients = $totalClientsQuery->count();

        $totalEntriesQuery = DB::table('splk_submission as s')
            ->join('client as c', 'c.uid', '=', 's.inst_refno')
            ->where('s.fin_year', $year)
            ->where('s.fin_category', 'STM02')
            ->whereIn('s.status', [1,2]);


        $district = $request->input('district') ?? $districtAccess;

        if (!empty($district)) {
            $totalEntriesQuery->where('c.rem8', $district);
        }


        $totalEntries = $totalEntriesQuery->count();

        return response()->json([
            'totalClients' => $totalClients,
            'totalEntries' => $totalEntries,
        ]);
    }

    public function getStatementsReport(Request $request)
    {
        $finYear = $request->filled('year') ? $request->year : date('Y');
        $finCategory = $request->filled('fin_category') ? $request->fin_category : 'STM02';
        $districtAccess = DB::table('usr')->where('mel', Auth::user()->mel)->value('joblvl');
        $district = $request->filled('district') ? $request->district : $districtAccess;
        $institute = $request->filled('institute') ? $request->institute : null;

        // Start building the subquery filter
        $subQueryFilter = "WHERE c.sta = 0 AND c.app = 'CLIENT' AND c.isdel = 0";

        if (!is_null($district)) {
            $subQueryFilter .= " AND c.rem8 = '{$district}'";
        }

        // Main query using the subquery approach for more efficient calculation
        $data = DB::table('client as c')
            ->selectRaw("
            COUNT(DISTINCT c.uid) AS total_berdaftar,
            COUNT(DISTINCT CASE WHEN s.status IN (1, 2, 3) THEN s.inst_refno END) AS total_telah_hantar,
            COUNT(DISTINCT CASE WHEN s.status = 2 THEN s.inst_refno END) AS total_diterima,

            COUNT(DISTINCT CASE 
                WHEN s.status = 2 OR (
                    s.status = 3 AND NOT EXISTS (
                        SELECT 1 
                        FROM splk_submission s2
                        WHERE s2.inst_refno = s.inst_refno
                        AND s2.fin_year = s.fin_year
                        AND s2.fin_category = s.fin_category
                        AND s2.status IN (1, 2)
                        AND s2.id > s.id
                    )
                ) 
                THEN s.inst_refno 
            END) AS total_checked,
            COUNT(DISTINCT CASE 
                WHEN s.status = 1 OR (
                    s.status = 3 AND EXISTS (
                        SELECT 1
                        FROM splk_submission s2
                        WHERE s2.inst_refno = s.inst_refno
                        AND s2.fin_year = s.fin_year
                        AND s2.fin_category = s.fin_category
                        AND s2.status = 1
                        AND s2.id > s.id
                    )
                )
                THEN s.inst_refno
            END) AS total_unchecked,


            COUNT(DISTINCT CASE 
                WHEN s.status = 3 AND NOT EXISTS (
                    SELECT 1 
                    FROM splk_submission s2
                    WHERE s2.inst_refno = s.inst_refno
                    AND s2.fin_year = s.fin_year
                    AND s2.fin_category = s.fin_category
                    AND s2.status IN (1, 2)
                    AND s2.id > s.id
                )
                THEN s.inst_refno 
            END) AS total_ditolak_belum_hantar,
            COUNT(DISTINCT CASE 
                WHEN s.status = 3 AND EXISTS (
                    SELECT 1 
                    FROM splk_submission s2
                    WHERE s2.inst_refno = s.inst_refno
                    AND s2.fin_year = s.fin_year
                    AND s2.fin_category = s.fin_category
                    AND s2.status IN (1, 2)
                    AND s2.id > s.id
                )
                THEN s.inst_refno 
            END) AS total_ditolak_dan_hantar
        ")
            ->leftJoin('splk_submission as s', function ($join) use ($finYear, $finCategory, $request) {
                $join->on('c.uid', '=', 's.inst_refno')
                    ->where('s.fin_year', $finYear)
                    ->where('s.fin_category', $finCategory)
                    ->whereNotIn('s.status', [0, 4]);
                if ($request->filled('institute')) {
                    $join->where('s.institute', $request->institute);
                }
            })
            ->where('c.sta', 0)
            ->where('c.app', 'CLIENT')
            ->where('c.isdel', 0);

        if (!is_null($district)) {
            $data->where('c.rem8', $district);
        }
        if (!is_null($institute)) {
            $data->where('c.cate1', $institute);
        }

        $result = $data->first();

        // Calculate total rejected
        $total_ditolak = $result->total_ditolak_belum_hantar + $result->total_ditolak_dan_hantar;

        return response()->json([
            'categories' => [
                ['Bil Hantar', 'Bil Daftar (Aktif)'],
                ['Bil Dah Semak', 'Bil Belum Semak'],
                ['Bil Terima', 'Bil Di Tolak'],
                ['Bil Tolak & Telah Hantar Semula', 'Bil Ditolak Belum Hantar Semula']
            ],
            'series' => [
                [$result->total_telah_hantar, $result->total_berdaftar - $result->total_telah_hantar],
                [$result->total_checked, $result->total_unchecked],
                [$result->total_diterima, $total_ditolak],
                [$result->total_ditolak_dan_hantar, $result->total_ditolak_belum_hantar]

            ],
            'colors' => [
                ['#E75FB4', '#5B6EF5'],
                ['#FF9066', '#26C5B2'],
                ['#FFD84D', '#4CAF50'],
                ['#FF9066', '#26C5B2']
            ]
        ]);
    }

    public function index()
    {

        $districtAccess = DB::table('usr')->where('mel', Auth::user()->mel)->value('joblvl');

        $categories = Parameter::where('grp', 'type_CLIENT')->pluck('code')->toArray();

        // Base query
        $baseQuery = Institute::selectRaw('cate, COUNT(*) as total')
            ->where('sta', 0)
            ->when($districtAccess !== null, function ($query) use ($districtAccess) {
                $query->where('rem8', $districtAccess);
            })
            ->whereIn('cate', $categories)
            ->groupBy('cate')
            ->pluck('total', 'cate');

        // Ensure all categories are present in result (even if 0)
        $categoryCounts = [];
        foreach ($categories as $code) {
            $categoryCounts[$code] = $baseQuery[$code] ?? 0;
        }

        // Optional: Total count of all
        $total_institute = array_sum($categoryCounts);



        $total_institute_registration = Institute::where('sta', 1)
            ->when($districtAccess !== null, function ($query) use ($districtAccess) {
                return $query->where('rem8', $districtAccess);
            })
            ->whereNotNull('registration_request_date')
            ->where(function ($q) {
                $q->whereNull('regdt')
                ->orWhere('regdt', '0000-00-00');
            })
            ->count() ?: null;

        $total_statement_to_review = FinancialStatement::where('status', 1)
            ->when($districtAccess !== null, function ($query) use ($districtAccess) {
                return $query->whereHas('Institute', function ($q) use ($districtAccess) {
                    $q->where('rem8', $districtAccess);
                });
            })
            ->count() ?: null;


        $total_statement_accepted = FinancialStatement::where('status', 2)
            ->when($districtAccess !== null, function ($query) use ($districtAccess) {
                return $query->whereHas('Institute', function ($q) use ($districtAccess) {
                    $q->where('rem8', $districtAccess);
                });
            })
            ->count() ?: null;


        $total_statement_request_edit = FinancialStatement::where('status', 4)
            ->when($districtAccess !== null, function ($query) use ($districtAccess) {
                return $query->whereHas('Institute', function ($q) use ($districtAccess) {
                    $q->where('rem8', $districtAccess);
                });
            })
            ->count() ?: null;


        $total_statement_cancelled = FinancialStatement::where('status', 3)
            ->when($districtAccess !== null, function ($query) use ($districtAccess) {
                return $query->whereHas('Institute', function ($q) use ($districtAccess) {
                    $q->where('rem8', $districtAccess);
                });
            })
            ->count() ?: null;

        $institute_registration_list = Institute::with('Type', 'Category')->where('sta', 1)
            ->when($districtAccess !== null, function ($query) use ($districtAccess) {
                return $query->where('rem8', $districtAccess);
            })
            ->whereNotNull('registration_request_date')
            ->where(function ($q) {
                $q->whereNull('regdt')
                ->orWhere('regdt', '0000-00-00');
            })
            ->limit(5)
            ->get();


        $financial_statements_list = FinancialStatement::with('Institute')
            ->where('status', 1)
            ->when(!is_null($districtAccess), function ($query) use ($districtAccess) {
                return $query->whereHas('Institute', function ($q) use ($districtAccess) {
                    $q->where('rem8', $districtAccess);
                });
            })
            ->orderBy('id', 'desc')
            ->limit(5)
            ->get()
            ->transform(function ($financialStatement) {
                $financialStatement->CATEGORY = isset($financialStatement->Category->prm)
                    ? strtoupper($financialStatement->Category->prm)
                    : null;
                $financialStatement->INSTITUTE = isset($financialStatement->Institute->name)
                    ? strtoupper($financialStatement->Institute->name)
                    : null;
                $financialStatement->DISTRICT = isset($financialStatement->Institute->District->prm)
                    ? strtoupper($financialStatement->Institute->District->prm)
                    : null;
                $financialStatement->SUBMISSION_DATE = date('d-m-Y', strtotime($financialStatement->submission_date));

                return $financialStatement;
            });

        $institute_by_district = Institute::select('rem8', DB::raw('count(*) as total'))
            ->when($districtAccess !== null, function ($query) use ($districtAccess) {
                return $query->where('rem8', $districtAccess);
            })
            ->groupBy('rem8')
            ->get()
            ->transform(function ($institute) {
                $institute->DISTRICT = isset($institute->District->prm)
                    ? strtoupper($institute->District->prm)
                    : null;
                return $institute;
            });

        $maxCount = $institute_by_district->max('total');

        $query = DB::table('client as c');

        if ($districtAccess != null) {
            $query->where('c.rem8', $districtAccess);
        }

        $subscriptions = $query->joinSub(
            DB::table('fin_ledger as inv')
                ->select(
                    'inv.vid',
                    DB::raw('SUM(inv.val) AS total_invoice'),
                    DB::raw('COALESCE(SUM(csl.val), 0) AS total_received'),
                    DB::raw('SUM(inv.val) - COALESCE(SUM(csl.val), 0) AS outstanding')
                )
                ->leftJoin('fin_ledger as csl', function ($join) {
                    $join->on('inv.vid', '=', 'csl.vid')
                        ->where('csl.src', 'CSL');
                })
                ->where('inv.src', 'INV')
                ->groupBy('inv.vid')
                ->having(DB::raw('SUM(inv.val) - COALESCE(SUM(csl.val), 0)'), '>', 0),
            'subquery',
            'c.uid',
            '=',
            'subquery.vid'
        )
        ->where('c.subscription_status', 2)
        ->select(
            'c.name as name',
            'c.con1 as con1',
            'c.mel as mel',
            'c.hp as hp',
            'c.subscription_status as subscription_status',
            'subquery.outstanding'
        )
        ->limit(5)
        ->get();
        $subscriptions->transform(function ($subscription) {
            $subscription->NAME = isset($subscription->name) ? strtoupper($subscription->name) : null;
            $subscription->OFFICER = isset($subscription->con1) ? strtoupper($subscription->con1) : null;
            $subscription->EMAIL = $subscription->mel ?? null;
            $subscription->PHONE = $subscription->hp ?? null;
            $subscription->TOTAL_OUTSTANDING = $subscription->outstanding ?? 0;
            $subscription->STATUS = $subscription->subscription_status
                ? Parameter::where('grp', 'subscriptionstatus')
                        ->where('val', $subscription->subscription_status)
                        ->value('prm')
                : null;
            return $subscription;
        });

        $latest_fin_year = DB::table('splk_submission')->max('fin_year');
        $totalClients = DB::table('client')->where('sta', 0)->count();
        $totalEntries = DB::table('splk_submission')
            ->where('fin_year', $latest_fin_year)
            ->where('fin_category', 'STM02')
            ->where('status', 3)
            ->count();

        $years = range(date('Y'), date('Y') - 4);

        $districts = Parameter::where('grp', 'district')->pluck('prm', 'code')->toArray();
        if ($districtAccess !== null) {
            $districts = array_filter($districts, function ($key) use ($districtAccess) {
                return $key == $districtAccess;
            }, ARRAY_FILTER_USE_KEY);
        }
        $institute = Parameter::where('grp', 'clientcate1')->pluck('prm', 'code')->toArray();
        $statement = Parameter::where('grp', 'statement')->pluck('prm', 'code')->toArray();





        return view('base.dashboard', compact(
            'total_institute',
            'total_institute_registration',
            'total_statement_to_review',
            'total_statement_cancelled',
            'total_statement_accepted',
            'total_statement_request_edit',
            'institute_registration_list',
            'financial_statements_list',
            'institute_by_district',
            'maxCount',
            'subscriptions',
            'latest_fin_year',
            'totalClients',
            'totalEntries',
            'years',
            'districts',
            'institute',
            'statement',
            'categoryCounts',
        ));
    }



}
