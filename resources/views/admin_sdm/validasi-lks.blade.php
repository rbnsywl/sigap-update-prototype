@extends('layouts.app')
@section('title', 'Validasi LKS Semester')
@section('breadcrumb', 'Studi PID / Validasi LKS')

@section('content')
<div x-data="{ sel:3 }">
    @include('partials.page-head', ['heading' => 'Validasi LKS Semester', 'sub' => 'Verifikasi kelengkapan 4 berkas sebelum diajukan ke Dekan.'])
    <div class="grid grid-cols-1 lg:grid-cols-5 gap-6">
        <div class="lg:col-span-2 bg-white rounded-lg border border-slate-200 overflow-hidden self-start">
            <div class="px-5 py-3.5 border-b border-slate-100 font-semibold text-slate-800 text-sm">Antrean Validasi</div>
            <div class="divide-y divide-slate-50">
                @foreach($lks as $i => $l)
                    <button @click="sel={{ $i }}" class="w-full text-left px-5 py-3.5 transition" :class="sel==={{ $i }}?'bg-teal-50':'hover:bg-slate-50'">
                        <div class="flex items-center justify-between gap-2">
                            <span class="text-sm font-medium text-slate-800 truncate">{{ $l['semester'] }}</span>
                            @include('partials.badge', ['label' => $l['status'], 'tone' => $statuses[$l['status']] ?? 'slate'])
                        </div>
                        <div class="text-xs text-slate-400 mt-0.5">Dr. Rangga Pratama · IPK {{ number_format($l['ipk'],2) }}</div>
                    </button>
                @endforeach
            </div>
        </div>
        <div class="lg:col-span-3">
            @foreach($lks as $i => $l)
                <div x-show="sel==={{ $i }}" x-cloak class="bg-white rounded-lg border border-slate-200">
                    <div class="px-6 py-4 border-b border-slate-100 flex items-center justify-between">
                        <h3 class="font-semibold text-slate-800">Verifikasi Dokumen — {{ $l['semester'] }}</h3>
                        @include('partials.badge', ['label' => $l['status'], 'tone' => $statuses[$l['status']] ?? 'slate'])
                    </div>
                    <div class="p-6 grid grid-cols-1 md:grid-cols-2 gap-6">
                        {{-- Evidence gabungan dari dosen --}}
                        <div>
                            @include('partials.evidence', ['title' => 'Berkas Gabungan dari Dosen', 'files' => \App\Support\MockData::evidenceLks()])
                        </div>
                        {{-- Checklist --}}
                        <div class="space-y-3">
                            <div class="text-sm font-medium text-slate-700">Kelengkapan 4 Berkas</div>
                            @foreach(['Dokumen LKS bertanda tangan Promotor','Transkrip / KHS semester ini','Surat Keterangan Aktif Kuliah','Bukti Pembayaran BPP/SPP'] as $c)
                                <label class="flex items-center gap-3 p-3 rounded-lg border border-slate-200 cursor-pointer hover:bg-slate-50">
                                    <input type="checkbox" class="w-4 h-4 rounded text-teal-500 focus:ring-teal-500">
                                    <span class="text-sm text-slate-700">{{ $c }}</span>
                                </label>
                            @endforeach
                            <div class="flex flex-col gap-2 pt-2">
                                <button @click="sigapToast('LKS {{ $l['semester'] }} divalidasi — diteruskan ke Dekan', 'green')" class="w-full px-4 py-2.5 rounded bg-teal-500 hover:bg-teal-600 text-white text-sm font-semibold transition active:scale-[0.98]">Validasi Memenuhi Syarat</button>
                                <button @click="sigapToast('Permintaan perbaikan dokumen dikirim ke dosen', 'rose')" class="w-full px-4 py-2.5 rounded border border-rose-300 text-rose-600 text-sm font-semibold hover:bg-rose-50">Minta Perbaikan Dokumen</button>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</div>
@endsection
