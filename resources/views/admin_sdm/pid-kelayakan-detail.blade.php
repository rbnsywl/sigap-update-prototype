@extends('layouts.app')
@section('title', 'Detail Kelayakan Dosen')
@section('breadcrumb', 'Studi PID / Detail Kelayakan')

@section('content')
    @php
        $syarat = \App\Support\MockData::kriteriaPidSyarat();
        $eks = $dosen['eksisting'];
        $okCount = collect($eks)->where('ok', true)->count();
        $total = count($syarat);
    @endphp

    <a href="/admin-sdm/pid/kelayakan" class="inline-flex items-center gap-1 text-sm text-slate-500 hover:text-teal-600 mb-4">← Kembali ke daftar</a>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <div class="lg:col-span-2 space-y-6">
            {{-- Profile --}}
            <div class="bg-white rounded-lg border border-slate-200 p-6 flex items-center gap-4">
                <div class="w-14 h-14 rounded-full bg-teal-600 text-white grid place-items-center text-lg font-bold">{{ $dosen['avatar'] }}</div>
                <div>
                    <div class="font-semibold text-slate-900">{{ $dosen['nama'] }}</div>
                    <div class="text-sm text-slate-500">{{ $dosen['nip'] }} · {{ $dosen['prodi'] }} · {{ $dosen['jad'] }}</div>
                </div>
                <div class="ml-auto text-right">
                    @include('partials.badge', ['label' => $dosen['status'], 'tone' => $dosen['status']==='Eligible Penuh YPT'?'green':($dosen['status']==='Eligible Sebagian'?'teal':($dosen['status']==='Data Belum Lengkap'?'amber':'rose'))])
                    <div class="text-xs text-slate-400 mt-1 tnum">{{ $okCount }}/{{ $total }} kriteria</div>
                </div>
            </div>

            {{-- Full matrix --}}
            <div class="bg-white rounded-lg border border-slate-200 overflow-hidden">
                <div class="px-6 py-4 border-b border-slate-100"><h3 class="font-semibold text-slate-800">Matriks Syarat & Kondisi Eksisting</h3></div>
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
        </div>

        {{-- Private notes + override --}}
        <div class="space-y-6" x-data="{ saved:false }">
            <div class="bg-amber-50 rounded-lg border border-amber-200 p-5">
                <div class="flex items-center gap-2 text-amber-800 font-semibold text-sm mb-1">
                    @include('partials.icon', ['name' => 'shield', 'class' => 'w-4 h-4']) Catatan Internal SDM
                </div>
                <p class="text-xs text-amber-700 mb-3">Catatan hanya terlihat oleh Admin SDM dan tidak tampil di portal dosen.</p>
                <textarea rows="5" class="w-full rounded border border-amber-300 bg-white px-3 py-2 text-sm focus:border-amber-500 outline-none" placeholder="Catatan evaluasi internal…">Kandidat kuat. FSDP lulus. Menunggu konfirmasi status PT tujuan pada daftar beasiswa RI.</textarea>
                <button @click="sigapToast('Catatan internal tersimpan', 'green')" class="mt-3 w-full px-3 py-2 rounded bg-amber-500 hover:bg-amber-600 text-white text-sm font-semibold">Simpan Catatan</button>
            </div>
            <div class="bg-white rounded-lg border border-slate-200 p-5">
                <h3 class="font-semibold text-slate-800 text-sm mb-3">Pemutakhiran Status Kelayakan</h3>
                <select class="w-full rounded border border-slate-300 px-3 py-2 text-sm focus:border-teal-500 outline-none mb-3">
                    <option>Eligible Penuh YPT</option><option>Eligible Sebagian</option><option>Belum Memenuhi Syarat</option><option>Data Belum Lengkap</option>
                </select>
                <button @click="sigapToast('Status kelayakan diperbarui', 'green')" class="w-full px-3 py-2 rounded bg-teal-500 hover:bg-teal-600 text-white text-sm font-semibold">Simpan Kelayakan</button>
            </div>
        </div>
    </div>
@endsection
