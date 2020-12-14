<?php

namespace App\Http\Controllers\Penjadwalan;

use App\Casts\LevelAccount;
use App\Casts\ScheduleType;
use App\Casts\StatusAccount;
use App\Http\Controllers\Controller;
use App\Models\Handler;
use App\Models\Schedule;
use App\Models\User;
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
            "data"=>Schedule::select("start_date",DB::raw("COUNT(DISTINCT(room_id)) as total_ruangan"),DB::raw("COUNT(user_id) as total_partisipan"))->where(["type"=>ScheduleType::SEMINAR])->groupBy("start_date")->get()
        ];
        return  $this->loadView("index",$data);
    }

    public function view(Request $req)
    {
        $req->validate([
            "date"=>"required"
        ]);
        $title = "Detail Data Seminar ($req->date)";
        $data = Schedule::where("start_date",$req->date)->orderBy("start_time","ASC")->get();
        return $this->loadView("viewForm",compact("title",'data','req'));

    }

    /**
     * @return mixed
     */
    public function add()
    {
        $title = "Tambah Seminar";
        $data_mhs = User::where(["level"=>LevelAccount::MAHASISWA,"status"=>StatusAccount::ACTIVE])->get(["id","name","username","kelas","semester"]);
        $data_dosen = Handler::all();
        if (count($data_mhs->toArray()) > 0 ){
            $data_mhs = json_encode($data_mhs->toArray());
            $data_dosen = json_encode($data_dosen->toArray());
        }else{
            $data_mhs = null;
            $data_dosen = null;
        }
        return  $this->loadView("form",compact("title","data_mhs","data_dosen"));
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
