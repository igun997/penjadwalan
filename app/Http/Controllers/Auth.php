<?php

namespace App\Http\Controllers;

use App\Casts\LevelAccount;
use App\Casts\StatusAccount;
use App\Models\User;
use Illuminate\Http\Request;

class Auth extends Controller
{

    public function index(){
        return view("login");
    }

    public function login(Request $req)
    {
        $req->validate([
            "username"=>"required",
            "password"=>"required"
        ]);

        $cek = User::where(["username"=>$req->username,"password"=>$req->password,"status"=>StatusAccount::ACTIVE]);
        if ($cek->count() > 0){
            $build = [
                "name"=>$cek->first()->name,
                "level"=>$cek->first()->level,
                "id"=>$cek->first()->id,
                "username"=>$cek->first()->username,
                "url"=>LevelAccount::redirect($cek->first()->level),
            ];
            session($build);
            return redirect($build["url"])->with(["msg"=>"Selamat Datang ".$build["name"]]);
        }else{
            return back()->withErrors(["msg"=>"Username & Password Salah"]);
        }
    }

    public function logout()
    {
        session()->flush();
        return redirect("/");
    }
}
