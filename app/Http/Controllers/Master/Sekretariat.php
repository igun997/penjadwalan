<?php

namespace App\Http\Controllers\Master;

use App\Casts\LevelAccount;
use App\Casts\StatusAccount;
use App\Http\Controllers\Controller;
use App\Models\Handler;
use App\Models\Room;
use App\Models\User;
use App\Traits\ViewTrait;
use Igun997\Utility\Excel;
use Illuminate\Http\Request;

class Sekretariat extends Controller
{
    use ViewTrait;
    public function __construct()
    {
        $this->base = "master.sekretariat";
    }

    /**
     * @param Request $req
     * @return mixed
     */
    public function index(Request $req)
    {
        $data = [
            "title"=>"Data Sekretariat",
            "data"=>User::where(["level"=>LevelAccount::SEKRETARIAT])->get()
        ];
        return  $this->loadView("index",$data);
    }

    /**
     * @return mixed
     */
    public function add()
    {
        $data = [
            "title"=>"Tambah Sekretariat",
            "route"=>route("master.sekretariat.add.action")
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
                "password"=>"required",
            ]);
            $data = $req->all();
            $data["status"] = StatusAccount::ACTIVE;
            $data["level"] = LevelAccount::SEKRETARIAT;
            $create = User::create($data);
        }else{
            $create = false;
            $file = $req->file("file");
            $store = $file->store("temp");
            $valid = storage_path()."/app/".$store;
            $excel = new Excel($valid);
            $format = [
                "no"=>"no",
                "nama"=>"nama",
                "username"=>"username",
                "password"=>"password",
            ];
            $result_excel = $excel->type("array")->setLabel(1)->reformat($format)->output();
            $unique = [];
            foreach ($result_excel as $index => $item) {
                if ($item["username"] !== null && $item["password"] !== null){
                    $item["name"] = $item["nama"];
                    $unique[] = $item;
                }
            }
            $uniques = array_map("unserialize", array_unique(array_map("serialize", $unique)));
            $itemSave = [];
            foreach ($uniques as $index => $unique) {
                $find = User::where(["username"=>$unique["username"]])->count();
                if ($find === 0){
                    $base = $unique;

                    $base["status"] = StatusAccount::ACTIVE;
                    $base["level"] = LevelAccount::SEKRETARIAT;
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
            return $this->successRedirect("master.sekretariat.list");
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
        $Sekretariat = User::findOrFail($id);
        $data = [
            "title"=>"Update Sekretariat",
            "data"=>$Sekretariat,
            "route"=>route("master.sekretariat.update.action",$id)
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

        $Sekretariat = User::findOrFail($id);
        $Sekretariat->name = $req->name;
        $Sekretariat->status = $req->status;
        if ($req->has("password")){
            $Sekretariat->password = $req->password;
        }
        if ($Sekretariat->save()){
            return $this->successRedirect("master.sekretariat.list",false);
        }
        return $this->failBack(false);
    }

    /**
     * @param $id
     * @return mixed
     */
    public function delete($id)
    {
        $Sekretariat = User::findOrFail($id);
        $del = $Sekretariat->delete();
        if ($del){
            return $this->successBack(false);
        }
        return $this->failBack(false);

    }

}
