@extends('layouts.app')
@section('title', 'Pelaporan Kelulusan PID')
@section('breadcrumb', 'Studi PID / Kelulusan')

@section('content')
    @include('partials.page-head', ['heading' => 'Pelaporan Kelulusan PID', 'sub' => 'Verifikasi kelulusan doktoral & pemrosesan NDE penutupan beasiswa.'])
    <div class="bg-white rounded-lg border border-slate-200 overflow-hidden">
        <table class="w-full text-sm">
            <thead><tr class="bg-slate-50 text-left text-[11px] uppercase tracking-wider text-slate-500">
                <th class="px-6 py-3 font-semibold">Dosen</th><th class="px-6 py-3 font-semibold">Universitas</th>
                <th class="px-6 py-3 font-semibold">Status Beasiswa</th><th class="px-6 py-3 font-semibold text-right">Aksi</th>
            </tr></thead>
            <tbody class="divide-y divide-slate-50">
                @foreach($pid as $p)
                    <tr class="hover:bg-slate-50/60">
                        <td class="px-6 py-3.5 font-medium text-slate-800">{{ $p['dosen'] }}</td>
                        <td class="px-6 py-3.5 text-slate-600">{{ $p['universitas'] }}</td>
                        <td class="px-6 py-3.5">@include('partials.badge', ['label' => $p['status'], 'tone' => 'green'])</td>
                        <td class="px-6 py-3.5 text-right"><button class="px-3 py-1.5 rounded bg-teal-500 hover:bg-teal-600 text-white text-xs font-semibold">Proses NDE Penutupan</button></td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endsection
