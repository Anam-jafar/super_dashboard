<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Models\FinancialStatement;
use App\Models\Institute;
use App\Models\Parameter;
use App\Services\DistrictAccessService;
use App\Services\FinancialStatementService;

class ReportController extends Controller
{
    protected $districtAccessService;

    public function __construct(DistrictAccessService $districtAccessService, FinancialStatementService $financialStatementService)
    {
        $this->financialStatementService = $financialStatementService;
        $this->districtAccessService = $districtAccessService;
    }

    public function applyFilters($query, Request $request)
    {
        $districtAccess = $this->districtAccessService->getDistrictAccess();

        if (!is_null($districtAccess)) {
            $query->where('c.rem8', $districtAccess);
        }

        foreach ($request->all() as $field => $value) {
            if (isset($value)) {
                if (\Schema::hasColumn('splk_submission', $field)) {
                    $query->where("s.$field", $value);
                } elseif (\Schema::hasColumn('client', $field)) {
                    $query->where("c.$field", $value);
                }
            }
        }

        if ($request->filled('search')) {
            $searchTerm = $request->input('search');
            $query->where('c.name', 'like', "%{$searchTerm}%");
        }

        return $query;
    }

    public function submissionCount(Request $request)
    {

        $perPage = $request->input('per_page', 10);
        $districtAccess = $this->districtAccessService->getDistrictAccess();

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
        if (!is_null($districtAccess)) {
            $query->where('c.rem8', $districtAccess);
        }
        $finYear = $request->filled('fin_year') ? $request->fin_year : date('Y');
        $finCategory = $request->filled('fin_category') ? $request->fin_category : 'STM01';
        $query->where('s.fin_year', $finYear)
            ->where('s.fin_category', $finCategory);
        $query->groupBy('t.prm', 's.fin_year', 's.fin_category')
            ->orderBy('t.prm');
        $entries = $query->paginate($perPage)->withQueryString();

        $entries->transform(function ($entry) {
            $entry->CATEGORY = isset($entry->cate_name) ? strtoupper($entry->cate_name) : null;
            $entry->FIN_CATEGORY = strtoupper(Parameter::where('code', $entry->fin_category)->value('prm') ?? '');
            return $entry;
        });

        $currentYear = date('Y');
        $years = array_combine(range($currentYear - 1, $currentYear - 4), range($currentYear - 1, $currentYear - 4));
        $parameters = $this->getCommon();

        return view('report.submission_count_list', [
            'years' => $years,
            'entries' => $entries,
            'parameters' => $parameters,
        ]);
    }


    public function submissionStatus(Request $request)
    {
        $perPage = $request->input('per_page', 10);

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
        $query = $this->applyFilters($query, $request);
        $query->orderBy('t.prm', 'ASC');
        $entries = $query->paginate($perPage)->withQueryString();

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
            $entry->FIN_STATUS = $this->financialStatementService->getFinStatus($entry->status);
            return $entry;
        });

        $parameters = $this->getCommon();

        $parameters = array_merge($parameters, $this->districtAccessService->fetchDistrictParameters());
        $filteredParameters = $this->fetchParameterOptions($request, [
            'cate1' => ['type_CLIENT', 'categories'],
            'rem8'  => ['subdistrict', 'subdistricts'],
        ]);
        $parameters = array_merge($parameters, $filteredParameters);

        $currentYear = date('Y');
        $years = array_combine(range($currentYear, $currentYear - 4), range($currentYear, $currentYear - 4));

        return view('report.submission_status', [
            'years' => $years,
            'entries' => $entries,
            'parameters' => $parameters,
        ]);
    }

    public function collectionAndExpense(Request $request)
    {
        $perPage = $request->input('per_page', 10);

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
        $query = $this->applyFilters($query, $request);
        $query->orderBy('t.prm', 'ASC');
        $entries = $query->paginate($perPage)->withQueryString();

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

        $currentYear = date('Y');
        $years = array_combine(range($currentYear, $currentYear - 4, -1), range($currentYear, $currentYear - 4, -1));

        $parameters = $this->getCommon();
        $parameters = array_merge($parameters, $this->districtAccessService->fetchDistrictParameters());

        return view('report.collection_expense', [
            'years' => $years,
            'entries' => $entries,
            'parameters' => $parameters,
        ]);
    }
    public function submissionDetailed(Request $request)
    {
        $perPage = $request->input('per_page', 10);

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
        $query = $this->applyFilters($query, $request);
        $query->orderBy('t.prm', 'ASC');
        $entries = $query->paginate($perPage)->withQueryString();

        $entries->transform(function ($entry) {
            foreach ($entry as $key => $value) {
                $entry->$key = strtoupper($value);
            }
            return $entry;
        });
        $entries->transform(function ($entry) {
            $entry->Kategori_laporan = strtoupper(Parameter::where('code', $entry->Kategori_laporan)->value('prm'));
            $entry->FIN_STATUS = $this->financialStatementService->getFinStatus($entry->status);
            return $entry;
        });

        $currentYear = date('Y');
        $years = array_combine(range($currentYear, $currentYear - 4, -1), range($currentYear, $currentYear - 4, -1));

        $parameters = $this->getCommon();
        $parameters = array_merge($parameters, $this->districtAccessService->fetchDistrictParameters());

        return view('report.submission_detailed', [
            'years' => $years,
            'entries' => $entries,
            'parameters' => $parameters,
        ]);
    }

    public function searchStatement(Request $request)
    {
        if ($request->isMethod('post')) {

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
            $query = $this->applyFilters($query, $request);


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
            $entries->transform(function ($entry) {
                foreach ($entry as $key => $value) {
                    $entry->$key = strtoupper($value);
                }
                return $entry;
            });
            $entries->transform(function ($entry) {
                $entry->Kategori_laporan = strtoupper(Parameter::where('code', $entry->Kategori_laporan)->value('prm'));
                $entry->FIN_STATUS = $this->financialStatementService->getFinStatus($entry->status);
                return $entry;
            });

            $currentYear = date('Y');
            $years = array_combine(range($currentYear, $currentYear - 4, -1), range($currentYear, $currentYear - 4, -1));

            $parameters = $this->getCommon();

            return view('report.search_result', [
                'years' => $years,
                'entries' => $entries,
                'parameters' => $parameters,
            ]);
        }

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

        $parameters = $this->getCommon();
        $parameters = array_merge($parameters, $this->districtAccessService->fetchDistrictParameters());

        return view('report.report_search', [
            'years' => $years,
            'parameters' => $parameters,
            'months' => $months,
        ]);
    }

}
