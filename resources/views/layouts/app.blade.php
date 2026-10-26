<!DOCTYPE html>
<html lang="id" class="h-full">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'SIGAP FEB') · SIGAP FEB</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: { sans: ['Inter', 'system-ui', 'sans-serif'] },
                    colors: {
                        navy:  { DEFAULT: '#1A2232', 900: '#141a27', 800: '#1A2232', 700: '#232d40' },
                        teal:  { 50:'#e6f6f7',100:'#c0eaed',500:'#009CA7',600:'#007A83',700:'#006971' },
                        surface: '#f8f9ff',
                    },
                    maxWidth: { content: '1440px' },
                }
            }
        }
    </script>
    <style>
        body { font-family: 'Inter', sans-serif; }
        ::-webkit-scrollbar { width: 8px; height: 8px; }
        ::-webkit-scrollbar-thumb { background: #cbd5e1; border-radius: 9999px; }
        [x-cloak] { display: none !important; }
        .tnum { font-variant-numeric: tabular-nums; }
    </style>
    <script defer src="https://cdn.jsdelivr.net/npm/@alpinejs/collapse@3.14.1/dist/cdn.min.js"></script>
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.14.1/dist/cdn.min.js"></script>
    <script>
        // Global Alpine stores for the prototype: document preview modal + toasts.
        document.addEventListener('alpine:init', () => {
            Alpine.store('preview', {
                open: false, name: '', meta: '', parts: [],
                show(name, meta, parts = []) { this.name = name; this.meta = meta || ''; this.parts = parts || []; this.open = true; },
                close() { this.open = false; }
            });
            Alpine.store('toast', {
                items: [],
                push(msg, tone = 'teal') {
                    const id = Date.now() + Math.random();
                    this.items.push({ id, msg, tone });
                    setTimeout(() => this.remove(id), 3200);
                },
                remove(id) { this.items = this.items.filter(t => t.id !== id); }
            });
        });
        // Helper dipakai di tombol: sigapToast('Pesan', 'green')
        function sigapToast(msg, tone) { window.Alpine && Alpine.store('toast').push(msg, tone || 'teal'); }
        function sigapPreview(name, meta, parts) { Alpine.store('preview').show(name, meta, parts); }
    </script>
</head>
<body class="h-full bg-surface text-[#0b1c30] antialiased">

@include('partials.preview-modal')
@include('partials.toasts')

<div class="flex min-h-full">

    {{-- ===================== SIDEBAR ===================== --}}
    <aside class="w-[280px] shrink-0 bg-navy text-white/70 flex flex-col fixed inset-y-0 left-0 z-30">
        {{-- Brand --}}
        <div class="h-16 flex items-center gap-3 px-6 border-b border-white/10">
            <div class="w-9 h-9 rounded-lg bg-teal-500 grid place-items-center font-bold text-white text-sm shrink-0">SG</div>
            <div class="leading-tight">
                <div class="text-white font-bold text-sm tracking-tight">SIGAP FEB</div>
                <div class="text-[10px] text-white/50 uppercase tracking-wider">Telkom University</div>
            </div>
        </div>

        {{-- Nav --}}
        <nav class="flex-1 overflow-y-auto py-4 px-3 space-y-5">
            @foreach($sidebar as [$group, $items])
                <div>
                    <div class="px-3 mb-2 text-[10px] font-semibold tracking-[0.12em] text-white/40 uppercase">{{ $group }}</div>
                    <div class="space-y-0.5">
                        @foreach($items as $item)
                            @php
                                $label = $item[0]; $href = $item[1]; $icon = $item[2]; $badge = $item[3] ?? null;
                                $active = request()->is(ltrim($href,'/')) || request()->is(ltrim($href,'/').'/*');
                            @endphp
                            <a href="{{ $href }}"
                               class="group flex items-center gap-3 pl-3 pr-2 py-2 rounded-md text-sm transition relative
                               {{ $active ? 'bg-teal-500/10 text-white font-semibold' : 'hover:bg-white/5 hover:text-white' }}">
                                @if($active)<span class="absolute left-0 top-1.5 bottom-1.5 w-1 rounded-full bg-teal-500"></span>@endif
                                <span class="shrink-0 {{ $active ? 'text-teal-500' : 'text-white/50 group-hover:text-white/80' }}">
                                    @include('partials.icon', ['name' => $icon, 'class' => 'w-[18px] h-[18px]'])
                                </span>
                                <span class="flex-1 truncate">{{ $label }}</span>
                                @if($badge)
                                    <span class="shrink-0 text-[10px] font-bold bg-teal-500 text-white rounded-full px-1.5 py-0.5 min-w-[18px] text-center">{{ $badge }}</span>
                                @endif
                            </a>
                        @endforeach
                    </div>
                </div>
            @endforeach
        </nav>

        {{-- Logout --}}
        <div class="p-3 border-t border-white/10">
            <form method="POST" action="/logout">
                @csrf
                <button class="w-full flex items-center gap-3 px-3 py-2 rounded-md text-sm text-white/60 hover:bg-white/5 hover:text-white transition">
                    @include('partials.icon', ['name' => 'logout', 'class' => 'w-[18px] h-[18px]'])
                    <span>Keluar</span>
                </button>
            </form>
        </div>
    </aside>

    {{-- ===================== MAIN ===================== --}}
    <div class="flex-1 ml-[280px] flex flex-col min-w-0">

        {{-- Header --}}
        <header class="h-16 bg-white border-b border-slate-200 flex items-center justify-between px-8 sticky top-0 z-20">
            <div class="min-w-0">
                <div class="text-xs text-slate-400">@yield('breadcrumb', 'SIGAP FEB')</div>
                <h1 class="text-base font-semibold text-slate-800 truncate">@yield('title', 'Dashboard')</h1>
            </div>

            <div class="flex items-center gap-3">
                {{-- Role switcher --}}
                <div class="hidden md:flex items-center gap-2 text-xs bg-slate-50 border border-slate-200 rounded-full px-3 py-1.5">
                    <span class="w-2 h-2 rounded-full bg-teal-500"></span>
                    <span class="text-slate-600">Mode Prototype · <span class="font-semibold text-slate-800">{{ $user['role_label'] }}</span></span>
                    <a href="/switch-role" class="text-teal-600 font-semibold hover:underline ml-1">Ganti</a>
                </div>

                {{-- Notifications --}}
                <div x-data="{ open:false }" class="relative">
                    <button @click="open=!open" class="relative w-10 h-10 grid place-items-center rounded-full hover:bg-slate-100 text-slate-600">
                        @include('partials.icon', ['name' => 'bell', 'class' => 'w-5 h-5'])
                        @if(count($notifications))<span class="absolute top-2 right-2 w-2 h-2 bg-rose-500 rounded-full"></span>@endif
                    </button>
                    <div x-show="open" x-cloak @click.outside="open=false"
                         class="absolute right-0 mt-2 w-80 bg-white rounded-lg border border-slate-200 shadow-[0_4px_12px_rgba(0,0,0,0.08)] overflow-hidden">
                        <div class="px-4 py-3 border-b border-slate-100 font-semibold text-sm text-slate-700">Notifikasi</div>
                        <div class="max-h-80 overflow-y-auto divide-y divide-slate-50">
                            @foreach($notifications as $n)
                                <div class="px-4 py-3 flex gap-3 hover:bg-slate-50">
                                    <span class="mt-1.5 w-2 h-2 rounded-full shrink-0 bg-{{ $n['tone'] }}-500"></span>
                                    <div class="min-w-0">
                                        <div class="text-sm text-slate-700">{{ $n['text'] }}</div>
                                        <div class="text-xs text-slate-400 mt-0.5">{{ $n['time'] }}</div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>

                {{-- User chip --}}
                <div class="flex items-center gap-3 pl-3 border-l border-slate-200">
                    <div class="text-right hidden sm:block leading-tight">
                        <div class="text-sm font-semibold text-slate-800">{{ $user['short'] }}</div>
                        <div class="text-xs text-slate-400">{{ $user['nip'] ?? '' }}</div>
                    </div>
                    <div class="w-9 h-9 rounded-full bg-teal-600 text-white grid place-items-center font-semibold text-sm">{{ $user['avatar'] }}</div>
                </div>
            </div>
        </header>

        {{-- Flash --}}
        @if(session('flash'))
            <div x-data="{show:true}" x-show="show" x-init="setTimeout(()=>show=false,4000)"
                 class="mx-8 mt-4 flex items-center justify-between gap-3 bg-teal-50 border border-teal-200 text-teal-800 rounded-lg px-4 py-3 text-sm">
                <div class="flex items-center gap-2">
                    @include('partials.icon', ['name' => 'check', 'class' => 'w-4 h-4'])
                    <span>{{ session('flash') }}</span>
                </div>
                <button @click="show=false" class="text-teal-600">@include('partials.icon', ['name' => 'x', 'class' => 'w-4 h-4'])</button>
            </div>
        @endif

        {{-- Content --}}
        <main class="flex-1 p-8">
            <div class="max-w-content mx-auto">
                @yield('content')
            </div>
        </main>

        <footer class="px-8 py-4 text-center text-xs text-slate-400 border-t border-slate-100">
            SIGAP FEB · Prototype UI (Laravel + Blade) — data contoh (mock). Integrasi database menyusul.
        </footer>
    </div>
</div>
</body>
</html>
