@extends('layouts.admin')

@section('title', 'Buku Tamu Publik / Inbox')
@section('page_title', 'Buku Tamu')

@section('content')
<div class="space-y-6" x-data="{ detailModal: null }">
    
    <!-- Header -->
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
        <div>
            <h2 class="text-xl font-extrabold text-[#0B132B] dark:text-white">Buku Tamu & Pesan Publik</h2>
            <p class="text-xs text-slate-600 dark:text-slate-400 mt-1 font-medium">Pesan, permohonan audiensi, dan komunikasi masyarakat dari formulir website</p>
        </div>
    </div>

    <!-- Table Container (Clean White Background Card) -->
    <div class="bg-white dark:bg-slate-900 border border-slate-300 dark:border-slate-800 rounded-2xl shadow-sm overflow-hidden">
        
        <!-- Filter Bar -->
        <div class="p-6 border-b border-slate-200 dark:border-slate-800 flex flex-col sm:flex-row sm:items-center justify-between gap-4 bg-slate-50/50 dark:bg-slate-900/50">
            <div class="flex items-center gap-2">
                <span class="text-xs font-semibold text-slate-700 dark:text-slate-300">Tampilkan</span>
                <form action="{{ route('admin.inbox.index') }}" method="GET">
                    <select name="entries" onchange="this.form.submit()" class="px-3 py-1.5 rounded-xl bg-white dark:bg-slate-950 border border-slate-300 dark:border-slate-700 text-xs font-semibold text-slate-900 dark:text-slate-200 outline-none shadow-sm">
                        <option value="10" {{ request('entries') == 10 ? 'selected' : '' }}>10</option>
                        <option value="25" {{ request('entries') == 25 ? 'selected' : '' }}>25</option>
                        <option value="50" {{ request('entries') == 50 ? 'selected' : '' }}>50</option>
                    </select>
                </form>
                <span class="text-xs font-semibold text-slate-700 dark:text-slate-300">pesan</span>
            </div>

            <form action="{{ route('admin.inbox.index') }}" method="GET" class="w-full sm:w-72">
                <div class="relative">
                    <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari nama / instansi / keperluan..." class="w-full pl-9 pr-4 py-2 rounded-xl bg-white dark:bg-slate-950 border border-slate-300 dark:border-slate-700 text-xs font-medium text-slate-900 dark:text-slate-200 focus:ring-2 focus:ring-blue-600 outline-none shadow-sm">
                    <i class="fa-solid fa-magnifying-glass absolute left-3 top-3 text-slate-400 text-xs"></i>
                </div>
            </form>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-left text-xs text-slate-800 dark:text-slate-200">
                <thead class="bg-[#0B132B] dark:bg-[#070D1E] text-white uppercase tracking-wider text-[11px] border-b border-blue-950">
                    <tr>
                        <th class="py-3.5 px-6 text-center w-16 font-bold">NO</th>
                        <th class="py-3.5 px-6 font-bold">TANGGAL</th>
                        <th class="py-3.5 px-6 font-bold">NAMA & INSTANSI</th>
                        <th class="py-3.5 px-6 font-bold">KONTAK / WA</th>
                        <th class="py-3.5 px-6 font-bold">TUJUAN & KEPERLUAN</th>
                        <th class="py-3.5 px-6 text-center w-36 font-bold">AKSI</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-200 dark:divide-slate-800">
                    @forelse($inboxes as $index => $item)
                        <tr class="hover:bg-slate-50 dark:hover:bg-white/[0.02] transition-colors">
                            <td class="py-4 px-6 text-center font-bold text-slate-500 dark:text-slate-400">{{ $inboxes->firstItem() + $index }}</td>
                            <td class="py-4 px-6 text-slate-700 dark:text-slate-300 font-medium">{{ $item->tanggal ? $item->tanggal->format('d-m-Y') : '-' }}</td>
                            <td class="py-4 px-6">
                                <div class="font-bold text-slate-900 dark:text-white flex items-center gap-2">
                                    <span>{{ $item->nama }}</span>
                                    @if($item->status === 'baru')
                                        <span class="px-1.5 py-0.5 rounded text-[9px] font-bold bg-rose-50 text-rose-700 border border-rose-200 dark:bg-rose-900/40 dark:text-rose-300">BARU</span>
                                    @endif
                                </div>
                                <div class="text-[11px] text-amber-700 dark:text-amber-400 font-semibold">{{ $item->instansi ?? 'Umum' }}</div>
                            </td>
                            <td class="py-4 px-6">
                                <div class="text-slate-900 dark:text-slate-200 font-semibold font-mono">{{ $item->telepon ?? '-' }}</div>
                                <div class="text-[10px] text-slate-500">{{ $item->email ?? '' }}</div>
                            </td>
                            <td class="py-4 px-6">
                                <div class="font-bold text-slate-900 dark:text-white leading-snug">{{ $item->keperluan }}</div>
                                <div class="text-[11px] text-slate-600 dark:text-slate-400 mt-0.5 line-clamp-1">{{ $item->pesan }}</div>
                            </td>
                            <td class="py-4 px-6 text-center">
                                <div class="flex items-center justify-center gap-2">
                                    <button type="button" @click="detailModal = {{ json_encode($item) }}" class="p-1.5 rounded-lg bg-blue-600 hover:bg-blue-700 text-white shadow-sm transition-all" title="Baca Pesan Lengkap">
                                        <i class="fa-solid fa-eye text-xs"></i>
                                    </button>
                                    <form action="{{ route('admin.inbox.destroy', $item->id) }}" method="POST" onsubmit="return confirm('Hapus pesan dari {{ $item->nama }}?')" class="inline">
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
                                Belum ada pesan masuk di buku tamu.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="p-6 border-t border-slate-200 dark:border-slate-800 flex justify-end bg-slate-50/50 dark:bg-slate-900/50">
            {{ $inboxes->withQueryString()->links() }}
        </div>

    </div>

    <!-- Modal Detail Pesan -->
    <div x-show="detailModal" x-cloak class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-slate-950/80 backdrop-blur-sm">
        <div class="relative w-full max-w-lg bg-white dark:bg-slate-900 border border-slate-300 dark:border-slate-800 rounded-3xl p-6 sm:p-8 shadow-2xl space-y-6 text-slate-900 dark:text-white" @click.away="detailModal = null">
            <div class="flex items-center justify-between border-b border-slate-200 dark:border-slate-800 pb-4">
                <h3 class="text-base font-extrabold text-[#0B132B] dark:text-white flex items-center gap-2">
                    <i class="fa-solid fa-envelope-open text-blue-600 dark:text-amber-400"></i> Detail Pesan Buku Tamu
                </h3>
                <button @click="detailModal = null" class="text-slate-400 hover:text-slate-600 dark:hover:text-white">
                    <i class="fa-solid fa-xmark text-base"></i>
                </button>
            </div>

            <div class="space-y-4 text-xs">
                <div class="p-4 rounded-2xl bg-slate-50 dark:bg-slate-950 border border-slate-200 dark:border-slate-800 space-y-2">
                    <div class="flex justify-between">
                        <span class="text-slate-600 dark:text-slate-400 font-medium">Pengirim:</span>
                        <span class="font-bold text-slate-900 dark:text-white" x-text="detailModal ? detailModal.nama : ''"></span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-slate-600 dark:text-slate-400 font-medium">Instansi:</span>
                        <span class="font-bold text-amber-700 dark:text-amber-400" x-text="detailModal ? detailModal.instansi : ''"></span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-slate-600 dark:text-slate-400 font-medium">No. WhatsApp / Telp:</span>
                        <span class="font-mono font-bold text-slate-900 dark:text-slate-200" x-text="detailModal ? detailModal.telepon : ''"></span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-slate-600 dark:text-slate-400 font-medium">Email:</span>
                        <span class="text-slate-800 dark:text-slate-200 font-semibold" x-text="detailModal ? detailModal.email : '-'"></span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-slate-600 dark:text-slate-400 font-medium">Keperluan:</span>
                        <span class="font-bold text-emerald-700 dark:text-emerald-400" x-text="detailModal ? detailModal.keperluan : ''"></span>
                    </div>
                </div>

                <div>
                    <span class="block text-slate-700 dark:text-slate-300 font-bold uppercase tracking-wider mb-1">Isi Pesan:</span>
                    <div class="p-4 rounded-2xl bg-slate-50 dark:bg-slate-950 border border-slate-200 dark:border-slate-800 text-slate-900 dark:text-slate-200 leading-relaxed font-medium" x-text="detailModal ? detailModal.pesan : ''"></div>
                </div>
            </div>

            <div class="flex items-center justify-between pt-4 border-t border-slate-200 dark:border-slate-800">
                <template x-if="detailModal && detailModal.telepon">
                    <a :href="'https://wa.me/' + detailModal.telepon.replace(/[^0-9]/g, '')" target="_blank" class="px-4 py-2 rounded-xl text-xs font-bold text-white bg-emerald-600 hover:bg-emerald-700 inline-flex items-center gap-2 shadow-sm transition-all">
                        <i class="fa-brands fa-whatsapp text-sm"></i> Balas via WhatsApp
                    </a>
                </template>
                <button type="button" @click="detailModal = null" class="px-5 py-2 rounded-xl text-xs font-bold text-slate-600 dark:text-slate-400 hover:bg-slate-100 dark:hover:bg-slate-800 transition-colors">Tutup</button>
            </div>
        </div>
    </div>

</div>
@endsection
