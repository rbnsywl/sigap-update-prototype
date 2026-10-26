@extends('layouts.app')
@section('title', 'Laporan Kemajuan Studi (LKS)')
@section('breadcrumb', 'Studi PID / Laporan LKS')

@section('content')
    @include('partials.page-head', ['heading' => 'Laporan Kemajuan Studi', 'sub' => 'Laporan capaian akademik semesteran bagi penerima beasiswa PID.'])

    {{-- Tahapan studi --}}
    <section class="mb-6 rounded-lg border border-slate-200 bg-white p-4 sm:p-6" aria-labelledby="study-progress-title">
        @php $steps = ['Semester aktif','Penyusunan proposal','Seminar hasil','Ujian tertutup','Disertasi / ujian terbuka']; $current = 1; @endphp
        <div class="mb-4 flex items-center justify-between gap-3">
            <h3 id="study-progress-title" class="text-sm font-semibold text-slate-900">Tahapan studi doktoral</h3>
            <span class="text-xs font-medium text-slate-600">Tahap {{ $current + 1 }} dari {{ count($steps) }}</span>
        </div>
        <ol class="grid gap-3 sm:grid-cols-5">
            @foreach($steps as $index => $step)
                <li class="flex items-center gap-3 rounded-md border px-3 py-2 sm:block sm:border-0 sm:p-0 sm:text-center"
                    @if($index === $current) aria-current="step" @endif>
                    <span class="grid h-9 w-9 shrink-0 place-items-center rounded-full text-sm font-semibold {{ $index <= $current ? 'bg-teal-500 text-white' : 'bg-slate-100 text-slate-600' }}">{{ $index + 1 }}</span>
                    <span class="text-xs leading-5 {{ $index === $current ? 'font-semibold text-slate-900' : 'font-medium text-slate-600' }} sm:mt-2 sm:block">{{ $step }}</span>
                </li>
            @endforeach
        </ol>
    </section>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        {{-- Form --}}
        <div class="lg:col-span-2 bg-white rounded-lg border border-slate-200">
            <div class="flex flex-col gap-3 border-b border-slate-100 px-6 py-4 sm:flex-row sm:items-center sm:justify-between">
                <h3 class="font-semibold text-slate-800">Formulir pelaporan semesteran</h3>
                <button type="button" @click="sigapToast('Simulasi unduh template LKS FEB', 'teal')" class="inline-flex min-h-11 items-center justify-center gap-2 rounded-md border border-teal-500 px-3 py-2 text-sm font-semibold text-teal-700 hover:bg-teal-50">
                    @include('partials.icon', ['name' => 'download', 'class' => 'w-4 h-4'])
                    Unduh Template LKS FEB (.docx)
                </button>
            </div>
            <div class="p-6 space-y-5">
                <div class="grid grid-cols-1 gap-5 sm:grid-cols-2">
                    <div>
                        <label class="block text-sm font-medium text-slate-700 mb-1.5">Semester LKS <span class="text-rose-500">*</span></label>
                        <select class="w-full rounded border border-slate-300 px-3 py-2 text-sm focus:border-teal-500 outline-none">
                            <option>Semester 5 (Ganjil 2025/2026)</option><option>Semester 4 (Genap 2024/2025)</option>
                        </select>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-slate-700 mb-1.5">Tanggal Submit <span class="text-rose-500">*</span></label>
                        <input type="date" class="w-full rounded border border-slate-300 px-3 py-2 text-sm focus:border-teal-500 outline-none">
                    </div>
                </div>
                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-1.5">IPK Semester Berjalan <span class="text-rose-500">*</span></label>
                    <input type="number" step="0.01" min="0" max="4" placeholder="Contoh: 3,92" class="w-full rounded border border-slate-300 px-3 py-2 text-sm focus:border-teal-500 outline-none sm:w-40">
                </div>
                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-1.5">Progres Tahapan Disertasi <span class="text-rose-500">*</span></label>
                    <textarea rows="4" placeholder="Uraikan kemajuan penulisan bab, publikasi prosiding/jurnal, dan bimbingan promotor…" class="w-full rounded border border-slate-300 px-3 py-2 text-sm focus:border-teal-500 outline-none"></textarea>
                </div>
                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-2">Berkas Gabungan (1 PDF, maks 15MB)</label>
                    <div class="rounded-lg bg-blue-50 border border-blue-100 p-3 mb-3 text-xs text-blue-800">
                        Gabungkan 4 dokumen dalam 1 PDF berurutan: (1) LKS bertanda tangan Promotor, (2) Transkrip/KHS, (3) Surat Keterangan Aktif, (4) Bukti Transfer BPP.
                    </div>
                    @include('partials.dropzone', ['label' => 'Unggah berkas gabungan PDF', 'hint' => 'PDF saja, maksimum 15 MB', 'maxMb' => 15])
                </div>
                <div class="flex justify-end gap-3 pt-2">
                    <button class="px-4 py-2 rounded border border-slate-300 text-sm font-medium text-slate-600">Simpan Draf</button>
                    <button type="button" @click="sigapToast('Simulasi submit: LKS menunggu review SDM', 'green')" class="px-5 py-2.5 rounded bg-teal-500 hover:bg-teal-600 text-white text-sm font-semibold inline-flex items-center gap-2 transition active:scale-[0.98]">
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
                @foreach($lks as $l)
                    <div class="px-6 py-4">
                        <div class="flex items-center justify-between gap-2">
                            <div class="text-sm font-medium text-slate-800">{{ $l['semester'] }}</div>
                            @include('partials.badge', ['label' => $l['status'], 'tone' => $statuses[$l['status']] ?? 'slate'])
                        </div>
                        <div class="text-xs text-slate-400 mt-1">Submit {{ $l['tanggal'] }} · IPK {{ number_format($l['ipk'],2) }}</div>
                        @if($l['status'] === 'LKS Approved')
                            <button class="mt-2 text-xs text-teal-600 font-semibold inline-flex items-center gap-1 hover:underline">
                                @include('partials.icon', ['name' => 'download', 'class' => 'w-3.5 h-3.5'])
                                Unduh LKS Disahkan
                            </button>
                        @endif
                    </div>
                @endforeach
            </div>
        </div>
    </div>
@endsection
