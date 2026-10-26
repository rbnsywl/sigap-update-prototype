<?php

namespace App\Support;

/**
 * Centralized mock data for the SIGAP FEB prototype.
 *
 * NOTE (for backend integration):
 * Each method below maps naturally to an Eloquent query. Replace the return
 * arrays with Model::query()->...->get() calls. Status strings are kept exactly
 * as specified in the PRD so the state machine can be ported 1:1.
 */
class MockData
{
    /* ---------------------------------------------------------------------
     | Modul 1 — Surat Tugas
     * ------------------------------------------------------------------- */
    public static function suratTugas(): array
    {
        return [
            [
                'id' => 'ST-2026-0042', 'tipe' => 'Individu',
                'dosen' => 'Dr. (Cand.) Rangga Pratama', 'prodi' => 'S1 Manajemen',
                'judul' => 'Narasumber Seminar Nasional Transformasi Digital FEB',
                'kategori' => 'Pengabdian Masyarakat', 'mitra' => 'Universitas Brawijaya',
                'lokasi' => 'Luring — Malang', 'mulai' => '2026-11-10', 'selesai' => '2026-11-11',
                'tanggal_masuk' => '2026-10-20', 'status' => 'Menunggu Verifikasi Prodi',
                'anggota' => [],
                'nomor_surat' => null, 'tanggal_terbit' => null,
            ],
            [
                'id' => 'ST-2026-0041', 'tipe' => 'Kelompok',
                'dosen' => 'Dr. (Cand.) Rangga Pratama', 'prodi' => 'S1 Manajemen',
                'judul' => 'Tim Penelitian Hibah Internal: Digitalisasi UMKM Jawa Barat',
                'kategori' => 'Penelitian', 'mitra' => 'LPPM Telkom University',
                'lokasi' => 'Hybrid', 'mulai' => '2026-11-01', 'selesai' => '2027-04-30',
                'tanggal_masuk' => '2026-10-18', 'status' => 'Menunggu Approval Kaprodi',
                'anggota' => [
                    ['nama' => 'Dr. (Cand.) Rangga Pratama', 'peran' => 'Ketua', 'prodi' => 'S1 Manajemen'],
                    ['nama' => 'Fitra Ramadhan, S.E., M.M.', 'peran' => 'Anggota', 'prodi' => 'S1 Manajemen'],
                    ['nama' => 'Nadia Ulfa, S.Ak., M.Ak.', 'peran' => 'Anggota', 'prodi' => 'S1 Akuntansi'],
                ],
                'nomor_surat' => null, 'tanggal_terbit' => null,
            ],
            [
                'id' => 'ST-2026-0039', 'tipe' => 'Individu',
                'dosen' => 'Dr. (Cand.) Rangga Pratama', 'prodi' => 'S1 Manajemen',
                'judul' => 'Reviewer Jurnal Nasional Terakreditasi Sinta 2',
                'kategori' => 'Penunjang', 'mitra' => 'Jurnal Manajemen Indonesia',
                'lokasi' => 'Daring', 'mulai' => '2026-10-05', 'selesai' => '2026-10-30',
                'tanggal_masuk' => '2026-10-01', 'status' => 'Menunggu Drafting SDM',
                'anggota' => [],
                'nomor_surat' => null, 'tanggal_terbit' => null,
            ],
            [
                'id' => 'ST-2026-0035', 'tipe' => 'Individu',
                'dosen' => 'Dr. (Cand.) Rangga Pratama', 'prodi' => 'S1 Manajemen',
                'judul' => 'Pemateri Workshop Metodologi Penelitian Kuantitatif',
                'kategori' => 'Pendidikan & Pengajaran', 'mitra' => 'STIE Ekuitas Bandung',
                'lokasi' => 'Luring — Bandung', 'mulai' => '2026-10-15', 'selesai' => '2026-10-15',
                'tanggal_masuk' => '2026-10-08', 'status' => 'Perlu Revisi Dosen',
                'catatan' => 'Surat undangan belum mencantumkan kop resmi penyelenggara. Mohon unggah ulang.',
                'anggota' => [],
                'nomor_surat' => null, 'tanggal_terbit' => null,
            ],
            [
                'id' => 'ST-2026-0028', 'tipe' => 'Individu',
                'dosen' => 'Dr. (Cand.) Rangga Pratama', 'prodi' => 'S1 Manajemen',
                'judul' => 'Narasumber Kuliah Umum Kewirausahaan Digital',
                'kategori' => 'Pengabdian Masyarakat', 'mitra' => 'Politeknik Negeri Bandung',
                'lokasi' => 'Luring — Bandung', 'mulai' => '2026-10-24', 'selesai' => '2026-10-24',
                'tanggal_masuk' => '2026-10-10', 'status' => 'Selesai (Terbit)',
                'anggota' => [],
                'nomor_surat' => 'FEB/SDM-ST/X/2026/045', 'tanggal_terbit' => '2026-10-25',
            ],
            [
                'id' => 'ST-2026-0021', 'tipe' => 'Kelompok',
                'dosen' => 'Dr. (Cand.) Rangga Pratama', 'prodi' => 'S1 Manajemen',
                'judul' => 'Tim Juri Business Plan Competition 2026',
                'kategori' => 'Penunjang', 'mitra' => 'HMM FEB Telkom University',
                'lokasi' => 'Luring — Kampus', 'mulai' => '2026-09-20', 'selesai' => '2026-09-21',
                'tanggal_masuk' => '2026-09-10', 'status' => 'Selesai (Terbit)',
                'anggota' => [
                    ['nama' => 'Dr. (Cand.) Rangga Pratama', 'peran' => 'Ketua', 'prodi' => 'S1 Manajemen'],
                    ['nama' => 'Yusuf Maulana, S.E., M.M.', 'peran' => 'Anggota', 'prodi' => 'S1 Manajemen'],
                ],
                'nomor_surat' => 'FEB/SDM-ST/IX/2026/031', 'tanggal_terbit' => '2026-09-15',
            ],
        ];
    }

