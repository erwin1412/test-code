# Test Code: Starter Tes Teknis Junior Developer

Aplikasi kecil milik sebuah ISP: data **pelanggan** dan **layanan internet** mereka. Modul ini sudah berjalan. Tugasmu melanjutkannya sesuai spec, persis seperti pekerjaan harian di tim kami.

- Tugas fitur: [docs/SPEC-TIKET.md](docs/SPEC-TIKET.md)
- Laporan bug: [docs/BUG-REPORTS.md](docs/BUG-REPORTS.md)

## Kebutuhan

- PHP 8.3 atau lebih baru (ekstensi `pdo_mysql`, `pdo_sqlite`)
- Composer 2
- MySQL 8 (Laragon, XAMPP, Docker, atau lainnya)

Stack: Laravel 13, Blade, MySQL. Tidak butuh Node/npm.

## Setup

```bash
composer install
cp .env.example .env
php artisan key:generate

# buat database kosong bernama test_code di MySQL, sesuaikan DB_* di .env bila perlu
php artisan migrate --seed

php artisan serve
```

Buka http://127.0.0.1:8000/services untuk halaman web, atau panggil API di `http://127.0.0.1:8000/api/...`.

Menjalankan test (memakai SQLite in-memory, tidak menyentuh database MySQL):

```bash
php artisan test
```

## Struktur dan konvensi

Ikuti pola di bawah saat menambah fitur. Kode yang konsisten dengan pola ini dinilai lebih baik daripada kode yang "jalan tapi beda gaya".

| Hal | Di mana | Catatan |
| --- | --- | --- |
| Format respons API | `app/Support/ApiResponse.php` | `success()` dan `error()`. Error validasi/404 di `/api/*` otomatis diformat di `bootstrap/app.php` |
| Validasi input | `app/Http/Requests` | Satu Form Request per aksi |
| Bentuk output | `app/Http/Resources` | Jangan mengembalikan model mentah |
| Nilai tetap (status, dll.) | `app/Enums` | Backed enum, di-cast di model |
| Controller API | `app/Http/Controllers/Api` | |
| Halaman web | `resources/views`, layout `layouts/app.blade.php` | |
| Test | `tests/Feature` | `RefreshDatabase`, factory untuk data |

## Endpoint yang sudah ada

| Method | Path | Keterangan |
| --- | --- | --- |
| GET | `/api/customers?search=` | Daftar pelanggan (cari nama atau kode) |
| GET | `/api/customers/{customer_code}` | Detail pelanggan + layanannya |
| GET | `/api/services?status=&search=&per_page=` | Daftar layanan; `search` = kode layanan atau kode pelanggan |
| GET | `/api/services/{service_code}` | Detail layanan |
| PATCH | `/api/services/{service_code}/status` | Body: `status`, `reason` (opsional) |
| GET | `/services` | Halaman daftar layanan |

Aturan status layanan: `active` ↔ `isolated`, `active`/`isolated` → `terminated`, dan `terminated` bersifat final.

## Cara mengumpulkan

1. Klik **Use this template → Create a new repository**, buat repo **private** di akun GitHub-mu, lalu undang `erwin1412` sebagai collaborator.
2. Clone repo-mu, lalu kerjakan di branch `feature/ticketing`. Commit bertahap dengan pesan yang jelas.
3. Buat Pull Request dari `feature/ticketing` ke `main` di repo-mu, lalu kirim link PR-nya.
4. Deskripsi PR berisi ringkasan perubahan, cara mengetes, dan asumsi yang kamu ambil.

Dokumen pendukung (`PROMPTS.md`, `DEBUG_LOG.md`, `BUGFIX.md`) diletakkan di root repo. Detailnya ada di instruksi tes yang dikirim lewat email.
