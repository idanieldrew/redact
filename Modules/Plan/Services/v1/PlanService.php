<?php

namespace Module\Plan\Services\v1;

use Module\Plan\Http\Resources\v1\PlanResource;
use Module\Plan\Http\Resources\v1\PlanCollection;
use Module\Plan\Repository\v1\PlanFeaturePlanRepository;
use Module\Plan\Repository\v1\PlanPlanRepository;
use Module\Plan\Services\Service;

class PlanService extends Service
{
    protected function repo()
    {
        return resolve(PlanPlanRepository::class);
    }

    public function index()
    {
        $plans = $this->repo()->index();

        return new PlanCollection($plans);
    }

    public function store($request)
    {
        $plan = $this->repo()->store($request);
        (new PlanFeaturePlanRepository)->store($plan, $request->features);

        return new PlanResource($plan->load('plan_feature'));
    }
}
