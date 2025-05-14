<?php

namespace App\Services;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use App\Models\Institute;
use App\Models\Parameter;
use App\Models\FinancialStatement;

class FinancialStatementService
{
    protected DistrictAccessService $districtAccessService;

    public function __construct(DistrictAccessService $districtAccessService)
    {
        $this->districtAccessService = $districtAccessService;
    }


    public function applyFilters($query, Request $request)
    {

        $query->join('client', 'splk_submission.inst_refno', '=', 'client.uid')
            ->select('splk_submission.*', 'client.name', 'client.rem8');

        $districtAccess = $this->districtAccessService->getDistrictAccess();

        if ($districtAccess !== null) {
            $query->where('client.rem8', $districtAccess);
        }



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


    public function transformFinancialStatementRelations($financialStatement)
    {
        $financialStatement->CATEGORY = $this->getParameter($financialStatement->Category);
        $financialStatement->INSTITUTE = isset($financialStatement->Institute->name) ? strtoupper($financialStatement->Institute->name) : null;
        $financialStatement->OFFICER = isset($financialStatement->Institute->con1) ? strtoupper($financialStatement->Institute->con1) : null;
        $financialStatement->DISTRICT = $this->getParameter($financialStatement->Institute->District);
        $financialStatement->SUBDISTRICT = $this->getParameter($financialStatement->Institute->Subdistrict);
        $financialStatement->SUBMISSION_DATE = date('d-m-Y', strtotime($financialStatement->submission_date));
        $financialStatement->FIN_STATUS = $this->getFinStatus($financialStatement->status);
        $financialStatement->INSTITUTE_TYPE = Parameter::where('code', $financialStatement->institute_type)->value('prm');

        return $financialStatement;
    }

    public function getParameter($relation)
    {
        return isset($relation->prm) ? strtoupper($relation->prm) : null;
    }

    public function getFinStatus($status)
    {
        return Parameter::where('grp', 'splkstatus')
            ->where('val', $status)
            ->pluck('prm', 'val')
            ->map(fn ($prm, $val) => ['val' => $val, 'prm' => $prm])
            ->first();
    }
}
