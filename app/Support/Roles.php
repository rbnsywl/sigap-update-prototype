<?php

namespace App\Support;

/**
 * Role definitions, mock users, and per-role sidebar navigation.
 *
 * NOTE (for backend integration):
 * - Replace the static $users list with your Eloquent User model + a `role` column.
 * - The sidebar structure can stay as config, driven by the authenticated user's role.
 */
class Roles
{
    public const DOSEN       = 'ROLE_DOSEN';
    public const STAFF_PRODI = 'ROLE_STAFF_PRODI';
    public const KAPRODI     = 'ROLE_KAPRODI';
    public const ADMIN_SDM   = 'ROLE_ADMIN_SDM';
    public const ATASAN_SDM  = 'ROLE_ATASAN_SDM';
    public const SEKDEK      = 'ROLE_SEKDEK_ADMIN';
    public const DEKAN       = 'ROLE_DEKAN';
    public const KETUA_KK    = 'ROLE_KETUA_KK';

    /**
     * Mock accounts for the role switcher (no real auth).
     */
    public static function users(): array
    {
        return [
            self::DOSEN => [
                'name' => 'Dr. (Cand.) Rangga Pratama, S.E., M.M.',
                'short' => 'Rangga Pratama',
                'role' => self::DOSEN,
                'role_label' => 'Dosen (Pemohon)',
                'nip' => '21880042',
                'prodi' => 'S1 Manajemen',
                'kk' => 'Manajemen Keuangan',
                'jad' => 'Lektor',
                'avatar' => 'RP',
                'home' => '/dashboard',
            ],
            self::STAFF_PRODI => [
                'name' => 'Siti Nurhaliza, S.Ikom.',
                'short' => 'Siti Nurhaliza',
                'role' => self::STAFF_PRODI,
                'role_label' => 'Staf Program Studi',
                'nip' => '21900115',
                'prodi' => 'S1 Manajemen',
                'avatar' => 'SN',
                'home' => '/prodi/dashboard',
            ],
            self::KAPRODI => [
                'name' => 'Dr. Bambang Wijaya, S.E., M.Si.',
                'short' => 'Bambang Wijaya',
                'role' => self::KAPRODI,
                'role_label' => 'Ketua Program Studi',
                'nip' => '21850077',
                'prodi' => 'S1 Manajemen',
                'avatar' => 'BW',
                'home' => '/kaprodi/dashboard',
            ],
            self::ADMIN_SDM => [
                'name' => 'Dewi Anggraini, S.A.B.',
                'short' => 'Dewi Anggraini',
                'role' => self::ADMIN_SDM,
                'role_label' => 'Admin SDM Fakultas',
                'nip' => '21910203',
                'avatar' => 'DA',
                'home' => '/admin-sdm/dashboard',
            ],
            self::ATASAN_SDM => [
                'name' => 'Agus Salim, S.E., M.M.',
                'short' => 'Agus Salim',
                'role' => self::ATASAN_SDM,
                'role_label' => 'Atasan SDM (Manajer)',
                'nip' => '21830011',
                'avatar' => 'AS',
                'home' => '/atasan-sdm/dashboard',
            ],
            self::SEKDEK => [
                'name' => 'Rina Marlina, A.Md.',
                'short' => 'Rina Marlina',
                'role' => self::SEKDEK,
                'role_label' => 'Admin Sekretariat Dekanat',
                'nip' => '21920308',
                'avatar' => 'RM',
                'home' => '/sekdek/dashboard',
            ],
            self::DEKAN => [
                'name' => 'Prof. Dr. Hendra Gunawan, S.E., M.B.A.',
                'short' => 'Hendra Gunawan',
                'role' => self::DEKAN,
                'role_label' => 'Dekan FEB',
                'nip' => '21790005',
                'avatar' => 'HG',
                'home' => '/dekan/dashboard',
            ],
            self::KETUA_KK => [
                'name' => 'Dr. Lestari Handayani, S.E., M.Ak.',
                'short' => 'Lestari Handayani',
                'role' => self::KETUA_KK,
                'role_label' => 'Ketua Kelompok Keahlian',
                'nip' => '21820044',
                'kk' => 'Akuntansi Keuangan',
                'avatar' => 'LH',
                'home' => '/kk/dashboard',
            ],
        ];
    }

    public static function user(string $role): ?array
    {
        return self::users()[$role] ?? null;
    }

