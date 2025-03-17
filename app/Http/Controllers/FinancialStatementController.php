<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

use App\Models\FinancialStatement;
use App\Models\Institute;

class FinancialStatementController extends Controller
{
    private function validateFinancialStatement(Request $request): array
    {
        $rules = [
            'inst_refno' => 'nullable',
            'fin_year' => 'nullable',
            'fin_category' => 'nullable',
            'latest_contruction_progress' => 'nullable',
            'ori_contruction_cost' => 'nullable',
            'variation_order' => 'nullable',
            'current_collection' => 'nullable',
            'total_collection' => 'nullable',
            'total_statement' => 'nullable',
            'transfer_pws' => 'nullable',
            'contruction_expenses' => 'nullable',
            'inst_surplus' => 'nullable',
            'pws_surplus' => 'nullable',
            'pws_expenses' => 'nullable',
            'balance_forward' => 'nullable',
            'total_expenses' => 'nullable',
            'total_income' => 'nullable',
            'total_surplus' => 'nullable',
            'bank_cash_balance' => 'nullable',
            'attachment1_info' => 'nullable',
            'attachment1' => 'required|file|mimes:pdf|max:2048',
            'attachment2' => 'required|file|mimes:pdf|max:2048',
            'attachment3' => 'required|file|mimes:pdf|max:2048',
    ];
    

        return Validator::make($request->all(), $rules)->validate();
    }

    private function generateUniqueUid()
    {
        $lastUid = DB::table('client')->orderBy('uid', 'desc')->value('uid');

        $numericPart = intval(substr($lastUid, 1)) ?? 0;

        do {
            $numericPart++;
            $newUid = 'C' . str_pad($numericPart, 5, '0', STR_PAD_LEFT);
            $exists = DB::table('client')->where('uid', $newUid)->exists();

        } while ($exists); 

        return $newUid;
    }

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



    public function create(Request $request, $inst_refno)
    {
        if($request->isMethod('post')){
            $validatedData = $this->validateFinancialStatement($request);

            if($request['draft'] == "true"){
                $validatedData['status'] = 0;
            
            }else{
                $validatedData['status'] = 1;
                $validatedData['submission_date'] = date('Y-m-d H:i:s');
            }
            $financialStatement = FinancialStatement::create($validatedData);

            if($financialStatement){
                return redirect()->route('statementList')->with('success', 'Financial Statement created successfully');
            }


        }
        $institute = Institute::where('uid', $inst_refno)->first();
        $instituteType = $institute->Category->lvl;
        $currentYear = date('Y');
        $years = array_combine(range($currentYear - 3, $currentYear + 1), range($currentYear - 3, $currentYear + 1));

        $parameters = $this->getCommon();
        return view('financial_statement.create', compact(['institute', 'instituteType', 'years', 'parameters']));
    }

    public function edit(Request $request, $id)
    {
        if ($request->isMethod('post')) {
            $validatedData = $this->validateFinancialStatement($request);

            $financialStatement = FinancialStatement::with('AuditType')->find($id);

            if (!$financialStatement) {
                return redirect()->route('statementList')->with('error', 'Financial Statement not found');
            }

            if ($request['draft'] == "true") {
                $validatedData['status'] = 0;
            } else {
                $validatedData['status'] = 1;
                $validatedData['submission_date'] = now();
            }

            $financialStatement->update($validatedData);

            return redirect()->route('statementList')->with('success', 'Financial Statement updated successfully');
        }

        $financialStatement = FinancialStatement::find($id);
        $institute = Institute::where('uid', $financialStatement->inst_refno)->first();
        $instituteType = $institute->Category->lvl;
        $currentYear = date('Y');
        $years = array_combine(range($currentYear - 3, $currentYear + 1), range($currentYear - 3, $currentYear + 1));

        $parameters = $this->getCommon();
        return view('financial_statement.edit', compact(['institute', 'instituteType', 'years', 'parameters', 'financialStatement']));
    }

