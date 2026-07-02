@extends('layouts.app')
    @section('solusi', 'active')
@section('content')
<div class="row">
    <div class="col-md-12">
        <div class='box '>
            <div class="box-header with-border">
                <h3 class="box-title">Solusi</h3>
                <button type="button" class="btn btn-sm btn-info dim btn-sm-dim pull-right" data-toggle="modal" data-target="#add"><i class="fa fa-plus-circle"></i></button>
            </div>

            <div class='box-body'>
                <div class='table-responsive'>
                    <table id="" data-ajax-url="" class="table table-striped  dataTab" style="width:100% !important">

                        <thead>
                        <tr>
                            <th>No</th>
                            <th>Penyakit</th>
                            <th width="30%">Deskripsi</th>
                            <th class="hidden-480"></th>
                        </tr>
                        </thead>

                        <tbody>
                            <tr>
                                @foreach($solusi as $no=>$items)
                                <td>
                                    <a href="#">{{$no+1}}</a>
                                </td>
                                <td>{{$items->penyakit}}</td>
                                <td>{{$items->deskripsi}}</td>
                                <td>
                                    <button class="btn btn-xs btn-warning" data-toggle="modal" data-target="#edit{{$items->id}}">
                                         <i class="ace-icon fa fa-pencil bigger-130"></i>
                                    </button>

                                </td>
                            </tr>

                           <div class="modal fade" id="edit{{$items->id}}" role="dialog" enctype="multipart/form-data">
                                <div class="modal-dialog modal-md">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                                            <h4 class="modal-title" id="myModalLabel"><span class="fa fa-pencil text-blue"></span>&nbsp;&nbsp;Edit Solusi</h4>
                                        </div>
                                        <form class="form-horizontal" role="form" action="update/{{$items->id}}penyakit" method="POST">
                                        {{csrf_field()}}
                                        {{ method_field('post') }}
                                            <div class="modal-body">
                                                <div class="form-group">
                                                    <label>Penyakit</label>
                                                    <select class="form-control" name="penyakit">
                                                        <option value selected>Pilih Penyakit</option>
                                                        @foreach($penyakit as $val)
                                                            <option value="{{$val->id}}">{{$val->penyakit}}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                                <div class="form-group">
                                                    <label>Deskripsi</label>
                                                    <textarea class="form-control" name="deskripsi" rows="14">{{$items->deskripsi}}</textarea>
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


<div class="modal fade" id="add" role="dialog">
    <div class="modal-dialog modal-md modal-default" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title" id="myModalLabel"><span class="fa fa-plus-circle text-blue"></span>&nbsp;&nbsp;Tambah Solusi</h4>
            </div>
            <form class="form-login" role="form" action="/store/solusi" method="POST" enctype="multipart/form-data">
            {{csrf_field()}}
                <div class="modal-body">
                        <div class="form-group">
                            <label>Penyakit</label>
                            <select class="form-control" name="penyakit">
                                <option value selected>Pilih Penyakit</option>
                                @foreach($penyakit as $val)
                                    <option value="{{$val->id}}">{{$val->penyakit}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label>Deskripsi</label>
                            <textarea class="form-control" name="deskripsi" rows="14"></textarea>
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

