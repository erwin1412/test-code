# Laporan Bug dari Tim Support

Tiga laporan di bawah masuk untuk modul layanan (`services`) yang sudah ada. Laporan ditulis oleh tim support, jadi isinya gejala, bukan penyebab.

Untuk setiap laporan:

1. Reproduksi masalahnya.
2. Temukan penyebabnya di kode.
3. Tulis test yang **gagal** sebelum diperbaiki dan **lulus** sesudahnya.
4. Perbaiki.
5. Catat di `BUGFIX.md`: penyebab, dampak, dan perbaikannya.

Kalau saat bekerja kamu menemukan bug lain di kode yang sudah ada, catat juga di `BUGFIX.md`. Itu nilai tambah.

---

## BUG-01: Filter status tidak berlaku saat mencari pelanggan

> "Saya buka daftar layanan, pilih status **active**, lalu cari pakai kode pelanggan. Yang muncul malah ada layanan yang sudah **terminated** juga. Kalau tanpa pencarian, filternya benar."

Endpoint: `GET /api/services?status=active&search={customer_code}`

## BUG-02: Layanan yang sudah diputus bisa diaktifkan lagi

> "Layanan pelanggan sudah kami putus (terminated) bulan lalu. Hari ini ada yang tidak sengaja mengubah statusnya jadi **active** lewat aplikasi dan berhasil. Bukannya putus itu final?"

Endpoint: `PATCH /api/services/{service_code}/status`

## BUG-03: Daftar layanan makin lambat saat data bertambah

> "Waktu datanya masih sedikit cepat. Sekarang buka daftar layanan dengan `per_page=100` terasa lambat sekali, padahal servernya tidak sibuk."

Endpoint: `GET /api/services`

Petunjuk: hitung berapa query database yang dijalankan untuk satu request.