    /** Lifecycle statuses for the ST state machine (for badges/legends). */
    public static function stStatuses(): array
    {
        return [
            'Menunggu Verifikasi Prodi' => 'amber',
            'Menunggu Approval Kaprodi' => 'amber',
            'Perlu Revisi Dosen' => 'rose',
            'Menunggu Drafting SDM' => 'blue',
            'Menunggu Validasi Atasan SDM' => 'blue',
            'Menunggu Penomoran Sekdek' => 'indigo',
            'Selesai (Terbit)' => 'green',
        ];
    }

    /* ---------------------------------------------------------------------
     | Modul 2 — Studi PID: Kelayakan
     |
     | Mengacu pada tabel syarat SK Rektor ttg Pengembangan Kompetensi:
     | 11 kriteria dengan 3 ambang skema (Full YPT / Sebagian YPT / Mandiri).
     * ------------------------------------------------------------------- */

    /**
     * Definisi baku 11 syarat + ambang per skema pembiayaan.
     * Dipakai sebagai header tabel evaluasi (kolom "Jenis Pembiayaan").
     */
    public static function kriteriaPidSyarat(): array
    {
        return [
            ['key' => 'usia',        'syarat' => 'Usia Maksimal',                 'full' => '45 Tahun',        'sebagian' => '48 Tahun',   'mandiri' => '50 Tahun'],
            ['key' => 'pegawai',     'syarat' => 'Status Pegawai',                'full' => 'Dosen Tetap',     'sebagian' => 'Perbantuan', 'mandiri' => 'Dosen Tetap / Perbantuan'],
            ['key' => 'jad',         'syarat' => 'JAD Minimal',                   'full' => 'AA',              'sebagian' => 'AA',         'mandiri' => 'NJAD'],
            ['key' => 'masa_kerja',  'syarat' => 'Masa Kerja Min. sejak Capeg',   'full' => '2 Tahun',         'sebagian' => '2 Tahun',    'mandiri' => '1 Tahun'],
            ['key' => 'fsdp',        'syarat' => 'Status FSDP',                   'full' => 'Lolos',           'sebagian' => 'Lolos',      'mandiri' => 'Lolos'],
            ['key' => 'rekomendasi', 'syarat' => 'Rekomendasi',                   'full' => 'Pimpinan Fakultas/Setingkat', 'sebagian' => 'Pimpinan Fakultas/Setingkat', 'mandiri' => 'Pimpinan Fakultas/Setingkat'],
            ['key' => 'hukuman',     'syarat' => 'Status Hukuman',                'full' => 'Tidak sedang dalam masa hukuman', 'sebagian' => 'Tidak sedang dalam masa hukuman', 'mandiri' => 'Tidak sedang dalam masa hukuman'],
            ['key' => 'pt_tujuan',   'syarat' => 'Status PT Tujuan',              'full' => 'Sesuai Daftar PT beasiswa RI', 'sebagian' => 'Sesuai Daftar PT beasiswa RI', 'mandiri' => 'Sesuai Daftar PT beasiswa RI'],
            ['key' => 'rank',        'syarat' => 'QS/THE Rank Subject/Prodi',     'full' => 'di atas Tel-U',   'sebagian' => 'di atas Tel-U', 'mandiri' => 'di atas Tel-U'],
            ['key' => 'pendidikan',  'syarat' => 'Pendidikan Terakhir',           'full' => 'Diakui Yayasan pada Jenjang S2', 'sebagian' => 'Diakui Yayasan pada Jenjang S2', 'mandiri' => 'Diakui Yayasan pada Jenjang S2'],
            ['key' => 'linearitas',  'syarat' => 'Linearitas',                    'full' => 'Linear',          'sebagian' => 'Linear',     'mandiri' => 'Linear'],
            ['key' => 'mentor',      'syarat' => 'Mentor',                        'full' => 'Internal Universitas Telkom', 'sebagian' => 'Internal Universitas Telkom', 'mandiri' => 'Internal Universitas Telkom'],
        ];
    }

