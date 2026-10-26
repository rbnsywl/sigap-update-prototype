@extends('layouts.app')
@section('title', 'Tanda Tangan Surat Tugas')
@section('breadcrumb', 'Pengesahan / Tanda Tangan ST')

@section('content')
<div x-data="{ modal:false }">
    @include('partials.page-head', ['heading' => 'Tanda Tangan Surat Tugas', 'sub' => 'Pengesahan digital (BSrE) surat tugas yang telah dinomori dekanat.'])
    @php $ready = collect($st)->whereNotNull('nomor_surat'); @endphp
    <div class="bg-white rounded-lg border border-slate-200 overflow-hidden">
        <table class="w-full text-sm">
            <thead><tr class="bg-slate-50 text-left text-[11px] uppercase tracking-wider text-slate-500">
                <th class="px-6 py-3 font-semibold">Nomor Surat</th><th class="px-6 py-3 font-semibold">Judul</th>
                <th class="px-6 py-3 font-semibold">Dosen</th><th class="px-6 py-3 font-semibold text-right">Aksi</th>
            </tr></thead>
            <tbody class="divide-y divide-slate-50">
                @foreach($ready as $row)
                    <tr class="hover:bg-slate-50/60">
                        <td class="px-6 py-3.5 font-medium text-slate-700 tnum">{{ $row['nomor_surat'] }}</td>
                        <td class="px-6 py-3.5 text-slate-600 max-w-xs truncate">{{ $row['judul'] }}</td>
                        <td class="px-6 py-3.5 text-slate-600">{{ $row['dosen'] }}</td>
                        <td class="px-6 py-3.5 text-right">
                            <button @click="modal=true" class="px-3 py-1.5 rounded bg-teal-500 hover:bg-teal-600 text-white text-xs font-semibold inline-flex items-center gap-1.5">
                                @include('partials.icon', ['name' => 'pen', 'class' => 'w-3.5 h-3.5']) Tanda Tangani
                            </button>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <div x-show="modal" x-cloak class="fixed inset-0 z-50 grid place-items-center p-4 bg-black/40" @click.self="modal=false">
        <div class="bg-white rounded-xl w-full max-w-md shadow-xl">
            <div class="px-6 py-4 border-b border-slate-100 flex items-center justify-between">
                <h3 class="font-semibold text-slate-800">Tanda Tangan Digital (BSrE)</h3>
                <button @click="modal=false" class="text-slate-400">@include('partials.icon', ['name' => 'x', 'class' => 'w-5 h-5'])</button>
            </div>
            <div class="p-6 space-y-4">
                <label class="flex items-start gap-3 p-3 rounded-lg border border-slate-200">
                    <input type="checkbox" class="w-4 h-4 rounded text-teal-500 focus:ring-teal-500 mt-0.5">
                    <span class="text-sm text-slate-700">Saya mengesahkan surat tugas ini secara resmi dengan tanda tangan digital tersertifikasi BSrE.</span>
                </label>
                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-1.5">PIN Tanda Tangan</label>
                    <input type="password" placeholder="••••••" class="w-full rounded border border-slate-300 px-3 py-2 text-sm focus:border-teal-500 outline-none tracking-widest">
                </div>
            </div>
            <div class="px-6 py-4 border-t border-slate-100 flex justify-end gap-3">
                <button @click="modal=false" class="px-4 py-2 rounded border border-slate-300 text-sm font-medium text-slate-600">Batal</button>
                <button @click="modal=false" class="px-4 py-2 rounded bg-teal-500 hover:bg-teal-600 text-white text-sm font-semibold">Sahkan & Terbitkan</button>
            </div>
        </div>
    </div>
</div>
@endsection
