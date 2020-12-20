<?php

namespace App\Casts;

use Illuminate\Contracts\Database\Eloquent\CastsAttributes;

class ScheduleStatus implements CastsAttributes
{
    const CREATED = 0;
    const ONGOING = 1;
    const COMPLETED = 2;
    const GRADUATE_SEMINAR = 3;
    const GRADUATE_SIDANG_AKHIR = 4;
    const GRADUATE_SIDANG_KOMPREHENSIF = 5;
    const GRADUATE_SIDANG_USULAN = 6;
    const UNGRADUATE_SEMINAR = 7;
    const UNGRADUATE_SIDANG_KOMPREHENSIF = 8;
    const UNGRADUATE_SIDANG_USULAN = 9;
    const UNGRADUATE_SIDANG_AKHIR = 10;

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
        if ($level == self::CREATED){
            return "Dibuat";
        }elseif ($level == self::ONGOING){
            return "Dalam Proses";
        }elseif ($level == self::GRADUATE_SEMINAR){
            return "Lulus Seminar";
        }elseif ($level == self::GRADUATE_SIDANG_AKHIR){
            return "Lulus Sidang Akhir";
        }elseif ($level == self::GRADUATE_SIDANG_KOMPREHENSIF){
            return "Lulus Sidang Komprehensif";
        }elseif ($level == self::GRADUATE_SIDANG_USULAN){
            return "Lulus Sidang Usulan";
        }elseif ($level == self::UNGRADUATE_SEMINAR){
            return "Gagal Seminar";
        }elseif ($level == self::UNGRADUATE_SIDANG_KOMPREHENSIF){
            return "Gagal Sidang Komprehensif";
        }elseif ($level == self::UNGRADUATE_SIDANG_USULAN){
            return "Gagal Sidang Usulan";
        }elseif ($level == self::UNGRADUATE_SIDANG_AKHIR){
            return "Gagal Sidang Akhir";
        }else{
            return  FALSE;
        }
    }
}
