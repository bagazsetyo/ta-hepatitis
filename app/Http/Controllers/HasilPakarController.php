<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\HasilPakar;
use App\Models\PivotHasilPakar;
use App\Models\Gejala;
use App\Models\Pasien;
use App\Models\Penyakit;

class HasilPakarController extends Controller
{

    public function index()
    {
        $gejalas                = Gejala::orderBy('gejala','asc')->get();
        $pasien                 = Pasien::all();


        return view('diagnosa.index', compact('gejalas','pasien'));
    }

    public function proses(Request $request)
    {
        $pakar              = new HasilPakar();
        $pakar->id_pasien   = $request->pasien;
        $pakar->tanggal     = date('Y-m-d');
        if($pakar->save())
        {
            foreach ($request->gejala as $key => $value) {
                $phpakar                        = new PivotHasilPakar(); 
                $phpakar->id_hasil              = $pakar->id;
                $phpakar->id_gejala             = $value;
                $phpakar->save();  
            }

        toastr()->success('Diagnosis berhasil');

        return redirect('/diagnosis/show'.$pakar->id);

        }





    }

    public function show($id)
    {
        $pakar              = HasilPakar::join('pasiens','pasiens.id','id_pasien')
                                        ->select('hasil_pakars.*','pasiens.*')
                                        ->where('hasil_pakars.id',$id)
                                        ->first();

        $phpakar            = PivotHasilPakar::join('gejalas','gejalas.id','id_gejala')
                                            ->join('pivot_penyakits','pivot_penyakits.id_gejala','gejalas.id')
                                            ->select('gejalas.*','pivot_penyakits.id_penyakit as idpenyakit')
                                            ->where('id_hasil', $id)
                                            ->get();

        $gejalapakar        = PivotHasilPakar::join('gejalas','gejalas.id','id_gejala')
                                            ->select('gejalas.*')
                                            ->where('id_hasil', $id)
                                            ->get();

        $totdata            = count($gejalapakar);

        $dpenyakit          =  PivotHasilPakar::join('gejalas','gejalas.id','id_gejala')
                                                ->join('pivot_penyakits','pivot_penyakits.id_gejala','gejalas.id')
                                                ->join('penyakits','penyakits.id','pivot_penyakits.id_penyakit')
                                                ->select('penyakits.id')
                                                ->groupBy('penyakits.id')
                                                ->where('id_hasil', $id)
                                                ->get();
        
        foreach ($dpenyakit as $key => $value) {
            $kode[]           = $value->id;
        }

       
        $penyakit           = Penyakit::leftJoin('solusis','solusis.id_penyakit','penyakits.id')
                                        ->select('penyakits.*','solusis.deskripsi')
                                        ->whereIn('penyakits.id',$kode)->get();



        return view('diagnosa.show', compact('pakar','phpakar','penyakit','gejalapakar','totdata'));
    }


    public function indexLaporan()
    {
        return view('report.index');
    }
}
