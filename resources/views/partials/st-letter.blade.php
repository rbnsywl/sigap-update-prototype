{{-- Surat Tugas dalam format kertas A4 penuh, mengikuti kop & layout resmi
     FEB Telkom University. Props: $row (data ST), $nomor (opsional override). --}}
@php
    $nomor = $nomor ?? ($row['nomor_surat'] ?? '......./SDM01/EB-WD2/2026');
    $anggota = count($row['anggota'] ?? []) ? $row['anggota'] : [
        ['nama' => $row['dosen'], 'nip' => '26820002', 'peran' => 'Dosen', 'prodi' => $row['prodi'] ?? ''],
    ];
@endphp
<div class="st-a4 bg-white mx-auto shadow-sm border border-slate-200" style="width:794px; min-height:1123px; padding:64px 72px; position:relative;">

    {{-- Kop surat: logo Telkom (merah + abu) --}}
    <div class="flex justify-end items-center gap-2 mb-10">
        <svg width="34" height="34" viewBox="0 0 48 48" fill="none" xmlns="http://www.w3.org/2000/svg">
            <path d="M24 4 L40 12 V24 C40 36 33 43 24 46 C15 43 8 36 8 24 V12 Z" fill="#ED1C24"/>
            <path d="M24 10 L34 15 V24 C34 32 30 37 24 39 V10 Z" fill="#6D6E71"/>
            <rect x="21" y="16" width="6" height="18" rx="1" fill="#ffffff"/>
            <rect x="16" y="16" width="16" height="5" rx="1" fill="#ffffff"/>
        </svg>
        <div class="leading-none">
            <div style="font-size:22px; font-weight:800; color:#1a1a1a; letter-spacing:-0.5px;">Telkom</div>
            <div style="font-size:13px; font-weight:600; color:#6D6E71; letter-spacing:0.5px;">University</div>
        </div>
    </div>

    {{-- Judul --}}
    <div class="text-center mb-1">
        <div style="font-size:24px; font-weight:800; letter-spacing:1px; text-decoration:underline; text-underline-offset:4px;">SURAT TUGAS</div>
    </div>
    <div class="text-center mb-8">
        <div style="font-size:13px; font-weight:700;" class="tnum">Nomor : {{ $nomor }}</div>
    </div>

    {{-- Pembuka --}}
    <p style="font-size:13px; line-height:1.7; text-align:justify;" class="mb-4">
        Pada hari ini <b>Jumat</b> tanggal <b>Enam Belas</b> bulan <b>Oktober</b> tahun <b>Dua Ribu Dua Puluh Enam</b>
        bertempat di Fakultas Ekonomi dan Bisnis Universitas Telkom, saya yang bertandatangan dibawah ini :
    </p>

    {{-- Penandatangan --}}
    <table style="font-size:13px; line-height:1.9;" class="mb-3">
        <tr><td style="width:90px; vertical-align:top;">Nama</td><td style="vertical-align:top;">: Deannes Isynuwardhana, S.E., M.M., Ph.D.</td></tr>
        <tr><td style="vertical-align:top;">NIP</td><td style="vertical-align:top;">: 08790035</td></tr>
        <tr><td style="vertical-align:top;">Jabatan</td><td style="vertical-align:top;">: Wakil Dekan II Fakultas Ekonomi dan Bisnis</td></tr>
    </table>

    <p style="font-size:13px;" class="mb-3">Menugaskan kepada :</p>

    {{-- Tabel dosen yang ditugaskan --}}
    <table class="w-full mb-5" style="font-size:13px; border-collapse:collapse;">
        <thead>
            <tr style="background:#f1f5f9;">
                <th style="border:1px solid #334155; padding:6px 10px; text-align:center;">Nama</th>
                <th style="border:1px solid #334155; padding:6px 10px; text-align:center; width:110px;">NIP</th>
                <th style="border:1px solid #334155; padding:6px 10px; text-align:center; width:120px;">Jabatan</th>
            </tr>
        </thead>
        <tbody>
            @foreach($anggota as $a)
                <tr>
                    <td style="border:1px solid #334155; padding:6px 10px;">{{ $a['nama'] }}</td>
                    <td style="border:1px solid #334155; padding:6px 10px; text-align:center;" class="tnum">{{ $a['nip'] ?? '—' }}</td>
                    <td style="border:1px solid #334155; padding:6px 10px; text-align:center;">{{ $a['peran'] ?? 'Dosen' }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <p style="font-size:13px;" class="mb-3">Untuk melaksanakan tugas :</p>

    {{-- Detail kegiatan --}}
    <table style="font-size:13px; line-height:1.9;" class="mb-5">
        <tr><td style="width:110px; vertical-align:top;">Kegiatan</td><td style="vertical-align:top;">: {{ $row['judul'] }}</td></tr>
        <tr><td style="vertical-align:top;">Tanggal</td><td style="vertical-align:top;">: {{ $row['mulai'] }}{{ $row['selesai'] !== $row['mulai'] ? ' s/d '.$row['selesai'] : '' }}</td></tr>
        <tr><td style="vertical-align:top;">Tempat</td><td style="vertical-align:top;">: {{ $row['lokasi'] }}</td></tr>
        <tr><td style="vertical-align:top;">Penyelenggara</td><td style="vertical-align:top;">: {{ $row['mitra'] }}</td></tr>
    </table>

    <p style="font-size:13px;" class="mb-8">Demikian surat tugas ini dibuat untuk dipergunakan dengan sebaik-baiknya.</p>

    {{-- Tanda tangan --}}
    <div style="font-size:13px; line-height:1.8;">
        <div class="mb-1">Bandung, 16 Oktober 2026</div>
        @if($row['tanggal_terbit'] ?? false)
            <div style="height:56px;" class="flex items-center">
                <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded bg-teal-50 text-teal-700" style="font-size:11px; font-weight:600;">
                    @include('partials.icon', ['name' => 'check', 'class' => 'w-3.5 h-3.5']) Ditandatangani digital (BSrE)
                </span>
            </div>
        @else
            <div style="height:56px;"></div>
        @endif
        <div style="font-weight:700;">Deannes Isynuwardhana, S.E., M.M., Ph.D.</div>
        <div style="font-weight:700; text-decoration:underline;">Wakil Dekan II Fakultas Ekonomi dan Bisnis</div>
        <div style="font-weight:700;">Universitas Telkom</div>
    </div>

    {{-- Footer alamat kampus --}}
    <div style="position:absolute; left:72px; right:72px; bottom:40px;">
        <div style="border-top:3px solid #ED1C24; padding-top:8px; font-size:7.5px; line-height:1.5; color:#555; text-align:center;">
            <div><b>Main Campus</b> Bangkit Building Telkom University, Jl. Telekomunikasi, Terusan Buah Batu, Bandung 40257, West Java, Indonesia | t: (022) 7566456 | e: info@telkomuniversity.ac.id</div>
            <div><b>Jakarta Campus</b> Jl. Daan Mogot KM. 11, Kedaung Kali Angke, Cengkareng, West Jakarta 11710, Indonesia | t: +62 81197800200 / (021) 545 1597 / 545 1697</div>
            <div><b>Surabaya Campus</b> Jl. Ketintang No.156, Gayungan, Surabaya, East Java 60231, Indonesia | t: +62 81139808009 / (031) 8280800</div>
            <div><b>Purwokerto Campus</b> Jl. DI Panjaitan No.128, Karangreja, Purwokerto Kidul, Kabupaten Banyumas, Center Java 53147, Indonesia | t: (0281) 641629</div>
            <div style="margin-top:4px; font-weight:700; font-size:9px; color:#333;">www.telkomuniversity.ac.id</div>
        </div>
    </div>
</div>
