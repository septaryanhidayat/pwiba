@extends('layouts.admin')

@section('title', 'Notulen Rapat & Absensi Kehadiran')
@section('page_title', 'Notulen Rapat & Absensi')

@section('content')
<div class="space-y-6">
    
    <!-- Header -->
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
        <div>
            <h2 class="text-xl font-extrabold text-white">Notulen Rapat & Daftar Hadir Anggota</h2>
            <p class="text-xs text-slate-400 mt-1">Pencatatan resmi hasil musyawarah, rapat kerja, dan checklist kehadiran pengurus</p>
        </div>
        <a href="{{ route('admin.meetings.create') }}" class="inline-flex items-center gap-2 px-4 py-2.5 rounded-xl text-xs font-bold text-slate-950 bg-emerald-400 hover:bg-emerald-300 shadow-lg shadow-emerald-400/20 transition-all">
            <i class="fa-solid fa-plus"></i>
            <span>+ Catat Notulen Rapat Baru</span>
        </a>
    </div>

    <!-- Table Container -->
    <div class="bg-slate-900 border border-slate-800 rounded-3xl shadow-xl overflow-hidden">
        
        <!-- Table Filter Bar -->
        <div class="p-6 border-b border-slate-800 flex flex-col sm:flex-row sm:items-center justify-between gap-4">
            <div class="flex items-center gap-2">
                <span class="text-xs text-slate-400">Tampilkan</span>
                <form action="{{ route('admin.meetings.index') }}" method="GET">
                    @if(request('search')) <input type="hidden" name="search" value="{{ request('search') }}"> @endif
                    <select name="entries" onchange="this.form.submit()" class="px-3 py-1.5 rounded-xl bg-slate-950 border border-slate-800 text-xs text-slate-200 outline-none">
                        <option value="10" {{ request('entries') == 10 ? 'selected' : '' }}>10</option>
                        <option value="25" {{ request('entries') == 25 ? 'selected' : '' }}>25</option>
                        <option value="50" {{ request('entries') == 50 ? 'selected' : '' }}>50</option>
                    </select>
                </form>
                <span class="text-xs text-slate-400">rapat</span>
            </div>

            <form action="{{ route('admin.meetings.index') }}" method="GET" class="w-full sm:w-72">
                @if(request('entries')) <input type="hidden" name="entries" value="{{ request('entries') }}"> @endif
                <div class="relative">
                    <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari judul / agenda / tempat..." class="w-full pl-9 pr-4 py-2 rounded-xl bg-slate-950 border border-slate-800 text-xs text-slate-200 focus:ring-2 focus:ring-amber-500 focus:border-amber-500 outline-none">
                    <i class="fa-solid fa-magnifying-glass absolute left-3 top-3 text-slate-500 text-xs"></i>
                </div>
            </form>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-left text-xs text-slate-300">
                <thead class="bg-slate-950/70 text-slate-400 uppercase tracking-wider text-[11px] border-b border-slate-800">
                    <tr>
                        <th class="py-3.5 px-6 text-center w-16">NO</th>
                        <th class="py-3.5 px-6">TANGGAL & WAKTU</th>
                        <th class="py-3.5 px-6">JUDUL & TEMPAT RAPAT</th>
                        <th class="py-3.5 px-6">PEMIMPIN & NOTULIS</th>
                        <th class="py-3.5 px-6 text-center">KEHADIRAN</th>
                        <th class="py-3.5 px-6 text-center w-48">AKSI</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-800/60">
                    @forelse($meetings as $index => $item)
                        <tr class="hover:bg-white/[0.02] transition-colors">
                            <td class="py-4 px-6 text-center font-bold text-slate-500">{{ $meetings->firstItem() + $index }}</td>
                            <td class="py-4 px-6">
                                <div class="font-bold text-white">{{ $item->tanggal ? $item->tanggal->translatedFormat('d M Y') : '-' }}</div>
                                <div class="text-[11px] text-slate-400">{{ $item->waktu_mulai ? substr($item->waktu_mulai, 0, 5) : '09:00' }} WIB</div>
                            </td>
                            <td class="py-4 px-6">
                                <div class="font-bold text-white text-sm leading-snug">{{ $item->judul_rapat }}</div>
                                <div class="text-[11px] text-amber-400 mt-0.5 flex items-center gap-1.5">
                                    <i class="fa-solid fa-location-dot text-[10px]"></i>
                                    <span>{{ $item->tempat }}</span>
                                </div>
                            </td>
                            <td class="py-4 px-6">
                                <div class="text-slate-300 font-semibold">P: {{ $item->pemimpin_rapat }}</div>
                                <div class="text-slate-400 text-[11px]">N: {{ $item->notulis }}</div>
                            </td>
                            <td class="py-4 px-6 text-center">
                                <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-xl text-xs font-bold bg-emerald-500/10 text-emerald-400 border border-emerald-500/20">
                                    <i class="fa-solid fa-users text-[10px]"></i>
                                    <span>{{ $item->attendances_count }} Anggota</span>
                                </span>
                            </td>
                            <td class="py-4 px-6 text-center">
                                <div class="flex items-center justify-center gap-2">
                                    <a href="{{ route('admin.meetings.print', $item->id) }}" target="_blank" class="p-2 rounded-lg bg-sky-500/10 hover:bg-sky-500 text-sky-400 hover:text-white border border-sky-500/20 transition-all" title="Cetak Lembar Notulen & Absensi">
                                        <i class="fa-solid fa-print"></i>
                                    </a>
                                    <a href="{{ route('admin.meetings.edit', $item->id) }}" class="p-2 rounded-lg bg-amber-500/10 hover:bg-amber-500 text-amber-400 hover:text-slate-950 border border-amber-500/20 transition-all" title="Edit Notulen">
                                        <i class="fa-solid fa-pen-to-square"></i>
                                    </a>
                                    <form action="{{ route('admin.meetings.destroy', $item->id) }}" method="POST" onsubmit="return confirm('Hapus notulen rapat ini?')" class="inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="p-2 rounded-lg bg-rose-500/10 hover:bg-rose-500 text-rose-400 hover:text-white border border-rose-500/20 transition-all" title="Hapus">
                                            <i class="fa-solid fa-trash"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="py-12 text-center text-slate-500">
                                Belum ada notulen rapat yang dicatat.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="p-6 border-t border-slate-800 flex flex-col sm:flex-row items-center justify-between text-xs text-slate-400 gap-4">
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
