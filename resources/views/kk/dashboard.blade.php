@extends('layouts.app')
@section('title', 'Dashboard KK')
@section('breadcrumb', 'Utama / Dashboard KK')

@section('content')
    @include('partials.page-head', ['heading' => 'Dashboard Kelompok Keahlian', 'sub' => 'Status anggota KK & usulan riset terkait penyetaraan S3.'])
    <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-6">
        @include('partials.stat-card', ['label' => 'Menunggu Penilaian', 'value' => 1, 'tone' => 'amber', 'icon' => 'cap'])
        @include('partials.stat-card', ['label' => 'Sudah Dinilai', 'value' => 5, 'tone' => 'green', 'icon' => 'check'])
        @include('partials.stat-card', ['label' => 'Anggota KK', 'value' => 8, 'tone' => 'teal', 'icon' => 'users'])
        @include('partials.stat-card', ['label' => 'Dosen S3 KK', 'value' => 2, 'tone' => 'blue', 'icon' => 'scroll'])
    </div>
    <div class="bg-white rounded-lg border border-slate-200 overflow-hidden">
        <div class="px-6 py-4 border-b border-slate-100 flex items-center justify-between">
            <h3 class="font-semibold text-slate-800">Berkas Menunggu Penilaian</h3>
            <a href="/kk/penilaian-s3" class="text-sm text-teal-600 font-semibold hover:underline">Buka penilaian</a>
        </div>
        <div class="divide-y divide-slate-50">
            @foreach(collect($rows)->where('status','Penilaian Internal Asesor') as $r)
                <div class="px-6 py-4 flex items-center gap-4">
                    <div class="w-10 h-10 rounded-full bg-teal-600 text-white grid place-items-center text-sm font-semibold">{{ $r['avatar'] }}</div>
                    <div class="flex-1 min-w-0"><div class="text-sm font-medium text-slate-800">{{ $r['dosen'] }}</div><div class="text-xs text-slate-400 truncate">{{ $r['judul_disertasi'] }}</div></div>
                    @include('partials.badge', ['label' => 'Perlu Dinilai', 'tone' => 'amber'])
                </div>
            @endforeach
        </div>
    </div>
@endsection
