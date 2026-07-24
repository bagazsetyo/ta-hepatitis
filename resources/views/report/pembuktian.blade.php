@extends('layouts.app')
    @section('report', 'active')

@section('content')
<style>
    .proof-card {
        border: 1px solid #e5e7eb;
        border-radius: 8px;
        padding: 14px 16px;
        background: #fff;
        min-height: 92px;
        margin-bottom: 15px;
    }
    .proof-card .label-text {
        color: #6b7280;
        font-size: 12px;
        text-transform: uppercase;
        letter-spacing: .04em;
    }
    .proof-card .value-text {
        margin-top: 8px;
        color: #111827;
        font-size: 24px;
        font-weight: 700;
    }
    .proof-note {
        padding: 12px 14px;
        border-left: 4px solid #0ea5e9;
        background: #f0f9ff;
        color: #0f172a;
        margin-bottom: 16px;
    }
    .symptom-list {
        margin: 0;
        padding-left: 16px;
    }
    .status-ok {
        color: #047857;
        font-weight: 700;
    }
    .status-fail {
        color: #b91c1c;
        font-weight: 700;
    }
</style>

<div class="row">
    <div class="col-md-12">
        <div class="box">
            <div class="box-header with-border">
                <h3 class="box-title">Pembuktian Logic Forward Chaining</h3>
                <div class="box-tools pull-right">
                    <a href="/laporan" class="btn btn-sm btn-default">
                        <i class="fa fa-arrow-left"></i> Kembali ke Laporan
                    </a>
                </div>
            </div>

            <div class="box-body">
                <div class="proof-note">
                    Halaman ini tidak menambah atau mengubah data database. Sistem hanya membaca riwayat diagnosis yang sudah tersimpan,
                    mengambil gejala pada setiap kasus, lalu menghitung ulang diagnosis dengan rule penyakit-gejala untuk mengecek konsistensi output.
                </div>

                <div class="row">
                    <div class="col-sm-3">
                        <div class="proof-card">
                            <div class="label-text">Total Kasus</div>
                            <div class="value-text">{{ $proof['total_kasus'] }}</div>
                        </div>
                    </div>
                    <div class="col-sm-3">
                        <div class="proof-card">
                            <div class="label-text">Sesuai</div>
                            <div class="value-text">{{ $proof['jumlah_sesuai'] }}</div>
                        </div>
                    </div>
                    <div class="col-sm-3">
                        <div class="proof-card">
                            <div class="label-text">Tidak Sesuai</div>
                            <div class="value-text">{{ $proof['jumlah_tidak_sesuai'] }}</div>
                        </div>
                    </div>
                    <div class="col-sm-3">
                        <div class="proof-card">
                            <div class="label-text">Akurasi Konsistensi</div>
                            <div class="value-text">
                                {{ $proof['akurasi_konsistensi'] !== null ? $proof['akurasi_konsistensi'].'%' : '-' }}
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <h4>Chart Hasil Pembuktian</h4>
                        <canvas id="proofChart" height="180"></canvas>
                    </div>
                    <div class="col-md-6">
                        <h4>Kelengkapan Rule Penyakit-Gejala</h4>
                        <table class="table table-bordered table-striped">
                            <tr>
                                <th>Kode</th>
                                <th>Penyakit</th>
                                <th>Jumlah Rule Gejala</th>
                            </tr>
                            @foreach($proof['rule_coverage'] as $rule)
                                <tr>
                                    <td>{{ $rule->kode }}</td>
                                    <td>{{ $rule->penyakit }}</td>
                                    <td>{{ $rule->jumlah_rule }}</td>
                                </tr>
                            @endforeach
                        </table>
                    </div>
                </div>

                <hr>

                <h4>Tabel Uji Konsistensi Output Diagnosis</h4>
                <p>
                    Status <strong>Sesuai</strong> berarti diagnosis tersimpan sama dengan hasil hitung ulang dari gejala dan rule yang ada saat ini.
                    Jika ada status <strong>Tidak Sesuai</strong>, berarti data lama perlu dicek ulang terhadap rule yang sekarang aktif.
                </p>

                <div style="overflow-x:auto;">
                    <table class="table table-bordered table-hover">
                        <tr>
                            <th>No</th>
                            <th>ID Hasil</th>
                            <th>Pasien</th>
                            <th>Tanggal</th>
                            <th>Gejala Input</th>
                            <th>Diagnosis Tersimpan</th>
                            <th>Nilai Tersimpan</th>
                            <th>Diagnosis Hitung Ulang</th>
                            <th>Nilai Hitung Ulang</th>
                            <th>Jumlah Gejala Cocok</th>
                            <th>Status</th>
                        </tr>
                        @foreach($proof['cases'] as $no => $case)
                            <tr>
                                <td>{{ $no + 1 }}</td>
                                <td>{{ $case['id_hasil'] }}</td>
                                <td>{{ $case['pasien'] }}</td>
                                <td>{{ $case['tanggal'] }}</td>
                                <td>
                                    <ul class="symptom-list">
                                        @foreach($case['gejala'] as $gejala)
                                            <li>{{ $gejala->kode }} - {{ $gejala->gejala }}</li>
                                        @endforeach
                                    </ul>
                                </td>
                                <td>{{ $case['diagnosis_tersimpan'] }}</td>
                                <td>{{ $case['nilai_tersimpan'] }}%</td>
                                <td>{{ $case['diagnosis_hitung_ulang'] }}</td>
                                <td>
                                    {{ $case['nilai_hitung_ulang'] !== null ? $case['nilai_hitung_ulang'].'%' : '-' }}
                                </td>
                                <td>{{ $case['jumlah_cocok'] }}</td>
                                <td>
                                    <span class="{{ $case['status'] === 'Sesuai' ? 'status-ok' : 'status-fail' }}">
                                        {{ $case['status'] }}
                                    </span>
                                </td>
                            </tr>
                        @endforeach
                    </table>
                </div>

                <hr>

                <h4>Ranking Kandidat Penyakit per Kasus</h4>
                <p>
                    Ranking ini menunjukkan kandidat penyakit berdasarkan jumlah gejala yang cocok.
                    Baris pertama pada ranking menjadi hasil diagnosis hitung ulang.
                </p>

                @foreach($proof['cases'] as $case)
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            ID Hasil {{ $case['id_hasil'] }} - {{ $case['pasien'] }}
                        </div>
                        <div class="panel-body">
                            @if(count($case['ranking']) === 0)
                                <p class="text-muted">Tidak ada rule yang cocok.</p>
                            @else
                                <table class="table table-bordered table-condensed">
                                    <tr>
                                        <th>Ranking</th>
                                        <th>Penyakit</th>
                                        <th>Jumlah Gejala Cocok</th>
                                        <th>Total Bobot Cocok</th>
                                    </tr>
                                    @foreach($case['ranking'] as $rank => $candidate)
                                        <tr>
                                            <td>{{ $rank + 1 }}</td>
                                            <td>{{ $candidate->penyakit }}</td>
                                            <td>{{ $candidate->jumlah_cocok }}</td>
                                            <td>{{ $candidate->nilai_cocok }}</td>
                                        </tr>
                                    @endforeach
                                </table>
                            @endif
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
</div>
@endsection

@section('kmeans')
<script>
    if (document.getElementById('proofChart')) {
        new Chart(document.getElementById('proofChart'), {
            type: 'doughnut',
            data: {
                labels: ['Sesuai', 'Tidak Sesuai'],
                datasets: [{
                    data: [{{ $proof['jumlah_sesuai'] }}, {{ $proof['jumlah_tidak_sesuai'] }}],
                    backgroundColor: ['#10b981', '#ef4444']
                }]
            },
            options: {
                responsive: true
            }
        });
    }
</script>
@endsection
