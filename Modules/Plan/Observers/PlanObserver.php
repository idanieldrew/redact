<?php

namespace Module\Plan\Observers;

use Illuminate\Support\Str;
use Module\Plan\Models\Plan;

class PlanObserver
{
    public function creating(Plan $plan)
    {
        $plan->slug = Str::slug($plan->name);
    }
}
