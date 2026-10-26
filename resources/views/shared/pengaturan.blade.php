@extends('layouts.app')
@section('title', 'Pengaturan')
@section('breadcrumb', 'Sistem / Pengaturan')

@section('content')
    @include('partials.page-head', ['heading' => 'Pengaturan', 'sub' => 'Preferensi akun & sistem.'])
    <div class="bg-white rounded-lg border border-slate-200 max-w-2xl divide-y divide-slate-50">
        @foreach([
            ['Notifikasi Email','Terima ringkasan status pengajuan via email', true],
            ['Notifikasi Tenggat LKS','Pengingat 7 hari sebelum jatuh tempo', true],
            ['Mode Ringkas Tabel','Tampilkan lebih banyak baris per layar', false],
        ] as [$t,$d,$on])
            <div class="px-6 py-4 flex items-center justify-between">
                <div><div class="text-sm font-medium text-slate-800">{{ $t }}</div><div class="text-xs text-slate-500">{{ $d }}</div></div>
                <div x-data="{on: {{ $on ? 'true':'false' }} }" @click="on=!on" class="w-11 h-6 rounded-full p-0.5 cursor-pointer transition" :class="on?'bg-teal-500':'bg-slate-300'">
                    <div class="w-5 h-5 rounded-full bg-white transition" :class="on?'translate-x-5':''"></div>
                </div>
            </div>
        @endforeach
    </div>
@endsection
