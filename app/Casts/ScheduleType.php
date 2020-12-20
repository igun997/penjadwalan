<?php

namespace App\Casts;

use Illuminate\Contracts\Database\Eloquent\CastsAttributes;

class ScheduleType implements CastsAttributes
{
    const SIDANG_AKHIR = 3;
    const SIDANG_USULAN = 1;
    const SIDANG_KOMPREHENSIF = 2;
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
        if ($level == self::SIDANG_KOMPREHENSIF){
            return "Sidang Komprehensif";
        }elseif ($level == self::SIDANG_USULAN){
            return "Sidang Usulan Penelitian";
        }elseif ($level == self::SIDANG_AKHIR){
            return "Sidang Akhir";
        }elseif ($level == self::SEMINAR){
            return "Seminar";
        }else{
            return  FALSE;
        }
    }
}
