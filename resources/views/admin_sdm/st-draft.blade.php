@extends('layouts.app')
@section('title', 'Pembuatan Draf ST')
@section('breadcrumb', 'Surat Tugas / Draf')

@section('content')
<div x-data="{ sel:2 }">
    @include('partials.page-head', ['heading' => 'Pembuatan Draf Surat Tugas', 'sub' => 'Generator otomatis menyusun surat berkop resmi FEB Telkom University (format A4).'])

    <div class="grid grid-cols-1 xl:grid-cols-4 gap-6">
        {{-- Queue --}}
        <div class="xl:col-span-1 bg-white rounded-lg border border-slate-200 overflow-hidden self-start">
            <div class="px-5 py-3.5 border-b border-slate-100 font-semibold text-slate-800 text-sm">Usulan Disetujui Kaprodi</div>
            <div class="divide-y divide-slate-50">
                @foreach($st as $i => $row)
                    <button @click="sel={{ $i }}" class="w-full text-left px-5 py-3.5 transition" :class="sel==={{ $i }}?'bg-teal-50':'hover:bg-slate-50'">
                        <div class="text-sm font-medium text-slate-800 truncate">{{ $row['judul'] }}</div>
                        <div class="text-xs text-slate-400 mt-0.5">{{ $row['id'] }} · {{ $row['dosen'] }}</div>
                    </button>
                @endforeach
            </div>
        </div>

        {{-- Letter preview (A4) --}}
        <div class="xl:col-span-3">
            @foreach($st as $i => $row)
                <div x-show="sel==={{ $i }}" x-cloak class="bg-white rounded-lg border border-slate-200">
                    <div class="px-6 py-4 border-b border-slate-100 flex items-center justify-between">
                        <h3 class="font-semibold text-slate-800">Preview Draf Surat (A4)</h3>
                        <span class="text-xs text-slate-400">Auto-generated dari data pengajuan</span>
                    </div>

                    {{-- Area kertas A4 --}}
                    <div class="p-6 bg-slate-100 overflow-x-auto">
                        <div class="mx-auto" style="width:794px; transform-origin: top center;">
                            @include('partials.st-letter', ['row' => $row])
                        </div>
                    </div>

                    <div class="p-6 border-t border-slate-100 space-y-5">
                        @include('partials.evidence', ['title' => 'Berkas Pendukung dari Dosen', 'files' => \App\Support\MockData::evidenceSuratTugas($row['id'])])
                        <div class="flex items-center justify-end gap-3">
                            <button @click="sigapPreview('Draf_ST_{{ $row['id'] }}.pdf', 'Format A4 · Kop FEB Telkom University', [])"
                                    class="px-4 py-2 rounded border border-slate-300 text-slate-600 text-sm font-semibold hover:bg-slate-50 inline-flex items-center gap-2">
                                @include('partials.icon', ['name' => 'eye', 'class' => 'w-4 h-4']) Preview PDF
                            </button>
                            <button @click="sigapToast('Draf {{ $row['id'] }} dikirim ke Atasan SDM', 'green')"
                                    class="px-5 py-2.5 rounded bg-teal-500 hover:bg-teal-600 text-white text-sm font-semibold inline-flex items-center gap-2 transition active:scale-[0.98]">
                                @include('partials.icon', ['name' => 'send', 'class' => 'w-4 h-4']) Kirim ke Atasan SDM untuk Validasi
                            </button>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</div>
@endsection
