@extends('layouts.app')
@section('title', 'Laporan & Rekap Eksekutif')
@section('breadcrumb', 'Data & Master / Laporan')

@section('content')
    @include('partials.page-head', ['heading' => 'Laporan & Rekap Eksekutif', 'sub' => 'Ekspor data transaksi & cetak laporan pembiayaan fakultas.'])
    <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-6">
        @include('partials.stat-card', ['label' => 'Total ST Terbit (2026)', 'value' => 128, 'tone' => 'teal', 'icon' => 'folder'])
        @include('partials.stat-card', ['label' => 'Dosen PID Aktif', 'value' => 9, 'tone' => 'green', 'icon' => 'cap'])
        @include('partials.stat-card', ['label' => 'Serapan Beasiswa', 'value' => 'Rp 214jt', 'tone' => 'blue', 'icon' => 'wallet'])
        @include('partials.stat-card', ['label' => 'Penyetaraan S3', 'value' => 3, 'tone' => 'amber', 'icon' => 'scroll'])
    </div>
    <div class="bg-white rounded-lg border border-slate-200 p-6">
        <h3 class="font-semibold text-slate-800 mb-4">Ekspor Data</h3>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-3">
            @foreach(['Rekap Surat Tugas (CSV)','Rekap Pembiayaan PID (Excel)','Laporan Penyetaraan S3 (PDF)'] as $x)
                <button class="flex items-center gap-3 p-4 rounded-lg border border-slate-200 hover:border-teal-400 hover:bg-teal-50/40 transition text-left">
                    <span class="w-9 h-9 rounded-lg bg-teal-50 text-teal-600 grid place-items-center shrink-0">@include('partials.icon', ['name' => 'download', 'class' => 'w-4 h-4'])</span>
                    <span class="text-sm font-medium text-slate-700">{{ $x }}</span>
                </button>
            @endforeach
        </div>
    </div>
@endsection
