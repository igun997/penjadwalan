<?php

namespace App\Http\Controllers;

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
        ];
        $excel = new Excel();
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
}
