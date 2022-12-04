<?php

namespace Module\Plan\Services;

use Module\Premium\Models\Plan;
use Module\Share\Service\Service as ServiceAlias;


class Service implements ServiceAlias
{

    public function model()
    {
        return Plan::query();
    }
}
