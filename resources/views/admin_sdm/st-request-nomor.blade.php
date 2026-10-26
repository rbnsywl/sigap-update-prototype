@extends('layouts.app')
@section('title', 'Request Nomor Surat')
@section('breadcrumb', 'Surat Tugas / Request Nomor')

@section('content')
<div x-data="{ sel:0, modal:false, sent:{} }">
    @include('partials.page-head', ['heading' => 'Request Nomor Surat', 'sub' => 'Ajukan permohonan penomoran resmi ke Admin Sekretariat Dekanat.'])
    @php $ready = collect($st)->take(3)->values(); @endphp

    <div class="grid grid-cols-1 lg:grid-cols-5 gap-6">
        {{-- List --}}
        <div class="lg:col-span-2 bg-white rounded-lg border border-slate-200 overflow-hidden self-start">
            <div class="px-5 py-3.5 border-b border-slate-100 font-semibold text-slate-800 text-sm">Draf Tervalidasi Atasan SDM</div>
            <div class="divide-y divide-slate-50">
                @foreach($ready as $i => $row)
                    <button @click="sel={{ $i }}" class="w-full text-left px-5 py-3.5 transition" :class="sel==={{ $i }}?'bg-teal-50':'hover:bg-slate-50'">
                        <div class="flex items-center justify-between gap-2">
                            <span class="text-xs text-slate-400 tnum">{{ $row['id'] }}</span>
                            <template x-if="sent[{{ $i }}]"><span class="inline-flex items-center px-2 py-0.5 rounded-full text-[10px] font-semibold bg-indigo-100 text-indigo-800">Menunggu Penomoran</span></template>
                        </div>
                        <div class="text-sm font-medium text-slate-800 truncate mt-0.5">{{ $row['judul'] }}</div>
                        <div class="text-xs text-slate-400 mt-0.5">{{ $row['dosen'] }}</div>
                    </button>
                @endforeach
            </div>
        </div>

        {{-- Detail --}}
        <div class="lg:col-span-3">
            @foreach($ready as $i => $row)
                <div x-show="sel==={{ $i }}" x-cloak class="bg-white rounded-lg border border-slate-200">
                    <div class="px-6 py-4 border-b border-slate-100 flex items-center justify-between">
                        <h3 class="font-semibold text-slate-800">Detail Permohonan Nomor</h3>
                        <span class="text-xs text-slate-400 tnum">{{ $row['id'] }}</span>
                    </div>
                    <div class="p-6 space-y-5">
                        <dl class="grid grid-cols-2 gap-x-6 gap-y-3 text-sm">
                            <div><dt class="text-slate-400">Kegiatan</dt><dd class="font-medium text-slate-800">{{ $row['judul'] }}</dd></div>
                            <div><dt class="text-slate-400">Kategori Tridharma</dt><dd class="font-medium text-slate-800">{{ $row['kategori'] }}</dd></div>
                            <div><dt class="text-slate-400">Pemohon</dt><dd class="font-medium text-slate-800">{{ $row['dosen'] }}</dd></div>
                            <div><dt class="text-slate-400">Program Studi</dt><dd class="font-medium text-slate-800">{{ $row['prodi'] }}</dd></div>
                            <div><dt class="text-slate-400">Penyelenggara</dt><dd class="font-medium text-slate-800">{{ $row['mitra'] }}</dd></div>
                            <div><dt class="text-slate-400">Tempat</dt><dd class="font-medium text-slate-800">{{ $row['lokasi'] }}</dd></div>
                            <div><dt class="text-slate-400">Periode</dt><dd class="font-medium text-slate-800">{{ $row['mulai'] }} s/d {{ $row['selesai'] }}</dd></div>
                            <div><dt class="text-slate-400">Jumlah Dosen</dt><dd class="font-medium text-slate-800">{{ count($row['anggota']) ?: 1 }} orang</dd></div>
                        </dl>

                        {{-- Rencana format nomor --}}
                        <div class="rounded-lg bg-slate-50 border border-slate-200 p-4">
                            <div class="text-xs font-semibold text-slate-500 uppercase tracking-wide mb-3">Usulan Format Penomoran</div>
                            <div class="grid grid-cols-2 gap-4 text-sm">
                                <div><dt class="text-slate-400 text-xs">Jenis Surat</dt><dd class="font-medium text-slate-800">Surat Tugas (ST)</dd></div>
                                <div><dt class="text-slate-400 text-xs">Unit Penerbit</dt><dd class="font-medium text-slate-800">SDM01 / EB-WD2</dd></div>
                                <div><dt class="text-slate-400 text-xs">Bulan / Tahun</dt><dd class="font-medium text-slate-800">Oktober / 2026</dd></div>
                                <div><dt class="text-slate-400 text-xs">Format Nomor</dt><dd class="font-medium text-teal-600 tnum">…/SDM01/EB-WD2/2026</dd></div>
                            </div>
                        </div>

                        {{-- Validasi berjenjang (riwayat ringkas) --}}
                        <div>
                            <div class="text-sm font-medium text-slate-700 mb-2">Jejak Validasi</div>
                            <div class="space-y-2">
                                @foreach([['Disusun Admin SDM','Dewi Anggraini','done'],['Divalidasi Atasan SDM','Agus Salim','done'],['Penomoran Sekdek','—','wait']] as [$t,$by,$st2])
                                    <div class="flex items-center gap-3 text-sm">
                                        <span class="w-6 h-6 rounded-full grid place-items-center shrink-0 {{ $st2==='done'?'bg-green-100 text-green-600':'bg-slate-100 text-slate-400' }}">
                                            @include('partials.icon', ['name' => $st2==='done'?'check':'clock', 'class' => 'w-3.5 h-3.5'])
                                        </span>
                                        <span class="text-slate-700">{{ $t }}</span>
                                        <span class="text-slate-400 text-xs ml-auto">{{ $by }}</span>
                                    </div>
                                @endforeach
                            </div>
                        </div>

                        <div class="flex justify-end">
                            <button @click="sent[{{ $i }}]=true; sigapToast('{{ $row['id'] }} diajukan ke Sekdek untuk penomoran', 'green')"
                                    :disabled="sent[{{ $i }}]"
                                    class="px-5 py-2.5 rounded bg-teal-500 hover:bg-teal-600 text-white text-sm font-semibold inline-flex items-center gap-2 transition active:scale-[0.98] disabled:opacity-50 disabled:cursor-not-allowed">
                                @include('partials.icon', ['name' => 'hash', 'class' => 'w-4 h-4'])
                                <span x-text="sent[{{ $i }}] ? 'Sudah Diajukan' : 'Ajukan Penomoran ke Sekdek'"></span>
                            </button>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</div>
@endsection