    public static function kelayakanDosen(): array
    {
        return [
            [
                'nama' => 'Dr. (Cand.) Rangga Pratama', 'avatar' => 'RP', 'nip' => '21880042',
                'prodi' => 'S1 Manajemen', 'usia' => 44, 'jad' => 'Lektor',
                'masa_kerja' => '12 Tahun 7 Bulan', 'status' => 'Eligible Penuh YPT',
                // Kondisi eksisting per 11 kriteria (sesuai tabel syarat).
                'eksisting' => [
                    'usia'        => ['nilai' => '44 Tahun',                               'ok' => true],
                    'pegawai'     => ['nilai' => 'Pegawai Tetap',                          'ok' => true],
                    'jad'         => ['nilai' => 'Lektor',                                 'ok' => true],
                    'masa_kerja'  => ['nilai' => '12 Thn 7 Bulan',                         'ok' => true],
                    'fsdp'        => ['nilai' => 'FSDP 2026',                              'ok' => true],
                    'rekomendasi' => ['nilai' => 'Dekan Fakultas Ekonomi dan Bisnis',     'ok' => true],
                    'hukuman'     => ['nilai' => 'Tidak dalam hukuman',                   'ok' => true],
                    'pt_tujuan'   => ['nilai' => 'Tidak terdaftar',                        'ok' => false],
                    'rank'        => ['nilai' => '1001-1100',                              'ok' => true],
                    'pendidikan'  => ['nilai' => 'S2 Management',                          'ok' => true],
                    'linearitas'  => ['nilai' => 'Linear',                                 'ok' => true],
                    'mentor'      => ['nilai' => 'Anita Silvianita, S.E., M.S.M., Ph.D',   'ok' => true],
                ],
            ],
            [
                'nama' => 'Fitra Ramadhan, S.E., M.M.', 'avatar' => 'FR', 'nip' => '21950120',
                'prodi' => 'S1 Manajemen', 'usia' => 47, 'jad' => 'Asisten Ahli',
                'masa_kerja' => '3 Tahun', 'status' => 'Eligible Sebagian',
                'eksisting' => [
                    'usia'        => ['nilai' => '47 Tahun',                       'ok' => true],
                    'pegawai'     => ['nilai' => 'Dosen Perbantuan',               'ok' => true],
                    'jad'         => ['nilai' => 'Asisten Ahli',                   'ok' => true],
                    'masa_kerja'  => ['nilai' => '3 Tahun',                        'ok' => true],
                    'fsdp'        => ['nilai' => 'FSDP 2025',                      'ok' => true],
                    'rekomendasi' => ['nilai' => 'Wakil Dekan SDM',               'ok' => true],
                    'hukuman'     => ['nilai' => 'Tidak dalam hukuman',           'ok' => true],
                    'pt_tujuan'   => ['nilai' => 'Universitas Padjadjaran',       'ok' => true],
                    'rank'        => ['nilai' => '751-800',                        'ok' => true],
                    'pendidikan'  => ['nilai' => 'S2 Manajemen',                  'ok' => true],
                    'linearitas'  => ['nilai' => 'Linear',                        'ok' => true],
                    'mentor'      => ['nilai' => 'Prof. Dr. Ratri Wahyuningtyas', 'ok' => true],
                ],
            ],
            [
                'nama' => 'Nadia Ulfa, S.Ak., M.Ak.', 'avatar' => 'NU', 'nip' => '21960211',
                'prodi' => 'S1 Akuntansi', 'usia' => 51, 'jad' => 'Lektor',
                'masa_kerja' => '5 Tahun', 'status' => 'Belum Memenuhi Syarat',
                'eksisting' => [
                    'usia'        => ['nilai' => '51 Tahun',               'ok' => false],
                    'pegawai'     => ['nilai' => 'Pegawai Tetap',          'ok' => true],
                    'jad'         => ['nilai' => 'Lektor',                 'ok' => true],
                    'masa_kerja'  => ['nilai' => '5 Tahun',                'ok' => true],
                    'fsdp'        => ['nilai' => 'FSDP 2024',              'ok' => true],
                    'rekomendasi' => ['nilai' => 'Kaprodi S1 Akuntansi',  'ok' => true],
                    'hukuman'     => ['nilai' => 'Tidak dalam hukuman',   'ok' => true],
                    'pt_tujuan'   => ['nilai' => 'Universitas Gadjah Mada','ok' => true],
                    'rank'        => ['nilai' => '551-600',               'ok' => true],
                    'pendidikan'  => ['nilai' => 'S2 Akuntansi',          'ok' => true],
                    'linearitas'  => ['nilai' => 'Linear',                'ok' => true],
                    'mentor'      => ['nilai' => 'Dr. Dewi Fitriani',     'ok' => true],
                ],
            ],
            [
                'nama' => 'Yusuf Maulana, S.E., M.M.', 'avatar' => 'YM', 'nip' => '21970333',
                'prodi' => 'S1 Manajemen', 'usia' => 33, 'jad' => '—',
                'masa_kerja' => '1 Tahun', 'status' => 'Data Belum Lengkap',
                'eksisting' => [
                    'usia'        => ['nilai' => '33 Tahun',           'ok' => true],
                    'pegawai'     => ['nilai' => 'Capeg',              'ok' => false],
                    'jad'         => ['nilai' => 'Data kosong',        'ok' => false],
                    'masa_kerja'  => ['nilai' => '1 Tahun',            'ok' => false],
                    'fsdp'        => ['nilai' => 'Belum',              'ok' => false],
                    'rekomendasi' => ['nilai' => 'Belum ada',          'ok' => false],
                    'hukuman'     => ['nilai' => 'Tidak dalam hukuman','ok' => true],
                    'pt_tujuan'   => ['nilai' => 'Belum ditentukan',   'ok' => false],
                    'rank'        => ['nilai' => '—',                  'ok' => false],
                    'pendidikan'  => ['nilai' => 'S2 Manajemen',       'ok' => true],
                    'linearitas'  => ['nilai' => 'Data kosong',        'ok' => false],
                    'mentor'      => ['nilai' => 'Belum ada',          'ok' => false],
                ],
            ],
        ];
    }

