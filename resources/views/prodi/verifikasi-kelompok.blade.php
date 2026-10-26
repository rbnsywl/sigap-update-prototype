@extends('layouts.app')
@section('title', 'Pemeriksaan Kelompok')
@section('breadcrumb', 'Surat Tugas / Pemeriksaan Kelompok')

@section('content')
    @include('partials.page-head', ['heading' => 'Pemeriksaan Pengajuan Kelompok', 'sub' => 'Validasi daftar anggota dosen & konfirmasi mata kuliah.'])
    @php $kelompok = collect($st)->where('tipe','Kelompok'); @endphp
    <div class="space-y-6">
        @foreach($kelompok as $row)
            <div class="bg-white rounded-lg border border-slate-200">
                <div class="px-6 py-4 border-b border-slate-100 flex items-center justify-between">
                    <div><div class="font-semibold text-slate-800">{{ $row['judul'] }}</div><div class="text-xs text-slate-400 tnum">{{ $row['id'] }}</div></div>
                    @include('partials.badge', ['label' => $row['status'], 'tone' => \App\Support\MockData::stStatuses()[$row['status']] ?? 'slate'])
                </div>
                <table class="w-full text-sm">
                    <thead><tr class="bg-slate-50 text-left text-[11px] uppercase tracking-wider text-slate-500">
                        <th class="px-6 py-3 font-semibold">Nama Dosen</th><th class="px-6 py-3 font-semibold">Peran</th>
                        <th class="px-6 py-3 font-semibold">Prodi</th><th class="px-6 py-3 font-semibold">Beban SKS</th><th class="px-6 py-3 font-semibold">Bentrok?</th>
                    </tr></thead>
                    <tbody class="divide-y divide-slate-50">
                        @foreach($row['anggota'] as $a)
                            <tr>
                                <td class="px-6 py-3.5 font-medium text-slate-800">{{ $a['nama'] }}</td>
                                <td class="px-6 py-3.5">@include('partials.badge', ['label' => $a['peran'], 'tone' => $a['peran']==='Ketua'?'teal':'slate'])</td>
                                <td class="px-6 py-3.5 text-slate-600">{{ $a['prodi'] }}</td>
                                <td class="px-6 py-3.5 text-slate-600 tnum">12 SKS</td>
                                <td class="px-6 py-3.5">@include('partials.badge', ['label' => 'Tidak', 'tone' => 'green'])</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @endforeach
    </div>
@endsection
