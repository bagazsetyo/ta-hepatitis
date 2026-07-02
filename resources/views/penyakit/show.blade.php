@extends('layouts.app')
    @section('penyakit', 'active')
@section('content')
<div class="row">
    <div class="col-md-12">
        <div class='box '>
            <div class="box-header with-border">
                <h3 class="box-title">Detail Penyakit</h3>
                <button type="button" class="btn btn-sm btn-info dim btn-sm-dim pull-right" data-toggle="modal" data-target="#add"><i class="fa fa-plus-circle"></i></button>
            </div>

            <div class='box-body'>
                      <div class="row invoice-info">
        <div class="col-sm-4 invoice-col">
          <address>
            <strong>{{$penyakit->penyakit}}</strong><br>
            {{$penyakit->kode}}<br>
          </address>
        </div>
        <!-- /.col -->
      </div>
      <!-- /.row -->

      <!-- Table row -->
        <span>
            DAFTAR GEJALA
        </span>
        <div class="row">
            <div class="col-xs-12 table-responsive">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Kode</th>
                            <th>Gejala</th>
                            <th>Nilai</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($pivpenyakit as $no=>$val)
                        <tr>
                          <td>{{$no+1}}</td>
                          <td>{{$val->kode}}</td>
                          <td>{{$val->gejala}}</td>
                          <td>{{number_format($val->nilai,0)}}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
      <!-- /.row -->

                <div class="row">
                    <div class="col-xs-6">
                        <p class="lead">Solusi:</p>
                        <p class="text-muted well well-sm no-shadow" style="margin-top: 10px;">
                            @if($solusi)
                                {{$solusi->deskripsi}}
                            @endif
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="add" role="dialog">
    <div class="modal-dialog modal-md modal-default" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title" id="myModalLabel"><span class="fa fa-plus-circle text-blue"></span>&nbsp;&nbsp;Tambah Gejala Penyakit {{$penyakit->penyakit}}</h4>
            </div>
            <form class="form-login" role="form" action="/store/gejala/penyakit" method="POST" enctype="multipart/form-data">
            {{csrf_field()}}
                <div class="modal-body">
                        <div class="form-group">
                            <label>Gejala</label>
                            <select class="form-control select2" name="gejala" style="width: 100%;">
                                <option value selected>Pilih Gejala</option>
                                @foreach($gejala as $val)
                                    <option value="{{$val->id}}">{{$val->kode}}-{{$val->gejala}}</option>
                                @endforeach
                            </select>
                        </div>
                        <input type="hidden" name="idpenyakit" value="{{$penyakit->id}}">
                        <div class="form-group">
                            <label>Nilai</label>
                            <input type="number" name="nilai" required step=".01" class="form-control">
                        </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary">Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div> 
@endsection

