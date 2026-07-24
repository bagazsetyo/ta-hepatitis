<?php

namespace App\Services;

use App\Models\HasilPakar;
use App\Models\PivotHasilPakar;
use App\Models\PivotPenyakit;
use Illuminate\Support\Facades\DB;

class DiagnosisProofService
{
    public function buildProof(): array
    {
        $cases = HasilPakar::join('pasiens', 'pasiens.id', 'hasil_pakars.id_pasien')
            ->join('penyakits', 'penyakits.id', 'hasil_pakars.id_penyakit')
            ->select(
                'hasil_pakars.id',
                'hasil_pakars.id_penyakit',
                'hasil_pakars.nilai',
                'hasil_pakars.tanggal',
                'pasiens.nama_lengkap',
                'penyakits.penyakit as diagnosis_tersimpan'
            )
            ->orderBy('hasil_pakars.id', 'asc')
            ->get();

        $results = [];
        $matchCount = 0;

        foreach ($cases as $case) {
            $symptoms = PivotHasilPakar::join('gejalas', 'gejalas.id', 'pivot_hasil_pakars.id_gejala')
                ->select('gejalas.id', 'gejalas.kode', 'gejalas.gejala')
                ->where('pivot_hasil_pakars.id_hasil', $case->id)
                ->orderBy('gejalas.kode', 'asc')
                ->get();

            $symptomIds = $symptoms->pluck('id')->all();
            $recalculated = $this->diagnose($symptomIds);
            $isMatch = $recalculated !== null && (int) $recalculated['id_penyakit'] === (int) $case->id_penyakit;

            if ($isMatch) {
                $matchCount++;
            }

            $results[] = [
                'id_hasil' => $case->id,
                'pasien' => $case->nama_lengkap,
                'tanggal' => $case->tanggal,
                'gejala' => $symptoms,
                'jumlah_gejala' => count($symptomIds),
                'diagnosis_tersimpan' => $case->diagnosis_tersimpan,
                'nilai_tersimpan' => $case->nilai,
                'diagnosis_hitung_ulang' => $recalculated['penyakit'] ?? '-',
                'nilai_hitung_ulang' => $recalculated['nilai_persen'] ?? null,
                'jumlah_cocok' => $recalculated['jumlah_cocok'] ?? 0,
                'status' => $isMatch ? 'Sesuai' : 'Tidak Sesuai',
                'ranking' => $recalculated['ranking'] ?? [],
            ];
        }

        $totalCases = count($results);

        return [
            'total_kasus' => $totalCases,
            'jumlah_sesuai' => $matchCount,
            'jumlah_tidak_sesuai' => $totalCases - $matchCount,
            'akurasi_konsistensi' => $totalCases > 0 ? round(($matchCount / $totalCases) * 100, 2) : null,
            'cases' => $results,
            'rule_coverage' => $this->ruleCoverage(),
        ];
    }

    private function diagnose(array $symptomIds): ?array
    {
        if (count($symptomIds) === 0) {
            return null;
        }

        $ranking = PivotPenyakit::join('penyakits', 'penyakits.id', 'pivot_penyakits.id_penyakit')
            ->select(
                'pivot_penyakits.id_penyakit',
                'penyakits.penyakit',
                DB::raw('count(*) as jumlah_cocok'),
                DB::raw('sum(pivot_penyakits.nilai) as nilai_cocok')
            )
            ->whereIn('pivot_penyakits.id_gejala', $symptomIds)
            ->groupBy('pivot_penyakits.id_penyakit', 'penyakits.penyakit')
            ->orderBy('jumlah_cocok', 'desc')
            ->get();

        if ($ranking->isEmpty()) {
            return null;
        }

        $best = $ranking->first();

        $totalRuleWeight = PivotPenyakit::where('id_penyakit', $best->id_penyakit)
            ->select(DB::raw('sum(nilai) as nilai'))
            ->first();

        $percentage = $totalRuleWeight && (float) $totalRuleWeight->nilai > 0
            ? round(((float) $best->nilai_cocok / (float) $totalRuleWeight->nilai) * 100, 2)
            : 0;

        return [
            'id_penyakit' => $best->id_penyakit,
            'penyakit' => $best->penyakit,
            'jumlah_cocok' => $best->jumlah_cocok,
            'nilai_persen' => $percentage,
            'ranking' => $ranking,
        ];
    }

    private function ruleCoverage()
    {
        return PivotPenyakit::rightJoin('penyakits', 'penyakits.id', 'pivot_penyakits.id_penyakit')
            ->select(
                'penyakits.kode',
                'penyakits.penyakit',
                DB::raw('count(pivot_penyakits.id_gejala) as jumlah_rule')
            )
            ->groupBy('penyakits.id', 'penyakits.kode', 'penyakits.penyakit')
            ->orderBy('penyakits.kode', 'asc')
            ->get();
    }
}
