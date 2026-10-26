@extends('layouts.app')
@section('title', 'Kelulusan PID')
@section('breadcrumb', 'Studi PID / Kelulusan')

@section('content')
    @include('partials.page-head', ['heading' => 'Pelaporan Kelulusan PID', 'sub' => 'Laporkan wisuda/ijazah doktoral untuk penutupan beasiswa.'])
    <div class="bg-white rounded-lg border border-slate-200 max-w-2xl">
        <div class="px-6 py-4 border-b border-slate-100"><h3 class="font-semibold text-slate-800">Formulir Kelulusan Doktoral</h3></div>
        <div class="p-6 grid grid-cols-1 md:grid-cols-2 gap-5">
            <div><label class="block text-sm font-medium text-slate-700 mb-1.5">Tanggal Kelulusan / Wisuda</label><input type="date" class="w-full rounded border border-slate-300 px-3 py-2 text-sm focus:border-teal-500 outline-none"></div>
            <div><label class="block text-sm font-medium text-slate-700 mb-1.5">IPK Akhir</label><input type="number" step="0.01" max="4" placeholder="3.90" class="w-full rounded border border-slate-300 px-3 py-2 text-sm focus:border-teal-500 outline-none"></div>
            <div class="md:col-span-2"><label class="block text-sm font-medium text-slate-700 mb-1.5">Judul Disertasi Final</label><input class="w-full rounded border border-slate-300 px-3 py-2 text-sm focus:border-teal-500 outline-none"></div>
            <div class="md:col-span-2"><label class="block text-sm font-medium text-slate-700 mb-2">Unggah Ijazah & Transkrip S3 (PDF)</label>@include('partials.dropzone', ['label' => 'Unggah ijazah & transkrip final'])</div>
            <div class="md:col-span-2 flex justify-end">
                <button class="px-5 py-2.5 rounded bg-teal-500 hover:bg-teal-600 text-white text-sm font-semibold inline-flex items-center gap-2">@include('partials.icon', ['name' => 'send', 'class' => 'w-4 h-4']) Laporkan Kelulusan</button>
            </div>
        </div>
    </div>
@endsection
