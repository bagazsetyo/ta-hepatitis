@extends('layouts.app')
    @section('report', 'active')

@section('content')
<style>
    .metric-card {
        border: 1px solid #e5e7eb;
        border-radius: 8px;
        padding: 14px 16px;
        background: #ffffff;
        min-height: 92px;
    }
    .metric-card .metric-label {
        color: #6b7280;
        font-size: 12px;
        text-transform: uppercase;
        letter-spacing: .04em;
    }
    .metric-card .metric-value {
        margin-top: 8px;
        color: #111827;
        font-size: 24px;
        font-weight: 700;
    }
    .cluster-panel {
        border: 1px solid #d1d5db;
        border-radius: 8px;
        margin-bottom: 16px;
        overflow: hidden;
        background: #fff;
    }
    .cluster-panel .cluster-heading {
        padding: 12px 14px;
        background: #f3f4f6;
        border-bottom: 1px solid #d1d5db;
        font-weight: 700;
    }
    .cluster-panel .cluster-body {
        padding: 14px;
    }
    .symptom-chip {
        display: inline-block;
        margin: 0 6px 6px 0;
        padding: 5px 8px;
        border-radius: 999px;
        background: #e0f2fe;
        color: #075985;
        font-size: 12px;
    }
    .proof-note {
        padding: 12px 14px;
        border-left: 4px solid #0ea5e9;
        background: #f0f9ff;
        color: #0f172a;
        margin-bottom: 16px;
    }
    .table-fixed-proof th,
    .table-fixed-proof td {
        white-space: nowrap;
        vertical-align: middle !important;
    }
</style>

