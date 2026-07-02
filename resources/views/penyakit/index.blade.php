@extends('layouts.app')
    @section('penyakit', 'active')
@section('content')
<div class="row">
    <div class="col-md-12">
        <div class='box '>
            <div class="box-header with-border">
                <h3 class="box-title">Penyakit</h3>
                <button type="button" class="btn btn-sm btn-info dim btn-sm-dim pull-right" data-toggle="modal" data-target="#addbarang"><i class="fa fa-plus-circle"></i></button>
            </div>

            <div class='box-body'>
                <div class='table-responsive'>
                    <table id="" data-ajax-url="" class="table table-striped  dataTab" style="width:100% !important">

                        <thead>
                        <tr>
                            <th>No</th>
                            <th>Kode</th>
                            <th>Penyakit</th>
                            <th width="30%">Keterangan</th>
                            <th class="hidden-480"></th>
                        </tr>
                        </thead>

                        <tbody>
                            <tr>
                                @foreach($penyakit as $no=>$items)
                                <td>
                                    <a href="#">{{$no+1}}</a>
                                </td>
                                <td>{{$items->kode}}</td>
                                <td>{{$items->penyakit}}</td>
                                <td>{{$items->keterangan}}</td>
                                <td>
                                    <button class="btn btn-xs btn-warning" data-toggle="modal" data-target="#edit{{$items->id}}">
                                         <i class="ace-icon fa fa-pencil bigger-130"></i>
                                    </button>
                                    <a href="/detail/{{$items->id}}penyakit" class="btn btn-xs btn-primary">
                                         <i class="ace-icon fa fa-eye bigger-130"></i>
                                    </a>
                                </td>
                            </tr>

                           <div class="modal fade" id="edit{{$items->id}}" role="dialog" enctype="multipart/form-data">
                                <div class="modal-dialog modal-md">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                                            <h4 class="modal-title" id="myModalLabel"><span class="fa fa-pencil text-blue"></span>&nbsp;&nbsp;Edit Penyakit</h4>
                                        </div>
                                        <form class="form-horizontal" role="form" action="update/{{$items->id}}penyakit" method="POST">
                                        {{csrf_field()}}
                                        {{ method_field('post') }}
                                            <div class="modal-body">
                                                    <div class="form-group">
                                                        <label>Kode</label>
                                                        <input type="text" class="form-control" name='kode' required placeholder="Kode" value="{{$items->kode}}">
                                                    </div>
                                                    <div class="form-group">
                                                        <label>Penyakit</label>
                                                        <input type="text" class="form-control" name='penyakit' required placeholder="gejala" value="{{$items->penyakit}}">
                                                    </div>
                                                    <div class="form-group">
                                                        <label>Keterangan</label>
                                                        <textarea class="form-control" name="keterangan" rows="4">{{$items->keterangan}}</textarea>
                                                    </div>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="submit" class="btn btn-primary">Simpan</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>        
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>


<div class="modal fade" id="addbarang" role="dialog">
    <div class="modal-dialog modal-md modal-default" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title" id="myModalLabel"><span class="fa fa-plus-circle text-blue"></span>&nbsp;&nbsp;Tambah Penyakit</h4>
            </div>
            <form class="form-login" role="form" action="/store/penyakit" method="POST" enctype="multipart/form-data">
            {{csrf_field()}}
                <div class="modal-body">
                        <div class="form-group">
                            <label>Kode</label>
                            <input type="text" class="form-control" name='kode' required placeholder="Kode">
                        </div>
                        <div class="form-group">
                            <label>Penyakit</label>
                            <input type="text" class="form-control" name='penyakit' required placeholder="gejala" >
                        </div>
                        <div class="form-group">
                            <label>Keterangan</label>
                            <textarea class="form-control" name="keterangan" rows="4"></textarea>
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

