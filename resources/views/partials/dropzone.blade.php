@php
    $hint = $hint ?? 'PDF saja, maksimum 10 MB';
    $label = $label ?? 'Pilih atau letakkan berkas PDF';
    $name = $name ?? null;
    preg_match('/(\d+)\s*MB/i', $hint, $sizeMatch);
    $maxMb = $maxMb ?? (isset($sizeMatch[1]) ? (int) $sizeMatch[1] : 10);
    $inputId = $id ?? 'upload-'.substr(md5($label.uniqid('', true)), 0, 10);
@endphp
<div x-data="{
        fileName: '',
        fileSize: '',
        isOver: false,
        isFocused: false,
        error: '',
        maxMb: {{ $maxMb }},
        formatSize(bytes) {
            return bytes >= 1048576 ? (bytes / 1048576).toFixed(1) + ' MB' : Math.max(1, Math.round(bytes / 1024)) + ' KB';
        },
        validate(file) {
            this.error = '';
            if (!file) return false;
            const isPdf = file.type === 'application/pdf' || file.name.toLowerCase().endsWith('.pdf');
            if (!isPdf) { this.error = 'Format berkas harus PDF.'; return false; }
            if (file.size > this.maxMb * 1048576) { this.error = `Ukuran berkas melebihi ${this.maxMb} MB.`; return false; }
            return true;
        },
        choose(file) {
            if (!this.validate(file)) { this.fileName = ''; this.fileSize = ''; this.$refs.input.value = ''; return; }
            this.fileName = file.name;
            this.fileSize = this.formatSize(file.size);
        },
        drop(event) {
            this.isOver = false;
            const file = event.dataTransfer.files[0];
            if (!this.validate(file)) return;
            const transfer = new DataTransfer();
            transfer.items.add(file);
            this.$refs.input.files = transfer.files;
            this.choose(file);
        },
        clear() {
            this.fileName = '';
            this.fileSize = '';
            this.error = '';
            this.$refs.input.value = '';
            this.$nextTick(() => this.$refs.input.focus());
        }
     }"
     @dragenter.prevent="isOver = true" @dragover.prevent="isOver = true" @dragleave.prevent="isOver = false" @drop.prevent="drop($event)"
     class="relative rounded-lg border-2 border-dashed bg-slate-50 p-4 text-center transition sm:p-5"
     :class="{
        'border-teal-500 bg-teal-50': isOver || isFocused,
        'border-rose-500 bg-rose-50': error,
        'border-slate-300 hover:border-teal-500': !isOver && !isFocused && !error
     }">
    <template x-if="!fileName">
        <div class="relative">
            <input id="{{ $inputId }}" x-ref="input" type="file" @change="choose($event.target.files[0])"
                   @focus="isFocused = true" @blur="isFocused = false"
                   @if($name) name="{{ $name }}" @endif
                   accept="application/pdf,.pdf" class="absolute inset-0 h-full w-full cursor-pointer opacity-0"
                   aria-describedby="{{ $inputId }}-hint {{ $inputId }}-error">
            <div class="pointer-events-none">
                <div class="mx-auto mb-3 grid h-11 w-11 place-items-center rounded-md bg-teal-100 text-teal-700" aria-hidden="true">
                    @include('partials.icon', ['name' => 'upload', 'class' => 'w-5 h-5'])
                </div>
                <label for="{{ $inputId }}" class="block text-sm font-semibold text-slate-800">{{ $label }}</label>
                <p id="{{ $inputId }}-hint" class="mt-1 text-xs text-slate-600">{{ $hint }}</p>
                <span class="mt-3 inline-flex min-h-11 items-center rounded-md border border-slate-300 bg-white px-4 py-2 text-sm font-semibold text-slate-700">Pilih berkas</span>
            </div>
        </div>
    </template>

    <template x-if="fileName">
        <div class="flex flex-col items-center gap-3 sm:flex-row sm:text-left">
            <span class="grid h-11 w-11 shrink-0 place-items-center rounded-md bg-teal-100 text-teal-700" aria-hidden="true">
                @include('partials.icon', ['name' => 'file', 'class' => 'w-5 h-5'])
            </span>
            <div class="min-w-0 flex-1">
                <p class="break-all text-sm font-semibold text-slate-800" x-text="fileName"></p>
                <p class="text-xs text-slate-600" x-text="fileSize + ' · Siap digunakan dalam simulasi'"></p>
            </div>
            <button type="button" @click="clear()" class="inline-flex min-h-11 items-center gap-2 rounded-md border border-slate-300 px-3 py-2 text-sm font-semibold text-slate-700 hover:bg-white" aria-label="Hapus berkas terpilih">
                @include('partials.icon', ['name' => 'trash', 'class' => 'w-4 h-4']) Hapus
            </button>
        </div>
    </template>

    <p id="{{ $inputId }}-error" x-show="error" x-cloak class="mt-3 text-sm font-semibold text-rose-700" role="alert" x-text="error"></p>
</div>
