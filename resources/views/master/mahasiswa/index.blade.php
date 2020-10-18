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
                    <a href="{{route("master.mahasiswa.add")}}" class="btn btn-success ml-2 mb-4">
                        <li class="fa fa-plus"></li> Tambah Data
                    </a>
                    <button id="import" type="button" class="btn btn-primary ml-2 mb-4">
                        <li class="fa fa-upload"></li> Upload via Excel
                    </button>
                    <a href="{{route("template.mahasiswa")}}" class="btn btn-primary ml-2 mb-4">
                        <li class="fa fa-download"></li> Template Excel
                    </a>
                    <div class="table-responsive">
                        <table id="mahasiswa" class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>NIM</th>
                                    <th>Nama</th>
                                    <th>Status</th>
                                    <th>Dibuat</th>
                                    <th>Diubah</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($data as $num => $row)
                                    <tr>
                                        <td>{{($num+1)}}</td>
                                        <td>{{$row->username}}</td>
                                        <td>{{$row->name}}</td>
                                        <td>{{\App\Casts\StatusAccount::lang($row->status)}}</td>
                                        <td>{{$row->created_at->format("d-m-Y")}}</td>
                                        <td>{{$row->updated_at->format("d-m-Y")}}</td>
                                        <td>
                                            <a href="{{route("master.mahasiswa.update",$row->id)}}" class="btn btn-warning m-2">
                                                <li class="fa fa-edit"></li>
                                            </a>

                                            <a href="{{route("master.mahasiswa.delete",$row->id)}}" class="btn btn-danger m-2">
                                                <li class="fa fa-trash"></li>
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
            $("#mahasiswa").DataTable();
            $("#import").on("click",function () {
                var dialog = bootbox.dialog({
                    title: 'Upload Data',
                    message: '<p align="center"><i class="fa fa-spin fa-spinner"></i> Loading...</p>'
                });

                dialog.init(function(){
                    setTimeout(function(){
                        var form = [
                            "<form action='{{route("master.mahasiswa.add.action")}}' method='post' enctype='multipart/form-data'>",
                            "<div class='form-group'>",
                            "<label>Masukan File Excel</label>",
                            "<input type='file' name='file' accept='application/vnd.ms-excel' class='form-control' required>",
                            "</div>",
                            "<div class='form-group'>",
                            "<button type='submit' class='btn btn-success'>Upload</button>",
                            "</div>",
                            "</form>"
                        ]
                        dialog.find('.bootbox-body').html(form.join(""));
                    }, 100);
                });
            })
        });
    </script>
@stop
