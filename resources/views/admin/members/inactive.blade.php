@extends('layouts.admin')

@section('title', 'Data Wartawan Belum / Tidak Aktif')
@section('page_title', 'Data Wartawan')

@section('content')
<div class="space-y-6">
    
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
        <div>
            <h2 class="text-xl font-extrabold text-white">Data Wartawan Belum / Tidak Aktif</h2>
            <p class="text-xs text-slate-400 mt-1">Daftar jurnalis dengan status non-aktif atau dalam proses perpanjangan berkas keanggotaan</p>
        </div>
        <a href="{{ route('admin.members.index') }}" class="px-4 py-2.5 rounded-xl text-xs font-bold text-slate-300 bg-slate-900 border border-slate-800 hover:text-white">
            <i class="fa-solid fa-arrow-left me-1"></i> Kembali ke Wartawan Aktif
        </a>
    </div>

    <!-- Table Container -->
    <div class="bg-slate-900 border border-slate-800 rounded-3xl shadow-xl overflow-hidden">
        
        <div class="p-6 border-b border-slate-800 flex flex-col sm:flex-row sm:items-center justify-between gap-4">
            <div class="text-xs text-slate-400">
                Total Wartawan Non-Aktif: <span class="font-bold text-rose-400">{{ $members->total() }} Orang</span>
            </div>

            <form action="{{ route('admin.members.inactive') }}" method="GET" class="w-full sm:w-72">
                <div class="relative">
                    <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari nama / nomor kartu..." class="w-full pl-9 pr-4 py-2 rounded-xl bg-slate-950 border border-slate-800 text-xs text-slate-200 focus:ring-2 focus:ring-amber-500 focus:border-amber-500 outline-none">
                    <i class="fa-solid fa-magnifying-glass absolute left-3 top-3 text-slate-500 text-xs"></i>
                </div>
            </form>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-left text-xs text-slate-300">
                <thead class="bg-slate-950/70 text-slate-400 uppercase tracking-wider text-[11px] border-b border-slate-800">
                    <tr>
                        <th class="py-3.5 px-6 text-center w-16">NO</th>
                        <th class="py-3.5 px-6">NAMA</th>
                        <th class="py-3.5 px-6">NOMOR KARTU</th>
                        <th class="py-3.5 px-6">TINGKAT</th>
                        <th class="py-3.5 px-6">MASA BERLAKU</th>
                        <th class="py-3.5 px-6">JABATAN</th>
                        <th class="py-3.5 px-6 text-center w-36">AKSI</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-800/60">
                    @forelse($members as $index => $m)
                        <tr class="hover:bg-white/[0.02] transition-colors">
                            <td class="py-3.5 px-6 text-center font-bold text-slate-500">{{ $members->firstItem() + $index }}</td>
                            <td class="py-3.5 px-6 font-bold text-white">
                                {{ $m->nama }}
                                <span class="block text-[11px] font-normal text-slate-400">{{ $m->nama_media }}</span>
                            </td>
                            <td class="py-3.5 px-6 font-mono text-slate-300">{{ $m->nomor_kartu ?? '-' }}</td>
                            <td class="py-3.5 px-6">
                                <span class="inline-block px-2.5 py-1 rounded-lg text-[11px] font-bold bg-slate-800 text-slate-400">
                                    {{ $m->tingkat_ukw }}
                                </span>
                            </td>
                            <td class="py-3.5 px-6 text-slate-400">{{ $m->masa_berlaku ? $m->masa_berlaku->format('d-m-Y') : '-' }}</td>
                            <td class="py-3.5 px-6 text-slate-400">{{ $m->jabatan }}</td>
                            <td class="py-3.5 px-6 text-center">
                                <form action="{{ route('admin.members.toggle', $m->id) }}" method="POST" class="inline">
                                    @csrf
                                    <button type="submit" class="px-3 py-1.5 rounded-lg bg-emerald-500/10 hover:bg-emerald-500 text-emerald-400 hover:text-slate-950 border border-emerald-500/20 text-xs font-bold transition-all" title="Aktifkan Kembali">
                                        <i class="fa-solid fa-rotate-left me-1"></i> Aktifkan
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="py-12 text-center text-slate-500">
                                Tidak ada data wartawan tidak aktif.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="p-6 border-t border-slate-800 flex justify-end">
            {{ $members->links() }}
        </div>

    </div>

</div>
@endsection
