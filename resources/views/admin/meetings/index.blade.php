@extends('layouts.admin')

@section('title', 'Notulen Rapat & Absensi Kehadiran')
@section('page_title', 'Notulen Rapat & Absensi')

@section('content')
<div class="space-y-6">
    
    <!-- Header -->
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
        <div>
            <h2 class="text-xl font-extrabold text-[#0B132B] dark:text-white">Notulen Rapat & Daftar Hadir Anggota</h2>
            <p class="text-xs text-slate-600 dark:text-slate-400 mt-1 font-medium">Pencatatan resmi hasil musyawarah, rapat kerja, dan checklist kehadiran pengurus</p>
        </div>
        <a href="{{ route('admin.meetings.create') }}" class="inline-flex items-center gap-2 px-4 py-2.5 rounded-xl text-xs font-bold text-white bg-blue-600 hover:bg-blue-700 dark:bg-emerald-500 dark:hover:bg-emerald-400 dark:text-slate-950 shadow-sm transition-all">
            <i class="fa-solid fa-plus"></i>
            <span>+ Catat Notulen Rapat Baru</span>
        </a>
    </div>

    <!-- Table Container (Clean White Background Card) -->
    <div class="bg-white dark:bg-slate-900 border border-slate-300 dark:border-slate-800 rounded-2xl shadow-sm overflow-hidden">
        
        <!-- Table Filter Bar -->
        <div class="p-6 border-b border-slate-200 dark:border-slate-800 flex flex-col sm:flex-row sm:items-center justify-between gap-4 bg-slate-50/50 dark:bg-slate-900/50">
            <div class="flex items-center gap-2">
                <span class="text-xs font-semibold text-slate-700 dark:text-slate-300">Tampilkan</span>
                <form action="{{ route('admin.meetings.index') }}" method="GET">
                    @if(request('search')) <input type="hidden" name="search" value="{{ request('search') }}"> @endif
                    <select name="entries" onchange="this.form.submit()" class="px-3 py-1.5 rounded-xl bg-white dark:bg-slate-950 border border-slate-300 dark:border-slate-700 text-xs font-semibold text-slate-900 dark:text-slate-200 outline-none shadow-sm">
                        <option value="10" {{ request('entries') == 10 ? 'selected' : '' }}>10</option>
                        <option value="25" {{ request('entries') == 25 ? 'selected' : '' }}>25</option>
                        <option value="50" {{ request('entries') == 50 ? 'selected' : '' }}>50</option>
                    </select>
                </form>
                <span class="text-xs font-semibold text-slate-700 dark:text-slate-300">rapat</span>
            </div>

            <form action="{{ route('admin.meetings.index') }}" method="GET" class="w-full sm:w-72">
                @if(request('entries')) <input type="hidden" name="entries" value="{{ request('entries') }}"> @endif
                <div class="relative">
                    <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari judul / agenda / tempat..." class="w-full pl-9 pr-4 py-2 rounded-xl bg-white dark:bg-slate-950 border border-slate-300 dark:border-slate-700 text-xs font-medium text-slate-900 dark:text-slate-200 focus:ring-2 focus:ring-blue-600 outline-none shadow-sm">
                    <i class="fa-solid fa-magnifying-glass absolute left-3 top-3 text-slate-400 text-xs"></i>
                </div>
            </form>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-left text-xs text-slate-800 dark:text-slate-200">
                <thead class="bg-[#0B132B] dark:bg-[#070D1E] text-white uppercase tracking-wider text-[11px] border-b border-blue-950">
                    <tr>
                        <th class="py-3.5 px-6 text-center w-16 font-bold">NO</th>
                        <th class="py-3.5 px-6 font-bold">TANGGAL & WAKTU</th>
                        <th class="py-3.5 px-6 font-bold">JUDUL & TEMPAT RAPAT</th>
                        <th class="py-3.5 px-6 font-bold">PEMIMPIN & NOTULIS</th>
                        <th class="py-3.5 px-6 text-center font-bold">KEHADIRAN</th>
                        <th class="py-3.5 px-6 text-center w-48 font-bold">AKSI</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-200 dark:divide-slate-800">
                    @forelse($meetings as $index => $item)
                        <tr class="hover:bg-slate-50 dark:hover:bg-white/[0.02] transition-colors">
                            <td class="py-4 px-6 text-center font-bold text-slate-500 dark:text-slate-400">{{ $meetings->firstItem() + $index }}</td>
                            <td class="py-4 px-6">
                                <div class="font-bold text-slate-900 dark:text-white">{{ $item->tanggal ? $item->tanggal->translatedFormat('d M Y') : '-' }}</div>
                                <div class="text-[11px] text-slate-600 dark:text-slate-400 font-medium">{{ $item->waktu_mulai ? substr($item->waktu_mulai, 0, 5) : '09:00' }} WIB</div>
                            </td>
                            <td class="py-4 px-6">
                                <div class="font-bold text-slate-900 dark:text-white text-sm leading-snug">{{ $item->judul_rapat }}</div>
                                <div class="text-[11px] text-amber-700 dark:text-amber-400 font-semibold mt-0.5 flex items-center gap-1.5">
                                    <i class="fa-solid fa-location-dot text-[10px]"></i>
                                    <span>{{ $item->tempat }}</span>
                                </div>
                            </td>
                            <td class="py-4 px-6">
                                <div class="text-slate-900 dark:text-slate-200 font-bold">P: {{ $item->pemimpin_rapat }}</div>
                                <div class="text-slate-600 dark:text-slate-400 text-[11px] font-medium">N: {{ $item->notulis }}</div>
                            </td>
                            <td class="py-4 px-6 text-center">
                                <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-xl text-xs font-bold bg-emerald-50 text-emerald-700 border border-emerald-200 dark:bg-emerald-950/60 dark:text-emerald-400 dark:border-emerald-800">
                                    <i class="fa-solid fa-users text-[10px]"></i>
                                    <span>{{ $item->attendances_count }} Anggota</span>
                                </span>
                            </td>
                            <td class="py-4 px-6 text-center">
                                <div class="flex items-center justify-center gap-2">
                                    <a href="{{ route('admin.meetings.print', $item->id) }}" target="_blank" class="p-1.5 rounded-lg bg-sky-500 hover:bg-sky-600 text-white shadow-sm transition-all" title="Cetak Lembar Notulen & Absensi">
                                        <i class="fa-solid fa-print text-xs"></i>
                                    </a>
                                    <a href="{{ route('admin.meetings.edit', $item->id) }}" class="p-1.5 rounded-lg bg-amber-500 hover:bg-amber-400 text-slate-950 font-bold shadow-sm transition-all" title="Edit Notulen">
                                        <i class="fa-solid fa-pen-to-square text-xs"></i>
                                    </a>
                                    <form action="{{ route('admin.meetings.destroy', $item->id) }}" method="POST" onsubmit="return confirm('Hapus notulen rapat ini?')" class="inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="p-1.5 rounded-lg bg-rose-600 hover:bg-rose-700 text-white shadow-sm transition-all" title="Hapus">
                                            <i class="fa-solid fa-trash text-xs"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="py-12 text-center text-slate-500 dark:text-slate-400 font-medium">
                                Belum ada notulen rapat yang dicatat.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="p-6 border-t border-slate-200 dark:border-slate-800 flex flex-col sm:flex-row items-center justify-between text-xs text-slate-600 dark:text-slate-400 gap-4 bg-slate-50/50 dark:bg-slate-900/50">
            <div>
                Menampilkan {{ $meetings->firstItem() ?? 0 }} s/d {{ $meetings->lastItem() ?? 0 }} dari {{ $meetings->total() }} rapat
            </div>
            <div>
                {{ $meetings->withQueryString()->links() }}
            </div>
        </div>

    </div>

</div>
@endsection
