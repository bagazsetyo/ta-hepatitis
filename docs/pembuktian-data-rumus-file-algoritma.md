# Pembuktian Data, Rumus, dan File Implementasi Algoritma

Dokumen ini dipakai untuk menjawab pertanyaan dosen penguji terkait bukti teknis penerapan Forward Chaining dan K-Means pada aplikasi.

## 1. Ringkasan Posisi Algoritma

Algoritma yang digunakan:

- Forward Chaining untuk diagnosis utama hepatitis.
- K-Means untuk pengelompokan riwayat pasien berdasarkan pola gejala.

Alur implementasi:

```text
Pasien memilih gejala
→ Forward Chaining mencocokkan gejala dengan rule penyakit
→ sistem menyimpan hasil diagnosis
→ K-Means membaca riwayat gejala pasien
→ sistem membentuk cluster pasien
→ laporan menampilkan hasil cluster dan evaluasi
```

## 2. Pembuktian Forward Chaining

### 2.1 Data yang Dipakai

Data Forward Chaining berasal dari:

- Tabel `gejalas`: daftar gejala.
- Tabel `penyakits`: daftar penyakit.
- Tabel `pivot_penyakits`: aturan hubungan penyakit dan gejala.
- Tabel `hasil_pakars`: hasil diagnosis.
- Tabel `pivot_hasil_pakars`: gejala yang dipilih pada proses diagnosis.

File database terkait:

- `init/database/migrations/2026_06_20_141812_create_gejalas_table.php`
- `init/database/migrations/2026_06_20_141818_create_penyakits_table.php`
- `init/database/migrations/2026_07_02_152646_create_pivot_penyakits_table.php`
- `init/database/migrations/2026_06_20_142043_create_hasil_pakars_table.php`
- `init/database/migrations/2026_06_20_143725_create_pivot_hasil_pakars_table.php`

### 2.2 File Implementasi

File utama:

- `init/app/Http/Controllers/HasilPakarController.php`

Method:

- `proses(Request $request)`

Bagian kode inti:

```php
$gejalaTerpilih = $request->input('gejala');

$hasilDiagnosa = PivotPenyakit::select(
        'id_penyakit',
        \DB::raw('count(*) as jumlah_cocok'),
        \DB::raw('sum(nilai) as nilai')
    )
    ->whereIn('id_gejala', $gejalaTerpilih)
    ->groupBy('id_penyakit')
    ->orderBy('jumlah_cocok', 'desc')
    ->first();
```

Makna kode:

- Sistem mengambil gejala yang dipilih pasien.
- Sistem mencari penyakit yang memiliki gejala tersebut pada tabel aturan.
- Sistem menghitung jumlah gejala yang cocok.
- Sistem mengambil penyakit dengan jumlah kecocokan terbanyak.

### 2.3 Rumus Nilai Diagnosis

Setelah penyakit terpilih, sistem menghitung nilai persentase:

```php
$totnilai = number_format(($hasilDiagnosa->nilai / $penyakit->nilai) * 100, 0);
```

Rumus:

```text
Nilai diagnosis = (Total bobot gejala yang cocok / Total bobot seluruh gejala pada penyakit terpilih) x 100%
```

Keterangan:

- Total bobot gejala yang cocok berasal dari `sum(nilai)` pada gejala yang dipilih pasien.
- Total bobot seluruh gejala penyakit berasal dari `sum(nilai)` semua rule pada penyakit terpilih.

### 2.4 Bentuk Aturan IF-THEN

Aturan pada sistem tersimpan sebagai relasi di tabel `pivot_penyakits`.

Contoh bentuk narasi:

```text
IF pasien memilih G01
AND pasien memilih G02
AND pasien memilih G03
THEN kemungkinan penyakit adalah Hepatitis A
```

Pada kode, aturan tersebut tidak ditulis manual sebagai kalimat IF-THEN, tetapi disimpan sebagai data relasi:

```text
id_penyakit → id_gejala → nilai
```

## 3. Pembuktian K-Means

### 3.1 Data yang Dipakai

Data K-Means berasal dari riwayat diagnosis pasien:

- Tabel `hasil_pakars`: data pasien yang sudah didiagnosis.
- Tabel `pivot_hasil_pakars`: gejala yang dipilih pasien.
- Tabel `gejalas`: daftar fitur gejala.
- Tabel `penyakits`: data diagnosis untuk membaca distribusi hasil pada cluster.

Data gejala dikodekan menjadi matriks 0/1.

Contoh:

