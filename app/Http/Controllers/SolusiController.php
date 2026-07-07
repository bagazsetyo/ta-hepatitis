<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Penyakit;
use App\Models\Solusi;


class SolusiController extends Controller
{
public function index()
    {
        $penyakit               = Penyakit::orderBy('penyakit','asc')->get();
        $solusi                 = Solusi::join('penyakits','penyakits.id','id_penyakit')
                                            ->select('solusis.*','penyakits.penyakit')
                                            ->get();


        return view('solusi.index', compact('penyakit','solusi'));
    }


    public function store(Request $request)
    {
        $solusi                             = new Solusi();
        $solusi->id_penyakit                = $request->penyakit;
        $solusi->kode                       = rand(0, 9999999);
        $solusi->deskripsi                  = $request->deskripsi;
        $solusi->save();


        toastr()->success('Berhasil Menyimpan Data Pasien');
        return back();
    }

    public function update(Request $request, $id)
    {

            $solusi                        = Solusi::find($id);
            $solusi->id_penyakit           = $request->penyakit;
            $solusi->deskripsi             = $request->deskripsi;
            $solusi->save();


            toastr()->success('Berhasil Update Data Pasien');

            return back();
        
    }
}
