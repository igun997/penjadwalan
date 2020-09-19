<?php

namespace App\Http\Controllers\Master;

use App\Contracts\ControllerContract;
use App\Contracts\CRUDContract;
use App\Http\Controllers\Controller;
use App\Models\Room;
use App\Traits\ViewTrait;
use Igun997\Utility\Excel;
use Illuminate\Http\Request;

class Ruangan extends Controller implements CRUDContract,ControllerContract
{
    use ViewTrait;
    public function __construct()
    {
        $this->base = "master.ruangan";
    }

    /**
     * @param Request $req
     * @return mixed
     */
    public function index(Request $req)
    {
        $data = [
            "title"=>"Data Ruangan",
            "data"=>Room::all()
        ];
        return  $this->loadView("index",$data);
    }

    /**
     * @return mixed
     */
    public function add()
    {
        $data = [
            "title"=>"Tambah Ruangan",
            "route"=>route("master.ruangan.add.action")
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
                "name"=>"required|unique:rooms,name"
            ]);
            $create = Room::create($req->all());
        }else{
            $create = false;
            $file = $req->file("file");
            $store = $file->store("temp");
            $valid = storage_path()."/app/".$store;
            $excel = new Excel($valid);
            $format = [
                "no"=>"no",
                "nama"=>"nama",
            ];
            $result_excel = $excel->type("array")->setLabel(1)->reformat($format)->output();
            $unique = [];
            foreach ($result_excel as $index => $item) {
                $unique[] = $item["nama"];
            }
            $uniques = array_unique($unique);
            $itemSave = [];
            foreach ($uniques as $index => $unique) {
                $find = Room::where(["name"=>$unique])->count();
                if ($find === 0){
                    $base = [
                        "name"=>$unique
                    ];
                    $save = Room::create($base);
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
            return $this->successRedirect("master.ruangan.list");
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
        $room = Room::findOrFail($id);
        $data = [
            "title"=>"Update Ruangan",
            "data"=>$room,
            "route"=>route("master.ruangan.update.action",$id)
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
            "name"=>"required|unique:rooms,name"
        ]);

        $room = Room::findOrFail($id);
        $room->name = $req->name;
        if ($room->save()){
            return $this->successRedirect("master.ruangan.list",false);
        }
        return $this->failBack(false);
    }

    /**
     * @param $id
     * @return mixed
     */
    public function delete($id)
    {
        $room = Room::findOrFail($id);
        $del = $room->delete();
        if ($del){
            return $this->successBack(false);
        }
        return $this->failBack(false);

    }




}
