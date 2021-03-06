@extends('adminlte::page')

@section('title', ((isset($title))?$title:""))

@section('content_header')

@stop

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <div class="card-title">{{((isset($title))?$title:"")}}</div>
                </div>
                <div class="card-body">
                    <a href="{{route("seminar.add")}}" class="btn btn-success ml-2 mb-4">
                        <li class="fa fa-plus"></li> Tambah Data
                    </a>
                    <a href="{{route("template.sidang",["type"=>0])}}" class="btn btn-primary ml-2 mb-4">
                        <li class="fa fa-download"></li> Export Data
                    </a>
                    <div class="table-responsive">
                        <table id="seminar" class="table table-bordered">
                            <thead>
                            <tr>
                                <th>No</th>
                                <th>Tgl</th>
                                <th>Total Partisipan</th>
                                <th>Total Ruangan</th>
                                <th>Aksi</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($data as $num => $row)
                                <tr>
                                    <td>{{($num+1)}}</td>
                                    <td>{{$row->start_date->format("d/m/Y")}}</td>
                                    <td>{{number_format($row->total_partisipan)}} Orang</td>
                                    <td>{{number_format($row->total_ruangan)}} Ruangan</td>
                                    <td>
                                        <a href="{{route("seminar.view.config",["date"=>$row->start_date->format("Y-m-d")])}}" class="btn btn-primary m-2">
                                            <li class="fa fa-cogs"></li>
                                        </a>
                                        <a href="{{route("seminar.view",["date"=>$row->start_date->format("Y-m-d")])}}" class="btn btn-primary m-2">
                                            <li class="fa fa-eye"></li>
                                        </a>
                                        <a href="{{route("seminar.update",[1,"date"=>$row->start_date->format("Y-m-d")])}}" class="btn btn-primary m-2">
                                            <li class="fa fa-users"></li>
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@stop

@section('css')

@stop

@section("js")
    @include("msg")
    <script>
        $(document).ready(function () {
            $("#seminar").DataTable();
            
        });
    </script>
@stop
