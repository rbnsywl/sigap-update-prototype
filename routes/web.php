<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\PageController;
use Illuminate\Support\Facades\Route;

/* ---------------- Auth (mock) ---------------- */
Route::get('/', fn () => redirect('/login'));
Route::get('/login', [AuthController::class, 'showLogin']);
Route::post('/login', [AuthController::class, 'login']);
Route::get('/switch-role', [AuthController::class, 'switchRole']);
Route::post('/logout', [AuthController::class, 'logout']);

/* ---------------- Authenticated (mock) ---------------- */
Route::middleware('mock.auth')->group(function () {

    // Shared
    Route::get('/bantuan', [PageController::class, 'bantuan']);
    Route::get('/pengaturan', [PageController::class, 'pengaturan']);
    Route::get('/profil', [PageController::class, 'profil']);

    // ---- Dosen ----
    Route::get('/dashboard', [PageController::class, 'dosenDashboard']);
    Route::get('/surat-tugas/ajukan', [PageController::class, 'stAjukan']);
    Route::get('/surat-tugas/riwayat', [PageController::class, 'stRiwayat']);
    Route::get('/studi-pid/cek-kelayakan', [PageController::class, 'cekKelayakan']);
    Route::get('/studi-pid/pengajuan', [PageController::class, 'pidPengajuan']);
    Route::get('/studi-pid/lks', [PageController::class, 'lks']);
    Route::get('/studi-pid/reimburs', [PageController::class, 'reimburs']);
    Route::get('/studi-pid/kelulusan', [PageController::class, 'kelulusanPid']);
    Route::get('/studi-non-pid/penyetaraan', [PageController::class, 'penyetaraanDosen']);

    // ---- Staf Prodi ----
    Route::get('/prodi/dashboard', [PageController::class, 'prodiDashboard']);
    Route::get('/prodi/verifikasi-st', [PageController::class, 'prodiVerifikasiSt']);
    Route::get('/prodi/verifikasi-kelompok', [PageController::class, 'prodiVerifikasiKelompok']);
    Route::get('/prodi/arsip', [PageController::class, 'prodiArsip']);

    // ---- Kaprodi ----
    Route::get('/kaprodi/dashboard', [PageController::class, 'kaprodiDashboard']);
    Route::get('/kaprodi/approval-st', [PageController::class, 'kaprodiApprovalSt']);
    Route::get('/kaprodi/penyetaraan-s3', [PageController::class, 'kaprodiPenyetaraan']);
    Route::get('/kaprodi/monitoring-kinerja', [PageController::class, 'kaprodiMonitoring']);

    // ---- Admin SDM ----
    Route::get('/admin-sdm/dashboard', [PageController::class, 'sdmDashboard']);
    Route::get('/admin-sdm/surat-tugas/draft', [PageController::class, 'sdmStDraft']);
    Route::get('/admin-sdm/surat-tugas/request-nomor', [PageController::class, 'sdmStRequestNomor']);
    Route::get('/admin-sdm/surat-tugas/penerbitan', [PageController::class, 'sdmStPenerbitan']);
    Route::get('/admin-sdm/pid/kelayakan', [PageController::class, 'sdmKelayakan']);
    Route::get('/admin-sdm/pid/kelayakan/{nip}', [PageController::class, 'sdmKelayakanDetail']);
    Route::get('/admin-sdm/pid/pengajuan', [PageController::class, 'sdmPidPengajuan']);
    Route::get('/admin-sdm/pid/validasi-lks', [PageController::class, 'sdmValidasiLks']);
    Route::get('/admin-sdm/pid/pembiayaan', [PageController::class, 'sdmPembiayaan']);
    Route::get('/admin-sdm/pid/kelulusan', [PageController::class, 'sdmKelulusan']);
    Route::get('/admin-sdm/penyetaraan', [PageController::class, 'sdmPenyetaraan']);
    Route::get('/admin-sdm/data-dosen', [PageController::class, 'sdmDataDosen']);
    Route::get('/admin-sdm/laporan', [PageController::class, 'sdmLaporan']);
    Route::get('/admin-sdm/pengaturan', [PageController::class, 'sdmPengaturan']);

    // ---- Atasan SDM ----
    Route::get('/atasan-sdm/dashboard', [PageController::class, 'atasanDashboard']);
    Route::get('/atasan-sdm/validasi-st', [PageController::class, 'atasanValidasiSt']);
    Route::get('/atasan-sdm/validasi-reimburs', [PageController::class, 'atasanValidasiReimburs']);
    Route::get('/atasan-sdm/monitoring-studi', [PageController::class, 'atasanMonitoring']);

    // ---- Sekdek ----
    Route::get('/sekdek/dashboard', [PageController::class, 'sekdekDashboard']);
    Route::get('/sekdek/penomoran-st', [PageController::class, 'sekdekPenomoran']);
    Route::get('/sekdek/buku-agenda', [PageController::class, 'sekdekBukuAgenda']);
    Route::get('/sekdek/pengaturan', [PageController::class, 'sekdekPengaturan']);

    // ---- Dekan ----
    Route::get('/dekan/dashboard', [PageController::class, 'dekanDashboard']);
    Route::get('/dekan/ttd-st', [PageController::class, 'dekanTtdSt']);
    Route::get('/dekan/approval-lks', [PageController::class, 'dekanApprovalLks']);
    Route::get('/dekan/approval-penyetaraan', [PageController::class, 'dekanApprovalPenyetaraan']);
    Route::get('/dekan/laporan-eksekutif', [PageController::class, 'dekanLaporan']);

    // ---- Ketua KK ----
    Route::get('/kk/dashboard', [PageController::class, 'kkDashboard']);
    Route::get('/kk/penilaian-s3', [PageController::class, 'kkPenilaian']);
    Route::get('/kk/riwayat-penilaian', [PageController::class, 'kkRiwayat']);
});