    public static function kelayakanStats(): array
    {
        return [
            ['label' => 'Total Dosen S2 FEB', 'value' => 48, 'tone' => 'slate'],
            ['label' => 'Eligible Penuh YPT', 'value' => 19, 'tone' => 'green'],
            ['label' => 'Eligible Sebagian', 'value' => 12, 'tone' => 'teal'],
            ['label' => 'Belum Memenuhi / Data Kurang', 'value' => 17, 'tone' => 'amber'],
        ];
    }

    /* ---------------------------------------------------------------------
     | Modul 2 — Pengajuan PID
     * ------------------------------------------------------------------- */
    public static function pengajuanPid(): array
    {
        return [
            [
                'id' => 'PID-2026-007', 'dosen' => 'Dr. (Cand.) Rangga Pratama',
                'universitas' => 'Universitas Padjadjaran', 'prodi_tujuan' => 'S3 Ilmu Manajemen',
                'skema' => '2N+12', 'durasi' => '7 Semester', 'status' => 'Aktif Studi',
                'plafon' => 56000000, 'sk_beasiswa' => 'SK-BEA/FEB/2024/012',
                'amandemen' => [],
            ],
        ];
    }

    /* ---------------------------------------------------------------------
     | Modul 3 — LKS
     * ------------------------------------------------------------------- */
    public static function lks(): array
    {
        return [
            ['semester' => 'Semester 1 (Ganjil 2023/2024)', 'tanggal' => '2024-01-15', 'ipk' => 3.85, 'status' => 'LKS Approved'],
            ['semester' => 'Semester 2 (Genap 2023/2024)', 'tanggal' => '2024-07-20', 'ipk' => 3.90, 'status' => 'LKS Approved'],
            ['semester' => 'Semester 3 (Ganjil 2024/2025)', 'tanggal' => '2025-01-18', 'ipk' => 3.92, 'status' => 'Menunggu Approval Dekan'],
            ['semester' => 'Semester 4 (Genap 2024/2025)', 'tanggal' => '2025-07-22', 'ipk' => 3.88, 'status' => 'Menunggu Review SDM'],
        ];
    }

