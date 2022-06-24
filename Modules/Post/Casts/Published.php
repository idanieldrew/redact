<?php

namespace Module\Post\Casts;

use Illuminate\Contracts\Database\Eloquent\CastsAttributes;
use Illuminate\Database\Eloquent\Model;

class Published implements CastsAttributes
{
    /**
     * Cast the given value.
     *
     * @param  Model $model
     * @param  string $key
     * @param  mixed $value
     * @param  array $attributes
     * @return string
     */
    public function get($model, string $key, $value, array $attributes): string
    {
        if ($value) {
            return 'published';
        }
        return 'no published';
    }

    /**
     * Prepare the given value for storage.
     *
     * @param  Model $model
     * @param  string $key
     * @param  mixed $value
     * @param  array $attributes
     * @return mixed
     */
    public function set($model, string $key, $value, array $attributes)
    {
        return $value;
    }
}
