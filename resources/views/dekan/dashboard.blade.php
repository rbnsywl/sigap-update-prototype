@extends('layouts.app')
@section('title', 'Executive Dashboard')
@section('breadcrumb', 'Utama / Executive Dashboard')

@section('content')
    @include('partials.page-head', ['heading' => 'Executive Dashboard', 'sub' => 'Indikator kinerja utama fakultas terkait studi lanjut & tridharma dosen.'])
    <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-6">
        @include('partials.stat-card', ['label' => 'ST Perlu TTD', 'value' => 2, 'tone' => 'amber', 'icon' => 'pen'])
        @include('partials.stat-card', ['label' => 'LKS Perlu Approval', 'value' => 3, 'tone' => 'blue', 'icon' => 'clipboard'])
        @include('partials.stat-card', ['label' => 'Penyetaraan S3', 'value' => 1, 'tone' => 'teal', 'icon' => 'cap'])
        @include('partials.stat-card', ['label' => 'Dosen S3 Aktif', 'value' => 9, 'tone' => 'green', 'icon' => 'users'])
    </div>
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        <div class="bg-white rounded-lg border border-slate-200 p-6">
            <h3 class="font-semibold text-slate-800 mb-4">Serapan Beasiswa PID Fakultas</h3>
            <div class="space-y-4">
                @foreach([['Dr. Rangga Pratama','43%'],['Dr. Siska Amelia','71%'],['Dr. Rina Kartika','29%']] as [$n,$p])
                    <div>
                        <div class="flex items-center justify-between text-sm mb-1"><span class="text-slate-600">{{ $n }}</span><span class="font-semibold text-slate-800 tnum">{{ $p }}</span></div>
                        <div class="h-2 rounded-full bg-slate-100 overflow-hidden"><div class="h-full bg-teal-500" style="width: {{ $p }}"></div></div>
                    </div>
                @endforeach
            </div>
        </div>
        <div class="bg-white rounded-lg border border-slate-200 p-6">
            <h3 class="font-semibold text-slate-800 mb-4">Tindakan Cepat</h3>
            <div class="grid grid-cols-1 gap-3">
                <a href="/dekan/ttd-st" class="flex items-center gap-3 p-4 rounded-lg border border-slate-200 hover:border-teal-400 hover:bg-teal-50/40 transition">@include('partials.icon', ['name' => 'pen', 'class' => 'w-5 h-5 text-teal-600']) <span class="text-sm font-medium text-slate-700">Tanda Tangan Surat Tugas</span></a>
                <a href="/dekan/approval-lks" class="flex items-center gap-3 p-4 rounded-lg border border-slate-200 hover:border-teal-400 hover:bg-teal-50/40 transition">@include('partials.icon', ['name' => 'clipboard', 'class' => 'w-5 h-5 text-teal-600']) <span class="text-sm font-medium text-slate-700">Approval LKS Semesteran</span></a>
                <a href="/dekan/approval-penyetaraan" class="flex items-center gap-3 p-4 rounded-lg border border-slate-200 hover:border-teal-400 hover:bg-teal-50/40 transition">@include('partials.icon', ['name' => 'cap', 'class' => 'w-5 h-5 text-teal-600']) <span class="text-sm font-medium text-slate-700">Penetapan Penyetaraan S3</span></a>
            </div>
        </div>
    </div>
@endsection
