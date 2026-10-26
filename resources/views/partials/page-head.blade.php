<div class="flex flex-wrap items-start justify-between gap-4 mb-6">
    <div>
        <h2 class="text-2xl font-bold text-slate-900 tracking-tight">{{ $heading }}</h2>
        @isset($sub)<p class="text-sm text-slate-500 mt-1">{{ $sub }}</p>@endisset
    </div>
    @isset($actions){{ $actions }}@endisset
</div>
