<?php

namespace Module\Status\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Module\Share\Traits\UseUuid;

class Status extends Model
{
    use HasFactory, UseUuid;

    protected $guarded = [];

    public function statusable(): \Illuminate\Database\Eloquent\Relations\MorphTo
    {
        return $this->morphTo();
    }
}
