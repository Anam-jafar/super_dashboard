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
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\GenericExport;

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

        $finYear = $request->filled('fin_year') ? $request->fin_year : date('Y');
        $finCategory = $request->filled('fin_category') ? $request->fin_category : 'STM01';


        // Create a base query that starts with institution types
        $query = DB::table('type as t')
            ->selectRaw("
                    t.prm AS cate_name,
                    '{$finYear}' AS fin_year,
                    '{$finCategory}' AS fin_category,
                    COALESCE(sub.total_submission, 0) AS total_submission,
                    COALESCE(sub.unsubmitted, 0) AS unsubmitted,
                    COALESCE(sub.total_telah_hantar, 0) AS total_telah_hantar,
                    COALESCE(sub.total_diterima, 0) AS total_diterima,
                    COALESCE(sub.total_ditolak_belum_hantar, 0) AS total_ditolak_belum_hantar,
                    COALESCE(sub.total_ditolak_dan_hantar, 0) AS total_ditolak_dan_hantar
                ")
                        ->where('t.grp', 'clientcate1')
                        ->leftJoin(DB::raw("(
                    SELECT
                        c.cate1,
                        COUNT(DISTINCT CASE WHEN s.status IN (1, 2) THEN s.inst_refno END) AS total_submission,
                        ((SELECT COUNT(*) FROM client c2 WHERE c2.cate1 = c.cate1 AND c2.sta = 0 AND c2.app = 'CLIENT' AND c2.isdel = 0) - 
                            COUNT(DISTINCT CASE WHEN s.status IN (1, 2) THEN s.inst_refno END)) AS unsubmitted,
                        COUNT(DISTINCT CASE WHEN s.status = 1 THEN s.inst_refno END) AS total_telah_hantar,
                        COUNT(DISTINCT CASE WHEN s.status = 2 THEN s.inst_refno END) AS total_diterima,
                        COUNT(DISTINCT CASE 
                            WHEN s.status = 3 AND NOT EXISTS (
                                SELECT 1 
                                FROM splk_submission s2
                                WHERE s2.inst_refno = s.inst_refno
                                AND s2.fin_year = s.fin_year
                                AND s2.fin_category = s.fin_category
                                AND s2.status IN (1,2)
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
                                AND s2.status IN (1,2)
                                AND s2.id > s.id
                            )
                            THEN s.inst_refno 
                        END) AS total_ditolak_dan_hantar
                    FROM client c
                    LEFT JOIN splk_submission s ON c.uid = s.inst_refno 
                        AND s.fin_year = '{$finYear}'
                        AND s.fin_category = '{$finCategory}'
                    WHERE c.sta = 0 AND c.app = 'CLIENT' AND c.isdel = 0
                    " . (!is_null($districtAccess) ? " AND c.rem8 = '{$districtAccess}'" : "") . "
                    GROUP BY c.cate1
                ) as sub"), 't.code', '=', 'sub.cate1')
            ->orderBy('t.prm');


        $isExcel = $request->boolean('excel', false);

        // If Excel requested, export and return here
        if ($isExcel) {
            $entries = $query->get();

            $headings = ['Institusi', 'Tahun', 'Kategori Penyata', 'Telah Hantar Penyata', 'Belum Hantar Penyata'];

            $data = $entries->map(function ($entry) {
                return [
                    strtoupper($entry->cate_name),
                    $entry->fin_year,
                    strtoupper(Parameter::where('code', $entry->fin_category)->value('prm') ?? ''),
                    $entry->total_submission,
                    $entry->unsubmitted,
                ];
            })->toArray();

            return Excel::download(new GenericExport($headings, $data), 'Jumlah Penghantaran.xlsx');
        }

        $entries = $query->paginate($perPage)->withQueryString();

        $entries->transform(function ($entry) {
            $entry->CATEGORY = isset($entry->cate_name) ? strtoupper($entry->cate_name) : null;
            $entry->FIN_CATEGORY = strtoupper(Parameter::where('code', $entry->fin_category)->value('prm') ?? '');
            $entry->JUMLAH_1 = $entry->total_submission + $entry->unsubmitted;
            $entry->JUMLAH_2 = $entry->total_telah_hantar + $entry->total_diterima;
            $entry->JUMLAH_3 = $entry->total_ditolak_belum_hantar + $entry->total_ditolak_dan_hantar;
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

    public function filteredSubmission(Request $request)
    {
        $perPage = $request->input('per_page', 10);

        $query = DB::table('splk_submission as s')->join('client as c', 'c.uid', '=', 's.inst_refno')
                    ->selectRaw("
                       s.fin_year AS fin_year, s.id AS id, t.prm AS cate_name, t1.prm AS district, t2.prm AS subdistrict, t3.prm AS fin_category, c.name AS institute_name, c.con1 as officer, s.submission_date AS date, s.status AS status")
                    ->join('type as t', function ($join) {
                        $join->on('c.cate', '=', 't.code')
                             ->where('t.grp', '=', 'type_client');
                    })
                    ->join('type as t1', function ($join) {
                        $join->on('c.rem8', '=', 't1.code')
                            ->where('t1.grp', '=', 'district');
                    })
                    ->join('type as t2', function ($join) {
                        $join->on('c.rem9', '=', 't2.code')
                            ->where('t2.grp', '=', 'subdistrict');
                    })
                    ->join('type as t3', function ($join) {
                        $join->on('s.fin_category', '=', 't3.code')
                            ->where('t3.grp', '=', 'statement');
                    });


        // Apply status filter if provided

        if ($request->filled('status')) {
            $statuses = explode(',', $request->input('status'));
            $query->whereIn('s.status', $statuses);
        }

        // Handle cate1 filter (convert prm to code)
        if ($request->filled('category')) {
            $cate1Code = Parameter::where('grp', 'clientcate1')->where('prm', $request->category)->value('code');
            if ($cate1Code) {
                $request->merge(['cate1' => $cate1Code]);
            }
        }

        if ($request->filled('fin_year')) {
            $query->where('s.fin_year', $request->fin_year);
        }

        if ($request->filled('fin_category')) {
            $query->where('s.fin_category', $request->fin_category);
        }

        if ($request->filled('category')) {
            $query->where('c.cate1', $cate1Code);
        }


        $isExcel = $request->boolean('excel', false);


        // 🔻 If Excel requested, export and return here
        if ($isExcel) {
            $entries = $query->get();

            $headings = ['Tarikh Hantar', 'Tahun Penyata', 'Kategori Penyata', 'Daerah', 'Mukim', 'Nama Institusi', 'Wakil Institusi', 'Status'];

            $data = $entries->map(function ($entry) {
                return [
                    date('d-m-Y', strtotime($entry->date)),
                    $entry->fin_year,
                    strtoupper($entry->fin_category),
                    strtoupper($entry->district),
                    strtoupper($entry->subdistrict),
                    strtoupper($entry->institute_name),
                    strtoupper($entry->officer),
                    $this->financialStatementService->getFinStatus($entry->status)['prm']
                ];
            })->toArray();

            return Excel::download(new GenericExport($headings, $data), 'Jumlah Penghantaran.xlsx');
        }

        $entries = $query
            ->orderBy('id', 'desc')
            ->paginate($perPage)->withQueryString();

        $entries->transform(function ($financialStatement) {
            $financialStatement->CATEGORY = strtoupper($financialStatement->fin_category);
            $financialStatement->INSTITUTE = strtoupper($financialStatement->institute_name);
            $financialStatement->OFFICER = strtoupper($financialStatement->officer);
            $financialStatement->DISTRICT = strtoupper($financialStatement->district);
            $financialStatement->SUBDISTRICT = strtoupper($financialStatement->subdistrict);
            $financialStatement->SUBMISSION_DATE = date('d-m-Y', strtotime($financialStatement->date));
            $financialStatement->FIN_STATUS = $this->financialStatementService->getFinStatus($financialStatement->status);
            return $financialStatement;
        });

        return view('report.filtered_submission', [
            'entries' => $entries,
        ]);

    }


    public function submissionStatus(Request $request)
    {
        $perPage = $request->input('per_page', 10);

        $query = DB::table('splk_submission as s')
            ->selectRaw("t.prm AS Jenis_Institusi, c.name AS Nama_institusi, 
            s.fin_year AS Tahun_Laporan, s.submission_date AS Tarikh_Hantar, 
            s.fin_category AS Kategori_laporan, t1.prm AS Daerah, 
            s.balance_forward AS Balance_forward, s.total_income AS Total_income, s.total_surplus AS Total_surplus,
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

        $finCategory = $request->filled('fin_category') ? $request->fin_category : 'STM02';
        $query->where('s.fin_category', $finCategory);

        $query = $this->applyFilters($query, $request);
        $query->orderBy('t.prm', 'ASC');

        $isExcel = $request->boolean('excel', false);

        // 🔻 If Excel requested, export and return here
        if ($isExcel) {
            $entries = $query->get();

            $headings = [
                'Jenis Institusi',
                'Nama Institusi',
                'Tahun Laporan',
                'Tarikh Hantar',
                'Kategori Laporan',
                'Daerah',
                'Baki bawa kehadapan 1 januari',
                'Jumlah Kutipan',
                'Jumlah Perbelanjaan',
                'Jumlah Pendapatan',
                'Jumlah Lebihan/Kurangan Tahun Semasa',
                'Maklumat Baki Bank Dan Tunai',
                'Status'
            ];

            $data = $entries->map(function ($entry) {
                return [
                    strtoupper($entry->Jenis_Institusi),
                    strtoupper($entry->Nama_institusi),
                    $entry->Tahun_Laporan,
                    strtoupper($entry->Tarikh_Hantar),
                    strtoupper(Parameter::where('code', $entry->Kategori_laporan)->value('prm') ?? ''),
                    strtoupper($entry->Daerah),
                    'RM '.number_format($entry->Balance_forward, 2, '.', ','),
                    'RM '.number_format($entry->Jumlah_kutipan, 2, '.', ','),
                    'RM '.number_format($entry->Jumlah_Belanja, 2, '.', ','),
                    'RM '.number_format($entry->Total_income, 2, '.', ','),
                    'RM '.number_format($entry->Total_surplus, 2, '.', ','),
                    'RM '.number_format($entry->Jumlah_Baki_Bank, 2, '.', ','),
                    $this->financialStatementService->getFinStatus($entry->status)['prm']
                ];
            })->toArray();


            return Excel::download(new GenericExport($headings, $data), 'Status Penghantaran.xlsx');
        }

        $entries = $query->paginate($perPage)->withQueryString();

        $entries->transform(function ($entry) {
            $entry->CATEGORY = strtoupper($entry->Jenis_Institusi);
            $entry->NAME = strtoupper($entry->Nama_institusi);
            $entry->YEAR = strtoupper($entry->Tahun_Laporan);
            $entry->DATE = strtoupper($entry->Tarikh_Hantar);
            $entry->STATEMENT = strtoupper(Parameter::where('code', $entry->Kategori_laporan)->value('prm'));
            $entry->DISTRICT = strtoupper($entry->Daerah);
            $entry->JUMLAH_KUTIPAN = 'RM '.number_format($entry->Jumlah_kutipan, 2, '.', ',');
            $entry->JUMLAH_BELANJA = 'RM '.number_format($entry->Jumlah_Belanja, 2, '.', ',');
            $entry->JUMLAH_BAKI_BANK = 'RM '.number_format($entry->Jumlah_Baki_Bank, 2, '.', ',');
            $entry->BALANCE_FORWARD = 'RM '.number_format($entry->Balance_forward, 2, '.', ',');
            $entry->TOTAL_INCOME = 'RM '.number_format($entry->Total_income, 2, '.', ',');
            $entry->TOTAL_SURPLUS = 'RM '.number_format($entry->Total_surplus, 2, '.', ',');
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
            s.balance_forward AS Balance_forward, s.total_surplus AS Total_surplus,
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

        $finCategory = $request->filled('fin_category') ? $request->fin_category : 'STM02';
        $query->where('s.fin_category', $finCategory);

        $query = $this->applyFilters($query, $request);
        $query->orderBy('t.prm', 'ASC');


        $isExcel = $request->boolean('excel', false);

        // 🔻 If Excel requested, export and return here
        if ($isExcel) {
            $entries = $query->get();

            $headings = [
                'Jenis Institusi',
                'Nama Institusi',
                'Tahun Laporan',
                'Kategori Laporan',
                'Daerah',
                'Baki bawa kehadapan 1 januari',
                'Jumlah Kutipan',
                'Jumlah Perbelanjaan',
                'Jumlah Pendapatan',
                'Jumlah Lebihan/Kurangan Tahun Semasa',
                'Maklumat Baki Bank Dan Tunai',
            ];

            $data = $entries->map(function ($entry) {
                return [
                    strtoupper($entry->Jenis_Institusi),
                    strtoupper($entry->Nama_institusi),
                    $entry->Tahun_Laporan,
                    strtoupper(Parameter::where('code', $entry->Kategori_laporan)->value('prm') ?? ''),
                    strtoupper($entry->Daerah),
                    'RM '.number_format($entry->Balance_forward, 2, '.', ','),
                    'RM '.number_format($entry->Jumlah_kutipan, 2, '.', ','),
                    'RM '.number_format($entry->Jumlah_Belanja, 2, '.', ','),
                    'RM '.number_format($entry->Jumlah_Pendapatan, 2, '.', ','),
                    'RM '.number_format($entry->Total_surplus, 2, '.', ','),
                    'RM '.number_format($entry->Jumlah_Baki_Diisytihar, 2, '.', ','),
                ];
            })->toArray();


            return Excel::download(new GenericExport($headings, $data), 'Kutipan Perbelanjaan.xlsx');
        }

        $entries = $query->paginate($perPage)->withQueryString();

        $entries->transform(function ($entry) {
            foreach ($entry as $key => $value) {
                $entry->$key = strtoupper($value);
            }
            return $entry;
        });
        $entries->transform(function ($entry) {
            $entry->Kategori_laporan = strtoupper(Parameter::where('code', $entry->Kategori_laporan)->value('prm'));
            $entry->Jumlah_kutipan = 'RM '.number_format($entry->Jumlah_kutipan, 2, '.', ',');
            $entry->Jumlah_Belanja = 'RM '.number_format($entry->Jumlah_Belanja, 2, '.', ',');
            $entry->Jumlah_Pendapatan = 'RM '.number_format($entry->Jumlah_Pendapatan, 2, '.', ',');
            $entry->Jumlah_Baki_Diisytihar = 'RM '.number_format($entry->Jumlah_Baki_Diisytihar, 2, '.', ',');
            $entry->BALANCE_FORWARD = 'RM '.number_format($entry->Balance_forward, 2, '.', ',');
            $entry->TOTAL_SURPLUS = 'RM '.number_format($entry->Total_surplus, 2, '.', ',');

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


        $isExcel = $request->boolean('excel', false);


        // 🔻 If Excel requested, export and return here
        if ($isExcel) {
            $entries = $query->get();

            $headings = ['Jenis Institusi', 'Nama Institusi', 'Tahun Laporan', 'Tarikh Hantar', 'Kategori Laporan', 'Daerah', 'Status'];

            $data = $entries->map(function ($entry) {
                return [
                    strtoupper($entry->Jenis_Institusi),
                    strtoupper($entry->Nama_institusi),
                    $entry->Tahun_Laporan,
                    strtoupper($entry->Tarikh_Hantar),
                    strtoupper(Parameter::where('code', $entry->Kategori_laporan)->value('prm') ?? ''),
                    strtoupper($entry->Daerah),
                    $this->financialStatementService->getFinStatus($entry->status)['prm']
                ];
            })->toArray();


            return Excel::download(new GenericExport($headings, $data), 'Perincian Penghantaran.xlsx');
        }

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


            $filters = $request->all();


            return view('report.search_result', [
                'years' => $years,
                'entries' => $entries,
                'parameters' => $parameters,
                'filters' => $filters,

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

    public function exportStatementReport(Request $request)
    {

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

        $entries = $query->get();

        $headings = ['Jenis Institusi', 'Nama Institusi', 'Tahun Laporan', 'Tarikh Hantar', 'Kategori Laporan', 'Daerah', 'Status'];

        $data = $entries->map(function ($entry) {
            return [
                strtoupper($entry->Jenis_Institusi),
                strtoupper($entry->Nama_institusi),
                $entry->Tahun_Laporan,
                strtoupper($entry->Tarikh_Hantar),
                strtoupper(Parameter::where('code', $entry->Kategori_laporan)->value('prm') ?? ''),
                strtoupper($entry->Daerah),
                $this->financialStatementService->getFinStatus($entry->status)['prm']
            ];
        })->toArray();


        return Excel::download(new GenericExport($headings, $data), 'Laporan.xlsx');



    }



}