    public static function lksStatuses(): array
    {
        return [
            'Draft' => 'slate',
            'Menunggu Review SDM' => 'amber',
            'Perlu Revisi Dosen' => 'rose',
            'Menunggu Approval Dekan' => 'blue',
            'LKS Approved' => 'green',
        ];
    }

    /* ---------------------------------------------------------------------
     | Modul 4 — Reimburs & Pembiayaan
     * ------------------------------------------------------------------- */
    public static function reimburs(): array
    {
        return [
            ['id' => 1, 'tanggal' => '2025-02-10', 'kategori' => 'Biaya BPP Kuliah', 'semester' => 'Semester 3', 'nominal' => 8000000, 'status' => 'Selesai'],
            ['id' => 2, 'tanggal' => '2025-03-05', 'kategori' => 'Biaya Buku Referensi Disertasi', 'semester' => 'Semester 3', 'nominal' => 1500000, 'status' => 'Selesai'],
            ['id' => 3, 'tanggal' => '2025-04-12', 'kategori' => 'Publikasi Jurnal Scopus', 'semester' => 'Semester 3', 'nominal' => 1500000, 'status' => 'Diproses'],
            ['id' => 4, 'tanggal' => '2025-01-20', 'kategori' => 'Biaya Transportasi Akademik', 'semester' => 'Semester 2', 'nominal' => 1000000, 'status' => 'Ditolak'],
        ];
    }

    public static function pembiayaanProfil(): array
    {
        return [
            'nama' => 'Dr. (Cand.) Rangga Pratama', 'avatar' => 'RP', 'nip' => '21880042',
            'program' => 'S3 — Universitas Padjadjaran (Skema 2N+12)',
            'lama' => '7 Semester',
            'plafon' => 56000000, 'realisasi' => 24000000, 'sisa' => 32000000,
            'semester_direimburs' => 3, 'semester_total' => 7,
        ];
    }

    public static function pembiayaanSemester(): array
    {
        return [
            [
                'semester' => 'Semester 1', 'tahun' => 'Ganjil 2023/2024', 'total' => 9000000, 'status' => 'Selesai',
                'items' => [
                    ['komponen' => 'BPP Kuliah', 'nominal' => 8000000, 'tanggal' => '2024-01-20', 'ket' => 'LKS Sem 1', 'sumber' => 'LKS Approved', 'status' => 'Selesai'],
                    ['komponen' => 'Buku Referensi', 'nominal' => 1000000, 'tanggal' => '2024-02-02', 'ket' => 'Klaim mandiri', 'sumber' => 'Upload Dosen', 'status' => 'Selesai'],
                ],
            ],
            [
                'semester' => 'Semester 2', 'tahun' => 'Genap 2023/2024', 'total' => 8000000, 'status' => 'Selesai',
                'items' => [
                    ['komponen' => 'BPP Kuliah', 'nominal' => 8000000, 'tanggal' => '2024-07-25', 'ket' => 'LKS Sem 2', 'sumber' => 'LKS Approved', 'status' => 'Selesai'],
                ],
            ],
            [
                'semester' => 'Semester 3', 'tahun' => 'Ganjil 2024/2025', 'total' => 7000000, 'status' => 'Diproses',
                'items' => [
                    ['komponen' => 'BPP Kuliah', 'nominal' => 8000000, 'tanggal' => '2025-02-10', 'ket' => 'Klaim mandiri', 'sumber' => 'Upload Dosen', 'status' => 'Selesai'],
                    ['komponen' => 'Publikasi Scopus', 'nominal' => 1500000, 'tanggal' => '2025-04-12', 'ket' => 'Menunggu NDE', 'sumber' => 'Upload Dosen', 'status' => 'Diproses'],
                ],
            ],
            [
                'semester' => 'Semester 4', 'tahun' => 'Genap 2024/2025', 'total' => 0, 'status' => 'Belum Ada Data',
                'items' => [],
            ],
        ];
    }

