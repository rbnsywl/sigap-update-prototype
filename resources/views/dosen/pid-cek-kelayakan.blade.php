@extends('layouts.app')
@section('title', 'Cek Kelayakan PID')
@section('breadcrumb', 'Studi PID / Cek Kelayakan')

@section('content')
    @php
        $syarat = \App\Support\MockData::kriteriaPidSyarat();
        $eks = $data['eksisting'];
        $eligible = $data['status'] === 'Eligible Penuh YPT';
        $okCount = collect($eks)->where('ok', true)->count();
        $total = count($syarat);
    @endphp

    @include('partials.page-head', ['heading' => 'Cek Kelayakan Program Insentif Doktoral', 'sub' => 'Evaluasi otomatis 11 kriteria terhadap ambang 3 skema pembiayaan. Hubungi Admin SDM jika ada data yang tidak sesuai.'])

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        {{-- Tabel kriteria --}}
        <div class="lg:col-span-2 bg-white rounded-lg border border-slate-200 overflow-hidden">
            <div class="px-6 py-4 border-b border-slate-100 flex items-center justify-between">
                <h3 class="font-semibold text-slate-800">Matriks Syarat & Kondisi Eksisting</h3>
                <span class="text-xs text-slate-400">{{ $okCount }}/{{ $total }} kriteria terpenuhi</span>
            </div>
            <div class="overflow-x-auto">
                <table class="w-full text-sm">
                    <thead>
                        <tr class="bg-slate-50 text-left text-[11px] uppercase tracking-wider text-slate-500">
                            <th class="px-4 py-3 font-semibold">Syarat</th>
                            <th class="px-3 py-3 font-semibold text-center">Full YPT</th>
                            <th class="px-3 py-3 font-semibold text-center">Sebagian YPT</th>
                            <th class="px-3 py-3 font-semibold text-center">Mandiri</th>
                            <th class="px-4 py-3 font-semibold">Kondisi Eksisting</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-50">
                        @foreach($syarat as $s)
                            @php $e = $eks[$s['key']] ?? ['nilai' => '—', 'ok' => false]; @endphp
                            <tr class="hover:bg-slate-50/60 align-top">
                                <td class="px-4 py-3 font-medium text-slate-700">{{ $s['syarat'] }}</td>
                                <td class="px-3 py-3 text-center text-slate-500">{{ $s['full'] }}</td>
                                <td class="px-3 py-3 text-center text-slate-500">{{ $s['sebagian'] }}</td>
                                <td class="px-3 py-3 text-center text-slate-500">{{ $s['mandiri'] }}</td>
                                <td class="px-4 py-3">
                                    <span class="inline-flex items-center gap-1.5 {{ $e['ok'] ? 'text-green-700' : 'text-rose-600' }}">
                                        <span class="w-4 h-4 rounded-full grid place-items-center shrink-0 {{ $e['ok'] ? 'bg-green-100' : 'bg-rose-100' }}">
                                            @include('partials.icon', ['name' => $e['ok'] ? 'check' : 'x', 'class' => 'w-3 h-3'])
                                        </span>
                                        <span class="font-medium">{{ $e['nilai'] }}</span>
                                    </span>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

        {{-- Result card --}}
        <div>
            <div class="bg-white rounded-lg border border-slate-200 p-6 sticky top-20">
                <div class="text-sm text-slate-400">Hasil Evaluasi</div>
                <div class="mt-3">
                    @include('partials.badge', ['label' => $data['status'], 'tone' => $eligible ? 'green' : 'amber'])
                </div>

                {{-- Ringkas skema --}}
                <div class="mt-5 space-y-2">
                    <div class="flex items-center justify-between text-sm">
                        <span class="text-slate-500">Kriteria terpenuhi</span>
                        <span class="font-semibold text-slate-800 tnum">{{ $okCount }} / {{ $total }}</span>
                    </div>
                    <div class="h-2 rounded-full bg-slate-100 overflow-hidden">
                        <div class="h-full rounded-full {{ $eligible ? 'bg-green-500' : 'bg-amber-500' }}" style="width: {{ round($okCount/$total*100) }}%"></div>
                    </div>
                </div>

                <p class="text-sm text-slate-500 mt-4">
                    {{ $eligible
                        ? 'Anda memenuhi seluruh kriteria utama dan dapat melanjutkan ke formulir pengajuan PID.'
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
