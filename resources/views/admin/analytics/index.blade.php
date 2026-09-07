@extends('layouts.admin')

@section('title', 'Statistik Pengunjung & Analitik Web')
@section('page_title', 'Statistik Pengunjung')

@section('content')
<div class="space-y-6">
    
    <!-- Header Section -->
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
        <div>
            <div class="inline-flex items-center gap-2 px-2.5 py-1 rounded-md bg-emerald-100 dark:bg-emerald-950/60 border border-emerald-200 dark:border-emerald-900/50 text-emerald-700 dark:text-emerald-400 text-[11px] font-bold tracking-wide uppercase mb-1">
                <span class="w-2 h-2 rounded-full bg-emerald-500 animate-pulse"></span>
                <span>Data Riil Aktif Dari Database</span>
            </div>
            <h2 class="text-xl font-extrabold text-[#0B132B] dark:text-white">Statistik Pengunjung & Tren Pembaca Portal</h2>
            <p class="text-xs text-slate-600 dark:text-slate-400 mt-1 font-medium">Metrik nyata lalu lintas website PWI Banyuasin, tren bacaan artikel, dan asal rujukan pengunjung</p>
        </div>
        <div class="flex items-center gap-2">
            <span class="text-xs text-slate-500 dark:text-slate-400 font-semibold">Online 15 Menit Terakhir:</span>
            <span class="px-3 py-1.5 rounded-xl bg-emerald-600 text-white font-extrabold text-xs shadow-sm flex items-center gap-1.5">
                <i class="fa-solid fa-users text-[10px]"></i>
                <span>{{ number_format($onlineVisitors) }} Online</span>
            </span>
        </div>
    </div>

    <!-- 4 Key Performance Metric Cards -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
        
        <!-- Total Hits / Pageviews -->
        <div class="p-5 rounded-2xl bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800 shadow-sm flex items-center justify-between">
            <div>
                <span class="text-[10px] font-bold text-slate-500 dark:text-slate-400 uppercase tracking-wider block mb-1">Total Tayangan Halaman</span>
                <div class="text-2xl font-black text-[#0B132B] dark:text-white">{{ number_format($totalPageviews) }}</div>
                <div class="text-[10px] text-blue-600 dark:text-blue-400 font-semibold mt-1">Akumulasi seluruh kunjungan</div>
            </div>
            <div class="w-12 h-12 rounded-2xl bg-blue-50 dark:bg-blue-950/60 text-blue-600 dark:text-blue-400 flex items-center justify-center text-lg">
                <i class="fa-solid fa-chart-simple"></i>
            </div>
        </div>

        <!-- Total Unique Visitors -->
        <div class="p-5 rounded-2xl bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800 shadow-sm flex items-center justify-between">
            <div>
                <span class="text-[10px] font-bold text-slate-500 dark:text-slate-400 uppercase tracking-wider block mb-1">Total Pengunjung Unik</span>
                <div class="text-2xl font-black text-[#0B132B] dark:text-white">{{ number_format($totalUniqueVisitors) }}</div>
                <div class="text-[10px] text-emerald-600 dark:text-emerald-400 font-semibold mt-1">Individu unik (berbasis sesi/IP)</div>
            </div>
            <div class="w-12 h-12 rounded-2xl bg-emerald-50 dark:bg-emerald-950/60 text-emerald-600 dark:text-emerald-400 flex items-center justify-center text-lg">
                <i class="fa-solid fa-users"></i>
            </div>
        </div>

        <!-- Today Visitors & Hits -->
        <div class="p-5 rounded-2xl bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800 shadow-sm flex items-center justify-between">
            <div>
                <span class="text-[10px] font-bold text-slate-500 dark:text-slate-400 uppercase tracking-wider block mb-1">Kunjungan Hari Ini</span>
                <div class="text-2xl font-black text-amber-600 dark:text-amber-400">{{ number_format($todayHits) }}</div>
                <div class="text-[10px] text-slate-500 dark:text-slate-400 font-semibold mt-1">
                    {{ number_format($todayVisitors) }} pengunjung unik hari ini
                </div>
            </div>
            <div class="w-12 h-12 rounded-2xl bg-amber-50 dark:bg-amber-950/60 text-amber-600 dark:text-amber-400 flex items-center justify-center text-lg">
                <i class="fa-solid fa-calendar-day"></i>
            </div>
        </div>

        <!-- Yesterday Visitors -->
        <div class="p-5 rounded-2xl bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800 shadow-sm flex items-center justify-between">
            <div>
                <span class="text-[10px] font-bold text-slate-500 dark:text-slate-400 uppercase tracking-wider block mb-1">Kunjungan Kemarin</span>
                <div class="text-2xl font-black text-purple-600 dark:text-purple-400">{{ number_format($yesterdayHits) }}</div>
                <div class="text-[10px] text-slate-500 dark:text-slate-400 font-semibold mt-1">
                    {{ number_format($yesterdayVisitors) }} pengunjung unik
                </div>
            </div>
            <div class="w-12 h-12 rounded-2xl bg-purple-50 dark:bg-purple-950/60 text-purple-600 dark:text-purple-400 flex items-center justify-center text-lg">
                <i class="fa-solid fa-clock-rotate-left"></i>
            </div>
        </div>

    </div>

    <!-- Daily Traffic & Reader Trends (14-Day Timeline Bar Chart) -->
    <div class="bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800 rounded-2xl p-6 shadow-sm">
        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-2 mb-6">
            <div>
                <h3 class="text-sm font-extrabold text-[#0B132B] dark:text-white flex items-center gap-2">
                    <i class="fa-solid fa-arrow-trend-up text-blue-600 dark:text-amber-400"></i>
                    <span>Tren Kunjungan & Pembaca (14 Hari Terakhir)</span>
                </h3>
                <p class="text-xs text-slate-500 dark:text-slate-400 mt-0.5">Grafik volume tayangan halaman harian portal PWI Banyuasin</p>
            </div>
            <div class="flex items-center gap-4 text-xs font-semibold">
                <div class="flex items-center gap-1.5 text-blue-600 dark:text-blue-400">
                    <span class="w-3 h-3 rounded bg-blue-600"></span>
                    <span>Tayangan (Hits)</span>
                </div>
                <div class="flex items-center gap-1.5 text-emerald-600 dark:text-emerald-400">
                    <span class="w-3 h-3 rounded bg-emerald-500"></span>
                    <span>Pengunjung Unik</span>
                </div>
            </div>
        </div>

        <!-- Custom Visual Bar Chart with Alpine Tooltip -->
        <div class="h-48 flex items-end gap-2 sm:gap-4 pt-8 border-b border-slate-200 dark:border-slate-800">
            @foreach($trends as $t)
                @php
                    $hitHeight = $maxDailyHits > 0 ? max(round(($t['hits'] / $maxDailyHits) * 100), $t['hits'] > 0 ? 8 : 2) : 2;
                    $visHeight = $maxDailyHits > 0 ? max(round(($t['visitors'] / $maxDailyHits) * 100), $t['visitors'] > 0 ? 6 : 2) : 2;
                @endphp
                <div class="flex-1 flex flex-col items-center h-full justify-end group relative cursor-pointer">
                    <!-- Tooltip Hover -->
                    <div class="opacity-0 group-hover:opacity-100 transition-opacity absolute -top-12 z-20 pointer-events-none bg-slate-900 text-white text-[10px] font-bold py-1 px-2 rounded-lg shadow-xl whitespace-nowrap border border-white/10 text-center">
                        <div>{{ $t['date'] }}</div>
                        <div class="text-blue-400">{{ $t['hits'] }} Hits / {{ $t['visitors'] }} Unik</div>
                    </div>

                    <!-- Bars Container -->
                    <div class="w-full flex items-end justify-center gap-0.5 sm:gap-1 h-full">
                        <!-- Hits Bar -->
                        <div class="w-1/2 rounded-t-md bg-blue-600 group-hover:bg-blue-500 transition-all duration-300" 
                             style="height: {{ $hitHeight }}%"></div>
                        <!-- Visitors Bar -->
                        <div class="w-1/2 rounded-t-md bg-emerald-500 group-hover:bg-emerald-400 transition-all duration-300" 
                             style="height: {{ $visHeight }}%"></div>
                    </div>
                </div>
            @endforeach
        </div>

        <!-- X-Axis Labels -->
        <div class="flex items-center gap-2 sm:gap-4 mt-2">
            @foreach($trends as $t)
                <div class="flex-1 text-center text-[10px] font-semibold text-slate-400 truncate">
                    {{ $t['label'] }}
                </div>
            @endforeach
        </div>
    </div>

    <!-- 2 Column Section: Popular News & Traffic Channels -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        
        <!-- Left: Most Read News & Top Pages -->
        <div class="space-y-6">
            
            <!-- Most Read Articles -->
            <div class="bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800 rounded-2xl p-6 shadow-sm">
                <h3 class="text-sm font-extrabold text-[#0B132B] dark:text-white flex items-center justify-between mb-4">
                    <span class="flex items-center gap-2">
                        <i class="fa-solid fa-newspaper text-rose-500"></i>
                        <span>Berita Paling Banyak Dibaca</span>
                    </span>
                    <a href="{{ route('admin.posts.index') }}" class="text-xs text-blue-600 hover:underline font-bold">Lihat Semua</a>
                </h3>

                <div class="divide-y divide-slate-100 dark:divide-slate-800">
                    @forelse($popularPosts as $index => $post)
                        <div class="py-3 flex items-center justify-between gap-4">
                            <div class="flex items-start gap-3 min-w-0">
                                <span class="w-6 h-6 rounded-full bg-slate-100 dark:bg-slate-800 text-slate-700 dark:text-slate-300 font-extrabold text-xs flex items-center justify-center shrink-0">
                                    {{ $index + 1 }}
                                </span>
                                <div class="min-w-0">
                                    <a href="{{ route('news.show', $post->slug) }}" target="_blank" class="text-xs font-bold text-slate-900 dark:text-white hover:text-blue-600 dark:hover:text-blue-400 truncate block">
                                        {{ $post->judul }}
                                    </a>
                                    <span class="text-[10px] text-slate-400 block mt-0.5">
                                        {{ $post->published_at ? $post->published_at->format('d M Y') : '-' }}
                                    </span>
                                </div>
                            </div>
                            <div class="shrink-0 text-right">
                                <span class="text-xs font-extrabold text-rose-600 dark:text-rose-400">
                                    {{ number_format($post->views_count) }}
                                </span>
                                <span class="text-[10px] text-slate-400 block">pembaca</span>
                            </div>
                        </div>
                    @empty
                        <div class="py-6 text-center text-xs text-slate-500">Belum ada berita terpublikasi.</div>
                    @endforelse
                </div>
            </div>

            <!-- Top Visited Pages -->
            <div class="bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800 rounded-2xl p-6 shadow-sm">
                <h3 class="text-sm font-extrabold text-[#0B132B] dark:text-white flex items-center gap-2 mb-4">
                    <i class="fa-solid fa-link text-blue-600"></i>
                    <span>Halaman Web Paling Sering Dikunjungi</span>
                </h3>

                <div class="space-y-2.5">
                    @forelse($topPages as $page)
                        @php
                            $percentage = $totalPageviews > 0 ? round(($page->total_views / $totalPageviews) * 100) : 0;
                        @endphp
                        <div>
                            <div class="flex items-center justify-between text-xs font-semibold mb-1">
                                <span class="text-slate-800 dark:text-slate-200 truncate pr-2">{{ $page->url == '/' ? '/ (Beranda Utama)' : $page->url }}</span>
                                <span class="text-slate-500 shrink-0">{{ number_format($page->total_views) }} tayangan ({{ $percentage }}%)</span>
                            </div>
                            <div class="w-full h-2 rounded-full bg-slate-100 dark:bg-slate-800 overflow-hidden">
                                <div class="h-full bg-blue-600 rounded-full" style="width: {{ $percentage }}%"></div>
                            </div>
                        </div>
                    @empty
                        <div class="py-4 text-center text-xs text-slate-500">Belum ada log halaman tercatat.</div>
                    @endforelse
                </div>
            </div>

        </div>

        <!-- Right: Referrers, Devices, Browsers -->
        <div class="space-y-6">
            
            <!-- Traffic Sources (Referrers) -->
            <div class="bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800 rounded-2xl p-6 shadow-sm">
                <h3 class="text-sm font-extrabold text-[#0B132B] dark:text-white flex items-center gap-2 mb-4">
                    <i class="fa-solid fa-compass text-amber-500"></i>
                    <span>Asal Lalu Lintas Pengunjung (Referrer)</span>
                </h3>

                <div class="divide-y divide-slate-100 dark:divide-slate-800">
                    @forelse($referrers as $ref)
                        @php
                            $refPct = $totalPageviews > 0 ? round(($ref->count / $totalPageviews) * 100) : 0;
                        @endphp
                        <div class="py-2.5 flex items-center justify-between gap-3 text-xs">
                            <div class="flex items-center gap-2.5 min-w-0">
                                @if(str_contains(strtolower($ref->referrer_domain), 'google'))
                                    <i class="fa-brands fa-google text-red-500 w-4"></i>
                                @elseif(str_contains(strtolower($ref->referrer_domain), 'facebook'))
                                    <i class="fa-brands fa-facebook text-blue-600 w-4"></i>
                                @elseif(str_contains(strtolower($ref->referrer_domain), 'instagram'))
                                    <i class="fa-brands fa-instagram text-pink-500 w-4"></i>
                                @elseif(str_contains(strtolower($ref->referrer_domain), 'whatsapp'))
                                    <i class="fa-brands fa-whatsapp text-emerald-500 w-4"></i>
                                @elseif(str_contains(strtolower($ref->referrer_domain), 'direct'))
                                    <i class="fa-solid fa-arrow-pointer text-slate-400 w-4"></i>
                                @else
                                    <i class="fa-solid fa-globe text-cyan-500 w-4"></i>
                                @endif
                                <span class="font-bold text-slate-900 dark:text-white truncate">{{ $ref->referrer_domain }}</span>
                                <span class="px-2 py-0.5 rounded text-[10px] font-semibold bg-slate-100 dark:bg-slate-800 text-slate-600 dark:text-slate-400">{{ $ref->referrer_type }}</span>
                            </div>
                            <div class="font-bold text-slate-700 dark:text-slate-300 shrink-0">
                                {{ number_format($ref->count) }} <span class="text-slate-400 font-normal">({{ $refPct }}%)</span>
                            </div>
                        </div>
                    @empty
                        <div class="py-4 text-center text-xs text-slate-500">Belum ada data referrer.</div>
                    @endforelse
                </div>
            </div>

            <!-- Devices & Platforms Breakdown -->
            <div class="bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800 rounded-2xl p-6 shadow-sm">
                <h3 class="text-sm font-extrabold text-[#0B132B] dark:text-white flex items-center gap-2 mb-4">
                    <i class="fa-solid fa-mobile-screen text-emerald-500"></i>
                    <span>Perangkat & Browser Pengunjung</span>
                </h3>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <!-- Device Types -->
                    <div class="p-3.5 rounded-xl bg-slate-50 dark:bg-slate-950/50 border border-slate-200 dark:border-slate-800 space-y-2">
                        <span class="text-[10px] font-bold text-slate-500 dark:text-slate-400 uppercase tracking-wider block">Tipe Perangkat</span>
                        @foreach($devices as $dev)
                            @php $devPct = $totalPageviews > 0 ? round(($dev->count / $totalPageviews) * 100) : 0; @endphp
                            <div class="flex items-center justify-between text-xs">
                                <span class="text-slate-700 dark:text-slate-300 font-semibold flex items-center gap-1.5">
                                    <i class="fa-solid {{ $dev->device_type === 'Mobile' ? 'fa-mobile' : ($dev->device_type === 'Tablet' ? 'fa-tablet' : 'fa-laptop') }} text-slate-400"></i>
                                    {{ $dev->device_type }}
                                </span>
                                <span class="font-extrabold text-slate-900 dark:text-white">{{ $devPct }}%</span>
                            </div>
                        @endforeach
                    </div>

                    <!-- Top Browsers -->
                    <div class="p-3.5 rounded-xl bg-slate-50 dark:bg-slate-950/50 border border-slate-200 dark:border-slate-800 space-y-2">
                        <span class="text-[10px] font-bold text-slate-500 dark:text-slate-400 uppercase tracking-wider block">Browser</span>
                        @foreach($browsers as $br)
                            @php $brPct = $totalPageviews > 0 ? round(($br->count / $totalPageviews) * 100) : 0; @endphp
                            <div class="flex items-center justify-between text-xs">
                                <span class="text-slate-700 dark:text-slate-300 font-semibold truncate pr-2">{{ $br->browser }}</span>
                                <span class="font-extrabold text-slate-900 dark:text-white shrink-0">{{ $brPct }}%</span>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>

        </div>

    </div>

    <!-- Live Visitor Feed (Recent 20 Genuine Logs) -->
    <div class="bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800 rounded-2xl shadow-sm overflow-hidden">
        <div class="p-5 border-b border-slate-200 dark:border-slate-800 flex items-center justify-between bg-slate-50/50 dark:bg-slate-900/50">
            <div>
                <h3 class="text-sm font-extrabold text-[#0B132B] dark:text-white flex items-center gap-2">
                    <span class="w-2 h-2 rounded-full bg-emerald-500 animate-ping"></span>
                    <span>Feed Kunjungan Terkini (Real-Time Live Logs)</span>
                </h3>
                <p class="text-xs text-slate-500 dark:text-slate-400 mt-0.5">20 aktivitas kunjungan riil terakhir di portal PWI Banyuasin</p>
            </div>
            <span class="text-xs text-slate-500 font-semibold">IP disamarkan untuk privasi</span>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-left text-xs text-slate-800 dark:text-slate-200 min-w-[700px]">
                <thead class="bg-[#0B132B] dark:bg-[#070D1E] text-white uppercase tracking-wider text-[11px] border-b border-blue-950">
                    <tr>
                        <th class="py-3 px-5 w-32 font-bold">WAKTU</th>
                        <th class="py-3 px-5 font-bold">HALAMAN / URL</th>
                        <th class="py-3 px-5 w-32 font-bold">IP PENGUNJUNG</th>
                        <th class="py-3 px-5 w-40 font-bold">RUJUKAN</th>
                        <th class="py-3 px-5 w-40 font-bold">PERANGKAT & BROWSER</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 dark:divide-slate-800">
                    @forelse($recentLogs as $log)
                        <tr class="hover:bg-slate-50 dark:hover:bg-white/[0.02] transition-colors">
                            <td class="py-3 px-5 text-slate-500 dark:text-slate-400 whitespace-nowrap">
                                {{ $log->created_at ? $log->created_at->diffForHumans() : '-' }}
                            </td>
                            <td class="py-3 px-5 font-bold text-slate-900 dark:text-white">
                                <span class="font-mono text-[11px] text-blue-600 dark:text-blue-400">{{ $log->url }}</span>
                            </td>
                            <td class="py-3 px-5 font-mono text-[11px] text-slate-600 dark:text-slate-400">
                                {{ $log->masked_ip }}
                            </td>
                            <td class="py-3 px-5 text-slate-700 dark:text-slate-300">
                                <span class="truncate block max-w-[140px]" title="{{ $log->referrer }}">
                                    {{ $log->referrer_domain }}
                                </span>
                            </td>
                            <td class="py-3 px-5 text-slate-700 dark:text-slate-300 whitespace-nowrap">
                                <span class="font-semibold">{{ $log->device_type }}</span>
                                <span class="text-slate-400 text-[10px] block">{{ $log->browser }} ({{ $log->platform }})</span>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="py-8 text-center text-slate-500 text-xs">Belum ada riwayat kunjungan.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

</div>
@endsection
