<?php

namespace App\Casts;

use Illuminate\Contracts\Database\Eloquent\CastsAttributes;

class ScheduleStatus implements CastsAttributes
{
    const CREATED = 0;
    const ONGOING = 1;
    const COMPLETED = 2;

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
        if ($level == ScheduleStatus::CREATED){
            return "Dibuat";
        }elseif ($level == ScheduleStatus::ONGOING){
            return "Dalam Proses";
        }elseif ($level == ScheduleStatus::COMPLETED){
            return "Selesai";
        }else{
            return  FALSE;
        }
    }
}
