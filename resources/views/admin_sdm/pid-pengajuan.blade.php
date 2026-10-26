@extends('layouts.app')
@section('title', 'Pengajuan Masuk PID')
@section('breadcrumb', 'Studi PID / Pengajuan Masuk')

@section('content')
    @include('partials.page-head', ['heading' => 'Pengajuan Masuk PID', 'sub' => 'Review izin belajar & registrasi beasiswa doktoral.'])
    <div class="bg-white rounded-lg border border-slate-200 overflow-hidden">
        <table class="w-full text-sm">
            <thead><tr class="bg-slate-50 text-left text-[11px] uppercase tracking-wider text-slate-500">
                <th class="px-6 py-3 font-semibold">ID</th><th class="px-6 py-3 font-semibold">Dosen</th>
                <th class="px-6 py-3 font-semibold">Universitas Tujuan</th><th class="px-6 py-3 font-semibold">Skema</th>
                <th class="px-6 py-3 font-semibold">Plafon</th><th class="px-6 py-3 font-semibold">Status</th><th class="px-6 py-3 font-semibold text-right">Aksi</th>
            </tr></thead>
            <tbody class="divide-y divide-slate-50">
                @foreach($pid as $p)
                    <tr class="hover:bg-slate-50/60">
                        <td class="px-6 py-3.5 font-medium text-slate-700 tnum">{{ $p['id'] }}</td>
                        <td class="px-6 py-3.5 text-slate-700">{{ $p['dosen'] }}</td>
                        <td class="px-6 py-3.5 text-slate-600">{{ $p['universitas'] }}</td>
                        <td class="px-6 py-3.5 text-slate-600">{{ $p['skema'] }}</td>
                        <td class="px-6 py-3.5 font-medium text-teal-600 tnum">{{ \App\Support\MockData::rupiah($p['plafon']) }}</td>
                        <td class="px-6 py-3.5">@include('partials.badge', ['label' => $p['status'], 'tone' => 'green'])</td>
                        <td class="px-6 py-3.5 text-right"><button class="text-teal-600 font-semibold hover:underline text-sm">Kelola</button></td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endsection
