@extends('layouts.admin')

@section('title', 'Data Wartawan Belum / Tidak Aktif')
@section('page_title', 'Data Wartawan')

@section('content')
<div class="space-y-6">
    
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
        <div>
            <h2 class="text-xl font-extrabold text-[#0B132B] dark:text-white">Data Wartawan Belum / Tidak Aktif</h2>
            <p class="text-xs text-slate-600 dark:text-slate-400 mt-1 font-medium">Daftar jurnalis dengan status non-aktif atau dalam proses perpanjangan berkas keanggotaan</p>
        </div>
        <a href="{{ route('admin.members.index') }}" class="px-4 py-2.5 rounded-xl text-xs font-bold text-slate-700 dark:text-slate-200 bg-white dark:bg-slate-800 hover:bg-slate-50 dark:hover:bg-slate-700 border border-slate-300 dark:border-slate-700 shadow-sm transition-all">
            <i class="fa-solid fa-arrow-left me-1"></i> Kembali ke Wartawan Aktif
        </a>
    </div>

    <!-- Table Container (Clean White Background Card) -->
    <div class="bg-white dark:bg-slate-900 border border-slate-300 dark:border-slate-800 rounded-2xl shadow-sm overflow-hidden">
        
        <div class="p-6 border-b border-slate-200 dark:border-slate-800 flex flex-col sm:flex-row sm:items-center justify-between gap-4 bg-slate-50/50 dark:bg-slate-900/50">
            <div class="text-xs font-semibold text-slate-700 dark:text-slate-300">
                Total Wartawan Non-Aktif: <span class="font-bold text-rose-600 dark:text-rose-400">{{ $members->total() }} Orang</span>
            </div>

            <form action="{{ route('admin.members.inactive') }}" method="GET" class="w-full sm:w-72">
                <div class="relative">
                    <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari nama / nomor kartu..." class="w-full pl-9 pr-4 py-2 rounded-xl bg-white dark:bg-slate-950 border border-slate-300 dark:border-slate-700 text-xs font-medium text-slate-900 dark:text-slate-200 focus:ring-2 focus:ring-blue-600 outline-none shadow-sm">
                    <i class="fa-solid fa-magnifying-glass absolute left-3 top-3 text-slate-400 text-xs"></i>
                </div>
            </form>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-left text-xs text-slate-800 dark:text-slate-200">
                <thead class="bg-[#0B132B] dark:bg-[#070D1E] text-white uppercase tracking-wider text-[11px] border-b border-blue-950">
                    <tr>
                        <th class="py-3.5 px-6 text-center w-16 font-bold">NO</th>
                        <th class="py-3.5 px-6 font-bold">NAMA</th>
                        <th class="py-3.5 px-6 font-bold">NOMOR KARTU</th>
                        <th class="py-3.5 px-6 font-bold">TINGKAT</th>
                        <th class="py-3.5 px-6 font-bold">MASA BERLAKU</th>
                        <th class="py-3.5 px-6 font-bold">JABATAN</th>
                        <th class="py-3.5 px-6 text-center w-36 font-bold">AKSI</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-200 dark:divide-slate-800">
                    @forelse($members as $index => $m)
                        <tr class="hover:bg-slate-50 dark:hover:bg-white/[0.02] transition-colors">
                            <td class="py-3.5 px-6 text-center font-bold text-slate-500 dark:text-slate-400">{{ $members->firstItem() + $index }}</td>
                            <td class="py-3.5 px-6">
                                <div class="font-bold text-slate-900 dark:text-white">{{ $m->nama }}</div>
                                <span class="block text-[11px] font-medium text-slate-600 dark:text-slate-400">{{ $m->nama_media }}</span>
                            </td>
                            <td class="py-3.5 px-6 font-mono text-slate-800 dark:text-slate-300 font-semibold">{{ $m->nomor_kartu ?? '-' }}</td>
                            <td class="py-3.5 px-6">
                                <span class="inline-block px-2.5 py-1 rounded-lg text-[11px] font-bold bg-slate-100 dark:bg-slate-800 text-slate-700 dark:text-slate-300 border border-slate-200 dark:border-slate-700">
                                    {{ $m->tingkat_ukw }}
                                </span>
                            </td>
                            <td class="py-3.5 px-6 text-slate-800 dark:text-slate-300 font-semibold">{{ $m->masa_berlaku ? $m->masa_berlaku->format('d-m-Y') : '-' }}</td>
                            <td class="py-3.5 px-6 text-slate-800 dark:text-slate-300 font-semibold">{{ $m->jabatan }}</td>
                            <td class="py-3.5 px-6 text-center">
                                <form action="{{ route('admin.members.toggle', $m->id) }}" method="POST" class="inline">
                                    @csrf
                                    <button type="submit" class="px-3 py-1.5 rounded-lg bg-emerald-600 hover:bg-emerald-700 text-white text-xs font-bold shadow-sm transition-all" title="Aktifkan Kembali">
                                        <i class="fa-solid fa-rotate-left me-1"></i> Aktifkan
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="py-12 text-center text-slate-500 dark:text-slate-400 font-medium">
                                Tidak ada data wartawan non-aktif.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="p-6 border-t border-slate-200 dark:border-slate-800 flex flex-col sm:flex-row items-center justify-between text-xs text-slate-600 dark:text-slate-400 gap-4 bg-slate-50/50 dark:bg-slate-900/50">
            <div>
                Menampilkan {{ $members->firstItem() ?? 0 }} s/d {{ $members->lastItem() ?? 0 }} dari {{ $members->total() }} wartawan
            </div>
            <div>
                {{ $members->withQueryString()->links() }}
            </div>
        </div>

    </div>

</div>
@endsection
