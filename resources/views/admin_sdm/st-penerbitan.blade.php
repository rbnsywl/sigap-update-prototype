@extends('layouts.app')
@section('title', 'Penerbitan ST')
@section('breadcrumb', 'Surat Tugas / Penerbitan')

@section('content')
    @include('partials.page-head', ['heading' => 'Penerbitan Surat Tugas', 'sub' => 'Distribusi surat resmi ke dosen & pemantauan masa sanggah (3 hari).'])
    @php $numbered = collect($st)->where('status','Selesai (Terbit)'); @endphp
    <div class="bg-white rounded-lg border border-slate-200 overflow-hidden">
        <table class="w-full text-sm">
            <thead><tr class="bg-slate-50 text-left text-[11px] uppercase tracking-wider text-slate-500">
                <th class="px-6 py-3 font-semibold">Nomor Surat</th><th class="px-6 py-3 font-semibold">Judul</th>
                <th class="px-6 py-3 font-semibold">Dosen</th><th class="px-6 py-3 font-semibold">Tgl Terbit</th>
                <th class="px-6 py-3 font-semibold">Status</th><th class="px-6 py-3 font-semibold text-right">Aksi</th>
            </tr></thead>
            <tbody class="divide-y divide-slate-50">
                @foreach($numbered as $row)
                    <tr class="hover:bg-slate-50/60">
                        <td class="px-6 py-3.5 font-medium text-slate-700 tnum">{{ $row['nomor_surat'] }}</td>
                        <td class="px-6 py-3.5 text-slate-600 max-w-xs truncate">{{ $row['judul'] }}</td>
                        <td class="px-6 py-3.5 text-slate-600">{{ $row['dosen'] }}</td>
                        <td class="px-6 py-3.5 text-slate-500">{{ $row['tanggal_terbit'] }}</td>
                        <td class="px-6 py-3.5">@include('partials.badge', ['label' => 'Terbit', 'tone' => 'green'])</td>
                        <td class="px-6 py-3.5 text-right">
                            <button class="text-teal-600 font-semibold hover:underline text-sm inline-flex items-center gap-1">
                                @include('partials.icon', ['name' => 'download', 'class' => 'w-4 h-4']) PDF
                            </button>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endsection
