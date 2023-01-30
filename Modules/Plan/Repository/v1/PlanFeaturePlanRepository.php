<?php

namespace Module\Plan\Repository\v1;

use Module\Plan\Models\Plan;
use Module\Plan\Repository\PlanFeatureRepository;

class PlanFeaturePlanRepository extends PlanFeatureRepository
{
    public function store(Plan $plan, $request)
    {
        return $plan->plan_feature()->create([
            'description' => $request,
        ]);
    }
}
