<?php

namespace Module\Status\Repository\v1;

use Illuminate\Database\Eloquent\Model;
use Module\Status\Repository\StatusRepository as Repository;

class StatusRepository extends Repository
{
    /**
     * Update Status model for model
     *
     * @param Model $model
     * @param array $data
     * @return mixed
     */
    public function update(Model $model, array $data)
    {
        return $model->statuses()->update([
            'name' => $data['name'],
            'reason' => $data['reason']
        ]);
    }
}
