<?php

namespace App\Http\Controllers\Penjadwalan;

use App\Casts\ScheduleType;
use App\Http\Controllers\Controller;
use App\Models\Schedule;
use App\Traits\ViewTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class Seminar extends Controller
{
    use ViewTrait;
    public function __construct()
    {
        $this->base = "penjadwalan.seminar";
    }

    /**
     * @param Request $req
     * @return mixed
     */
    public function index(Request $req)
    {
        $data = [
            "title"=>"Data Seminar",
            "data"=>Schedule::select("status","start_date",DB::raw("COUNT(DISTINCT(room_id)) as total_ruangan"),DB::raw("COUNT(user_id) as total_partisipan"))->where(["type"=>ScheduleType::SEMINAR])->groupBy("start_date")->groupBy("status")->get()
        ];
        return  $this->loadView("index",$data);
    }

    /**
     * @return mixed
     */
    public function add()
    {


    }

    /**
     * @param Request $req
     * @return mixed
     */
    public function add_action(Request $req)
    {

    }

    /**
     * @param Request $req
     * @param $id
     * @return mixed
     */
    public function update(Request $req, $id)
    {

    }

    /**
     * @param Request $req
     * @param $id
     * @return mixed
     */
    public function update_action(Request $req, $id)
    {

    }

    /**
     * @param $id
     * @return mixed
     */
    public function delete($id)
    {

    }
}
