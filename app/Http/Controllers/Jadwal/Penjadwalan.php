<?php

namespace App\Http\Controllers\Jadwal;

use App\Casts\ScheduleType;
use App\Http\Controllers\Controller;
use App\Models\Schedule;
use App\Traits\ViewTrait;
use Illuminate\Http\Request;

class Penjadwalan extends Controller
{
    use ViewTrait;
    public function __construct()
    {
        $this->base = "jadwal";
    }
    public function index(Request $req)
    {
        $req->validate([
            "type"=>"required"
        ]);
        $title = "Penjadwalan ".ScheduleType::lang($req->type);
        $jadwal = Schedule::where("type",$req->type)->orderBy("start_date","ASC")->orderBy("end_time","ASC")->get();
        return $this->loadView("index",compact("title","jadwal"));
    }
}