    public static function evidenReimburs(): array
    {
        return [
            ['id' => 101, 'tanggal' => '2025-04-12', 'kategori' => 'Publikasi Scopus', 'semester' => 'Semester 3', 'nominal' => 1500000, 'file' => 'eviden-scopus-2025.pdf', 'catatan' => 'Invoice publikasi jurnal Q2', 'status' => 'Diproses'],
            ['id' => 102, 'tanggal' => '2025-02-10', 'kategori' => 'BPP Kuliah', 'semester' => 'Semester 3', 'nominal' => 8000000, 'file' => 'bukti-bpp-sem3.pdf', 'catatan' => 'Transfer m-banking BNI', 'status' => 'Selesai'],
        ];
    }

    /* ---------------------------------------------------------------------
     | Modul 5 — Penyetaraan S3
     * ------------------------------------------------------------------- */
    public static function penyetaraan(): array
    {
        return [
            [
                'id' => 'PS3-2026-003', 'dosen' => 'Dr. Ahmad Fauzi, S.E., M.M.', 'avatar' => 'AF',
                'nip' => '21840099', 'prodi' => 'S1 Manajemen', 'kk' => 'Manajemen Stratejik',
                'judul_disertasi' => 'Dynamic Capabilities & Firm Performance pada Industri Kreatif',
                'pt' => 'Universitas Indonesia', 'tanggal' => '2026-10-15',
                'status' => 'Penilaian Internal Asesor',
                'asesor' => [
                    ['peran' => 'Ketua KK', 'nama' => 'Dr. Lestari Handayani', 'done' => true],
                    ['peran' => 'Kaprodi', 'nama' => 'Dr. Bambang Wijaya', 'done' => true],
                    ['peran' => 'Dekan', 'nama' => 'Prof. Hendra Gunawan', 'done' => false],
                ],
                'catatan_admin' => null,
            ],
            [
                'id' => 'PS3-2026-002', 'dosen' => 'Dr. Siska Amelia, S.Ak., M.Ak.', 'avatar' => 'SA',
                'nip' => '21860055', 'prodi' => 'S1 Akuntansi', 'kk' => 'Akuntansi Keuangan',
                'judul_disertasi' => 'Pengaruh ESG Disclosure terhadap Cost of Capital',
                'pt' => 'Universitas Gadjah Mada', 'tanggal' => '2026-10-02',
                'status' => 'Perlu Revisi',
                'asesor' => [],
                'catatan_admin' => 'Scan ijazah tidak terbaca dengan jelas / blur, harap unggah ulang.',
            ],
            [
                'id' => 'PS3-2026-001', 'dosen' => 'Dr. Rina Kartika, S.E., M.M.', 'avatar' => 'RK',
                'nip' => '21810022', 'prodi' => 'S1 Manajemen', 'kk' => 'Manajemen Pemasaran',
                'judul_disertasi' => 'Customer Engagement dalam Ekosistem Marketplace',
                'pt' => 'Institut Teknologi Bandung', 'tanggal' => '2026-09-01',
                'status' => 'Selesai',
                'asesor' => [
                    ['peran' => 'Ketua KK', 'nama' => 'Dr. Lestari Handayani', 'done' => true],
                    ['peran' => 'Kaprodi', 'nama' => 'Dr. Bambang Wijaya', 'done' => true],
                    ['peran' => 'Dekan', 'nama' => 'Prof. Hendra Gunawan', 'done' => true],
                ],
                'catatan_admin' => null,
            ],
        ];
    }

