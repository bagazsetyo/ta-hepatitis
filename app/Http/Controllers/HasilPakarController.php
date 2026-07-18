<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\HasilPakar;
use App\Models\PivotHasilPakar;
use App\Models\Gejala;
use App\Models\Pasien;
use App\Models\Penyakit;
use App\Models\PivotPenyakit;
use App\Services\KMeansService;

class HasilPakarController extends Controller
{

    public function index()
    {
        $gejalas                = Gejala::orderBy('kode','asc')->get();
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

        $totnilai                   = number_format(($hasilDiagnosa->nilai/$penyakit->nilai)*100,0);

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
        
        $pasien                         = Pasien::all();
        $gejala                         = Gejala::orderBy('gejala','asc')->get();

        $clusterpenyakit                = HasilPakar::select('hasil_pakars.id_pasien as idpasien','hasil_pakars.id_penyakit as idpenyakit')
                                                        ->get();

        $clustergejala                = HasilPakar::join('pivot_hasil_pakars','pivot_hasil_pakars.id_hasil','hasil_pakars.id')
                                                        ->select('hasil_pakars.id_pasien as idpasien','pivot_hasil_pakars.id_gejala as idgejala','hasil_pakars.id_penyakit as idpenyakit')
                                                        ->get();

        $penyakit                       = Penyakit::orderBy('penyakit','asc')->get();

        $diagnosisPasien                = HasilPakar::join('penyakits','penyakits.id','hasil_pakars.id_penyakit')
                                                        ->select('hasil_pakars.id_pasien as idpasien','penyakits.penyakit')
                                                        ->get();

        $kmeans                         = (new KMeansService())->clusterPatients(
                                                        $pasien,
                                                        $gejala,
                                                        $clustergejala,
                                                        $diagnosisPasien,
                                                        5
                                                    );

        $kmeansCharts                   = [
                                                        'cluster_labels' => array_map(function ($cluster) {
                                                            return 'Cluster '.$cluster['cluster'];
                                                        }, $kmeans['clusters']),
                                                        'cluster_counts' => array_map(function ($cluster) {
                                                            return $cluster['member_count'];
                                                        }, $kmeans['clusters']),
                                                        'diagnosis_labels' => [],
                                                        'diagnosis_counts' => [],
                                                    ];

        foreach ($kmeans['clusters'] as $cluster) {
            foreach ($cluster['diagnosis_distribution'] as $diagnosis => $jumlah) {
                $kmeansCharts['diagnosis_labels'][] = 'C'.$cluster['cluster'].' - '.$diagnosis;
                $kmeansCharts['diagnosis_counts'][] = $jumlah;
            }
        }

        return view('report.index', compact('pasien','gejala','clusterpenyakit','penyakit','clustergejala','kmeans','kmeansCharts'));

    }
}
