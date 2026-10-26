@extends('layouts.app')
@section('title', 'Master Data Dosen')
@section('breadcrumb', 'Data & Master / Dosen')

@section('content')
    @include('partials.page-head', ['heading' => 'Master Data Dosen', 'sub' => 'Sinkronisasi data HRIS: NIP, status kepegawaian, kelompok keahlian.'])
    <div class="bg-white rounded-lg border border-slate-200 overflow-hidden">
        <div class="px-6 py-4 border-b border-slate-100 flex items-center justify-between">
            <h3 class="font-semibold text-slate-800">Daftar Dosen FEB</h3>
            <button class="inline-flex items-center gap-2 px-3 py-1.5 rounded border border-teal-500 text-teal-600 text-sm font-semibold hover:bg-teal-50">
                @include('partials.icon', ['name' => 'chart', 'class' => 'w-4 h-4']) Sinkronkan HRIS
            </button>
        </div>
        <table class="w-full text-sm">
            <thead><tr class="bg-slate-50 text-left text-[11px] uppercase tracking-wider text-slate-500">
                <th class="px-6 py-3 font-semibold">Dosen</th><th class="px-6 py-3 font-semibold">NIP</th>
                <th class="px-6 py-3 font-semibold">Prodi</th><th class="px-6 py-3 font-semibold">JAD</th>
                <th class="px-6 py-3 font-semibold">Masa Kerja</th><th class="px-6 py-3 font-semibold">Status</th>
            </tr></thead>
            <tbody class="divide-y divide-slate-50">
                @foreach($rows as $r)
                    <tr class="hover:bg-slate-50/60">
                        <td class="px-6 py-3.5"><div class="flex items-center gap-3"><div class="w-8 h-8 rounded-full bg-teal-600 text-white grid place-items-center text-xs font-semibold">{{ $r['avatar'] }}</div><span class="font-medium text-slate-800">{{ $r['nama'] }}</span></div></td>
                        <td class="px-6 py-3.5 text-slate-500 tnum">{{ $r['nip'] }}</td>
                        <td class="px-6 py-3.5 text-slate-600">{{ $r['prodi'] }}</td>
                        <td class="px-6 py-3.5 text-slate-600">{{ $r['jad'] }}</td>
                        <td class="px-6 py-3.5 text-slate-600">{{ $r['masa_kerja'] }}</td>
                        <td class="px-6 py-3.5">@include('partials.badge', ['label' => 'Aktif', 'tone' => 'green'])</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endsection
