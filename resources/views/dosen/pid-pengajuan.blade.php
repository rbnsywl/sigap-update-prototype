@extends('layouts.app')
@section('title', 'Pengajuan Studi Lanjut PID')
@section('breadcrumb', 'Studi PID / Pengajuan')

@section('content')
    @include('partials.page-head', ['heading' => 'Pengajuan Studi Lanjut PID', 'sub' => 'Formulir pendaftaran beasiswa doktoral & riwayat amandemen.'])

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <div class="lg:col-span-2 bg-white rounded-lg border border-slate-200">
            <div class="px-6 py-4 border-b border-slate-100"><h3 class="font-semibold text-slate-800">Formulir Pendaftaran Beasiswa S3</h3></div>
            <div class="p-6 grid grid-cols-1 md:grid-cols-2 gap-5">
                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-1.5">Universitas Tujuan</label>
                    <select class="w-full rounded border border-slate-300 px-3 py-2 text-sm focus:border-teal-500 outline-none">
                        <option>Universitas Padjadjaran (PTN - Unggul)</option><option>Universitas Indonesia</option><option>Institut Teknologi Bandung</option><option>Luar Negeri</option>
                    </select>
                </div>
                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-1.5">Program Studi / Fokus Disertasi</label>
                    <input placeholder="cth: S3 Ilmu Manajemen" class="w-full rounded border border-slate-300 px-3 py-2 text-sm focus:border-teal-500 outline-none">
                </div>
                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-1.5">Skema Pembiayaan</label>
                    <select class="w-full rounded border border-slate-300 px-3 py-2 text-sm focus:border-teal-500 outline-none">
                        <option>2N+12 (2 thn mitra + 12 bln penulisan)</option><option>Kemitraan Khusus</option>
                    </select>
                </div>
                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-1.5">Estimasi Durasi Studi</label>
                    <input placeholder="cth: 7 Semester" class="w-full rounded border border-slate-300 px-3 py-2 text-sm focus:border-teal-500 outline-none">
                </div>
                <div class="md:col-span-2 grid grid-cols-3 gap-4">
                    <div><label class="block text-sm font-medium text-slate-700 mb-2">LoA</label>@include('partials.dropzone', ['label' => 'Letter of Acceptance'])</div>
                    <div><label class="block text-sm font-medium text-slate-700 mb-2">Proposal Disertasi</label>@include('partials.dropzone', ['label' => 'Rencana Disertasi'])</div>
                    <div><label class="block text-sm font-medium text-slate-700 mb-2">Surat Rekomendasi</label>@include('partials.dropzone', ['label' => 'Rekomendasi Pimpinan'])</div>
                </div>
                <div class="md:col-span-2 flex justify-end">
                    <button class="px-5 py-2.5 rounded bg-teal-500 hover:bg-teal-600 text-white text-sm font-semibold inline-flex items-center gap-2">
                        @include('partials.icon', ['name' => 'send', 'class' => 'w-4 h-4'])
                        Ajukan Pendaftaran
                    </button>
                </div>
            </div>
        </div>

        {{-- Active study + amendments --}}
        <div class="space-y-6">
            <div class="bg-white rounded-lg border border-slate-200 p-6">
                <div class="flex items-center justify-between">
                    <h3 class="font-semibold text-slate-800">Studi Aktif</h3>
                    @include('partials.badge', ['label' => $pid['status'], 'tone' => 'green'])
                </div>
                <dl class="mt-4 space-y-3 text-sm">
                    <div><dt class="text-slate-400">Universitas</dt><dd class="font-medium text-slate-800">{{ $pid['universitas'] }}</dd></div>
                    <div><dt class="text-slate-400">Skema</dt><dd class="font-medium text-slate-800">{{ $pid['skema'] }} · {{ $pid['durasi'] }}</dd></div>
                    <div><dt class="text-slate-400">SK Beasiswa</dt><dd class="font-medium text-slate-800 tnum">{{ $pid['sk_beasiswa'] }}</dd></div>
                    <div><dt class="text-slate-400">Plafon</dt><dd class="font-medium text-teal-600 tnum">{{ \App\Support\MockData::rupiah($pid['plafon']) }}</dd></div>
                </dl>
            </div>
            <div class="bg-white rounded-lg border border-slate-200 p-6">
                <h3 class="font-semibold text-slate-800 mb-2">Riwayat Amandemen</h3>
                <p class="text-sm text-slate-400">Belum ada perpanjangan masa studi.</p>
            </div>
        </div>
    </div>
@endsection
