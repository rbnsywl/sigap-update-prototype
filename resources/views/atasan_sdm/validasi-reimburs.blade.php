@extends('layouts.app')
@section('title', 'Validasi Usulan Reimburs')
@section('breadcrumb', 'Validasi / Reimburs')

@section('content')
    @include('partials.page-head', ['heading' => 'Validasi Usulan Reimburs', 'sub' => 'Tinjau kelayakan total nominal pengajuan klaim beasiswa NDE fakultas.'])
    @php $toneMap = ['Selesai'=>'green','Diproses'=>'amber','Ditolak'=>'rose']; @endphp
    <div class="bg-white rounded-lg border border-slate-200 overflow-hidden">
        <table class="w-full text-sm">
            <thead><tr class="bg-slate-50 text-left text-[11px] uppercase tracking-wider text-slate-500">
                <th class="px-6 py-3 font-semibold">Tanggal</th><th class="px-6 py-3 font-semibold">Dosen</th>
                <th class="px-6 py-3 font-semibold">Kategori</th><th class="px-6 py-3 font-semibold text-right">Nominal</th>
                <th class="px-6 py-3 font-semibold">Status</th><th class="px-6 py-3 font-semibold text-right">Aksi</th>
            </tr></thead>
            <tbody class="divide-y divide-slate-50">
                @foreach($rows as $r)
                    <tr class="hover:bg-slate-50/60">
                        <td class="px-6 py-3.5 text-slate-500">{{ $r['tanggal'] }}</td>
                        <td class="px-6 py-3.5 text-slate-700">Dr. Rangga Pratama</td>
                        <td class="px-6 py-3.5 text-slate-600">{{ $r['kategori'] }}</td>
                        <td class="px-6 py-3.5 text-right font-medium text-slate-800 tnum">{{ \App\Support\MockData::rupiah($r['nominal']) }}</td>
                        <td class="px-6 py-3.5">@include('partials.badge', ['label' => $r['status'], 'tone' => $toneMap[$r['status']] ?? 'slate'])</td>
                        <td class="px-6 py-3.5 text-right">
                            @if($r['status']==='Diproses')
                                <button class="px-3 py-1.5 rounded bg-teal-500 hover:bg-teal-600 text-white text-xs font-semibold">Setujui Usulan</button>
                            @else
                                <span class="text-slate-300 text-xs">—</span>
                            @endif
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endsection
