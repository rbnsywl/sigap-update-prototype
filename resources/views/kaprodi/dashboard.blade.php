@extends('layouts.app')
@section('title', 'Dashboard Kaprodi')
@section('breadcrumb', 'Utama / Dashboard Kaprodi')

@section('content')
    @include('partials.page-head', ['heading' => 'Dashboard Ketua Program Studi', 'sub' => 'Ringkasan kegiatan tridharma dosen prodi semester berjalan.'])
    <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-6">
        @include('partials.stat-card', ['label' => 'Menunggu Approval', 'value' => 3, 'tone' => 'amber', 'icon' => 'check'])
        @include('partials.stat-card', ['label' => 'Disetujui Bulan Ini', 'value' => 14, 'tone' => 'green', 'icon' => 'folder'])
        @include('partials.stat-card', ['label' => 'Review Penyetaraan S3', 'value' => 1, 'tone' => 'blue', 'icon' => 'cap'])
        @include('partials.stat-card', ['label' => 'Dosen Aktif Prodi', 'value' => 28, 'tone' => 'teal', 'icon' => 'users'])
    </div>
    <div class="bg-white rounded-lg border border-slate-200 overflow-hidden">
        <div class="px-6 py-4 border-b border-slate-100 flex items-center justify-between">
            <h3 class="font-semibold text-slate-800">Perlu Persetujuan Anda</h3>
            <a href="/kaprodi/approval-st" class="text-sm text-teal-600 font-semibold hover:underline">Lihat semua</a>
        </div>
        @include('prodi.partials.queue-table', ['st' => array_slice($st,0,3), 'actionLabel' => 'Approve', 'actionHref' => '/kaprodi/approval-st'])
    </div>
@endsection
