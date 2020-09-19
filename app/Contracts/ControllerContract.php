<?php

namespace App\Contracts;



use Illuminate\Http\Request;

interface ControllerContract
{
    public function index(Request $req);
}
