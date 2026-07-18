# Jawaban Pertanyaan Penguji Terkait Forward Chaining dan K-Means

Dokumen ini disiapkan sebagai pegangan saat dosen penguji bertanya tentang alasan, alur, dan pembuktian penggunaan dua metode pada sistem.

## 1. Apa Alur Gabungan Dua Metode pada Sistem?

Jawaban:

```text
Pada sistem ini, Forward Chaining digunakan sebagai metode utama untuk menentukan diagnosis hepatitis berdasarkan aturan gejala-penyakit. K-Means digunakan sebagai metode pendukung untuk mengelompokkan riwayat pasien berdasarkan kemiripan pola gejala. Jadi K-Means tidak menggantikan Forward Chaining, tetapi membantu analisis data pasien pada halaman laporan.
```

Alur sistem:

```text
Input pasien dan gejala
→ gejala menjadi fakta awal
→ Forward Chaining mencocokkan fakta dengan aturan penyakit
→ sistem menghasilkan diagnosis hepatitis
→ hasil diagnosis dan gejala pasien disimpan
→ K-Means membaca data riwayat gejala pasien
→ pasien dikelompokkan berdasarkan kemiripan gejala
→ laporan menampilkan cluster, grafik, dan evaluasi
```

## 2. Kenapa Tidak K-Means Langsung Menentukan Hepatitis A-E?

Jawaban:

```text
K-Means merupakan metode unsupervised, sehingga tidak memiliki label penyakit pada saat proses clustering. Karena itu, cluster 1 sampai cluster 5 tidak otomatis berarti Hepatitis A sampai Hepatitis E. Diagnosis penyakit tetap harus dilakukan dengan aturan pakar melalui Forward Chaining. K-Means hanya digunakan untuk melihat pola kemiripan gejala pasien.
```

## 3. Kenapa Menggunakan Dua Metode?

Jawaban:

```text
Dua metode digunakan karena memiliki fungsi berbeda. Forward Chaining sesuai untuk diagnosis karena menggunakan aturan IF-THEN dari pakar. K-Means sesuai untuk analisis data karena dapat mengelompokkan pasien berdasarkan kemiripan pola gejala. Dengan demikian, sistem tidak hanya memberikan hasil diagnosis, tetapi juga menyediakan laporan pengelompokan pasien.
```

## 4. Kenapa K-Means Dipakai di Laporan, Bukan di Awal Diagnosis?

Jawaban:

```text
K-Means membutuhkan kumpulan data pasien untuk membentuk cluster. Pada sistem ini, data tersebut tersedia setelah pasien melakukan diagnosis dan gejalanya tersimpan. Oleh karena itu, K-Means ditempatkan pada halaman laporan untuk menganalisis riwayat pasien yang sudah ada.
```

## 5. Apakah K-Means Mempengaruhi Hasil Diagnosis?

Jawaban:

```text
Tidak. Hasil diagnosis tetap ditentukan oleh Forward Chaining. K-Means hanya menampilkan pola pengelompokan pasien berdasarkan gejala. Pemisahan fungsi ini dilakukan agar diagnosis tetap berbasis aturan pakar, sedangkan clustering digunakan sebagai analisis pendukung.
```

## 6. Kenapa Nilai K Menggunakan 5?

Jawaban:

```text
Nilai K=5 digunakan karena penelitian membatasi jenis hepatitis sampai Hepatitis A, B, C, D, dan E. Namun K=5 tidak berarti setiap cluster otomatis mewakili satu jenis hepatitis. Nilai tersebut digunakan untuk membentuk lima kelompok pola gejala, kemudian makna tiap cluster dibaca berdasarkan gejala dominan dan distribusi diagnosis Forward Chaining.
```

Jika jumlah data pasien kurang dari 5:

```text
Sistem menyesuaikan jumlah cluster aktual dengan jumlah data pasien yang tersedia. Misalnya jika hanya ada 3 pasien yang memiliki riwayat gejala, maka cluster aktual menjadi 3 agar proses K-Means tetap valid.
```

## 7. Kenapa Data Gejala Dibuat 0 dan 1?

Jawaban:

