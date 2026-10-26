@php
    $title = $title ?? 'Berkas terunggah';
    $evidenceTitleId = 'evidence-title-'.substr(md5($title.json_encode($files)), 0, 8);
@endphp
<section aria-labelledby="{{ $evidenceTitleId }}">
    <div class="mb-2 flex flex-wrap items-center gap-2">
        <h3 id="{{ $evidenceTitleId }}" class="text-sm font-semibold text-slate-800">{{ $title }}</h3>
        <span class="text-xs text-slate-600">{{ count($files) }} berkas</span>
    </div>
    <div class="divide-y divide-slate-100 overflow-hidden rounded-lg border border-slate-200">
        @forelse($files as $file)
            @php $parts = $file['bagian'] ?? []; @endphp
            <article class="flex flex-col gap-3 px-4 py-3 hover:bg-slate-50 sm:flex-row sm:items-center">
                <div class="flex min-w-0 flex-1 items-center gap-3">
                    <span class="grid h-11 w-11 shrink-0 place-items-center rounded-md bg-rose-50 text-rose-700" aria-hidden="true">
                        @include('partials.icon', ['name' => 'file', 'class' => 'w-5 h-5'])
                    </span>
                    <div class="min-w-0 flex-1">
                        <p class="break-words text-sm font-semibold text-slate-800">{{ $file['nama'] }}</p>
                        <p class="mt-0.5 text-xs text-slate-600">{{ $file['ukuran'] }} · Diunggah {{ $file['tanggal'] }} oleh {{ $file['oleh'] }}</p>
                    </div>
                </div>
                <div class="grid grid-cols-2 gap-2 sm:flex sm:shrink-0">
                    <button type="button"
                            @click="sigapPreview(@js($file['nama']), @js($file['ukuran'].' · '.$file['oleh']), @js($parts))"
                            class="inline-flex min-h-11 items-center justify-center gap-2 rounded-md border border-slate-300 px-3 py-2 text-sm font-semibold text-slate-700 transition hover:border-teal-500 hover:bg-teal-50 hover:text-teal-700">
                        @include('partials.icon', ['name' => 'eye', 'class' => 'w-4 h-4']) Pratinjau
                    </button>
                    <button type="button"
                            @click="sigapToast(@js('Simulasi unduh: '.$file['nama']), 'teal')"
                            class="inline-flex min-h-11 items-center justify-center gap-2 rounded-md border border-slate-300 px-3 py-2 text-sm font-semibold text-slate-700 transition hover:border-teal-500 hover:bg-teal-50 hover:text-teal-700">
                        @include('partials.icon', ['name' => 'download', 'class' => 'w-4 h-4']) Unduh
                    </button>
                </div>
            </article>
        @empty
            <div class="px-4 py-8 text-center">
                <div class="mx-auto grid h-11 w-11 place-items-center rounded-md bg-slate-100 text-slate-600" aria-hidden="true">
                    @include('partials.icon', ['name' => 'file', 'class' => 'w-5 h-5'])
                </div>
                <p class="mt-3 text-sm font-semibold text-slate-700">Belum ada berkas</p>
                <p class="mt-1 text-xs text-slate-600">Berkas yang diunggah pada tahap sebelumnya akan tampil di sini.</p>
            </div>
        @endforelse
    </div>
</section>
