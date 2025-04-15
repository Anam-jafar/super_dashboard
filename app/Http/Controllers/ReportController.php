<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Models\FinancialStatement;
use App\Models\Institute;
use App\Models\Parameter;

class ReportController extends Controller
{
    private function applyFilters($query, Request $request)
    {
        $query->join('client', 'splk_submission.inst_refno', '=', 'client.uid')
            ->select('splk_submission.*', 'client.name', 'client.rem8');

        foreach ($request->all() as $field => $value) {
            if (!empty($value)) {
                if (\Schema::hasColumn('splk_submission', $field)) {
                    $query->where("splk_submission.$field", $value);
                } elseif (\Schema::hasColumn('client', $field)) {
                    $query->where("client.$field", $value);
                }
            }
        }

        if ($request->filled('search')) {
            $searchTerm = $request->input('search');
            $query->where('client.name', 'like', "%{$searchTerm}%");
        }

        return $query;
    }

    public function list(Request $request)
    {

        $districtAccess = DB::table('usr')
            ->where('mel', Auth::user()->mel)
            ->value('joblvl');

        $perPage = $request->input('per_page', 10);

        $query = FinancialStatement::with('Institute')->where('status', 1);

        if (!is_null($districtAccess)) {
            $query->whereHas('institute', function ($q) use ($districtAccess) {
                $q->where('rem8', $districtAccess);
            });
        }
        $query = $this->applyFilters($query, $request);

        $financialStatements = $query
            ->orderBy('id', 'desc')
            ->paginate($perPage)->withQueryString();

        $financialStatements->getCollection()->transform(function ($financialStatement) {
            $financialStatement->CATEGORY = isset($financialStatement->Category->prm) ? strtoupper($financialStatement->Category->prm) : null;
            $financialStatement->INSTITUTE = isset($financialStatement->Institute->name) ? strtoupper($financialStatement->Institute->name) : null;
            $financialStatement->OFFICER = isset($financialStatement->Institute->con1) ? strtoupper($financialStatement->Institute->con1) : null;
            $financialStatement->FINSUBMISSIONSTATUS = isset($financialStatement->status) ? strtoupper($financialStatement->status) : null;
            $financialStatement->DISTRICT = isset($financialStatement->Institute->District->prm) ? strtoupper($financialStatement->Institute->District->prm) : null;
            $financialStatement->SUBDISTRICT = isset($financialStatement->Institute->Subdistrict->prm) ? strtoupper($financialStatement->Institute->Subdistrict->prm) : null;
            $financialStatement->SUBMISSION_DATE = date('d-m-Y', strtotime($financialStatement->submission_date));
            $financialStatement->FIN_STATUS = Parameter::where('grp', 'splkstatus')
                ->where('val', $financialStatement->status)
                ->pluck('prm', 'val')
                ->map(fn ($prm, $val) => ['val' => $val, 'prm' => $prm])
                ->first();
            return $financialStatement;
        });

        $currentYear = date('Y');
        $years = array_combine(range($currentYear - 3, $currentYear + 3), range($currentYear - 3, $currentYear + 3));

        $parameters = $this->getCommon();
        if ($districtAccess != null) {
            $parameters['districts'] = Parameter::where('grp', 'district')
                ->where('code', $districtAccess)
                ->pluck('prm', 'code')
                ->toArray();
            $parameters['subdistricts'] = Parameter::where('grp', 'subdistrict')
                ->where('etc', $districtAccess)
                ->pluck('prm', 'code')
                ->toArray();
        }

        if ($request->filled('cate1')) {
            $parameters['categories'] = Parameter::where('grp', 'type_CLIENT')
                ->where('etc', $request->cate1)
                ->pluck('prm', 'code')
                ->toArray();
        }

        if ($request->filled('rem8')) {
            $parameters['subdistricts'] = Parameter::where('grp', 'subdistrict')
                ->where('etc', $request->rem8)
                ->pluck('prm', 'code')
                ->toArray();
        }
        return view('financial_statement.list', [
            'parameters' => $parameters,
            'financialStatements' => $financialStatements,
            'years' => $years,
        ]);
    }

