@extends('adminlte::page')

@section('title', ((isset($title))?$title:""))

@section('content_header')

@stop

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <div class="card-title">{{$title}}</div>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-12">
                            <table class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Hari / Tgl</th>
                                        <th>Waktu</th>
                                        <th>Nama Mahasiswa</th>
                                        <th>NIM</th>
                                        <th>Pembimbing</th>
                                        <th>Pemimpin Sidang</th>
                                        <th>Penguji</th>
                                    </tr>
                                </thead>
                                <tbody>
                                @foreach($jadwal as $k => $r)
                                    <tr >
                                        <td>{{$k+1}}</td>
                                        <td>{{$r->start_date->format("d/m/Y")}}</td>
                                        <td>{{$r->start_time}} - {{$r->end_time}}</td>
                                        <td {{($r->user_id == session()->get("id"))?'class=bg-danger':""}}>{{$r->user->name}}</td>
                                        <td>{{$r->user->username}}</td>
                                        <td {{@($r->pembimbing->nip == session()->get("nip"))?'class=bg-danger':""}}>{{$r->pembimbing->name ?? "-"}}</td>
                                        <td {{@($r->pembimbing->nip == session()->get("nip"))?'class=bg-danger':""}}>{{$r->penguji_satu->name ?? "-"}}</td>
                                        <td {{@($r->pembimbing->nip == session()->get("nip"))?'class=bg-danger':""}}>{{$r->penguji_dua->name ?? "-"}}</td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                        </div>
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
//assumption: the column that you wish to rowspan is sorted.

            //this is where you put in your settings
            const spanner = (need_span)=>{
                for (const need_span_key in need_span) {
                    var indexOfColumnToRowSpan = need_span[need_span_key];
                    var $table = $('table');


                    //this is the code to do spanning, should work for any table
                    var rowSpanMap = {};
                    $table.find('tr').each(function(){
                        var valueOfTheSpannableCell = $($(this).children('td')[indexOfColumnToRowSpan]).text();
                        $($(this).children('td')[indexOfColumnToRowSpan]).attr('data-original-value', valueOfTheSpannableCell);
                        rowSpanMap[valueOfTheSpannableCell] = true;
                    });

                    for(var rowGroup in rowSpanMap){
                        var $cellsToSpan = $('td[data-original-value="'+rowGroup+'"]');
                        var numberOfRowsToSpan = $cellsToSpan.length;
                        $cellsToSpan.each(function(index){
                            if(index==0){
                                $(this).attr('rowspan', numberOfRowsToSpan);
                            }else{
                                $(this).hide();
                            }
                        });
                    }
                }

            }
            spanner([1,2]);
        })
    </script>
@stop
