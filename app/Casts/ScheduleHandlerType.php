<?php

namespace App\Casts;

use Illuminate\Contracts\Database\Eloquent\CastsAttributes;

class ScheduleHandlerType implements CastsAttributes
{
    const PEMBIMBING = 1;
    const REVIEWER_1 = 2;
    const REVIEWER_2 = 3;
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

    public static function lang($level,$mode=1)
    {
        switch ($level){
            case ScheduleHandlerType::PEMBIMBING:
                if ($mode){
                    return "Pembimbing";
                }
                return "Penguji 1";
                break;
            case ScheduleHandlerType::REVIEWER_1:
                if ($mode){
                    return "Reviewer 1";
                }

                return "Penguji 2";
                break;
            case ScheduleHandlerType::REVIEWER_2:
                if ($mode){
                    return "Reviewer 2";
                }

                return "Penguji 3";
                break;
            default:
                return "Undefined";
        }
    }
}
