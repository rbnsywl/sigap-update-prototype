<header class="mb-6 flex flex-col gap-4 border-b border-slate-200 pb-5 sm:flex-row sm:items-start sm:justify-between">
    <div class="max-w-3xl">
        <h2 class="text-xl font-bold tracking-tight text-slate-950 sm:text-2xl">{{ $heading }}</h2>
        @isset($sub)<p class="mt-1.5 text-sm leading-6 text-slate-600">{{ $sub }}</p>@endisset
    </div>
    @isset($actions)<div class="flex shrink-0 flex-wrap items-center gap-2">{{ $actions }}</div>@endisset
</header>
