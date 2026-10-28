@extends('layouts.app')
@section('title', 'Riwayat & Status Surat Tugas')
@section('breadcrumb', 'Surat Tugas / Riwayat')

@section('content')
    @php
        // Post-publish revision window demo: ST-2026-0028 published today → 3-day window active.
        $published = collect($st)->firstWhere('id', 'ST-2026-0028');
    @endphp

    {{-- Published doc card with revision countdown --}}
    @if($published)
        <div x-data="{
                terbit: new Date('{{ $published['tanggal_terbit'] }}'),
                get sisaHari(){ const ms=(this.terbit.getTime()+3*864e5)-Date.now(); return Math.ceil(ms/864e5); },
                get bisaRevisi(){ return this.sisaHari>0; },
                modal:false
             }" class="bg-white rounded-lg border border-slate-200 mb-6 overflow-hidden">
            <div class="px-6 py-4 border-b border-slate-100 flex items-center justify-between">
                <h3 class="font-semibold text-slate-800">Surat Tugas Terbaru Terbit</h3>
                @include('partials.badge', ['label' => 'Selesai (Terbit)', 'tone' => 'green'])
            </div>
            <div class="p-6 grid grid-cols-1 lg:grid-cols-3 gap-6">
                <div class="lg:col-span-2">
                    <div class="text-lg font-semibold text-slate-900">{{ $published['judul'] }}</div>
                    <dl class="mt-4 grid grid-cols-2 gap-x-6 gap-y-3 text-sm">
                        <div><dt class="text-slate-400">Nomor Surat</dt><dd class="font-medium text-slate-800 tnum">{{ $published['nomor_surat'] }}</dd></div>
                        <div><dt class="text-slate-400">Tanggal Terbit</dt><dd class="font-medium text-slate-800">{{ $published['tanggal_terbit'] }}</dd></div>
                        <div><dt class="text-slate-400">Institusi Mitra</dt><dd class="font-medium text-slate-800">{{ $published['mitra'] }}</dd></div>
                        <div><dt class="text-slate-400">Tanda Tangan</dt><dd class="font-medium text-teal-600 inline-flex items-center gap-1">BSrE Verified ✓</dd></div>
                    </dl>
                    <button class="mt-5 inline-flex items-center gap-2 px-4 py-2 rounded bg-teal-500 hover:bg-teal-600 text-white text-sm font-semibold transition">
                        @include('partials.icon', ['name' => 'download', 'class' => 'w-4 h-4'])
                        Unduh Surat Tugas Resmi (PDF)
                    </button>
                </div>

                {{-- Revision window --}}
                <div class="rounded-lg border p-4" :class="bisaRevisi ? 'bg-amber-50 border-amber-200' : 'bg-slate-50 border-slate-200'">
                    <div class="flex items-center gap-2 text-sm font-medium" :class="bisaRevisi ? 'text-amber-800' : 'text-slate-500'">
                        @include('partials.icon', ['name' => 'clock', 'class' => 'w-4 h-4'])
                        Masa Sanggah Revisi
                    </div>
                    <p class="text-xs mt-2" :class="bisaRevisi ? 'text-amber-700' : 'text-slate-500'">
                        <template x-if="bisaRevisi">
                            <span>Tersisa <b x-text="sisaHari"></b> hari kerja untuk mengajukan revisi mandiri.</span>
                        </template>
                        <template x-if="!bisaRevisi">
                            <span>Masa sanggah telah berakhir.</span>
                        </template>
                    </p>
                    <button @click="bisaRevisi && (modal=true)" :disabled="!bisaRevisi"
                            :title="bisaRevisi ? '' : 'Masa sanggah revisi mandiri telah berakhir. Silakan hubungi Admin SDM secara langsung'"
                            class="mt-3 w-full px-3 py-2 rounded text-sm font-semibold transition"
                            :class="bisaRevisi ? 'bg-amber-500 hover:bg-amber-600 text-white' : 'bg-slate-200 text-slate-400 cursor-not-allowed'">
                        Ajukan Revisi Surat
                    </button>
                </div>
            </div>

            {{-- Revision modal --}}
            <div x-show="modal" x-cloak class="fixed inset-0 z-50 grid place-items-center p-4 bg-black/40" @click.self="modal=false">
                <div class="bg-white rounded-xl w-full max-w-lg shadow-xl" x-transition>
                    <div class="px-6 py-4 border-b border-slate-100 flex items-center justify-between">
                        <h3 class="font-semibold text-slate-800">Ajukan Revisi Surat Tugas</h3>
                        <button @click="modal=false" class="text-slate-400 hover:text-slate-600">@include('partials.icon',['name'=>'x','class'=>'w-5 h-5'])</button>
                    </div>
                    <div class="p-6 space-y-4">
                        <div>
                            <label class="block text-sm font-medium text-slate-700 mb-1.5">Bagian yang Direvisi</label>
                            <select class="w-full rounded border border-slate-300 px-3 py-2 text-sm focus:border-teal-500 outline-none">
                                <option>Kesalahan Penulisan Gelar/Nama</option><option>Tanggal Kegiatan</option><option>Judul Kegiatan</option><option>Anggota Tim</option>
                            </select>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-slate-700 mb-1.5">Alasan Perubahan <span class="text-rose-500">*</span></label>
                            <textarea rows="3" class="w-full rounded border border-slate-300 px-3 py-2 text-sm focus:border-teal-500 outline-none" placeholder="Jelaskan alasan revisi…"></textarea>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-slate-700 mb-2">Dokumen Pendukung (Opsional)</label>
                            @include('partials.dropzone', ['label' => 'Unggah dokumen pendukung'])
                        </div>
                    </div>
                    <div class="px-6 py-4 border-t border-slate-100 flex justify-end gap-3">
                        <button @click="modal=false" class="px-4 py-2 rounded border border-slate-300 text-sm font-medium text-slate-600">Batal</button>
                        <button @click="modal=false" class="px-4 py-2 rounded bg-teal-500 hover:bg-teal-600 text-white text-sm font-semibold">Kirim Revisi</button>
                    </div>
                </div>
            </div>
        </div>
    @endif

    {{-- History table --}}
    <div class="bg-white rounded-lg border border-slate-200 overflow-hidden">
        <div class="px-6 py-4 border-b border-slate-100 flex items-center justify-between">
            <h3 class="font-semibold text-slate-800">Riwayat Pengajuan</h3>
            <input placeholder="Cari…" class="rounded border border-slate-300 px-3 py-1.5 text-sm w-48 focus:border-teal-500 outline-none">
        </div>
        <table class="w-full text-sm">
            <thead>
                <tr class="bg-slate-50 text-left text-[11px] uppercase tracking-wider text-slate-500">
                    <th class="px-6 py-3 font-semibold">No. Tiket</th>
                    <th class="px-6 py-3 font-semibold">Judul Kegiatan</th>
                    <th class="px-6 py-3 font-semibold">Tipe</th>
                    <th class="px-6 py-3 font-semibold">Tgl Masuk</th>
                    <th class="px-6 py-3 font-semibold">Status</th>
                    <th class="px-6 py-3 font-semibold text-right">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-50">
                @foreach($st as $row)
                    <tr class="hover:bg-slate-50/60">
                        <td class="px-6 py-3.5 font-medium text-slate-700 tnum">{{ $row['id'] }}</td>
                        <td class="px-6 py-3.5 text-slate-600 max-w-xs truncate">{{ $row['judul'] }}</td>
                        <td class="px-6 py-3.5">
                            @include('partials.badge', ['label' => $row['tipe'], 'tone' => $row['tipe']==='Kelompok'?'purple':'blue'])
                        </td>
                        <td class="px-6 py-3.5 text-slate-500">{{ $row['tanggal_masuk'] }}</td>
                        <td class="px-6 py-3.5">@include('partials.badge', ['label' => $row['status'], 'tone' => $statuses[$row['status']] ?? 'slate'])</td>
                        <td class="px-6 py-3.5 text-right">
                            @include('partials.st-preview-modal', ['row' => $row, 'trigger' => 'Lihat Detail', 'compact' => true])
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endsection
