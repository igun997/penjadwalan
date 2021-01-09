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
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class Sidang extends Controller
{
    use ViewTrait;
    public function __construct()
    {
        $this->base = "penjadwalan.sidang";
    }

    /**
     * @param Request $req
     * @return mixed
     */
    public function index(Request $req)
    {
        $req->validate([
            "type"=>"numeric"
        ]);
        $data = [
            "title"=>"Data Sidang",
            "type"=>$req->type,
            "data"=>Schedule::select("start_date",DB::raw("COUNT(DISTINCT(room_id)) as total_ruangan"),DB::raw("COUNT(user_id) as total_partisipan"))->where(["type"=>$req->type])->groupBy("start_date")->get()
        ];
        return  $this->loadView("index",$data);
    }

    public function view(Request $req)
    {
        $req->validate([
            "date"=>"required",
            "type"=>"required",
            "room_id"=>"numeric"
        ]);
        $title = "Detail Data Sidang ($req->date)";
        if ($req->has("room_id")){
            $data = Schedule::where("start_date",$req->date)->where("type",$req->type)->where("room_id",$req->room_id)->orderBy("room_id","DESC")->get();
        }else{
            $data = Schedule::where("start_date",$req->date)->where("type",$req->type)->orderBy("room_id","DESC")->get();
        }
        return $this->loadView("viewForm",compact("title",'data','req'));

    }

    public function configView(Request $req)
    {
        $req->validate([
            "date"=>"required",
            "type"=>"required",
            "room_id"=>"numeric"
        ]);
        $title = "Pengaturan Data Sidang ($req->date)";
        if ($req->has("room_id")){
            $data = Schedule::where("start_date",$req->date)->where("type",$req->type)->where("room_id",$req->room_id)->orderBy("room_id","DESC")->get();
        }else{
            $data = Schedule::where("start_date",$req->date)->where("type",$req->type)->orderBy("room_id","DESC")->get();
        }
        return $this->loadView("configView",compact("title",'data','req'));
    }

    /**
     * @return mixed
     */
    public function add()
    {
        $title = "Tambah Sidang";
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
            "date"=>"required",
            "room_id"=>"numeric"
        ]);
        $title = "Update Data Sidang ($req->date)";
        if ($req->has("room_id")){
            $data = Schedule::where("start_date",$req->date)->where("type",$id)->where("room_id",$req->room_id)->orderBy("room_id","ASC")->get();
        }else{
            $data = Schedule::where("start_date",$req->date)->where("type",$id)->orderBy("room_id","ASC")->get();
        }
        $data_mhs = User::where(["level"=>LevelAccount::MAHASISWA,"status"=>StatusAccount::ACTIVE])->get(["id","name","username","kelas","semester"]);
        $data_dosen = Handler::all();
        $data_ruangan = Room::all();
        $route = route("sidang.update.action",[$id,$req->date]);
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
            "time_start"=>"required",
            "time_end"=>"required",
            "room_id"=>"required",
            "handler_2"=>"required",
            "handler_3"=>"required",
        ]);
        foreach ($req->id as $k => $row) {
            $find = Schedule::find($row);
            $find->room_id = $req->room_id[$k];
            $find->start_time = $req->time_start[$k];
            $find->end_time = $req->time_end[$k];
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

    public function updateStatus(Request $req)
    {
        $req->validate([
            "id"=>"required",
            "status"=>"numeric|required"
        ]);
        if ($req->status == ScheduleStatus::GRADUATE_SEMINAR){
            Schedule::where(["id"=>$req->id])->update(["type"=>ScheduleType::SIDANG_USULAN,"status"=>$req->status]);
        }elseif($req->status == ScheduleStatus::GRADUATE_SIDANG_USULAN){
            Schedule::where(["id"=>$req->id])->update(["type"=>ScheduleType::SIDANG_KOMPREHENSIF,"status"=>$req->status]);
        }elseif($req->status == ScheduleStatus::GRADUATE_SIDANG_KOMPREHENSIF){
            Schedule::where(["id"=>$req->id])->update(["type"=>ScheduleType::SIDANG_AKHIR,"status"=>$req->status]);
        }else{
            Schedule::where(["id"=>$req->id])->update(["status"=>$req->status]);
        }
        return $this->successBack(false);
    }
}
