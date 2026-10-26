<!DOCTYPE html>
<html lang="id" class="h-full">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="theme-color" content="#1A2232">
    <title>Pilih Peran · SIGAP FEB</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <script>
        tailwind.config = { theme: { extend: {
            fontFamily: { sans: ['Inter', 'system-ui', 'sans-serif'] },
            colors: { navy: '#1A2232', teal: { 500: '#007A83', 600: '#00666E', 700: '#004F55' } }
        }}}
    </script>
    <link rel="stylesheet" href="{{ asset('css/sigap.css') }}">
</head>
<body class="min-h-full bg-slate-50 text-slate-900">
<a href="#role-selector" class="skip-link">Langsung ke pilihan peran</a>

<main class="grid min-h-screen lg:grid-cols-[minmax(320px,0.85fr)_minmax(560px,1.15fr)]">
    <section class="flex flex-col justify-between bg-navy px-6 py-8 text-white sm:px-10 lg:min-h-screen lg:p-12" aria-labelledby="brand-title">
        <div class="flex items-center gap-3">
            <div class="grid h-11 w-11 place-items-center rounded-md bg-teal-500 text-sm font-bold" aria-hidden="true">SG</div>
            <div>
                <div class="font-bold tracking-tight">SIGAP FEB</div>
                <div class="text-xs text-white/70">Telkom University</div>
            </div>
        </div>

        <div class="my-10 max-w-xl lg:my-16">
            <p class="mb-3 text-sm font-semibold text-[#82f3ff]">Portal administrasi FEB</p>
            <h1 id="brand-title" class="text-3xl font-bold leading-tight tracking-tight sm:text-4xl">Satu tempat untuk mengikuti proses administrasi dosen.</h1>
            <p class="mt-5 max-w-lg text-sm leading-7 text-white/80 sm:text-base">Pilih peran untuk melihat pengajuan, pemeriksaan dokumen, persetujuan, penomoran, dan penerbitan dari sudut pandang pengguna terkait.</p>
        </div>

        <div class="border-t border-white/15 pt-5 text-xs leading-5 text-white/70">
            Mode prototype. Tidak menggunakan kata sandi dan tidak menyimpan perubahan ke basis data.
        </div>
    </section>

    <section id="role-selector" class="flex items-center justify-center px-4 py-8 sm:px-8 lg:px-12" tabindex="-1" aria-labelledby="role-title">
        <div class="w-full max-w-xl">
            <div class="mb-6">
                <p class="text-sm font-semibold text-teal-700">Akses simulasi</p>
                <h2 id="role-title" class="mt-1 text-2xl font-bold tracking-tight text-slate-950 sm:text-3xl">Pilih peran pengguna</h2>
                <p class="mt-2 text-sm leading-6 text-slate-600">Setiap pilihan membuka navigasi dan tugas yang berbeda. Anda dapat mengganti peran kapan saja dari header aplikasi.</p>
            </div>

            <form method="POST" action="/login" class="grid gap-2 sm:grid-cols-2">
                @csrf
                @foreach($users as $role => $user)
                    <button name="role" value="{{ $role }}"
                            class="group flex min-h-[76px] w-full items-center gap-3 rounded-lg border border-slate-200 bg-white p-3 text-left transition hover:border-teal-500 hover:bg-teal-50">
                        <span class="grid h-11 w-11 shrink-0 place-items-center rounded-full bg-teal-600 text-sm font-semibold text-white" aria-hidden="true">{{ $user['avatar'] }}</span>
                        <span class="min-w-0 flex-1">
                            <span class="block truncate text-sm font-semibold text-slate-900">{{ $user['short'] }}</span>
                            <span class="mt-0.5 block text-xs leading-5 text-slate-600">{{ $user['role_label'] }}</span>
                        </span>
                        <svg class="h-5 w-5 shrink-0 text-slate-500 transition group-hover:translate-x-0.5 group-hover:text-teal-700" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true"><path d="m9 6 6 6-6 6"/></svg>
                    </button>
                @endforeach
            </form>
        </div>
    </section>
</main>
</body>
</html>
