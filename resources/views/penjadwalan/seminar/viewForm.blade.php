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

                    <div class="table-responsive">
                        <table id="seminar" class="table table-bordered">
                            <thead>
                            <tr>
                                <th>No</th>
                                <th>Waktu Mulai</th>
                                <th>Waktu Selesai</th>
                                <th>Pembimbing</th>
                                <th>Penguji 1</th>
                                <th>Penguji 2</th>
                                <th>Status</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($data as $num => $row)
                                <tr>
                                    <td>{{($num+1)}}</td>
                                    <td>{{($row->start_time)}}</td>
                                    <td>{{($row->end_time)}}</td>
                                    <td>{{($row->pembimbing->name)}}</td>
                                    <td>{{(($row->penguji_satu)?$row->penguji_satu->name:"-")}}</td>
                                    <td>{{(($row->penguji_dua)?$row->penguji_dua->name:"-")}}</td>
                                    <td>{{(\App\Casts\ScheduleStatus::lang($row->status))}}</td>
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
