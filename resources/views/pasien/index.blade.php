@extends('layouts.app')
    @section('pasiens', 'active')
@section('content')
<div class="row">
    <div class="col-md-12">
        <div class='box '>
            <div class="box-header with-border">
                <h3 class="box-title">Pasien</h3>
                <button type="button" class="btn btn-sm btn-info dim btn-sm-dim pull-right" data-toggle="modal" data-target="#addbarang"><i class="fa fa-plus-circle"></i></button>
            </div>

            <div class='box-body'>
                <div class='table-responsive'>
                    <table id="" data-ajax-url="" class="table table-striped  dataTab" style="width:100% !important">

                        <thead>
                        <tr>
                            <th>No</th>
                            <th>Nik</th>
                            <th>Nama Lengkap</th>
                            <th>Jenis Kelamin</th>
                            <th>Handphone</th>
                            <th class="hidden-480"></th>
                        </tr>
                        </thead>

                        <tbody>
                            <tr>
                                @foreach($pasien as $no=>$items)
                                <td>
                                    <a href="#">{{$no+1}}</a>
                                </td>
                                <td>{{$items->nik}}</td>
                                <td>{{$items->nama_lengkap}}</td>
                                <td>{{$items->jenis_kelamin}}</td>
                                <td>{{$items->handphone}}</td>
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
                                            <h4 class="modal-title" id="myModalLabel"><span class="fa fa-pencil text-blue"></span>&nbsp;&nbsp;Edit Pasien</h4>
                                        </div>
                                        <form class="form-horizontal" role="form" action="update/{{$items->id}}pasien" method="POST">
                                        {{csrf_field()}}
                                        {{ method_field('post') }}
                                            <div class="modal-body row">
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label>Nama Pasien</label>
                                                        <input type="text" class="form-control" name='nama' required placeholder="Nama Pasien" value="{{$items->nama_lengkap}}">
                                                    </div>
                                                    <div class="form-group">
                                                        <label>Nik</label>
                                                        <input type="text" class="form-control" name='nik' required placeholder="Nomor Induk Kependudukan" value="{{$items->nik}}">
                                                    </div>
                                                    <div class="form-group">
                                                        <label>Email</label>
                                                        <input type="email" class="form-control" name='email' required placeholder="Email" value="{{$items->email}}">
                                                    </div>
                                                    <div class="form-group">
                                                        <label>Hp/WA</label>
                                                        <input type="text" class="form-control" name='hp' required placeholder="Nomor Hp atau WA" value="{{$items->handphone}}">
                                                    </div>
                                                    <div class="form-group">
                                                        <label>Jenis Kelamin</label>
                                                        <select class="form-control" name="jeniskelamin">
                                                            <option value selected>Pilih Jenis Kelamin</option>
                                                            <option @if($items->jenis_kelamin=="Laki-Laki") selected @endif  value="Laki-Laki">Laki-Laki</option>
                                                            <option @if($items->jenis_kelamin=="Perempuan") selected @endif value="Perempuan">Perempuan</option>
                                                        </select>
                                                    </div>
                                                    <div class="form-group">
                                                        <label>Tempat Lahir</label>
                                                        <input type="text" class="form-control" name='tempatlahir' required placeholder="Tempat Lahir" value="{{$items->tempat_lahir}}">
                                                    </div>
                                                    <div class="form-group">
                                                        <label>Tanggal Lahir</label>
                                                        <input type="text" class="form-control maxdate" name='tanggallahir' required placeholder="Nomor Hp atau WA" value="{{date('d-m-Y', strtotime($items->tanggal_lahir))}}">
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label>Alamat</label>
                                                        <textarea name="alamat" class="form-control" rows="4">{{$items->alamat_ktp}}</textarea>
                                                    </div>
                                                    <div class="form-group">
                                                        <label>Agama</label>
                                                        <select class="form-control" name="agama">
                                                            <option value selected>Pilih Agama</option>
                                                            <option @if($items->agama=="Kristen") selected @endif value="Kristen">Kristen</option>
                                                            <option @if($items->agama=="Katolik") selected @endif value="Katolik">Katolik</option>
                                                            <option @if($items->agama=="Islam") selected @endif value="Islam">Islam</option>
                                                            <option @if($items->agama=="Hindu") selected @endif value="Hindu">Hindu</option>
                                                            <option @if($items->agama=="Budha") selected @endif value="Budha">Budha</option>

                                                        </select>
                                                    </div>
                                                    <div class="form-group">
                                                        <label>Status Perkawinan</label>
                                                        <select class="form-control" name="menikah">
                                                            <option value selected>Pilih Status</option>
                                                            <option @if($items->status_pernikahan=="Belum Menikah") selected @endif value="Belum Menikah">Belum Menikah</option>
                                                            <option @if($items->status_pernikahan=="Menikah") selected @endif value="Menikah">Menikah</option>
                                                            <option @if($items->status_pernikahan=="Cerai") selected @endif value="Cerai">Cerai</option>


                                                        </select>
                                                    </div>
                                                    <div class="form-group">
                                                        <label>Pekerjaan</label>
                                                        <input type="text" class="form-control" name='pekerjaan' required placeholder="Pekerjaan" value="{{$items->pekerjaan}}">
                                                    </div>
                                                    <div class="form-group">
                                                        <label>Password</label>
                                                        <input type="password" class="form-control" name='password'  placeholder="Password">
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
    <div class="modal-dialog modal-lg modal-default" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title" id="myModalLabel"><span class="fa fa-plus-circle text-blue"></span>&nbsp;&nbsp;Tambah Pasien</h4>
            </div>
            <form class="form-login" role="form" action="/store/pasien" method="POST" enctype="multipart/form-data">
            {{csrf_field()}}
                <div class="modal-body row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Nama Pasien</label>
                            <input type="text" class="form-control" name='nama' required placeholder="Nama Pasien">
                        </div>
                        <div class="form-group">
                            <label>Nik</label>
                            <input type="text" class="form-control" name='nik' required placeholder="Nomor Induk Kependudukan">
                        </div>
                        <div class="form-group">
                            <label>Email</label>
                            <input type="email" class="form-control" name='email' required placeholder="Email">
                        </div>
                        <div class="form-group">
                            <label>Hp/WA</label>
                            <input type="text" class="form-control" name='hp' required placeholder="Nomor Hp atau WA">
                        </div>
                        <div class="form-group">
                            <label>Jenis Kelamin</label>
                            <select class="form-control" name="jeniskelamin">
                                <option value selected>Pilih Jenis Kelamin</option>
                                <option value="Laki-Laki">Laki-Laki</option>
                                <option value="Perempuan">Perempuan</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label>Tempat Lahir</label>
                            <input type="text" class="form-control" name='tempatlahir' required placeholder="Tempat Lahir">
                        </div>
                        <div class="form-group">
                            <label>Tanggal Lahir</label>
                            <input type="text" class="form-control maxdate" name='tanggallahir' required placeholder="Tanggal Lahir">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Alamat</label>
                            <textarea name="alamat" class="form-control" rows="4"></textarea>
                        </div>
                        <div class="form-group">
                            <label>Agama</label>
                            <select class="form-control" name="agama">
                                <option value selected>Pilih Agama</option>
                                <option value="Kristen">Kristen</option>
                                <option value="Katolik">Katolik</option>
                                <option value="Islam">Islam</option>
                                <option value="Hindu">Hindu</option>
                                <option value="Budha">Budha</option>

                            </select>
                        </div>
                        <div class="form-group">
                            <label>Status Perkawinan</label>
                            <select class="form-control" name="menikah">
                                <option value selected>Pilih Status</option>
                                <option value="Belum Menikah">Belum Menikah</option>
                                <option value="Menikah">Menikah</option>
                                <option value="Cerai">Cerai</option>


                            </select>
                        </div>
                        <div class="form-group">
                            <label>Pekerjaan</label>
                            <input type="text" class="form-control" name='pekerjaan' required placeholder="Pekerjaan">
                        </div>
                        <div class="form-group">
                            <label>Password</label>
                            <input type="password" class="form-control" name='password' required placeholder="Password">
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
@endsection

