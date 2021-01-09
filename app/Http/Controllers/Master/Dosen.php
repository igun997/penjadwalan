<?php

namespace App\Http\Controllers\Master;

use App\Casts\LevelAccount;
use App\Http\Controllers\Controller;
use App\Models\Handler;
use App\Models\Room;
use App\Models\User;
use App\Traits\ViewTrait;
use Igun997\Utility\Excel;
use Illuminate\Http\Request;

class Dosen extends Controller
{
    use ViewTrait;
    public function __construct()
    {
        $this->base = "master.dosen";
    }

    /**
     * @param Request $req
     * @return mixed
     */
    public function index(Request $req)
    {
        $data = [
            "title"=>"Data Dosen",
            "data"=>Handler::all()
        ];
        return  $this->loadView("index",$data);
    }

    /**
     * @return mixed
     */
    public function add()
    {
        $data = [
            "title"=>"Tambah Dosen",
            "route"=>route("master.dosen.add.action")
        ];

        return $this->loadView("form",$data);

    }

    /**
     * @param Request $req
     * @return mixed
     */
    public function add_action(Request $req)
    {
        if (!$req->has("file")){
            $req->validate([
                "nip"=>"required|unique:handlers,nip",
                "name"=>"required",
                "kelas"=>"min:1",
                "semester"=>"min:1",
            ]);
            User::create(["name"=>$req->name,"username"=>$req->nip,"password"=>$req->nip,"status"=>1,"level"=>LevelAccount::DOSEN]);
            $create = Handler::create($req->all());
        }else{
            $create = false;
            $file = $req->file("file");
            $store = $file->store("temp");
            $valid = storage_path()."/app/".$store;
            $excel = new Excel($valid);
            $format = [
                "nip"=>"nip",
                "nama"=>"nama",
                "kelas"=>"kelas",
                "semester"=>"semester",
            ];
            $result_excel = $excel->type("array")->setLabel(1)->reformat($format)->output();
            $unique = [];
            foreach ($result_excel as $index => $item) {
                if ($item["nip"] !== null){
                    $item["name"] = $item["nama"];
                    $unique[] = $item;
                }
            }
            $uniques = array_unique($unique);
            $itemSave = [];
            foreach ($uniques as $index => $unique) {
                $find = Handler::where(["nip"=>$unique["nip"]])->count();
                if ($find === 0){
                    $base = $unique;
                    User::create(["name"=>$base["name"],"username"=>$base["nip"],"password"=>$base["nip"],"status"=>1,"level"=>LevelAccount::DOSEN]);
                    $save = Handler::create($base);
                    if ($save){
                        $itemSave[] = 1;
                    }else{
                        $itemSave[] = 0;
                    }
                }
            }

            if (count(array_unique($itemSave)) === 1){
                return $this->successBack();
            }
            return $this->failBack();
        }

        if ($create){
            return $this->successRedirect("master.dosen.list");
        }
        return $this->failBack();
    }

    /**
     * @param Request $req
     * @param $id
     * @return mixed
     */
    public function update(Request $req, $id)
    {
        $dosen = Handler::findOrFail($id);
        $data = [
            "title"=>"Update Dosen",
            "data"=>$dosen,
            "route"=>route("master.dosen.update.action",$id)
        ];

        return $this->loadView("form",$data);
    }

    /**
     * @param Request $req
     * @param $id
     * @return mixed
     */
    public function update_action(Request $req, $id)
    {
        $req->validate([
            "name"=>"required",
        ]);

        $dosen = Handler::findOrFail($id);
        $dosen->name = $req->name;
        if($req->has("semester") && $req->has("kelas")){
            $dosen->kelas = $req->kelas;
            $dosen->semester = $req->semester;
        }
        if ($req->has("nip")){
            $dosen->nip = $req->nip;
        }
        if ($dosen->save()){
            return $this->successRedirect("master.dosen.list",false);
        }
        return $this->failBack(false);
    }

    /**
     * @param $id
     * @return mixed
     */
    public function delete($id)
    {
        $dosen = Handler::findOrFail($id);
        $del = $dosen->delete();
        if ($del){
            return $this->successBack(false);
        }
        return $this->failBack(false);

    }

}
