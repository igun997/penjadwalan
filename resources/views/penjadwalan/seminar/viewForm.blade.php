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
                @php
                $ruangan = [];
                $sdate = null;
                foreach ($data as $index => $item) {
                    if ($index === 0){
                        $sdate = $item->start_date->format("Y-m-d");
                    }
                    $ruangan[] = [
                        "v"=>$item->room_id,
                        "n"=>$item->room->name
                    ];
                }
                $ruangan = array_map("unserialize", array_unique(array_map("serialize", $ruangan)));
                @endphp
                <div class="card-body">
                    <div class="form-group mb-5 col-6">
                        <select id="room" class="form-control">
                            <option>Pilih Ruangan</option>
                            @foreach($ruangan as $t)
                                @if($req->has("room_id"))
                                    @if($req->room_id == $t["v"])
                                        <option value="{{$t["v"]}}" selected>{{$t["n"]}}</option>
                                    @else
                                        <option value="{{$t["v"]}}">{{$t["n"]}}</option>
                                    @endif
                                @else
                                    <option value="{{$t["v"]}}">{{$t["n"]}}</option>
                                @endif
                            @endforeach
                        </select>
                    </div>
                    <div class="table-responsive">
                        <table id="seminar" class="table table-bordered">
                            <thead>
                            <tr>
                                <th>No</th>
                                <th>Waktu Mulai</th>
                                <th>Waktu Selesai</th>
                                <th>Ruangan</th>
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
                                    <td>{{($row->room->name)}}</td>
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
            $("#room").on("change",function () {
                const v = parseInt($(this).val());
                const c = "{{(explode("&",url()->current()))[0]}}";
                if((v - 9999)){
                    location.href = c+"?date={{$sdate}}&room_id="+v;
                }else{
                    location.href = c+"?date={{$sdate}}";
                }
            })

        });
    </script>
@stop
