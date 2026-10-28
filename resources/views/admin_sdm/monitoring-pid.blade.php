@extends('layouts.app')
@section('title', 'Monitoring Dosen PID')
@section('breadcrumb', 'Studi PID / Monitoring Dosen')

@section('content')
    @include('partials.page-head', ['heading' => 'Monitoring Dosen PID', 'sub' => 'Pantau perkembangan studi dosen penerima PID — LKS, reimburs, pembiayaan, & amandemen. Klik Detail untuk memilih data yang diperiksa.'])

    @php
        $cTotal = count($rows);
        $cTepat = collect($rows)->where('kepatuhan', 'Tepat Waktu')->count();
        $cPerhatian = collect($rows)->where('kepatuhan', 'Perlu Perhatian')->count();
        $cLebih = collect($rows)->where('kepatuhan', 'Melebihi Batas')->count();
    @endphp
    <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-6">
        @include('partials.stat-card', ['label' => 'Total Dosen PID Aktif', 'value' => $cTotal, 'tone' => 'slate', 'icon' => 'cap'])
        @include('partials.stat-card', ['label' => 'Tepat Waktu', 'value' => $cTepat, 'tone' => 'green', 'icon' => 'check'])
        @include('partials.stat-card', ['label' => 'Perlu Perhatian', 'value' => $cPerhatian, 'tone' => 'amber', 'icon' => 'clock'])
        @include('partials.stat-card', ['label' => 'Melebihi Batas', 'value' => $cLebih, 'tone' => 'rose', 'icon' => 'help'])
    </div>

    <div class="bg-white rounded-lg border border-slate-200 overflow-hidden">
        <div class="px-6 py-4 border-b border-slate-100 flex items-center justify-between">
            <h3 class="font-semibold text-slate-800">Daftar Dosen Studi PID</h3>
            <input placeholder="Cari dosen / universitas…" class="rounded border border-slate-300 px-3 py-1.5 text-sm w-56 focus:border-teal-500 outline-none">
        </div>
        <div class="overflow-x-auto">
            <table class="w-full text-sm">
                <thead><tr class="bg-slate-50 text-left text-[11px] uppercase tracking-wider text-slate-500">
                    <th class="px-6 py-3 font-semibold">Dosen</th>
                    <th class="px-6 py-3 font-semibold">Universitas</th>
                    <th class="px-6 py-3 font-semibold">Skema</th>
                    <th class="px-6 py-3 font-semibold">Progres Semester</th>
                    <th class="px-6 py-3 font-semibold">IPK</th>
                    <th class="px-6 py-3 font-semibold">Kepatuhan</th>
                    <th class="px-6 py-3 font-semibold text-right">Aksi</th>
                </tr></thead>
                <tbody class="divide-y divide-slate-50">
                    @foreach($rows as $r)
                        @php $pct = (int) round($r['semester_berjalan'] / max(1, $r['durasi_total']) * 100); @endphp
                        <tr class="hover:bg-slate-50/60">
                            <td class="px-6 py-3.5">
                                <div class="flex items-center gap-3">
                                    <div class="w-8 h-8 rounded-full bg-teal-600 text-white grid place-items-center text-xs font-semibold">{{ $r['avatar'] }}</div>
                                    <div>
                                        <div class="font-medium text-slate-800">{{ $r['dosen'] }}</div>
                                        <div class="text-xs text-slate-400 tnum">{{ $r['nip'] }} · {{ $r['prodi'] }}</div>
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-3.5 text-slate-600">{{ $r['universitas'] }}<div class="text-xs text-slate-400">{{ $r['prodi_tujuan'] }}</div></td>
                            <td class="px-6 py-3.5 text-slate-600">{{ $r['skema'] }}</td>
                            <td class="px-6 py-3.5">
                                <div class="flex items-center gap-2">
                                    <div class="w-24 h-2 rounded-full bg-slate-100 overflow-hidden"><div class="h-full bg-teal-500" style="width: {{ $pct }}%"></div></div>
                                    <span class="text-xs text-slate-500 tnum">{{ $r['semester_berjalan'] }}/{{ $r['durasi_total'] }}</span>
                                </div>
                            </td>
                            <td class="px-6 py-3.5 text-slate-700 tnum">{{ number_format($r['ipk'], 2) }}</td>
                            <td class="px-6 py-3.5">@include('partials.badge', ['label' => $r['kepatuhan'], 'tone' => $statuses[$r['kepatuhan']] ?? 'slate'])</td>
                            <td class="px-6 py-3.5 text-right">
                                <a href="/admin-sdm/pid/monitoring/{{ $r['nip'] }}" class="text-teal-600 font-semibold hover:underline text-sm">Detail</a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection
