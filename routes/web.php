<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get("/","Auth@index")->name("login");
Route::get("/template",function (){
    return view("template.jadwal");
});
Route::post("/login","Auth@login")->name("login.post");
Route::get("/logout","Auth@logout")->name("login");
Route::prefix("/template")->name("template.")->group(function (){
    Route::get("/ruangan","Utility@excel_template_ruangan")->name("ruangan");
    Route::get("/dosen","Utility@excel_template_dosen")->name("dosen");
    Route::get("/mahasiswa","Utility@excel_template_mahasiswa")->name("mahasiswa");
    Route::get("/sekretariat","Utility@excel_template_sekretariat")->name("sekretariat");
    Route::get("/seminar","Utility@excel_template_seminar")->name("seminar");
    Route::get("/sidang","Utility@excel_template_sidang")->name("sidang");
});

Route::get("/dashboard","Dashboard@index")->middleware("gateway:0|1|2|3")->name("dashboard");
//Admin
Route::prefix("master")->middleware("gateway:0")->name("master.")->namespace("Master")->group(function(){
    Route::prefix("ruangan")->name("ruangan.")->group(function (){
        Route::get("/","Ruangan@index")->name("list");

        Route::get("/add","Ruangan@add")->name("add");
        Route::post("/add","Ruangan@add_action")->name("add.action");

        Route::get("/update/{id}","Ruangan@update")->name("update");
        Route::post("/update/{id}","Ruangan@update_action")->name("update.action");

        Route::get("/delete/{id}","Ruangan@delete")->name("delete");
    });

    Route::prefix("dosen")->name("dosen.")->group(function (){
        Route::get("/","Dosen@index")->name("list");

        Route::get("/add","Dosen@add")->name("add");
        Route::post("/add","Dosen@add_action")->name("add.action");

        Route::get("/update/{id}","Dosen@update")->name("update");
        Route::post("/update/{id}","Dosen@update_action")->name("update.action");

        Route::get("/delete/{id}","Dosen@delete")->name("delete");
    });

    Route::prefix("mahasiswa")->name("mahasiswa.")->group(function (){
        Route::get("/","Mahasiswa@index")->name("list");

        Route::get("/add","Mahasiswa@add")->name("add");
        Route::post("/add","Mahasiswa@add_action")->name("add.action");

        Route::get("/update/{id}","Mahasiswa@update")->name("update");
        Route::post("/update/{id}","Mahasiswa@update_action")->name("update.action");

        Route::get("/delete/{id}","Mahasiswa@delete")->name("delete");
    });

    Route::prefix("sekretariat")->name("sekretariat.")->group(function (){
        Route::get("/","Sekretariat@index")->name("list");

        Route::get("/add","Sekretariat@add")->name("add");
        Route::post("/add","Sekretariat@add_action")->name("add.action");

        Route::get("/update/{id}","Sekretariat@update")->name("update");
        Route::post("/update/{id}","Sekretariat@update_action")->name("update.action");

        Route::get("/delete/{id}","Sekretariat@delete")->name("delete");
    });

    Route::prefix("administrator")->name("administrator.")->group(function (){
        Route::get("/","Administrator@index")->name("list");

        Route::get("/add","Administrator@add")->name("add");
        Route::post("/add","Administrator@add_action")->name("add.action");

        Route::get("/update/{id}","Administrator@update")->name("update");
        Route::post("/update/{id}","Administrator@update_action")->name("update.action");

        Route::get("/delete/{id}","Administrator@delete")->name("delete");
    });
});
//Sekretariat


Route::prefix("penguji")->middleware("gateway:1")->name("penguji.")->namespace("Penjadwalan")->group(function (){
    Route::get("/","Penguji@index")->name("list");

    Route::get("/add","Penguji@add")->name("add");
    Route::post("/add","Penguji@add_action")->name("add.action");

    Route::get("/update/{id}","Penguji@update")->name("update");
    Route::post("/update/{id}","Penguji@update_action")->name("update.action");

    Route::get("/delete/{id}","Penguji@delete")->name("delete");
});

Route::prefix("seminar")->middleware("gateway:1")->name("seminar.")->namespace("Penjadwalan")->group(function (){
    Route::get("/","Seminar@index")->name("list");

    Route::get("/add","Seminar@add")->name("add");
    Route::post("/add","Seminar@add_action")->name("add.action");

    Route::get("/update/{id}","Seminar@update")->name("update");
    Route::post("/update/{id}","Seminar@update_action")->name("update.action");

    Route::get("/delete/{id}","Seminar@delete")->name("delete");

    Route::get("/view","Seminar@view")->name("view");
    Route::get("/config","Seminar@configView")->name("view.config");
    Route::get("/update_status","Seminar@updateStatus")->name("config.update_status");
});


Route::prefix("sidang")->middleware("gateway:1")->name("sidang.")->namespace("Penjadwalan")->group(function (){
    Route::get("/","Sidang@index")->name("list");

    Route::get("/add","Sidang@add")->name("add");
    Route::post("/add","Sidang@add_action")->name("add.action");

    Route::get("/update/{id}","Sidang@update")->name("update");
    Route::post("/update/{id}","Sidang@update_action")->name("update.action");

    Route::get("/delete/{id}","Sidang@delete")->name("delete");

    Route::get("/view","Sidang@view")->name("view");
    Route::get("/config","Sidang@configView")->name("view.config");
    Route::get("/update_status","Sidang@updateStatus")->name("config.update_status");
});
//Siswa
Route::prefix("jadwal")->middleware("gateway:2|3")->namespace("Jadwal")->name("jadwal.")->group(function (){
    Route::get("/","Penjadwalan@index")->name("list");
});



Route::prefix("cetak")->middleware("gateway:1")->namespace("Cetak")->name("cetak")->group(function(){
    Route::get("/","Cetak@index")->name("list");
    Route::get("/jadwal","Cetak@jadwal")->name("jadwal");

});
