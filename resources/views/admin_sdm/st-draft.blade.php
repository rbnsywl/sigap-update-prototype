@extends('layouts.app')
@section('title', 'Pembuatan Draf ST')
@section('breadcrumb', 'Surat Tugas / Draf')

@section('content')
<div x-data="{ sel:2 }">
    @include('partials.page-head', ['heading' => 'Pembuatan Draf Surat Tugas', 'sub' => 'Generator otomatis menyusun surat berkop resmi FEB Telkom University.'])
    @php $drafts = collect($st)->where('status','Menunggu Drafting SDM')->values(); if($drafts->isEmpty()) $drafts = collect($st)->take(2)->values(); @endphp
    <div class="grid grid-cols-1 lg:grid-cols-5 gap-6">
        <div class="lg:col-span-2 bg-white rounded-lg border border-slate-200 overflow-hidden self-start">
            <div class="px-5 py-3.5 border-b border-slate-100 font-semibold text-slate-800 text-sm">Usulan Disetujui Kaprodi</div>
            <div class="divide-y divide-slate-50">
                @foreach($st as $i => $row)
                    <button @click="sel={{ $i }}" class="w-full text-left px-5 py-3.5 transition" :class="sel==={{ $i }}?'bg-teal-50':'hover:bg-slate-50'">
                        <div class="text-sm font-medium text-slate-800 truncate">{{ $row['judul'] }}</div>
                        <div class="text-xs text-slate-400 mt-0.5">{{ $row['id'] }} · {{ $row['dosen'] }}</div>
                    </button>
                @endforeach
            </div>
        </div>
        <div class="lg:col-span-3">
            @foreach($st as $i => $row)
                <div x-show="sel==={{ $i }}" x-cloak class="bg-white rounded-lg border border-slate-200">
                    <div class="px-6 py-4 border-b border-slate-100 flex items-center justify-between">
                        <h3 class="font-semibold text-slate-800">Preview Draf Surat</h3>
                        <span class="text-xs text-slate-400">Auto-generated · Kop FEB Telkom University</span>
                    </div>
                    {{-- Letter preview --}}
                    <div class="p-6">
                        <div class="border border-slate-200 rounded-lg p-8 bg-white text-sm leading-relaxed">
                            <div class="text-center border-b-2 border-slate-800 pb-3 mb-5">
                                <div class="font-bold text-base">FAKULTAS EKONOMI DAN BISNIS</div>
                                <div class="font-semibold">TELKOM UNIVERSITY</div>
                            </div>
                            <div class="text-center font-bold underline mb-1">SURAT TUGAS</div>
                            <div class="text-center text-slate-500 mb-5 tnum">Nomor: {{ $row['nomor_surat'] ?? '…………/…………/2026' }}</div>
                            <p class="mb-3">Dekan Fakultas Ekonomi dan Bisnis Telkom University dengan ini menugaskan:</p>
                            <table class="mb-3">
                                <tr><td class="pr-4 align-top text-slate-500">Nama</td><td>: {{ $row['dosen'] }}</td></tr>
                                <tr><td class="pr-4 align-top text-slate-500">Prodi</td><td>: {{ $row['prodi'] }}</td></tr>
                                <tr><td class="pr-4 align-top text-slate-500">Kegiatan</td><td>: {{ $row['judul'] }}</td></tr>
                                <tr><td class="pr-4 align-top text-slate-500">Periode</td><td>: {{ $row['mulai'] }} s/d {{ $row['selesai'] }}</td></tr>
                            </table>
                            <p class="text-slate-500 italic">Demikian surat tugas ini dibuat untuk dilaksanakan dengan penuh tanggung jawab.</p>
                        </div>
                        <div class="flex items-center justify-end gap-3 mt-5">
                            <button class="px-4 py-2 rounded border border-slate-300 text-slate-600 text-sm font-semibold hover:bg-slate-50 inline-flex items-center gap-2">
                                @include('partials.icon', ['name' => 'eye', 'class' => 'w-4 h-4']) Preview PDF
                            </button>
                            <button class="px-5 py-2.5 rounded bg-teal-500 hover:bg-teal-600 text-white text-sm font-semibold inline-flex items-center gap-2">
                                @include('partials.icon', ['name' => 'send', 'class' => 'w-4 h-4']) Kirim ke Atasan SDM untuk Validasi
                            </button>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</div>
@endsection
