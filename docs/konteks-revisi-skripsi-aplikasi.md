# Konteks Revisi Skripsi dan Penyesuaian Aplikasi

Dokumen ini menjadi acuan kerja paralel untuk menyesuaikan naskah skripsi dengan aplikasi yang sedang dibuat. Fokus utama revisi adalah memastikan klaim pada skripsi tentang penggunaan metode Forward Chaining dan K-Means Clustering benar-benar sesuai dengan implementasi aplikasi.

## 1. Konteks Terakhir yang Masih Tersimpan

File skripsi terakhir yang dianalisis:

- `D:\Databagas\Titip\REVISI DAN PERBAIKAN.pdf`

Aplikasi penuh saat ini berada di:

- `D:\Code\juel\Source Code\init`

Review skripsi yang diberikan sebelumnya mencakup revisi BAB I sampai BAB IV, terutama:

- BAB I perlu tambahan batasan masalah.
- Batasan penyakit perlu sampai Hepatitis E.
- Teknik pengumpulan data di BAB I perlu dihapus karena sudah dibahas di BAB III.
- BAB II perlu menambahkan penelitian terdahulu.
- Rule pada bagian Forward Chaining perlu dirapikan.
- UML di BAB II perlu dihapus karena sudah ada di BAB III.
- Penjelasan penggabungan metode Forward Chaining dan K-Means perlu diperjelas.
- Istilah Web Browser perlu diganti menjadi Web.
- Materi Hepatitis perlu dipindahkan ke bagian awal setelah penelitian terdahulu.
- BAB III perlu dirapikan, termasuk pengantar awal dan struktur poin.
- BAB IV perlu pengujian kepada pakar/dokter.
- Kesimpulan blackbox perlu diganti dengan kesimpulan pengujian berdasarkan gejala.

Catatan tambahan dari diskusi terakhir:

- Jika K-Means tetap dipakai pada judul, maka di laporan harus ada pembuktian implementasi K-Means.
- K-Means sebaiknya tidak diklaim sebagai penentu diagnosis utama.
- Forward Chaining lebih tepat diposisikan sebagai metode utama diagnosis.
- K-Means lebih aman diposisikan sebagai metode pendukung untuk mengelompokkan riwayat pasien berdasarkan pola gejala.

## 2. Kondisi Aplikasi Saat Ini

Berdasarkan pemeriksaan folder `init`, aplikasi menggunakan Laravel dan sudah memiliki struktur lengkap seperti `app`, `database`, `resources`, `routes`, `vendor`, dan `node_modules`.

Bagian diagnosis berada pada:

- `init/app/Http/Controllers/HasilPakarController.php`

Alur diagnosis saat ini:

1. User memilih pasien.
2. User memilih gejala melalui checkbox.
3. Sistem mengambil daftar gejala terpilih.
4. Sistem mencocokkan gejala dengan tabel relasi penyakit-gejala.
5. Penyakit dengan jumlah gejala cocok terbanyak dipilih sebagai hasil diagnosis.
6. Nilai persentase dihitung dari bobot gejala yang cocok dibanding total bobot gejala pada penyakit tersebut.
7. Hasil diagnosis disimpan ke tabel `hasil_pakars`.
8. Gejala yang dipilih disimpan ke tabel `pivot_hasil_pakars`.

Bagian inti diagnosis saat ini:

