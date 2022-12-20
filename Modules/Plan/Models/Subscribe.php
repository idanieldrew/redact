<?php

namespace Module\Plan\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Module\Share\Traits\UseUuid;

class Subscribe extends Model
{
    use HasFactory, SoftDeletes,UseUuid;
}
