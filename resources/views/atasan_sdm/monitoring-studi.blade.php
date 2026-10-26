@extends('layouts.app')
@section('title', 'Monitoring Studi Lanjut')
@section('breadcrumb', 'Monitoring / Studi Lanjut')

@section('content')
    @include('partials.page-head', ['heading' => 'Monitoring Studi Lanjut PID', 'sub' => 'Pengawasan batas masa studi dosen (evaluasi semester & amandemen).'])
    <div class="bg-white rounded-lg border border-slate-200 overflow-hidden">
        <table class="w-full text-sm">
            <thead><tr class="bg-slate-50 text-left text-[11px] uppercase tracking-wider text-slate-500">
                <th class="px-6 py-3 font-semibold">Dosen</th><th class="px-6 py-3 font-semibold">Universitas</th>
                <th class="px-6 py-3 font-semibold">Skema</th><th class="px-6 py-3 font-semibold">Progres</th><th class="px-6 py-3 font-semibold">Status</th>
            </tr></thead>
            <tbody class="divide-y divide-slate-50">
                @foreach($pid as $p)
                    <tr class="hover:bg-slate-50/60">
                        <td class="px-6 py-3.5 font-medium text-slate-800">{{ $p['dosen'] }}</td>
                        <td class="px-6 py-3.5 text-slate-600">{{ $p['universitas'] }}</td>
                        <td class="px-6 py-3.5 text-slate-600">{{ $p['skema'] }}</td>
                        <td class="px-6 py-3.5">
                            <div class="flex items-center gap-2"><div class="w-28 h-2 rounded-full bg-slate-100 overflow-hidden"><div class="h-full bg-teal-500" style="width:43%"></div></div><span class="text-xs text-slate-500 tnum">3/7</span></div>
                        </td>
                        <td class="px-6 py-3.5">@include('partials.badge', ['label' => 'Tepat Waktu', 'tone' => 'green'])</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endsection
