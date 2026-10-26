@extends('layouts.app')
@section('title', 'Dashboard Manajerial')
@section('breadcrumb', 'Utama / Dashboard Manajerial')

@section('content')
    @include('partials.page-head', ['heading' => 'Dashboard Manajerial SDM', 'sub' => 'Metrik kepatuhan SDM & serapan anggaran studi lanjut.'])
    <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-6">
        @include('partials.stat-card', ['label' => 'ST Menunggu Validasi', 'value' => 2, 'tone' => 'amber', 'icon' => 'shield'])
        @include('partials.stat-card', ['label' => 'Usulan Reimburs', 'value' => 3, 'tone' => 'blue', 'icon' => 'wallet'])
        @include('partials.stat-card', ['label' => 'Kepatuhan Regulasi', 'value' => '98%', 'tone' => 'green', 'icon' => 'check'])
        @include('partials.stat-card', ['label' => 'Dosen PID Dipantau', 'value' => 9, 'tone' => 'teal', 'icon' => 'cap'])
    </div>
    <div class="bg-white rounded-lg border border-slate-200 overflow-hidden">
        <div class="px-6 py-4 border-b border-slate-100 flex items-center justify-between">
            <h3 class="font-semibold text-slate-800">Perlu Validasi Anda</h3>
            <a href="/atasan-sdm/validasi-st" class="text-sm text-teal-600 font-semibold hover:underline">Lihat semua</a>
        </div>
        @include('prodi.partials.queue-table', ['st' => array_slice($st,0,3), 'actionLabel' => 'Validasi', 'actionHref' => '/atasan-sdm/validasi-st'])
    </div>
@endsection