```text
Karena input sistem berupa checkbox gejala. Jika pasien memilih suatu gejala, maka nilainya 1. Jika tidak memilih, nilainya 0. Bentuk 0/1 membuat data gejala dapat diproses secara numerik oleh K-Means.
```

Contoh:

```text
Pasien memilih G01, G02, dan G05.
Jika daftar gejala adalah G01, G02, G03, G04, G05, maka vektornya:
[1, 1, 0, 0, 1]
```

## 8. Apakah Bobot Gejala Dipakai di K-Means?

Jawaban:

```text
Pada implementasi ini, K-Means menggunakan data kehadiran gejala 0/1. Bobot gejala digunakan pada proses Forward Chaining untuk menghitung persentase kecocokan diagnosis. Pemisahan ini dilakukan agar clustering fokus pada pola kemunculan gejala, sedangkan diagnosis tetap mempertimbangkan bobot aturan.
```

## 9. Apakah Usia, Jenis Kelamin, dan Data Laboratorium Dipakai?

Jawaban:

```text
Tidak. Sistem saat ini dibatasi pada diagnosis awal berbasis gejala. Usia dan jenis kelamin hanya menjadi data identitas pasien. Data laboratorium seperti SGPT dan SGOT belum tersedia secara konsisten pada aplikasi, sehingga tidak dimasukkan ke proses Forward Chaining maupun K-Means.
```

Jika ditanya kenapa:

```text
Karena sistem ini ditujukan sebagai alat bantu diagnosis awal, bukan pengganti diagnosis medis lengkap. Pemeriksaan laboratorium tetap menjadi bagian dari diagnosis final oleh dokter dan dapat menjadi pengembangan selanjutnya.
```

## 10. Bagaimana Cara Membuktikan Forward Chaining Berjalan?

Jawaban:

```text
Pembuktiannya dilihat dari proses pencocokan gejala terpilih terhadap aturan penyakit pada tabel relasi penyakit-gejala. Sistem menghitung jumlah gejala yang cocok untuk setiap penyakit, lalu memilih penyakit dengan jumlah kecocokan paling tinggi. Setelah itu sistem menghitung persentase nilai dari total bobot gejala yang cocok.
```

File pembuktian:

- `init/app/Http/Controllers/HasilPakarController.php`
- Method `proses()`
- Tabel aturan: `pivot_penyakits`
- Tabel gejala hasil konsultasi: `pivot_hasil_pakars`
- Tabel hasil diagnosis: `hasil_pakars`

## 11. Bagaimana Cara Membuktikan K-Means Berjalan?

Jawaban:

```text
Pembuktian K-Means terdapat pada halaman laporan. Sistem membentuk matriks gejala pasien 0/1, menentukan centroid awal, menghitung jarak data ke centroid, menentukan cluster terdekat, memperbarui centroid, dan mengulang proses sampai cluster stabil. Hasil akhirnya ditampilkan berupa cluster pasien, gejala dominan, distribusi diagnosis, grafik, iterasi, Silhouette Score, dan Davies-Bouldin Index.
```

File pembuktian:

- `init/app/Services/KMeansService.php`
- `init/app/Http/Controllers/HasilPakarController.php`
- `init/resources/views/report/index.blade.php`

## 12. Kalau Nilai Evaluasi K-Means Rendah, Apakah Penelitian Gagal?

Jawaban:

```text
Tidak. Jika nilai evaluasi rendah, artinya pola gejala pasien sulit dipisahkan secara jelas oleh K-Means. Hal ini wajar karena beberapa jenis hepatitis memiliki gejala yang mirip atau tumpang tindih. Kesimpulannya, K-Means kurang tepat sebagai metode utama diagnosis, tetapi masih dapat digunakan sebagai analisis pendukung untuk melihat pola kemiripan pasien.
```

## 13. Apa Kesimpulan Paling Aman?

Jawaban:

```text
Forward Chaining terbukti sesuai sebagai metode diagnosis karena bekerja berdasarkan aturan pakar. K-Means dapat digunakan sebagai metode pendukung untuk pengelompokan pasien berdasarkan kemiripan gejala. K-Means tidak digunakan sebagai penentu diagnosis utama karena bersifat unsupervised dan hasil cluster perlu diinterpretasikan berdasarkan dominasi gejala serta diagnosis Forward Chaining.
```

