@extends('layouts.public')

@section('title', 'Ketua PWI Banyuasin Dari Masa ke Masa')
@section('meta_description', 'Rekam jejak kepemimpinan Ketua Persatuan Wartawan Indonesia (PWI) Kabupaten Banyuasin dari masa ke masa dalam mengawal kemerdekaan pers dan integritas jurnalisme.')

@section('content')
<div class="py-12 md:py-16 bg-slate-50 dark:bg-slate-950 min-h-screen" x-data="{ selectedPhoto: null, selectedName: '', selectedPeriod: '', selectedTitle: '', selectedDesc: '' }">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-12">
        
        <!-- Header Banner (Mobile Centered) -->
        <div class="text-center max-w-3xl mx-auto space-y-4">
            <div class="inline-flex items-center gap-2 px-4 py-1.5 rounded-full bg-blue-50 dark:bg-blue-950/60 border border-blue-200 dark:border-blue-800 text-blue-700 dark:text-amber-400 text-xs font-extrabold uppercase tracking-widest shadow-sm">
                <i class="fa-solid fa-award"></i>
                <span>Sejarah & Kepemimpinan</span>
            </div>
            <h1 class="text-3xl sm:text-4xl md:text-5xl font-black text-slate-900 dark:text-white tracking-tight leading-tight">
                Ketua PWI Kabupaten Banyuasin <br class="hidden sm:inline">
                <span class="text-transparent bg-clip-text bg-gradient-to-r from-blue-700 via-blue-600 to-amber-500 dark:from-amber-400 dark:to-amber-200">
                    Dari Masa ke Masa
                </span>
            </h1>
            <p class="text-sm md:text-base text-slate-600 dark:text-slate-300 font-medium leading-relaxed">
                Menapaki rekam jejak kepemimpinan Persatuan Wartawan Indonesia (PWI) Kabupaten Banyuasin sejak awal berdirinya dalam mengawal kemerdekaan pers, etika jurnalistik, dan kemitraan strategis pembangunan daerah.
            </p>
        </div>

        <!-- Leaders Grid (Proporsional, Tanpa Tulisan di Foto, Teks Bersih di Bawah) -->
        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-5 gap-6 sm:gap-8">
            @foreach($leaders as $index => $leader)
                <div class="group relative bg-white dark:bg-slate-900 rounded-3xl border border-slate-200 dark:border-slate-800 p-4 shadow-sm hover:shadow-xl transition-all duration-300 flex flex-col justify-between hover:-translate-y-1.5">
                    
                    <!-- Top Badge: Urutan / Status -->
                    <div class="flex items-center justify-between gap-2 mb-3">
                        <span class="inline-flex items-center justify-center w-7 h-7 rounded-xl bg-slate-100 dark:bg-slate-800 text-slate-700 dark:text-slate-300 font-extrabold text-xs">
                            #{{ $leader->urutan }}
                        </span>
                        @if($leader->status_aktif)
                            <span class="inline-flex items-center gap-1.5 px-2.5 py-0.5 rounded-full text-[10px] font-extrabold bg-emerald-100 text-emerald-800 dark:bg-emerald-950/80 dark:text-emerald-300 border border-emerald-300 dark:border-emerald-800">
                                <span class="w-1.5 h-1.5 rounded-full bg-emerald-500 animate-ping"></span>
                                Petahana
                            </span>
                        @else
                            <span class="text-[10px] font-bold text-slate-500 dark:text-slate-400">
                                Demisioner
                            </span>
                        @endif
                    </div>

                    <!-- Proportional Portrait Photo (Clean without text) -->
                    <div class="relative w-full aspect-[4/5] rounded-2xl overflow-hidden bg-gradient-to-b from-red-800 to-red-950 cursor-pointer shadow-inner group-hover:ring-2 ring-blue-600 dark:ring-amber-400 transition-all"
                         @click="selectedPhoto = '{{ $leader->foto_url }}'; selectedName = '{{ $leader->nama }}'; selectedPeriod = 'Periode {{ $leader->periode }}'; selectedTitle = '{{ $leader->jabatan }}'; selectedDesc = '{{ $leader->keterangan ?? '' }}'">
                        
                        <img src="{{ $leader->foto_url }}" 
                             alt="{{ $leader->nama }}" 
                             class="w-full h-full object-cover object-top group-hover:scale-105 transition-transform duration-500"
                             loading="lazy">
                        
                        <!-- Overlay Zoom Icon -->
                        <div class="absolute inset-0 bg-slate-950/20 opacity-0 group-hover:opacity-100 transition-opacity flex items-center justify-center">
                            <span class="w-10 h-10 rounded-full bg-white/80 dark:bg-slate-900/80 text-slate-900 dark:text-white flex items-center justify-center shadow-lg backdrop-blur-sm">
                                <i class="fa-solid fa-magnifying-glass-plus text-sm"></i>
                            </span>
                        </div>
                    </div>

                    <!-- Clean Typography Below Photo -->
                    <div class="pt-4 text-center space-y-2 flex-grow flex flex-col justify-between">
                        <div>
                            <!-- Period Badge -->
                            <div class="inline-block px-3 py-1 rounded-full text-xs font-black tracking-wide {{ $leader->status_aktif ? 'bg-blue-600 text-white shadow-sm shadow-blue-500/30' : 'bg-slate-100 dark:bg-slate-800 text-slate-800 dark:text-amber-400 border border-slate-200 dark:border-slate-700' }}">
                                {{ $leader->periode }}
                            </div>

                            <!-- Full Name & Degrees -->
                            <h3 class="text-base md:text-lg font-black text-slate-900 dark:text-white mt-2 leading-snug">
                                {{ $leader->nama }}
                            </h3>

                            <!-- Title -->
                            <p class="text-xs font-semibold text-blue-700 dark:text-slate-300 mt-0.5">
                                {{ $leader->jabatan }}
                            </p>
                        </div>

                        @if($leader->keterangan)
                            <div class="pt-2 border-t border-slate-100 dark:border-slate-800/80">
                                <p class="text-[11px] text-slate-500 dark:text-slate-400 italic line-clamp-2">
                                    "{{ $leader->keterangan }}"
                                </p>
                            </div>
                        @endif
                    </div>

                </div>
            @endforeach
        </div>

        <!-- Table Summary Card (Clean & Responsive) -->
        <div class="bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800 rounded-3xl p-6 sm:p-8 shadow-sm">
            <div class="max-w-2xl mx-auto text-center space-y-2 mb-6">
                <h3 class="text-lg font-bold text-slate-900 dark:text-white">
                    Tabel Kronologi Kepemimpinan PWI Kabupaten Banyuasin
                </h3>
                <p class="text-xs text-slate-500 dark:text-slate-400">
                    Daftar resmi masa bakti Ketua PWI Kabupaten Banyuasin sejak tahun 2014 hingga sekarang.
                </p>
            </div>

            <div class="overflow-x-auto">
                <table class="w-full text-left text-xs text-slate-800 dark:text-slate-200">
                    <thead class="bg-slate-100 dark:bg-slate-800 text-slate-900 dark:text-white uppercase tracking-wider text-[11px] font-bold">
                        <tr>
                            <th class="py-3 px-4 text-center w-16">NO</th>
                            <th class="py-3 px-4">NAMA KETUA</th>
                            <th class="py-3 px-4">JABATAN</th>
                            <th class="py-3 px-4 text-center">PERIODE</th>
                            <th class="py-3 px-4 text-center">STATUS</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100 dark:divide-slate-800 font-medium">
                        @foreach($leaders as $l)
                            <tr class="hover:bg-slate-50 dark:hover:bg-white/[0.02] transition-colors">
                                <td class="py-3 px-4 text-center font-bold text-slate-500 dark:text-slate-400">{{ $l->urutan }}</td>
                                <td class="py-3 px-4 font-extrabold text-slate-900 dark:text-white">{{ $l->nama }}</td>
                                <td class="py-3 px-4 text-slate-600 dark:text-slate-300">{{ $l->jabatan }}</td>
                                <td class="py-3 px-4 text-center">
                                    <span class="inline-block px-2.5 py-0.5 rounded-full font-bold text-xs bg-slate-100 dark:bg-slate-800 text-slate-800 dark:text-slate-200">
                                        {{ $l->periode }}
                                    </span>
                                </td>
                                <td class="py-3 px-4 text-center">
                                    @if($l->status_aktif)
                                        <span class="px-2.5 py-0.5 rounded-full text-[11px] font-bold bg-emerald-100 text-emerald-800 dark:bg-emerald-950/60 dark:text-emerald-400">
                                            Aktif
                                        </span>
                                    @else
                                        <span class="px-2.5 py-0.5 rounded-full text-[11px] font-medium bg-slate-100 text-slate-500 dark:bg-slate-800 dark:text-slate-400">
                                            Demisioner
                                        </span>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Lightbox Modal -->
        <div x-show="selectedPhoto" x-cloak @click.away="selectedPhoto = null" class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-slate-950/90 backdrop-blur-md">
            <div class="relative max-w-md w-full bg-slate-900 rounded-3xl overflow-hidden border border-white/10 shadow-2xl animate-in fade-in zoom-in-95 duration-200">
                <button @click="selectedPhoto = null" class="absolute top-4 right-4 z-20 w-10 h-10 rounded-full bg-black/60 text-white hover:bg-black flex items-center justify-center cursor-pointer transition-colors">
                    <i class="fa-solid fa-xmark text-lg"></i>
                </button>
                <div class="w-full bg-slate-950 flex items-center justify-center p-4">
                    <img :src="selectedPhoto" :alt="selectedName" class="max-h-[70vh] w-auto object-contain rounded-2xl shadow-2xl">
                </div>
                <div class="p-6 bg-slate-900 border-t border-white/10 text-center space-y-1">
                    <span class="inline-block px-3 py-1 rounded-full text-xs font-bold bg-amber-400 text-slate-950" x-text="selectedPeriod"></span>
                    <h3 class="text-xl font-black text-white pt-2" x-text="selectedName"></h3>
                    <p class="text-xs font-semibold text-slate-300" x-text="selectedTitle"></p>
                    <p class="text-xs text-slate-400 pt-2 italic" x-show="selectedDesc" x-text="selectedDesc"></p>
                </div>
            </div>
        </div>

    </div>
</div>
@endsection
