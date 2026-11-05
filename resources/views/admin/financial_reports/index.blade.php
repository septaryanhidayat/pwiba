@extends('layouts.admin')

@section('title', 'Laporan Keuangan Kegiatan PWI')
@section('page_title', 'Laporan Keuangan Kegiatan')

@section('content')
<div class="space-y-6">
    
    <!-- Header -->
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
        <div>
            <h2 class="text-xl font-extrabold text-[#0B132B] dark:text-white">Laporan Keuangan Kegiatan PWI Banyuasin</h2>
            <p class="text-xs text-slate-600 dark:text-slate-400 mt-1 font-medium">Pencatatan pembukuan arus kas masuk (penerimaan) dan kas keluar (pengeluaran) per kegiatan resmi</p>
        </div>
        <a href="{{ route('admin.financial-reports.create') }}" class="inline-flex items-center gap-2 px-4 py-2.5 rounded-xl text-xs font-bold text-white bg-blue-600 hover:bg-blue-700 dark:bg-emerald-500 dark:hover:bg-emerald-400 dark:text-slate-950 shadow-sm transition-all">
            <i class="fa-solid fa-plus"></i>
            <span>+ Buat Laporan Keuangan Baru</span>
        </a>
    </div>

    <!-- Stat Cards Summary -->
    <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
        <div class="p-5 rounded-2xl bg-white dark:bg-slate-900 border border-slate-300 dark:border-slate-800 shadow-sm flex items-center gap-4">
            <div class="w-12 h-12 rounded-xl bg-emerald-50 dark:bg-emerald-950/60 border border-emerald-200 dark:border-emerald-800 text-emerald-600 dark:text-emerald-400 flex items-center justify-center text-lg">
                <i class="fa-solid fa-arrow-down-long"></i>
            </div>
            <div>
                <div class="text-[11px] font-bold uppercase tracking-wider text-slate-500 dark:text-slate-400">Total Kas Masuk</div>
                <div class="text-lg font-black text-slate-900 dark:text-white mt-0.5">Rp {{ number_format($totalKasMasuk, 0, ',', '.') }}</div>
            </div>
        </div>

        <div class="p-5 rounded-2xl bg-white dark:bg-slate-900 border border-slate-300 dark:border-slate-800 shadow-sm flex items-center gap-4">
            <div class="w-12 h-12 rounded-xl bg-rose-50 dark:bg-rose-950/60 border border-rose-200 dark:border-rose-800 text-rose-600 dark:text-rose-400 flex items-center justify-center text-lg">
                <i class="fa-solid fa-arrow-up-long"></i>
            </div>
            <div>
                <div class="text-[11px] font-bold uppercase tracking-wider text-slate-500 dark:text-slate-400">Total Kas Keluar</div>
                <div class="text-lg font-black text-slate-900 dark:text-white mt-0.5">Rp {{ number_format($totalKasKeluar, 0, ',', '.') }}</div>
            </div>
        </div>

        <div class="p-5 rounded-2xl bg-white dark:bg-slate-900 border border-slate-300 dark:border-slate-800 shadow-sm flex items-center gap-4">
            <div class="w-12 h-12 rounded-xl bg-blue-50 dark:bg-blue-950/60 border border-blue-200 dark:border-blue-800 text-blue-600 dark:text-blue-400 flex items-center justify-center text-lg">
                <i class="fa-solid fa-scale-balanced"></i>
            </div>
            <div>
                <div class="text-[11px] font-bold uppercase tracking-wider text-slate-500 dark:text-slate-400">Saldo Akhir Akumulasi</div>
                <div class="text-lg font-black {{ $totalSaldoAkumulasi >= 0 ? 'text-blue-700 dark:text-blue-400' : 'text-rose-600 dark:text-rose-400' }} mt-0.5">
                    Rp {{ number_format($totalSaldoAkumulasi, 0, ',', '.') }}
                </div>
            </div>
        </div>
    </div>

    <!-- Table Container -->
    <div class="bg-white dark:bg-slate-900 border border-slate-300 dark:border-slate-800 rounded-2xl shadow-sm overflow-hidden">
        
        <!-- Filter Bar -->
        <div class="p-6 border-b border-slate-200 dark:border-slate-800 flex flex-col sm:flex-row sm:items-center justify-between gap-4 bg-slate-50/50 dark:bg-slate-900/50">
            <div class="flex items-center gap-2">
                <span class="text-xs font-semibold text-slate-700 dark:text-slate-300">Tampilkan</span>
                <form action="{{ route('admin.financial-reports.index') }}" method="GET">
                    @if(request('search')) <input type="hidden" name="search" value="{{ request('search') }}"> @endif
                    <select name="entries" onchange="this.form.submit()" class="px-3 py-1.5 rounded-xl bg-white dark:bg-slate-950 border border-slate-300 dark:border-slate-700 text-xs font-semibold text-slate-900 dark:text-slate-200 outline-none shadow-sm">
                        <option value="10" {{ request('entries') == 10 ? 'selected' : '' }}>10</option>
                        <option value="25" {{ request('entries') == 25 ? 'selected' : '' }}>25</option>
                        <option value="50" {{ request('entries') == 50 ? 'selected' : '' }}>50</option>
                    </select>
                </form>
                <span class="text-xs font-semibold text-slate-700 dark:text-slate-300">laporan</span>
            </div>

            <form action="{{ route('admin.financial-reports.index') }}" method="GET" class="w-full sm:w-80">
                @if(request('entries')) <input type="hidden" name="entries" value="{{ request('entries') }}"> @endif
                <div class="relative">
                    <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari nama kegiatan / tanggal..." class="w-full pl-9 pr-4 py-2 rounded-xl bg-white dark:bg-slate-950 border border-slate-300 dark:border-slate-700 text-xs font-medium text-slate-900 dark:text-slate-200 focus:ring-2 focus:ring-blue-600 outline-none shadow-sm">
                    <i class="fa-solid fa-magnifying-glass absolute left-3 top-3 text-slate-400 text-xs"></i>
                </div>
            </form>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-left text-xs text-slate-800 dark:text-slate-200 min-w-[750px]">
                <thead class="bg-[#0B132B] dark:bg-[#070D1E] text-white uppercase tracking-wider text-[11px] border-b border-blue-950">
                    <tr>
                        <th class="py-3.5 px-6 text-center w-16 font-bold">NO</th>
                        <th class="py-3.5 px-6 font-bold">KEGIATAN & PERIODE</th>
                        <th class="py-3.5 px-6 text-right font-bold text-emerald-400">PENERIMAAN</th>
                        <th class="py-3.5 px-6 text-right font-bold text-rose-400">PENGELUARAN</th>
                        <th class="py-3.5 px-6 text-right font-bold text-cyan-300">SALDO</th>
                        <th class="py-3.5 px-6 font-bold">PENANGGUNG JAWAB</th>
                        <th class="py-3.5 px-6 text-center w-40 font-bold">AKSI</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-200 dark:divide-slate-800">
                    @forelse($reports as $index => $item)
                        <tr class="hover:bg-slate-50 dark:hover:bg-white/[0.02] transition-colors">
                            <td class="py-4 px-6 text-center font-bold text-slate-500 dark:text-slate-400">{{ $reports->firstItem() + $index }}</td>
                            <td class="py-4 px-6">
                                <div class="font-bold text-slate-900 dark:text-white text-sm leading-snug">{{ $item->judul_kegiatan }}</div>
                                @if($item->lanjutan_nama_kegiatan)
                                    <div class="text-[11px] text-slate-600 dark:text-slate-300 font-semibold mt-0.5">{{ $item->lanjutan_nama_kegiatan }}</div>
                                @endif
                                <div class="text-[11px] text-amber-700 dark:text-amber-400 font-medium mt-1 flex items-center gap-1.5">
                                    <i class="fa-solid fa-calendar-days text-[10px]"></i>
                                    <span>{{ $item->hari_tanggal ?: 'Belum ditentukan' }}</span>
                                </div>
                            </td>
                            <td class="py-4 px-6 text-right font-bold text-emerald-600 dark:text-emerald-400">
                                Rp {{ number_format($item->total_penerimaan, 0, ',', '.') }}
                            </td>
                            <td class="py-4 px-6 text-right font-bold text-rose-600 dark:text-rose-400">
                                Rp {{ number_format($item->total_pengeluaran, 0, ',', '.') }}
                            </td>
                            <td class="py-4 px-6 text-right">
                                <span class="font-extrabold {{ $item->saldo >= 0 ? 'text-blue-700 dark:text-cyan-400' : 'text-rose-600 dark:text-rose-400' }}">
                                    Rp {{ number_format($item->saldo, 0, ',', '.') }}
                                </span>
                            </td>
                            <td class="py-4 px-6">
                                <div class="text-slate-900 dark:text-slate-200 font-semibold text-[11px]">Ketua: {{ $item->nama_mengetahui }}</div>
                                <div class="text-slate-600 dark:text-slate-400 text-[11px]">Bendahara: {{ $item->nama_bendahara }}</div>
                            </td>
                            <td class="py-4 px-6 text-center">
                                <div class="flex items-center justify-center gap-2">
                                    <a href="{{ route('admin.financial-reports.print', $item->id) }}" target="_blank" class="p-1.5 rounded-lg bg-sky-500 hover:bg-sky-600 text-white shadow-sm transition-all" title="Cetak Lembar Laporan Keuangan (A4 Landscape)">
                                        <i class="fa-solid fa-print text-xs"></i>
                                    </a>
                                    <a href="{{ route('admin.financial-reports.edit', $item->id) }}" class="p-1.5 rounded-lg bg-amber-500 hover:bg-amber-400 text-slate-950 font-bold shadow-sm transition-all" title="Edit Laporan Keuangan">
                                        <i class="fa-solid fa-pen-to-square text-xs"></i>
                                    </a>
                                    <form action="{{ route('admin.financial-reports.destroy', $item->id) }}" method="POST" onsubmit="return confirm('Hapus laporan keuangan ini? Seluruh data penerimaan dan pengeluaran akan terhapus.')" class="inline">
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
                            <td colspan="7" class="py-12 text-center text-slate-500 dark:text-slate-400">
                                <div class="w-12 h-12 rounded-full bg-slate-100 dark:bg-slate-800 text-slate-400 flex items-center justify-center mx-auto mb-3 text-lg">
                                    <i class="fa-solid fa-receipt"></i>
                                </div>
                                <div class="text-sm font-bold text-slate-700 dark:text-slate-300">Belum ada Laporan Keuangan Kegiatan</div>
                                <div class="text-xs text-slate-500 dark:text-slate-400 mt-1">Klik tombol "+ Buat Laporan Keuangan Baru" di atas untuk memulai pencatatan.</div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($reports->hasPages())
            <div class="p-4 border-t border-slate-200 dark:border-slate-800">
                {{ $reports->links() }}
            </div>
        @endif
    </div>

</div>
@endsection

