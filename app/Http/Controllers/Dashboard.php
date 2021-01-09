<?php

namespace App\Http\Controllers;

use App\Casts\LevelAccount;
use App\Casts\ScheduleStatus;
use App\Casts\ScheduleType;
use App\Models\Schedule;
use App\Models\User;
use App\Traits\ViewTrait;
use Illuminate\Http\Request;

class Dashboard extends Controller
{
    use ViewTrait;
    public function __construct()
    {
        $this->base = "dashboard";
    }

    public function index()
    {
        $total = User::where(["level"=>LevelAccount::MAHASISWA])->count();
        $peserta_seminar = Schedule::where(["type"=>ScheduleType::SEMINAR])->count();
        $peserta_seminar_gagal = Schedule::where(["type"=>ScheduleType::SEMINAR,"status"=>ScheduleStatus::UNGRADUATE_SEMINAR])->count();
        $peserta_sidang_gagal = Schedule::whereIn("type",[ScheduleType::SIDANG_USULAN,ScheduleType::SIDANG_KOMPREHENSIF,ScheduleType::SIDANG_AKHIR])->whereIn("status",[ScheduleStatus::UNGRADUATE_SIDANG_USULAN,ScheduleStatus::UNGRADUATE_SIDANG_AKHIR,ScheduleStatus::UNGRADUATE_SIDANG_KOMPREHENSIF])->count();
        $peserta_sidang = Schedule::whereIn("type",[ScheduleType::SIDANG_USULAN,ScheduleType::SIDANG_KOMPREHENSIF,ScheduleType::SIDANG_AKHIR])->count();
        $lulus = Schedule::whereIn("type",[ScheduleType::SIDANG_AKHIR])->where(["status"=>ScheduleStatus::GRADUATE_SIDANG_AKHIR])->count();
        $chartjs = app()->chartjs
            ->name('lineChartTest')
            ->type('pie')
            ->size(['width' => 400, 'height' => 200])
            ->labels(['Total Mahasiswa', 'Peserta Seminar', 'Peserta Sidang', 'Gagal Sidang', 'Gagal Seminar', 'Lulus'])
            ->datasets([
                [
                    'backgroundColor' => ['#FF6384', '#36A2EB','#2980b9','#8e44ad','#f39c12','#16a085'],
                    'hoverBackgroundColor' => ['#FF6384', '#36A2EB','#2980b9','#8e44ad','#f39c12','#16a085'],
                    'data' => [$total,$peserta_seminar,$peserta_sidang,$peserta_sidang_gagal,$peserta_seminar_gagal,$lulus],
                ]
            ])
            ->options([]);
        $data = [
            "title"=>"Dashboard",
            "chartjs"=>$chartjs
        ];
        return $this->loadView("home",$data);
    }
}
