@extends('layouts.app')
@section('title', 'Monitoring Kinerja Dosen')
@section('breadcrumb', 'Rekapitulasi / Monitoring Kinerja')

@section('content')
    @include('partials.page-head', ['heading' => 'Monitoring Kinerja Dosen Prodi', 'sub' => 'Rekapitulasi beban tugas & kegiatan tridharma dosen.'])
    <div class="bg-white rounded-lg border border-slate-200 overflow-hidden">
        <table class="w-full text-sm">
            <thead><tr class="bg-slate-50 text-left text-[11px] uppercase tracking-wider text-slate-500">
                <th class="px-6 py-3 font-semibold">Dosen</th><th class="px-6 py-3 font-semibold">Pendidikan</th>
                <th class="px-6 py-3 font-semibold">Penelitian</th><th class="px-6 py-3 font-semibold">Pengabdian</th><th class="px-6 py-3 font-semibold">Total ST</th>
            </tr></thead>
            <tbody class="divide-y divide-slate-50">
                @foreach([['Rangga Pratama',4,3,2,9],['Fitra Ramadhan',3,2,1,6],['Yusuf Maulana',2,1,2,5]] as $r)
                    <tr class="hover:bg-slate-50/60">
                        <td class="px-6 py-3.5 font-medium text-slate-800">{{ $r[0] }}</td>
                        <td class="px-6 py-3.5 text-slate-600 tnum">{{ $r[1] }}</td>
                        <td class="px-6 py-3.5 text-slate-600 tnum">{{ $r[2] }}</td>
                        <td class="px-6 py-3.5 text-slate-600 tnum">{{ $r[3] }}</td>
                        <td class="px-6 py-3.5"><span class="font-semibold text-teal-600 tnum">{{ $r[4] }}</span></td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endsection
