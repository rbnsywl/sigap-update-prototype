@extends('layouts.app')
@section('title', 'Laporan Kemajuan Studi (LKS)')
@section('breadcrumb', 'Studi PID / Laporan LKS')

@section('content')
    @include('partials.page-head', ['heading' => 'Laporan Kemajuan Studi', 'sub' => 'Laporan capaian akademik semesteran bagi penerima beasiswa PID.'])

    {{-- Step tracker --}}
    <div class="bg-white rounded-lg border border-slate-200 p-6 mb-6">
        @php $steps = ['Semester Aktif','Penyusunan Proposal','Seminar Hasil','Ujian Tertutup','Disertasi / Terbuka']; $current = 1; @endphp
        <div class="flex items-center justify-between">
            @foreach($steps as $i => $s)
                <div class="flex items-center {{ !$loop->last ? 'flex-1' : '' }}">
                    <div class="flex flex-col items-center gap-2">
                        <div class="w-9 h-9 rounded-full grid place-items-center text-sm font-semibold {{ $i <= $current ? 'bg-teal-500 text-white' : 'bg-slate-100 text-slate-400' }}">{{ $i+1 }}</div>
                        <span class="text-[11px] text-center max-w-[90px] {{ $i <= $current ? 'text-slate-700 font-medium' : 'text-slate-400' }}">{{ $s }}</span>
                    </div>
                    @if(!$loop->last)<div class="flex-1 h-0.5 mx-2 -mt-6 {{ $i < $current ? 'bg-teal-500' : 'bg-slate-200' }}"></div>@endif
                </div>
            @endforeach
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        {{-- Form --}}
        <div class="lg:col-span-2 bg-white rounded-lg border border-slate-200">
            <div class="px-6 py-4 border-b border-slate-100 flex items-center justify-between">
                <h3 class="font-semibold text-slate-800">Formulir Pelaporan Semesteran</h3>
                <button class="inline-flex items-center gap-2 px-3 py-1.5 rounded border border-teal-500 text-teal-600 text-sm font-semibold hover:bg-teal-50">
                    @include('partials.icon', ['name' => 'download', 'class' => 'w-4 h-4'])
                    Unduh Template LKS FEB (.docx)
                </button>
            </div>
            <div class="p-6 space-y-5">
                <div class="grid grid-cols-2 gap-5">
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
                    <input type="number" step="0.01" min="0" max="4" placeholder="cth: 3.92" class="w-40 rounded border border-slate-300 px-3 py-2 text-sm focus:border-teal-500 outline-none">
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
                    @include('partials.dropzone', ['label' => 'Unggah berkas gabungan PDF', 'hint' => 'PDF saja · Maks 15MB'])
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
