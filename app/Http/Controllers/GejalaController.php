<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Gejala;


class GejalaController extends Controller
{
    public function index()
    {
        $gejala             = Gejala::orderBy('gejala','asc')->get();


        return view('gejala.index', compact('gejala'));
    }


    public function store(Request $request)
    {
        $cgejala                        = Gejala::where('kode', $request->kode)->first();
        if($cgejala)
        {
            toastr()->error('Kode Sudah Terdaftar');
            return back();
        } 
        else
        {
            $gejala                         = new Gejala();
            $gejala->kode                   = $request->kode;
            $gejala->gejala                 = $request->gejala;
            $gejala->nilai                  = $request->nilai;
            $gejala->save();


            toastr()->success('Berhasil Menyimpan Data Pasien');

            return back();
        }
    }

    public function update(Request $request, $id)
    {

            $gejala                         = Gejala::find($id);
            $gejala->kode                   = $request->kode;
            $gejala->gejala                 = $request->gejala;
            $gejala->nilai                  = $request->nilai;
            $gejala->save();


            toastr()->success('Berhasil Update Data Pasien');

            return back();
        
    }
}
