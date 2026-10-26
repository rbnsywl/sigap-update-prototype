<!DOCTYPE html>
<html lang="id" class="h-full">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="theme-color" content="#1A2232">
    <title>@yield('title', 'SIGAP FEB') · SIGAP FEB</title>

    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: { sans: ['Inter', 'system-ui', 'sans-serif'] },
                    colors: {
                        navy: { DEFAULT: '#1A2232', 900: '#111827', 800: '#1A2232', 700: '#263247' },
                        teal: { 50: '#e6f6f7', 100: '#c0eaed', 500: '#007A83', 600: '#00666E', 700: '#004F55' },
                        surface: '#f6f8fb',
                    },
                    maxWidth: { content: '1440px' },
                }
            }
        }
    </script>
    <link rel="stylesheet" href="{{ asset('css/sigap.css') }}">

    <script>
        document.addEventListener('alpine:init', () => {
            Alpine.store('preview', {
                open: false,
                name: '',
                meta: '',
                parts: [],
                previousFocus: null,
                show(name, meta, parts = []) {
                    this.previousFocus = document.activeElement;
                    this.name = name;
                    this.meta = meta || '';
                    this.parts = parts || [];
                    this.open = true;
                    document.body.style.overflow = 'hidden';
                    Alpine.nextTick(() => document.querySelector('#document-preview-dialog [data-dialog-close]')?.focus());
                },
                close() {
                    this.open = false;
                    document.body.style.overflow = '';
                    Alpine.nextTick(() => this.previousFocus?.focus?.());
                }
            });

            Alpine.store('toast', {
                items: [],
                push(message, tone = 'teal') {
                    const id = Date.now() + Math.random();
                    this.items.push({ id, message, tone });
                    setTimeout(() => this.remove(id), 6000);
                },
                remove(id) {
                    this.items = this.items.filter((toast) => toast.id !== id);
                }
            });
        });

        function sigapToast(message, tone) {
            window.Alpine && Alpine.store('toast').push(message, tone || 'teal');
        }

        function sigapPreview(name, meta, parts) {
            Alpine.store('preview').show(name, meta, parts);
        }
    </script>
    <script defer src="https://cdn.jsdelivr.net/npm/@alpinejs/collapse@3.14.1/dist/cdn.min.js"></script>
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.14.1/dist/cdn.min.js"></script>
    <script defer src="{{ asset('js/sigap-ui.js') }}"></script>
</head>
<body class="h-full bg-surface text-[#0b1c30] antialiased">
<script>
    // Reveal the page as soon as the DOM is parsed, so styles are already applied
    // on first paint. This avoids the flash of unstyled content between navigations.
    (function () {
        function reveal() { document.body.classList.add('sigap-ready'); }
        if (document.readyState === 'loading') {
            document.addEventListener('DOMContentLoaded', reveal);
        } else {
            reveal();
        }
        // Hard fallback so the body is never stuck hidden.
        setTimeout(reveal, 400);
    })();
</script>
<a href="#main-content" class="skip-link">Lewati navigasi</a>

@include('partials.preview-modal')
@include('partials.toasts')

