@extends('layouts.app')
    @section('pasiens', 'active')
@section('content')
<div class="row">
    <div class="col-md-3">
        <div class="box box-primary">
            <div class="box-body box-profile">
                <img class="profile-user-img img-responsive img-circle" src="/assets/dist/img/user4-128x128.jpg" alt="User profile picture">

                <h3 class="profile-username text-center">{{$pasien->nama_lengkap}}</h3>

                <ul class="list-group list-group-unbordered">
                    <li class="list-group-item">
                        <b>{{$pasien->nik}}</b> 
                    </li>
                    <li class="list-group-item">
                        <b>{{$pasien->handphone}}</b> 
                    </li>
                    <li class="list-group-item">
                        <b>{{$pasien->jenis_kelamin}}</b> 
                    </li>
                </ul>
            </div>
        </div>
    </div>
        <!-- /.col -->
    <div class="col-md-9">
        <div class="nav-tabs-custom">
            <ul class="nav nav-tabs">
                <li class="active"><a href="#profil" data-toggle="tab">Profil</a></li>
                <li><a href="#diagnosa" data-toggle="tab">Diagnosa</a></li>
            </ul>
            <div class="tab-content">
                <div class="active tab-pane" id="profil">
                    <div class="post">
                        <table class="table table-striped table-hover">
                            <tr>
                                <td>Nama Lengkap</td>
                                <td>:</td>
                                <td>{{$pasien->nama_lengkap}}</td>
                            </tr>
                            <tr>
                                <td>NIK</td>
                                <td>:</td>
                                <td>{{$pasien->nik}}</td>
                            </tr>
                            <tr>
                                <td>Handphone</td>
                                <td>:</td>
                                <td>{{$pasien->handphone}}</td>
                            </tr>
                            <tr>
                                <td>Jenis Kelamin</td>
                                <td>:</td>
                                <td>{{$pasien->jenis_kelamin}}</td>
                            </tr>
                            <tr>
                                <td>Tempat Lahir</td>
                                <td>:</td>
                                <td>{{$pasien->tempat_lahir}}</td>
                            </tr>
                            <tr>
                                <td>Tanggal Lahir</td>
                                <td>:</td>
                                <td>{{date('d-m-Y', strtotime($pasien->tanggal_lahir))}}</td>
                            </tr>
                            <tr>
                                <td>Alamat</td>
                                <td>:</td>
                                <td>{{$pasien->alamat_ktp}}</td>
                            </tr>
                            <tr>
                                <td>Agama</td>
                                <td>:</td>
                                <td>{{$pasien->agama}}</td>
                            </tr>
                            <tr>
                                <td>Pekerjaan</td>
                                <td>:</td>
                                <td>{{$pasien->pekerjaan}}</td>
                            </tr>
                            <tr>
                                <td>Status Pernikahan</td>
                                <td>:</td>
                                <td>{{$pasien->status_pernikahan}}</td>
                            </tr>
                        </table>
                    </div>
                </div>
              <div class="tab-pane" id="diagnosa">
                    <div class="post">
                        <table class="table table-striped table-hover">
                            <tr>
                                <th>No</th>
                                <th>Tanggal</th>
                            </tr>
                            @foreach($diagnosa as $no=>$val)
                            <tr>
                                <td>{{$no+1}}</td>
                                <td>{{date('d-m-Y', strtotime($val->tanggal))}}</td>
                                <td>
                                    <a href="/diagnosis/show{{$val->id}}" class="btn btn-xs btn-primary">
                                        <i class="ace-icon fa fa-eye bigger-130"></i>
                                    </a>
                                </td>
                            </tr>
                            @endforeach
                        </table>
                    </div>
              </div>
          </div>
        </div>
        <!-- /.col -->
      </div>
@endsection

