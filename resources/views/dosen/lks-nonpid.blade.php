@extends('layouts.app')
@section('title', 'Lapor LKS (Non-PID)')
@section('breadcrumb', 'Studi Non-PID / Lapor LKS')

@section('content')
    @include('partials.page-head', ['heading' => 'Lapor Kemajuan Studi (LKS)', 'sub' => 'Pelaporan kemajuan studi mandiri (Non-PID). Cukup unggah dokumen LKS — tanpa berkas keuangan beasiswa.'])

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        {{-- Form --}}
        <div class="lg:col-span-2 bg-white rounded-lg border border-slate-200">
            <div class="px-6 py-4 border-b border-slate-100 flex items-center justify-between">
                <h3 class="font-semibold text-slate-800">Formulir Pelaporan LKS</h3>
                <button type="button" @click="sigapToast('Mengunduh Template LKS FEB (.docx)', 'teal')"
                        class="inline-flex items-center gap-2 px-3 py-1.5 rounded border border-teal-500 text-teal-600 text-sm font-semibold hover:bg-teal-50">
                    @include('partials.icon', ['name' => 'download', 'class' => 'w-4 h-4'])
                    Unduh Template LKS (.docx)
                </button>
            </div>
            <div class="p-6 space-y-5">
                <div class="grid grid-cols-2 gap-5">
                    <div>
                        <label class="block text-sm font-medium text-slate-700 mb-1.5">Semester LKS <span class="text-rose-500">*</span></label>
                        <select class="w-full rounded border border-slate-300 px-3 py-2 text-sm focus:border-teal-500 outline-none">
                            <option>Semester 3 (Ganjil 2025/2026)</option><option>Semester 2 (Genap 2024/2025)</option>
                        </select>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-slate-700 mb-1.5">Tanggal Submit <span class="text-rose-500">*</span></label>
                        <input type="date" class="w-full rounded border border-slate-300 px-3 py-2 text-sm focus:border-teal-500 outline-none">
                    </div>
                </div>
                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-1.5">IPK Semester Berjalan <span class="text-rose-500">*</span></label>
                    <input type="number" step="0.01" min="0" max="4" placeholder="cth: 3.80" class="w-40 rounded border border-slate-300 px-3 py-2 text-sm focus:border-teal-500 outline-none">
                </div>
                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-1.5">Progres Tahapan Studi <span class="text-rose-500">*</span></label>
                    <textarea rows="4" placeholder="Uraikan kemajuan perkuliahan / penelitian / penulisan selama semester ini…" class="w-full rounded border border-slate-300 px-3 py-2 text-sm focus:border-teal-500 outline-none"></textarea>
                </div>
                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-2">Dokumen LKS <span class="text-rose-500">*</span></label>
                    <div class="rounded-lg bg-teal-50 border border-teal-100 p-3 mb-3 text-xs text-teal-800 flex items-start gap-2">
                        @include('partials.icon', ['name' => 'clipboard', 'class' => 'w-4 h-4 shrink-0 mt-0.5'])
                        <span>Khusus Non-PID: cukup unggah <b>1 dokumen LKS</b> (PDF) yang telah ditandatangani Promotor. Tidak perlu transkrip keuangan atau bukti transfer BPP.</span>
                    </div>
                    @include('partials.dropzone', ['label' => 'Unggah dokumen LKS (PDF)', 'hint' => 'PDF saja · Maks 10MB'])
                </div>
                <div class="flex justify-end gap-3 pt-2">
                    <button class="px-4 py-2 rounded border border-slate-300 text-sm font-medium text-slate-600">Simpan Draf</button>
                    <button type="button" @click="sigapToast('LKS disubmit — menunggu review SDM', 'green')" class="px-5 py-2.5 rounded bg-teal-500 hover:bg-teal-600 text-white text-sm font-semibold inline-flex items-center gap-2 transition active:scale-[0.98]">
                        @include('partials.icon', ['name' => 'send', 'class' => 'w-4 h-4'])
                        Submit LKS
                    </button>
                </div>
            </div>
        </div>

        {{-- History --}}
        <div class="bg-white rounded-lg border border-slate-200">
            <div class="px-6 py-4 border-b border-slate-100"><h3 class="font-semibold text-slate-800">Riwayat Pelaporan</h3></div>
            <div class="divide-y divide-slate-50">
                @forelse($lks as $l)
                    <div class="px-6 py-4">
                        <div class="flex items-center justify-between gap-2">
                            <div class="text-sm font-medium text-slate-800">{{ $l['semester'] }}</div>
                            @include('partials.badge', ['label' => $l['status'], 'tone' => $statuses[$l['status']] ?? 'slate'])
                        </div>
                        <div class="text-xs text-slate-400 mt-1">Submit {{ $l['tanggal'] }} · IPK {{ number_format($l['ipk'],2) }}</div>
                        @if($l['status'] === 'LKS Approved')
                            <button type="button" @click="sigapToast('Mengunduh LKS disahkan — {{ $l['semester'] }}', 'teal')" class="mt-2 text-xs text-teal-600 font-semibold inline-flex items-center gap-1 hover:underline">
                                @include('partials.icon', ['name' => 'download', 'class' => 'w-3.5 h-3.5'])
                                Unduh LKS Disahkan
                            </button>
                        @endif
                    </div>
                @empty
                    <div class="px-6 py-8 text-center text-sm text-slate-400">Belum ada laporan LKS.</div>
                @endforelse
            </div>
        </div>
    </div>
@endsection
