@php
    $tones = [
        'slate' => ['bg-slate-100','text-slate-600'],
        'green' => ['bg-green-100','text-green-700'],
        'teal'  => ['bg-teal-100','text-teal-700'],
        'amber' => ['bg-amber-100','text-amber-700'],
        'blue'  => ['bg-blue-100','text-blue-700'],
        'rose'  => ['bg-rose-100','text-rose-700'],
    ];
    [$bg,$fg] = $tones[$tone ?? 'slate'] ?? $tones['slate'];
@endphp
<div class="bg-white rounded-lg border border-slate-200 p-5">
    <div class="flex items-start justify-between">
        <div>
            <div class="text-sm text-slate-500">{{ $label }}</div>
            <div class="mt-2 text-3xl font-bold text-slate-900 tnum">{{ $value }}</div>
            @isset($hint)<div class="mt-1 text-xs text-slate-400">{{ $hint }}</div>@endisset
        </div>
        @isset($icon)
            <div class="w-10 h-10 rounded-lg grid place-items-center {{ $bg }} {{ $fg }}">
                @include('partials.icon', ['name' => $icon, 'class' => 'w-5 h-5'])
            </div>
        @endisset
    </div>
</div>
