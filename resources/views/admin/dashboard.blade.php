@extends('layouts.admin')

@section('title', 'Dashboard MIS')
@section('page_title', 'Dashboard Manajemen Sistem')

@section('content')
<div class="space-y-8">
    
    <!-- Top Action Bar -->
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
        <div>
            <h2 class="text-xl font-extrabold text-[#0B132B] dark:text-white">Ringkasan Statistik Keanggotaan</h2>
            <p class="text-xs text-slate-600 dark:text-slate-400 mt-1 font-medium">Data Wartawan Terdaftar PWI Kabupaten Banyuasin</p>
        </div>
        <div class="flex items-center gap-3">
            <a href="{{ route('admin.members.print-report') }}" target="_blank" class="inline-flex items-center gap-2 px-4 py-2.5 rounded-xl text-xs font-bold text-slate-700 dark:text-slate-200 bg-white dark:bg-slate-800 hover:bg-slate-50 dark:hover:bg-slate-700 border border-slate-300 dark:border-slate-700 shadow-sm transition-all">
                <i class="fa-solid fa-print text-slate-500 dark:text-slate-400"></i>
                <span>Cetak Rekapitulasi</span>
            </a>
            <a href="{{ route('admin.meetings.create') }}" class="inline-flex items-center gap-2 px-4 py-2.5 rounded-xl text-xs font-bold text-white bg-blue-600 hover:bg-blue-700 dark:bg-amber-400 dark:hover:bg-amber-300 dark:text-slate-950 shadow-sm transition-all">
                <i class="fa-solid fa-clipboard-check text-emerald-300 dark:text-slate-950"></i>
                <span>+ Catat Notulen</span>
            </a>
        </div>
    </div>

    <!-- 4 UKW Modern Statistics Cards (Deep Navy & Accent Palette) -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-5">
        
        <!-- Card 1: Belum UKW -->
        <div class="p-6 rounded-2xl bg-white dark:bg-slate-900 border border-slate-300 dark:border-slate-800 shadow-sm relative overflow-hidden group hover:border-blue-500 transition-all">
            <div class="flex items-center justify-between">
                <span class="text-xs font-bold text-slate-600 dark:text-slate-400 uppercase tracking-wider">Belum UKW</span>
                <div class="w-10 h-10 rounded-xl bg-slate-100 text-slate-700 dark:bg-slate-800 dark:text-slate-300 flex items-center justify-center font-bold text-sm">
                    <i class="fa-solid fa-user-clock"></i>
                </div>
            </div>
            <div class="mt-4 flex items-baseline gap-2">
                <span class="text-3xl font-black text-[#0B132B] dark:text-white">{{ $ukwStats['belum_ukw'] }}</span>
                <span class="text-xs text-slate-600 dark:text-slate-400 font-semibold">Wartawan</span>
            </div>
            <div class="mt-4 pt-4 border-t border-slate-100 dark:border-slate-800 flex items-center justify-between text-[11px] text-slate-600 dark:text-slate-400 font-medium">
                <span>Rasio: {{ round(($ukwStats['belum_ukw'] / max(1, $ukwStats['total_aktif'])) * 100) }}%</span>
                <span class="text-slate-500 font-semibold">Anggota Baru</span>
            </div>
        </div>

        <!-- Card 2: Wartawan Muda (Emerald Green) -->
        <div class="p-6 rounded-2xl bg-white dark:bg-slate-900 border border-slate-300 dark:border-slate-800 shadow-sm relative overflow-hidden group hover:border-emerald-500 transition-all">
            <div class="flex items-center justify-between">
                <span class="text-xs font-bold text-emerald-800 dark:text-emerald-400 uppercase tracking-wider">Wartawan Muda</span>
                <div class="w-10 h-10 rounded-xl bg-emerald-50 text-emerald-700 dark:bg-emerald-950/60 dark:text-emerald-400 flex items-center justify-center font-bold text-sm">
                    <i class="fa-solid fa-certificate"></i>
                </div>
            </div>
            <div class="mt-4 flex items-baseline gap-2">
                <span class="text-3xl font-black text-[#0B132B] dark:text-white">{{ $ukwStats['muda'] }}</span>
                <span class="text-xs text-slate-600 dark:text-slate-400 font-semibold">Wartawan</span>
            </div>
            <div class="mt-4 pt-4 border-t border-slate-100 dark:border-slate-800 flex items-center justify-between text-[11px] text-slate-600 dark:text-slate-400 font-medium">
                <span>Rasio: {{ round(($ukwStats['muda'] / max(1, $ukwStats['total_aktif'])) * 100) }}%</span>
                <span class="text-emerald-700 dark:text-emerald-400 font-bold">Tingkat Muda</span>
            </div>
        </div>

        <!-- Card 3: Wartawan Madya (Royal Blue) -->
        <div class="p-6 rounded-2xl bg-white dark:bg-slate-900 border border-slate-300 dark:border-slate-800 shadow-sm relative overflow-hidden group hover:border-blue-500 transition-all">
            <div class="flex items-center justify-between">
                <span class="text-xs font-bold text-blue-800 dark:text-blue-400 uppercase tracking-wider">Wartawan Madya</span>
                <div class="w-10 h-10 rounded-xl bg-blue-50 text-blue-700 dark:bg-blue-950/60 dark:text-blue-400 flex items-center justify-center font-bold text-sm">
                    <i class="fa-solid fa-medal"></i>
                </div>
            </div>
            <div class="mt-4 flex items-baseline gap-2">
                <span class="text-3xl font-black text-[#0B132B] dark:text-white">{{ $ukwStats['madya'] }}</span>
                <span class="text-xs text-slate-600 dark:text-slate-400 font-semibold">Wartawan</span>
            </div>
            <div class="mt-4 pt-4 border-t border-slate-100 dark:border-slate-800 flex items-center justify-between text-[11px] text-slate-600 dark:text-slate-400 font-medium">
                <span>Rasio: {{ round(($ukwStats['madya'] / max(1, $ukwStats['total_aktif'])) * 100) }}%</span>
                <span class="text-blue-700 dark:text-blue-400 font-bold">Tingkat Madya</span>
            </div>
        </div>

        <!-- Card 4: Wartawan Utama (Rose/Wine) -->
        <div class="p-6 rounded-2xl bg-white dark:bg-slate-900 border border-slate-300 dark:border-slate-800 shadow-sm relative overflow-hidden group hover:border-rose-500 transition-all">
            <div class="flex items-center justify-between">
                <span class="text-xs font-bold text-rose-800 dark:text-rose-400 uppercase tracking-wider">Wartawan Utama</span>
                <div class="w-10 h-10 rounded-xl bg-rose-50 text-rose-700 dark:bg-rose-950/60 dark:text-rose-400 flex items-center justify-center font-bold text-sm">
                    <i class="fa-solid fa-award"></i>
                </div>
            </div>
            <div class="mt-4 flex items-baseline gap-2">
                <span class="text-3xl font-black text-[#0B132B] dark:text-white">{{ $ukwStats['utama'] }}</span>
                <span class="text-xs text-slate-600 dark:text-slate-400 font-semibold">Wartawan</span>
            </div>
            <div class="mt-4 pt-4 border-t border-slate-100 dark:border-slate-800 flex items-center justify-between text-[11px] text-slate-600 dark:text-slate-400 font-medium">
                <span>Rasio: {{ round(($ukwStats['utama'] / max(1, $ukwStats['total_aktif'])) * 100) }}%</span>
                <span class="text-rose-700 dark:text-rose-400 font-bold">Tingkat Utama</span>
            </div>
        </div>

    </div>

    <!-- Active Members Data Table (Deep Navy Header & Maximum Legibility) -->
    <div class="bg-white dark:bg-slate-900 border border-slate-300 dark:border-slate-800 rounded-2xl shadow-sm overflow-hidden">
        
        <!-- Table Header & Filter Bar -->
        <div class="p-6 border-b border-slate-200 dark:border-slate-800 flex flex-col sm:flex-row sm:items-center justify-between gap-4 bg-slate-50/50 dark:bg-slate-900/50">
            <div>
                <h3 class="text-base font-black text-[#0B132B] dark:text-white">DATA ANGGOTA PWI BANYUASIN</h3>
                <p class="text-xs text-slate-600 dark:text-slate-400 mt-0.5 font-medium">Daftar wartawan aktif terdaftar secara resmi di PWI Kabupaten Banyuasin</p>
            </div>
            
            <div class="flex items-center gap-3">
                <form action="{{ route('admin.dashboard') }}" method="GET" class="flex items-center gap-2">
                    <div class="relative">
                        <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari nama / nomor kartu..." class="w-64 pl-9 pr-4 py-2 rounded-xl bg-white dark:bg-slate-950 border border-slate-300 dark:border-slate-700 text-xs font-medium text-slate-900 dark:text-slate-200 focus:ring-2 focus:ring-blue-600 outline-none shadow-sm transition-all">
                        <i class="fa-solid fa-magnifying-glass absolute left-3 top-3 text-slate-400 text-xs"></i>
                    </div>
                </form>
                <a href="{{ route('admin.members.index') }}" class="px-4 py-2 rounded-xl text-xs font-bold text-white bg-blue-600 hover:bg-blue-700 dark:bg-slate-800 dark:hover:bg-slate-700 shadow-sm transition-colors">
                    Kelola Anggota <i class="fa-solid fa-arrow-right text-[10px] ms-1"></i>
                </a>
            </div>
        </div>

        <!-- Table Container with Deep Navy Header -->
        <div class="overflow-x-auto">
            <table class="w-full text-left text-xs text-slate-800 dark:text-slate-200">
                <thead class="bg-[#0B132B] dark:bg-[#070D1E] text-white uppercase tracking-wider text-[11px] border-b border-blue-950">
                    <tr>
                        <th class="py-3.5 px-6 text-center w-16 font-bold">NO</th>
                        <th class="py-3.5 px-6 w-20 text-center font-bold">FOTO</th>
                        <th class="py-3.5 px-6 font-bold">NAMA</th>
                        <th class="py-3.5 px-6 font-bold">NOMOR KARTU</th>
                        <th class="py-3.5 px-6 font-bold">TINGKAT</th>
                        <th class="py-3.5 px-6 font-bold">MASA BERLAKU</th>
                        <th class="py-3.5 px-6 font-bold">JABATAN</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-200 dark:divide-slate-800">
                    @forelse($members as $index => $m)
                        <tr class="hover:bg-slate-50 dark:hover:bg-white/[0.02] transition-colors">
                            <td class="py-3.5 px-6 text-center font-bold text-slate-500 dark:text-slate-400">{{ $members->firstItem() + $index }}</td>
                            <td class="py-3.5 px-6 text-center">
                                <div class="w-10 h-10 rounded-xl bg-slate-100 dark:bg-slate-800 ring-1 ring-slate-300 dark:ring-slate-700 overflow-hidden mx-auto shadow-sm">
                                    <img src="{{ $m->foto_url }}" alt="{{ $m->nama }}" class="w-full h-full object-cover">
                                </div>
                            </td>
                            <td class="py-3.5 px-6">
                                <div class="font-bold text-slate-900 dark:text-white">{{ $m->nama }}</div>
                                <span class="block text-[11px] font-medium text-slate-600 dark:text-slate-400">{{ $m->nama_media }}</span>
                            </td>
                            <td class="py-3.5 px-6 font-mono text-slate-800 dark:text-slate-300 font-semibold">{{ $m->nomor_kartu ?? '-' }}</td>
                            <td class="py-3.5 px-6">
                                <span class="inline-block px-2.5 py-1 rounded-lg text-[11px] font-bold {{ $m->ukw_color_badge }}">
                                    {{ $m->tingkat_ukw }}
                                </span>
                            </td>
                            <td class="py-3.5 px-6 text-slate-800 dark:text-slate-300 font-semibold">{{ $m->masa_berlaku ? $m->masa_berlaku->format('d-m-Y') : '-' }}</td>
                            <td class="py-3.5 px-6">
                                <span class="inline-block px-2.5 py-1 rounded-md bg-slate-100 dark:bg-slate-800 border border-slate-300 dark:border-slate-700 text-[#0B132B] dark:text-slate-200 font-bold text-[11px]">
                                    {{ $m->jabatan }}
                                </span>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="py-12 text-center text-slate-500 dark:text-slate-400 font-medium">
                                Tidak ada data anggota terdaftar.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Table Footer Pagination -->
        <div class="p-6 border-t border-slate-200 dark:border-slate-800 flex flex-col sm:flex-row items-center justify-between text-xs text-slate-600 dark:text-slate-400 gap-4 bg-slate-50/50 dark:bg-slate-900/50">
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
