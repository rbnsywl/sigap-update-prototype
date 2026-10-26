@php $hint = $hint ?? 'PDF saja · Maks 10MB'; $label = $label ?? 'Seret & letakkan berkas di sini, atau klik untuk memilih'; @endphp
<div x-data="{ name:'', over:false }"
     @dragover.prevent="over=true" @dragleave.prevent="over=false"
     @drop.prevent="over=false; name = $event.dataTransfer.files[0]?.name || ''"
     class="relative rounded-lg border-2 border-dashed transition p-6 text-center cursor-pointer"
     :class="over ? 'border-teal-500 bg-teal-50' : 'border-slate-300 bg-slate-50/50 hover:border-teal-400'"
     @click="$refs.inp.click()">
    <input type="file" x-ref="inp" accept="application/pdf" class="hidden" @change="name = $event.target.files[0]?.name || ''">
    <div class="w-11 h-11 mx-auto rounded-full bg-teal-100 text-teal-600 grid place-items-center mb-3">
        @include('partials.icon', ['name' => 'upload', 'class' => 'w-5 h-5'])
    </div>
    <template x-if="!name">
        <div>
            <div class="text-sm font-medium text-slate-700">{{ $label }}</div>
            <div class="text-xs text-slate-400 mt-1">{{ $hint }}</div>
        </div>
    </template>
    <template x-if="name">
        <div class="flex items-center justify-center gap-2 text-sm text-slate-700">
            @include('partials.icon', ['name' => 'file', 'class' => 'w-4 h-4 text-teal-600'])
            <span x-text="name" class="font-medium"></span>
            <button type="button" @click.stop="name=''; $refs.inp.value=''" class="text-slate-400 hover:text-rose-500">
                @include('partials.icon', ['name' => 'x', 'class' => 'w-4 h-4'])
            </button>
        </div>
    </template>
</div>
