<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Mail\EditRequestApprove;
use Illuminate\Support\Facades\Mail;
use App\Models\FinancialStatement;
use App\Models\Institute;
use App\Models\Parameter;
use App\Services\DistrictAccessService;
use App\Services\FinancialStatementService;
use Illuminate\Support\Facades\Log;

class FinancialStatementController extends Controller
{
    protected $financialStatementService;
    protected $districtAccessService;

    public function __construct(FinancialStatementService $financialStatementService, DistrictAccessService $districtAccessService)
    {
        $this->financialStatementService = $financialStatementService;
        $this->districtAccessService = $districtAccessService;
    }

    public function review(Request $request, $id)
    {
        $financialStatement = FinancialStatement::find($id);

        if ($request->isMethod('post')) {

            $validatedData = $request->validate([
                'status' => 'required',
                'cancel_reason_adm' => 'nullable',
                'suggestion_adm' => 'nullable',
            ]);

            $validatedData['verified_by'] = Auth::user()->uid;
            $validatedData['verified_at'] = now();
            if (!$financialStatement) {
                return redirect()->route('statementList')->with('error', 'Financial Statement not found');
            }

            $financialStatement->update($validatedData);

            return redirect()->route('statementList')->with('success', 'Laporan Kewangan Telah Berjaya Dihantar');
        }
        $financialStatement->SUBMISSION_DATE = date('d-m-Y', strtotime($financialStatement->submission_date));
        $financialStatement->FIN_STATUS = $this->financialStatementService->getFinStatus($financialStatement->status);
        $financialStatement->INSTITUTE = Parameter::where('code', $financialStatement->institute)->value('prm');
        $financialStatement->INSTITUTE_TYPE = Parameter::where('code', $financialStatement->institute_type)->value('prm');
        $institute = Institute::where('uid', $financialStatement->inst_refno)->first();
        $instituteType = (int) DB::table('type')
            ->where('grp', 'type_CLIENT')
            ->where('code', $financialStatement->institute_type)
            ->value('lvl');

        $currentYear = date('Y');
        $years = array_combine(range($currentYear - 3, $currentYear + 1), range($currentYear - 3, $currentYear + 1));

        $parameters = $this->getCommon();
        return view('financial_statement.review', compact(['institute', 'instituteType', 'years', 'parameters', 'financialStatement']));
    }

    public function list(Request $request)
    {
        $perPage = $request->input('per_page', 10);
        $query = FinancialStatement::with('Institute')->whereIn('status', [1, 4]);
        $query = $this->financialStatementService->applyFilters($query, $request);
        $financialStatements = $query
            ->orderBy('id', 'desc')
            ->paginate($perPage)->withQueryString();
        $financialStatements->getCollection()->transform(function ($financialStatement) {
            return $this->financialStatementService->transformFinancialStatementRelations($financialStatement);
        });

        $currentYear = date('Y');
        $years = array_combine(range($currentYear - 3, $currentYear + 3), range($currentYear - 3, $currentYear + 3));

        $parameters = $this->getCommon();
        $parameters = array_merge($parameters, $this->districtAccessService->fetchDistrictParameters());
        $filteredParameters = $this->fetchParameterOptions($request, [
            'cate1' => ['type_CLIENT', 'categories'],
            'rem8'  => ['subdistrict', 'subdistricts'],
        ]);
        $parameters = array_merge($parameters, $filteredParameters);

        return view('financial_statement.list', [
            'parameters' => $parameters,
            'financialStatements' => $financialStatements,
            'years' => $years,
        ]);
    }

    public function view(Request $request, $id)
    {
        $financialStatement = FinancialStatement::with('VerifiedBy')->find($id);
        $financialStatement->SUBMISSION_DATE = date('d-m-Y', strtotime($financialStatement->submission_date));
        $financialStatement->FIN_STATUS = $this->financialStatementService->getFinStatus($financialStatement->status);
        $financialStatement->INSTITUTE = Parameter::where('code', $financialStatement->institute)->value('prm');
        $financialStatement->INSTITUTE_TYPE = Parameter::where('code', $financialStatement->institute_type)->value('prm');

        $institute = Institute::where('uid', $financialStatement->inst_refno)->first();

        $instituteType = (int) DB::table('type')
            ->where('grp', 'type_CLIENT')
            ->where('code', $financialStatement->institute_type)
            ->value('lvl');

        $currentYear = date('Y');
        $years = array_combine(range($currentYear - 3, $currentYear + 1), range($currentYear - 3, $currentYear + 1));

        $parameters = $this->getCommon();
        return view('financial_statement.view', compact(['institute', 'instituteType', 'years', 'parameters', 'financialStatement']));
    }

    public function reviewedList(Request $request)
    {
        $perPage = $request->input('per_page', 10);
        $query = FinancialStatement::with('Institute')->whereNotIn('status', [0,  4]);
        $query = $this->financialStatementService->applyFilters($query, $request);
        $financialStatements = $query
            ->orderBy('id', 'desc')
            ->paginate($perPage)->withQueryString();
        $financialStatements->getCollection()->transform(function ($financialStatement) {
            return $this->financialStatementService->transformFinancialStatementRelations($financialStatement);
        });

        $currentYear = date('Y');
        $years = array_combine(range($currentYear - 3, $currentYear + 3), range($currentYear - 3, $currentYear + 3));

        $parameters = $this->getCommon();
        $parameters = array_merge($parameters, $this->districtAccessService->fetchDistrictParameters());
        $filteredParameters = $this->fetchParameterOptions($request, [
            'cate1' => ['type_CLIENT', 'categories'],
            'rem8'  => ['subdistrict', 'subdistricts'],
        ]);
        $parameters = array_merge($parameters, $filteredParameters);

        return view('financial_statement.reviewed_statement_list', [
            'parameters' => $parameters,
            'financialStatements' => $financialStatements,
            'years' => $years,
        ]);
    }

    public function approveEditRequest(Request $request, $id)
    {
        $financialStatement = FinancialStatement::find($id);
        if (!$financialStatement) {
            return redirect()->route('statementList')->with('error', 'Financial Statement not found');
        }

        $financialStatement->update(['status' => 0,
            'submission_date' => null,
            'verified_by' => null,
            'verified_at' => null,
            'request_edit_date' => null,
            'request_edit_reason' => null]);

        $institute = Institute::where('uid', $financialStatement->inst_refno)->first();
        $fin_category = Parameter::where('code', $financialStatement->fin_category)->value('prm');
        try {
            Mail::to($institute->mel)->send(new EditRequestApprove($institute->name, $fin_category, $financialStatement->fin_year));
        } catch (\Exception $e) {
            Log::error('Failed to send financial statement edit approval confirmation email', [
                'email' => $request->mel,
                'error' => $e->getMessage(),
            ]);
        }

        return redirect()->route('statementList')->with('success', 'Permintaan suntingan Penyata Kewangan diluluskan.');
    }
}
