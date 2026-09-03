@extends('layouts.admin')

@section('title', 'Struktur Organisasi PWI Banyuasin')
@section('page_title', 'Struktur Organisasi')

@section('content')
<div class="space-y-6" x-data="{ modalTambah: false, editData: null }">
    
    <!-- Header -->
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
        <div>
            <h2 class="text-xl font-extrabold text-white">Struktur Kepengurusan PWI Banyuasin</h2>
            <p class="text-xs text-slate-400 mt-1">Susunan 32 pejabat pengurus harian dan kepala seksi bidang Masa Bhakti 2025–2028</p>
        </div>
        <button @click="modalTambah = true" class="inline-flex items-center gap-2 px-4 py-2.5 rounded-xl text-xs font-bold text-slate-950 bg-amber-400 hover:bg-amber-300 shadow-lg shadow-amber-400/20 transition-all">
            <i class="fa-solid fa-plus"></i>
            <span>+ Tambah Pengurus</span>
        </button>
    </div>

    <!-- Table Container -->
    <div class="bg-slate-900 border border-slate-800 rounded-3xl shadow-xl overflow-hidden">
        
        <!-- Filter Bar -->
        <div class="p-6 border-b border-slate-800 flex flex-col sm:flex-row sm:items-center justify-between gap-4">
            <div class="flex items-center gap-2">
                <span class="text-xs text-slate-400">Tampilkan</span>
                <form action="{{ route('admin.organization.index') }}" method="GET">
                    @if(request('search')) <input type="hidden" name="search" value="{{ request('search') }}"> @endif
                    <select name="entries" onchange="this.form.submit()" class="px-3 py-1.5 rounded-xl bg-slate-950 border border-slate-800 text-xs text-slate-200 outline-none">
                        <option value="10" {{ request('entries') == 10 ? 'selected' : '' }}>10</option>
                        <option value="25" {{ request('entries') == 25 ? 'selected' : '' }}>25</option>
                        <option value="50" {{ request('entries') == 50 ? 'selected' : '' }}>50</option>
                        <option value="100" {{ request('entries') == 100 ? 'selected' : '' }}>100</option>
                    </select>
                </form>
                <span class="text-xs text-slate-400">pengurus</span>
            </div>

            <form action="{{ route('admin.organization.index') }}" method="GET" class="w-full sm:w-72">
                @if(request('entries')) <input type="hidden" name="entries" value="{{ request('entries') }}"> @endif
                <div class="relative">
                    <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari nama / jabatan..." class="w-full pl-9 pr-4 py-2 rounded-xl bg-slate-950 border border-slate-800 text-xs text-slate-200 focus:ring-2 focus:ring-amber-500 focus:border-amber-500 outline-none">
                    <i class="fa-solid fa-magnifying-glass absolute left-3 top-3 text-slate-500 text-xs"></i>
                </div>
            </form>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-left text-xs text-slate-300">
                <thead class="bg-slate-950/70 text-slate-400 uppercase tracking-wider text-[11px] border-b border-slate-800">
                    <tr>
                        <th class="py-3.5 px-6 text-center w-16">NO</th>
                        <th class="py-3.5 px-6">NAMA PENGURUS</th>
                        <th class="py-3.5 px-6">NOMOR KARTU</th>
                        <th class="py-3.5 px-6">TINGKAT</th>
                        <th class="py-3.5 px-6">MASA BERLAKU</th>
                        <th class="py-3.5 px-6">JABATAN</th>
                        <th class="py-3.5 px-6 text-center w-36">AKSI</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-800/60">
                    @forelse($structures as $index => $s)
                        <tr class="hover:bg-white/[0.02] transition-colors">
                            <td class="py-3.5 px-6 text-center font-bold text-slate-500">{{ $structures->firstItem() + $index }}</td>
                            <td class="py-3.5 px-6 font-bold text-white">{{ $s->nama }}</td>
                            <td class="py-3.5 px-6 font-mono text-slate-400">{{ $s->nomor_kartu ?? '-' }}</td>
                            <td class="py-3.5 px-6">
                                <span class="inline-block px-2.5 py-1 rounded-lg text-[10px] font-bold {{ $s->tingkat_ukw === 'Wartawan Utama' ? 'bg-rose-500/10 text-rose-400 border border-rose-500/20' : ($s->tingkat_ukw === 'Wartawan Madya' ? 'bg-cyan-500/10 text-cyan-400 border border-cyan-500/20' : ($s->tingkat_ukw === 'Wartawan Muda' ? 'bg-emerald-500/10 text-emerald-400 border border-emerald-500/20' : 'bg-slate-800 text-slate-400')) }}">
                                    {{ $s->tingkat_ukw ?? 'Belum UKW' }}
                                </span>
                            </td>
                            <td class="py-3.5 px-6">
                                <span class="inline-block px-2.5 py-1 rounded-md bg-slate-100 dark:bg-slate-800 border border-slate-200/60 dark:border-slate-700 text-slate-700 dark:text-slate-300 font-semibold text-[11px]">
                                    {{ $s->jabatan }}
                                </span>
                            </td>
                            <td class="py-3.5 px-6 text-center">
                                <div class="flex items-center justify-center gap-1.5">
                                    <button type="button" @click="editData = {{ json_encode($s) }}" class="p-1.5 rounded-lg bg-blue-500/10 hover:bg-blue-500 text-blue-400 hover:text-white border border-blue-500/20 transition-all" title="Edit Pengurus">
                                        <i class="fa-solid fa-pen"></i>
                                    </button>
                                    <form action="{{ route('admin.organization.destroy', $s->id) }}" method="POST" onsubmit="return confirm('Hapus pengurus {{ $s->nama }}?')" class="inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="p-1.5 rounded-lg bg-rose-500/10 hover:bg-rose-500 text-rose-400 hover:text-white border border-rose-500/20 transition-all" title="Hapus">
                                            <i class="fa-solid fa-trash"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="py-12 text-center text-slate-500">
                                Tidak ada data pengurus organisasi.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="p-6 border-t border-slate-800 flex flex-col sm:flex-row items-center justify-between text-xs text-slate-400 gap-4">
            <div>
                Menampilkan {{ $structures->firstItem() ?? 0 }} s/d {{ $structures->lastItem() ?? 0 }} dari {{ $structures->total() }} pengurus
            </div>
            <div>
                {{ $structures->withQueryString()->links() }}
            </div>
        </div>

    </div>

    <!-- Modal Tambah Pengurus -->
    <div x-show="modalTambah" x-cloak class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-slate-950/80 backdrop-blur-sm">
        <div class="relative w-full max-w-lg bg-slate-900 border border-slate-800 rounded-3xl p-6 sm:p-8 shadow-2xl space-y-6" @click.away="modalTambah = false">
            <div class="flex items-center justify-between border-b border-slate-800 pb-4">
                <h3 class="text-base font-bold text-white flex items-center gap-2">
                    <i class="fa-solid fa-sitemap text-amber-400"></i> Tambah Pengurus Organisasi
                </h3>
                <button @click="modalTambah = false" class="text-slate-400 hover:text-white">
                    <i class="fa-solid fa-xmark"></i>
                </button>
            </div>

            <form action="{{ route('admin.organization.store') }}" method="POST" class="space-y-4">
                @csrf

                <div>
                    <label class="block text-xs font-bold text-slate-300 uppercase mb-1">Nama Lengkap & Gelar *</label>
                    <input type="text" name="nama" required class="w-full px-4 py-2.5 rounded-xl bg-slate-950 border border-slate-800 text-xs text-white focus:ring-2 focus:ring-amber-500 outline-none" placeholder="Contoh: Wardoyo, S.I.Kom">
                </div>

                <div class="grid grid-cols-2 gap-3">
                    <div>
                        <label class="block text-xs font-bold text-slate-300 uppercase mb-1">Nomor Kartu (KTA)</label>
                        <input type="text" name="nomor_kartu" class="w-full px-4 py-2.5 rounded-xl bg-slate-950 border border-slate-800 text-xs text-white focus:ring-2 focus:ring-amber-500 outline-none" placeholder="06.00.17208.14B">
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-slate-300 uppercase mb-1">Tingkat UKW</label>
                        <select name="tingkat_ukw" class="w-full px-4 py-2.5 rounded-xl bg-slate-950 border border-slate-800 text-xs text-white focus:ring-2 focus:ring-amber-500 outline-none">
                            <option value="Wartawan Utama">Wartawan Utama</option>
                            <option value="Wartawan Madya">Wartawan Madya</option>
                            <option value="Wartawan Muda">Wartawan Muda</option>
                            <option value="Belum UKW">Belum UKW</option>
                        </select>
                    </div>
                </div>

                <div class="grid grid-cols-2 gap-3">
                    <div>
                        <label class="block text-xs font-bold text-slate-300 uppercase mb-1">Jabatan Pengurus *</label>
                        <input type="text" name="jabatan" required class="w-full px-4 py-2.5 rounded-xl bg-slate-950 border border-slate-800 text-xs text-white focus:ring-2 focus:ring-amber-500 outline-none" placeholder="Contoh: KETUA / SEKRETARIS">
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-slate-300 uppercase mb-1">Urutan Tampil (No)</label>
                        <input type="number" name="urutan" value="1" class="w-full px-4 py-2.5 rounded-xl bg-slate-950 border border-slate-800 text-xs text-white focus:ring-2 focus:ring-amber-500 outline-none">
                    </div>
                </div>

                <div class="flex items-center justify-end gap-3 pt-4 border-t border-slate-800">
                    <button type="button" @click="modalTambah = false" class="px-4 py-2 rounded-xl text-xs font-semibold text-slate-400 hover:text-white bg-slate-950">Batal</button>
                    <button type="submit" class="px-6 py-2 rounded-xl text-xs font-bold text-slate-950 bg-amber-400 hover:bg-amber-300">Simpan Pengurus</button>
                </div>
            </form>
        </div>
    </div>

    <!-- Modal Edit Pengurus -->
    <div x-show="editData" x-cloak class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-slate-950/80 backdrop-blur-sm">
        <div class="relative w-full max-w-lg bg-slate-900 border border-slate-800 rounded-3xl p-6 sm:p-8 shadow-2xl space-y-6" @click.away="editData = null">
            <div class="flex items-center justify-between border-b border-slate-800 pb-4">
                <h3 class="text-base font-bold text-white flex items-center gap-2">
                    <i class="fa-solid fa-pen text-blue-400"></i> Edit Pengurus
                </h3>
                <button @click="editData = null" class="text-slate-400 hover:text-white">
                    <i class="fa-solid fa-xmark"></i>
                </button>
            </div>

            <form :action="'{{ url('admin/struktur-organisasi') }}/' + (editData ? editData.id : '')" method="POST" class="space-y-4">
                @csrf
                @method('PUT')

                <div>
                    <label class="block text-xs font-bold text-slate-300 uppercase mb-1">Nama Lengkap & Gelar *</label>
                    <input type="text" name="nama" :value="editData ? editData.nama : ''" required class="w-full px-4 py-2.5 rounded-xl bg-slate-950 border border-slate-800 text-xs text-white focus:ring-2 focus:ring-amber-500 outline-none">
                </div>

                <div class="grid grid-cols-2 gap-3">
                    <div>
                        <label class="block text-xs font-bold text-slate-300 uppercase mb-1">Nomor Kartu (KTA)</label>
                        <input type="text" name="nomor_kartu" :value="editData ? editData.nomor_kartu : ''" class="w-full px-4 py-2.5 rounded-xl bg-slate-950 border border-slate-800 text-xs text-white focus:ring-2 focus:ring-amber-500 outline-none">
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-slate-300 uppercase mb-1">Tingkat UKW</label>
                        <select name="tingkat_ukw" :value="editData ? editData.tingkat_ukw : ''" class="w-full px-4 py-2.5 rounded-xl bg-slate-950 border border-slate-800 text-xs text-white focus:ring-2 focus:ring-amber-500 outline-none">
                            <option value="Wartawan Utama">Wartawan Utama</option>
                            <option value="Wartawan Madya">Wartawan Madya</option>
                            <option value="Wartawan Muda">Wartawan Muda</option>
                            <option value="Belum UKW">Belum UKW</option>
                        </select>
                    </div>
                </div>

                <div class="grid grid-cols-2 gap-3">
                    <div>
                        <label class="block text-xs font-bold text-slate-300 uppercase mb-1">Jabatan Pengurus *</label>
                        <input type="text" name="jabatan" :value="editData ? editData.jabatan : ''" required class="w-full px-4 py-2.5 rounded-xl bg-slate-950 border border-slate-800 text-xs text-white focus:ring-2 focus:ring-amber-500 outline-none">
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-slate-300 uppercase mb-1">Urutan Tampil (No)</label>
                        <input type="number" name="urutan" :value="editData ? editData.urutan : 1" class="w-full px-4 py-2.5 rounded-xl bg-slate-950 border border-slate-800 text-xs text-white focus:ring-2 focus:ring-amber-500 outline-none">
                    </div>
                </div>

                <div class="flex items-center justify-end gap-3 pt-4 border-t border-slate-800">
                    <button type="button" @click="editData = null" class="px-4 py-2 rounded-xl text-xs font-semibold text-slate-400 hover:text-white bg-slate-950">Batal</button>
                    <button type="submit" class="px-6 py-2 rounded-xl text-xs font-bold text-white bg-blue-600 hover:bg-blue-500">Simpan Perubahan</button>
                </div>
            </form>
        </div>
    </div>

</div>
@endsection
