@extends('layouts.app')
@section('title', 'Cek Kelayakan PID')
@section('breadcrumb', 'Studi PID / Cek Kelayakan')

@section('content')
    @php $eligible = $data['status'] === 'Eligible Penuh YPT'; @endphp

    @include('partials.page-head', ['heading' => 'Cek Kelayakan Program Insentif Doktoral', 'sub' => 'Evaluasi otomatis berdasarkan data HRIS Anda. Hubungi Admin SDM jika ada data yang tidak sesuai.'])

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        {{-- Criteria --}}
        <div class="lg:col-span-2 space-y-6">
            <div class="bg-white rounded-lg border border-slate-200">
                <div class="px-6 py-4 border-b border-slate-100 flex items-center gap-2">
                    <h3 class="font-semibold text-slate-800">Kriteria Otomatis (HRIS)</h3>
                    <span class="text-xs text-slate-400">· ditarik dari master data kepegawaian</span>
                </div>
                <div class="divide-y divide-slate-50">
                    @foreach($data['kriteria'] as $k)
                        <div class="px-6 py-4 flex items-center gap-4">
                            <div class="w-9 h-9 rounded-full grid place-items-center shrink-0 {{ $k['ok'] ? 'bg-green-100 text-green-600' : 'bg-rose-100 text-rose-600' }}">
                                @include('partials.icon', ['name' => $k['ok'] ? 'check' : 'x', 'class' => 'w-5 h-5'])
                            </div>
                            <div class="flex-1">
                                <div class="text-sm font-medium text-slate-800">{{ $k['label'] }}</div>
                                <div class="text-xs {{ $k['ok'] ? 'text-green-600' : 'text-rose-600' }} mt-0.5">
                                    {{ $k['ok'] ? 'Memenuhi Syarat' : 'Belum Memenuhi' }} — {{ $k['detail'] }}
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>

            <div class="bg-white rounded-lg border border-slate-200">
                <div class="px-6 py-4 border-b border-slate-100"><h3 class="font-semibold text-slate-800">Kriteria Verifikasi Manual (SDM)</h3></div>
                <div class="divide-y divide-slate-50">
                    <div class="px-6 py-4 flex items-center justify-between">
                        <span class="text-sm text-slate-700">Status Lulus FSDP (Forum Studi Dosen Pemula)</span>
                        @include('partials.badge', ['label' => $data['fsdp'], 'tone' => $data['fsdp']==='Lulus'?'green':'amber'])
                    </div>
                    <div class="px-6 py-4 flex items-center justify-between">
                        <span class="text-sm text-slate-700">Catatan Disiplin Kepegawaian & BKD</span>
                        @include('partials.badge', ['label' => $data['disiplin'], 'tone' => 'green'])
                    </div>
                </div>
            </div>
        </div>

        {{-- Result card --}}
        <div>
            <div class="bg-white rounded-lg border border-slate-200 p-6 sticky top-20">
                <div class="text-sm text-slate-400">Hasil Evaluasi</div>
                <div class="mt-3 flex items-center gap-2">
                    @include('partials.badge', ['label' => $data['status'], 'tone' => $eligible ? 'green' : 'amber'])
                </div>
                <p class="text-sm text-slate-500 mt-4">
                    {{ $eligible
                        ? 'Selamat! Anda memenuhi seluruh kriteria dan dapat melanjutkan ke formulir pengajuan PID.'
                        : 'Sebagian kriteria belum terpenuhi. Anda tetap dapat mengajukan untuk ditinjau manual oleh SDM.' }}
                </p>
                <a href="/studi-pid/pengajuan"
                   class="mt-5 w-full inline-flex items-center justify-center gap-2 px-4 py-2.5 rounded text-sm font-semibold transition {{ $eligible ? 'bg-teal-500 hover:bg-teal-600 text-white' : 'bg-slate-100 text-slate-400 pointer-events-none' }}">
                    Lanjutkan ke Formulir Pengajuan PID
                </a>
            </div>
        </div>
    </div>
@endsection