```text
Daftar gejala: G01, G02, G03, G04, G05
Pasien memilih: G01, G03, G05
Vektor K-Means: [1, 0, 1, 0, 1]
```

Makna:

- 1 berarti gejala dialami atau dipilih pasien.
- 0 berarti gejala tidak dipilih pasien.

### 3.2 File Implementasi

File service K-Means:

- `init/app/Services/KMeansService.php`

File integrasi controller:

- `init/app/Http/Controllers/HasilPakarController.php`

Method controller:

- `indexLaporan()`

File tampilan bukti:

- `init/resources/views/report/index.blade.php`

### 3.3 Bagian Kode Pemanggilan K-Means

Di controller laporan:

```php
$kmeans = (new KMeansService())->clusterPatients(
    $pasien,
    $gejala,
    $clustergejala,
    $diagnosisPasien,
    5
);
```

Makna:

- `$pasien`: daftar pasien.
- `$gejala`: daftar semua gejala.
- `$clustergejala`: gejala yang pernah dipilih pasien.
- `$diagnosisPasien`: diagnosis hasil Forward Chaining.
- `5`: jumlah cluster yang diminta.

### 3.4 Nilai K

Nilai K yang digunakan:

```text
K = 5
```

Alasan:

```text
K=5 digunakan karena batasan penelitian membahas Hepatitis A, B, C, D, dan E. Namun cluster tidak otomatis berarti masing-masing jenis hepatitis. Cluster tetap harus diinterpretasikan berdasarkan gejala dominan dan distribusi diagnosis.
```

Jika data pasien kurang dari 5, sistem otomatis menyesuaikan:

```php
$k = max(1, min($requestedK, count($samples)));
```

Makna:

```text
Jumlah cluster aktual tidak boleh lebih banyak dari jumlah data pasien yang memiliki gejala.
```

### 3.5 Rumus Jarak Euclidean

K-Means menghitung jarak setiap pasien ke centroid menggunakan Euclidean Distance.

Rumus:

```text
d(x, c) = sqrt((x1 - c1)^2 + (x2 - c2)^2 + ... + (xn - cn)^2)
```

Keterangan:

- `x` adalah vektor gejala pasien.
- `c` adalah vektor centroid cluster.
- `n` adalah jumlah gejala.

File implementasi:

- `init/app/Services/KMeansService.php`

Method:

- `distance(array $a, array $b)`

Kode:

```php
private function distance(array $a, array $b): float
{
    $sum = 0.0;

    foreach ($a as $index => $value) {
        $difference = $value - ($b[$index] ?? 0.0);
        $sum += $difference * $difference;
    }

    return sqrt($sum);
}
```

### 3.6 Penentuan Centroid Awal

Centroid awal menggunakan strategi deterministic farthest-first.

Makna sederhana:

```text
Centroid pertama diambil dari data pasien pertama. Centroid berikutnya dipilih dari data pasien yang jaraknya paling jauh dari centroid yang sudah ada. Strategi ini dipakai agar hasil clustering stabil saat laporan dibuka ulang.
```

File implementasi:

- `init/app/Services/KMeansService.php`

Method:

- `initialCentroids(array $samples, int $k)`

### 3.7 Penentuan Cluster Terdekat

Setiap pasien dimasukkan ke cluster dengan jarak terdekat terhadap centroid.

File implementasi:

- `init/app/Services/KMeansService.php`

Method:

- `assignSamples(array $samples, array $centroids)`

### 3.8 Pembaruan Centroid

Centroid baru dihitung dari rata-rata seluruh data dalam cluster.

Rumus:

```text
Cj = (x1 + x2 + ... + xm) / m
```

Keterangan:

- `Cj` adalah centroid cluster ke-j.
- `x` adalah data pasien dalam cluster.
- `m` adalah jumlah anggota cluster.

File implementasi:

- `init/app/Services/KMeansService.php`

Method:

- `recalculateCentroids(...)`

### 3.9 Penghentian Iterasi

Iterasi berhenti jika pembagian cluster sudah tidak berubah.

Kode:

```php
if ($newAssignments === $assignments && $iteration > 1) {
    break;
}
```

Makna:

```text
Jika hasil pengelompokan pada iterasi saat ini sama dengan iterasi sebelumnya, maka cluster dianggap stabil.
```

## 4. Pembuktian Evaluasi Cluster

### 4.1 Silhouette Score

Silhouette Score digunakan untuk mengukur seberapa baik data berada di cluster-nya dibanding cluster lain.

Rumus:

```text
s(i) = (b(i) - a(i)) / max(a(i), b(i))
```

Keterangan:

