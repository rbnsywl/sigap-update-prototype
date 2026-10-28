@extends('layouts.app')
@section('title', 'Dashboard')
@section('breadcrumb', 'Utama / Dashboard')

@section('content')
    <div class="mb-6">
        <h2 class="text-2xl font-bold text-slate-900">Selamat datang, {{ $user['short'] }} 👋</h2>
        <p class="text-sm text-slate-500 mt-1">Ringkasan Surat Tugas & studi mandiri (Non-PID) Anda.</p>
    </div>

    {{-- Stat cards (tanpa plafon beasiswa) --}}
    <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-6">
        @include('partials.stat-card', ['label' => 'ST Diproses', 'value' => 2, 'tone' => 'amber', 'icon' => 'edit'])
        @include('partials.stat-card', ['label' => 'ST Terbit', 'value' => 3, 'tone' => 'green', 'icon' => 'folder'])
        @include('partials.stat-card', ['label' => 'LKS Semester Ini', 'value' => '1', 'tone' => 'blue', 'icon' => 'clipboard', 'hint' => 'Menunggu review SDM'])
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        {{-- Pengajuan aktif --}}
        <div class="lg:col-span-2 bg-white rounded-lg border border-slate-200">
            <div class="px-5 py-4 border-b border-slate-100 flex items-center justify-between">
                <h3 class="font-semibold text-slate-800">Pengajuan Surat Tugas Aktif</h3>
                <a href="/surat-tugas/riwayat" class="text-sm text-teal-600 font-semibold hover:underline">Lihat semua</a>
            </div>
            <div class="divide-y divide-slate-50">
                @foreach(array_slice($st, 0, 4) as $row)
                    <div class="px-5 py-3.5 flex items-center gap-4">
                        <div class="w-10 h-10 rounded-lg bg-teal-50 text-teal-600 grid place-items-center shrink-0">
                            @include('partials.icon', ['name' => 'doc', 'class' => 'w-5 h-5'])
                        </div>
                        <div class="min-w-0 flex-1">
                            <div class="text-sm font-medium text-slate-800 truncate">{{ $row['judul'] }}</div>
                            <div class="text-xs text-slate-400 mt-0.5">{{ $row['id'] }} · {{ $row['tipe'] }}</div>
                        </div>
                        @include('partials.badge', ['label' => $row['status'], 'tone' => \App\Support\MockData::stStatuses()[$row['status']] ?? 'slate'])
                    </div>
                @endforeach
            </div>
        </div>

        {{-- Tenggat & pintasan --}}
        <div class="space-y-6">
            <div class="bg-white rounded-lg border border-slate-200 p-5">
                <h3 class="font-semibold text-slate-800 mb-3">Tenggat Waktu</h3>
                <div class="flex items-start gap-3 p-3 rounded-lg bg-amber-50 border border-amber-100">
                    @include('partials.icon', ['name' => 'clock', 'class' => 'w-5 h-5 text-amber-600 mt-0.5'])
                    <div>
                        <div class="text-sm font-medium text-amber-800">Lapor LKS semester ini</div>
                        <div class="text-xs text-amber-700 mt-0.5">Jatuh tempo dalam 10 hari</div>
                    </div>
                </div>
            </div>
            <div class="bg-white rounded-lg border border-slate-200 p-5">
                <h3 class="font-semibold text-slate-800 mb-3">Pintasan Cepat</h3>
                <div class="grid grid-cols-2 gap-2">
                    <a href="/surat-tugas/ajukan" class="flex flex-col items-center gap-2 p-3 rounded-lg border border-slate-200 hover:border-teal-400 hover:bg-teal-50/40 transition text-center">
                        @include('partials.icon', ['name' => 'edit', 'class' => 'w-5 h-5 text-teal-600'])
                        <span class="text-xs font-medium text-slate-600">Ajukan ST</span>
                    </a>
                    <a href="/studi-non-pid/lks" class="flex flex-col items-center gap-2 p-3 rounded-lg border border-slate-200 hover:border-teal-400 hover:bg-teal-50/40 transition text-center">
                        @include('partials.icon', ['name' => 'clipboard', 'class' => 'w-5 h-5 text-teal-600'])
                        <span class="text-xs font-medium text-slate-600">Lapor LKS</span>
                    </a>
                    <a href="/studi-non-pid/penyetaraan" class="flex flex-col items-center gap-2 p-3 rounded-lg border border-slate-200 hover:border-teal-400 hover:bg-teal-50/40 transition text-center">
                        @include('partials.icon', ['name' => 'scroll', 'class' => 'w-5 h-5 text-teal-600'])
                        <span class="text-xs font-medium text-slate-600">Penyetaraan S3</span>
                    </a>
                    <a href="/surat-tugas/riwayat" class="flex flex-col items-center gap-2 p-3 rounded-lg border border-slate-200 hover:border-teal-400 hover:bg-teal-50/40 transition text-center">
                        @include('partials.icon', ['name' => 'folder', 'class' => 'w-5 h-5 text-teal-600'])
                        <span class="text-xs font-medium text-slate-600">Riwayat ST</span>
                    </a>
                </div>
            </div>
        </div>
    </div>
@endsection
