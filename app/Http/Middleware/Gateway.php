<?php

namespace App\Http\Middleware;

use App\Casts\ScheduleType;
use App\Casts\StatusAccount;
use Closure;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Event;

class Gateway
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next,$is_must = null)
    {
        $level = session()->get("level");
        if ($level === NULL || $is_must === NULL){
            if ($request->ajax()){
                return response()->json(["msg"=>"Anda Belum Login "],400);
            }
            return  redirect("/")->withErrors(["msg"=>"Anda Belum Login"]);

        }else{
            $exploded = explode("|",$is_must);

            if (in_array($level,$exploded)){
                $is_must = $level;
//                Config::set("adminlte.sidebar_collapse",true);
                Event::listen("JeroenNoten\LaravelAdminLte\Events\BuildingMenu",function ($e){
                    $e->menu->add([
                        "text"=>"Beranda",
                        "url"=>"dashboard",
                        "icon"=>"fa fa-home"
                    ]);
                });

                if ($level == 0){
                    Event::listen("JeroenNoten\LaravelAdminLte\Events\BuildingMenu",function ($e){
                        $e->menu->add([
                            "text"=>"Data Ruangan",
                            "url"=>"master/ruangan",
                            "icon"=>"fa fa-file"
                        ]);
                        $e->menu->add([
                            "text"=>"Data Dosen",
                            "url"=>"master/dosen",
                            "icon"=>"fa fa-file"
                        ]);
                        $e->menu->add([
                            "text"=>"Data Mahasiswa",
                            "url"=>"master/mahasiswa",
                            "icon"=>"fa fa-file"
                        ]);
                        $e->menu->add([
                            "text"=>"Data Sekretariat",
                            "url"=>"master/sekretariat",
                            "icon"=>"fa fa-file"
                        ]);
//                        $e->menu->add([
//                            "text"=>"Data Administrator",
//                            "url"=>"master/administrator",
//                            "icon"=>"fa fa-file"
//                        ]);

                    });
                }elseif ($level == 1){
                    Event::listen("JeroenNoten\LaravelAdminLte\Events\BuildingMenu",function ($e){
                        $e->menu->add([
                            "text"=>"Penjadwalan Seminar",
                            "url"=>"seminar",
                            "icon"=>"fa fa-calendar"
                        ]);
                        $e->menu->add([
                            "text"=>"Penjadwalan Sidang Usulan",
                            "url"=>"sidang?type=".ScheduleType::SIDANG_USULAN,
                            "icon"=>"fa fa-calendar"
                        ]);
                        $e->menu->add([
                            "text"=>"Penjadwalan Sidang Komprehensif",
                            "url"=>"sidang?type=".ScheduleType::SIDANG_KOMPREHENSIF,
                            "icon"=>"fa fa-calendar"
                        ]);
                        $e->menu->add([
                            "text"=>"Penjadwalan Sidang Akhir",
                            "url"=>"sidang?type=".ScheduleType::SIDANG_AKHIR,
                            "icon"=>"fa fa-calendar"
                        ]);
//                        $e->menu->add([
//                            "text"=>"Laporan",
//                            "url"=>"cetak",
//                            "icon"=>"fa fa-file"
//                        ]);
                    });
                }elseif ($level == 2){
                    Event::listen("JeroenNoten\LaravelAdminLte\Events\BuildingMenu",function ($e){

                        $e->menu->add([
                            "text"=>"Jadwal Seminar",
                            "url"=>"jadwal?type=".ScheduleType::SEMINAR,
                            "icon"=>"fa fa-calendar"
                        ]);
                        $e->menu->add([
                            "text"=>"Jadwal Sidang Usulan",
                            "url"=>"jadwal?type=".ScheduleType::SIDANG_USULAN,
                            "icon"=>"fa fa-calendar"
                        ]);
                        $e->menu->add([
                            "text"=>"Jadwal Sidang Komprehensif",
                            "url"=>"jadwal?type=".ScheduleType::SIDANG_KOMPREHENSIF,
                            "icon"=>"fa fa-calendar"
                        ]);
                        $e->menu->add([
                            "text"=>"Jadwal Sidang Akhir",
                            "url"=>"jadwal?type=".ScheduleType::SIDANG_AKHIR,
                            "icon"=>"fa fa-calendar"
                        ]);


                    });
                }elseif ($level == 3){
                    Event::listen("JeroenNoten\LaravelAdminLte\Events\BuildingMenu",function ($e){

                        $e->menu->add([
                            "text"=>"Jadwal Seminar",
                            "url"=>"jadwal?type=".ScheduleType::SEMINAR,
                            "icon"=>"fa fa-calendar"
                        ]);
                        $e->menu->add([
                            "text"=>"Jadwal Sidang Usulan",
                            "url"=>"jadwal?type=".ScheduleType::SIDANG_USULAN,
                            "icon"=>"fa fa-calendar"
                        ]);
                        $e->menu->add([
                            "text"=>"Jadwal Sidang Komprehensif",
                            "url"=>"jadwal?type=".ScheduleType::SIDANG_KOMPREHENSIF,
                            "icon"=>"fa fa-calendar"
                        ]);
                        $e->menu->add([
                            "text"=>"Jadwal Sidang Akhir",
                            "url"=>"jadwal?type=".ScheduleType::SIDANG_AKHIR,
                            "icon"=>"fa fa-calendar"
                        ]);


                    });
                }

                Event::listen("JeroenNoten\LaravelAdminLte\Events\BuildingMenu",function ($e){
                    $e->menu->add([
                        "text"=>"Logout",
                        "url"=>"logout",
                        "icon"=>"fa fa-sign-out-alt"
                    ]);

                });
            }

            if ($level == $is_must){
                return $next($request);
            }else{
                if ($request->ajax()){
                    return response()->json(["msg"=>"Anda tidak memiliki akses ke halaman ini  "],400);
                }
                return  redirect("/")->withErrors(["msg"=>"Anda tidak memiliki akses ke halaman ini "]);
            }
        }

    }
}
