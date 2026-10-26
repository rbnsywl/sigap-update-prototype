@php
    $tones = [
        'green'  => 'bg-green-100 text-green-800',
        'amber'  => 'bg-amber-100 text-amber-800',
        'teal'   => 'bg-teal-100 text-teal-800',
        'blue'   => 'bg-blue-100 text-blue-800',
        'indigo' => 'bg-indigo-100 text-indigo-800',
        'rose'   => 'bg-rose-100 text-rose-800',
        'slate'  => 'bg-slate-100 text-slate-700',
        'purple' => 'bg-purple-100 text-purple-800',
    ];
    $tone = $tones[$tone ?? 'slate'] ?? $tones['slate'];
@endphp
<span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-semibold {{ $tone }}">{{ $label }}</span>
