@extends('layouts.app')
@section('title', 'Penerbitan ST')
@section('breadcrumb', 'Surat Tugas / Penerbitan')

@section('content')
<div x-data="{ terbit: {} }">
    @include('partials.page-head', ['heading' => 'Penerbitan Surat Tugas', 'sub' => 'Terbitkan surat yang telah dinomori Sekdek — langsung tampil di akun dosen.'])

    @php
        // Siap terbit: sudah dinomori Sekdek tapi belum di-"Terbitkan" Admin SDM.
        $siap = [
            ['id' => 'ST-2026-0028', 'nomor' => 'FEB/SDM-ST/X/2026/045', 'judul' => 'Narasumber Kuliah Umum Kewirausahaan Digital', 'dosen' => 'Dr. (Cand.) Rangga Pratama'],
            ['id' => 'ST-2026-0041', 'nomor' => 'FEB/SDM-ST/X/2026/046', 'judul' => 'Tim Penelitian Hibah Internal: Digitalisasi UMKM', 'dosen' => 'Dr. (Cand.) Rangga Pratama'],
        ];
        $terbit = collect($st)->where('status','Selesai (Terbit)');
        // Index ST lengkap by id agar tombol Preview punya data surat utuh.
        $byId = collect($st)->keyBy('id');
    @endphp

    {{-- Siap Terbit --}}
    <div class="bg-white rounded-lg border border-slate-200 overflow-hidden mb-6">
        <div class="px-6 py-4 border-b border-slate-100 flex items-center gap-2">
            <h3 class="font-semibold text-slate-800">Siap Terbit</h3>
            <span class="text-xs text-slate-400">· sudah dinomori Sekdek</span>
        </div>
        <table class="w-full text-sm">
            <thead><tr class="bg-slate-50 text-left text-[11px] uppercase tracking-wider text-slate-500">
                <th class="px-6 py-3 font-semibold">Nomor Surat</th><th class="px-6 py-3 font-semibold">Judul</th>
                <th class="px-6 py-3 font-semibold">Dosen</th><th class="px-6 py-3 font-semibold">Status</th><th class="px-6 py-3 font-semibold text-right">Aksi</th>
            </tr></thead>
            <tbody class="divide-y divide-slate-50">
                @foreach($siap as $i => $row)
                    <tr class="hover:bg-slate-50/60">
                        <td class="px-6 py-3.5 font-medium text-slate-700 tnum">{{ $row['nomor'] }}</td>
                        <td class="px-6 py-3.5 text-slate-600 max-w-xs truncate">{{ $row['judul'] }}</td>
                        <td class="px-6 py-3.5 text-slate-600">{{ $row['dosen'] }}</td>
                        <td class="px-6 py-3.5">
                            <template x-if="terbit[{{ $i }}]"><span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-semibold bg-green-100 text-green-800">Terbit · Tampil di Dosen</span></template>
                            <template x-if="!terbit[{{ $i }}]"><span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-semibold bg-amber-100 text-amber-800">Siap Terbit</span></template>
                        </td>
                        <td class="px-6 py-3.5 text-right">
                            @php
                                // Gabungkan data ST lengkap (bila ada) dengan nomor dari antrean "siap terbit".
                                $full = ($byId[$row['id']] ?? [
                                    'id' => $row['id'], 'judul' => $row['judul'], 'dosen' => $row['dosen'],
                                    'prodi' => '', 'mitra' => '—', 'lokasi' => '—',
                                    'mulai' => '2026-10-16', 'selesai' => '2026-10-16',
                                    'anggota' => [], 'tanggal_terbit' => null,
                                ]);
                                $full = array_merge($full, ['nomor_surat' => $row['nomor']]);
                            @endphp
                            <div class="inline-flex items-center gap-2">
                                @include('partials.st-preview-modal', ['row' => $full, 'nomor' => $row['nomor'], 'trigger' => 'Preview'])
                                <button @click="terbit[{{ $i }}]=true; sigapToast('{{ $row['nomor'] }} diterbitkan — sekarang tampil di akun dosen', 'green')"
                                        :disabled="terbit[{{ $i }}]"
                                        class="px-3.5 py-1.5 rounded bg-teal-500 hover:bg-teal-600 text-white text-xs font-semibold inline-flex items-center gap-1.5 transition active:scale-[0.98] disabled:opacity-50 disabled:cursor-not-allowed">
                                    @include('partials.icon', ['name' => 'printer', 'class' => 'w-3.5 h-3.5'])
                                    <span x-text="terbit[{{ $i }}] ? 'Sudah Terbit' : 'Terbitkan'"></span>
                                </button>
                            </div>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    {{-- Sudah terbit + masa sanggah --}}
    <div class="bg-white rounded-lg border border-slate-200 overflow-hidden">
        <div class="px-6 py-4 border-b border-slate-100"><h3 class="font-semibold text-slate-800">Riwayat Terbit & Masa Sanggah</h3></div>
        <table class="w-full text-sm">
            <thead><tr class="bg-slate-50 text-left text-[11px] uppercase tracking-wider text-slate-500">
                <th class="px-6 py-3 font-semibold">Nomor Surat</th><th class="px-6 py-3 font-semibold">Judul</th>
                <th class="px-6 py-3 font-semibold">Dosen</th><th class="px-6 py-3 font-semibold">Tgl Terbit</th>
                <th class="px-6 py-3 font-semibold">Masa Sanggah</th><th class="px-6 py-3 font-semibold text-right">Aksi</th>
            </tr></thead>
            <tbody class="divide-y divide-slate-50">
                @foreach($terbit as $row)
                    <tr class="hover:bg-slate-50/60">
                        <td class="px-6 py-3.5 font-medium text-slate-700 tnum">{{ $row['nomor_surat'] }}</td>
                        <td class="px-6 py-3.5 text-slate-600 max-w-xs truncate">{{ $row['judul'] }}</td>
                        <td class="px-6 py-3.5 text-slate-600">{{ $row['dosen'] }}</td>
                        <td class="px-6 py-3.5 text-slate-500">{{ $row['tanggal_terbit'] }}</td>
                        <td class="px-6 py-3.5">@include('partials.badge', ['label' => 'Berakhir', 'tone' => 'slate'])</td>
                        <td class="px-6 py-3.5 text-right">
                            <div class="inline-flex items-center gap-3">
                                @include('partials.st-preview-modal', ['row' => $row, 'trigger' => 'Preview', 'compact' => true])
                                <button @click="sigapToast('Mengunduh PDF {{ $row['nomor_surat'] }}', 'teal')" class="text-teal-600 font-semibold hover:underline text-sm inline-flex items-center gap-1">
                                    @include('partials.icon', ['name' => 'download', 'class' => 'w-4 h-4']) PDF
                                </button>
                            </div>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection
