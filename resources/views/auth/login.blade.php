<!DOCTYPE html>
<html lang="id" class="h-full">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Masuk · SIGAP FEB</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <script>
        tailwind.config = { theme: { extend: {
            fontFamily: { sans: ['Inter','sans-serif'] },
            colors: { navy:'#1A2232', teal:{500:'#009CA7',600:'#007A83'} }
        }}}
    </script>
    <style>body{font-family:'Inter',sans-serif}</style>
</head>
<body class="h-full bg-navy text-white">
<div class="min-h-full grid lg:grid-cols-2">

    {{-- Left brand panel --}}
    <div class="hidden lg:flex flex-col justify-between p-12 bg-gradient-to-br from-[#1A2232] to-[#0f1521] relative overflow-hidden">
        <div class="absolute -top-20 -right-20 w-80 h-80 rounded-full bg-teal-500/10 blur-2xl"></div>
        <div class="flex items-center gap-3 relative">
            <div class="w-10 h-10 rounded-lg bg-teal-500 grid place-items-center font-bold">SG</div>
            <div class="font-bold tracking-tight">SIGAP FEB</div>
        </div>
        <div class="relative">
            <h1 class="text-4xl font-bold leading-tight">Sistem Integrasi Administrasi<br>& Pengelolaan Sumber Daya</h1>
            <p class="mt-4 text-white/60 max-w-md">Portal terpusat Fakultas Ekonomi dan Bisnis — Telkom University. Surat Tugas, Studi PID, LKS, Reimburs, dan Penyetaraan S3 dalam satu alur yang transparan.</p>
        </div>
        <div class="relative text-xs text-white/40">Prototype UI · Mode demonstrasi tanpa autentikasi nyata</div>
    </div>

    {{-- Right: role selector --}}
    <div class="flex items-center justify-center p-6 lg:p-12 bg-[#f8f9ff] text-slate-800">
        <div class="w-full max-w-md">
            <div class="lg:hidden flex items-center gap-3 mb-8">
                <div class="w-10 h-10 rounded-lg bg-teal-500 grid place-items-center font-bold text-white">SG</div>
                <div class="font-bold tracking-tight text-navy">SIGAP FEB</div>
            </div>

            <h2 class="text-2xl font-bold text-slate-900">Masuk sebagai…</h2>
            <p class="text-sm text-slate-500 mt-1 mb-6">Pilih peran untuk menjelajahi prototype. Setiap peran memiliki sidebar & hak akses berbeda (RBAC).</p>

            <form method="POST" action="/login" class="space-y-2">
                @csrf
                @foreach($users as $role => $u)
                    <button name="role" value="{{ $role }}"
                            class="w-full flex items-center gap-4 p-3.5 rounded-lg border border-slate-200 bg-white hover:border-teal-500 hover:shadow-sm transition text-left group">
                        <span class="w-11 h-11 rounded-full bg-teal-600 text-white grid place-items-center font-semibold shrink-0">{{ $u['avatar'] }}</span>
                        <span class="flex-1 min-w-0">
                            <span class="block font-semibold text-slate-800 text-sm truncate">{{ $u['short'] }}</span>
                            <span class="block text-xs text-slate-500">{{ $u['role_label'] }}</span>
                        </span>
                        <span class="text-slate-300 group-hover:text-teal-500 transition">
                            <svg class="w-5 h-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="m9 6 6 6-6 6"/></svg>
                        </span>
                    </button>
                @endforeach
            </form>

            <p class="text-xs text-slate-400 mt-6 text-center">Tidak ada kata sandi — ini lingkungan prototyping.</p>
        </div>
    </div>
</div>
</body>
</html>
