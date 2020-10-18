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
                            <label>NIP</label>
                            <input type="number" class="form-control" name="nip" {{(isset($data->nip))?"disabled":""}} value="{{@$data->nip}}" required>
                        </div>
                        <div class="form-group">
                            <label>Nama Dosen</label>
                            <input type="text" class="form-control" name="name"  value="{{@$data->name}}" required>
                        </div>
                        <div class="form-group">
                            <label>Kelas</label>
                            <select name="kelas" class="form-control kelas" >
                                @if(isset($data->kelas) && @$data->kelas)
                                    <option value="{{$data->kelas}}" selected>{{$data->kelas}}</option>
                                @endif
                            </select>
                        </div>
                        <div class="form-group">
                            <label>Semester</label>
                            <select name="semester" class="form-control semester" >
                                @if(isset($data->semester) && @$data->semester)
                                    <option value="{{$data->semester}}" selected>{{$data->semester}}</option>
                                @endif
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
        $(".kelas").select2({
            tags: true,
            data:{!! json_encode(\App\Models\User::select("kelas as _id","kelas as text")->whereRaw("users.kelas IS NOT NULL")->get()) !!}
        });
        $(".semester").select2({
            tags: true,
            data:{!! json_encode(\App\Models\User::select("semester as _id","semester as text")->whereRaw("users.semester IS NOT NULL")->get()) !!}
        });
    </script>
@stop
