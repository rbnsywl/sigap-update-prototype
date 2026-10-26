@extends('layouts.app')
@section('title', 'Riwayat Penilaian')
@section('breadcrumb', 'Penilaian / Riwayat')

@section('content')
    @include('partials.page-head', ['heading' => 'Riwayat Penilaian', 'sub' => 'Arsip berkas dosen yang telah diberikan rekomendasi keilmuan.'])
    <div class="bg-white rounded-lg border border-slate-200 overflow-hidden">
        <table class="w-full text-sm">
            <thead><tr class="bg-slate-50 text-left text-[11px] uppercase tracking-wider text-slate-500">
                <th class="px-6 py-3 font-semibold">Dosen</th><th class="px-6 py-3 font-semibold">Disertasi</th>
                <th class="px-6 py-3 font-semibold">Tanggal</th><th class="px-6 py-3 font-semibold">Status</th><th class="px-6 py-3 font-semibold text-right">Aksi</th>
            </tr></thead>
            <tbody class="divide-y divide-slate-50">
                @foreach($rows as $r)
                    <tr class="hover:bg-slate-50/60">
                        <td class="px-6 py-3.5 font-medium text-slate-800">{{ $r['dosen'] }}</td>
                        <td class="px-6 py-3.5 text-slate-600 max-w-xs truncate">{{ $r['judul_disertasi'] }}</td>
                        <td class="px-6 py-3.5 text-slate-500">{{ $r['tanggal'] }}</td>
                        <td class="px-6 py-3.5">@include('partials.badge', ['label' => $r['status'], 'tone' => $statuses[$r['status']] ?? 'slate'])</td>
                        <td class="px-6 py-3.5 text-right"><button class="text-teal-600 font-semibold hover:underline text-sm">Lihat</button></td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endsection
