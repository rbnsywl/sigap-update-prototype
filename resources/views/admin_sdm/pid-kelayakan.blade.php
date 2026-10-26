@extends('layouts.app')
@section('title', 'Monitor Kelayakan PID')
@section('breadcrumb', 'Studi PID / Kelayakan')

@section('content')
    @include('partials.page-head', ['heading' => 'Monitor Kelayakan Dosen PID', 'sub' => 'Pantau eligibilitas studi lanjut doktoral dosen FEB.'])
    <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-6">
        @include('partials.stat-card', ['label' => $stats[0]['label'], 'value' => $stats[0]['value'], 'tone' => 'slate', 'icon' => 'users'])
        @include('partials.stat-card', ['label' => $stats[1]['label'], 'value' => $stats[1]['value'], 'tone' => 'green', 'icon' => 'check'])
        @include('partials.stat-card', ['label' => $stats[2]['label'], 'value' => $stats[2]['value'], 'tone' => 'teal', 'icon' => 'cap'])
        @include('partials.stat-card', ['label' => $stats[3]['label'], 'value' => $stats[3]['value'], 'tone' => 'amber', 'icon' => 'help'])
    </div>
    <div class="bg-white rounded-lg border border-slate-200 overflow-hidden">
        <div class="px-6 py-4 border-b border-slate-100 flex items-center justify-between">
            <h3 class="font-semibold text-slate-800">Daftar Kelayakan Dosen</h3>
            <input placeholder="Cari dosen…" class="rounded border border-slate-300 px-3 py-1.5 text-sm w-52 focus:border-teal-500 outline-none">
        </div>
        <table class="w-full text-sm">
            <thead><tr class="bg-slate-50 text-left text-[11px] uppercase tracking-wider text-slate-500">
                <th class="px-6 py-3 font-semibold">Dosen</th><th class="px-6 py-3 font-semibold">NIP</th>
                <th class="px-6 py-3 font-semibold">Prodi</th><th class="px-6 py-3 font-semibold">Usia</th>
                <th class="px-6 py-3 font-semibold">JAD</th><th class="px-6 py-3 font-semibold">Masa Kerja</th>
                <th class="px-6 py-3 font-semibold">Kelayakan</th><th class="px-6 py-3 font-semibold text-right">Aksi</th>
            </tr></thead>
            <tbody class="divide-y divide-slate-50">
                @foreach($rows as $r)
                    <tr class="hover:bg-slate-50/60">
                        <td class="px-6 py-3.5">
                            <div class="flex items-center gap-3">
                                <div class="w-8 h-8 rounded-full bg-teal-600 text-white grid place-items-center text-xs font-semibold">{{ $r['avatar'] }}</div>
                                <span class="font-medium text-slate-800">{{ $r['nama'] }}</span>
                            </div>
                        </td>
                        <td class="px-6 py-3.5 text-slate-500 tnum">{{ $r['nip'] }}</td>
                        <td class="px-6 py-3.5 text-slate-600">{{ $r['prodi'] }}</td>
                        <td class="px-6 py-3.5 text-slate-600 tnum">{{ $r['usia'] }}</td>
                        <td class="px-6 py-3.5 text-slate-600">{{ $r['jad'] }}</td>
                        <td class="px-6 py-3.5 text-slate-600">{{ $r['masa_kerja'] }}</td>
                        <td class="px-6 py-3.5">@include('partials.badge', ['label' => $r['status'], 'tone' => $statuses[$r['status']] ?? 'slate'])</td>
                        <td class="px-6 py-3.5 text-right">
                            <a href="/admin-sdm/pid/kelayakan/{{ $r['nip'] }}" class="text-teal-600 font-semibold hover:underline text-sm">Detail</a>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endsection
