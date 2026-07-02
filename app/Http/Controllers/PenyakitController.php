<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Penyakit;
use App\Models\Gejala;
use App\Models\Solusi;
use App\Models\PivotPenyakit;

class PenyakitController extends Controller
{
    public function index()
    {
        $penyakit             = Penyakit::orderBy('penyakit','asc')->get();


        return view('penyakit.index', compact('penyakit'));
    }


    public function store(Request $request)
    {
        $cpenyakit                        = penyakit::where('kode', $request->kode)->first();
        if($cpenyakit)
        {
            toastr()->error('Kode Sudah Terdaftar');
            return back();
        } 
        else
        {
            $penyakit                         = new Penyakit();
            $penyakit->kode                   = $request->kode;
            $penyakit->penyakit               = $request->penyakit;
            $penyakit->keterangan             = $request->keterangan;
            $penyakit->save();


            toastr()->success('Berhasil Menyimpan Data Pasien');

            return back();
        }
    }

    public function update(Request $request, $id)
    {

            $penyakit                         = Penyakit::find($id);
            $penyakit->kode                   = $request->kode;
            $penyakit->penyakit               = $request->penyakit;
            $penyakit->keterangan             = $request->keterangan;
            $penyakit->save();


            toastr()->success('Berhasil Update Data Pasien');

            return back();
        
    }

    public function show($id)
    {
        $gejala                             = Gejala::all();
        $penyakit                           = Penyakit::find($id);
        $solusi                             = Solusi::where('id_penyakit',$id)->first();
        $pivpenyakit                        = PivotPenyakit::join('gejalas','gejalas.id','id_gejala')
                                                            ->select('gejalas.*')
                                                            ->where('id_penyakit', $id)
                                                            ->get();

        return view('penyakit.show', compact('gejala','penyakit','solusi','pivpenyakit'));
    }

    public function storeGejalaPenyakit(Request $request)
    {
        $checkpiv                       = PivotPenyakit::where('id_penyakit', $request->idpenyakit)
                                                        ->where('id_gejala', $request->gejala)
                                                        ->first();

        if($checkpiv)
        {
            toastr()->error('Gejala Sudah Terdaftar');
            return back();
        }
        else
        {
            $pivpenyakit                    = new PivotPenyakit();
            $pivpenyakit->id_penyakit       = $request->idpenyakit;
            $pivpenyakit->id_gejala         = $request->gejala;
            $pivpenyakit->nilai             = $request->nilai;
            $pivpenyakit->save();

            toastr()->success('Berhasil tambah data gejala penyakit');

            return back();
        }

    }
}
