@extends('adminlte::page')

@section('title', ((isset($title))?$title:""))

@section('content_header')

@stop

@section('content')
    @php
        $ruangan = [];
        $sdate = null;
        if (isset($data)){
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
        }

    @endphp
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <div class="card-title">{{((isset($title))?$title:"")}}</div>
                </div>
                <div class="card-body">
                    @if(count($ruangan) > 0)
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
                    @endif
                    <form action="{{$route ?? route("seminar.add.action")}}" method="post">
                        <div class="row">
                            <div class="col-12">
                                @csrf
                                <div class="form-group">
                                    <label>Tanggal Sidang</label>
                                    <input type="date" name="date" value="{{@$req->date}}" class="form-control" />
                                </div>
                            </div>
                            @if(!isset($data))
                                <div class="col-12 " >
                                    <div class="form-group">
                                        <button class="btn btn-success" type="button" id="add_mhs">
                                            <li class="fa fa-plus"></li>
                                        </button>
                                    </div>
                                </div>
                            @endif
                            <div class="col-12 table-responsive">
                                <table class="table table-bordered">
                                    <thead>
                                    <tr>
                                        <th>Nama MHS</th>
                                        <th>Pembimbing</th>
                                        <th>Ruangan</th>
                                        <th>Waktu Mulai</th>
                                        <th>Waktu Selesai</th>
                                        @if(isset($data))
                                            <th>Penguji 1</th>
                                            <th>Penguji 2</th>
                                        @endif
                                        <th>Aksi</th>
                                    </tr>
                                    </thead>
                                    @php
                                            @endphp
                                    <tbody id="mhs_list">
                                    @if(isset($data))
                                        @foreach($data as $row)
                                            <tr>
                                                <td>{{$row->user->name}}</td>
                                                <td>{{$row->pembimbing->name}}</td>
                                                <td>
                                                    <select name="room_id[]" class="form-control">
                                                        @foreach($data_ruangan as $r)
                                                            @if($row->room_id === $r->id)
                                                                <option  selected value="{{$r->id}}">{{$r->name}}</option>
                                                            @else
                                                                <option  value="{{$r->id}}">{{$r->name}}</option>
                                                            @endif
                                                        @endforeach
                                                    </select>
                                                </td>
                                                <td>
                                                    <input type="text" name="time_start[]" class="time form-control" value="{{$row->start_time}}">
                                                </td>
                                                <td>
                                                    <input type="text" name="time_end[]" class="time form-control" value="{{$row->end_time}}">
                                                    <input type="text"  value="{{$row->id}}" name="id[]" hidden></td>
                                                @if(isset($row->penguji_satu->name))
                                                    <td>

                                                        <select name="handler_2[]" class="form-control">
                                                            @foreach($data_dosen as $d)
                                                                <option value="{{$d["id"]}}" {{($d["id"] == $row->penguji_satu->id)?"selected":""}}>{{$d["name"]}}</option>
                                                            @endforeach
                                                        </select>
                                                    </td>
                                                @else
                                                    <td>
                                                        <select name="handler_2[]" class="form-control">
                                                            <option value="" selected>== Pilih == </option>
                                                            @foreach($data_dosen as $d)
                                                                <option value="{{$d["id"]}}">{{$d["name"]}}</option>
                                                            @endforeach
                                                        </select>
                                                    </td>
                                                @endif
                                                @if(isset($row->penguji_dua->name))
                                                    <td>
                                                        <select name="handler_3[]" class="form-control">
                                                            @foreach($data_dosen as $d)
                                                                <option value="{{$d["id"]}}" {{($d["id"] == $row->penguji_dua->id)?"selected":""}}>{{$d["name"]}}</option>
                                                            @endforeach
                                                        </select>
                                                    </td>
                                                @else
                                                    <td>
                                                        <select name="handler_3[]" class="form-control">
                                                            <option value="" selected>== Pilih == </option>

                                                            @foreach($data_dosen as $d)
                                                                <option value="{{$d["id"]}}" >{{$d["name"]}}</option>
                                                            @endforeach
                                                        </select>
                                                    </td>
                                                @endif
                                                <td>
                                                    <a href="{{route("seminar.delete",$row->id)}}" class="btn btn-danger">
                                                        <li class="fa fa-trash"></li>
                                                    </a>
                                                </td>
                                            </tr>
                                        @endforeach

                                    @endif
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-12">
                                <button class="btn btn-success" type="submit">{{isset($route)?"Update": "Simpan"}}</button>
                            </div>
                        </div>
                    </form>

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
            @if(!isset($data))
            function add_form(data = []){
                const _list_mhs = function (def_id = null) {
                    let items = [];
                    const _mhs_data = JSON.parse('{!! $data_mhs !!}');
                    for (const _mhs_data_key in _mhs_data) {
                        items.push(([
                            "<option value='"+_mhs_data[_mhs_data_key].id+"'>"+_mhs_data[_mhs_data_key].name+"</option>",
                        ]).join(""))
                    }
                    let _list = [
                        "<div class='form-group'>",
                        "<select class='form-control' name='user_id[]'>",
                        items.join(""),
                        "</select>",
                        "</div>"
                    ];
                    return _list.join("");
                };
                const _list_dosen = function (def_id = null,num=1) {
                    let items = [];
                    const _mhs_data = JSON.parse('{!! $data_dosen !!}');
                    for (const _mhs_data_key in _mhs_data) {
                        items.push(([
                            "<option value='"+_mhs_data[_mhs_data_key].id+"'>"+_mhs_data[_mhs_data_key].name+"</option>",
                        ]).join(""))
                    }
                    let _list = [
                        "<div class='form-group'>",
                        "<select class='form-control' name='handler_"+num+"[]'>",
                        items.join(""),
                        "</select>",
                        "</div>"
                    ];
                    return _list.join("");
                };
                const _list_room = function (def_id = null) {
                    let items = [];
                    const _mhs_data = JSON.parse('{!! $data_ruangan !!}');
                    for (const _mhs_data_key in _mhs_data) {
                        items.push(([
                            "<option value='"+_mhs_data[_mhs_data_key].id+"'>"+_mhs_data[_mhs_data_key].name+"</option>",
                        ]).join(""))
                    }
                    let _list = [
                        "<div class='form-group'>",
                        "<select class='form-control' name='room_id[]'>",
                        items.join(""),
                        "</select>",
                        "</div>"
                    ];
                    return _list.join("");
                };
                const _form = function (no=1,data = []) {
                    let _build = [];
                    if(data.length === 0){
                        _build = [
                            "<tr>",
                            `<td>${_list_mhs()}</td>`,
                            `<td>${_list_dosen(null,1)}</td>`,
                            `<td>${_list_room()}</td>`,
                            `<td><input class="form-control time"  name="time_start[]" /></td>`,
                            `<td><input class="form-control time"  name="time_end[]" /></td>`,
                            @if(isset($route))
                            `<td>${_list_dosen(null,2)}</td>`,
                            `<td>${_list_dosen(null,3)}</td>`,
                            @endif
                            `<td><button class="btn btn-danger" onclick="return $(this).parent().parent().remove()" type="button">Hapus</button></td>`,
                            "</tr>",
                        ];
                    }else{

                    }
                    return _build;
                };
                return _form(1,data);
            }
            $("#add_mhs").on("click",function () {
                $("#mhs_list").append(add_form().join(""));
                $("#mhs_list").find(".time").timepicker({
                    showSeconds: true,
                    showMeridian: false,
                    defaultTime: false,
                    minuteStep: 1,
                });
            });
            @endif

            $("#room").on("change",function () {
                const v = parseInt($(this).val());
                const c = "{{(explode("&",url()->current()))[0]}}";
                if((v - 9999)){
                    location.href = c+"?date={{$sdate}}&room_id="+v;
                }else{
                    location.href = c+"?date={{$sdate}}";
                }
            })
            $("#mhs_list").find(".time").timepicker({
                showSeconds: true,
                showMeridian: false,
                defaultTime: false,
                minuteStep: 1,
            });

        })
    </script>
@stop
