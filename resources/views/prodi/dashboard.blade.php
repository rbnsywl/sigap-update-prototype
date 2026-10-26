@extends('layouts.app')
@section('title', 'Dashboard Prodi')
@section('breadcrumb', 'Utama / Dashboard Prodi')

@section('content')
    @include('partials.page-head', ['heading' => 'Dashboard Program Studi', 'sub' => 'Ringkasan usulan Surat Tugas masuk dari dosen prodi.'])
    <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-6">
        @include('partials.stat-card', ['label' => 'Usulan Masuk', 'value' => 4, 'tone' => 'amber', 'icon' => 'inbox'])
        @include('partials.stat-card', ['label' => 'Perlu Revisi', 'value' => 1, 'tone' => 'rose', 'icon' => 'edit'])
        @include('partials.stat-card', ['label' => 'Diteruskan ke Kaprodi', 'value' => 6, 'tone' => 'green', 'icon' => 'check'])
        @include('partials.stat-card', ['label' => 'Total Bulan Ini', 'value' => 11, 'tone' => 'teal', 'icon' => 'folder'])
    </div>
    <div class="bg-white rounded-lg border border-slate-200 overflow-hidden">
        <div class="px-6 py-4 border-b border-slate-100"><h3 class="font-semibold text-slate-800">Antrean Terbaru</h3></div>
        @include('prodi.partials.queue-table', ['st' => array_slice($st,0,4)])
    </div>
@endsection
