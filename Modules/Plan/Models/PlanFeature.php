<?php

namespace Module\Plan\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Module\Plan\Casts\DescriptionPlan;
use Module\Share\Traits\UseUuid;

class PlanFeature extends Model
{
    use HasFactory, SoftDeletes,UseUuid;

    protected $guarded = [];

    protected $casts = [
        'description' => DescriptionPlan::class
    ];
}
