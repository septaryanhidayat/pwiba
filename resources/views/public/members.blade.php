@extends('layouts.public')

@section('title', 'Direktori Anggota Wartawan PWI Banyuasin')

@section('content')
<!-- Header Banner -->
<div class="gradient-mesh text-white py-16 relative overflow-hidden text-center sm:text-left">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
        <div class="max-w-3xl mx-auto sm:mx-0 flex flex-col items-center sm:items-start">
            <span class="text-xs font-bold uppercase tracking-wider text-amber-400 bg-white/10 px-3.5 py-1 rounded-full border border-white/15">
                Direktori Resmi
            </span>
            <h1 class="text-3xl sm:text-4xl font-extrabold text-white mt-3">
                Data Wartawan Terdaftar PWI Banyuasin
            </h1>
            <p class="text-slate-300 text-sm sm:text-base mt-2">
                Daftar jurnalis profesional terverifikasi dengan jenjang Uji Kompetensi Wartawan (UKW) dan media pers yang terafiliasi.
            </p>
        </div>
    </div>
</div>

<div class="py-12 bg-slate-50 dark:bg-slate-950 transition-colors duration-200">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        
        @if(!$showPublicMembers)
            <!-- Pemutakhiran Data Notice Card (Ketika Direktori Dinonaktifkan) -->
            <div class="max-w-3xl mx-auto py-12 text-center">
                <div class="bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800 rounded-3xl p-8 sm:p-12 shadow-xl relative overflow-hidden">
                    <div class="w-20 h-20 rounded-3xl bg-amber-500/10 text-amber-500 flex items-center justify-center text-3xl mx-auto mb-6 shadow-inner ring-1 ring-amber-500/20">
                        <i class="fa-solid fa-user-clock animate-pulse"></i>
                    </div>

                    <span class="inline-flex items-center gap-2 px-3 py-1 rounded-full text-xs font-bold bg-amber-50 text-amber-700 dark:bg-amber-950/60 dark:text-amber-300 border border-amber-200 dark:border-amber-800 mb-4">
                        <span class="w-2 h-2 rounded-full bg-amber-500 animate-ping"></span>
                        Tahap Verifikasi & Pemutakhiran
                    </span>

                    <h2 class="text-2xl sm:text-3xl font-extrabold text-[#0B132B] dark:text-white mb-3">
                        Direktori Anggota Sedang Diperbarui
                    </h2>

                    <p class="text-slate-600 dark:text-slate-300 text-sm leading-relaxed max-w-xl mx-auto mb-8 font-medium">
                        Mohon maaf atas ketidaknyamanannya. Halaman direktori keanggotaan wartawan terdaftar PWI Kabupaten Banyuasin saat ini sedang dalam proses sinkronisasi, pemutakhiran jenjang UKW, serta verifikasi data media resmi oleh sekretariat.
                    </p>

                    <div class="flex flex-col sm:flex-row items-center justify-center gap-3.5">
                        <a href="{{ route('organization.public') }}" class="w-full sm:w-auto inline-flex items-center justify-center gap-2 px-6 py-3 rounded-xl font-bold text-sm text-white bg-blue-600 hover:bg-blue-700 shadow-md shadow-blue-600/20 transition-all">
                            <i class="fa-solid fa-sitemap"></i>
                            <span>Lihat Struktur Pengurus</span>
                        </a>
                        <a href="{{ route('home') }}" class="w-full sm:w-auto inline-flex items-center justify-center gap-2 px-6 py-3 rounded-xl font-bold text-sm text-slate-700 dark:text-slate-200 bg-slate-100 hover:bg-slate-200 dark:bg-slate-800 dark:hover:bg-slate-700 transition-all">
                            <i class="fa-solid fa-house"></i>
                            <span>Kembali ke Beranda</span>
                        </a>
                    </div>
                </div>
            </div>
        @else
            <!-- Filter and Search -->
            <div class="flex flex-col sm:flex-row items-center justify-between gap-4 mb-8 text-center sm:text-left">
                <div>
                    <h3 class="text-base font-extrabold text-slate-900 dark:text-white">
                        Insan Pers Terdaftar ({{ $members->total() }} Wartawan)
                    </h3>
                    <p class="text-xs text-slate-500 dark:text-slate-400 mt-0.5">
                        Wartawan resmi dan profesional yang mengemban tugas jurnalistik di Kabupaten Banyuasin
                    </p>
                </div>

                <form action="{{ route('members.public') }}" method="GET" class="w-full sm:w-80">
                    <div class="relative">
                        <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari nama wartawan, KTA, atau media..." class="w-full pl-10 pr-4 py-2.5 rounded-xl border border-slate-200 dark:border-slate-700 bg-white dark:bg-slate-900 text-xs text-slate-900 dark:text-white focus:ring-2 focus:ring-blue-600 focus:border-blue-600 outline-none shadow-sm">
                        <i class="fa-solid fa-magnifying-glass absolute left-3.5 top-3.5 text-slate-400 text-xs"></i>
                    </div>
                </form>
            </div>

            <!-- Members Grid -->
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
                @forelse($members as $m)
                    <div class="bg-white dark:bg-slate-900 rounded-2xl p-6 border border-slate-200 dark:border-slate-800 shadow-sm hover:shadow-xl transition-all duration-300 group hover:-translate-y-1 flex flex-col justify-between">
                        <div>
                            <div class="flex items-center gap-4 mb-4">
                                <div class="w-14 h-14 rounded-2xl bg-slate-900 text-white flex items-center justify-center font-bold text-lg shadow-md overflow-hidden flex-shrink-0 aspect-square">
                                    <img src="{{ $m->foto_url }}" alt="{{ $m->nama }}" width="56" height="56" loading="lazy" decoding="async" class="w-full h-full object-cover">
                                </div>
                                <div class="min-w-0 flex-grow">
                                    <h4 class="text-sm font-bold text-slate-900 dark:text-white truncate group-hover:text-blue-600 dark:group-hover:text-blue-400 transition-colors">{{ $m->nama }}</h4>
                                    <span class="block text-[11px] font-semibold text-slate-500 dark:text-slate-400 uppercase truncate">
                                        {{ $m->nomor_kartu ?? 'KTA PWI Banyuasin' }}
                                    </span>
                                </div>
                            </div>

                            <div class="p-3 rounded-xl bg-slate-50 dark:bg-slate-800/80 border border-slate-100 dark:border-slate-700/60 mb-4 space-y-1.5 text-xs">
                                <div class="flex items-center justify-between">
                                    <span class="text-slate-400 text-[10px] uppercase font-bold">Jabatan / Peran</span>
                                    <span class="font-extrabold text-blue-900 dark:text-blue-300">{{ $m->jabatan ?? 'Wartawan' }}</span>
                                </div>
                                <div class="flex items-center justify-between">
                                    <span class="text-slate-400 text-[10px] uppercase font-bold">Media Pers</span>
                                    <span class="font-semibold text-slate-700 dark:text-slate-300 truncate max-w-[180px]">{{ $m->nama_media ?? 'Media Mitra PWI' }}</span>
                                </div>
                            </div>
                        </div>

                        <!-- Social Media Icons for Each Journalist -->
                        <div class="pt-3 border-t border-slate-100 dark:border-slate-800 flex items-center justify-between">
                            <div class="flex items-center gap-2">
                                <a href="{{ $m->x_twitter ?: 'https://x.com/pwibanyuasin' }}" target="_blank" rel="noopener noreferrer" aria-label="X Twitter {{ $m->nama }}" class="w-7 h-7 rounded-lg bg-slate-100 dark:bg-slate-800 hover:bg-slate-900 hover:text-white text-slate-500 dark:text-slate-400 flex items-center justify-center text-xs transition-colors" title="X (Twitter)">
                                    <i class="fa-brands fa-x-twitter"></i>
                                </a>
                                <a href="{{ $m->facebook ?: 'https://facebook.com/pwibanyuasin' }}" target="_blank" rel="noopener noreferrer" aria-label="Facebook {{ $m->nama }}" class="w-7 h-7 rounded-lg bg-blue-50 dark:bg-blue-950/60 hover:bg-blue-600 hover:text-white text-blue-600 dark:text-blue-400 flex items-center justify-center text-xs transition-colors" title="Facebook">
                                    <i class="fa-brands fa-facebook-f"></i>
                                </a>
                                <a href="{{ $m->instagram ?: 'https://instagram.com/pwibanyuasin' }}" target="_blank" rel="noopener noreferrer" aria-label="Instagram {{ $m->nama }}" class="w-7 h-7 rounded-lg bg-rose-50 dark:bg-rose-950/60 hover:bg-gradient-to-tr hover:from-amber-500 hover:via-rose-500 hover:to-purple-600 hover:text-white text-rose-500 dark:text-rose-400 flex items-center justify-center text-xs transition-colors" title="Instagram">
                                    <i class="fa-brands fa-instagram"></i>
                                </a>
                                <a href="{{ $m->youtube ?: 'https://youtube.com/@pwibanyuasin' }}" target="_blank" rel="noopener noreferrer" aria-label="YouTube {{ $m->nama }}" class="w-7 h-7 rounded-lg bg-red-50 dark:bg-red-950/60 hover:bg-red-600 hover:text-white text-red-600 dark:text-red-400 flex items-center justify-center text-xs transition-colors" title="YouTube">
                                    <i class="fa-brands fa-youtube"></i>
                                </a>
                            </div>
                            <span class="inline-flex items-center gap-1 text-[11px] font-bold text-emerald-600 dark:text-emerald-400">
                                <i class="fa-solid fa-circle-check text-[9px]"></i> Terverifikasi
                            </span>
                        </div>
                    </div>
                @empty
                    <div class="col-span-3 text-center py-16 bg-white dark:bg-slate-900 rounded-2xl border border-slate-200 dark:border-slate-800 text-slate-500">
                        Tidak ditemukan data wartawan yang sesuai.
                    </div>
                @endforelse
            </div>

            <!-- Pagination -->
            <div class="mt-12 flex justify-center">
                {{ $members->withQueryString()->links() }}
            </div>
        @endif

    </div>
</div>
@endsection
