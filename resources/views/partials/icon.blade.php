@php
    // Minimal inline SVG icon set (Lucide-style, 24x24, stroke currentColor).
    $paths = [
        'home' => '<path d="M3 9.5 12 3l9 6.5"/><path d="M5 10v10h14V10"/>',
        'user' => '<circle cx="12" cy="8" r="4"/><path d="M4 20c0-3.3 3.6-6 8-6s8 2.7 8 6"/>',
        'edit' => '<path d="M12 20h9"/><path d="M16.5 3.5a2.1 2.1 0 0 1 3 3L7 19l-4 1 1-4Z"/>',
        'folder' => '<path d="M3 7a2 2 0 0 1 2-2h4l2 2h8a2 2 0 0 1 2 2v9a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2Z"/>',
        'search' => '<circle cx="11" cy="11" r="7"/><path d="m21 21-4.3-4.3"/>',
        'doc' => '<path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8Z"/><path d="M14 2v6h6"/>',
        'clipboard' => '<rect x="8" y="3" width="8" height="4" rx="1"/><path d="M8 5H6a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V7a2 2 0 0 0-2-2h-2"/>',
        'wallet' => '<path d="M3 7a2 2 0 0 1 2-2h12v4"/><path d="M3 7v10a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-6H6a3 3 0 0 1-3-3Z"/><circle cx="17" cy="14" r="1"/>',
        'cap' => '<path d="m12 4 10 5-10 5L2 9Z"/><path d="M6 11v5c0 1.5 2.7 3 6 3s6-1.5 6-3v-5"/>',
        'scroll' => '<path d="M5 4h11a2 2 0 0 1 2 2v12a2 2 0 0 0 2 2H8a2 2 0 0 1-2-2V6a2 2 0 0 0-2-2Z"/><path d="M8 8h7M8 12h7"/>',
        'help' => '<circle cx="12" cy="12" r="9"/><path d="M9.5 9a2.5 2.5 0 0 1 4.5 1.5c0 1.5-2 2-2 3"/><circle cx="12" cy="17" r="0.5"/>',
        'inbox' => '<path d="M3 12h5l2 3h4l2-3h5"/><path d="M5 5h14l2 7v5a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-5Z"/>',
        'users' => '<circle cx="9" cy="8" r="3"/><path d="M3 20c0-3 2.7-5 6-5s6 2 6 5"/><path d="M16 5a3 3 0 0 1 0 6"/><path d="M18 20c0-2-1-3.5-2.5-4.3"/>',
        'archive' => '<rect x="3" y="4" width="18" height="4" rx="1"/><path d="M5 8v11a1 1 0 0 0 1 1h12a1 1 0 0 0 1-1V8"/><path d="M10 12h4"/>',
        'check' => '<path d="M20 6 9 17l-5-5"/>',
        'chart' => '<path d="M4 20V4"/><path d="M4 20h16"/><rect x="7" y="12" width="3" height="5"/><rect x="12" y="8" width="3" height="9"/><rect x="17" y="5" width="3" height="12"/>',
        'settings' => '<circle cx="12" cy="12" r="3"/><path d="M19 12a7 7 0 0 0-.1-1l2-1.5-2-3.5-2.4 1a7 7 0 0 0-1.7-1l-.3-2.5h-4l-.3 2.5a7 7 0 0 0-1.7 1l-2.4-1-2 3.5L5 11a7 7 0 0 0 0 2l-2 1.5 2 3.5 2.4-1a7 7 0 0 0 1.7 1l.3 2.5h4l.3-2.5a7 7 0 0 0 1.7-1l2.4 1 2-3.5-2-1.5c.1-.3.1-.7.1-1Z"/>',
        'hash' => '<path d="M4 9h16M4 15h16M10 3 8 21M16 3l-2 18"/>',
        'printer' => '<path d="M6 9V3h12v6"/><rect x="4" y="9" width="16" height="7" rx="2"/><path d="M8 16h8v5H8z"/>',
        'report' => '<path d="M6 2h9l5 5v15a0 0 0 0 1 0 0H6a2 2 0 0 1-2-2V4a2 2 0 0 1 2-2Z"/><path d="M14 2v5h5"/><path d="M8 13h8M8 17h5"/>',
        'shield' => '<path d="M12 3 5 6v5c0 4 3 7 7 9 4-2 7-5 7-9V6Z"/><path d="m9 12 2 2 4-4"/>',
        'book' => '<path d="M5 4h12a2 2 0 0 1 2 2v14H7a2 2 0 0 1-2-2Z"/><path d="M5 18a2 2 0 0 1 2-2h12"/>',
        'pen' => '<path d="M12 20h9"/><path d="M16.5 3.5a2.1 2.1 0 0 1 3 3L7 19l-4 1 1-4Z"/>',
        'bell' => '<path d="M18 8a6 6 0 0 0-12 0c0 7-3 9-3 9h18s-3-2-3-9"/><path d="M13.7 21a2 2 0 0 1-3.4 0"/>',
        'logout' => '<path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"/><path d="m16 17 5-5-5-5"/><path d="M21 12H9"/>',
        'plus' => '<path d="M12 5v14M5 12h14"/>',
        'trash' => '<path d="M4 7h16M10 7V4h4v3M6 7l1 13h10l1-13"/>',
        'upload' => '<path d="M12 16V4m0 0 4 4m-4-4L8 8"/><path d="M4 16v2a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2v-2"/>',
        'download' => '<path d="M12 4v12m0 0 4-4m-4 4-4-4"/><path d="M4 20h16"/>',
        'eye' => '<path d="M2 12s3.5-7 10-7 10 7 10 7-3.5 7-10 7S2 12 2 12Z"/><circle cx="12" cy="12" r="3"/>',
        'x' => '<path d="M6 6l12 12M18 6 6 18"/>',
        'chevron-down' => '<path d="m6 9 6 6 6-6"/>',
        'clock' => '<circle cx="12" cy="12" r="9"/><path d="M12 7v5l3 2"/>',
        'send' => '<path d="m22 2-7 20-4-9-9-4Z"/><path d="M22 2 11 13"/>',
        'file' => '<path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8Z"/><path d="M14 2v6h6"/>',
    ];
    $p = $paths[$name ?? 'doc'] ?? $paths['doc'];
    $cls = $class ?? 'w-5 h-5';
@endphp
<svg xmlns="http://www.w3.org/2000/svg" class="{{ $cls }}" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true" focusable="false">{!! $p !!}</svg>
