@extends('layouts.app')
@section('title', 'Pelaporan Kelulusan PID')
@section('breadcrumb', 'Studi PID / Kelulusan')

@section('content')
<div x-data="{ sel:0, nde:false }">
    @include('partials.page-head', ['heading' => 'Pelaporan Kelulusan PID', 'sub' => 'Verifikasi kelulusan doktoral & pemrosesan NDE penutupan beasiswa ke SDM Pusat.'])

    @php
        $rp = fn($v) => \App\Support\MockData::rupiah($v);
        // Data kelulusan (mock) — detail per dosen PID yang melaporkan kelulusan.
        $lulus = [[
            'dosen' => 'Dr. (Cand.) Rangga Pratama', 'avatar' => 'RP', 'nip' => '21880042',
            'universitas' => 'Universitas Padjadjaran', 'prodi' => 'S3 Ilmu Manajemen',
            'tgl_lulus' => '2026-09-28', 'ipk' => '3.92', 'lama_studi' => '7 Semester',
            'judul' => 'Dynamic Capabilities & Firm Performance pada Industri Kreatif Jawa Barat',
            'plafon' => 56000000, 'realisasi' => 52000000,
            'status' => 'Menunggu Proses NDE',
            'berkas' => [
                ['nama' => 'Ijazah_S3.pdf', 'ukuran' => '1.1 MB', 'tanggal' => '2026-09-30', 'oleh' => 'Dr. (Cand.) Rangga Pratama'],
                ['nama' => 'Transkrip_Nilai_S3.pdf', 'ukuran' => '890 KB', 'tanggal' => '2026-09-30', 'oleh' => 'Dr. (Cand.) Rangga Pratama'],
                ['nama' => 'SK_Yudisium.pdf', 'ukuran' => '620 KB', 'tanggal' => '2026-09-30', 'oleh' => 'Dr. (Cand.) Rangga Pratama'],
            ],
        ]];
    @endphp

    <div class="grid grid-cols-1 lg:grid-cols-5 gap-6">
        {{-- List --}}
        <div class="lg:col-span-2 bg-white rounded-lg border border-slate-200 overflow-hidden self-start">
            <div class="px-5 py-3.5 border-b border-slate-100 font-semibold text-slate-800 text-sm">Laporan Kelulusan Masuk</div>
            <div class="divide-y divide-slate-50">
                @foreach($lulus as $i => $l)
                    <button @click="sel={{ $i }}" class="w-full text-left px-5 py-3.5 flex items-center gap-3 transition" :class="sel==={{ $i }}?'bg-teal-50':'hover:bg-slate-50'">
                        <div class="w-9 h-9 rounded-full bg-teal-600 text-white grid place-items-center text-xs font-semibold shrink-0">{{ $l['avatar'] }}</div>
                        <div class="min-w-0">
                            <div class="text-sm font-medium text-slate-800 truncate">{{ $l['dosen'] }}</div>
                            <div class="text-xs text-slate-400">{{ $l['universitas'] }}</div>
                        </div>
                    </button>
                @endforeach
            </div>
        </div>

        {{-- Detail --}}
        <div class="lg:col-span-3">
            @foreach($lulus as $i => $l)
                <div x-show="sel==={{ $i }}" x-cloak class="bg-white rounded-lg border border-slate-200">
                    <div class="px-6 py-5 border-b border-slate-100 flex items-center gap-4">
                        <div class="w-12 h-12 rounded-full bg-teal-600 text-white grid place-items-center font-semibold">{{ $l['avatar'] }}</div>
                        <div class="flex-1">
                            <div class="font-semibold text-slate-900">{{ $l['dosen'] }}</div>
                            <div class="text-xs text-slate-400">{{ $l['nip'] }} · {{ $l['universitas'] }}</div>
                        </div>
                        @include('partials.badge', ['label' => $l['status'], 'tone' => 'amber'])
                    </div>
                    <div class="p-6 space-y-5">
                        {{-- Detail akademik --}}
                        <dl class="grid grid-cols-2 gap-x-6 gap-y-3 text-sm">
                            <div><dt class="text-slate-400">Program Studi</dt><dd class="font-medium text-slate-800">{{ $l['prodi'] }}</dd></div>
                            <div><dt class="text-slate-400">Tanggal Lulus</dt><dd class="font-medium text-slate-800">{{ $l['tgl_lulus'] }}</dd></div>
                            <div><dt class="text-slate-400">IPK Akhir</dt><dd class="font-medium text-slate-800 tnum">{{ $l['ipk'] }}</dd></div>
                            <div><dt class="text-slate-400">Lama Studi</dt><dd class="font-medium text-slate-800">{{ $l['lama_studi'] }}</dd></div>
                            <div class="col-span-2"><dt class="text-slate-400">Judul Disertasi</dt><dd class="font-medium text-slate-800">{{ $l['judul'] }}</dd></div>
                        </dl>

                        {{-- Rekap keuangan penutupan --}}
                        <div class="grid grid-cols-3 gap-4">
                            <div class="rounded-lg bg-slate-50 p-4"><div class="text-xs text-slate-500">Plafon</div><div class="mt-1 font-bold text-slate-900 tnum">{{ $rp($l['plafon']) }}</div></div>
                            <div class="rounded-lg bg-green-50 p-4"><div class="text-xs text-green-700">Realisasi</div><div class="mt-1 font-bold text-green-700 tnum">{{ $rp($l['realisasi']) }}</div></div>
                            <div class="rounded-lg bg-teal-50 p-4"><div class="text-xs text-teal-700">Sisa (dikembalikan)</div><div class="mt-1 font-bold text-teal-700 tnum">{{ $rp($l['plafon'] - $l['realisasi']) }}</div></div>
                        </div>

                        {{-- Berkas kelulusan --}}
                        @include('partials.evidence', ['title' => 'Berkas Kelulusan', 'files' => $l['berkas']])

                        <div class="flex justify-end gap-3">
                            <button @click="sigapToast('Berkas dikembalikan ke dosen untuk perbaikan', 'rose')" class="px-4 py-2 rounded border border-slate-300 text-slate-600 text-sm font-semibold hover:bg-slate-50">Minta Perbaikan</button>
                            <button @click="nde=true" class="px-5 py-2.5 rounded bg-teal-500 hover:bg-teal-600 text-white text-sm font-semibold inline-flex items-center gap-2">
                                @include('partials.icon', ['name' => 'send', 'class' => 'w-4 h-4']) Proses NDE Penutupan Beasiswa
                            </button>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>

    {{-- NDE modal --}}
    <div x-show="nde" x-cloak class="fixed inset-0 z-50 grid place-items-center p-4 bg-black/40" @click.self="nde=false">
        <div class="bg-white rounded-xl w-full max-w-md shadow-xl">
            <div class="px-6 py-4 border-b border-slate-100 flex items-center justify-between">
                <h3 class="font-semibold text-slate-800">NDE Penutupan Beasiswa ke SDM Pusat</h3>
                <button @click="nde=false" class="text-slate-400">@include('partials.icon', ['name' => 'x', 'class' => 'w-5 h-5'])</button>
            </div>
            <div class="p-6 space-y-4">
                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-1.5">Nomor NDE Penutupan <span class="text-rose-500">*</span></label>
                    <input placeholder="cth: NDE/FEB/SDM/X/2026/150" class="w-full rounded border border-slate-300 px-3 py-2 text-sm focus:border-teal-500 outline-none tnum">
                </div>
                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-1.5">Tanggal Disposisi</label>
                    <input type="date" class="w-full rounded border border-slate-300 px-3 py-2 text-sm focus:border-teal-500 outline-none">
                </div>
            </div>
            <div class="px-6 py-4 border-t border-slate-100 flex justify-end gap-3">
                <button @click="nde=false" class="px-4 py-2 rounded border border-slate-300 text-sm font-medium text-slate-600">Batal</button>
                <button @click="nde=false; sigapToast('Simulasi selesai: NDE penutupan diproses dan pembaruan HRIS dijadwalkan', 'green')" class="px-4 py-2 rounded bg-teal-500 hover:bg-teal-600 text-white text-sm font-semibold">Konfirmasi & Kirim</button>
            </div>
        </div>
    </div>
</div>
@endsection
