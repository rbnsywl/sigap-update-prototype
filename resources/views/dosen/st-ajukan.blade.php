@extends('layouts.app')
@section('title', 'Pengajuan Surat Tugas')
@section('breadcrumb', 'Surat Tugas / Pengajuan ST')

@section('content')
<div x-data="{
        tipe:'Individu',
        anggota:[{nama:'',peran:'Ketua',prodi:''},{nama:'',peran:'Anggota',prodi:''}],
        lokasi:'Luring',
        addAnggota(){ this.anggota.push({nama:'',peran:'Anggota',prodi:''}) },
        removeAnggota(i){ if(this.anggota.length>2) this.anggota.splice(i,1) }
    }">

    <div role="note" class="mb-6 flex items-start gap-3 rounded-lg border border-teal-200 bg-teal-50 px-4 py-3 text-sm text-teal-800">
        @include('partials.icon', ['name' => 'help', 'class' => 'w-5 h-5 shrink-0 mt-0.5'])
        <span>Lengkapi data kegiatan dan unggah surat undangan serta TOR dalam format PDF, maksimum 10 MB per berkas.</span>
    </div>

    <form method="GET" action="/surat-tugas/riwayat" class="space-y-6">

        {{-- Section A --}}
        <div class="bg-white rounded-lg border border-slate-200">
            <div class="px-6 py-4 border-b border-slate-100"><h3 class="font-semibold text-slate-800">A · Informasi Pemohon & Tipe Pengajuan</h3></div>
            <div class="p-6 space-y-5">
                <fieldset>
                    <legend class="mb-2 block text-sm font-semibold text-slate-800">Tipe penugasan</legend>
                    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
                        <label class="cursor-pointer">
                            <input type="radio" name="tipe" value="Individu" x-model="tipe" class="peer sr-only">
                            <span class="flex min-h-11 items-center rounded-lg border-2 border-slate-200 px-4 py-3 text-sm font-semibold text-slate-700 transition peer-checked:border-teal-500 peer-checked:bg-teal-50 peer-checked:text-teal-700 peer-focus-visible:outline peer-focus-visible:outline-2 peer-focus-visible:outline-offset-2 peer-focus-visible:outline-cyan-700">Individu</span>
                        </label>
                        <label class="cursor-pointer">
                            <input type="radio" name="tipe" value="Kelompok" x-model="tipe" class="peer sr-only">
                            <span class="flex min-h-11 items-center rounded-lg border-2 border-slate-200 px-4 py-3 text-sm font-semibold text-slate-700 transition peer-checked:border-teal-500 peer-checked:bg-teal-50 peer-checked:text-teal-700 peer-focus-visible:outline peer-focus-visible:outline-2 peer-focus-visible:outline-offset-2 peer-focus-visible:outline-cyan-700">Kelompok</span>
                        </label>
                    </div>
                </fieldset>

                {{-- Dynamic members --}}
                <div x-show="tipe==='Kelompok'" x-cloak x-transition>
                    <div class="mb-3 flex flex-col gap-2 sm:flex-row sm:items-center sm:justify-between">
                        <div>
                            <h4 class="text-sm font-semibold text-slate-800">Daftar anggota kelompok</h4>
                            <p class="text-xs text-slate-600">Minimal satu ketua dan satu anggota.</p>
                        </div>
                        <button type="button" @click="addAnggota()" class="inline-flex min-h-11 items-center justify-center gap-2 rounded-md border border-teal-500 px-3 py-2 text-sm font-semibold text-teal-700 hover:bg-teal-50">
                            @include('partials.icon', ['name' => 'plus', 'class' => 'w-4 h-4'])
                            Tambah anggota
                        </button>
                    </div>
                    <div class="space-y-3">
                        <template x-for="(member, index) in anggota" :key="index">
                            <div class="grid grid-cols-1 gap-3 rounded-lg border border-slate-200 bg-slate-50 p-3 sm:grid-cols-[minmax(0,2fr)_minmax(120px,1fr)_minmax(0,1.2fr)_44px] sm:items-end">
                                <label class="text-xs font-semibold text-slate-700">Nama dosen atau NIP
                                    <input x-model="member.nama" :name="`anggota[${index}][nama]`" placeholder="Ketik nama atau NIP" class="mt-1 w-full rounded border border-slate-300 bg-white px-3 py-2 text-sm focus:border-teal-500 outline-none">
                                </label>
                                <label class="text-xs font-semibold text-slate-700">Peran
                                    <select x-model="member.peran" :name="`anggota[${index}][peran]`" class="mt-1 w-full rounded border border-slate-300 bg-white px-3 py-2 text-sm focus:border-teal-500 outline-none">
                                        <option>Ketua</option><option>Anggota</option>
                                    </select>
                                </label>
                                <label class="text-xs font-semibold text-slate-700">Program studi
                                    <input x-model="member.prodi" :name="`anggota[${index}][prodi]`" placeholder="Program studi" class="mt-1 w-full rounded border border-slate-300 bg-white px-3 py-2 text-sm focus:border-teal-500 outline-none">
                                </label>
                                <button type="button" @click="removeAnggota(index)" :disabled="anggota.length<=2"
                                        class="grid h-11 w-11 place-items-center rounded-md text-slate-600 hover:bg-rose-50 hover:text-rose-700 disabled:opacity-40" :aria-label="`Hapus anggota ${index + 1}`">
                                    @include('partials.icon', ['name' => 'trash', 'class' => 'w-4 h-4'])
                                </button>
                            </div>
                        </template>
                    </div>
                </div>
            </div>
        </div>

        {{-- Section B --}}
        <div class="bg-white rounded-lg border border-slate-200">
            <div class="px-6 py-4 border-b border-slate-100"><h3 class="font-semibold text-slate-800">B · Rincian Kegiatan Tridharma</h3></div>
            <div class="p-6 grid grid-cols-1 md:grid-cols-2 gap-5">
                <div class="md:col-span-2">
                    <label class="block text-sm font-medium text-slate-700 mb-1.5">Nama / Judul Kegiatan <span class="text-rose-500">*</span></label>
                    <input placeholder="cth: Narasumber Seminar Nasional Transformasi Digital FEB" class="w-full rounded border border-slate-300 px-3 py-2 text-sm focus:border-teal-500 focus:ring-2 focus:ring-teal-500/10 outline-none">
                </div>
                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-1.5">Kategori Tridharma <span class="text-rose-500">*</span></label>
                    <select class="w-full rounded border border-slate-300 px-3 py-2 text-sm focus:border-teal-500 outline-none">
                        <option>Pendidikan & Pengajaran</option><option>Penelitian</option><option>Pengabdian Masyarakat</option><option>Penunjang</option>
                    </select>
                </div>
                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-1.5">Penyelenggara / Institusi Mitra <span class="text-rose-500">*</span></label>
                    <input placeholder="cth: Universitas Brawijaya" class="w-full rounded border border-slate-300 px-3 py-2 text-sm focus:border-teal-500 outline-none">
                </div>
                <fieldset>
                    <legend class="mb-2 block text-sm font-semibold text-slate-800">Lokasi pelaksanaan</legend>
                    <div class="grid grid-cols-3 gap-2">
                        @foreach(['Daring','Luring','Hybrid'] as $location)
                            <label class="cursor-pointer">
                                <input type="radio" name="lokasi" value="{{ $location }}" x-model="lokasi" class="peer sr-only">
                                <span class="flex min-h-11 items-center justify-center rounded-md border border-slate-300 px-2 py-2 text-sm font-semibold text-slate-700 transition peer-checked:border-teal-500 peer-checked:bg-teal-50 peer-checked:text-teal-700 peer-focus-visible:outline peer-focus-visible:outline-2 peer-focus-visible:outline-offset-2 peer-focus-visible:outline-cyan-700">{{ $location }}</span>
                            </label>
                        @endforeach
                    </div>
                </fieldset>
                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-1.5">Alamat / Tautan Kegiatan</label>
                    <input placeholder="Alamat luring atau link daring" class="w-full rounded border border-slate-300 px-3 py-2 text-sm focus:border-teal-500 outline-none">
                </div>
                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-1.5">Tanggal Mulai</label>
                    <input type="date" class="w-full rounded border border-slate-300 px-3 py-2 text-sm focus:border-teal-500 outline-none">
                </div>
                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-1.5">Tanggal Selesai</label>
                    <input type="date" class="w-full rounded border border-slate-300 px-3 py-2 text-sm focus:border-teal-500 outline-none">
                </div>
            </div>
        </div>

        {{-- Section C --}}
        <div class="bg-white rounded-lg border border-slate-200">
            <div class="px-6 py-4 border-b border-slate-100"><h3 class="font-semibold text-slate-800">C · Berkas persyaratan dan eviden</h3></div>
            <div class="p-6 grid grid-cols-1 md:grid-cols-2 gap-5">
                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-2">Surat Undangan Resmi</label>
                    @include('partials.dropzone', ['label' => 'Unggah Surat Undangan / Call for Papers'])
                </div>
                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-2">Term of Reference (TOR)</label>
                    @include('partials.dropzone', ['label' => 'Unggah TOR / Kerangka Acuan Kerja'])
                </div>
            </div>
        </div>

        {{-- Actions --}}
        <div class="flex items-center justify-end gap-3">
            <button type="button" class="px-5 py-2.5 rounded border border-slate-300 text-sm font-medium text-slate-600 hover:bg-slate-50">Simpan sebagai Draf</button>
            <button type="submit" class="px-5 py-2.5 rounded bg-teal-500 hover:bg-teal-600 text-white text-sm font-semibold inline-flex items-center gap-2 transition active:scale-[0.98]">
                @include('partials.icon', ['name' => 'send', 'class' => 'w-4 h-4'])
                Kirim Permohonan
            </button>
        </div>
    </form>
</div>
@endsection
