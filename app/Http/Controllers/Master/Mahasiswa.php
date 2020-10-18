<?php

namespace App\Http\Controllers\Master;

use App\Casts\LevelAccount;
use App\Casts\StatusAccount;
use App\Http\Controllers\Controller;
use App\Models\User;
use App\Traits\ViewTrait;
use Igun997\Utility\Excel;
use Illuminate\Http\Request;

class Mahasiswa extends Controller
{
    use ViewTrait;
    public function __construct()
    {
        $this->base = "master.mahasiswa";
    }

    /**
     * @param Request $req
     * @return mixed
     */
    public function index(Request $req)
    {
        $data = [
            "title"=>"Data Mahasiswa",
            "data"=>User::where(["level"=>LevelAccount::MAHASISWA])->get()
        ];
        return  $this->loadView("index",$data);
    }

    /**
     * @return mixed
     */
    public function add()
    {
        $data = [
            "title"=>"Tambah Mahasiswa",
            "route"=>route("master.mahasiswa.add.action")
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
                "username"=>"required|unique:users,username",
                "name"=>"required",
                "kelas"=>"required",
                "semester"=>"required",
                "password"=>"required",
            ]);
            $data = $req->all();
            $data["kelas"] = strtoupper($data["kelas"]);
            $data["semester"] = strtoupper($data["semester"]);
            $data["status"] = StatusAccount::ACTIVE;
            $data["level"] = LevelAccount::MAHASISWA;
            $create = User::create($data);
        }else{
            $create = false;
            $file = $req->file("file");
            $store = $file->store("temp");
            $valid = storage_path()."/app/".$store;
            $excel = new Excel($valid);
            $format = [
                "nim"=>"nim",
                "nama"=>"nama",
                "kelas"=>"kelas",
                "semester"=>"semester",
                "password"=>"password",
            ];
            $result_excel = $excel->type("array")->setLabel(1)->reformat($format)->output();
            $unique = [];
            foreach ($result_excel as $index => $item) {
                if ($item["nim"] !== null && $item["semester"] !== null && $item["kelas"] !== null){
                    $item["name"] = $item["nama"];
                    $item["username"] = $item["nim"];
                    if (!$item["password"]){
                        $item["password"] = $item["nim"];
                    }
                    $unique[] = $item;
                }
            }
            $uniques = array_map("unserialize", array_unique(array_map("serialize", $unique)));
            $itemSave = [];
            foreach ($uniques as $index => $unique) {
                $find = User::where(["username"=>$unique["nim"]])->count();
                if ($find === 0){
                    $base = $unique;

                    $base["status"] = StatusAccount::ACTIVE;
                    $base["level"] = LevelAccount::MAHASISWA;
                    $save = User::create($base);
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
            return $this->successRedirect("master.mahasiswa.list");
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
        $Mahasiswa = User::findOrFail($id);
        $data = [
            "title"=>"Update Mahasiswa",
            "data"=>$Mahasiswa,
            "route"=>route("master.mahasiswa.update.action",$id)
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
            "status"=>"required",
            "password"=>"min:3",
        ]);

        $Mahasiswa = User::findOrFail($id);
        $Mahasiswa->name = $req->name;
        $Mahasiswa->status = $req->status;
        $Mahasiswa->kelas = $req->kelas;
        $Mahasiswa->semester = $req->semester;
        if ($req->has("password")){
            $Mahasiswa->password = $req->password;
        }
        if ($Mahasiswa->save()){
            return $this->successRedirect("master.mahasiswa.list",false);
        }
        return $this->failBack(false);
    }

    /**
     * @param $id
     * @return mixed
     */
    public function delete($id)
    {
        $Mahasiswa = User::findOrFail($id);
        $del = $Mahasiswa->delete();
        if ($del){
            return $this->successBack(false);
        }
        return $this->failBack(false);

    }

}
