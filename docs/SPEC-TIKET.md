# Spec: Modul Tiket Gangguan Layanan

## Konteks

Kami penyedia internet (ISP). Satu pelanggan bisa punya beberapa layanan (misalnya rumah dan kantor). Saat ada gangguan, tim support membuat tiket **untuk layanan tertentu**, lalu teknisi memprosesnya sampai selesai.

Modul pelanggan (`customers`) dan layanan (`services`) sudah ada di repo ini. Tugasmu menambahkan modul tiket di atasnya.

## Aturan teknis

- Kerjakan di repo ini (Laravel 13, PHP 8.3+, MySQL 8). Jangan membuat proyek baru.
- **Ikuti pola yang sudah ada**:
  - semua respons API memakai `App\Support\ApiResponse`;
  - validasi input memakai Form Request di `app/Http/Requests`;
  - output memakai API Resource di `app/Http/Resources`;
  - nilai tetap (status, kategori, prioritas) memakai backed enum di `app/Enums`, seperti `ServiceStatus`;
  - halaman web memakai layout `resources/views/layouts/app.blade.php`.
- Struktur tabel dibuat lewat migration. Tidak ada query yang menyambung input user secara langsung.
- Timezone aplikasi sudah `Asia/Jakarta` (WIB).

## Data

### tickets

| Kolom | Keterangan |
| --- | --- |
| id | |
| ticket_number | Unik. Format `TKT-YYYYMMDD-NNNN`: tanggal = tanggal dibuat dalam WIB, `NNNN` = urutan ke-berapa pada tanggal itu, mulai `0001` setiap hari |
| service_id | Foreign key ke `services` |
| category | `no_internet` \| `slow` \| `los_red` \| `other` |
| description | Wajib, 10–1000 karakter |
| priority | `low` \| `normal` \| `high` |
| status | `open` \| `in_progress` \| `resolved` \| `closed` |
| resolved_at | datetime, nullable |
| created_at, updated_at | |

### ticket_logs

`id`, `ticket_id`, `from_status` (nullable), `to_status`, `note` (nullable), `created_at`

## Aturan bisnis

1. Layanan berstatus `terminated` **tidak boleh** dibuatkan tiket → HTTP 422. Layanan `isolated` **boleh** (gangguan bisa karena isolir).
2. Satu **layanan** hanya boleh punya **satu** tiket aktif (`open` atau `in_progress`) → HTTP 409 bila sudah ada. Pelanggan dengan dua layanan boleh punya dua tiket aktif, satu per layanan.
3. Kategori `los_red` selalu berprioritas `high`, apa pun input priority. Bila priority tidak dikirim, default `normal`.
4. Transisi status yang sah **hanya**:
   - `open` → `in_progress`
   - `in_progress` → `resolved`
   - `resolved` → `closed`
   - `resolved` → `in_progress` (dibuka ulang)

   Transisi lain → HTTP 422. Tiket `closed` tidak bisa diubah lagi.
5. Saat menjadi `resolved`: `resolved_at` diisi waktu sekarang. Saat dibuka ulang: `resolved_at` dikosongkan.
6. Setiap pembuatan tiket dan setiap perubahan status dicatat di `ticket_logs` (pembuatan: `from_status` = null, `to_status` = `open`). Perubahan status dan log-nya harus dalam **satu database transaction**.

## API (prefix `/api`)

Format respons mengikuti `ApiResponse`, termasuk untuk error 404, 409, dan 422.

| Method | Path | Keterangan |
| --- | --- | --- |
| POST | `/api/tickets` | Body: `service_code`, `category`, `description`, `priority` (opsional). Berhasil → 201 |
| GET | `/api/tickets` | Filter opsional: `status`, `service_code`, `customer_code`. 15 per halaman, terbaru dulu. Tiap item menyertakan `service_code`, `customer_code`, `customer_name` |
| GET | `/api/tickets/{ticket_number}` | Detail tiket + seluruh log urut waktu. Tidak ada → 404 |
| PATCH | `/api/tickets/{ticket_number}/status` | Body: `status`, `note` (opsional) |

**Perubahan pada endpoint yang sudah ada:** `GET /api/services/{service_code}` ditambah field `active_ticket` berisi `{ ticket_number, status, category }` tiket aktif layanan itu, atau `null` bila tidak ada.

## Halaman web

`GET /tickets`: tabel tiket (nomor, kode layanan, pelanggan, kategori, prioritas, status, dibuat), filter status lewat dropdown, dan pagination. Tambahkan menu "Tiket" di navigasi layout.

## Testing (wajib)

Minimal **6 feature test baru** yang lulus, mencakup aturan 1–5 dan format `ticket_number`. Seluruh test yang sudah ada juga harus tetap lulus.

## Di luar cakupan

Login/autentikasi, notifikasi, upload file.
