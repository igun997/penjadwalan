<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public function successRedirect(string $route_name,bool $is_add = true)
    {
        return redirect(route($route_name))->with(["msg"=>(($is_add)?"Sukses Tambah Data":"Sukses Update Data")]);
    }
    public function successBack(bool $is_add = true)
    {
        return back()->with(["msg"=>(($is_add)?"Sukses Tambah Data":"Sukses Update Data")]);
    }

    public function failRedirect(string $route_name,bool $is_add = true)
    {
        return redirect(route($route_name))->withErrors(["msg"=>(($is_add)?"Gagal Tambah Data":"Gagal Update Data")]);
    }

    public function failBack(bool $is_add = true)
    {
        return back()->withErrors(["msg"=>(($is_add)?"Gagal Tambah Data":"Gagal Update Data")]);
    }
}
