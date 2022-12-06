<?php

namespace Module\Plan\Repository\v1;

use Illuminate\Support\Str;
use Module\Plan\Repository\PlanRepository;

class PlanPlanRepository extends PlanRepository
{
    public function store($request)
    {
        return $this->model()->create([
            'name' => $name = $request->name,
            'slug' => Str::slug($name),
            'count_account' => $request->count_account,
            'description' => $request->description,
            'price' => $request->price,
            'period' => $request->period,
            'interval' => $request->interval
        ]);
    }
}