- `a(i)` adalah rata-rata jarak data ke anggota lain dalam cluster yang sama.
- `b(i)` adalah rata-rata jarak terkecil data ke cluster lain.
- Nilai mendekati 1 berarti cluster lebih baik.
- Nilai mendekati 0 berarti data berada di batas antar cluster.
- Nilai mendekati -1 berarti data kemungkinan kurang tepat cluster.

File implementasi:

- `init/app/Services/KMeansService.php`

Method:

- `silhouetteScore(...)`

### 4.2 Davies-Bouldin Index

Davies-Bouldin Index digunakan untuk mengukur kualitas cluster berdasarkan kerapatan cluster dan jarak antar centroid.

Rumus umum:

```text
DBI = (1 / K) x Σ max((Si + Sj) / Mij)
```

Keterangan:

- `Si` adalah rata-rata jarak data dalam cluster i terhadap centroid i.
- `Sj` adalah rata-rata jarak data dalam cluster j terhadap centroid j.
- `Mij` adalah jarak centroid i dan centroid j.
- Semakin kecil nilai DBI, semakin baik cluster.

File implementasi:

- `init/app/Services/KMeansService.php`

Method:

- `daviesBouldinIndex(...)`

## 5. Output Bukti di Halaman Laporan

Halaman laporan:

- URL aplikasi: `/laporan`
- Route: `Route::get('laporan',[HasilPakarController::class,'indexLaporan'])`
- File view: `init/resources/views/report/index.blade.php`

Output yang tampil:

- Jumlah data cluster.
- Nilai K.
- Silhouette Score.
- Davies-Bouldin Index.
- Grafik jumlah pasien per cluster.
- Grafik distribusi diagnosis per cluster.
- Hasil cluster.
- Anggota cluster.
- Gejala dominan.
- Distribusi diagnosis pada cluster.
- Matriks gejala 0/1.
- Matriks diagnosis hasil Forward Chaining.
- Tabel iterasi K-Means.

## 5.1 Output Bukti Konsistensi Forward Chaining

Halaman pembuktian logic:

- URL aplikasi: `/laporan/pembuktian`
- Route: `Route::get('laporan/pembuktian',[HasilPakarController::class,'pembuktian'])`
- File view: `init/resources/views/report/pembuktian.blade.php`
- File service: `init/app/Services/DiagnosisProofService.php`

Halaman ini tidak menambah, mengubah, atau menghapus data database. Sistem hanya membaca data hasil diagnosis yang sudah tersimpan, mengambil gejala pada setiap kasus, lalu menghitung ulang diagnosis dengan rule yang ada pada tabel `pivot_penyakits`.

Output yang tampil:

- Total kasus yang diuji.
- Jumlah kasus sesuai.
- Jumlah kasus tidak sesuai.
- Akurasi konsistensi logic.
- Chart hasil pembuktian.
- Kelengkapan jumlah rule penyakit-gejala.
- Tabel diagnosis tersimpan vs diagnosis hitung ulang.
- Ranking kandidat penyakit per kasus.

Makna pembuktian:

```text
Jika diagnosis tersimpan sama dengan diagnosis hitung ulang, berarti logic Forward Chaining konsisten terhadap data gejala dan rule penyakit-gejala yang ada saat ini.
```

Catatan batasan:

```text
Pembuktian ini menguji konsistensi logic sistem, bukan validasi medis final. Validasi medis tetap perlu dilakukan dengan pakar/dokter.
```

## 6. Screenshot yang Perlu Masuk BAB IV

Screenshot yang disarankan:

- Halaman pembuktian logic Forward Chaining.
- Tampilan ringkasan metrik K-Means.
- Chart jumlah pasien per cluster.
- Chart distribusi diagnosis per cluster.
- Tabel hasil cluster dan gejala dominan.
- Matriks pasien berdasarkan gejala 0/1.
- Tabel iterasi K-Means.
- Halaman hasil diagnosis Forward Chaining.

## 7. Kesimpulan Pembuktian

Kalimat kesimpulan yang aman:

```text
Berdasarkan implementasi pada aplikasi, metode Forward Chaining digunakan untuk menghasilkan diagnosis hepatitis berdasarkan aturan gejala-penyakit. Sementara itu, K-Means digunakan untuk mengelompokkan data pasien berdasarkan kemiripan pola gejala. Bukti penerapan K-Means ditunjukkan melalui matriks gejala 0/1, hasil cluster, grafik distribusi cluster, tabel iterasi, Silhouette Score, dan Davies-Bouldin Index pada halaman laporan.
```
