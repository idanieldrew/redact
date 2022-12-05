<?php

namespace Module\Plan\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Module\Plan\Casts\DescriptionPlan;
use Module\User\Models\User;

class Plan extends Model
{
    use HasFactory, SoftDeletes;

    protected $guarded = [];

    protected $casts = [
        'description' => DescriptionPlan::class
    ];

    /** relations */
    public function plan_feature()
    {
        return $this->hasMany(PlanFeature::class);
    }
}
