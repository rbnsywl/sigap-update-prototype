@extends('layouts.app')
@section('title', 'Pengaturan')
@section('breadcrumb', 'Sistem / Pengaturan')

@section('content')
    @include('partials.page-head', ['heading' => 'Pengaturan', 'sub' => 'Atur pemberitahuan dan kepadatan tampilan untuk simulasi akun ini.'])

    <section class="max-w-2xl overflow-hidden rounded-lg border border-slate-200 bg-white" aria-labelledby="preferences-title">
        <div class="border-b border-slate-200 px-5 py-4 sm:px-6">
            <h3 id="preferences-title" class="text-sm font-semibold text-slate-900">Preferensi antarmuka</h3>
            <p class="mt-1 text-xs text-slate-600">Perubahan hanya berlaku selama halaman prototype ini terbuka.</p>
        </div>
        <div class="divide-y divide-slate-100">
            @foreach([
                ['email-notifications', 'Notifikasi email', 'Terima ringkasan status pengajuan melalui email.', true],
                ['lks-reminders', 'Pengingat tenggat LKS', 'Tampilkan pengingat tujuh hari sebelum tenggat.', true],
                ['compact-tables', 'Tabel ringkas', 'Kurangi tinggi baris agar lebih banyak data terlihat.', false],
            ] as [$id, $title, $description, $enabled])
                <label for="{{ $id }}" x-data="{ enabled: {{ $enabled ? 'true' : 'false' }} }" class="flex min-h-[76px] cursor-pointer items-center justify-between gap-5 px-5 py-4 hover:bg-slate-50 sm:px-6">
                    <span class="min-w-0">
                        <span class="block text-sm font-semibold text-slate-900">{{ $title }}</span>
                        <span id="{{ $id }}-description" class="mt-1 block text-xs leading-5 text-slate-600">{{ $description }}</span>
                    </span>
                    <span class="relative shrink-0">
                        <input id="{{ $id }}" type="checkbox" x-model="enabled" @change="sigapToast('{{ $title }} diperbarui untuk simulasi ini', 'teal')"
                               class="peer sr-only" aria-describedby="{{ $id }}-description" role="switch" :aria-checked="enabled.toString()">
                        <span class="sigap-switch" aria-hidden="true"></span>
                    </span>
                </label>
            @endforeach
        </div>
    </section>
@endsection
