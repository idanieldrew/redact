<?php

namespace Module\Plan\Repository;

use Module\Plan\Models\PlanFeature;
use Module\Share\Repository\Repository as BaseRepository;

class PlanFeatureRepository extends BaseRepository
{
    public function model()
    {
        return PlanFeature::query();
    }
}
