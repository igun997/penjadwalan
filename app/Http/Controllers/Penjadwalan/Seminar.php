<?php

namespace App\Http\Controllers\Penjadwalan;

use App\Casts\LevelAccount;
use App\Casts\ScheduleStatus;
use App\Casts\ScheduleType;
use App\Casts\StatusAccount;
use App\Http\Controllers\Controller;
use App\Models\Handler;
use App\Models\Room;
use App\Models\Schedule;
use App\Models\User;
use App\Traits\ViewTrait;
use Carbon\Carbon;
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
        $data = Schedule::where("start_date",$req->date)->orderBy("room_id","DESC")->get();
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
        $data_ruangan = Room::all();
        if (count($data_mhs->toArray()) > 0 ){
            $data_mhs = json_encode($data_mhs->toArray());
            $data_dosen = json_encode($data_dosen->toArray());
        }else{
            $data_mhs = null;
            $data_dosen = null;
        }
        return  $this->loadView("form",compact("title","data_mhs","data_dosen","data_ruangan"));
    }

    /**
     * @param Request $req
     * @return mixed
     */
    public function add_action(Request $req)
    {
        $req->validate([
            "user_id"=>"required",
            "handler_1"=>"required",
            "room_id"=>"required",
            "date"=>"required",
            "time_start"=>"required",
            "time_end"=>"required",
        ]);

        $item = [];
        foreach ($req->user_id as $k => $row) {
            $item[] = [
                "room_id"=>$req->room_id[$k],
                "handler_1"=>$req->handler_1[$k],
                "start_time"=>$req->time_start[$k],
                "end_time"=>$req->time_end[$k],
                "type"=>ScheduleType::SEMINAR,
                "user_id"=>$req->user_id[$k],
                "start_date"=>$req->date,
                "status"=>ScheduleStatus::CREATED,
                "created_at"=>date("Y-m-d"),
                "updated_at"=>date("Y-m-d"),
            ];
        }
        $batch = Schedule::insert($item);
        if ($batch){
            return $this->successBack();
        }
        return  $this->failBack();
    }

    /**
     * @param Request $req
     * @param $id
     * @return mixed
     */
    public function update(Request $req, $id)
    {
        $req->validate([
            "date"=>"required"
        ]);
        $title = "Update Data Seminar ($req->date)";
        $data = Schedule::where("start_date",$req->date)->orderBy("start_time","ASC")->get();
        $data_mhs = User::where(["level"=>LevelAccount::MAHASISWA,"status"=>StatusAccount::ACTIVE])->get(["id","name","username","kelas","semester"]);
        $data_dosen = Handler::all();
        $data_ruangan = Room::all();
        $route = route("seminar.update.action",[$id,$req->date]);
        if (count($data_mhs->toArray()) > 0 ){
            $data_mhs = $data_mhs->toArray();
            $data_dosen = $data_dosen->toArray();
        }else{
            $data_mhs = null;
            $data_dosen = null;
        }
        return  $this->loadView("form",compact("route","title","data_mhs","data_dosen","data_ruangan","req","data"));

    }

    /**
     * @param Request $req
     * @param $id
     * @return mixed
     */
    public function update_action(Request $req, $id)
    {
        $req->validate([
            "id"=>"required",
            "handler_2"=>"required",
            "handler_3"=>"required",
        ]);
        foreach ($req->id as $k => $row) {
            $find = Schedule::find($row);
            $find->handler_2 = $req->handler_2[$k];
            $find->handler_3 = $req->handler_3[$k];
            $find->save();
        }
        return $this->successBack(false);
    }

    /**
     * @param $id
     * @return mixed
     */
    public function delete($id)
    {
        Schedule::findOrFail($id)->delete();
        return $this->successBack(false);
    }
}
