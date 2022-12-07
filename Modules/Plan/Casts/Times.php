<?php

namespace Module\Plan\Casts;

use Illuminate\Contracts\Database\Eloquent\CastsAttributes;
use Morilog\Jalali\Jalalian;

class Times implements CastsAttributes
{
    /**
     * Cast the given value.
     *
     * @param \Illuminate\Database\Eloquent\Model $model
     * @param string $key
     * @param mixed $value
     * @param array $attributes
     * @return mixed
     */
    public function get($model, string $key, $value, array $attributes)
    {
        if ($value) {
            $jdate = Jalalian::fromFormat('Y-m-d H:i:s', $value);
            $timestamp = $jdate->getTimestamp();
            $persion = Jalalian::fromFormat('Y-m-d H:i:s', $value)->toString();

            return array('timestamp' => $timestamp, 'org' => $value, 'jalali' => $persion);
        }
        return null;
    }

    /**
     * Prepare the given value for storage.
     *
     * @param \Illuminate\Database\Eloquent\Model $model
     * @param string $key
     * @param mixed $value
     * @param array $attributes
     * @return mixed
     */
    public function set($model, string $key, $value, array $attributes)
    {
        return $value;
    }
}