    /**
     * Sidebar navigation per role. Each group has a label and items.
     * Item: [label, route (path), icon key, optional badge]
     */
    public static function sidebar(string $role): array
    {
        return match ($role) {
            self::DOSEN => [
                ['UTAMA', [
                    ['Dashboard', '/dashboard', 'home'],
                    ['Profil Saya', '/profil', 'user'],
                ]],
                ['SURAT TUGAS', [
                    ['Pengajuan ST', '/surat-tugas/ajukan', 'edit'],
                    ['Riwayat & Status ST', '/surat-tugas/riwayat', 'folder'],
                ]],
                ['STUDI PID (BEASISWA DOKTORAL)', [
                    ['Cek Kelayakan PID', '/studi-pid/cek-kelayakan', 'search'],
                    ['Pengajuan PID', '/studi-pid/pengajuan', 'doc'],
                    ['Laporan LKS', '/studi-pid/lks', 'clipboard'],
                    ['Reimburs Biaya', '/studi-pid/reimburs', 'wallet'],
                    ['Kelulusan PID', '/studi-pid/kelulusan', 'cap'],
                ]],
                ['STUDI NON-PID', [
                    ['Penyetaraan S3', '/studi-non-pid/penyetaraan', 'scroll'],
                ]],
                ['SISTEM', [
                    ['Pusat Bantuan', '/bantuan', 'help'],
                ]],
            ],
            self::STAFF_PRODI => [
                ['UTAMA', [
                    ['Dashboard Prodi', '/prodi/dashboard', 'home'],
                ]],
                ['MANAJEMEN SURAT TUGAS', [
                    ['Verifikasi ST Masuk', '/prodi/verifikasi-st', 'inbox', 4],
                    ['Pemeriksaan Kelompok', '/prodi/verifikasi-kelompok', 'users'],
                    ['Arsip Pengajuan Prodi', '/prodi/arsip', 'archive'],
                ]],
                ['SISTEM', [
                    ['Bantuan', '/bantuan', 'help'],
                ]],
            ],
            self::KAPRODI => [
                ['UTAMA', [
                    ['Dashboard Kaprodi', '/kaprodi/dashboard', 'home'],
                ]],
                ['PERSETUJUAN & APPROVAL', [
                    ['Approval Surat Tugas', '/kaprodi/approval-st', 'check', 3],
                    ['Review Penyetaraan S3', '/kaprodi/penyetaraan-s3', 'cap'],
                ]],
                ['REKAPITULASI PRODI', [
                    ['Monitoring Kinerja Dosen', '/kaprodi/monitoring-kinerja', 'chart'],
                ]],
                ['SISTEM', [
                    ['Pengaturan', '/pengaturan', 'settings'],
                ]],
            ],
            self::ADMIN_SDM => [
                ['UTAMA', [
                    ['Dashboard Admin SDM', '/admin-sdm/dashboard', 'home'],
                ]],
                ['MODUL SURAT TUGAS', [
                    ['Pembuatan Draf ST', '/admin-sdm/surat-tugas/draft', 'edit', 2],
                    ['Request Nomor Surat', '/admin-sdm/surat-tugas/request-nomor', 'hash'],
                    ['Penerbitan ST', '/admin-sdm/surat-tugas/penerbitan', 'printer'],
                ]],
                ['MODUL STUDI PID', [
                    ['Monitor Kelayakan PID', '/admin-sdm/pid/kelayakan', 'chart'],
                    ['Pengajuan Masuk PID', '/admin-sdm/pid/pengajuan', 'inbox'],
                    ['Monitoring Dosen PID', '/admin-sdm/pid/monitoring', 'search'],
                    ['Validasi LKS Semester', '/admin-sdm/pid/validasi-lks', 'clipboard', 5],
                    ['Catatan Pembiayaan & Reimburs', '/admin-sdm/pid/pembiayaan', 'wallet'],
                    ['Pelaporan Kelulusan PID', '/admin-sdm/pid/kelulusan', 'cap'],
                ]],
                ['MODUL PENYETARAAN S3 NON-PID', [
                    ['Kelola Penyetaraan S3', '/admin-sdm/penyetaraan', 'scroll'],
                ]],
                ['DATA & MASTER', [
                    ['Master Data Dosen', '/admin-sdm/data-dosen', 'users'],
                    ['Laporan & Rekap Eksekutif', '/admin-sdm/laporan', 'report'],
                ]],
                ['SISTEM', [
                    ['Konfigurasi Sistem', '/admin-sdm/pengaturan', 'settings'],
                ]],
            ],
            self::ATASAN_SDM => [
                ['UTAMA', [
                    ['Dashboard Manajerial', '/atasan-sdm/dashboard', 'home'],
                ]],
                ['VALIDASI BERJENJANG', [
                    ['Validasi Surat Tugas', '/atasan-sdm/validasi-st', 'shield', 2],
                    ['Validasi Usulan Reimburs', '/atasan-sdm/validasi-reimburs', 'wallet'],
                ]],
                ['MONITORING & KEPATUHAN', [
                    ['Monitoring Studi Lanjut', '/atasan-sdm/monitoring-studi', 'chart'],
                ]],
                ['SISTEM', [
                    ['Bantuan', '/bantuan', 'help'],
                ]],
            ],
            self::SEKDEK => [
                ['UTAMA', [
                    ['Dashboard Sekdek', '/sekdek/dashboard', 'home'],
                ]],
                ['TATA KELOLA SURAT', [
                    ['Penomoran Surat Tugas', '/sekdek/penomoran-st', 'hash', 2],
                    ['Buku Agenda Surat Keluar', '/sekdek/buku-agenda', 'book'],
                ]],
                ['SISTEM', [
                    ['Pengaturan Register', '/sekdek/pengaturan', 'settings'],
                ]],
            ],
            self::DEKAN => [
                ['UTAMA', [
                    ['Executive Dashboard', '/dekan/dashboard', 'home'],
                ]],
                ['PENGESAHAN & APPROVAL AKHIR', [
                    ['Tanda Tangan Surat Tugas', '/dekan/ttd-st', 'pen', 2],
                    ['Approval LKS Semesteran', '/dekan/approval-lks', 'clipboard', 3],
                    ['Penetapan Penyetaraan S3', '/dekan/approval-penyetaraan', 'cap'],
                ]],
                ['SISTEM & ARSIP', [
                    ['Laporan Eksekutif SDM', '/dekan/laporan-eksekutif', 'report'],
                ]],
            ],
            self::KETUA_KK => [
                ['UTAMA', [
                    ['Dashboard KK', '/kk/dashboard', 'home'],
                ]],
                ['PENILAIAN AKADEMIK', [
                    ['Penilaian Penyetaraan S3', '/kk/penilaian-s3', 'cap', 1],
                    ['Riwayat Penilaian', '/kk/riwayat-penilaian', 'archive'],
                ]],
                ['SISTEM', [
                    ['Bantuan', '/bantuan', 'help'],
                ]],
            ],
            default => [],
        };
    }
}
