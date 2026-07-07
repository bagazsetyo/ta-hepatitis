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
                <h3 class="box-title">FORM DIAGNOSA</h3>
            </div>
            <div class="box box-solid">
                <div class='box-body'>
                    <form action="/diagnosis/proses" method="POST">
                        @csrf
                        <div class="form-group">
                            <label>Pasien</label>
                            <select class="form-control select2" name="pasien" style="width: 100%;" required>
                                <option value selected>Pilih Pasien</option>
                                @foreach($pasien as $val)
                                    <option value="{{$val->id}}">{{$val->nama_lengkap}}</option>
                                @endforeach
                            </select>
                        </div>
                        <ul class="custom-list-group">
                            @foreach($gejalas as $gejala)
                                <li class="list-groupitem">
                                    <input type="checkbox" class="flat-red" name="gejala[]" value="{{ $gejala->id }}" >
                                    <label class="label label-info" style="margin-right:15px; margin-left: 15px;"> {{ $gejala->kode }} </label>
                                    <span class="text"> {{ $gejala->gejala }}</span>     
                                </li>
                            @endforeach
                        </ul>
                        <div class="modal-footer">
                            <button type="submit" class="btn btn-success"><i class="fa fa-dashboard"></i>  Mulai Diagnosis</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

