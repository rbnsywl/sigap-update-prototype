@extends('layouts.app')
@section('title', 'Buku Agenda Surat Keluar')
@section('breadcrumb', 'Tata Kelola / Buku Agenda')

@section('content')
    @include('partials.page-head', ['heading' => 'Buku Agenda Surat Keluar', 'sub' => 'Log lengkap penomoran dokumen resmi FEB Telkom University.'])
    @php $numbered = collect($st)->whereNotNull('nomor_surat'); @endphp
    <div class="bg-white rounded-lg border border-slate-200 overflow-hidden">
        <table class="w-full text-sm">
            <thead><tr class="bg-slate-50 text-left text-[11px] uppercase tracking-wider text-slate-500">
                <th class="px-6 py-3 font-semibold">Nomor Surat</th><th class="px-6 py-3 font-semibold">Perihal</th>
                <th class="px-6 py-3 font-semibold">Tujuan</th><th class="px-6 py-3 font-semibold">Tgl Terbit</th>
            </tr></thead>
            <tbody class="divide-y divide-slate-50">
                @foreach($numbered as $row)
                    <tr class="hover:bg-slate-50/60">
                        <td class="px-6 py-3.5 font-medium text-teal-600 tnum">{{ $row['nomor_surat'] }}</td>
                        <td class="px-6 py-3.5 text-slate-600 max-w-xs truncate">{{ $row['judul'] }}</td>
                        <td class="px-6 py-3.5 text-slate-600">{{ $row['dosen'] }}</td>
                        <td class="px-6 py-3.5 text-slate-500">{{ $row['tanggal_terbit'] }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endsection
