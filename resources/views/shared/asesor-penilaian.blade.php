{{-- Reusable assessor assessment screen for Penyetaraan S3 (Kaprodi, Dekan, Ketua KK).
     Expects: $rows, $statuses, $roleLabel --}}
<div x-data="{ tab:'menunggu', sel:0 }">
    @include('partials.page-head', ['heading' => 'Penilaian Penyetaraan S3', 'sub' => 'Evaluasi linearitas keilmuan dan integritas akademik sebagai '.$roleLabel.'.'])

    {{-- Tabs --}}
    <div role="tablist" aria-label="Status penilaian" class="mb-6 flex w-full gap-1 overflow-x-auto rounded-lg bg-slate-100 p-1 sm:w-fit">
        <button id="tab-menunggu" role="tab" type="button" @click="tab='menunggu'" :aria-selected="(tab==='menunggu').toString()" aria-controls="panel-menunggu" class="whitespace-nowrap rounded-md px-4 py-2 text-sm font-semibold transition" :class="tab==='menunggu'?'bg-white text-teal-700 shadow-sm':'text-slate-600'">Menunggu penilaian</button>
        <button id="tab-riwayat" role="tab" type="button" @click="tab='riwayat'" :aria-selected="(tab==='riwayat').toString()" aria-controls="panel-riwayat" class="whitespace-nowrap rounded-md px-4 py-2 text-sm font-semibold transition" :class="tab==='riwayat'?'bg-white text-teal-700 shadow-sm':'text-slate-600'">Riwayat penilaian</button>
    </div>

    @php
        $menunggu = collect($rows)->whereIn('status',['Penilaian Internal Asesor'])->values();
        $riwayat = collect($rows)->where('status','Selesai')->values();
    @endphp

    <div id="panel-menunggu" role="tabpanel" aria-labelledby="tab-menunggu" x-show="tab==='menunggu'">
        @if($menunggu->isEmpty())
            <div class="rounded-lg border border-slate-200 bg-white p-8 text-center">
                <div class="mx-auto grid h-11 w-11 place-items-center rounded-md bg-slate-100 text-slate-600" aria-hidden="true">@include('partials.icon', ['name' => 'clipboard', 'class' => 'w-5 h-5'])</div>
                <p class="mt-3 text-sm font-semibold text-slate-800">Tidak ada berkas menunggu penilaian</p>
                <p class="mt-1 text-xs text-slate-600">Berkas baru akan tampil setelah Admin SDM menyelesaikan distribusi asesor.</p>
            </div>
        @else
            @foreach($menunggu as $r)
                <div class="bg-white rounded-lg border border-slate-200 mb-6">
                    {{-- Header --}}
                    <div class="px-6 py-5 border-b border-slate-100 flex flex-wrap items-start justify-between gap-4">
                        <div class="flex items-center gap-4">
                            <div class="w-12 h-12 rounded-full bg-teal-600 text-white grid place-items-center font-semibold">{{ $r['avatar'] }}</div>
                            <div>
                                <div class="font-semibold text-slate-900">{{ $r['dosen'] }}</div>
                                <div class="text-xs text-slate-400 mt-0.5">{{ $r['nip'] }} · {{ $r['prodi'] }} · KK {{ $r['kk'] }}</div>
                                <div class="text-sm text-slate-600 mt-1.5 max-w-xl"><span class="text-slate-600">Disertasi:</span> {{ $r['judul_disertasi'] }} <span class="text-slate-600">, {{ $r['pt'] }}</span></div>
                            </div>
                        </div>
                        <div class="flex gap-2">
                            @php $pf = \App\Support\MockData::evidencePenyetaraan()[0]; @endphp
                            <button @click="sigapPreview(@js($pf['nama']), @js($pf['ukuran'].' · '.$pf['oleh']), @js($pf['bagian']))"
                                    class="inline-flex items-center gap-2 px-3 py-1.5 rounded border border-slate-300 text-slate-600 text-sm font-medium hover:border-teal-400 hover:text-teal-600">
                                @include('partials.icon', ['name' => 'eye', 'class' => 'w-4 h-4']) Lihat Dokumen
                            </button>
                            <button type="button" @click="sigapToast('Simulasi unduh paket berkas ZIP', 'teal')"
                                    class="inline-flex items-center gap-2 px-3 py-1.5 rounded border border-slate-300 text-slate-600 text-sm font-medium hover:border-teal-400 hover:text-teal-600">
                                @include('partials.icon', ['name' => 'download', 'class' => 'w-4 h-4']) Unduh (.ZIP)
                            </button>
                        </div>
                    </div>

                    {{-- Assessment form --}}
                    <div class="p-6 grid grid-cols-1 lg:grid-cols-2 gap-6">
                        <div class="space-y-4">
                            {{-- Evidence gabungan dari dosen pengusul --}}
                            @include('partials.evidence', ['title' => 'Berkas Gabungan dari Dosen Pengusul', 'files' => \App\Support\MockData::evidencePenyetaraan()])
                            <button @click="sigapToast('Template lembar nilai asesor diunduh', 'teal')" class="inline-flex items-center gap-2 px-3 py-1.5 rounded border border-teal-500 text-teal-600 text-sm font-semibold hover:bg-teal-50">
                                @include('partials.icon', ['name' => 'download', 'class' => 'w-4 h-4']) Unduh Template Lembar Nilai Asesor FEB
                            </button>
                            <div class="space-y-2">
                                @foreach(['Kesesuaian tema disertasi dengan roadmap KK','Relevansi publikasi doktoral dengan kurikulum prodi','Pernyataan bebas plagiarisme'] as $c)
                                    <label class="flex items-center gap-3 p-3 rounded-lg border border-slate-200 cursor-pointer hover:bg-slate-50">
                                        <input type="checkbox" class="w-4 h-4 rounded text-teal-500 focus:ring-teal-500">
                                        <span class="text-sm text-slate-700">{{ $c }}</span>
                                    </label>
                                @endforeach
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-slate-700 mb-1.5">Catatan / Pertimbangan Asesor</label>
                                <textarea rows="3" class="w-full rounded border border-slate-300 px-3 py-2 text-sm focus:border-teal-500 outline-none"></textarea>
                            </div>
                        </div>
                        <div class="space-y-4">
                            <div>
                                <label class="block text-sm font-medium text-slate-700 mb-2">Unggah Lembar Nilai Bertandatangan (PDF)</label>
                                @include('partials.dropzone', ['label' => 'Unggah lembar nilai asesor'])
                            </div>
                            <div class="flex items-center justify-end gap-3 pt-2">
                                <button @click="sigapToast('Berkas dikembalikan untuk perbaikan', 'rose')" class="px-4 py-2 rounded border border-slate-300 text-slate-600 text-sm font-semibold hover:bg-slate-50">Kembalikan untuk Perbaikan</button>
                                <button @click="sigapToast('Rekomendasi penyetaraan S3 terkirim', 'green')" class="px-5 py-2.5 rounded bg-teal-500 hover:bg-teal-600 text-white text-sm font-semibold inline-flex items-center gap-2 transition active:scale-[0.98]">
                                    @include('partials.icon', ['name' => 'send', 'class' => 'w-4 h-4']) Kirim Rekomendasi
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        @endif
    </div>

    <div id="panel-riwayat" role="tabpanel" aria-labelledby="tab-riwayat" x-show="tab==='riwayat'" x-cloak>
        <div class="bg-white rounded-lg border border-slate-200 overflow-hidden">
            <table class="w-full text-sm">
                <thead><tr class="bg-slate-50 text-left text-[11px] uppercase tracking-wider text-slate-500">
                    <th class="px-6 py-3 font-semibold">Dosen</th><th class="px-6 py-3 font-semibold">Disertasi</th>
                    <th class="px-6 py-3 font-semibold">Tanggal</th><th class="px-6 py-3 font-semibold">Status</th>
                </tr></thead>
                <tbody class="divide-y divide-slate-50">
                    @foreach($riwayat as $r)
                        <tr class="hover:bg-slate-50/60">
                            <td class="px-6 py-3.5 font-medium text-slate-800">{{ $r['dosen'] }}</td>
                            <td class="px-6 py-3.5 text-slate-600 max-w-xs truncate">{{ $r['judul_disertasi'] }}</td>
                            <td class="px-6 py-3.5 text-slate-500">{{ $r['tanggal'] }}</td>
                            <td class="px-6 py-3.5">@include('partials.badge', ['label' => $r['status'], 'tone' => $statuses[$r['status']] ?? 'slate'])</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
