@extends('layouts.admin')

@section('title', 'Dashboard MIS')
@section('page_title', 'Dashboard Manajemen Sistem')

@section('content')
<div class="space-y-8">
    
    <!-- Top Action Bar -->
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
        <div>
            <h2 class="text-xl font-extrabold text-white">Ringkasan Statistik Keanggotaan</h2>
            <p class="text-xs text-slate-400 mt-1">Data Wartawan Terdaftar PWI Kabupaten Banyuasin</p>
        </div>
        <div class="flex items-center gap-3">
            <a href="{{ route('admin.members.print-report') }}" target="_blank" class="inline-flex items-center gap-2 px-4 py-2.5 rounded-xl text-xs font-bold text-slate-950 bg-amber-400 hover:bg-amber-300 shadow-lg shadow-amber-400/20 transition-all">
                <i class="fa-solid fa-print"></i>
                <span>Cetak Rekapitulasi</span>
            </a>
            <a href="{{ route('admin.meetings.create') }}" class="inline-flex items-center gap-2 px-4 py-2.5 rounded-xl text-xs font-bold text-white bg-emerald-600 hover:bg-emerald-500 shadow-lg shadow-emerald-600/20 transition-all">
                <i class="fa-solid fa-clipboard-check"></i>
                <span>+ Catat Notulen</span>
            </a>
        </div>
    </div>

    <!-- 4 UKW Modern Statistics Cards -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-5">
        
        <!-- Card 1: Belum UKW (Slate/Gray) -->
        <div class="p-6 rounded-3xl bg-slate-900 border border-slate-800 shadow-xl relative overflow-hidden group hover:border-slate-700 transition-all">
            <div class="flex items-center justify-between">
                <span class="text-xs font-bold text-slate-400 uppercase tracking-wider">Belum UKW</span>
                <div class="w-10 h-10 rounded-2xl bg-slate-800 text-slate-300 flex items-center justify-center font-bold text-sm">
                    <i class="fa-solid fa-user-clock"></i>
                </div>
            </div>
            <div class="mt-4 flex items-baseline gap-2">
                <span class="text-3xl font-extrabold text-white">{{ $ukwStats['belum_ukw'] }}</span>
                <span class="text-xs text-slate-400">Wartawan</span>
            </div>
            <div class="mt-4 pt-4 border-t border-slate-800/80 flex items-center justify-between text-[11px] text-slate-400">
                <span>Rasio: {{ round(($ukwStats['belum_ukw'] / max(1, $ukwStats['total_aktif'])) * 100) }}%</span>
                <span class="text-slate-500">Anggota Baru</span>
            </div>
        </div>

        <!-- Card 2: Wartawan Muda (Emerald Green) -->
        <div class="p-6 rounded-3xl bg-slate-900 border border-slate-800 shadow-xl relative overflow-hidden group hover:border-emerald-500/50 transition-all">
            <div class="flex items-center justify-between">
                <span class="text-xs font-bold text-emerald-400 uppercase tracking-wider">Wartawan Muda</span>
                <div class="w-10 h-10 rounded-2xl bg-emerald-500/20 text-emerald-400 flex items-center justify-center font-bold text-sm">
                    <i class="fa-solid fa-certificate"></i>
                </div>
            </div>
            <div class="mt-4 flex items-baseline gap-2">
                <span class="text-3xl font-extrabold text-emerald-400">{{ $ukwStats['muda'] }}</span>
                <span class="text-xs text-slate-400">Wartawan</span>
            </div>
            <div class="mt-4 pt-4 border-t border-slate-800/80 flex items-center justify-between text-[11px] text-slate-400">
                <span>Rasio: {{ round(($ukwStats['muda'] / max(1, $ukwStats['total_aktif'])) * 100) }}%</span>
                <span class="text-emerald-400 font-semibold">Tingkat Muda</span>
            </div>
        </div>

        <!-- Card 3: Wartawan Madya (Cyan/Teal) -->
        <div class="p-6 rounded-3xl bg-slate-900 border border-slate-800 shadow-xl relative overflow-hidden group hover:border-cyan-500/50 transition-all">
            <div class="flex items-center justify-between">
                <span class="text-xs font-bold text-cyan-400 uppercase tracking-wider">Wartawan Madya</span>
                <div class="w-10 h-10 rounded-2xl bg-cyan-500/20 text-cyan-400 flex items-center justify-center font-bold text-sm">
                    <i class="fa-solid fa-medal"></i>
                </div>
            </div>
            <div class="mt-4 flex items-baseline gap-2">
                <span class="text-3xl font-extrabold text-cyan-400">{{ $ukwStats['madya'] }}</span>
                <span class="text-xs text-slate-400">Wartawan</span>
            </div>
            <div class="mt-4 pt-4 border-t border-slate-800/80 flex items-center justify-between text-[11px] text-slate-400">
                <span>Rasio: {{ round(($ukwStats['madya'] / max(1, $ukwStats['total_aktif'])) * 100) }}%</span>
                <span class="text-cyan-400 font-semibold">Tingkat Madya</span>
            </div>
        </div>

        <!-- Card 4: Wartawan Utama (Rose/Red) -->
        <div class="p-6 rounded-3xl bg-slate-900 border border-slate-800 shadow-xl relative overflow-hidden group hover:border-rose-500/50 transition-all">
            <div class="flex items-center justify-between">
                <span class="text-xs font-bold text-rose-400 uppercase tracking-wider">Wartawan Utama</span>
                <div class="w-10 h-10 rounded-2xl bg-rose-500/20 text-rose-400 flex items-center justify-center font-bold text-sm">
                    <i class="fa-solid fa-award"></i>
                </div>
            </div>
            <div class="mt-4 flex items-baseline gap-2">
                <span class="text-3xl font-extrabold text-rose-400">{{ $ukwStats['utama'] }}</span>
                <span class="text-xs text-slate-400">Wartawan</span>
            </div>
            <div class="mt-4 pt-4 border-t border-slate-800/80 flex items-center justify-between text-[11px] text-slate-400">
                <span>Rasio: {{ round(($ukwStats['utama'] / max(1, $ukwStats['total_aktif'])) * 100) }}%</span>
                <span class="text-rose-400 font-semibold">Tingkat Utama</span>
            </div>
        </div>

    </div>

    <!-- Active Members Data Table (Modern Tailwind Style) -->
    <div class="bg-slate-900 border border-slate-800 rounded-3xl shadow-xl overflow-hidden">
        
        <!-- Table Header & Filter Bar -->
        <div class="p-6 border-b border-slate-800 flex flex-col sm:flex-row sm:items-center justify-between gap-4">
            <div>
                <h3 class="text-base font-bold text-white">DATA ANGGOTA PWI BANYUASIN</h3>
                <p class="text-xs text-slate-400 mt-0.5">Daftar wartawan aktif terdaftar secara resmi di PWI Kabupaten Banyuasin</p>
            </div>
            
            <div class="flex items-center gap-3">
                <form action="{{ route('admin.dashboard') }}" method="GET" class="flex items-center gap-2">
                    <div class="relative">
                        <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari nama / nomor kartu..." class="w-64 pl-9 pr-4 py-2 rounded-xl bg-slate-950 border border-slate-800 text-xs text-slate-200 focus:ring-2 focus:ring-amber-500 focus:border-amber-500 outline-none">
                        <i class="fa-solid fa-magnifying-glass absolute left-3 top-3 text-slate-500 text-xs"></i>
                    </div>
                </form>
                <a href="{{ route('admin.members.index') }}" class="px-4 py-2 rounded-xl text-xs font-bold text-blue-400 bg-blue-500/10 hover:bg-blue-500/20 border border-blue-500/30 transition-colors">
                    Kelola Anggota <i class="fa-solid fa-arrow-right text-[10px] ms-1"></i>
                </a>
            </div>
        </div>

        <!-- Table Container -->
        <div class="overflow-x-auto">
            <table class="w-full text-left text-xs text-slate-300">
                <thead class="bg-slate-950/70 text-slate-400 uppercase tracking-wider text-[11px] border-b border-slate-800">
                    <tr>
                        <th class="py-3.5 px-6 text-center w-16">NO</th>
                        <th class="py-3.5 px-6 w-20 text-center">FOTO</th>
                        <th class="py-3.5 px-6">NAMA</th>
                        <th class="py-3.5 px-6">NOMOR KARTU</th>
                        <th class="py-3.5 px-6">TINGKAT</th>
                        <th class="py-3.5 px-6">MASA BERLAKU</th>
                        <th class="py-3.5 px-6">JABATAN</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-800/60">
                    @forelse($members as $index => $m)
                        <tr class="hover:bg-white/[0.02] transition-colors">
                            <td class="py-3.5 px-6 text-center font-bold text-slate-500">{{ $members->firstItem() + $index }}</td>
                            <td class="py-3.5 px-6 text-center">
                                <div class="w-10 h-10 rounded-xl bg-slate-800 overflow-hidden mx-auto">
                                    <img src="{{ $m->foto_url }}" alt="{{ $m->nama }}" class="w-full h-full object-cover">
                                </div>
                            </td>
                            <td class="py-3.5 px-6 font-bold text-white">
                                {{ $m->nama }}
                                <span class="block text-[11px] font-normal text-slate-400">{{ $m->nama_media }}</span>
                            </td>
                            <td class="py-3.5 px-6 font-mono text-slate-400">{{ $m->nomor_kartu ?? '-' }}</td>
                            <td class="py-3.5 px-6">
                                <span class="inline-block px-2.5 py-1 rounded-lg text-[11px] font-bold {{ $m->ukw_color_badge }}">
                                    {{ $m->tingkat_ukw }}
                                </span>
                            </td>
                            <td class="py-3.5 px-6 text-slate-400">{{ $m->masa_berlaku ? $m->masa_berlaku->format('d-m-Y') : '-' }}</td>
                            <td class="py-3.5 px-6 font-bold text-amber-400">{{ $m->jabatan }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="py-12 text-center text-slate-500">
                                Tidak ada data anggota terdaftar.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Table Footer Pagination -->
        <div class="p-6 border-t border-slate-800 flex flex-col sm:flex-row items-center justify-between text-xs text-slate-400 gap-4">
            <div>
                Menampilkan {{ $members->firstItem() ?? 0 }} s/d {{ $members->lastItem() ?? 0 }} dari total {{ $members->total() }} anggota
            </div>
            <div>
                {{ $members->withQueryString()->links() }}
            </div>
        </div>

    </div>

</div>
@endsection
