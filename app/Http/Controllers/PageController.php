<?php

namespace App\Http\Controllers;

use App\Support\MockData;

/**
 * Thin controller that feeds mock data into Blade views for the prototype.
 * Each method maps 1:1 to a screen in the PRD. For real integration, replace
 * MockData::* calls with Eloquent queries and add FormRequest validation.
 */
class PageController extends Controller
{
    /* ===================== DOSEN ===================== */
    public function dosenDashboard()      { return view('dosen.dashboard', ['st' => MockData::suratTugas(), 'lks' => MockData::lks()]); }
    public function profil()              { return view('dosen.profil'); }
    public function stAjukan()            { return view('dosen.st-ajukan'); }
    public function stRiwayat()           { return view('dosen.st-riwayat', ['st' => MockData::suratTugas(), 'statuses' => MockData::stStatuses()]); }
    public function cekKelayakan()        { return view('dosen.pid-cek-kelayakan', ['data' => MockData::kelayakanDosen()[0]]); }
    public function pidPengajuan()        { return view('dosen.pid-pengajuan', ['pid' => MockData::pengajuanPid()[0]]); }
    public function lks()                 { return view('dosen.lks', ['lks' => MockData::lks(), 'statuses' => MockData::lksStatuses()]); }
    public function reimburs()            { return view('dosen.reimburs', ['rows' => MockData::reimburs()]); }
    public function kelulusanPid()        { return view('dosen.kelulusan-pid'); }
    public function penyetaraanDosen()    { return view('dosen.penyetaraan', ['rows' => MockData::penyetaraan(), 'statuses' => MockData::penyetaraanStatuses()]); }
    public function bantuan()             { return view('shared.bantuan'); }

    /* ===================== STAF PRODI ===================== */
    public function prodiDashboard()      { return view('prodi.dashboard', ['st' => MockData::suratTugas()]); }
    public function prodiVerifikasiSt()   { return view('prodi.verifikasi-st', ['st' => MockData::suratTugas(), 'statuses' => MockData::stStatuses()]); }
    public function prodiVerifikasiKelompok() { return view('prodi.verifikasi-kelompok', ['st' => MockData::suratTugas()]); }
    public function prodiArsip()          { return view('prodi.arsip', ['st' => MockData::suratTugas(), 'statuses' => MockData::stStatuses()]); }

    /* ===================== KAPRODI ===================== */
    public function kaprodiDashboard()    { return view('kaprodi.dashboard', ['st' => MockData::suratTugas()]); }
    public function kaprodiApprovalSt()   { return view('kaprodi.approval-st', ['st' => MockData::suratTugas(), 'statuses' => MockData::stStatuses()]); }
    public function kaprodiPenyetaraan()  { return view('kaprodi.penyetaraan-s3', ['rows' => MockData::penyetaraan(), 'statuses' => MockData::penyetaraanStatuses()]); }
    public function kaprodiMonitoring()   { return view('kaprodi.monitoring-kinerja'); }

