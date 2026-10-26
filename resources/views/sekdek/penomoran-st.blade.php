@extends('layouts.app')
@section('title', 'Penomoran Surat Tugas')
@section('breadcrumb', 'Tata Kelola / Penomoran')

@section('content')
<div x-data="{ sel:0, modal:false, numbered:{} }">
    @include('partials.page-head', ['heading' => 'Penomoran Surat Tugas', 'sub' => 'Alokasi nomor keluar dari register buku agenda surat keluar dekanat.'])
    @php $ready = collect($st)->take(3)->values(); @endphp

    <div class="grid grid-cols-1 lg:grid-cols-5 gap-6">
        {{-- Antrean --}}
        <div class="lg:col-span-2 bg-white rounded-lg border border-slate-200 overflow-hidden self-start">
            <div class="px-5 py-3.5 border-b border-slate-100 font-semibold text-slate-800 text-sm">Tervalidasi Atasan SDM</div>
            <div class="divide-y divide-slate-50">
                @foreach($ready as $i => $row)
                    <button @click="sel={{ $i }}" class="w-full text-left px-5 py-3.5 transition" :class="sel==={{ $i }}?'bg-teal-50':'hover:bg-slate-50'">
                        <div class="flex items-center justify-between gap-2">
                            <span class="text-xs text-slate-400 tnum">{{ $row['id'] }}</span>
                            <template x-if="numbered[{{ $i }}]"><span class="inline-flex items-center px-2 py-0.5 rounded-full text-[10px] font-semibold bg-green-100 text-green-800">Sudah Dinomori</span></template>
                        </div>
                        <div class="text-sm font-medium text-slate-800 truncate mt-0.5">{{ $row['judul'] }}</div>
                        <div class="text-xs text-slate-400 mt-0.5">{{ $row['dosen'] }}</div>
                    </button>
                @endforeach
            </div>
        </div>

        {{-- Detail --}}
        <div class="lg:col-span-3">
            @foreach($ready as $i => $row)
                <div x-show="sel==={{ $i }}" x-cloak class="bg-white rounded-lg border border-slate-200">
                    <div class="px-6 py-4 border-b border-slate-100 flex items-center justify-between">
                        <h3 class="font-semibold text-slate-800">Detail Surat untuk Penomoran</h3>
                        <span class="text-xs text-slate-400 tnum">{{ $row['id'] }}</span>
                    </div>
                    <div class="p-6 space-y-5">
                        <dl class="grid grid-cols-2 gap-x-6 gap-y-3 text-sm">
                            <div class="col-span-2"><dt class="text-slate-400">Kegiatan</dt><dd class="font-medium text-slate-800">{{ $row['judul'] }}</dd></div>
                            <div><dt class="text-slate-400">Pemohon</dt><dd class="font-medium text-slate-800">{{ $row['dosen'] }}</dd></div>
                            <div><dt class="text-slate-400">Program Studi</dt><dd class="font-medium text-slate-800">{{ $row['prodi'] }}</dd></div>
                            <div><dt class="text-slate-400">Kategori</dt><dd class="font-medium text-slate-800">{{ $row['kategori'] }}</dd></div>
                            <div><dt class="text-slate-400">Penyelenggara</dt><dd class="font-medium text-slate-800">{{ $row['mitra'] }}</dd></div>
                            <div><dt class="text-slate-400">Periode</dt><dd class="font-medium text-slate-800">{{ $row['mulai'] }} s/d {{ $row['selesai'] }}</dd></div>
                            <div><dt class="text-slate-400">Divalidasi oleh</dt><dd class="font-medium text-slate-800">Agus Salim (Atasan SDM)</dd></div>
                        </dl>

                        {{-- Panel register --}}
                        <div class="rounded-lg bg-slate-50 border border-slate-200 p-4">
                            <div class="text-xs font-semibold text-slate-500 uppercase tracking-wide mb-3">Register Buku Agenda Surat Keluar</div>
                            <div class="grid grid-cols-2 gap-4 text-sm">
                                <div><dt class="text-slate-400 text-xs">Nomor Urut Terakhir</dt><dd class="font-medium text-slate-800 tnum">365</dd></div>
                                <div><dt class="text-slate-400 text-xs">Nomor Urut Berikutnya</dt><dd class="font-semibold text-teal-600 tnum">366</dd></div>
                                <div><dt class="text-slate-400 text-xs">Kode Unit</dt><dd class="font-medium text-slate-800">SDM01 / EB-WD2</dd></div>
                                <div><dt class="text-slate-400 text-xs">Periode</dt><dd class="font-medium text-slate-800">Oktober 2026</dd></div>
                            </div>
                        </div>

                        <template x-if="numbered[{{ $i }}]">
                            <div class="flex items-center gap-2 rounded-lg bg-green-50 border border-green-200 px-4 py-3 text-sm text-green-800">
                                @include('partials.icon', ['name' => 'check', 'class' => 'w-4 h-4'])
                                Nomor <b class="tnum">366/SDM01/EB-WD2/2026</b> telah dialokasikan & diteruskan ke Admin SDM untuk penerbitan.
                            </div>
                        </template>

                        <div class="flex justify-end">
                            <button @click="modal=true; sel={{ $i }}" :disabled="numbered[{{ $i }}]"
                                    class="px-5 py-2.5 rounded bg-teal-500 hover:bg-teal-600 text-white text-sm font-semibold inline-flex items-center gap-2 transition active:scale-[0.98] disabled:opacity-50 disabled:cursor-not-allowed">
                                @include('partials.icon', ['name' => 'hash', 'class' => 'w-4 h-4'])
                                <span x-text="numbered[{{ $i }}] ? 'Sudah Dinomori' : 'Beri Nomor Surat'"></span>
                            </button>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>

    {{-- Modal alokasi nomor --}}
    <div x-show="modal" x-cloak class="fixed inset-0 z-50 grid place-items-center p-4 bg-black/40" @click.self="modal=false">
        <div class="bg-white rounded-xl w-full max-w-md shadow-xl">
            <div class="px-6 py-4 border-b border-slate-100 flex items-center justify-between">
                <h3 class="font-semibold text-slate-800">Alokasi Nomor Surat</h3>
                <button @click="modal=false" class="text-slate-400">@include('partials.icon', ['name' => 'x', 'class' => 'w-5 h-5'])</button>
            </div>
            <div class="p-6 space-y-4">
                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-1.5">Nomor Surat (dari Buku Agenda)</label>
                    <input value="366/SDM01/EB-WD2/2026" class="w-full rounded border border-slate-300 px-3 py-2 text-sm focus:border-teal-500 outline-none tnum">
                    <p class="text-xs text-slate-400 mt-1">Saran otomatis dari register (urut berikutnya: 366). Dapat diubah manual.</p>
                </div>
                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-1.5">Tanggal Registrasi</label>
                    <input type="date" value="2026-10-26" class="w-full rounded border border-slate-300 px-3 py-2 text-sm focus:border-teal-500 outline-none">
                </div>
                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-1.5">Catatan Register (opsional)</label>
                    <input placeholder="cth: Perihal Dosen Tamu" class="w-full rounded border border-slate-300 px-3 py-2 text-sm focus:border-teal-500 outline-none">
                </div>
            </div>
            <div class="px-6 py-4 border-t border-slate-100 flex justify-end gap-3">
                <button @click="modal=false" class="px-4 py-2 rounded border border-slate-300 text-sm font-medium text-slate-600">Batal</button>
                <button @click="numbered[sel]=true; modal=false; sigapToast('Nomor 366/SDM01/EB-WD2/2026 dialokasikan & diteruskan ke Admin SDM', 'green')" class="px-4 py-2 rounded bg-teal-500 hover:bg-teal-600 text-white text-sm font-semibold">Simpan & Teruskan ke SDM</button>
            </div>
        </div>
    </div>
</div>
@endsection
