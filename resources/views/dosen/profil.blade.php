@extends('layouts.app')
@section('title', 'Profil Saya')
@section('breadcrumb', 'Utama / Profil')

@section('content')
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <div class="bg-white rounded-lg border border-slate-200 p-6 text-center">
            <div class="w-20 h-20 rounded-full bg-teal-600 text-white grid place-items-center text-2xl font-bold mx-auto">{{ $user['avatar'] }}</div>
            <div class="mt-4 font-semibold text-slate-900">{{ $user['name'] }}</div>
            <div class="text-sm text-slate-500">{{ $user['role_label'] }}</div>
            @include('partials.badge', ['label' => 'Tetap YPT', 'tone' => 'green'])
        </div>
        <div class="lg:col-span-2 bg-white rounded-lg border border-slate-200">
            <div class="px-6 py-4 border-b border-slate-100"><h3 class="font-semibold text-slate-800">Data Kepegawaian</h3></div>
            <dl class="p-6 grid grid-cols-2 gap-x-6 gap-y-4 text-sm">
                <div><dt class="text-slate-400">NIP</dt><dd class="font-medium text-slate-800 tnum">{{ $user['nip'] ?? '-' }}</dd></div>
                <div><dt class="text-slate-400">Program Studi</dt><dd class="font-medium text-slate-800">{{ $user['prodi'] ?? '-' }}</dd></div>
                <div><dt class="text-slate-400">Jabatan Akademik (JAD)</dt><dd class="font-medium text-slate-800">{{ $user['jad'] ?? '-' }}</dd></div>
                <div><dt class="text-slate-400">Kelompok Keahlian</dt><dd class="font-medium text-slate-800">{{ $user['kk'] ?? '-' }}</dd></div>
                <div><dt class="text-slate-400">Status Kepegawaian</dt><dd class="font-medium text-slate-800">Dosen Tetap YPT</dd></div>
                <div><dt class="text-slate-400">Riwayat Pendidikan</dt><dd class="font-medium text-slate-800">S1 UNPAD · S2 ITB · (S3 on-going UNPAD)</dd></div>
            </dl>
        </div>
    </div>
@endsection
