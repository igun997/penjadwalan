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
                        <form action="" method="post">
                            <div class="row">
                                <div class="col-12">
                                        @csrf
                                        <div class="form-group">
                                            <label>Tanggal Seminar</label>
                                            <input type="date" class="form-control" />
                                        </div>
                                </div>
                               <div class="col-12">
                                   <div class="form-group">
                                       <button class="btn btn-success" type="button" id="add_mhs">
                                           <li class="fa fa-plus"></li>
                                       </button>
                                   </div>
                               </div>
                                <div class="col-12 table-responsive">
                                    <table class="table table-bordered">
                                        <thead>
                                            <tr>
                                                <th>Nama MHS</th>
                                                <th>Pembimbing</th>
                                                <th>Penguji 1</th>
                                                <th>Penguji 2</th>
                                                <th>Waktu Mulai</th>
                                                <th>Waktu Selesai</th>
                                                <th>Aksi</th>
                                            </tr>
                                        </thead>
                                        <tbody id="mhs_list">

                                        </tbody>
                                    </table>
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
                const _form = function (no=1,data = []) {
                    let _build = [];
                    if(data.length === 0){
                        _build = [
                            "<tr>",
                            `<td>${_list_mhs()}</td>`,
                            `<td>${_list_dosen(null,1)}</td>`,
                            `<td>${_list_dosen(null,2)}</td>`,
                            `<td>${_list_dosen(null,3)}</td>`,
                            `<td><input class="form-control" type="text" name="time_start[]" /></td>`,
                            `<td><input class="form-control" type="text" name="time_end[]" /></td>`,
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
            })
        })
    </script>
@stop
