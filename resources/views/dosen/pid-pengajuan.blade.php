@extends('layouts.app')
@section('title', 'Pengajuan Studi Lanjut PID')
@section('breadcrumb', 'Studi PID / Pengajuan')

@section('content')
<div x-data="{
        lokasiStudi: 'dalam',
        akreditasiDiBawah: false,
        studiDimulai: false
    }">
    @include('partials.page-head', ['heading' => 'Pengajuan Studi Lanjut PID', 'sub' => 'Formulir pendaftaran studi lanjut doktoral & kelengkapan berkas.'])

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <div class="lg:col-span-2 bg-white rounded-lg border border-slate-200">
            <div class="px-6 py-4 border-b border-slate-100"><h3 class="font-semibold text-slate-800">Formulir Pendaftaran Studi S3</h3></div>
            <div class="p-6 space-y-5">

                {{-- Lokasi studi: dalam / luar negeri --}}
                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-2">Lokasi Studi</label>
                    <div class="flex gap-3 max-w-md">
                        <label class="flex-1 cursor-pointer">
                            <input type="radio" name="lokasi_studi" value="dalam" x-model="lokasiStudi" class="peer sr-only">
                            <div class="rounded-lg border-2 px-4 py-3 text-sm font-medium text-center transition peer-checked:border-teal-500 peer-checked:bg-teal-50 peer-checked:text-teal-700 border-slate-200 text-slate-600">Dalam Negeri</div>
                        </label>
                        <label class="flex-1 cursor-pointer">
                            <input type="radio" name="lokasi_studi" value="luar" x-model="lokasiStudi" class="peer sr-only">
                            <div class="rounded-lg border-2 px-4 py-3 text-sm font-medium text-center transition peer-checked:border-teal-500 peer-checked:bg-teal-50 peer-checked:text-teal-700 border-slate-200 text-slate-600">Luar Negeri</div>
                        </label>
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                    {{-- Universitas tujuan: input manual --}}
                    <div>
                        <label class="block text-sm font-medium text-slate-700 mb-1.5">Universitas Tujuan</label>
                        <input placeholder="Ketik nama universitas tujuan…"
                               class="w-full rounded border border-slate-300 px-3 py-2 text-sm focus:border-teal-500 focus:ring-2 focus:ring-teal-500/10 outline-none">
                        <p class="text-xs text-slate-400 mt-1" x-show="lokasiStudi==='luar'" x-cloak>cth: National University of Singapore, Monash University</p>
                        <p class="text-xs text-slate-400 mt-1" x-show="lokasiStudi==='dalam'">cth: Universitas Padjadjaran, Universitas Indonesia</p>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-slate-700 mb-1.5">Program Studi / Fokus Disertasi</label>
                        <input placeholder="cth: S3 Ilmu Manajemen" class="w-full rounded border border-slate-300 px-3 py-2 text-sm focus:border-teal-500 outline-none">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-slate-700 mb-1.5">Rencana Mulai Studi</label>
                        <input type="date" class="w-full rounded border border-slate-300 px-3 py-2 text-sm focus:border-teal-500 outline-none">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-slate-700 mb-1.5">Estimasi Durasi Studi</label>
                        <input placeholder="cth: 7 Semester" class="w-full rounded border border-slate-300 px-3 py-2 text-sm focus:border-teal-500 outline-none">
                    </div>
                </div>

                {{-- Dokumen wajib unggah --}}
                <div>
                    <div class="text-sm font-medium text-slate-700 mb-3">Berkas Pengajuan</div>
                    <div class="space-y-4">
                        {{-- 1. LoA --}}
                        <div class="rounded-lg border border-slate-200 p-4">
                            <div class="flex items-center justify-between mb-2">
                                <div class="text-sm font-medium text-slate-700">1. Letter of Acceptance (LoA) <span class="text-rose-500">*</span></div>
                            </div>
                            @include('partials.dropzone', ['label' => 'Unggah LoA dari universitas tujuan'])
                        </div>

                        {{-- 2. Pakta Integritas (+ template) --}}
                        <div class="rounded-lg border border-slate-200 p-4">
                            <div class="flex items-center justify-between mb-2">
                                <div class="text-sm font-medium text-slate-700">2. Pakta Integritas <span class="text-rose-500">*</span></div>
                                <button type="button" @click="sigapToast('Template Pakta Integritas diunduh', 'teal')"
                                        class="inline-flex items-center gap-1.5 text-xs font-semibold text-teal-600 hover:text-teal-700">
                                    @include('partials.icon', ['name' => 'download', 'class' => 'w-3.5 h-3.5']) Unduh Template
                                </button>
                            </div>
                            @include('partials.dropzone', ['label' => 'Unggah pakta integritas bertandatangan'])
                        </div>

                        {{-- 3. Surat Pernyataan (+ template) --}}
                        <div class="rounded-lg border border-slate-200 p-4">
                            <div class="flex items-center justify-between mb-2">
                                <div class="text-sm font-medium text-slate-700">3. Surat Pernyataan <span class="text-rose-500">*</span></div>
                                <button type="button" @click="sigapToast('Template Surat Pernyataan diunduh', 'teal')"
                                        class="inline-flex items-center gap-1.5 text-xs font-semibold text-teal-600 hover:text-teal-700">
                                    @include('partials.icon', ['name' => 'download', 'class' => 'w-3.5 h-3.5']) Unduh Template
                                </button>
                            </div>
                            @include('partials.dropzone', ['label' => 'Unggah surat pernyataan bertandatangan'])
                        </div>

                        {{-- 4. Surat Pernyataan Linearitas (+ template) --}}
                        <div class="rounded-lg border border-slate-200 p-4">
                            <div class="flex items-center justify-between mb-2">
                                <div class="text-sm font-medium text-slate-700">4. Surat Pernyataan Linearitas <span class="text-rose-500">*</span></div>
                                <button type="button" @click="sigapToast('Template Surat Pernyataan Linearitas diunduh', 'teal')"
                                        class="inline-flex items-center gap-1.5 text-xs font-semibold text-teal-600 hover:text-teal-700">
                                    @include('partials.icon', ['name' => 'download', 'class' => 'w-3.5 h-3.5']) Unduh Template
                                </button>
                            </div>
                            @include('partials.dropzone', ['label' => 'Unggah surat pernyataan linearitas keilmuan'])
                        </div>

                        {{-- 5. Bukti bayar BPP --}}
                        <div class="rounded-lg border border-slate-200 p-4">
                            <div class="text-sm font-medium text-slate-700 mb-2">5. Bukti Bayar BPP <span class="text-rose-500">*</span></div>
                            @include('partials.dropzone', ['label' => 'Unggah bukti pembayaran BPP'])
                        </div>

                        {{-- 6. Form Justifikasi (opsional, kondisional) --}}
                        <div class="rounded-lg border border-slate-200 p-4">
                            <label class="flex items-center gap-2 mb-2 cursor-pointer">
                                <input type="checkbox" x-model="akreditasiDiBawah" class="w-4 h-4 rounded text-teal-500 focus:ring-teal-500">
                                <span class="text-sm font-medium text-slate-700">Kampus tujuan berakreditasi di bawah Tel-U</span>
                            </label>
                            <div class="text-sm text-slate-500 mb-2">6. Form Justifikasi
                                <span x-show="akreditasiDiBawah" class="text-rose-500 font-medium" x-cloak>— wajib diisi</span>
                                <span x-show="!akreditasiDiBawah" class="text-slate-400">(opsional)</span>
                            </div>
                            @include('partials.dropzone', ['label' => 'Unggah form justifikasi'])
                        </div>
                    </div>
                </div>

                {{-- Checklist studi dimulai --}}
                <div class="rounded-lg bg-slate-50 border border-slate-200 p-4">
                    <label class="flex items-start gap-3 cursor-pointer">
                        <input type="checkbox" x-model="studiDimulai" class="w-4 h-4 rounded text-teal-500 focus:ring-teal-500 mt-0.5">
                        <span>
                            <span class="block text-sm font-medium text-slate-700">Studi lanjut sudah dimulai</span>
                            <span class="block text-xs text-slate-500 mt-0.5">Centang jika Anda telah resmi memulai perkuliahan S3. Kartu "Studi Aktif" baru akan muncul setelah dicentang.</span>
                        </span>
                    </label>
                </div>

                <div class="flex justify-end">
                    <button type="button" @click="sigapToast('Pengajuan PID terkirim — menunggu validasi Admin SDM', 'green')"
                            class="px-5 py-2.5 rounded bg-teal-500 hover:bg-teal-600 text-white text-sm font-semibold inline-flex items-center gap-2 transition active:scale-[0.98]">
                        @include('partials.icon', ['name' => 'send', 'class' => 'w-4 h-4'])
                        Ajukan Pendaftaran
                    </button>
                </div>
            </div>
        </div>

        {{-- Side panel --}}
        <div class="space-y-6">
            {{-- Studi Aktif — hanya muncul jika studiDimulai dicentang --}}
            <div x-show="studiDimulai" x-cloak x-transition class="bg-white rounded-lg border border-slate-200 p-6">
                <div class="flex items-center justify-between">
                    <h3 class="font-semibold text-slate-800">Studi Aktif</h3>
                    @include('partials.badge', ['label' => 'Aktif Studi', 'tone' => 'green'])
                </div>
                <dl class="mt-4 space-y-3 text-sm">
                    <div><dt class="text-slate-400">Universitas</dt><dd class="font-medium text-slate-800">{{ $pid['universitas'] }}</dd></div>
                    <div><dt class="text-slate-400">Program Studi</dt><dd class="font-medium text-slate-800">{{ $pid['prodi_tujuan'] }}</dd></div>
                    <div><dt class="text-slate-400">Estimasi Durasi</dt><dd class="font-medium text-slate-800">{{ $pid['durasi'] }}</dd></div>
                    <div><dt class="text-slate-400">SK Studi Lanjut</dt><dd class="font-medium text-slate-800 tnum">{{ $pid['sk_beasiswa'] }}</dd></div>
                </dl>
            </div>

            {{-- Placeholder saat studi belum dimulai --}}
            <div x-show="!studiDimulai" class="bg-white rounded-lg border border-dashed border-slate-300 p-6 text-center">
                @include('partials.icon', ['name' => 'cap', 'class' => 'w-8 h-8 text-slate-300 mx-auto'])
                <div class="text-sm text-slate-500 mt-2">Belum ada studi aktif</div>
                <div class="text-xs text-slate-400 mt-1">Centang "Studi lanjut sudah dimulai" untuk menampilkan status studi aktif.</div>
            </div>

            <div class="bg-white rounded-lg border border-slate-200 p-6">
                <h3 class="font-semibold text-slate-800 mb-2">Riwayat Amandemen</h3>
                <p class="text-sm text-slate-400">Belum ada perpanjangan masa studi.</p>
            </div>
        </div>
    </div>
</div>
@endsection
