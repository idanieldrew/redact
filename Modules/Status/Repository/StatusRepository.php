<?php

namespace Module\Status\Repository;

use Module\Share\Repository\Repository;
use Module\Status\Models\Status;

class StatusRepository extends Repository
{

    public function model()
    {
        return Status::query();
    }
}
