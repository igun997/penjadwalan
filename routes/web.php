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
Route::post("/login","Auth@login")->name("login.post");
Route::get("/logout","Auth@logout")->name("login");
Route::get("/template/ruangan","Utility@excel_template_ruangan")->name("template.ruangan");

Route::get("/dahsboard","Dashboard@index")->middleware("gateway:0|1|2")->name("dashboard");
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
Route::prefix("pembimbing")->middleware("gateway:1")->name("pembimbing.")->namespace("Pembimbing")->group(function (){
    Route::get("/","Pembimbing@index")->name("list");

    Route::get("/add","Pembimbing@add")->name("add");
    Route::post("/add","Pembimbing@add_action")->name("add.action");

    Route::get("/update/{id}","Pembimbing@update")->name("update");
    Route::post("/update/{id}","Pembimbing@update_action")->name("update.action");

    Route::get("/delete/{id}","Pembimbing@delete")->name("delete");
});

Route::prefix("seminar")->middleware("gateway:1")->name("seminar.")->namespace("Penjadwalan")->group(function (){
    Route::get("/","Penjadwalan@index")->name("list");

    Route::get("/add","Penjadwalan@add")->name("add");
    Route::post("/add","Penjadwalan@add_action")->name("add.action");

    Route::get("/update/{id}","Penjadwalan@update")->name("update");
    Route::post("/update/{id}","Penjadwalan@update_action")->name("update.action");

    Route::get("/delete/{id}","Penjadwalan@delete")->name("delete");
});


Route::prefix("sidang")->middleware("gateway:1")->name("sidang.")->namespace("Penjadwalan")->group(function (){
    Route::get("/","Penjadwalan@index")->name("list");

    Route::get("/add","Penjadwalan@add")->name("add");
    Route::post("/add","Penjadwalan@add_action")->name("add.action");

    Route::get("/update/{id}","Penjadwalan@update")->name("update");
    Route::post("/update/{id}","Penjadwalan@update_action")->name("update.action");

    Route::get("/delete/{id}","Penjadwalan@delete")->name("delete");
});
//Siswa
Route::prefix("jadwal")->middleware("gateway:2")->namespace("Jadwal")->name("jadwal.")->group(function (){
    Route::get("/","Jadwal@index")->name("list");
});



Route::prefix("cetak")->middleware("gateway:1")->namespace("Cetak")->name("cetak")->group(function(){
    Route::get("/","Cetak@index")->name("list");
    Route::get("/jadwal","Cetak@jadwal")->name("jadwal");

});
