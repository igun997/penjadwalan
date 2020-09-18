<?php

namespace App\Casts;

use Illuminate\Contracts\Database\Eloquent\CastsAttributes;

class StatusAccount implements CastsAttributes
{
    CONST INACTIVE = 0;
    CONST ACTIVE = 1;
    const DELETED = 2;

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
        if ($level == StatusAccount::ACTIVE){
            return "Aktif";
        }elseif ($level == StatusAccount::INACTIVE){
            return "Tidak Aktif";
        }elseif ($level == StatusAccount::DELETED){
            return "Di Hapus";
        }else{
            return  FALSE;
        }
    }
}
