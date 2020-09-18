<?php

namespace App\Traits;

trait ViewTrait
{
    public string $base;

    public function loadView(string $view,array $data = [])
    {
        return view($this->base.".".$view,$data);
    }
}
