@php $statuses = \App\Support\MockData::stStatuses(); @endphp
<table class="w-full text-sm">
    <thead><tr class="bg-slate-50 text-left text-[11px] uppercase tracking-wider text-slate-500">
        <th class="px-6 py-3 font-semibold">No. Tiket</th>
        <th class="px-6 py-3 font-semibold">Dosen / Ketua</th>
        <th class="px-6 py-3 font-semibold">Judul Agenda</th>
        <th class="px-6 py-3 font-semibold">Tipe</th>
        <th class="px-6 py-3 font-semibold">Masuk</th>
        <th class="px-6 py-3 font-semibold">Status</th>
        <th class="px-6 py-3 font-semibold text-right">Aksi</th>
    </tr></thead>
    <tbody class="divide-y divide-slate-50">
        @foreach($st as $row)
            <tr class="hover:bg-slate-50/60">
                <td class="px-6 py-3.5 font-medium text-slate-700 tnum">{{ $row['id'] }}</td>
                <td class="px-6 py-3.5 text-slate-600">{{ $row['dosen'] }}</td>
                <td class="px-6 py-3.5 text-slate-600 max-w-xs truncate">{{ $row['judul'] }}</td>
                <td class="px-6 py-3.5">@include('partials.badge', ['label' => $row['tipe'], 'tone' => $row['tipe']==='Kelompok'?'purple':'blue'])</td>
                <td class="px-6 py-3.5 text-slate-500">{{ $row['tanggal_masuk'] }}</td>
                <td class="px-6 py-3.5">@include('partials.badge', ['label' => $row['status'], 'tone' => $statuses[$row['status']] ?? 'slate'])</td>
                <td class="px-6 py-3.5 text-right">
                    <a href="/prodi/verifikasi-st" class="text-teal-600 font-semibold hover:underline text-sm">Verifikasi</a>
                </td>
            </tr>
        @endforeach
    </tbody>
</table>
