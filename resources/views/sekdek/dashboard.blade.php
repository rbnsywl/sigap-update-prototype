@extends('layouts.app')
@section('title', 'Dashboard Sekdek')
@section('breadcrumb', 'Utama / Dashboard Sekdek')

@section('content')
    @include('partials.page-head', ['heading' => 'Dashboard Sekretariat Dekanat', 'sub' => 'Antrean surat siap nomor & statistik penomoran bulan berjalan.'])
    <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-6">
        @include('partials.stat-card', ['label' => 'Siap Dinomori', 'value' => 2, 'tone' => 'amber', 'icon' => 'hash'])
        @include('partials.stat-card', ['label' => 'Dinomori Bulan Ini', 'value' => 23, 'tone' => 'green', 'icon' => 'book'])
        @include('partials.stat-card', ['label' => 'Total ST 2026', 'value' => 128, 'tone' => 'teal', 'icon' => 'folder'])
        @include('partials.stat-card', ['label' => 'Rata-rata/Hari', 'value' => '4.2', 'tone' => 'blue', 'icon' => 'chart'])
    </div>
    <div class="bg-white rounded-lg border border-slate-200 overflow-hidden">
        <div class="px-6 py-4 border-b border-slate-100 flex items-center justify-between">
            <h3 class="font-semibold text-slate-800">Surat Siap Dinomori</h3>
            <a href="/sekdek/penomoran-st" class="text-sm text-teal-600 font-semibold hover:underline">Buka penomoran</a>
        </div>
        @include('prodi.partials.queue-table', ['st' => array_slice($st,0,3)])
    </div>
@endsection
