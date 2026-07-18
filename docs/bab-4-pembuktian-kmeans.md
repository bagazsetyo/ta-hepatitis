# Bahan BAB IV: Pembuktian Implementasi K-Means

Dokumen ini berisi bahan narasi dan data yang perlu diambil dari halaman laporan aplikasi setelah implementasi K-Means. Gunakan dokumen ini untuk menyusun bagian BAB IV agar klaim penggunaan K-Means memiliki bukti implementasi.

## 1. Posisi Metode pada Sistem

Pada aplikasi, metode Forward Chaining digunakan sebagai metode utama untuk menentukan diagnosis hepatitis berdasarkan aturan gejala-penyakit. Metode K-Means digunakan sebagai metode pendukung untuk mengelompokkan data pasien berdasarkan kemiripan pola gejala.

Alur implementasi:

```text
Input pasien dan gejala
→ Forward Chaining menentukan diagnosis
→ hasil diagnosis dan gejala tersimpan
→ K-Means membaca riwayat gejala pasien
→ K-Means membentuk cluster pasien
→ laporan menampilkan cluster, chart, dan evaluasi cluster
```

## 2. Data yang Perlu Diambil dari Halaman Laporan

Halaman laporan sekarang menyediakan beberapa bagian yang bisa dijadikan bukti BAB IV:

- Jumlah data pasien yang masuk proses clustering.
- Nilai K yang digunakan.
- Silhouette Score.
- Davies-Bouldin Index.
- Grafik jumlah pasien per cluster.
- Grafik distribusi diagnosis per cluster.
- Ringkasan anggota cluster.
- Gejala dominan pada tiap cluster.
- Matriks pasien berdasarkan gejala 0/1.
- Matriks pasien berdasarkan hasil diagnosis Forward Chaining.
- Tabel iterasi K-Means.

## 3. Narasi Pembuktian Data Input

Contoh narasi:

```text
Data yang digunakan pada proses K-Means merupakan data riwayat gejala pasien yang diperoleh dari hasil konsultasi pada sistem. Setiap gejala dikodekan dalam bentuk biner, yaitu nilai 1 apabila gejala dialami pasien dan nilai 0 apabila gejala tidak dialami pasien. Bentuk data biner ini digunakan karena input diagnosis pada sistem berupa pemilihan gejala melalui checkbox.
```

## 4. Narasi Nilai K

Contoh narasi:

```text
Jumlah cluster yang digunakan adalah K=5. Nilai K=5 dipilih karena penelitian ini membatasi jenis hepatitis sampai Hepatitis A, B, C, D, dan E. Namun, hasil cluster tidak secara langsung merepresentasikan masing-masing jenis hepatitis karena K-Means merupakan metode unsupervised. Oleh karena itu, interpretasi cluster dilakukan berdasarkan dominasi gejala dan distribusi hasil diagnosis Forward Chaining pada anggota cluster.
```

## 5. Narasi Hasil Cluster

Contoh narasi:

```text
Berdasarkan hasil clustering, pasien terbagi ke dalam beberapa cluster sesuai kemiripan pola gejala. Setiap cluster memiliki karakteristik yang dapat dilihat dari gejala dominan dan distribusi diagnosis pada anggota cluster. Informasi ini menunjukkan bahwa K-Means dapat digunakan untuk membantu menganalisis pola kemiripan gejala pasien, bukan sebagai penentu utama diagnosis.
```

Sesuaikan kalimat berikut berdasarkan hasil nyata pada laporan:

```text
Cluster 1 terdiri dari ... pasien dan didominasi oleh gejala ....
Cluster 2 terdiri dari ... pasien dan didominasi oleh gejala ....
Cluster 3 terdiri dari ... pasien dan didominasi oleh gejala ....
Cluster 4 terdiri dari ... pasien dan didominasi oleh gejala ....
Cluster 5 terdiri dari ... pasien dan didominasi oleh gejala ....
```

## 6. Narasi Evaluasi Silhouette Score

Silhouette Score digunakan untuk melihat kualitas pemisahan cluster. Nilainya berada pada rentang -1 sampai 1.

Interpretasi umum:

- Mendekati 1 berarti data dalam cluster cukup rapat dan terpisah baik dari cluster lain.
- Mendekati 0 berarti data berada di batas antar cluster.
- Mendekati -1 berarti data kemungkinan berada pada cluster yang kurang tepat.

Contoh narasi jika nilainya cukup baik:

```text
Nilai Silhouette Score yang diperoleh adalah .... Nilai tersebut menunjukkan bahwa pola gejala pasien memiliki pemisahan cluster yang cukup baik, sehingga hasil clustering dapat digunakan sebagai informasi pendukung dalam analisis laporan pasien.
```

Contoh narasi jika nilainya rendah:

```text
Nilai Silhouette Score yang diperoleh adalah .... Nilai tersebut menunjukkan bahwa pemisahan antar cluster belum terlalu kuat. Hal ini dapat terjadi karena beberapa jenis hepatitis memiliki gejala yang saling tumpang tindih. Dengan demikian, K-Means kurang tepat digunakan sebagai metode utama diagnosis, tetapi masih dapat digunakan sebagai metode pendukung untuk melihat pola kemiripan gejala pasien.
```

## 7. Narasi Evaluasi Davies-Bouldin Index

Davies-Bouldin Index digunakan untuk melihat kualitas cluster berdasarkan kedekatan data dalam cluster dan jarak antar cluster. Semakin kecil nilainya, semakin baik kualitas cluster.

Contoh narasi:

```text
Nilai Davies-Bouldin Index yang diperoleh adalah .... Nilai ini digunakan sebagai indikator kualitas cluster, di mana nilai yang lebih kecil menunjukkan cluster yang lebih baik. Hasil ini menjadi dasar untuk menilai apakah pengelompokan pola gejala pasien cukup representatif sebagai analisis pendukung.
```

## 8. Kesimpulan Pengujian K-Means

Kesimpulan aman:

```text
Berdasarkan hasil implementasi dan evaluasi, K-Means dapat digunakan sebagai metode pendukung untuk mengelompokkan pasien berdasarkan kemiripan pola gejala. Namun, K-Means tidak digunakan sebagai metode utama untuk menentukan jenis hepatitis karena algoritma ini bersifat unsupervised dan tidak menggunakan aturan medis. Diagnosis utama tetap ditentukan menggunakan Forward Chaining berdasarkan basis aturan yang divalidasi oleh pakar.
```

## 9. Catatan untuk Screenshot BAB IV

Screenshot yang sebaiknya disiapkan:

- Tampilan ringkasan metrik K-Means.
- Grafik jumlah pasien per cluster.
- Grafik distribusi diagnosis per cluster.
- Tabel hasil cluster dan gejala dominan.
- Matriks data gejala 0/1.
- Tabel iterasi K-Means.

