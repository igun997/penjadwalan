<?php

namespace App\Traits;

trait ViewTrait
{
    public $base;

    public function loadView($view,$data = [])
    {
        return view($this->base.".".$view,$data);
    }
}
