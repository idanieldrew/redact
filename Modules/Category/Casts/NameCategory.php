<?php

namespace Module\Category\Casts;

use Illuminate\Contracts\Database\Eloquent\CastsAttributes;

class NameCategory implements CastsAttributes
{
    /**
     * Prepare the given value for storage.
     *
     * @param  \Illuminate\Database\Eloquent\Model  $model
     * @param  string  $key
     * @param  mixed  $value
     * @param  array  $attributes
     * @return mixed
     */
    public function set($model, string $key, $value, array $attributes)
    {
        return $value;
    }

    public function get($model, string $key, $value, array $attributes)
    {
        // TODO: Implement get() method.
    }
}
