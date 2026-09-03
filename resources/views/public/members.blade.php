@extends('layouts.public')

@section('title', 'Direktori Anggota Wartawan PWI Banyuasin')

@section('content')
<!-- Header Banner -->
<div class="gradient-mesh text-white py-16 relative overflow-hidden">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
        <div class="max-w-3xl">
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
        
        <!-- UKW Level Stat Pills -->
        <div class="grid grid-cols-2 sm:grid-cols-4 gap-4 mb-8">
            <a href="{{ route('members.public') }}?ukw=Wartawan Utama" class="p-4 rounded-2xl bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800 shadow-sm hover:border-rose-300 dark:hover:border-rose-500/50 hover:shadow-md transition-all flex items-center justify-between">
                <div>
                    <div class="text-[10px] font-bold uppercase text-slate-400">Wartawan Utama</div>
                    <div class="text-xl font-extrabold text-rose-600 dark:text-rose-400">{{ $ukwStats['utama'] }} Orang</div>
                </div>
                <div class="w-8 h-8 rounded-xl bg-rose-50 dark:bg-rose-950/60 text-rose-500 dark:text-rose-400 flex items-center justify-center font-bold text-xs">
                    <i class="fa-solid fa-award"></i>
                </div>
            </a>
            <a href="{{ route('members.public') }}?ukw=Wartawan Madya" class="p-4 rounded-2xl bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800 shadow-sm hover:border-cyan-300 dark:hover:border-cyan-500/50 hover:shadow-md transition-all flex items-center justify-between">
                <div>
                    <div class="text-[10px] font-bold uppercase text-slate-400">Wartawan Madya</div>
                    <div class="text-xl font-extrabold text-cyan-600 dark:text-cyan-400">{{ $ukwStats['madya'] }} Orang</div>
                </div>
                <div class="w-8 h-8 rounded-xl bg-cyan-50 dark:bg-cyan-950/60 text-cyan-500 dark:text-cyan-400 flex items-center justify-center font-bold text-xs">
                    <i class="fa-solid fa-medal"></i>
                </div>
            </a>
            <a href="{{ route('members.public') }}?ukw=Wartawan Muda" class="p-4 rounded-2xl bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800 shadow-sm hover:border-emerald-300 dark:hover:border-emerald-500/50 hover:shadow-md transition-all flex items-center justify-between">
                <div>
                    <div class="text-[10px] font-bold uppercase text-slate-400">Wartawan Muda</div>
                    <div class="text-xl font-extrabold text-emerald-600 dark:text-emerald-400">{{ $ukwStats['muda'] }} Orang</div>
                </div>
                <div class="w-8 h-8 rounded-xl bg-emerald-50 dark:bg-emerald-950/60 text-emerald-500 dark:text-emerald-400 flex items-center justify-center font-bold text-xs">
                    <i class="fa-solid fa-certificate"></i>
                </div>
            </a>
            <a href="{{ route('members.public') }}?ukw=Belum UKW" class="p-4 rounded-2xl bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800 shadow-sm hover:border-slate-300 dark:hover:border-slate-700 hover:shadow-md transition-all flex items-center justify-between">
                <div>
                    <div class="text-[10px] font-bold uppercase text-slate-400">Belum UKW</div>
                    <div class="text-xl font-extrabold text-slate-700 dark:text-slate-300">{{ $ukwStats['belum_ukw'] }} Orang</div>
                </div>
                <div class="w-8 h-8 rounded-xl bg-slate-100 dark:bg-slate-800 text-slate-500 dark:text-slate-400 flex items-center justify-center font-bold text-xs">
                    <i class="fa-solid fa-user-check"></i>
                </div>
            </a>
        </div>

        <!-- Filter and Search -->
        <div class="flex flex-col sm:flex-row items-center justify-between gap-4 mb-8">
            <div class="flex items-center gap-2">
                <a href="{{ route('members.public') }}" class="px-4 py-2 rounded-xl text-xs font-bold transition-all {{ !request('ukw') ? 'bg-slate-900 dark:bg-amber-400 text-white dark:text-slate-950 shadow-md' : 'bg-white dark:bg-slate-900 text-slate-600 dark:text-slate-300 hover:bg-slate-100 dark:hover:bg-slate-800 border border-slate-200 dark:border-slate-800' }}">
                    Semua Jenjang
                </a>
            </div>

            <form action="{{ route('members.public') }}" method="GET" class="w-full sm:w-80">
                @if(request('ukw'))
                    <input type="hidden" name="ukw" value="{{ request('ukw') }}">
                @endif
                <div class="relative">
                    <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari nama, KTA, atau jabatan..." class="w-full pl-10 pr-4 py-2.5 rounded-xl border border-slate-200 dark:border-slate-700 bg-white dark:bg-slate-900 text-xs text-slate-900 dark:text-white focus:ring-2 focus:ring-amber-500 focus:border-amber-500 outline-none shadow-sm">
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
                            <div class="w-14 h-14 rounded-2xl bg-slate-900 text-white flex items-center justify-center font-bold text-lg shadow-md overflow-hidden flex-shrink-0">
                                <img src="{{ $m->foto_url }}" alt="{{ $m->nama }}" class="w-full h-full object-cover">
                            </div>
                            <div class="min-w-0 flex-grow">
                                <h4 class="text-sm font-bold text-slate-900 dark:text-white truncate group-hover:text-blue-600 dark:group-hover:text-blue-400 transition-colors">{{ $m->nama }}</h4>
                                <span class="block text-[11px] font-semibold text-slate-500 dark:text-slate-400 uppercase truncate">
                                    {{ $m->nomor_kartu ?? 'KTA Belum Terbit' }}
                                </span>
                            </div>
                        </div>

                        <div class="p-3 rounded-xl bg-slate-50 dark:bg-slate-800/80 border border-slate-100 dark:border-slate-700/60 mb-4 space-y-1.5 text-xs">
                            <div class="flex items-center justify-between">
                                <span class="text-slate-400 text-[10px] uppercase font-bold">Jabatan</span>
                                <span class="font-extrabold text-blue-900 dark:text-blue-300">{{ $m->jabatan }}</span>
                            </div>
                            <div class="flex items-center justify-between">
                                <span class="text-slate-400 text-[10px] uppercase font-bold">Media Pers</span>
                                <span class="font-semibold text-slate-700 dark:text-slate-300 truncate max-w-[180px]">{{ $m->nama_media }}</span>
                            </div>
                        </div>
                    </div>

                    <div class="pt-3 border-t border-slate-100 dark:border-slate-800 flex items-center justify-between text-xs">
                        <span class="px-2.5 py-0.5 rounded-md font-semibold {{ $m->tingkat_ukw === 'Wartawan Utama' ? 'bg-rose-50 text-rose-600 border border-rose-200 dark:bg-rose-950/60 dark:text-rose-400 dark:border-rose-800' : ($m->tingkat_ukw === 'Wartawan Madya' ? 'bg-cyan-50 text-cyan-600 border border-cyan-200 dark:bg-cyan-950/60 dark:text-cyan-400 dark:border-cyan-800' : ($m->tingkat_ukw === 'Wartawan Muda' ? 'bg-emerald-50 text-emerald-600 border border-emerald-200 dark:bg-emerald-950/60 dark:text-emerald-400 dark:border-emerald-800' : 'bg-slate-100 text-slate-600 dark:bg-slate-800 dark:text-slate-300')) }}">
                            {{ $m->tingkat_ukw }}
                        </span>
                        <span class="text-slate-400 text-[10px]">
                            {{ $m->masa_berlaku ? 'Berlaku s/d ' . $m->masa_berlaku->format('d/m/Y') : 'Aktif' }}
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

    </div>
</div>
@endsection
