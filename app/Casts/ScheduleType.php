<?php

namespace App\Casts;

use Illuminate\Contracts\Database\Eloquent\CastsAttributes;

class ScheduleType implements CastsAttributes
{
    const SIDANG = 1;
    const SEMINAR = 0;

    /**
     * Cast the given value.
     *
     * @param  \Illuminate\Database\Eloquent\Model  $model
     * @param  string  $key
     * @param  mixed  $value
     * @param  array  $attributes
     * @return mixed
     */
    public function get($model, $key, $value, $attributes)
    {
        return $value;
    }

    /**
     * Prepare the given value for storage.
     *
     * @param  \Illuminate\Database\Eloquent\Model  $model
     * @param  string  $key
     * @param  array  $value
     * @param  array  $attributes
     * @return mixed
     */
    public function set($model, $key, $value, $attributes)
    {
        return $value;
    }
    public static function lang($level)
    {
        if ($level == ScheduleType::SEMINAR){
            return "Seminar";
        }elseif ($level == StatusAccount::SIDANG){
            return "Sidang";
        }else{
            return  FALSE;
        }
    }
}
