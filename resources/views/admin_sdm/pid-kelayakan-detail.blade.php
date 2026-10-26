@extends('layouts.app')
@section('title', 'Detail Kelayakan Dosen')
@section('breadcrumb', 'Studi PID / Detail Kelayakan')

@section('content')
    <a href="/admin-sdm/pid/kelayakan" class="inline-flex items-center gap-1 text-sm text-slate-500 hover:text-teal-600 mb-4">← Kembali ke daftar</a>
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <div class="lg:col-span-2 space-y-6">
            {{-- Profile --}}
            <div class="bg-white rounded-lg border border-slate-200 p-6 flex items-center gap-4">
                <div class="w-14 h-14 rounded-full bg-teal-600 text-white grid place-items-center text-lg font-bold">{{ $dosen['avatar'] }}</div>
                <div>
                    <div class="font-semibold text-slate-900">{{ $dosen['nama'] }}</div>
                    <div class="text-sm text-slate-500">{{ $dosen['nip'] }} · {{ $dosen['prodi'] }} · {{ $dosen['jad'] }}</div>
                </div>
                <div class="ml-auto">@include('partials.badge', ['label' => $dosen['status'], 'tone' => 'green'])</div>
            </div>

            {{-- Auto criteria --}}
            <div class="bg-white rounded-lg border border-slate-200">
                <div class="px-6 py-4 border-b border-slate-100"><h3 class="font-semibold text-slate-800">Kriteria Otomatis (HRIS)</h3></div>
                <div class="divide-y divide-slate-50">
                    @foreach($dosen['kriteria'] as $k)
                        <div class="px-6 py-3.5 flex items-center gap-4">
                            <div class="w-8 h-8 rounded-full grid place-items-center shrink-0 {{ $k['ok'] ? 'bg-green-100 text-green-600' : 'bg-rose-100 text-rose-600' }}">
                                @include('partials.icon', ['name' => $k['ok'] ? 'check' : 'x', 'class' => 'w-4 h-4'])
                            </div>
                            <div class="flex-1"><span class="text-sm font-medium text-slate-800">{{ $k['label'] }}</span></div>
                            <span class="text-sm text-slate-500">{{ $k['detail'] }}</span>
                        </div>
                    @endforeach
                </div>
            </div>

            {{-- Manual checklist --}}
            <div class="bg-white rounded-lg border border-slate-200">
                <div class="px-6 py-4 border-b border-slate-100"><h3 class="font-semibold text-slate-800">Verifikasi Manual SDM</h3></div>
                <div class="p-6 space-y-2">
                    @foreach(['Lulus Forum Studi Dosen Pemula (FSDP)','Tidak memiliki catatan disiplin kepegawaian','Beban BKD terpenuhi'] as $c)
                        <label class="flex items-center gap-3 p-3 rounded-lg border border-slate-200 cursor-pointer hover:bg-slate-50">
                            <input type="checkbox" checked class="w-4 h-4 rounded text-teal-500 focus:ring-teal-500">
                            <span class="text-sm text-slate-700">{{ $c }}</span>
                        </label>
                    @endforeach
                </div>
            </div>
        </div>

        {{-- Private notes --}}
        <div class="space-y-6">
            <div class="bg-amber-50 rounded-lg border border-amber-200 p-5">
                <div class="flex items-center gap-2 text-amber-800 font-semibold text-sm mb-1">
                    @include('partials.icon', ['name' => 'shield', 'class' => 'w-4 h-4']) Catatan Internal SDM
                </div>
                <p class="text-xs text-amber-700 mb-3">🔒 Catatan hanya terlihat oleh Admin SDM, tidak tampil di portal dosen.</p>
                <textarea rows="5" class="w-full rounded border border-amber-300 bg-white px-3 py-2 text-sm focus:border-amber-500 outline-none" placeholder="Catatan evaluasi internal…">Kandidat kuat. FSDP lulus 2023. Menunggu konfirmasi LoA dari UNPAD.</textarea>
                <button class="mt-3 w-full px-3 py-2 rounded bg-amber-500 hover:bg-amber-600 text-white text-sm font-semibold">Simpan Catatan</button>
            </div>
            <div class="bg-white rounded-lg border border-slate-200 p-5">
                <h3 class="font-semibold text-slate-800 text-sm mb-3">Pemutakhiran Status</h3>
                <select class="w-full rounded border border-slate-300 px-3 py-2 text-sm focus:border-teal-500 outline-none mb-3">
                    <option>Eligible Penuh YPT</option><option>Eligible Sebagian</option><option>Belum Memenuhi Syarat</option><option>Data Belum Lengkap</option>
                </select>
                <button class="w-full px-3 py-2 rounded bg-teal-500 hover:bg-teal-600 text-white text-sm font-semibold">Simpan Kelayakan</button>
            </div>
        </div>
    </div>
@endsection
