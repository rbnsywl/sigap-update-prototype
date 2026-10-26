# SIGAP FEB — Prototype Frontend (Laravel + Blade)

Prototype UI untuk **Sistem Integrasi Administrasi dan Pengelolaan Sumber Daya FEB – Telkom University**.
Dibangun dengan **Laravel 13 + Blade + Tailwind (CDN) + Alpine.js**, memakai **data mock** (belum terhubung database) agar bisa langsung jalan di lokal untuk prototyping.

> Target: setelah desain disetujui, prototype ini tinggal diintegrasikan ke aplikasi Laravel existing — controller & view sudah mengikuti struktur Laravel standar.

---

## Menjalankan di Lokal

Prasyarat: PHP 8.2+ dan Composer.

```bash
cd sigap-feb
composer install          # jika folder vendor belum ada
php artisan key:generate  # jika APP_KEY belum di-set
php artisan serve
```

Buka `http://localhost:8000` → akan diarahkan ke halaman **login**.

### Mock Login (tanpa password)
Di halaman login, pilih salah satu dari **8 peran** untuk masuk ke sudut pandang masing-masing:

| Peran | Home |
|---|---|
| Dosen (Pemohon) | `/dashboard` |
| Staf Program Studi | `/prodi/dashboard` |
| Ketua Program Studi | `/kaprodi/dashboard` |
| Admin SDM Fakultas | `/admin-sdm/dashboard` |
| Atasan SDM | `/atasan-sdm/dashboard` |
| Admin Sekretariat Dekanat | `/sekdek/dashboard` |
| Dekan / Wakil Dekan | `/dekan/dashboard` |
| Ketua Kelompok Keahlian | `/kk/dashboard` |

Untuk berpindah peran: klik **"Ganti"** di header, atau buka `/switch-role`.

---

## Cakupan (semua 5 modul × 8 role)

- **Modul 1 — Surat Tugas**: pengajuan (individu/kelompok + *Add More* anggota), verifikasi prodi, approval kaprodi, drafting SDM, validasi atasan SDM, penomoran sekdek, TTD dekan (BSrE), fitur revisi pasca-terbit dengan **countdown 3 hari**.
- **Modul 2 — Studi PID**: cek kelayakan mandiri (indikator hijau/merah), monitor kelayakan admin (+ *private notes* SDM), pengajuan beasiswa & plafon.
- **Modul 3 — LKS**: form pelaporan + step tracker, unduh template, unggah PDF gabungan, validasi SDM (split view), approval + TTD digital Dekan.
- **Modul 4 — Reimburs & Pembiayaan**: klaim dosen + ringkasan finansial, dashboard pembiayaan admin (plafon/realisasi/sisa, **accordion per semester**, tag sumber data, **modal NDE**).
- **Modul 5 — Penyetaraan S3**: pengajuan 2 kolom + step tracker, distribusi ke 3 asesor, layar penilaian asesor (dipakai KK/Kaprodi/Dekan), berita acara & NDE.

---

## Struktur Kode (untuk integrasi)

```
app/
  Http/Controllers/
    AuthController.php      # mock login / switch role / logout
    PageController.php      # 1 method per layar → ganti MockData dengan Eloquent
  Http/Middleware/
    MockAuth.php            # baca role dari session, share user/sidebar/notif ke view
  Support/
    Roles.php               # definisi 8 role + user contoh + struktur sidebar per role
    MockData.php            # SEMUA data contoh (ganti dengan query DB saat integrasi)
resources/views/
  layouts/app.blade.php     # sidebar navy + header + layout utama
  partials/                 # icon, badge, stat-card, dropzone, page-head (reusable)
  auth/login.blade.php      # halaman pemilihan role
  dosen/ prodi/ kaprodi/ admin_sdm/ atasan_sdm/ sekdek/ dekan/ kk/   # view per role
  shared/                   # asesor-penilaian, bantuan, pengaturan
routes/web.php              # seluruh rute per role (dibungkus middleware mock.auth)
```

### Langkah integrasi database (ringkas)
1. Buat model Eloquent + migration untuk: `users` (dengan kolom `role`), `surat_tugas`, `pengajuan_pid`, `lks`, `reimburs`, `penyetaraan_s3`, dsb.
2. Ganti isi method di `PageController` dari `MockData::*` menjadi query Eloquent.
3. Ganti `MockAuth` dengan middleware `auth` bawaan Laravel + gate/policy berbasis kolom `role`.
4. Tambahkan `FormRequest` untuk validasi pada form `POST` (form di Blade sudah menyertakan `@csrf`).

---

## Catatan Desain
- Warna: Deep Teal `#009CA7` (aksen) · Dark Navy `#1A2232` (sidebar) · surface `#f8f9ff`.
- Font: Inter. Layout desktop-first.
- Tailwind & Alpine via CDN agar zero-build. Untuk produksi, disarankan pindah ke build Vite + Tailwind lokal.