    public static function penyetaraanStatuses(): array
    {
        return [
            'Validasi Admin SDM' => 'amber',
            'Perlu Revisi' => 'rose',
            'Penilaian Internal Asesor' => 'blue',
            'Menunggu SDM Pusat' => 'indigo',
            'Selesai' => 'green',
        ];
    }

    /* ---------------------------------------------------------------------
     | Notifications (shared, header bell)
     * ------------------------------------------------------------------- */
    public static function notifications(string $role): array
    {
        return match ($role) {
            Roles::DOSEN => [
                ['text' => 'ST-2026-0035 memerlukan revisi berkas', 'time' => '2 jam lalu', 'tone' => 'rose'],
                ['text' => 'Tenggat LKS Semester 5 dalam 7 hari', 'time' => '1 hari lalu', 'tone' => 'amber'],
                ['text' => 'Reimburs Publikasi Scopus sedang diproses', 'time' => '2 hari lalu', 'tone' => 'teal'],
            ],
            Roles::ADMIN_SDM => [
                ['text' => '5 LKS menunggu validasi dokumen', 'time' => '1 jam lalu', 'tone' => 'amber'],
                ['text' => '2 draf ST siap disusun', 'time' => '3 jam lalu', 'tone' => 'blue'],
            ],
            default => [
                ['text' => 'Selamat datang di SIGAP FEB', 'time' => 'baru saja', 'tone' => 'teal'],
            ],
        };
    }

    public static function rupiah(int $v): string
    {
        return 'Rp ' . number_format($v, 0, ',', '.');
    }

    /* ---------------------------------------------------------------------
     | Evidence / dokumen terunggah (dipakai lintas-role untuk preview)
     |
     | Setiap berkas: nama, ukuran, tanggal unggah, pengunggah.
     | Dipakai komponen resources/views/partials/evidence.blade.php agar
     | role berikutnya (Staf Prodi, Kaprodi, Admin SDM, Asesor) bisa melihat
     | berkas yang diunggah role sebelumnya.
     * ------------------------------------------------------------------- */

    /** Evidence Surat Tugas per nomor tiket. */
    public static function evidenceSuratTugas(string $id): array
    {
        $common = [
            ['nama' => 'Surat_Undangan_Resmi.pdf', 'ukuran' => '1.2 MB', 'tanggal' => '2026-10-20', 'oleh' => 'Dr. (Cand.) Rangga Pratama'],
            ['nama' => 'TOR_Kerangka_Acuan.pdf',    'ukuran' => '860 KB', 'tanggal' => '2026-10-20', 'oleh' => 'Dr. (Cand.) Rangga Pratama'],
        ];
        // Variasi kecil agar tiap tiket terasa berbeda.
        return match ($id) {
            'ST-2026-0041' => array_merge($common, [
                ['nama' => 'Proposal_Hibah_Internal.pdf', 'ukuran' => '2.4 MB', 'tanggal' => '2026-10-18', 'oleh' => 'Dr. (Cand.) Rangga Pratama'],
            ]),
            default => $common,
        };
    }

    /** 4 berkas gabungan LKS (satu PDF berisi 4 bagian). */
    public static function evidenceLks(): array
    {
        return [
            ['nama' => 'LKS_Gabungan.pdf', 'ukuran' => '8.6 MB', 'tanggal' => '2025-01-18', 'oleh' => 'Dr. (Cand.) Rangga Pratama',
             'bagian' => ['Dokumen LKS (TTD Promotor)', 'Transkrip / KHS', 'Surat Keterangan Aktif', 'Bukti Transfer BPP']],
        ];
    }

    /** Berkas gabungan penyetaraan S3. */
    public static function evidencePenyetaraan(): array
    {
        return [
            ['nama' => 'Berkas_Penyetaraan_S3_Gabungan.pdf', 'ukuran' => '9.1 MB', 'tanggal' => '2026-10-15', 'oleh' => 'Dosen Pengusul',
             'bagian' => ['Ijazah & Transkrip S3', 'Ringkasan Disertasi', 'Roadmap Penelitian', 'Lembar Pengesahan', 'Pernyataan Linearitas']],
        ];
    }
}
