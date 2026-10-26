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

    <div class="mb-6 flex items-center gap-2 text-sm text-teal-800 bg-teal-50 border border-teal-100 rounded-lg px-4 py-3">
        @include('partials.icon', ['name' => 'help', 'class' => 'w-4 h-4 shrink-0'])
        <span>Lengkapi formulir di bawah. Pastikan berkas undangan & TOR dalam format PDF (maks 10MB) sebelum mengirim.</span>
    </div>

    <form method="GET" action="/surat-tugas/riwayat" class="space-y-6">

        {{-- Section A --}}
        <div class="bg-white rounded-lg border border-slate-200">
            <div class="px-6 py-4 border-b border-slate-100"><h3 class="font-semibold text-slate-800">A · Informasi Pemohon & Tipe Pengajuan</h3></div>
            <div class="p-6 space-y-5">
                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-2">Tipe Penugasan</label>
                    <div class="flex gap-3">
                        <label class="flex-1 cursor-pointer">
                            <input type="radio" name="tipe" value="Individu" x-model="tipe" class="peer sr-only">
                            <div class="rounded-lg border-2 px-4 py-3 text-sm font-medium transition peer-checked:border-teal-500 peer-checked:bg-teal-50 peer-checked:text-teal-700 border-slate-200 text-slate-600">Individu</div>
                        </label>
                        <label class="flex-1 cursor-pointer">
                            <input type="radio" name="tipe" value="Kelompok" x-model="tipe" class="peer sr-only">
                            <div class="rounded-lg border-2 px-4 py-3 text-sm font-medium transition peer-checked:border-teal-500 peer-checked:bg-teal-50 peer-checked:text-teal-700 border-slate-200 text-slate-600">Kelompok</div>
                        </label>
                    </div>
                </div>

                {{-- Dynamic members --}}
                <div x-show="tipe==='Kelompok'" x-cloak x-transition>
                    <div class="flex items-center justify-between mb-2">
                        <label class="block text-sm font-medium text-slate-700">Daftar Anggota Kelompok</label>
                        <button type="button" @click="addAnggota()" class="inline-flex items-center gap-1.5 text-sm font-semibold text-teal-600 hover:text-teal-700">
                            @include('partials.icon', ['name' => 'plus', 'class' => 'w-4 h-4'])
                            Add More Anggota
                        </button>
                    </div>
                    <div class="space-y-2">
                        <template x-for="(a,i) in anggota" :key="i">
                            <div class="grid grid-cols-12 gap-2 items-center">
                                <input x-model="a.nama" placeholder="Nama Dosen (NIP)" class="col-span-5 rounded border border-slate-300 px-3 py-2 text-sm focus:border-teal-500 focus:ring-2 focus:ring-teal-500/10 outline-none">
                                <select x-model="a.peran" class="col-span-3 rounded border border-slate-300 px-3 py-2 text-sm focus:border-teal-500 outline-none">
                                    <option>Ketua</option><option>Anggota</option>
                                </select>
                                <input x-model="a.prodi" placeholder="Prodi Asal" class="col-span-3 rounded border border-slate-300 px-3 py-2 text-sm focus:border-teal-500 outline-none">
                                <button type="button" @click="removeAnggota(i)" :disabled="anggota.length<=2"
                                        class="col-span-1 grid place-items-center h-9 rounded text-slate-400 hover:text-rose-500 disabled:opacity-30 disabled:cursor-not-allowed">
                                    @include('partials.icon', ['name' => 'trash', 'class' => 'w-4 h-4'])
                                </button>
                            </div>
                        </template>
                    </div>
                    <p class="text-xs text-slate-400 mt-2">Minimal 1 ketua & 1 anggota.</p>
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
                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-1.5">Lokasi Pelaksanaan</label>
                    <div class="flex gap-2">
                        @foreach(['Daring','Luring','Hybrid'] as $l)
                            <label class="flex-1 cursor-pointer">
                                <input type="radio" name="lokasi" value="{{ $l }}" x-model="lokasi" class="peer sr-only">
                                <div class="text-center rounded border px-2 py-2 text-sm transition peer-checked:border-teal-500 peer-checked:bg-teal-50 peer-checked:text-teal-700 border-slate-200 text-slate-600">{{ $l }}</div>
                            </label>
                        @endforeach
                    </div>
                </div>
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
            <div class="px-6 py-4 border-b border-slate-100"><h3 class="font-semibold text-slate-800">C · Berkas Persyaratan & Eviden</h3></div>
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
