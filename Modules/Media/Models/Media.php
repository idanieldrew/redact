<?php

namespace Module\Media\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Module\Media\Casts\PrivateMedia;
use Module\Share\Traits\UseUuid;

class Media extends Model
{
    use HasFactory, UseUuid;

    protected $guarded = [];

    protected $casts = [
        'files' => 'json',
        'isPrivate' => PrivateMedia::class
    ];

    /** Relations */
    public function imageable()
    {
        return $this->morphTo();
    }
}