    /* ===================== ADMIN SDM ===================== */
    public function sdmDashboard()        { return view('admin_sdm.dashboard', ['st' => MockData::suratTugas(), 'kstats' => MockData::kelayakanStats()]); }
    public function sdmStDraft()          { return view('admin_sdm.st-draft', ['st' => MockData::suratTugas(), 'statuses' => MockData::stStatuses()]); }
    public function sdmStRequestNomor()   { return view('admin_sdm.st-request-nomor', ['st' => MockData::suratTugas()]); }
    public function sdmStPenerbitan()     { return view('admin_sdm.st-penerbitan', ['st' => MockData::suratTugas()]); }
    public function sdmKelayakan()        { return view('admin_sdm.pid-kelayakan', ['stats' => MockData::kelayakanStats(), 'rows' => MockData::kelayakanDosen(), 'statuses' => [
        'Eligible Penuh YPT'=>'green','Eligible Sebagian'=>'teal','Belum Memenuhi Syarat'=>'rose','Data Belum Lengkap'=>'amber']]); }
    public function sdmKelayakanDetail($nip = null) {
        $dosen = MockData::kelayakanByNip($nip);
        return view('admin_sdm.pid-kelayakan-detail', [
            'dosen' => $dosen,
            'konteks' => MockData::kelayakanKonteks($dosen['status']),
        ]);
    }
    public function sdmPidPengajuan()     { return view('admin_sdm.pid-pengajuan', ['pid' => MockData::pengajuanPid(), 'statuses' => MockData::pengajuanPidStatuses()]); }
    public function sdmMonitoringPid()    { return view('admin_sdm.monitoring-pid', ['rows' => MockData::monitoringPid(), 'statuses' => MockData::kepatuhanStatuses()]); }
    public function sdmMonitoringPidDetail($nip = null) {
        $dosen = MockData::monitoringPidByNip($nip);
        return view('admin_sdm.monitoring-pid-detail', [
            'dosen' => $dosen,
            'studi' => MockData::studiDetail((string) $dosen['nip']),
            'lksStatuses' => MockData::lksStatuses(),
        ]);
    }
    public function sdmValidasiLks()      { return view('admin_sdm.validasi-lks', ['lks' => MockData::lks(), 'statuses' => MockData::lksStatuses()]); }
    public function sdmPembiayaan()       { return view('admin_sdm.pembiayaan', [
        'profil' => MockData::pembiayaanProfil(),
        'semesters' => MockData::pembiayaanSemester(),
        'eviden' => MockData::evidenReimburs(),
    ]); }
    public function sdmKelulusan()        { return view('admin_sdm.kelulusan-pid', ['pid' => MockData::pengajuanPid()]); }
    public function sdmPenyetaraan()      { return view('admin_sdm.penyetaraan', ['rows' => MockData::penyetaraan(), 'statuses' => MockData::penyetaraanStatuses()]); }
    public function sdmDataDosen()        { return view('admin_sdm.data-dosen', ['rows' => MockData::kelayakanDosen()]); }
    public function sdmLaporan()          { return view('admin_sdm.laporan'); }
    public function sdmPengaturan()       { return view('shared.pengaturan'); }

    /* ===================== ATASAN SDM ===================== */
    public function atasanDashboard()     { return view('atasan_sdm.dashboard', ['st' => MockData::suratTugas()]); }
    public function atasanValidasiSt()    { return view('atasan_sdm.validasi-st', ['st' => MockData::suratTugas(), 'statuses' => MockData::stStatuses()]); }
    public function atasanValidasiReimburs() { return view('atasan_sdm.validasi-reimburs', ['rows' => MockData::reimburs()]); }
    public function atasanMonitoring()    { return view('atasan_sdm.monitoring-studi', ['pid' => MockData::pengajuanPid()]); }

    /* ===================== SEKDEK ===================== */
    public function sekdekDashboard()     { return view('sekdek.dashboard', ['st' => MockData::suratTugas()]); }
    public function sekdekPenomoran()     { return view('sekdek.penomoran-st', ['st' => MockData::suratTugas()]); }
    public function sekdekBukuAgenda()    { return view('sekdek.buku-agenda', ['st' => MockData::suratTugas()]); }
    public function sekdekPengaturan()    { return view('shared.pengaturan'); }

    /* ===================== DEKAN ===================== */
    public function dekanDashboard()      { return view('dekan.dashboard', ['st' => MockData::suratTugas(), 'lks' => MockData::lks()]); }
    public function dekanTtdSt()          { return view('dekan.ttd-st', ['st' => MockData::suratTugas()]); }
    public function dekanApprovalLks()    { return view('dekan.approval-lks', ['lks' => MockData::lks(), 'statuses' => MockData::lksStatuses()]); }
    public function dekanApprovalPenyetaraan() { return view('dekan.approval-penyetaraan', ['rows' => MockData::penyetaraan(), 'statuses' => MockData::penyetaraanStatuses()]); }
    public function dekanLaporan()        { return view('admin_sdm.laporan'); }

    /* ===================== KETUA KK ===================== */
    public function kkDashboard()         { return view('kk.dashboard', ['rows' => MockData::penyetaraan()]); }
    public function kkPenilaian()         { return view('kk.penilaian-s3', ['rows' => MockData::penyetaraan(), 'statuses' => MockData::penyetaraanStatuses()]); }
    public function kkRiwayat()           { return view('kk.riwayat-penilaian', ['rows' => MockData::penyetaraan(), 'statuses' => MockData::penyetaraanStatuses()]); }

    /* ===================== SHARED ===================== */
    public function pengaturan()          { return view('shared.pengaturan'); }
}
