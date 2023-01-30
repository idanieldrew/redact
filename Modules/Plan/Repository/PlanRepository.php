<?php

namespace Module\Plan\Repository;

use Module\Plan\Models\Plan;
use Module\Share\Repository\Repository as BaseRepository;

class PlanRepository extends BaseRepository
{
    public function model()
    {
        return Plan::query();
    }
}
