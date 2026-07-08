@extends('layouts.app')
    @section('diagnosa', 'active')
    
@section('content')
<style>
    .custom-list-group {
          list-style-type: none; /* Removes default bullets */
          padding: 0;
          margin: 0;
          border-radius: 4px;
    }
    .list-groupitem {
        padding: 12px 16px;
        background-color: #ffffff;
        color: #333333;
        font-family: sans-serif;
        font-size: 16px;
    }
</style>
<div class="row">
    <div class="col-md-12">
        <div class='box '>
            <div class="box-header with-border">
                <h3 class="box-title">DIAGNOSA</h3>
            </div>
            <div class="box box-solid">
                <div class='box-body '>
                    <div class="col-md-12 row">
                        <div class="col-md-6">
                            <table class="table table-striped table-hover">
                                <tr>
                                    <td>Nama Lengkap</td>
                                    <td>:</td>
                                    <td>{{$pakar->nama_lengkap}}</td>
                                </tr>
                                <tr>
                                    <td>Handphone</td>
                                    <td>:</td>
                                    <td>{{$pakar->handphone}}</td>
                                </tr>
                                <tr>
                                    <td>Nik</td>
                                    <td>:</td>
                                    <td>{{$pakar->nik}}</td>
                                </tr>
                                <tr>
                                    <td>Jenis Kelamin</td>
                                    <td>:</td>
                                    <td>{{$pakar->jenis_kelamin}}</td>
                                </tr>
                                <tr>
                                    <td>Tanggal Lahir</td>
                                    <td>:</td>
                                    <td>{{date('d-m-Y', strtotime($pakar->tanggal_lahir))}}</td>
                                </tr>
                            </table>
                        </div>
                    </div>
                   
                    <div class="col-md-12 row">
                        <hr>
                        <span><center>HASIL DIAGNOSIS</center></span>
                        <hr>
                        
                        <div class="col-md-6">    
                                          
                            <label>
                                 <div class="widget-user-header bg-info">
                                    <center>
                                        <h2 class="widget-user-username">JENIS PENYAKIT DENGAN GEJALA TERKAIT</h2>
                                    </center>
                                </div>
                           
                            </label>
                            <div class="widget-user-header bg-blue">
                                <center>
                                <div class="widget-user-image">
                                    <img class="img-circle" src="/assets/img/logo.png" width="20%" alt="User Avatar">
                                </div>
                                    <h2 class="widget-user-username">Memiliki Nilai {{$pakar->nilai}} %</h2> 
                                    <h3 class="widget-user-desc">{{$penyakit->kode}} - {{$penyakit->penyakit}} </h3><br>
                                    <span>{{$penyakit->solusi}}</span>
                                </center>
                            </div>
                          
                                    

                        </div>
                        <div class="col-md-6">
                            <table class="table table-striped table-hover">
                                <tr>
                                    <th>No</th>
                                    <th>Kode</th>
                                    <th>Nama Gejala</th>
                                </tr>
                                @foreach($gejalapakar as $no=>$item )
                                <tr>
                                    <td>{{$no+1}}</td>
                                    <td>{{$item->kode}}</td>
                                    <td>{{$item->gejala}}</td>
                                </tr>
                                @endforeach
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

