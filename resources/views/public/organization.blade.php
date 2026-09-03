@extends('layouts.public')

@section('title', 'Susunan Struktur Organisasi PWI Kabupaten Banyuasin')

@section('content')
<!-- Header Banner -->
<div class="gradient-mesh text-white py-16 relative overflow-hidden text-center sm:text-left">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
        <div class="max-w-3xl mx-auto sm:mx-0 flex flex-col items-center sm:items-start">
            <span class="text-xs font-bold uppercase tracking-wider text-amber-400 bg-white/10 px-3.5 py-1 rounded-full border border-white/15">
                Struktur Kepengurusan Resmi
            </span>
            <h1 class="text-3xl sm:text-4xl font-extrabold text-white mt-3">
                Jajaran Pengurus PWI Kabupaten Banyuasin
            </h1>
            <p class="text-slate-300 text-sm sm:text-base mt-2">
                Masa Bhakti 2025–2028 • Mengabdi untuk kemajuan dan martabat pers di Bumi Sedulang Setudung.
            </p>
        </div>
    </div>
</div>

<div class="py-16 bg-slate-50 dark:bg-slate-950 transition-colors duration-200">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
            @forelse($structures as $s)
                <div class="bg-white dark:bg-slate-900 rounded-2xl p-6 border border-slate-200 dark:border-slate-800 shadow-sm hover:shadow-xl transition-all duration-300 group hover:-translate-y-1 flex flex-col justify-between">
                    <div>
                        <div class="flex items-center gap-4 mb-4">
                            <div class="w-14 h-14 rounded-2xl bg-slate-100 dark:bg-slate-800 text-slate-700 dark:text-slate-200 flex items-center justify-center font-bold text-lg shadow-sm ring-1 ring-slate-200 dark:ring-slate-700 overflow-hidden flex-shrink-0">
                                <img src="{{ $s->foto_url }}" alt="{{ $s->nama }}" class="w-full h-full object-cover">
                            </div>
                            <div class="min-w-0 flex-grow">
                                <h4 class="text-sm font-bold text-slate-900 dark:text-white truncate group-hover:text-blue-600 dark:group-hover:text-blue-400 transition-colors">{{ $s->nama }}</h4>
                                <span class="block text-[10px] font-semibold text-slate-500 dark:text-slate-400 uppercase truncate">
                                    {{ $s->nomor_kartu ?? 'KTA PWI' }}
                                </span>
                            </div>
                        </div>

                        <div class="p-3 rounded-xl bg-slate-50 dark:bg-slate-800/80 border border-slate-100 dark:border-slate-700/60 mb-4">
                            <div class="text-[10px] uppercase font-bold text-slate-400">Jabatan Kepengurusan</div>
                            <div class="text-xs font-extrabold text-blue-900 dark:text-blue-300 leading-snug">{{ $s->jabatan }}</div>
                        </div>
                    </div>

                    <div class="pt-3 border-t border-slate-100 dark:border-slate-800 flex items-center justify-between">
                        <div class="flex items-center gap-1.5">
                            <a href="{{ $s->x_twitter ?: 'https://x.com/pwibanyuasin' }}" target="_blank" class="w-6 h-6 rounded-md bg-slate-100 dark:bg-slate-800 hover:bg-slate-900 hover:text-white text-slate-500 dark:text-slate-400 flex items-center justify-center text-[10px] transition-colors" title="X (Twitter)">
                                <i class="fa-brands fa-x-twitter"></i>
                            </a>
                            <a href="{{ $s->facebook ?: 'https://facebook.com/pwibanyuasin' }}" target="_blank" class="w-6 h-6 rounded-md bg-blue-50 dark:bg-blue-950/60 hover:bg-blue-600 hover:text-white text-blue-600 dark:text-blue-400 flex items-center justify-center text-[10px] transition-colors" title="Facebook">
                                <i class="fa-brands fa-facebook-f"></i>
                            </a>
                            <a href="{{ $s->instagram ?: 'https://instagram.com/pwibanyuasin' }}" target="_blank" class="w-6 h-6 rounded-md bg-rose-50 dark:bg-rose-950/60 hover:bg-rose-600 hover:text-white text-rose-500 dark:text-rose-400 flex items-center justify-center text-[10px] transition-colors" title="Instagram">
                                <i class="fa-brands fa-instagram"></i>
                            </a>
                            <a href="{{ $s->youtube ?: 'https://youtube.com/@pwibanyuasin' }}" target="_blank" class="w-6 h-6 rounded-md bg-red-50 dark:bg-red-950/60 hover:bg-red-600 hover:text-white text-red-600 dark:text-red-400 flex items-center justify-center text-[10px] transition-colors" title="YouTube">
                                <i class="fa-brands fa-youtube"></i>
                            </a>
                        </div>
                        <span class="text-slate-400 text-[10px] font-bold">{{ $s->periode }}</span>
                    </div>
                </div>
            @empty
                <div class="col-span-4 text-center py-12 text-slate-400">
                    Data pengurus belum tersedia.
                </div>
            @endforelse
        </div>

    </div>
</div>
@endsection
