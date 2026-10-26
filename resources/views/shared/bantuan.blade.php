@extends('layouts.app')
@section('title', 'Pusat Bantuan')
@section('breadcrumb', 'Sistem / Bantuan')

@section('content')
    @include('partials.page-head', ['heading' => 'Pusat Bantuan', 'sub' => 'Panduan SOP dan unduhan format resmi FEB.'])
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
        @foreach([
            ['SOP Pengajuan Surat Tugas','Alur lengkap pengajuan ST individu & kelompok.'],
            ['SOP Studi Lanjut PID','Kriteria kelayakan & skema pembiayaan beasiswa.'],
            ['Panduan Pelaporan LKS','Format dokumen & jadwal pelaporan semesteran.'],
            ['Panduan Reimburs','Kategori biaya & alur NDE.'],
            ['SOP Penyetaraan S3','Alur penilaian asesor & berita acara.'],
            ['Template Resmi FEB','Unduh semua template dokumen.'],
        ] as [$t,$d])
            <div class="bg-white rounded-lg border border-slate-200 p-5 hover:border-teal-400 transition">
                <div class="w-10 h-10 rounded-lg bg-teal-50 text-teal-600 grid place-items-center mb-3">@include('partials.icon', ['name' => 'help', 'class' => 'w-5 h-5'])</div>
                <div class="font-semibold text-slate-800 text-sm">{{ $t }}</div>
                <p class="text-xs text-slate-500 mt-1">{{ $d }}</p>
                <button class="mt-3 text-sm text-teal-600 font-semibold hover:underline">Buka panduan →</button>
            </div>
        @endforeach
    </div>
@endsection
