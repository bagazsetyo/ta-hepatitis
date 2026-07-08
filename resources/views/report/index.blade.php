@extends('layouts.app')
    @section('report', 'active')
@section('content')
<div class="row">
    <div class="col-md-12">
        <div class='box '>
            <div class="box-header with-border">
                <h3 class="box-title">LAPORAN</h3>
               
            </div>

            <div class='box-body'>
                <br>
                    <label>
                        K-MEANS PASIEN BERDASARKAN PENYAKIT
                    </label>
                    <hr>
                    <table class="table table-bordered table-hover" style="border: 1px;">
                        <tr>
                            <th>No</th>
                            <th>Nama Pasien</th>
                            @foreach($penyakit as $val)
                                <th>
                                    <center>{{$val->penyakit}}</center>
                                </th>
                            @endforeach
                        </tr>
                        @foreach($pasien as $no=>$ps)       
                        <tr>
                            <td>{{$no+1}}</td>
                            <td>{{$ps->nama_lengkap}}</td>
                            @foreach($penyakit as $val)
                            @php 
                                $nilai =0;
                            @endphp
                            <td>
                                @foreach($clusterpenyakit as $clas)
                                    @if($ps->id==$clas->idpasien && $clas->idpenyakit==$val->id)
                                        @php 
                                            $nilai =1;
                                        @endphp
                                    @endif
                                @endforeach
                                <center>{{$nilai}}</center>
                            </td>
                             @endforeach
                        </tr>
                        @endforeach
                    </table>
                    <hr>
                    <label>
                        K-MEANS PASIEN BERDASARKAN GEJALA
                    </label>
                    <hr>
                    <table class="table table-bordered table-hover">
                        <tr>
                            <th>No</th>
                            <th>Nama Pasien</th>
                            @foreach($gejala as $val)
                                <th>{{$val->gejala}}</th>
                            @endforeach
                        </tr>
                        @foreach($pasien as $no=>$ps)
                        <tr>
                            <td>{{$no+1}}</td>
                            <td>{{$ps->nama_lengkap}}</td>
                            @foreach($gejala as $val)
                            @php 
                                $nilai =0;
                            @endphp
                            <td>
                                @foreach($clustergejala as $clas)
                                    @if($ps->id==$clas->idpasien && $clas->idgejala==$val->id)
                                        @php 
                                            $nilai =1;
                                        @endphp
                                    @endif
                                @endforeach
                                <center>{{$nilai}}</center>
                            </td>
                             @endforeach
                        </tr>
                        @endforeach
                    </table>
            </div>
        </div>
    </div>
</div>



@endsection