    public function review(Request $request, $id)
    {
        $financialStatement = FinancialStatement::find($id);

        if ($request->isMethod('post')) {

            $validatedData = $request->validate([
                'status' => 'nullable',
                'cancel_reason_adm' => 'nullable',
                'suggestion_adm' => 'nullable',
            ]);
            if (!$financialStatement) {
                return redirect()->route('statementList')->with('error', 'Financial Statement not found');
            }

            $financialStatement->update($validatedData);

            return redirect()->route('statementList')->with('success', 'Financial Statement updated successfully');
        }
        $institute = Institute::where('uid', $financialStatement->inst_refno)->first();
        $instituteType = $institute->Category->lvl;
        $currentYear = date('Y');
        $years = array_combine(range($currentYear - 3, $currentYear + 1), range($currentYear - 3, $currentYear + 1));

        $parameters = $this->getCommon();
        return view('financial_statement.review', compact(['institute', 'instituteType', 'years', 'parameters', 'financialStatement']));
    }

    public function list(Request $request)
    {
        $perPage = $request->input('per_page', 10);

        $query = FinancialStatement::where('status', 1);

        $query = $this->applyFilters($query, $request);

        $financialStatements = $query
            ->orderBy('id', 'desc')
            ->paginate($perPage)->withQueryString();

        
            $financialStatements->getCollection()->transform(function ($financialStatement) {
            $financialStatement->CATEGORY = $financialStatement->Category->prm ?? null;
            $financialStatement->INSTITUTE = $financialStatement->Institute->name ?? null;
            $financialStatement->OFFICER = $financialStatement->Institute->con1 ?? null;
            $financialStatement->FINSUBMISSIONSTATUS = $financialStatement->status ?? null;
            $financialStatement->DISTRICT = $financialStatement->Institute->District->prm ?? null;
            return $financialStatement;
        });

        $currentYear = date('Y');
        $years = array_combine(range($currentYear - 3, $currentYear + 3), range($currentYear - 3, $currentYear + 3));

        return view('financial_statement.list', [
            'parameters' => $this->getCommon(),
            'financialStatements' => $financialStatements,
            'years' => $years,
        ]);
    }

    public function view(Request $request, $id)
    {
        $financialStatement = FinancialStatement::find($id);

        $institute = Institute::where('uid', $financialStatement->inst_refno)->first();
        $instituteType = $institute->Category->lvl;
        $currentYear = date('Y');
        $years = array_combine(range($currentYear - 3, $currentYear + 1), range($currentYear - 3, $currentYear + 1));

        $parameters = $this->getCommon();
        return view('financial_statement.view', compact(['institute', 'instituteType', 'years', 'parameters', 'financialStatement']));
    }

    public function reviewedList(Request $request)
    {
        $perPage = $request->input('per_page', 10);

        $query = FinancialStatement::whereNotIn('status', [0, 1]);

        $query = $this->applyFilters($query, $request);

        $financialStatements = $query
            ->orderBy('id', 'desc')
            ->paginate($perPage)->withQueryString();

        
            $financialStatements->getCollection()->transform(function ($financialStatement) {
            $financialStatement->CATEGORY = $financialStatement->Category->prm ?? null;
            $financialStatement->INSTITUTE = $financialStatement->Institute->name ?? null;
            $financialStatement->OFFICER = $financialStatement->Institute->con1 ?? null;
            $financialStatement->FINSUBMISSIONSTATUS = $financialStatement->status ?? null;
            return $financialStatement;
        });

        $currentYear = date('Y');
        $years = array_combine(range($currentYear - 3, $currentYear + 3), range($currentYear - 3, $currentYear + 3));

        return view('financial_statement.reviewed_statement_list', [
            'parameters' => $this->getCommon(),
            'financialStatements' => $financialStatements,
            'years' => $years,
        ]);
    }
}
