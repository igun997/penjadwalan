<?php

namespace App\Http\Controllers;

use App\Casts\LevelAccount;
use App\Models\Handler;
use App\Models\Room;
use App\Models\User;
use Igun997\Utility\Excel;
use Illuminate\Http\Request;

class Utility extends Controller
{
    public function excel_template_ruangan()
    {
        $template = [
            "A1"=>"no",
            "B1"=>"nama",
        ];
        $row =[];
        foreach (Room::all() as $index => $item) {
            $row["A".($index+2)] = ($index+1);
            $row["B".($index+2)] = $item->name;
        }
        $template = array_merge($template,$row);
        $excel = new Excel();
        try {
            $excel->properties([
                "creator" => "UNIKOM",
                "title" => "TemplateExcel_Ruangan",
                "subject" => "",
                "description" => ""
            ])->setSheet(0)->write($template, "Data Ruangan", true)->output();
        } catch (\Exception $e) {
            return response()->json(["code"=>500],500);
        }
    }
    public function excel_template_dosen()
    {
        $template = [
            "A1"=>"nip",
            "B1"=>"nama",
            "C1"=>"kelas",
            "D1"=>"semester",
            "E1"=>"* Jika Tidak Memiliki Kelas & Semester isi Dengan dash '-'",
        ];
        $excel = new Excel();
        $row =[];
        foreach (Handler::all() as $index => $item) {
            $row["A".($index+2)] = ($index+1);
            $row["B".($index+2)] = $item->nip;
            $row["C".($index+2)] = $item->name;
            $row["D".($index+2)] = $item->kelas;
            $row["E".($index+2)] = $item->semester;
        }
        $template = array_merge($template,$row);
        try {
            $excel->properties([
                "creator" => "UNIKOM",
                "title" => "TemplateExcel_DOSEN",
                "subject" => "",
                "description" => ""
            ])->setSheet(0)->write($template, "Data Dosen", true)->output();
        } catch (\Exception $e) {
            return response()->json(["code"=>500],500);
        }
    }

    public function excel_template_sekretariat()
    {
        $template = [
            "A1"=>"no",
            "B1"=>"nama",
            "C1"=>"username",
            "D1"=>"password",
        ];
        $excel = new Excel();
        $row =[];
        foreach (User::where(["level"=>LevelAccount::SEKRETARIAT])->get() as $index => $item) {
            $row["A".($index+2)] = ($index+1);
            $row["B".($index+2)] = $item->name;
            $row["C".($index+2)] = $item->username;
            $row["D".($index+2)] = "";
        }
        $template = array_merge($template,$row);
        try {
            $excel->properties([
                "creator" => "UNIKOM",
                "title" => "TemplateExcel_SEKRE",
                "subject" => "",
                "description" => ""
            ])->setSheet(0)->write($template, "Data Sekretariat", true)->output();
        } catch (\Exception $e) {
            return response()->json(["code"=>500],500);
        }
    }

    public function excel_template_mahasiswa()
    {
        $template = [
            "A1"=>"nim",
            "B1"=>"nama",
            "C1"=>"kelas",
            "D1"=>"semester",
            "E1"=>"password",
        ];
        $excel = new Excel();
        $row =[];
        foreach (User::where(["level"=>LevelAccount::MAHASISWA])->get() as $index => $item) {
            $row["A".($index+2)] = ($index+1);
            $row["B".($index+2)] = $item->username;
            $row["B".($index+2)] = $item->name;
            $row["C".($index+2)] = $item->kelas;
            $row["D".($index+2)] = $item->semester;
            $row["E".($index+2)] ="";
        }
        $template = array_merge($template,$row);
        try {
            $excel->properties([
                "creator" => "UNIKOM",
                "title" => "TemplateExcel_Mahasiswa",
                "subject" => "",
                "description" => ""
            ])->setSheet(0)->write($template, "Data Mahasiswa", true)->output();
        } catch (\Exception $e) {
            return response()->json(["code"=>500],500);
        }
    }
}
