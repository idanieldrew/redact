<?php

namespace Module\Plan\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Module\Plan\Casts\DescriptionPlan;
use Module\Plan\Casts\Times;
use Module\Share\Traits\UseUuid;

class Plan extends Model
{
    use HasFactory, SoftDeletes,UseUuid;

    protected $guarded = [];

    protected $casts = [
        'description' => DescriptionPlan::class,
        'created_at' => Times::class,
        'updated_at' => Times::class,
        'deleted_at' => Times::class,
    ];

    /** relations */
    public function plan_feature()
    {
        return $this->hasOne(PlanFeature::class);
    }
}
