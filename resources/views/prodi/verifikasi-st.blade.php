@extends('layouts.app')
@section('title', 'Verifikasi ST Masuk')
@section('breadcrumb', 'Surat Tugas / Verifikasi')

@section('content')
<div x-data="{ sel: 1, modal:false, status: {} }">
    @include('partials.page-head', ['heading' => 'Verifikasi Berkas Surat Tugas', 'sub' => 'Periksa kelengkapan berkas & beban SKS sebelum diteruskan ke Kaprodi.'])

    <div class="grid grid-cols-1 lg:grid-cols-5 gap-6">
        {{-- Queue list --}}
        <div class="lg:col-span-2 bg-white rounded-lg border border-slate-200 overflow-hidden self-start">
            <div class="px-5 py-3.5 border-b border-slate-100 font-semibold text-slate-800 text-sm">Antrean Masuk ({{ count($st) }})</div>
            <div class="divide-y divide-slate-50 max-h-[560px] overflow-y-auto">
                @foreach($st as $i => $row)
                    <button @click="sel={{ $i }}" class="w-full text-left px-5 py-3.5 flex items-start gap-3 transition" :class="sel==={{ $i }} ? 'bg-teal-50' : 'hover:bg-slate-50'">
                        <div class="flex-1 min-w-0">
                            <div class="flex items-center gap-2 mb-1">
                                @include('partials.badge', ['label' => $row['tipe'], 'tone' => $row['tipe']==='Kelompok'?'purple':'blue'])
                                <span class="text-xs text-slate-400 tnum">{{ $row['id'] }}</span>
                            </div>
                            <div class="text-sm font-medium text-slate-800 truncate">{{ $row['judul'] }}</div>
                            <div class="text-xs text-slate-400 mt-0.5">{{ $row['dosen'] }} · {{ $row['tanggal_masuk'] }}</div>
                        </div>
                    </button>
                @endforeach
            </div>
        </div>

        {{-- Detail work area --}}
        <div class="lg:col-span-3 space-y-6">
            @foreach($st as $i => $row)
                <div x-show="sel==={{ $i }}" x-cloak class="bg-white rounded-lg border border-slate-200">
                    <div class="px-6 py-4 border-b border-slate-100 flex items-center justify-between">
                        <h3 class="font-semibold text-slate-800">Detail Verifikasi</h3>
                        <div class="flex items-center gap-2">
                            {{-- Badge status reaktif (berubah setelah aksi) --}}
                            <template x-if="status[{{ $i }}]">
                                <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-semibold"
                                      :class="status[{{ $i }}]==='diteruskan' ? 'bg-blue-100 text-blue-800' : 'bg-rose-100 text-rose-800'"
                                      x-text="status[{{ $i }}]==='diteruskan' ? 'Menunggu Approval Kaprodi' : 'Perlu Revisi Dosen'"></span>
                            </template>
                            @include('partials.badge', ['label' => $row['tipe'], 'tone' => $row['tipe']==='Kelompok'?'purple':'blue'])
                        </div>
                    </div>
                    <div class="p-6 space-y-5">
                        <div class="text-base font-semibold text-slate-900">{{ $row['judul'] }}</div>
                        <dl class="grid grid-cols-2 gap-x-6 gap-y-3 text-sm">
                            <div><dt class="text-slate-400">Pemohon</dt><dd class="font-medium text-slate-800">{{ $row['dosen'] }}</dd></div>
                            <div><dt class="text-slate-400">Kategori</dt><dd class="font-medium text-slate-800">{{ $row['kategori'] }}</dd></div>
                            <div><dt class="text-slate-400">Mitra</dt><dd class="font-medium text-slate-800">{{ $row['mitra'] }}</dd></div>
                            <div><dt class="text-slate-400">Periode</dt><dd class="font-medium text-slate-800">{{ $row['mulai'] }} s/d {{ $row['selesai'] }}</dd></div>
                        </dl>

                        {{-- Evidence yang diunggah dosen — kini bisa dilihat Staf Prodi --}}
                        @include('partials.evidence', ['title' => 'Berkas Pendukung dari Dosen', 'files' => \App\Support\MockData::evidenceSuratTugas($row['id'])])

                        @if(count($row['anggota']))
                            <div>
                                <div class="text-sm font-medium text-slate-700 mb-2">Anggota Tim (cek beban SKS)</div>
                                <div class="rounded-lg border border-slate-200 divide-y divide-slate-50">
                                    @foreach($row['anggota'] as $a)
                                        <div class="px-4 py-2.5 flex items-center justify-between text-sm">
                                            <div><span class="font-medium text-slate-800">{{ $a['nama'] }}</span> <span class="text-slate-400">· {{ $a['prodi'] }}</span></div>
                                            @include('partials.badge', ['label' => $a['peran'], 'tone' => $a['peran']==='Ketua'?'teal':'slate'])
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        @endif

                        {{-- Checklist --}}
                        <div>
                            <div class="text-sm font-medium text-slate-700 mb-2">Daftar Periksa Berkas</div>
                            <div class="space-y-2">
                                @foreach(['Kesesuaian tanggal dengan kalender akademik','Keabsahan surat undangan / penyelenggara','Kelayakan anggota tim yang diajukan'] as $c)
                                    <label class="flex items-center gap-3 p-3 rounded-lg border border-slate-200 cursor-pointer hover:bg-slate-50">
                                        <input type="checkbox" class="w-4 h-4 rounded text-teal-500 focus:ring-teal-500">
                                        <span class="text-sm text-slate-700">{{ $c }}</span>
                                    </label>
                                @endforeach
                            </div>
                        </div>

                        <div class="flex items-center justify-end gap-3 pt-2">
                            <button @click="modal=true" class="px-4 py-2 rounded border border-rose-300 text-rose-600 text-sm font-semibold hover:bg-rose-50">Kembalikan Revisi ke Dosen</button>
                            <button @click="status[{{ $i }}]='diteruskan'; sigapToast('{{ $row['id'] }} diteruskan ke Kaprodi', 'green')"
                                    class="px-5 py-2.5 rounded bg-teal-500 hover:bg-teal-600 text-white text-sm font-semibold inline-flex items-center gap-2 transition active:scale-[0.98]">
                                @include('partials.icon', ['name' => 'check', 'class' => 'w-4 h-4'])
                                Teruskan ke Kaprodi
                            </button>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>

    {{-- Return modal --}}
    <div x-show="modal" x-cloak class="fixed inset-0 z-50 grid place-items-center p-4 bg-black/40" @click.self="modal=false">
        <div class="bg-white rounded-xl w-full max-w-md shadow-xl">
            <div class="px-6 py-4 border-b border-slate-100 flex items-center justify-between">
                <h3 class="font-semibold text-slate-800">Kembalikan untuk Revisi</h3>
                <button @click="modal=false" class="text-slate-400">@include('partials.icon', ['name' => 'x', 'class' => 'w-5 h-5'])</button>
            </div>
            <div class="p-6">
                <label class="block text-sm font-medium text-slate-700 mb-1.5">Catatan Perbaikan <span class="text-rose-500">*</span></label>
                <textarea rows="4" class="w-full rounded border border-slate-300 px-3 py-2 text-sm focus:border-teal-500 outline-none" placeholder="Wajib diisi — jelaskan apa yang perlu diperbaiki…"></textarea>
            </div>
            <div class="px-6 py-4 border-t border-slate-100 flex justify-end gap-3">
                <button @click="modal=false" class="px-4 py-2 rounded border border-slate-300 text-sm font-medium text-slate-600">Batal</button>
                <button @click="status[sel]='revisi'; modal=false; sigapToast('Pengajuan dikembalikan ke dosen untuk revisi', 'rose')" class="px-4 py-2 rounded bg-rose-500 hover:bg-rose-600 text-white text-sm font-semibold">Kirim ke Dosen</button>
            </div>
        </div>
    </div>
</div>
@endsection
