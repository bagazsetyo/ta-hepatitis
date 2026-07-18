# Penjelasan Sederhana Sistem untuk Dosen Non-Teknis

Dokumen ini menjelaskan cara kerja aplikasi dengan bahasa sederhana agar dosen yang tidak mendalami sistem atau pemrograman tetap dapat memahami alurnya.

## 1. Tujuan Aplikasi

Aplikasi ini dibuat untuk membantu proses diagnosis awal penyakit hepatitis berdasarkan gejala yang dialami pasien. Sistem tidak menggantikan dokter, tetapi menjadi alat bantu untuk memberikan gambaran awal jenis hepatitis yang paling mungkin.

Jenis hepatitis yang menjadi batasan penelitian:

- Hepatitis A
- Hepatitis B
- Hepatitis C
- Hepatitis D
- Hepatitis E

## 2. Data yang Dipakai

Data utama yang dipakai sistem adalah:

- data pasien;
- data gejala;
- data penyakit hepatitis;
- aturan hubungan antara gejala dan penyakit;
- solusi atau rekomendasi awal;
- riwayat hasil diagnosis pasien.

Pada sistem ini, pasien memilih gejala melalui daftar checkbox. Gejala yang dipilih kemudian diproses oleh sistem.

## 3. Cara Sistem Menentukan Diagnosis

Sistem menggunakan metode Forward Chaining.

Penjelasan sederhananya:

```text
Forward Chaining bekerja dari fakta menuju kesimpulan.
Fakta = gejala yang dipilih pasien.
Kesimpulan = jenis hepatitis yang paling sesuai.
```

Contoh sederhana:

```text
Jika pasien mengalami demam, mual, mata kuning, dan urine gelap,
maka sistem mencocokkan gejala tersebut dengan aturan penyakit.
Penyakit yang paling banyak memiliki kecocokan gejala akan dipilih sebagai hasil diagnosis.
```

Jadi Forward Chaining berperan seperti proses berpikir berbasis aturan:

```text
IF gejala tertentu muncul
THEN kemungkinan penyakit tertentu
```

## 4. Fungsi K-Means pada Aplikasi

K-Means tidak digunakan untuk menentukan diagnosis utama.

K-Means digunakan untuk mengelompokkan pasien yang memiliki pola gejala mirip.

Contoh sederhana:

```text
Pasien A dan pasien B sama-sama mengalami demam, mual, dan nyeri perut.
Maka K-Means dapat menempatkan mereka pada kelompok yang sama.
```

Tujuan K-Means:

- melihat pola kemiripan antar pasien;
- mengetahui gejala yang dominan pada kelompok pasien tertentu;
- membantu membuat laporan analisis;
- mendukung pembahasan BAB IV.

## 5. Perbedaan Forward Chaining dan K-Means

Forward Chaining:

- digunakan untuk diagnosis;
- memakai aturan pakar;
- menghasilkan jenis hepatitis;
- cocok untuk sistem pakar.

K-Means:

- digunakan untuk pengelompokan pasien;
- memakai data gejala dalam bentuk angka;
- menghasilkan cluster atau kelompok;
- cocok untuk analisis pola data.

Ringkasnya:

```text
Forward Chaining menjawab: pasien kemungkinan terkena hepatitis apa?
K-Means menjawab: pasien ini mirip dengan kelompok pasien yang mana?
```

## 6. Kenapa K-Means Tidak Langsung Menentukan Penyakit?

Karena K-Means hanya mengelompokkan data berdasarkan kemiripan angka. K-Means tidak memahami aturan medis dan tidak mengetahui label penyakit sejak awal.

Maka dari itu:

```text
Cluster 1 tidak otomatis berarti Hepatitis A.
Cluster 2 tidak otomatis berarti Hepatitis B.
```

Makna cluster dibaca setelah proses clustering, dengan melihat:

- gejala yang dominan;
- hasil diagnosis Forward Chaining pada anggota cluster;
- validasi dari pakar atau dokter jika tersedia.

## 7. Bukti yang Bisa Dilihat di Aplikasi

Pada halaman laporan, aplikasi menampilkan:

- jumlah pasien yang diproses K-Means;
- jumlah cluster;
- grafik jumlah pasien per cluster;
- grafik distribusi diagnosis per cluster;
- daftar anggota tiap cluster;
- gejala dominan tiap cluster;
- tabel data gejala 0/1;
- tabel iterasi K-Means;
- nilai evaluasi cluster.

Bagian ini dapat digunakan sebagai bukti bahwa metode K-Means benar-benar dijalankan dalam aplikasi.

## 8. Kesimpulan Sederhana

Aplikasi menggunakan dua metode dengan fungsi yang berbeda.

```text
Forward Chaining digunakan untuk menentukan diagnosis awal hepatitis berdasarkan aturan gejala.
K-Means digunakan untuk mengelompokkan riwayat pasien berdasarkan kemiripan gejala.
```

Dengan alur ini, sistem tetap memiliki dasar diagnosis yang jelas melalui aturan pakar, sekaligus memiliki analisis tambahan melalui pengelompokan data pasien.

