<?php

namespace App\Casts;

use Illuminate\Contracts\Database\Eloquent\CastsAttributes;

class LevelAccount implements CastsAttributes
{
    const  ADMIN = 0;
    const  SEKRETARIAT = 1;
    const  MAHASISWA = 2;
    const  DOSEN = 3;
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
        if ($level == LevelAccount::ADMIN){
            return "Admninistrator";
        }elseif ($level == LevelAccount::SEKRETARIAT){
            return "Sekretariat";
        }elseif ($level == LevelAccount::MAHASISWA){
            return "Mahasiswa";
        }else{
            return  FALSE;
        }
    }

    public static function redirect()
    {
        return route("dashboard");
    }

}
