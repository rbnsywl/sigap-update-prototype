@extends('layouts.app')
@section('title', 'Penomoran Surat Tugas')
@section('breadcrumb', 'Tata Kelola / Penomoran')

@section('content')
<div x-data="{ modal:false, judul:'' }">
    @include('partials.page-head', ['heading' => 'Penomoran Surat Tugas', 'sub' => 'Alokasi nomor keluar dari register buku nomor resmi dekanat.'])
    @php $ready = collect($st)->take(3); @endphp
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
                            <button @click="modal=true; judul='{{ addslashes($row['judul']) }}'" class="px-3 py-1.5 rounded bg-teal-500 hover:bg-teal-600 text-white text-xs font-semibold inline-flex items-center gap-1.5">
                                @include('partials.icon', ['name' => 'hash', 'class' => 'w-3.5 h-3.5']) Beri Nomor
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
                <h3 class="font-semibold text-slate-800">Alokasi Nomor Surat</h3>
                <button @click="modal=false" class="text-slate-400">@include('partials.icon', ['name' => 'x', 'class' => 'w-5 h-5'])</button>
            </div>
            <div class="p-6 space-y-4">
                <p class="text-sm text-slate-500" x-text="judul"></p>
                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-1.5">Nomor Surat (dari Buku Agenda)</label>
                    <input value="FEB/SDM-ST/X/2026/046" class="w-full rounded border border-slate-300 px-3 py-2 text-sm focus:border-teal-500 outline-none tnum">
                    <p class="text-xs text-slate-400 mt-1">Saran otomatis dari register. Dapat diubah manual.</p>
                </div>
                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-1.5">Tanggal Registrasi</label>
                    <input type="date" value="2026-10-26" class="w-full rounded border border-slate-300 px-3 py-2 text-sm focus:border-teal-500 outline-none">
                </div>
            </div>
            <div class="px-6 py-4 border-t border-slate-100 flex justify-end gap-3">
                <button @click="modal=false" class="px-4 py-2 rounded border border-slate-300 text-sm font-medium text-slate-600">Batal</button>
                <button @click="modal=false" class="px-4 py-2 rounded bg-teal-500 hover:bg-teal-600 text-white text-sm font-semibold">Simpan & Teruskan ke SDM</button>
            </div>
        </div>
    </div>
</div>
@endsection
