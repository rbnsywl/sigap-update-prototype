@extends('layouts.app')
@section('title', 'Request Nomor Surat')
@section('breadcrumb', 'Surat Tugas / Request Nomor')

@section('content')
    @include('partials.page-head', ['heading' => 'Request Nomor Surat', 'sub' => 'Ajukan permohonan penomoran resmi ke Admin Sekretariat Dekanat.'])
    @php $ready = collect($st)->where('status','Menunggu Validasi Atasan SDM')->values(); if($ready->isEmpty()) $ready = collect($st)->take(2); @endphp
    <div class="bg-white rounded-lg border border-slate-200 overflow-hidden">
        <table class="w-full text-sm">
            <thead><tr class="bg-slate-50 text-left text-[11px] uppercase tracking-wider text-slate-500">
                <th class="px-6 py-3 font-semibold">No. Tiket</th><th class="px-6 py-3 font-semibold">Judul</th>
                <th class="px-6 py-3 font-semibold">Dosen</th><th class="px-6 py-3 font-semibold text-right">Aksi</th>
            </tr></thead>
            <tbody class="divide-y divide-slate-50">
                @foreach($ready as $row)
                    <tr class="hover:bg-slate-50/60">
                        <td class="px-6 py-3.5 font-medium text-slate-700 tnum">{{ $row['id'] }}</td>
                        <td class="px-6 py-3.5 text-slate-600 max-w-xs truncate">{{ $row['judul'] }}</td>
                        <td class="px-6 py-3.5 text-slate-600">{{ $row['dosen'] }}</td>
                        <td class="px-6 py-3.5 text-right">
                            <button class="px-3 py-1.5 rounded bg-teal-500 hover:bg-teal-600 text-white text-xs font-semibold inline-flex items-center gap-1.5">
                                @include('partials.icon', ['name' => 'hash', 'class' => 'w-3.5 h-3.5']) Ajukan ke Sekdek
                            </button>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endsection
