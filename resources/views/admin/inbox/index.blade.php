@extends('layouts.admin')

@section('title', 'Buku Tamu Publik / Inbox')
@section('page_title', 'Buku Tamu')

@section('content')
<div class="space-y-6" x-data="{ detailModal: null }">
    
    <!-- Header -->
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
        <div>
            <h2 class="text-xl font-extrabold text-white">Buku Tamu & Pesan Publik</h2>
            <p class="text-xs text-slate-400 mt-1">Pesan, permohonan audiensi, dan komunikasi masyarakat dari formulir website</p>
        </div>
    </div>

    <!-- Table Container -->
    <div class="bg-slate-900 border border-slate-800 rounded-3xl shadow-xl overflow-hidden">
        
        <!-- Filter Bar -->
        <div class="p-6 border-b border-slate-800 flex flex-col sm:flex-row sm:items-center justify-between gap-4">
            <div class="flex items-center gap-2">
                <span class="text-xs text-slate-400">Tampilkan</span>
                <form action="{{ route('admin.inbox.index') }}" method="GET">
                    <select name="entries" onchange="this.form.submit()" class="px-3 py-1.5 rounded-xl bg-slate-950 border border-slate-800 text-xs text-slate-200 outline-none">
                        <option value="10" {{ request('entries') == 10 ? 'selected' : '' }}>10</option>
                        <option value="25" {{ request('entries') == 25 ? 'selected' : '' }}>25</option>
                        <option value="50" {{ request('entries') == 50 ? 'selected' : '' }}>50</option>
                    </select>
                </form>
                <span class="text-xs text-slate-400">pesan</span>
            </div>

            <form action="{{ route('admin.inbox.index') }}" method="GET" class="w-full sm:w-72">
                <div class="relative">
                    <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari nama / instansi / keperluan..." class="w-full pl-9 pr-4 py-2 rounded-xl bg-slate-950 border border-slate-800 text-xs text-slate-200 focus:ring-2 focus:ring-amber-500 focus:border-amber-500 outline-none">
                    <i class="fa-solid fa-magnifying-glass absolute left-3 top-3 text-slate-500 text-xs"></i>
                </div>
            </form>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-left text-xs text-slate-300">
                <thead class="bg-slate-950/70 text-slate-400 uppercase tracking-wider text-[11px] border-b border-slate-800">
                    <tr>
                        <th class="py-3.5 px-6 text-center w-16">NO</th>
                        <th class="py-3.5 px-6">TANGGAL</th>
                        <th class="py-3.5 px-6">NAMA & INSTANSI</th>
                        <th class="py-3.5 px-6">KONTAK / WA</th>
                        <th class="py-3.5 px-6">TUJUAN & KEPERLUAN</th>
                        <th class="py-3.5 px-6 text-center w-36">AKSI</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-800/60">
                    @forelse($inboxes as $index => $item)
                        <tr class="hover:bg-white/[0.02] transition-colors">
                            <td class="py-4 px-6 text-center font-bold text-slate-500">{{ $inboxes->firstItem() + $index }}</td>
                            <td class="py-4 px-6 text-slate-400">{{ $item->tanggal ? $item->tanggal->format('d-m-Y') : '-' }}</td>
                            <td class="py-4 px-6">
                                <div class="font-bold text-white flex items-center gap-2">
                                    <span>{{ $item->nama }}</span>
                                    @if($item->status === 'baru')
                                        <span class="px-1.5 py-0.5 rounded text-[9px] font-bold bg-rose-500/20 text-rose-400 border border-rose-500/30">BARU</span>
                                    @endif
                                </div>
                                <div class="text-[11px] text-amber-400">{{ $item->instansi ?? 'Umum' }}</div>
                            </td>
                            <td class="py-4 px-6">
                                <div class="text-slate-300">{{ $item->telepon ?? '-' }}</div>
                                <div class="text-[10px] text-slate-500">{{ $item->email ?? '' }}</div>
                            </td>
                            <td class="py-4 px-6">
                                <div class="font-bold text-white leading-snug">{{ $item->keperluan }}</div>
                                <div class="text-[11px] text-slate-400 mt-0.5 line-clamp-1">{{ $item->pesan }}</div>
                            </td>
                            <td class="py-4 px-6 text-center">
                                <div class="flex items-center justify-center gap-2">
                                    <button type="button" @click="detailModal = {{ json_encode($item) }}" class="p-2 rounded-lg bg-blue-500/10 hover:bg-blue-500 text-blue-400 hover:text-white border border-blue-500/20 transition-all" title="Baca Pesan Lengkap">
                                        <i class="fa-solid fa-eye"></i>
                                    </button>
                                    <form action="{{ route('admin.inbox.destroy', $item->id) }}" method="POST" onsubmit="return confirm('Hapus pesan dari {{ $item->nama }}?')" class="inline">
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
                                Belum ada pesan masuk di buku tamu.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="p-6 border-t border-slate-800 flex justify-end">
            {{ $inboxes->withQueryString()->links() }}
        </div>

    </div>

    <!-- Modal Detail Pesan -->
    <div x-show="detailModal" x-cloak class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-slate-950/80 backdrop-blur-sm">
        <div class="relative w-full max-w-lg bg-slate-900 border border-slate-800 rounded-3xl p-6 sm:p-8 shadow-2xl space-y-6" @click.away="detailModal = null">
            <div class="flex items-center justify-between border-b border-slate-800 pb-4">
                <h3 class="text-base font-bold text-white flex items-center gap-2">
                    <i class="fa-solid fa-envelope-open text-amber-400"></i> Detail Pesan Buku Tamu
                </h3>
                <button @click="detailModal = null" class="text-slate-400 hover:text-white">
                    <i class="fa-solid fa-xmark"></i>
                </button>
            </div>

            <div class="space-y-4 text-xs">
                <div class="p-4 rounded-2xl bg-slate-950 border border-slate-800 space-y-2">
                    <div class="flex justify-between">
                        <span class="text-slate-400">Pengirim:</span>
                        <span class="font-bold text-white" x-text="detailModal ? detailModal.nama : ''"></span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-slate-400">Instansi:</span>
                        <span class="font-bold text-amber-400" x-text="detailModal ? detailModal.instansi : ''"></span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-slate-400">No. WhatsApp / Telp:</span>
                        <span class="font-mono text-slate-200" x-text="detailModal ? detailModal.telepon : ''"></span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-slate-400">Email:</span>
                        <span class="text-slate-200" x-text="detailModal ? detailModal.email : '-'"></span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-slate-400">Keperluan:</span>
                        <span class="font-bold text-emerald-400" x-text="detailModal ? detailModal.keperluan : ''"></span>
                    </div>
                </div>

                <div>
                    <span class="block text-slate-400 font-bold uppercase mb-1">Isi Pesan:</span>
                    <div class="p-4 rounded-2xl bg-slate-950 border border-slate-800 text-slate-200 leading-relaxed" x-text="detailModal ? detailModal.pesan : ''"></div>
                </div>
            </div>

            <div class="flex items-center justify-between pt-4 border-t border-slate-800">
                <template x-if="detailModal && detailModal.telepon">
                    <a :href="'https://wa.me/' + detailModal.telepon.replace(/[^0-9]/g, '')" target="_blank" class="px-4 py-2 rounded-xl text-xs font-bold text-slate-950 bg-emerald-400 hover:bg-emerald-300 inline-flex items-center gap-2">
                        <i class="fa-brands fa-whatsapp text-sm"></i> Balas via WhatsApp
                    </a>
                </template>
                <button type="button" @click="detailModal = null" class="px-5 py-2 rounded-xl text-xs font-semibold text-slate-400 hover:text-white bg-slate-950">Tutup</button>
            </div>
        </div>
    </div>

</div>
@endsection
