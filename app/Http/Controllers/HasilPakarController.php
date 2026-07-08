<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\HasilPakar;
use App\Models\PivotHasilPakar;
use App\Models\Gejala;
use App\Models\Pasien;
use App\Models\Penyakit;
use App\Models\PivotPenyakit;
use Rubix\ML\Clusterers\KMeans;

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

        $gejalaTerpilih             =   $request->input('gejala');

        $hasilDiagnosa              = PivotPenyakit::select('id_penyakit', \DB::raw('count(*) as jumlah_cocok'), \DB::raw('sum(nilai) as nilai'))
                                        ->whereIn('id_gejala', $gejalaTerpilih)
                                        ->groupBy('id_penyakit')
                                        ->orderBy('jumlah_cocok', 'desc')
                                        ->first();

        $penyakit                   = PivotPenyakit::where('id_penyakit', $hasilDiagnosa->id_penyakit)
                                                    ->select(\DB::raw('sum(nilai) as nilai'))
                                                    ->first();

        $totnilai                   = number_format(($hasilDiagnosa->nilai/$penyakit->nilai)*100,2);

        $pakar                      = new HasilPakar();
        $pakar->id_pasien           = $request->pasien;
        $pakar->id_penyakit         = $hasilDiagnosa->id_penyakit;
        $pakar->nilai               = $totnilai;
        $pakar->tanggal             = date('Y-m-d');
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
        

   
       
        $penyakit           = Penyakit::leftJoin('solusis','solusis.id_penyakit','penyakits.id')
                                        ->select('penyakits.*','solusis.deskripsi')
                                        ->where('penyakits.id',$pakar->id_penyakit)
                                        ->first();





        return view('diagnosa.show', compact('pakar','phpakar','penyakit','gejalapakar'));
    }


    public function indexLaporan()
    {

        $kmeans = new KMeans(3);

        return view('report.index');
    }
}