<div class="row">
    <div class="col-md-12">
        <div class="box">
            <div class="box-header with-border">
                <h3 class="box-title">Laporan Analisis Diagnosis dan K-Means</h3>
            </div>

            <div class="box-body">
                <div class="proof-note">
                    <strong>Catatan Metode:</strong>
                    Forward Chaining digunakan untuk menentukan diagnosis berdasarkan aturan gejala-penyakit.
                    K-Means digunakan sebagai analisis pendukung untuk mengelompokkan riwayat pasien berdasarkan kemiripan pola gejala 0/1.
                </div>

                <div class="row">
                    <div class="col-sm-3">
                        <div class="metric-card">
                            <div class="metric-label">Jumlah Data Cluster</div>
                            <div class="metric-value">{{ $kmeans['sample_count'] }}</div>
                        </div>
                    </div>
                    <div class="col-sm-3">
                        <div class="metric-card">
                            <div class="metric-label">Nilai K</div>
                            <div class="metric-value">{{ $kmeans['actual_k'] }} / {{ $kmeans['requested_k'] }}</div>
                        </div>
                    </div>
                    <div class="col-sm-3">
                        <div class="metric-card">
                            <div class="metric-label">Silhouette Score</div>
                            <div class="metric-value">
                                {{ $kmeans['silhouette_score'] !== null ? $kmeans['silhouette_score'] : '-' }}
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-3">
                        <div class="metric-card">
                            <div class="metric-label">Davies-Bouldin Index</div>
                            <div class="metric-value">
                                {{ $kmeans['davies_bouldin_index'] !== null ? $kmeans['davies_bouldin_index'] : '-' }}
                            </div>
                        </div>
                    </div>
                </div>

                <hr>

                <div class="row">
                    <div class="col-md-6">
                        <h4>Grafik Jumlah Pasien per Cluster</h4>
                        <canvas id="clusterChart" height="180"></canvas>
                    </div>
                    <div class="col-md-6">
                        <h4>Distribusi Diagnosis per Cluster</h4>
                        <canvas id="diagnosisChart" height="180"></canvas>
                    </div>
                </div>

                <hr>

                <h4>Hasil Cluster K-Means</h4>
                @if(count($kmeans['clusters']) === 0)
                    <div class="alert alert-warning">
                        Data gejala pasien belum tersedia, sehingga proses K-Means belum dapat dijalankan.
                    </div>
                @endif

                @foreach($kmeans['clusters'] as $cluster)
                    <div class="cluster-panel">
                        <div class="cluster-heading">
                            Cluster {{ $cluster['cluster'] }} - {{ $cluster['member_count'] }} Pasien
                        </div>
                        <div class="cluster-body">
                            <div class="row">
                                <div class="col-md-6">
                                    <strong>Anggota Cluster</strong>
                                    @if(count($cluster['members']) > 0)
                                        <ul>
                                            @foreach($cluster['members'] as $member)
                                                <li>{{ $member['nama'] }}</li>
                                            @endforeach
                                        </ul>
                                    @else
                                        <p class="text-muted">Tidak ada anggota pada cluster ini.</p>
                                    @endif
                                </div>
                                <div class="col-md-6">
                                    <strong>Gejala Dominan</strong><br>
                                    @if(count($cluster['dominant_symptoms']) > 0)
                                        @foreach($cluster['dominant_symptoms'] as $symptom)
                                            <span class="symptom-chip">
                                                {{ $symptom['gejala'] }}: {{ $symptom['jumlah'] }} pasien ({{ $symptom['persentase'] }}%)
                                            </span>
                                        @endforeach
                                    @else
                                        <p class="text-muted">Belum ada gejala dominan.</p>
                                    @endif

                                    <br><br>
                                    <strong>Distribusi Diagnosis</strong>
                                    @if(count($cluster['diagnosis_distribution']) > 0)
                                        <ul>
                                            @foreach($cluster['diagnosis_distribution'] as $diagnosis => $jumlah)
                                                <li>{{ $diagnosis }}: {{ $jumlah }} data</li>
                                            @endforeach
                                        </ul>
                                    @else
                                        <p class="text-muted">Belum ada diagnosis pada cluster ini.</p>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach

                @if(count($kmeans['excluded_patients']) > 0)
                    <div class="alert alert-info">
                        <strong>Data tidak dihitung dalam K-Means:</strong>
                        {{ count($kmeans['excluded_patients']) }} pasien belum memiliki gejala hasil diagnosis.
                    </div>
                @endif

                <hr>

                <h4>Pembuktian Data Input K-Means: Matriks Pasien Berdasarkan Gejala</h4>
                <p>
                    Nilai 1 berarti pasien memiliki gejala tersebut pada riwayat diagnosis, sedangkan nilai 0 berarti tidak tercatat.
                    Matriks ini menjadi data numerik yang diproses oleh K-Means.
                </p>
                <div style="overflow-x:auto;">
                    <table class="table table-bordered table-striped table-hover table-fixed-proof">
                        <tr>
                            <th>No</th>
                            <th>Nama Pasien</th>
                            @foreach($gejala as $val)
                                <th>{{ $val->kode }}</th>
                            @endforeach
                        </tr>
                        @foreach($pasien as $no=>$ps)
                            <tr>
                                <td>{{ $no+1 }}</td>
                                <td>{{ $ps->nama_lengkap }}</td>
                                @foreach($gejala as $val)
                                    @php
                                        $nilai = 0;
                                    @endphp
                                    <td>
                                        @foreach($clustergejala as $clas)
                                            @if($ps->id == $clas->idpasien && $clas->idgejala == $val->id)
                                                @php
                                                    $nilai = 1;
                                                @endphp
                                            @endif
                                        @endforeach
                                        <center>{{ $nilai }}</center>
                                    </td>
                                @endforeach
                            </tr>
                        @endforeach
                    </table>
                </div>

                <hr>

                <h4>Matriks Pasien Berdasarkan Hasil Diagnosis Forward Chaining</h4>
                <p>
                    Nilai 1 berarti pasien pernah mendapatkan hasil diagnosis penyakit tersebut.
                    Data ini digunakan untuk membaca distribusi diagnosis pada masing-masing cluster.
                </p>
                <div style="overflow-x:auto;">
                    <table class="table table-bordered table-hover table-fixed-proof">
                        <tr>
                            <th>No</th>
                            <th>Nama Pasien</th>
                            @foreach($penyakit as $val)
                                <th><center>{{ $val->penyakit }}</center></th>
                            @endforeach
                        </tr>
                        @foreach($pasien as $no=>$ps)
                            <tr>
                                <td>{{ $no+1 }}</td>
                                <td>{{ $ps->nama_lengkap }}</td>
                                @foreach($penyakit as $val)
                                    @php
                                        $nilai = 0;
                                    @endphp
                                    <td>
                                        @foreach($clusterpenyakit as $clas)
                                            @if($ps->id == $clas->idpasien && $clas->idpenyakit == $val->id)
                                                @php
                                                    $nilai = 1;
                                                @endphp
                                            @endif
                                        @endforeach
                                        <center>{{ $nilai }}</center>
                                    </td>
                                @endforeach
                            </tr>
                        @endforeach
                    </table>
                </div>

                <hr>

                <h4>Data Iterasi K-Means untuk BAB IV</h4>
                <p>
                    Tabel ini dapat digunakan sebagai bukti bahwa proses K-Means berjalan secara iteratif sampai pembagian cluster stabil.
                </p>
                <table class="table table-bordered table-striped">
                    <tr>
                        <th>Iterasi</th>
                        @for($i = 1; $i <= max(1, $kmeans['actual_k']); $i++)
                            <th>Jumlah Data Cluster {{ $i }}</th>
                        @endfor
                    </tr>
                    @foreach($kmeans['iterations'] as $iteration)
                        <tr>
                            <td>{{ $iteration['iteration'] }}</td>
                            @foreach($iteration['assignments'] as $count)
                                <td>{{ $count }}</td>
                            @endforeach
                        </tr>
                    @endforeach
                </table>
            </div>
        </div>
    </div>
</div>
@endsection

@section('kmeans')
<script>
    var clusterLabels = @json($kmeansCharts['cluster_labels']);
    var clusterCounts = @json($kmeansCharts['cluster_counts']);
    var diagnosisLabels = @json($kmeansCharts['diagnosis_labels']);
    var diagnosisCounts = @json($kmeansCharts['diagnosis_counts']);

    if (document.getElementById('clusterChart')) {
        new Chart(document.getElementById('clusterChart'), {
            type: 'bar',
            data: {
                labels: clusterLabels,
                datasets: [{
                    label: 'Jumlah Pasien',
                    data: clusterCounts,
                    backgroundColor: '#0ea5e9'
                }]
            },
            options: {
                responsive: true,
                legend: { display: false },
                scales: {
                    yAxes: [{
                        ticks: { beginAtZero: true, precision: 0 }
                    }]
                }
            }
        });
    }

    if (document.getElementById('diagnosisChart')) {
        new Chart(document.getElementById('diagnosisChart'), {
            type: 'bar',
            data: {
                labels: diagnosisLabels,
                datasets: [{
                    label: 'Jumlah Diagnosis',
                    data: diagnosisCounts,
                    backgroundColor: '#10b981'
                }]
            },
            options: {
                responsive: true,
                legend: { display: false },
                scales: {
                    yAxes: [{
                        ticks: { beginAtZero: true, precision: 0 }
                    }]
                }
            }
        });
    }
</script>
@endsection
