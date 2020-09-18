<?php

namespace App\Http\Controllers;

use App\Traits\ViewTrait;
use Illuminate\Http\Request;

class Dashboard extends Controller
{
    use ViewTrait;
    public function __construct()
    {
        $this->base = "dashboard";
    }

    public function index()
    {
        $data = [
            "title"=>"Dashboard"
        ];
        return $this->loadView("home",$data);
    }
}