<div x-data="{ mobileNav: false }" @keydown.escape.window="mobileNav = false" class="min-h-full">
    <div x-show="mobileNav" x-cloak x-transition.opacity
         class="fixed inset-0 z-30 bg-slate-950/50 lg:hidden"
         aria-hidden="true"
         @click="mobileNav = false"></div>

    <aside id="primary-navigation"
           class="fixed inset-y-0 left-0 z-40 flex w-[280px] -translate-x-full flex-col bg-navy text-white/80 transition-transform duration-200 lg:translate-x-0"
           :class="mobileNav ? 'translate-x-0' : '-translate-x-full'"
           aria-label="Navigasi aplikasi">
        <div class="flex min-h-16 items-center gap-3 border-b border-white/10 px-5">
            <div class="grid h-10 w-10 shrink-0 place-items-center rounded-md bg-teal-500 text-sm font-bold text-white" aria-hidden="true">SG</div>
            <div class="min-w-0 leading-tight">
                <div class="text-sm font-bold tracking-tight text-white">SIGAP FEB</div>
                <div class="mt-0.5 text-[11px] font-medium text-white/70">Telkom University</div>
            </div>
            <button type="button" @click="mobileNav = false"
                    class="ml-auto grid h-11 w-11 place-items-center rounded-md text-white/80 hover:bg-white/10 lg:hidden"
                    aria-label="Tutup menu navigasi">
                @include('partials.icon', ['name' => 'x', 'class' => 'w-5 h-5'])
            </button>
        </div>

        <nav class="flex-1 space-y-5 overflow-y-auto px-3 py-4" aria-label="Navigasi utama">
            @foreach($sidebar as [$group, $items])
                <section aria-labelledby="nav-group-{{ $loop->index }}">
                    <h2 id="nav-group-{{ $loop->index }}" class="mb-2 px-3 text-[11px] font-semibold tracking-[0.08em] text-white/70">{{ $group }}</h2>
                    <div class="space-y-0.5">
                        @foreach($items as $item)
                            @php
                                $label = $item[0];
                                $href = $item[1];
                                $icon = $item[2];
                                $badge = $item[3] ?? null;
                                $active = request()->is(ltrim($href, '/')) || request()->is(ltrim($href, '/').'/*');
                            @endphp
                            <a href="{{ $href }}" @click="mobileNav = false"
                               @if($active) aria-current="page" @endif
                               class="group relative flex min-h-11 items-center gap-3 rounded-md py-2 pl-3 pr-2 text-sm transition
                               {{ $active ? 'bg-white/10 font-semibold text-white' : 'text-white/80 hover:bg-white/5 hover:text-white' }}">
                                @if($active)<span class="absolute inset-y-2 left-0 w-1 rounded-full bg-teal-500" aria-hidden="true"></span>@endif
                                <span class="shrink-0 {{ $active ? 'text-[#63d7e2]' : 'text-white/70 group-hover:text-white' }}">
                                    @include('partials.icon', ['name' => $icon, 'class' => 'w-[18px] h-[18px]'])
                                </span>
                                <span class="min-w-0 flex-1">{{ $label }}</span>
                                @if($badge)
                                    <span class="min-w-[24px] shrink-0 rounded-full bg-teal-500 px-2 py-0.5 text-center text-[11px] font-bold text-white"
                                          aria-label="{{ $badge }} item menunggu">{{ $badge }}</span>
                                @endif
                            </a>
                        @endforeach
                    </div>
                </section>
            @endforeach
        </nav>

        <div class="space-y-1 border-t border-white/10 p-3">
            <a href="/switch-role" class="flex min-h-11 w-full items-center gap-3 rounded-md px-3 py-2 text-sm text-white/80 transition hover:bg-white/5 hover:text-white md:hidden">
                @include('partials.icon', ['name' => 'users', 'class' => 'w-[18px] h-[18px]'])
                <span>Ganti peran</span>
            </a>
            <form method="POST" action="/logout">
                @csrf
                <button class="flex min-h-11 w-full items-center gap-3 rounded-md px-3 py-2 text-sm text-white/80 transition hover:bg-white/5 hover:text-white">
                    @include('partials.icon', ['name' => 'logout', 'class' => 'w-[18px] h-[18px]'])
                    <span>Keluar</span>
                </button>
            </form>
        </div>
    </aside>

    <div class="flex min-h-screen min-w-0 flex-col lg:ml-[280px]">
        <header class="sticky top-0 z-20 flex min-h-16 items-center justify-between gap-3 border-b border-slate-200 bg-white/95 px-4 py-2 sm:px-6 lg:px-8">
            <div class="flex min-w-0 items-center gap-3">
                <button type="button" @click="mobileNav = true"
                        class="grid h-11 w-11 shrink-0 place-items-center rounded-md border border-slate-300 text-slate-700 hover:bg-slate-50 lg:hidden"
                        :aria-expanded="mobileNav.toString()" aria-controls="primary-navigation" aria-label="Buka menu navigasi">
                    <svg class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true">
                        <path d="M4 7h16M4 12h16M4 17h16"/>
                    </svg>
                </button>
                <div class="min-w-0">
                    <nav aria-label="Breadcrumb" class="hidden text-xs text-slate-500 sm:block">@yield('breadcrumb', 'SIGAP FEB')</nav>
                    <h1 class="truncate text-sm font-semibold text-slate-900 sm:text-base">@yield('title', 'Dashboard')</h1>
                </div>
            </div>

            <div class="flex items-center gap-2 sm:gap-3">
                <div class="hidden items-center gap-2 rounded-md border border-slate-200 bg-slate-50 px-3 py-2 text-xs md:flex">
                    <span class="h-2 w-2 rounded-full bg-teal-500" aria-hidden="true"></span>
                    <span class="text-slate-600">Prototype: <span class="font-semibold text-slate-800">{{ $user['role_label'] }}</span></span>
                    <a href="/switch-role" class="ml-1 font-semibold text-teal-700 hover:underline">Ganti peran</a>
                </div>

                @php
                    $notificationToneClasses = [
                        'rose' => 'bg-rose-600',
                        'amber' => 'bg-amber-600',
                        'teal' => 'bg-teal-600',
                        'blue' => 'bg-blue-600',
                        'green' => 'bg-green-600',
                    ];
                @endphp
                <div x-data="{ open:false }" @keydown.escape.window="open = false" class="relative">
                    <button type="button" @click="open = !open"
                            class="relative grid h-11 w-11 place-items-center rounded-md text-slate-700 hover:bg-slate-100"
                            :aria-expanded="open.toString()" aria-controls="notifications-panel"
                            aria-label="Buka notifikasi, {{ count($notifications) }} notifikasi">
                        @include('partials.icon', ['name' => 'bell', 'class' => 'w-5 h-5'])
                        @if(count($notifications))
                            <span class="absolute right-2 top-2 h-2.5 w-2.5 rounded-full border-2 border-white bg-rose-600" aria-hidden="true"></span>
                        @endif
                    </button>
                    <section id="notifications-panel" x-show="open" x-cloak x-transition.origin.top.right @click.outside="open = false"
                             class="sigap-popover absolute right-0 mt-2 overflow-hidden rounded-lg border border-slate-200 bg-white shadow-lg"
                             aria-label="Daftar notifikasi">
                        <div class="border-b border-slate-100 px-4 py-3 text-sm font-semibold text-slate-800">Notifikasi</div>
                        <div class="max-h-80 divide-y divide-slate-100 overflow-y-auto">
                            @forelse($notifications as $notification)
                                <div class="flex gap-3 px-4 py-3">
                                    <span class="mt-1.5 h-2.5 w-2.5 shrink-0 rounded-full {{ $notificationToneClasses[$notification['tone']] ?? 'bg-slate-600' }}" aria-hidden="true"></span>
                                    <div class="min-w-0">
                                        <div class="text-sm text-slate-700">{{ $notification['text'] }}</div>
                                        <div class="mt-0.5 text-xs text-slate-500">{{ $notification['time'] }}</div>
                                    </div>
                                </div>
                            @empty
                                <div class="px-4 py-6 text-center text-sm text-slate-600">Belum ada notifikasi untuk peran ini.</div>
                            @endforelse
                        </div>
                    </section>
                </div>

                <div class="flex items-center gap-3 border-l border-slate-200 pl-2 sm:pl-3">
                    <div class="hidden text-right leading-tight sm:block">
                        <div class="text-sm font-semibold text-slate-800">{{ $user['short'] }}</div>
                        <div class="text-xs text-slate-500">{{ $user['nip'] ?? '' }}</div>
                    </div>
                    <div class="grid h-10 w-10 place-items-center rounded-full bg-teal-600 text-sm font-semibold text-white" aria-hidden="true">{{ $user['avatar'] }}</div>
                </div>
            </div>
        </header>

        @if(session('flash'))
            <div x-data="{ show:true }" x-show="show" role="status" aria-live="polite"
                 class="mx-4 mt-4 flex items-center justify-between gap-3 rounded-lg border border-teal-200 bg-teal-50 px-4 py-3 text-sm text-teal-800 sm:mx-6 lg:mx-8">
                <div class="flex items-center gap-2">
                    @include('partials.icon', ['name' => 'check', 'class' => 'w-4 h-4'])
                    <span>{{ session('flash') }}</span>
                </div>
                <button type="button" @click="show = false" class="grid h-11 w-11 place-items-center rounded-md text-teal-700" aria-label="Tutup pemberitahuan">
                    @include('partials.icon', ['name' => 'x', 'class' => 'w-4 h-4'])
                </button>
            </div>
        @endif

        <main id="main-content" tabindex="-1" class="flex-1 p-4 sm:p-6 lg:p-8">
            <div class="mx-auto max-w-content">
                @yield('content')
            </div>
        </main>

        <footer class="border-t border-slate-200 bg-white px-4 py-4 text-center text-xs text-slate-600 sm:px-6 lg:px-8">
            SIGAP FEB. Prototype antarmuka dengan data simulasi; integrasi basis data dilakukan pada tahap berikutnya.
        </footer>
    </div>
</div>
</body>
</html>
