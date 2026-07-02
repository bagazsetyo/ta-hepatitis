@extends('layouts.app')

@section('content')
<div class="box">
    <div class="box-body">
        <div class="row">
        <div class="col-md-12">
            <br>
            <br>    
            <center>
                <img src="/assets/img/logo.png" width="30%">
            </center>
            <br>
            <center>
                <br>
                <span style="font-size: 48px;">
                    <b>SELAMAT DATANG</b>
                </span>
                <br>
                <br>
                <label style="font-size: 34px;">
                    
                </label>
                <br>
                <br>
                <label>
                    {{Auth::user()->nama}}
                </label>
            </center>
          </div>    
        </div>
    </div>
</div>

@endsection
