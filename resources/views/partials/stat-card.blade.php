@php
    $tones = [
        'slate' => ['bg-slate-100', 'text-slate-700'],
        'green' => ['bg-green-100', 'text-green-800'],
        'teal' => ['bg-teal-100', 'text-teal-800'],
        'amber' => ['bg-amber-100', 'text-amber-800'],
        'blue' => ['bg-blue-100', 'text-blue-800'],
        'rose' => ['bg-rose-100', 'text-rose-800'],
    ];
    [$backgroundClass, $foregroundClass] = $tones[$tone ?? 'slate'] ?? $tones['slate'];
@endphp
<article class="rounded-lg border border-slate-200 bg-white p-5">
    <div class="flex items-start justify-between gap-4">
        <dl class="min-w-0">
            <dt class="text-sm font-medium text-slate-600">{{ $label }}</dt>
            <dd class="mt-2 break-words text-2xl font-bold tracking-tight text-slate-950 tnum sm:text-3xl">{{ $value }}</dd>
            @isset($hint)<dd class="mt-1 text-xs leading-5 text-slate-600">{{ $hint }}</dd>@endisset
        </dl>
        @isset($icon)
            <span class="grid h-11 w-11 shrink-0 place-items-center rounded-md {{ $backgroundClass }} {{ $foregroundClass }}" aria-hidden="true">
                @include('partials.icon', ['name' => $icon, 'class' => 'w-5 h-5'])
            </span>
        @endisset
    </div>
</article>
