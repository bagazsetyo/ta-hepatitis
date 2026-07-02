@extends('layouts.app')
    @section('gejala', 'active')
@section('content')
<div class="row">
    <div class="col-md-12">
        <div class='box '>
            <div class="box-header with-border">
                <h3 class="box-title">Gejala</h3>
                <button type="button" class="btn btn-sm btn-info dim btn-sm-dim pull-right" data-toggle="modal" data-target="#addbarang"><i class="fa fa-plus-circle"></i></button>
            </div>

            <div class='box-body'>
                <div class='table-responsive'>
                    <table id="" data-ajax-url="" class="table table-striped  dataTab" style="width:100% !important">

                        <thead>
                        <tr>
                            <th>No</th>
                            <th>Kode</th>
                            <th>Gejala</th>
                            <th>Nilai</th>
                            <th class="hidden-480"></th>
                        </tr>
                        </thead>

                        <tbody>
                            <tr>
                                @foreach($gejala as $no=>$items)
                                <td>
                                    <a href="#">{{$no+1}}</a>
                                </td>
                                <td>{{$items->kode}}</td>
                                <td>{{$items->gejala}}</td>
                                <td>{{$items->nilai}}</td>
                                <td>
                                    <div class="hidden-sm hidden-xs action-buttons">
                                        <a class="green" href="#" data-toggle="modal" data-target="#edit{{$items->id}}">
                                            <i class="ace-icon fa fa-pencil bigger-130"></i>
                                        </a>
                                    </div>
                                </td>
                            </tr>

                           <div class="modal fade" id="edit{{$items->id}}" role="dialog" enctype="multipart/form-data">
                                <div class="modal-dialog modal-lg">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                                            <h4 class="modal-title" id="myModalLabel"><span class="fa fa-pencil text-blue"></span>&nbsp;&nbsp;Edit Gejala</h4>
                                        </div>
                                        <form class="form-horizontal" role="form" action="update/{{$items->id}}gejala" method="POST">
                                        {{csrf_field()}}
                                        {{ method_field('post') }}
                                            <div class="modal-body row">
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label>Kode</label>
                                                        <input type="text" class="form-control" name='kode' required placeholder="Kode" value="{{$items->kode}}">
                                                    </div>
                                                    <div class="form-group">
                                                        <label>Gejala</label>
                                                        <input type="text" class="form-control" name='gejala' required placeholder="gejala" value="{{$items->gejala}}">
                                                    </div>
                                                    <div class="form-group">
                                                        <label>Nilai</label>
                                                        <input type="number" class="form-control" name='nilai' required placeholder="Nilai" value="{{$items->nilai}}">
                                                    </div>
                                                    
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
                <h4 class="modal-title" id="myModalLabel"><span class="fa fa-plus-circle text-blue"></span>&nbsp;&nbsp;Tambah Gejala</h4>
            </div>
            <form class="form-login" role="form" action="/store/gejala" method="POST" enctype="multipart/form-data">
            {{csrf_field()}}
                <div class="modal-body ">
                        <div class="form-group">
                            <label>Kode</label>
                            <input type="text" class="form-control" name='kode' required placeholder="Kode">
                        </div>
                        <div class="form-group">
                            <label>Gejala</label>
                            <input type="text" class="form-control" name='gejala' required placeholder="gejala" >
                        </div>
                        <div class="form-group">
                            <label>Nilai</label>
                            <input type="number" class="form-control" name='nilai' required placeholder="Nilai" >
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