    public function submissionCount(Request $request)
    {
        $districtAccess = DB::table('usr')
            ->where('mel', Auth::user()->mel)
            ->value('joblvl');

        // Define the base query
        $query = DB::table('splk_submission as s')
            ->selectRaw("t.prm AS cate_name, s.fin_year, s.fin_category,
            COUNT(CASE WHEN s.status IN (1, 2) THEN 1 END) AS total_submission, 
            SUM(CASE WHEN c.sta = 0 AND c.app = 'CLIENT' AND c.isdel = 0 THEN 1 ELSE 0 END) - 
            COUNT(CASE WHEN s.status IN (1, 2) THEN 1 END) AS unsubmitted")
            ->join('client as c', 'c.uid', '=', 's.inst_refno')
            ->join('type as t', function ($join) {
                $join->on('c.cate1', '=', 't.code')
                    ->where('t.grp', '=', 'clientcate1');
            });

        // Apply district access filter if applicable
        if (!is_null($districtAccess)) {
            $query->where('c.rem8', $districtAccess);
        }

        // Get filtering parameters from request
        $finYear = $request->filled('fin_year') ? $request->fin_year : date('Y');
        $finCategory = $request->filled('fin_category') ? $request->fin_category : 'STM01';

        // Apply filters to the query
        $query->where('s.fin_year', $finYear)
            ->where('s.fin_category', $finCategory);

        // Fix for MySQL's ONLY_FULL_GROUP_BY issue
        $query->groupBy('t.prm', 's.fin_year', 's.fin_category')
            ->orderBy('t.prm');

        // Paginate results
        $perPage = $request->input('per_page', 10);
        $entries = $query->paginate($perPage)->withQueryString();

        // Transform data to include fin_category name
        $entries->transform(function ($entry) {
            $entry->CATEGORY = isset($entry->cate_name) ? strtoupper($entry->cate_name) : null;
            $entry->FIN_CATEGORY = strtoupper(Parameter::where('code', $entry->fin_category)->value('prm') ?? '');
            return $entry;
        });

        // Generate year filter options
        $currentYear = date('Y');
        $years = array_combine(range($currentYear - 1, $currentYear - 4), range($currentYear - 1, $currentYear - 4));

        // Fetch common parameters
        $parameters = $this->getCommon();

        // Return view with data
        return view('report.submission_count_list', [
            'years' => $years,
            'entries' => $entries,
            'parameters' => $parameters,
        ]);
    }


    public function submissionStatus(Request $request)
    {
        $districtAccess = DB::table('usr')
                ->where('mel', Auth::user()->mel)
                ->value('joblvl');
        // Define the base query
        $query = DB::table('splk_submission as s')
            ->selectRaw("t.prm AS Jenis_Institusi, c.name AS Nama_institusi, 
            s.fin_year AS Tahun_Laporan, s.submission_date AS Tarikh_Hantar, 
            s.fin_category AS Kategori_laporan, t1.prm AS Daerah, 
            s.total_collection AS Jumlah_kutipan, s.total_expenses AS Jumlah_Belanja, 
            s.bank_cash_balance AS Jumlah_Baki_Bank, s.status, t2.prm AS Status")->whereNotIn('s.status', [0, 4])
            ->join('client as c', 'c.uid', '=', 's.inst_refno')
            ->join('type as t', function ($join) {
                $join->on('c.cate', '=', 't.code')
                     ->where('t.grp', '=', 'type_client');
            })
            ->join('type as t1', function ($join) {
                $join->on('c.rem8', '=', 't1.code')
                     ->where('t1.grp', '=', 'district');
            })
            ->join('type as t2', function ($join) {
                $join->on('s.status', '=', 't2.val')
                     ->where('t2.grp', '=', 'splkstatus');
            });

        if (!is_null($districtAccess)) {
            $query->where('c.rem8', $districtAccess);
        }

        // Apply filters based on request parameters
        if ($request->filled('rem8')) {
            $query->where('c.rem8', $request->rem8);
        }
        if ($request->filled('cate')) {
            $query->where('c.cate', $request->cate);
        }
        if ($request->filled('status')) {
            $query->where('s.status', $request->status);
        }
        if ($request->filled('fin_year')) {
            $query->where('s.fin_year', $request->fin_year);
        }
        if ($request->filled('search')) {
            $query->where('c.name', 'like', '%' . $request->search . '%');
        }

        // Order and paginate
        $query->orderBy('t.prm', 'ASC');
        $perPage = $request->input('per_page', 10);
        $entries = $query->paginate($perPage)->withQueryString();

        // Transform entries before sending to the view
        $entries->transform(function ($entry) {
            $entry->CATEGORY = strtoupper($entry->Jenis_Institusi);
            $entry->NAME = strtoupper($entry->Nama_institusi);
            $entry->YEAR = strtoupper($entry->Tahun_Laporan);
            $entry->DATE = strtoupper($entry->Tarikh_Hantar);
            $entry->STATEMENT = strtoupper(Parameter::where('code', $entry->Kategori_laporan)->value('prm'));
            $entry->DISTRICT = strtoupper($entry->Daerah);
            $entry->JUMLAH_KUTIPAN = strtoupper($entry->Jumlah_kutipan);
            $entry->JUMLAH_BELANJA = strtoupper($entry->Jumlah_Belanja);
            $entry->JUMLAH_BAKI_BANK = strtoupper($entry->Jumlah_Baki_Bank);
            $entry->FIN_STATUS = Parameter::where('grp', 'splkstatus')
                ->where('val', $entry->status)
                ->pluck('prm', 'val')
                ->map(fn ($prm, $val) => ['val' => $val, 'prm' => $prm])
                ->first();
            return $entry;
        });

        // Fetch parameters
        $parameters = $this->getCommon();
        if ($districtAccess != null) {
            $parameters['districts'] = Parameter::where('grp', 'district')
                ->where('code', $districtAccess)
                ->pluck('prm', 'code')
                ->toArray();
            $parameters['subdistricts'] = Parameter::where('grp', 'subdistrict')
                ->where('etc', $districtAccess)
                ->pluck('prm', 'code')
                ->toArray();
        }
        if ($request->filled('cate1')) {
            $parameters['categories'] = Parameter::where('grp', 'type_CLIENT')
                ->where('etc', $request->cate1)
                ->pluck('prm', 'code')
                ->toArray();
        }
        if ($request->filled('rem8')) {
            $parameters['subdistricts'] = Parameter::where('grp', 'subdistrict')
                ->where('etc', $request->rem8)
                ->pluck('prm', 'code')
                ->toArray();
        }

        // Fetch years dynamically
        $currentYear = date('Y');
        $years = array_combine(range($currentYear, $currentYear - 4), range($currentYear, $currentYear - 4));

        // Return view with data
        return view('report.submission_status', [
            'years' => $years,
            'entries' => $entries,
            'parameters' => $parameters,
        ]);
    }

    public function collectionAndExpense(Request $request)
    {
        $districtAccess = DB::table('usr')
                ->where('mel', Auth::user()->mel)
                ->value('joblvl');
        // Define the base query
        $query = DB::table('splk_submission as s')
            ->selectRaw("t.prm AS Jenis_Institusi, c.name AS Nama_institusi, 
            s.fin_year AS Tahun_Laporan, s.fin_category AS Kategori_laporan, 
            t1.prm AS Daerah, s.total_collection AS Jumlah_kutipan, 
            s.total_expenses AS Jumlah_Belanja, s.total_income AS Jumlah_Pendapatan, 
            s.bank_cash_balance AS Jumlah_Baki_Diisytihar")->whereNotIn('s.status', [0, 4])
            ->join('client as c', 'c.uid', '=', 's.inst_refno')
            ->join('type as t', function ($join) {
                $join->on('c.cate', '=', 't.code')
                     ->where('t.grp', '=', 'type_client');
            })
            ->join('type as t1', function ($join) {
                $join->on('c.rem8', '=', 't1.code')
                     ->where('t1.grp', '=', 'district');
            });

        if (!is_null($districtAccess)) {
            $query->where('c.rem8', $districtAccess);
        }
        // Apply filters based on request parameters
        if ($request->filled('rem8')) {
            $query->where('c.rem8', $request->rem8);
        }
        if ($request->filled('cate')) {
            $query->where('c.cate', $request->cate);
        }
        if ($request->filled('fin_year')) {
            $query->where('s.fin_year', $request->fin_year);
        }
        if ($request->filled('search')) {
            $query->where('c.name', 'like', '%' . $request->search . '%');
        }

        // Order and paginate
        $query->orderBy('t.prm', 'ASC');
        $perPage = $request->input('per_page', 10);
        $entries = $query->paginate($perPage)->withQueryString();

        // Transform entries before sending to the view
        $entries->transform(function ($entry) {
            foreach ($entry as $key => $value) {
                $entry->$key = strtoupper($value);
            }
            return $entry;
        });
        $entries->transform(function ($entry) {
            $entry->Kategori_laporan = strtoupper(Parameter::where('code', $entry->Kategori_laporan)->value('prm'));
            return $entry;
        });


        // Fetch years dynamically
        $currentYear = date('Y');
        $years = array_combine(range($currentYear, $currentYear - 4, -1), range($currentYear, $currentYear - 4, -1));

        // Fetch parameters
        $parameters = $this->getCommon();


        if ($districtAccess != null) {
            $parameters['districts'] = Parameter::where('grp', 'district')
                ->where('code', $districtAccess)
                ->pluck('prm', 'code')
                ->toArray();
            $parameters['subdistricts'] = Parameter::where('grp', 'subdistrict')
                ->where('etc', $districtAccess)
                ->pluck('prm', 'code')
                ->toArray();
        }
        // Return view with data
        return view('report.collection_expense', [
            'years' => $years,
            'entries' => $entries,
            'parameters' => $parameters,
        ]);
    }
    public function submissionDetailed(Request $request)
    {
        $districtAccess = DB::table('usr')
                ->where('mel', Auth::user()->mel)
                ->value('joblvl');
        // Define the base query
        $query = DB::table('splk_submission as s')
            ->selectRaw("t.prm AS Jenis_Institusi, c.name AS Nama_institusi, 
            s.submission_date AS Tarikh_Hantar, s.fin_year AS Tahun_Laporan, 
            s.fin_category AS Kategori_laporan, s.id AS id, s.status as status,
            t1.prm AS Daerah, t2.prm AS Status")->whereNotIn('s.status', [0, 4])
            ->join('client as c', 'c.uid', '=', 's.inst_refno')
            ->join('type as t', function ($join) {
                $join->on('c.cate', '=', 't.code')
                     ->where('t.grp', '=', 'type_client');
            })
            ->join('type as t1', function ($join) {
                $join->on('c.rem8', '=', 't1.code')
                     ->where('t1.grp', '=', 'district');
            })
            ->join('type as t2', function ($join) {
                $join->on('s.status', '=', 't2.val')
                     ->where('t2.grp', '=', 'splkstatus');
            });

        // Apply filters based on request parameters
        if ($request->filled('fin_year')) {
            $query->where('s.fin_year', $request->fin_year);
        }
        if ($request->filled('fin_category')) {
            $query->where('s.fin_category', $request->fin_category);
        }
        if (!is_null($districtAccess)) {
            $query->where('c.rem8', $districtAccess);
        }

        // Order and paginate
        $query->orderBy('t.prm', 'ASC');
        $perPage = $request->input('per_page', 10);
        $entries = $query->paginate($perPage)->withQueryString();

        // Transform entries before sending to the view
        $entries->transform(function ($entry) {
            foreach ($entry as $key => $value) {
                $entry->$key = strtoupper($value);
            }
            return $entry;
        });
        $entries->transform(function ($entry) {
            $entry->Kategori_laporan = strtoupper(Parameter::where('code', $entry->Kategori_laporan)->value('prm'));
            $entry->FIN_STATUS = Parameter::where('grp', 'splkstatus')
                ->where('val', $entry->status)
                ->pluck('prm', 'val')
                ->map(fn ($prm, $val) => ['val' => $val, 'prm' => $prm])
                ->first();
            return $entry;
        });

        // Fetch years dynamically
        $currentYear = date('Y');
        $years = array_combine(range($currentYear, $currentYear - 4, -1), range($currentYear, $currentYear - 4, -1));

        // Fetch parameters
        $parameters = $this->getCommon();

        if ($districtAccess != null) {
            $parameters['districts'] = Parameter::where('grp', 'district')
                ->where('code', $districtAccess)
                ->pluck('prm', 'code')
                ->toArray();
            $parameters['subdistricts'] = Parameter::where('grp', 'subdistrict')
                ->where('etc', $districtAccess)
                ->pluck('prm', 'code')
                ->toArray();
        }


        // Return view with data
        return view('report.submission_detailed', [
            'years' => $years,
            'entries' => $entries,
            'parameters' => $parameters,
        ]);
    }

    public function searchStatement(Request $request)
    {
        if ($request->isMethod('post')) {
            // $validator = Validator::make($request->all(), [
            //     'fin_year' => 'required',
            //     'fin_category' => 'required',
            //     'fin_month' => 'required',
            // ]);

            // if ($validator->fails()) {
            //     return redirect()->back()
            //         ->withErrors($validator)
            //         ->withInput();
            // }

            // Define the base query
            $query = DB::table('splk_submission as s')
                ->selectRaw("t.prm AS Jenis_Institusi, c.name AS Nama_institusi, 
                s.submission_date AS Tarikh_Hantar, s.fin_year AS Tahun_Laporan, 
                s.fin_category AS Kategori_laporan, s.id AS id, s.status as status,
                t1.prm AS Daerah, t2.prm AS Status")->whereNotIn('s.status', [0, 4])
                ->join('client as c', 'c.uid', '=', 's.inst_refno')
                ->join('type as t', function ($join) {
                    $join->on('c.cate', '=', 't.code')
                        ->where('t.grp', '=', 'type_client');
                })
                ->join('type as t1', function ($join) {
                    $join->on('c.rem8', '=', 't1.code')
                        ->where('t1.grp', '=', 'district');
                })
                ->join('type as t2', function ($join) {
                    $join->on('s.status', '=', 't2.val')
                        ->where('t2.grp', '=', 'splkstatus');
                });
            $districtAccess = DB::table('usr')
                    ->where('mel', Auth::user()->mel)
                    ->value('joblvl');

            if (!is_null($districtAccess)) {
                $query->where('c.rem8', $districtAccess);
            }

            // Apply filters based on request parameters
            if ($request->filled('fin_year')) {
                $query->where('s.fin_year', $request->fin_year);
            }
            if ($request->filled('fin_category')) {
                $query->where('s.fin_category', $request->fin_category);
            }
            if ($request->filled('rem8')) {
                $query->where('c.rem8', $request->rem8);
            }
            if ($request->filled('cate')) {
                $query->where('c.cate', $request->cate);
            }
            if ($request->filled('status')) {
                $query->where('s.status', $request->status);
            }
            if ($request->filled('cate1')) {
                $query->where('c.cate1', $request->cate1);
            }
            if ($request->filled('year')) {
                $query->whereYear('s.submission_date', $request->year);
            }

            if ($request->filled('month')) {
                $query->whereMonth('s.submission_date', $request->month);
            }

            if ($request->filled('start_date')) {
                $query->whereDate('s.submission_date', '>=', $request->start_date);
            }

            if ($request->filled('end_date')) {
                $query->whereDate('s.submission_date', '<=', $request->end_date);
            }

            $query->orderBy('t.prm', 'ASC');
            $perPage = $request->input('per_page', 10);
            $entries = $query->paginate($perPage)->withQueryString();

            // Transform entries before sending to the view
            $entries->transform(function ($entry) {
                foreach ($entry as $key => $value) {
                    $entry->$key = strtoupper($value);
                }
                return $entry;
            });
            $entries->transform(function ($entry) {
                $entry->Kategori_laporan = strtoupper(Parameter::where('code', $entry->Kategori_laporan)->value('prm'));
                $entry->FIN_STATUS = Parameter::where('grp', 'splkstatus')
                    ->where('val', $entry->status)
                    ->pluck('prm', 'val')
                    ->map(fn ($prm, $val) => ['val' => $val, 'prm' => $prm])
                    ->first();
                return $entry;
            });

            // Fetch years dynamically
            $currentYear = date('Y');
            $years = array_combine(range($currentYear, $currentYear - 4, -1), range($currentYear, $currentYear - 4, -1));

            // Fetch parameters
            $parameters = $this->getCommon();

            // Return view with data
            return view('report.search_result', [
                'years' => $years,
                'entries' => $entries,
                'parameters' => $parameters,
            ]);

            $financialStatements = FinancialStatement::where('fin_year', $request->fin_year)
                ->where('fin_category', $request->fin_category)
                ->where('fin_month', $request->fin_month)
                ->get();

            return view('report.search_statement', [
                'financialStatements' => $financialStatements,
            ]);
        }


        // Fetch years dynamically
        $currentYear = date('Y');
        $years = array_combine(range($currentYear, $currentYear - 4, -1), range($currentYear, $currentYear - 4, -1));
        $months = [];
        $malayMonths = [
            '01' => 'Januari',
            '02' => 'Februari',
            '03' => 'Mac',
            '04' => 'April',
            '05' => 'Mei',
            '06' => 'Jun',
            '07' => 'Julai',
            '08' => 'Ogos',
            '09' => 'September',
            '10' => 'Oktober',
            '11' => 'November',
            '12' => 'Disember',
        ];

        foreach (range(1, 12) as $month) {
            $monthKey = str_pad($month, 2, '0', STR_PAD_LEFT);
            $months[$monthKey] = $malayMonths[$monthKey];
        }



        // Fetch parameters
        $parameters = $this->getCommon();


        $districtAccess = DB::table('usr')
                ->where('mel', Auth::user()->mel)
                ->value('joblvl');


        if ($districtAccess != null) {
            $parameters['districts'] = Parameter::where('grp', 'district')
                ->where('code', $districtAccess)
                ->pluck('prm', 'code')
                ->toArray();
            $parameters['subdistricts'] = Parameter::where('grp', 'subdistrict')
                ->where('etc', $districtAccess)
                ->pluck('prm', 'code')
                ->toArray();
        }

        // Return view with data
        return view('report.report_search', [
            'years' => $years,
            'parameters' => $parameters,
            'months' => $months,
        ]);
    }

}
