<?php

namespace App\Services;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use App\Models\Institute;
use App\Models\Parameter;
use App\Models\FinancialStatement;

class SubscriptionService
{
    protected DistrictAccessService $districtAccessService;

    public function __construct(DistrictAccessService $districtAccessService)
    {
        $this->districtAccessService = $districtAccessService;
    }

    public function applyFilters($query, Request $request)
    {

        $districtAccess = $this->districtAccessService->getDistrictAccess();
        if ($districtAccess !== null) {
            $query->where('rem8', $districtAccess);
        }
        foreach ($request->all() as $field => $value) {
            // Use isset() instead of !empty() to allow filtering when value is 0
            if (isset($value) && \Schema::hasColumn('client', $field)) {
                $query->where($field, $value);
            }
        }

        if ($request->filled('search')) {
            $searchTerm = $request->input('search');
            $query->where('name', 'like', "%{$searchTerm}%");
        }

        return $query;
    }

    public function transformRelations($subscription, $withCollection = false)
    {
        $subscription->NAME = isset($subscription->name) ? strtoupper($subscription->name) : null;
        $subscription->TYPE = $this->getParameter($subscription->Type);
        $subscription->DISTRICT = $this->getParameter($subscription->District);
        $subscription->SUBDISTRICT = $this->getParameter($subscription->Subdistrict);
        $subscription->CATEGORY = $this->getParameter($subscription->Category);
        $subscription->SUBSCRIPTION_DATE = date('d-m-Y', $subscription->subscription_request_date);
        $subscription->SUBSCRIPTION_STATUS = $this->getSubscriptionStatus($subscription->subscription_status); // fixed this line

        if ($withCollection) {
            $latestSubmission = DB::table('splk_submission')
                ->where('inst_refno', $subscription->uid)
                ->where('fin_category', 'STM02')
                ->orderByDesc('fin_year')
                ->limit(1)
                ->first(['total_income', 'fin_year']);

            $subscription->COLLECTION = [
                'TOTAL_COLLECTION' => $latestSubmission->total_income ?? null,
                'FIN_YEAR' => $latestSubmission->fin_year ?? null,
            ];
        }

        return $subscription;
    }

    public function getParameter($relation)
    {
        return isset($relation->prm) ? strtoupper($relation->prm) : null;
    }

    public function getSubscriptionStatus($status)
    {
        return Parameter::where('grp', 'subscriptionstatus')
            ->where('val', $status)
            ->pluck('prm', 'val')
            ->map(fn ($prm, $val) => ['val' => $val, 'prm' => $prm])
            ->first();
    }

}
