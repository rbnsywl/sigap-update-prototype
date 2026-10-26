@extends('layouts.app')
@section('title', 'Approval Surat Tugas')
@section('breadcrumb', 'Approval / Surat Tugas')

@section('content')
<div x-data="{ sel:1, reject:false }">
    @include('partials.page-head', ['heading' => 'Approval Surat Tugas', 'sub' => 'Review relevansi tridharma dengan roadmap keilmuan prodi.'])
    <div class="grid grid-cols-1 lg:grid-cols-5 gap-6">
        <div class="lg:col-span-2 bg-white rounded-lg border border-slate-200 overflow-hidden self-start">
            <div class="px-5 py-3.5 border-b border-slate-100 font-semibold text-slate-800 text-sm">Antrean Persetujuan</div>
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
                    <div class="px-6 py-4 border-b border-slate-100"><h3 class="font-semibold text-slate-800">Review Substansi Keilmuan</h3></div>
                    <div class="p-6 space-y-5">
                        <div class="text-base font-semibold text-slate-900">{{ $row['judul'] }}</div>
                        <dl class="grid grid-cols-2 gap-x-6 gap-y-3 text-sm">
                            <div><dt class="text-slate-400">Pemohon</dt><dd class="font-medium text-slate-800">{{ $row['dosen'] }}</dd></div>
                            <div><dt class="text-slate-400">Kategori Tridharma</dt><dd class="font-medium text-slate-800">{{ $row['kategori'] }}</dd></div>
                            <div><dt class="text-slate-400">Mitra</dt><dd class="font-medium text-slate-800">{{ $row['mitra'] }}</dd></div>
                            <div><dt class="text-slate-400">Periode</dt><dd class="font-medium text-slate-800">{{ $row['mulai'] }} s/d {{ $row['selesai'] }}</dd></div>
                        </dl>
                        <div class="rounded-lg bg-slate-50 border border-slate-100 p-4">
                            <div class="text-xs font-semibold text-slate-500 uppercase tracking-wide mb-1">Catatan Staf Prodi</div>
                            <p class="text-sm text-slate-700">Berkas lengkap, tidak ada bentrok jadwal mengajar. Relevan dengan roadmap prodi.</p>
                        </div>
                        <div class="flex items-center justify-end gap-3">
                            <button @click="reject=true" class="px-4 py-2 rounded border border-rose-300 text-rose-600 text-sm font-semibold hover:bg-rose-50">Tolak / Kembalikan</button>
                            <button class="px-5 py-2.5 rounded bg-teal-500 hover:bg-teal-600 text-white text-sm font-semibold inline-flex items-center gap-2">
                                @include('partials.icon', ['name' => 'check', 'class' => 'w-4 h-4'])
                                Setujui & Teruskan ke SDM Fakultas
                            </button>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>

    <div x-show="reject" x-cloak class="fixed inset-0 z-50 grid place-items-center p-4 bg-black/40" @click.self="reject=false">
        <div class="bg-white rounded-xl w-full max-w-md shadow-xl">
            <div class="px-6 py-4 border-b border-slate-100 flex items-center justify-between">
                <h3 class="font-semibold text-slate-800">Tolak / Kembalikan Pengajuan</h3>
                <button @click="reject=false" class="text-slate-400">@include('partials.icon', ['name' => 'x', 'class' => 'w-5 h-5'])</button>
            </div>
            <div class="p-6">
                <label class="block text-sm font-medium text-slate-700 mb-1.5">Catatan Penolakan <span class="text-rose-500">*</span></label>
                <textarea rows="4" class="w-full rounded border border-slate-300 px-3 py-2 text-sm focus:border-teal-500 outline-none" placeholder="Wajib diisi…"></textarea>
            </div>
            <div class="px-6 py-4 border-t border-slate-100 flex justify-end gap-3">
                <button @click="reject=false" class="px-4 py-2 rounded border border-slate-300 text-sm font-medium text-slate-600">Batal</button>
                <button @click="reject=false" class="px-4 py-2 rounded bg-rose-500 hover:bg-rose-600 text-white text-sm font-semibold">Kirim Penolakan</button>
            </div>
        </div>
    </div>
</div>
@endsection
