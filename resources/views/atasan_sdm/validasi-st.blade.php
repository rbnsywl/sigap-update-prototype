@extends('layouts.app')
@section('title', 'Validasi Surat Tugas')
@section('breadcrumb', 'Validasi / Surat Tugas')

@section('content')
<div x-data="{ sel:2, status:{} }">
    @include('partials.page-head', ['heading' => 'Validasi Surat Tugas (Manajerial)', 'sub' => 'Review kelayakan draf ST sebelum diteruskan ke Sekdek untuk penomoran.'])
    <div class="grid grid-cols-1 xl:grid-cols-4 gap-6">
        <div class="xl:col-span-1 bg-white rounded-lg border border-slate-200 overflow-hidden self-start">
            <div class="px-5 py-3.5 border-b border-slate-100 font-semibold text-slate-800 text-sm">Draf Menunggu Validasi</div>
            <div class="divide-y divide-slate-50">
                @foreach($st as $i => $row)
                    <button @click="sel={{ $i }}" class="w-full text-left px-5 py-3.5 transition" :class="sel==={{ $i }}?'bg-teal-50':'hover:bg-slate-50'">
                        <div class="text-sm font-medium text-slate-800 truncate">{{ $row['judul'] }}</div>
                        <div class="text-xs text-slate-400 mt-0.5">{{ $row['id'] }} · {{ $row['dosen'] }}</div>
                    </button>
                @endforeach
            </div>
        </div>
        <div class="xl:col-span-3">
            @foreach($st as $i => $row)
                <div x-show="sel==={{ $i }}" x-cloak class="bg-white rounded-lg border border-slate-200">
                    <div class="px-6 py-4 border-b border-slate-100 flex items-center justify-between">
                        <h3 class="font-semibold text-slate-800">Validasi Kepatuhan Regulasi</h3>
                        <template x-if="status[{{ $i }}]">
                            <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-semibold"
                                  :class="status[{{ $i }}]==='valid' ? 'bg-indigo-100 text-indigo-800' : 'bg-rose-100 text-rose-800'"
                                  x-text="status[{{ $i }}]==='valid' ? 'Menunggu Penomoran Sekdek' : 'Dikembalikan ke Admin SDM'"></span>
                        </template>
                    </div>
                    <div class="p-6 space-y-6">
                        {{-- Ringkasan kegiatan --}}
                        <div>
                            <div class="text-base font-semibold text-slate-900">{{ $row['judul'] }}</div>
                            <dl class="grid grid-cols-2 gap-x-6 gap-y-3 text-sm mt-3">
                                <div><dt class="text-slate-400">Pemohon</dt><dd class="font-medium text-slate-800">{{ $row['dosen'] }}</dd></div>
                                <div><dt class="text-slate-400">Program Studi</dt><dd class="font-medium text-slate-800">{{ $row['prodi'] }}</dd></div>
                                <div><dt class="text-slate-400">Kategori Tridharma</dt><dd class="font-medium text-slate-800">{{ $row['kategori'] }}</dd></div>
                                <div><dt class="text-slate-400">Penyelenggara</dt><dd class="font-medium text-slate-800">{{ $row['mitra'] }}</dd></div>
                                <div><dt class="text-slate-400">Tempat</dt><dd class="font-medium text-slate-800">{{ $row['lokasi'] }}</dd></div>
                                <div><dt class="text-slate-400">Periode</dt><dd class="font-medium text-slate-800">{{ $row['mulai'] }} s/d {{ $row['selesai'] }}</dd></div>
                            </dl>
                        </div>

                        {{-- Jejak proses sebelumnya --}}
                        <div class="rounded-lg bg-slate-50 border border-slate-200 p-4">
                            <div class="text-xs font-semibold text-slate-500 uppercase tracking-wide mb-3">Jejak Persetujuan Sebelumnya</div>
                            <div class="space-y-2">
                                @foreach([['Verifikasi Staf Prodi','Siti Nurhaliza','2026-10-20'],['Approval Kaprodi','Dr. Bambang Wijaya','2026-10-21'],['Drafting Admin SDM','Dewi Anggraini','2026-10-22']] as [$t,$by,$tgl])
                                    <div class="flex items-center gap-3 text-sm">
                                        <span class="w-6 h-6 rounded-full grid place-items-center shrink-0 bg-green-100 text-green-600">@include('partials.icon', ['name' => 'check', 'class' => 'w-3.5 h-3.5'])</span>
                                        <span class="text-slate-700">{{ $t }}</span>
                                        <span class="text-slate-400 text-xs ml-auto">{{ $by }} · {{ $tgl }}</span>
                                    </div>
                                @endforeach
                            </div>
                        </div>

                        {{-- Preview draf A4 (dari Admin SDM) --}}
                        <div>
                            <div class="flex items-center justify-between mb-2">
                                <span class="text-sm font-medium text-slate-700">Draf Surat Tugas (dari Admin SDM)</span>
                                <button @click="sigapPreview('Draf_ST_{{ $row['id'] }}.pdf', 'Format A4 · Kop FEB', [])" class="text-xs text-teal-600 font-semibold inline-flex items-center gap-1 hover:underline">
                                    @include('partials.icon', ['name' => 'eye', 'class' => 'w-3.5 h-3.5']) Preview penuh
                                </button>
                            </div>
                            <div class="rounded-lg border border-slate-200 bg-slate-100 p-4 overflow-hidden" style="max-height:360px; overflow-y:auto;">
                                <div style="transform:scale(0.52); transform-origin:top center; margin-bottom:-520px;">
                                    @include('partials.st-letter', ['row' => $row])
                                </div>
                            </div>
                        </div>

                        {{-- Checklist kepatuhan --}}
                        <div>
                            <div class="text-sm font-medium text-slate-700 mb-2">Checklist Kepatuhan Manajerial</div>
                            <div class="space-y-2">
                                @foreach(['Beban kerja dosen sesuai regulasi kepegawaian','Format surat sesuai template resmi FEB','Tidak ada konflik penugasan lain pada periode sama','Kategori tridharma relevan & dapat dipertanggungjawabkan'] as $c)
                                    <label class="flex items-center gap-3 p-3 rounded-lg border border-slate-200 cursor-pointer hover:bg-slate-50">
                                        <input type="checkbox" class="w-4 h-4 rounded text-teal-500 focus:ring-teal-500"><span class="text-sm text-slate-700">{{ $c }}</span>
                                    </label>
                                @endforeach
                            </div>
                        </div>

                        {{-- Catatan --}}
                        <div>
                            <label class="block text-sm font-medium text-slate-700 mb-1.5">Catatan Validasi (opsional)</label>
                            <textarea rows="2" class="w-full rounded border border-slate-300 px-3 py-2 text-sm focus:border-teal-500 outline-none" placeholder="Catatan untuk Admin SDM / Sekdek…"></textarea>
                        </div>

                        <div class="flex items-center justify-end gap-3">
                            <button @click="status[{{ $i }}]='kembali'; sigapToast('{{ $row['id'] }} dikembalikan ke Admin SDM', 'rose')" class="px-4 py-2 rounded border border-rose-300 text-rose-600 text-sm font-semibold hover:bg-rose-50">Kembalikan ke Admin SDM</button>
                            <button @click="status[{{ $i }}]='valid'; sigapToast('{{ $row['id'] }} tervalidasi — diajukan ke Sekdek untuk penomoran', 'green')"
                                    class="px-5 py-2.5 rounded bg-teal-500 hover:bg-teal-600 text-white text-sm font-semibold inline-flex items-center gap-2 transition active:scale-[0.98]">
                                @include('partials.icon', ['name' => 'shield', 'class' => 'w-4 h-4']) Validasi & Ajukan Penomoran
                            </button>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</div>
@endsection
