@extends('layouts.app')
@section('title', 'Kelola Penyetaraan S3')
@section('breadcrumb', 'Penyetaraan S3 / Kelola')

@section('content')
<div x-data="{ distribusi:false, ba:false }">
    @include('partials.page-head', ['heading' => 'Kelola Penyetaraan Ijazah S3', 'sub' => 'Validasi berkas, distribusi ke asesor, & pelaporan ke SDM Pusat.'])

    <div class="space-y-4">
        @foreach($rows as $r)
            <div class="bg-white rounded-lg border border-slate-200">
                <div class="px-6 py-5 flex flex-wrap items-start justify-between gap-4">
                    <div class="flex items-center gap-4">
                        <div class="w-12 h-12 rounded-full bg-teal-600 text-white grid place-items-center font-semibold">{{ $r['avatar'] }}</div>
                        <div>
                            <div class="font-semibold text-slate-900">{{ $r['dosen'] }}</div>
                            <div class="text-xs text-slate-400 mt-0.5">{{ $r['id'] }} · {{ $r['prodi'] }} · {{ $r['tanggal'] }}</div>
                            <div class="text-sm text-slate-600 mt-1 max-w-xl">{{ $r['judul_disertasi'] }}</div>
                        </div>
                    </div>
                    <div class="text-right">
                        @include('partials.badge', ['label' => $r['status'], 'tone' => $statuses[$r['status']] ?? 'slate'])
                    </div>
                </div>

                {{-- Assessor progress --}}
                @if(count($r['asesor']))
                    <div class="px-6 pb-5">
                        @php $done = collect($r['asesor'])->where('done',true)->count(); $tot = count($r['asesor']); @endphp
                        <div class="text-xs text-slate-500 mb-2">{{ $done }} dari {{ $tot }} Asesor telah mengunggah nilai</div>
                        <div class="grid grid-cols-3 gap-3">
                            @foreach($r['asesor'] as $a)
                                <div class="rounded-lg border p-3 {{ $a['done'] ? 'border-green-200 bg-green-50' : 'border-slate-200 bg-slate-50' }}">
                                    <div class="flex items-center gap-2 text-xs font-semibold {{ $a['done'] ? 'text-green-700' : 'text-slate-500' }}">
                                        @include('partials.icon', ['name' => $a['done']?'check':'clock', 'class' => 'w-3.5 h-3.5'])
                                        {{ $a['peran'] }}
                                    </div>
                                    <div class="text-xs text-slate-500 mt-1">{{ $a['nama'] }}</div>
                                </div>
                            @endforeach
                        </div>
                        <div class="flex justify-end gap-3 mt-4">
                            @if($done === $tot && $r['status'] !== 'Selesai')
                                <button @click="ba=true" class="px-4 py-2 rounded bg-teal-500 hover:bg-teal-600 text-white text-sm font-semibold inline-flex items-center gap-2">
                                    @include('partials.icon', ['name' => 'report', 'class' => 'w-4 h-4']) Buat Berita Acara & Lapor NDE
                                </button>
                            @endif
                        </div>
                    </div>
                @elseif($r['status'] === 'Perlu Revisi')
                    <div class="px-6 pb-5">
                        <div class="flex items-start gap-3 bg-yellow-50 border border-yellow-200 rounded-lg px-4 py-3">
                            @include('partials.icon', ['name' => 'help', 'class' => 'w-5 h-5 text-yellow-600 shrink-0 mt-0.5'])
                            <span class="text-sm text-yellow-700">{{ $r['catatan_admin'] }}</span>
                        </div>
                    </div>
                @else
                    <div class="px-6 pb-5 flex justify-end gap-3">
                        <button class="px-4 py-2 rounded border border-rose-300 text-rose-600 text-sm font-semibold hover:bg-rose-50">Kembalikan — Perlu Revisi</button>
                        <button @click="distribusi=true" class="px-4 py-2 rounded bg-teal-500 hover:bg-teal-600 text-white text-sm font-semibold inline-flex items-center gap-2">
                            @include('partials.icon', ['name' => 'users', 'class' => 'w-4 h-4']) Distribusi ke 3 Asesor
                        </button>
                    </div>
                @endif
            </div>
        @endforeach
    </div>

    {{-- Distribusi modal --}}
    <div x-show="distribusi" x-cloak class="fixed inset-0 z-50 grid place-items-center p-4 bg-black/40" @click.self="distribusi=false">
        <div class="bg-white rounded-xl w-full max-w-md shadow-xl">
            <div class="px-6 py-4 border-b border-slate-100 flex items-center justify-between">
                <h3 class="font-semibold text-slate-800">Distribusi ke Tim Asesor</h3>
                <button @click="distribusi=false" class="text-slate-400">@include('partials.icon', ['name' => 'x', 'class' => 'w-5 h-5'])</button>
            </div>
            <div class="p-6 space-y-2">
                @foreach(['Ketua Kelompok Keahlian (KK)','Ketua Program Studi (Kaprodi)','Dekan / Wakil Dekan'] as $a)
                    <label class="flex items-center gap-3 p-3 rounded-lg border border-slate-200 cursor-pointer hover:bg-slate-50">
                        <input type="checkbox" checked class="w-4 h-4 rounded text-teal-500 focus:ring-teal-500">
                        <span class="text-sm text-slate-700">{{ $a }}</span>
                    </label>
                @endforeach
            </div>
            <div class="px-6 py-4 border-t border-slate-100 flex justify-end gap-3">
                <button @click="distribusi=false" class="px-4 py-2 rounded border border-slate-300 text-sm font-medium text-slate-600">Batal</button>
                <button @click="distribusi=false" class="px-4 py-2 rounded bg-teal-500 hover:bg-teal-600 text-white text-sm font-semibold">Distribusikan</button>
            </div>
        </div>
    </div>

    {{-- Berita Acara modal --}}
    <div x-show="ba" x-cloak class="fixed inset-0 z-50 grid place-items-center p-4 bg-black/40" @click.self="ba=false">
        <div class="bg-white rounded-xl w-full max-w-md shadow-xl">
            <div class="px-6 py-4 border-b border-slate-100 flex items-center justify-between">
                <h3 class="font-semibold text-slate-800">Berita Acara & Pelaporan NDE</h3>
                <button @click="ba=false" class="text-slate-400">@include('partials.icon', ['name' => 'x', 'class' => 'w-5 h-5'])</button>
            </div>
            <div class="p-6 space-y-4">
                <button class="w-full px-4 py-2.5 rounded border border-teal-500 text-teal-600 text-sm font-semibold hover:bg-teal-50 inline-flex items-center justify-center gap-2">
                    @include('partials.icon', ['name' => 'download', 'class' => 'w-4 h-4']) Generate Berita Acara Rapat Penyetaraan
                </button>
                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-1.5">Nomor NDE Pengantar ke SDM Pusat <span class="text-rose-500">*</span></label>
                    <input placeholder="cth: NDE/FEB/SDM/X/2026/201" class="w-full rounded border border-slate-300 px-3 py-2 text-sm focus:border-teal-500 outline-none tnum">
                </div>
            </div>
            <div class="px-6 py-4 border-t border-slate-100 flex justify-end gap-3">
                <button @click="ba=false" class="px-4 py-2 rounded border border-slate-300 text-sm font-medium text-slate-600">Batal</button>
                <button @click="ba=false" class="px-4 py-2 rounded bg-teal-500 hover:bg-teal-600 text-white text-sm font-semibold">Kirim ke SDM Pusat</button>
            </div>
        </div>
    </div>
</div>
@endsection