```php
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

Makna implementasi:

- Ini sudah mendekati konsep Forward Chaining atau pencocokan aturan berbasis fakta gejala.
- Fakta awal adalah gejala yang dipilih pasien.
- Aturan tersimpan pada tabel relasi `pivot_penyakits`.
- Kesimpulan akhir adalah jenis hepatitis yang paling cocok.

Namun, aplikasi belum benar-benar menjalankan K-Means.

Bukti kondisi K-Means saat ini:

- Ada `use App\Services\KMeansService;` di `HasilPakarController.php`.
- Folder `app/Services` belum ada.
- Tidak ada class `KMeansService`.
- Tidak ada proses centroid.
- Tidak ada nilai K.
- Tidak ada perhitungan jarak Euclidean.
- Tidak ada iterasi pembaruan centroid.
- Tidak ada evaluasi cluster seperti Silhouette Score atau Davies-Bouldin Index.

Bagian laporan saat ini berada pada:

- `init/resources/views/report/index.blade.php`

Halaman laporan saat ini menampilkan matriks 0/1 berdasarkan:

- pasien vs penyakit hasil diagnosis;
- pasien vs gejala yang pernah dipilih.

Walaupun label tampilan memakai istilah "K-MEANS PASIEN BERDASARKAN PENYAKIT" dan "K-MEANS PASIEN BERDASARKAN GEJALA", secara teknis tabel tersebut belum merupakan hasil K-Means.

## 3. Temuan Penting untuk Disesuaikan

### 3.1 Penyakit Baru Sampai Hepatitis D

Seeder penyakit saat ini:

- Hepatitis A
- Hepatitis B
- Hepatitis C
- Hepatitis D

Belum ada Hepatitis E.

File terkait:

- `init/database/seeders/Penyakit.php`

Jika skripsi membatasi penyakit sampai Hepatitis E, maka aplikasi juga perlu menambahkan:

- data penyakit Hepatitis E;
- rule gejala untuk Hepatitis E;
- solusi atau rekomendasi Hepatitis E;
- data relasi penyakit-gejala untuk Hepatitis E.

### 3.2 Diagnosis Tidak Memakai Usia, Jenis Kelamin, atau Laboratorium

Aplikasi menyimpan data pasien seperti usia dan jenis kelamin, tetapi data tersebut belum digunakan dalam proses diagnosis atau clustering.

Data SGPT, SGOT, dan hasil laboratorium juga belum terlihat pada struktur aplikasi yang diperiksa.

Implikasi untuk skripsi:

- Jika data laboratorium tidak ada di aplikasi, jangan tulis seolah-olah sistem memakai data SGPT/SGOT.
- Jika dosen bertanya kenapa hanya gejala, jawabannya: karena sistem dibatasi sebagai alat bantu diagnosis awal berbasis gejala, sedangkan data laboratorium menjadi batasan dan pengembangan selanjutnya.

### 3.3 K-Means Tidak Boleh Langsung Disebut Hepatitis A-E

K-Means adalah metode unsupervised. Artinya, cluster yang terbentuk tidak otomatis berarti Hepatitis A, B, C, D, atau E.

Narasi yang aman:

```text
K-Means digunakan untuk mengelompokkan pasien berdasarkan kemiripan pola gejala. Hasil cluster tidak secara langsung menentukan jenis hepatitis, melainkan digunakan sebagai informasi pendukung untuk melihat pola kemiripan antar pasien.
```

Jika memakai K=5, narasi yang aman:

```text
Nilai K=5 digunakan untuk membentuk lima kelompok pola gejala pasien sesuai batasan penelitian yang membahas Hepatitis A sampai Hepatitis E. Namun, cluster yang terbentuk tidak otomatis merepresentasikan masing-masing jenis hepatitis karena K-Means merupakan metode unsupervised. Interpretasi cluster dilakukan berdasarkan dominasi gejala dan hasil diagnosis Forward Chaining pada anggota cluster.
```

## 4. Rekomendasi Alur Metode yang Paling Aman

Alur yang direkomendasikan untuk aplikasi dan skripsi:

```text
Input data pasien
→ input gejala pasien
→ Forward Chaining menentukan diagnosis Hepatitis A-E
→ hasil diagnosis disimpan
→ K-Means mengelompokkan riwayat pasien berdasarkan pola gejala
→ laporan menampilkan hasil diagnosis, cluster pasien, karakteristik cluster, dan evaluasi cluster
```

Posisi metode:

- Forward Chaining: metode utama untuk diagnosis.
- K-Means: metode pendukung untuk analisis pola pasien pada laporan.

Alasan memilih alur ini:

- Paling sesuai dengan kode aplikasi saat ini.
- Perubahan aplikasi tidak terlalu besar.
- Lebih mudah dipertanggungjawabkan secara akademik.
- Tidak memaksakan K-Means sebagai metode diagnosis, karena K-Means tidak menggunakan label penyakit.

## 5. Pembuktian K-Means yang Perlu Ada di BAB IV

Jika K-Means dipakai dalam judul, maka BAB IV perlu memuat bukti bahwa K-Means benar-benar dijalankan.

Minimal bukti yang perlu ditampilkan:

- Tabel data pasien dan gejala dalam bentuk 0/1.
- Nilai K yang digunakan.
- Centroid awal.
- Perhitungan jarak data ke centroid.
- Hasil cluster akhir.
- Jumlah pasien pada tiap cluster.
- Karakteristik cluster berdasarkan dominasi gejala.
- Evaluasi cluster, minimal Silhouette Score atau Davies-Bouldin Index.

Contoh narasi hasil:

```text
Berdasarkan hasil implementasi K-Means terhadap data gejala pasien, diperoleh lima cluster dengan karakteristik gejala yang berbeda. Cluster 1 didominasi oleh pasien dengan gejala demam, mual, dan nyeri perut, sedangkan Cluster 2 didominasi oleh pasien dengan gejala ikterus dan urine gelap. Hasil ini menunjukkan bahwa K-Means dapat membantu mengelompokkan pasien berdasarkan kemiripan pola gejala, sehingga berguna sebagai analisis pendukung pada laporan sistem.
```

Jika hasil evaluasi kurang baik, narasi yang aman:

```text
Nilai evaluasi cluster menunjukkan bahwa pemisahan antar cluster belum terlalu kuat. Hal ini disebabkan oleh adanya kemiripan gejala pada beberapa jenis hepatitis. Dengan demikian, K-Means kurang tepat digunakan sebagai metode utama diagnosis, tetapi masih dapat digunakan sebagai metode pendukung untuk melihat pola pengelompokan pasien berdasarkan gejala.
```

## 6. Rencana Penyesuaian Aplikasi

### 6.1 Perubahan Minimal

Perubahan minimal agar aplikasi benar-benar memakai dua metode:

- Tambahkan `app/Services/KMeansService.php`.
- Tambahkan fungsi pembentukan matriks gejala pasien.
- Jalankan K-Means pada halaman laporan.
- Tampilkan hasil cluster pada laporan.
- Tampilkan ringkasan karakteristik tiap cluster.
- Tambahkan evaluasi sederhana cluster.

Perubahan ini tidak perlu mengubah proses diagnosis utama.

### 6.2 Perubahan Data Hepatitis E

Untuk memenuhi batasan sampai Hepatitis E:

- Tambahkan `P05 - Hepatitis E` pada data penyakit.
- Tambahkan gejala yang relevan jika belum ada.
- Tambahkan relasi gejala-penyakit untuk Hepatitis E.
- Tambahkan solusi/rekomendasi Hepatitis E.

### 6.3 Validasi Pakar

BAB IV perlu ditambah pengujian kepada dokter atau pakar.

Minimal format pengujian:

- Dokter memvalidasi rule IF-THEN.
- Dokter memberikan diagnosis pembanding untuk sejumlah kasus.
- Sistem diuji terhadap kasus tersebut.
- Hasil sistem dibandingkan dengan hasil dokter.
- Akurasi dihitung.

Rumus:

```text
Akurasi = (Jumlah diagnosis sesuai dokter / Total kasus uji) x 100%
```

Untuk K-Means:

- Evaluasi teknis menggunakan Silhouette Score atau Davies-Bouldin Index.
- Interpretasi cluster dikonfirmasi kepada pakar bila memungkinkan.

## 7. Penyesuaian Naskah Skripsi

### BAB I

Tambahkan batasan masalah:

- Sistem hanya melakukan diagnosis awal, bukan diagnosis final medis.
- Jenis hepatitis dibatasi sampai Hepatitis A, B, C, D, dan E.
- Data input utama adalah gejala yang dipilih pasien.
- Data laboratorium seperti SGPT/SGOT tidak digunakan jika memang belum ada di aplikasi.
- Forward Chaining digunakan untuk diagnosis.
- K-Means digunakan untuk pengelompokan data pasien berdasarkan pola gejala.

Hapus teknik pengumpulan data dari BAB I jika sudah dijelaskan di BAB III.

### BAB II

Tambahkan penelitian terdahulu.

Urutan yang disarankan:

1. Penelitian terdahulu.
2. Hepatitis.
3. Sistem Pakar.
4. Forward Chaining.
5. K-Means Clustering.
6. Penggabungan Forward Chaining dan K-Means.
7. Web.
8. PHP.
9. MySQL.

Hapus UML dari BAB II karena UML lebih tepat berada di BAB III.

### BAB III

Perjelas alur metode:

```text
Forward Chaining digunakan untuk menentukan diagnosis berdasarkan rule gejala-penyakit. K-Means digunakan setelah data diagnosis dan gejala pasien tersimpan untuk mengelompokkan pasien berdasarkan kemiripan pola gejala. Hasil K-Means digunakan sebagai laporan dan analisis pendukung, bukan sebagai penentu utama diagnosis.
```

Jika tetap ingin memakai istilah pra-diagnosa, perlu hati-hati karena aplikasi saat ini lebih cocok menggunakan K-Means pada laporan setelah data pasien tersedia.

### BAB IV

Tambahkan bagian:

- Implementasi Forward Chaining.
- Implementasi K-Means.
- Hasil cluster.
- Evaluasi cluster.
- Pengujian diagnosis dengan pakar.
- Kesimpulan pengujian berdasarkan gejala.

Kesimpulan blackbox sebaiknya tidak menjadi fokus utama. Blackbox cukup sebagai pengujian fungsional aplikasi, sedangkan pengujian utama penelitian harus membahas kesesuaian diagnosis sistem terhadap pakar dan hasil clustering.

## 8. Jawaban Jika Dosen Mengulik

### Kenapa K-Means hanya memakai gejala?

```text
Karena sistem ini dibatasi sebagai sistem diagnosis awal berbasis gejala. Data laboratorium seperti SGPT dan SGOT belum tersedia secara konsisten pada aplikasi, sehingga tidak digunakan dalam proses clustering. Hal tersebut menjadi batasan penelitian dan dapat dikembangkan pada penelitian selanjutnya.
```

### Apakah cluster 1 berarti Hepatitis A?

```text
Tidak secara langsung. K-Means merupakan metode unsupervised, sehingga cluster yang terbentuk tidak otomatis sama dengan label penyakit. Interpretasi cluster dilakukan berdasarkan dominasi gejala dan hasil diagnosis Forward Chaining pada pasien dalam cluster tersebut.
```

### Kenapa masih memakai Forward Chaining kalau sudah ada K-Means?

```text
Forward Chaining digunakan untuk menentukan diagnosis karena berbasis aturan pakar. K-Means digunakan untuk mengelompokkan pola gejala pasien sebagai analisis pendukung. Keduanya memiliki fungsi berbeda dalam sistem.
```

### Apakah K-Means cocok?

```text
K-Means cocok digunakan sebagai metode pendukung untuk mengelompokkan pasien berdasarkan kemiripan pola gejala. Namun K-Means tidak digunakan sebagai metode utama diagnosis karena tidak memakai label penyakit dan tidak memiliki aturan medis dalam proses clustering.
```

## 9. Keputusan Kerja yang Disarankan

Keputusan paling aman:

```text
Skripsi dan aplikasi disesuaikan dengan alur:
Forward Chaining untuk diagnosis, K-Means untuk clustering laporan pasien.
```

Dengan keputusan ini:

- Judul masih bisa mempertahankan dua metode.
- Implementasi aplikasi tidak perlu dirombak besar.
- BAB IV bisa menampilkan bukti K-Means.
- Risiko pertanyaan penguji lebih mudah dijawab.

## 10. Catatan Teknis Lanjutan

Beberapa hal teknis yang perlu dicek sebelum implementasi:

- Migration `hasil_pakars` memiliki kolom `id_solusi` yang wajib, tetapi controller diagnosis saat ini belum mengisi `id_solusi`.
- Seeder penyakit belum memuat Hepatitis E.
- Relasi penyakit-gejala untuk Hepatitis E perlu disiapkan.
- Jika K-Means ingin disimpan permanen, perlu tabel tambahan untuk hasil cluster.
- Jika K-Means cukup untuk laporan, hasil cluster bisa dihitung langsung saat membuka halaman laporan tanpa tabel baru.

## 11. Status Implementasi K-Means

Implementasi awal K-Means sudah ditambahkan pada aplikasi di folder `init`.

File yang ditambahkan atau diubah:

- `init/app/Services/KMeansService.php`
- `init/app/Http/Controllers/HasilPakarController.php`
- `init/resources/views/report/index.blade.php`
- `init/database/seeders/Penyakit.php`
- `docs/bab-4-pembuktian-kmeans.md`

Perubahan utama:

- Menambahkan service K-Means dengan data input berupa matriks gejala pasien 0/1.
- Menjalankan K-Means pada halaman laporan tanpa menambah tabel baru.
- Menggunakan nilai K=5 sebagai batas maksimal cluster sesuai batas penelitian Hepatitis A-E.
- Jika jumlah pasien yang memiliki data gejala kurang dari 5, sistem otomatis memakai jumlah cluster sesuai jumlah data yang tersedia.
- Menampilkan hasil cluster, anggota cluster, gejala dominan, distribusi diagnosis, iterasi K-Means, Silhouette Score, dan Davies-Bouldin Index.
- Menambahkan chart jumlah pasien per cluster dan distribusi diagnosis per cluster.
- Menambahkan Hepatitis E pada seeder penyakit.

Catatan penting:

- K-Means tidak mengubah hasil diagnosis.
- Diagnosis tetap ditentukan oleh Forward Chaining berbasis aturan gejala-penyakit.
- K-Means dipakai sebagai pembuktian analisis pendukung pada laporan BAB IV.
- Relasi rule gejala untuk Hepatitis E tetap harus dimasukkan berdasarkan validasi pakar/dokter.
