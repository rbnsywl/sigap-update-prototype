@extends('layouts.app')
@section('title', 'Penyetaraan Ijazah S3')
@section('breadcrumb', 'Studi Non-PID / Penyetaraan S3')

@section('content')
    @include('partials.page-head', ['heading' => 'Penyetaraan Ijazah S3 Non-PID', 'sub' => 'Ajukan penilaian linearitas keilmuan untuk ijazah S3 mandiri/eksternal.'])

    {{-- Step tracker --}}
    <div class="bg-white rounded-lg border border-slate-200 p-6 mb-6">
        @php $steps = ['Submit Dokumen','Validasi Admin SDM','Penilaian Internal Asesor','Laporan ke SDM Pusat','Selesai']; $current = 0; @endphp
        <div class="flex items-center justify-between">
            @foreach($steps as $i => $s)
                <div class="flex items-center {{ !$loop->last ? 'flex-1' : '' }}">
                    <div class="flex flex-col items-center gap-2">
                        <div class="w-9 h-9 rounded-full grid place-items-center text-sm font-semibold {{ $i <= $current ? 'bg-teal-500 text-white' : 'bg-slate-100 text-slate-400' }}">{{ $i+1 }}</div>
                        <span class="text-[11px] text-center max-w-[100px] {{ $i <= $current ? 'text-slate-700 font-medium' : 'text-slate-400' }}">{{ $s }}</span>
                    </div>
                    @if(!$loop->last)<div class="flex-1 h-0.5 mx-2 -mt-6 {{ $i < $current ? 'bg-teal-500' : 'bg-slate-200' }}"></div>@endif
                </div>
            @endforeach
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-6">
        {{-- Left: templates --}}
        <div class="bg-white rounded-lg border border-slate-200">
            <div class="px-6 py-4 border-b border-slate-100"><h3 class="font-semibold text-slate-800">1 · Template & Panduan Dokumen</h3></div>
            <div class="p-6 space-y-3">
                @foreach(['Format Roadmap Penelitian (.docx)','Format Lembar Pengesahan (.docx)','Format Pernyataan Linearitas Keilmuan (.pdf)'] as $t)
                    <button class="w-full flex items-center gap-3 p-3 rounded-lg border border-slate-200 hover:border-teal-400 hover:bg-teal-50/40 transition text-left">
                        <span class="w-9 h-9 rounded-lg bg-teal-50 text-teal-600 grid place-items-center shrink-0">@include('partials.icon', ['name' => 'file', 'class' => 'w-4 h-4'])</span>
                        <span class="flex-1 text-sm text-slate-700">{{ $t }}</span>
                        @include('partials.icon', ['name' => 'download', 'class' => 'w-4 h-4 text-slate-400'])
                    </button>
                @endforeach
                <div class="flex items-start gap-2 text-xs text-amber-800 bg-amber-50 border border-amber-100 rounded-lg px-3 py-3 mt-2">
                    @include('partials.icon', ['name' => 'help', 'class' => 'w-4 h-4 shrink-0 mt-0.5'])
                    <span>Pastikan seluruh dokumen telah ditandatangani oleh pihak terkait sebelum digabungkan menjadi satu berkas PDF final.</span>
                </div>
            </div>
        </div>

        {{-- Right: upload --}}
        <div class="bg-white rounded-lg border border-slate-200">
            <div class="px-6 py-4 border-b border-slate-100"><h3 class="font-semibold text-slate-800">2 · Upload Berkas Gabungan</h3></div>
            <div class="p-6 space-y-4">
                <div class="rounded-lg bg-blue-50 border border-blue-100 p-3 text-xs text-blue-800">
                    Gabungkan berurutan dalam 1 PDF: Ijazah & Transkrip S3, Ringkasan Disertasi, Roadmap Penelitian, Lembar Pengesahan, Pernyataan Linearitas.
                </div>
                @include('partials.dropzone', ['label' => 'Unggah 1 File PDF Gabungan', 'hint' => 'PDF saja · Maks 10MB'])
                <button class="w-full px-5 py-2.5 rounded bg-teal-500 hover:bg-teal-600 text-white text-sm font-semibold inline-flex items-center justify-center gap-2">
                    @include('partials.icon', ['name' => 'send', 'class' => 'w-4 h-4'])
                    Kirim ke Admin SDM
                </button>
            </div>
        </div>
    </div>

    {{-- History --}}
    <div class="bg-white rounded-lg border border-slate-200 overflow-hidden">
        <div class="px-6 py-4 border-b border-slate-100"><h3 class="font-semibold text-slate-800">Riwayat Pengajuan</h3></div>
        {{-- Revision highlight box --}}
        @php $revisi = collect($rows)->firstWhere('status','Perlu Revisi'); @endphp
        @if($revisi)
            <div class="mx-6 mt-4 flex items-start gap-3 bg-yellow-50 border border-yellow-200 rounded-lg px-4 py-3">
                @include('partials.icon', ['name' => 'help', 'class' => 'w-5 h-5 text-yellow-600 shrink-0 mt-0.5'])
                <div>
                    <div class="text-sm font-medium text-yellow-800">Catatan Admin SDM — Perlu Revisi</div>
                    <div class="text-sm text-yellow-700 mt-0.5">{{ $revisi['catatan_admin'] }}</div>
                </div>
            </div>
        @endif
        <table class="w-full text-sm mt-2">
            <thead><tr class="bg-slate-50 text-left text-[11px] uppercase tracking-wider text-slate-500">
                <th class="px-6 py-3 font-semibold">Tgl Submit</th>
                <th class="px-6 py-3 font-semibold">ID Pengajuan</th>
                <th class="px-6 py-3 font-semibold">Status</th>
                <th class="px-6 py-3 font-semibold text-right">Aksi</th>
            </tr></thead>
            <tbody class="divide-y divide-slate-50">
                @foreach($rows as $r)
                    <tr class="hover:bg-slate-50/60">
                        <td class="px-6 py-3.5 text-slate-500">{{ $r['tanggal'] }}</td>
                        <td class="px-6 py-3.5 font-medium text-slate-700 tnum">{{ $r['id'] }}</td>
                        <td class="px-6 py-3.5">@include('partials.badge', ['label' => $r['status'], 'tone' => $statuses[$r['status']] ?? 'slate'])</td>
                        <td class="px-6 py-3.5 text-right"><button class="text-teal-600 font-semibold hover:underline text-sm">Lihat Detail</button></td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endsection
