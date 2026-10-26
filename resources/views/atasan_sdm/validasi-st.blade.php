@extends('layouts.app')
@section('title', 'Validasi Surat Tugas')
@section('breadcrumb', 'Validasi / Surat Tugas')

@section('content')
<div x-data="{ sel:2 }">
    @include('partials.page-head', ['heading' => 'Validasi Surat Tugas (Manajerial)', 'sub' => 'Review kelayakan draf ST sebelum diteruskan ke Sekdek untuk penomoran.'])
    <div class="grid grid-cols-1 lg:grid-cols-5 gap-6">
        <div class="lg:col-span-2 bg-white rounded-lg border border-slate-200 overflow-hidden self-start">
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
        <div class="lg:col-span-3">
            @foreach($st as $i => $row)
                <div x-show="sel==={{ $i }}" x-cloak class="bg-white rounded-lg border border-slate-200">
                    <div class="px-6 py-4 border-b border-slate-100"><h3 class="font-semibold text-slate-800">Validasi Kepatuhan Regulasi</h3></div>
                    <div class="p-6 space-y-5">
                        <div class="text-base font-semibold text-slate-900">{{ $row['judul'] }}</div>
                        <dl class="grid grid-cols-2 gap-x-6 gap-y-3 text-sm">
                            <div><dt class="text-slate-400">Pemohon</dt><dd class="font-medium text-slate-800">{{ $row['dosen'] }}</dd></div>
                            <div><dt class="text-slate-400">Kategori</dt><dd class="font-medium text-slate-800">{{ $row['kategori'] }}</dd></div>
                            <div><dt class="text-slate-400">Mitra</dt><dd class="font-medium text-slate-800">{{ $row['mitra'] }}</dd></div>
                            <div><dt class="text-slate-400">Periode</dt><dd class="font-medium text-slate-800">{{ $row['mulai'] }} s/d {{ $row['selesai'] }}</dd></div>
                        </dl>
                        <div class="space-y-2">
                            @foreach(['Beban kerja dosen sesuai regulasi kepegawaian','Format surat sesuai template resmi FEB','Tidak ada konflik penugasan lain'] as $c)
                                <label class="flex items-center gap-3 p-3 rounded-lg border border-slate-200 cursor-pointer hover:bg-slate-50">
                                    <input type="checkbox" class="w-4 h-4 rounded text-teal-500 focus:ring-teal-500"><span class="text-sm text-slate-700">{{ $c }}</span>
                                </label>
                            @endforeach
                        </div>
                        <div class="flex items-center justify-end gap-3">
                            <button class="px-4 py-2 rounded border border-rose-300 text-rose-600 text-sm font-semibold hover:bg-rose-50">Kembalikan ke Admin SDM</button>
                            <button class="px-5 py-2.5 rounded bg-teal-500 hover:bg-teal-600 text-white text-sm font-semibold inline-flex items-center gap-2">
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
