@extends('adminlte::page')

@section('title', ((isset($title))?$title:""))

@section('content_header')

@stop

@section('content')
    <div class="row">
        <div class="col-6 offset-3">
            <div class="card">
                <div class="card-header">
                    <div class="card-title">{{((isset($title))?$title:"")}}</div>
                </div>
                <div class="card-body">
                    <form action="{{$route}}" method="post">
                        <div class="form-group">
                            <label>NIM</label>
                            <input type="number" class="form-control" name="username" {{(isset($data->username))?"disabled":""}} value="{{@$data->username}}" required>
                        </div>
                        <div class="form-group">
                            <label>Nama Mahasiswa</label>
                            <input type="text" class="form-control" name="name"  value="{{@$data->name}}" required>
                        </div>
                        <div class="form-group">
                            <label>Password</label>
                            <input type="password" class="form-control" name="password"  value="{{@$data->password}}" required>
                        </div>
                        <div class="form-group">
                            <label>Aktif ? </label>
                            <select name="status" class="form-control" >
                                <option value="1" {{(@$data->status == 1)?"selected":""}}>Aktif</option>
                                <option value="0" {{(@$data->status == 0)?"selected":""}}>Tidak Aktif</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <button class="btn btn-primary btn-block btn-lg">Simpan Data</button>
                        </div>
                    </form>
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

    </script>
@stop
