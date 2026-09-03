@extends('layouts.admin')

@section('title', 'Surat Keluar & Administrasi')
@section('page_title', 'Surat Keluar')

@section('content')
<div class="space-y-6" x-data="{ 
    modalTugas: false, 
    modalAudiensi: false, 
    modalBiasa: false, 
    modalProposal: false 
}">
    
    <!-- Top Action Bar with 4 Generator Buttons matching ref/new/ -->
    <div class="flex flex-col lg:flex-row lg:items-center justify-between gap-4">
        <div>
            <h2 class="text-xl font-extrabold text-white">Buku Register Surat Keluar</h2>
            <p class="text-xs text-slate-400 mt-1">Pengarsipan digital dan pembuatan surat tugas, audiensi, surat biasa, dan proposal</p>
        </div>
        
        <div class="flex flex-wrap items-center gap-2">
            <button @click="modalTugas = true" class="inline-flex items-center gap-2 px-3.5 py-2.5 rounded-xl text-xs font-bold text-white bg-cyan-600 hover:bg-cyan-500 shadow-lg shadow-cyan-600/20 transition-all">
                <i class="fa-solid fa-user-tag"></i>
                <span>+ Buat Surat Tugas</span>
            </button>
            <button @click="modalAudiensi = true" class="inline-flex items-center gap-2 px-3.5 py-2.5 rounded-xl text-xs font-bold text-slate-950 bg-amber-400 hover:bg-amber-300 shadow-lg shadow-amber-400/20 transition-all">
                <i class="fa-solid fa-comments"></i>
                <span>+ Buat Surat Audensi</span>
            </button>
            <button @click="modalBiasa = true" class="inline-flex items-center gap-2 px-3.5 py-2.5 rounded-xl text-xs font-bold text-white bg-emerald-600 hover:bg-emerald-500 shadow-lg shadow-emerald-600/20 transition-all">
                <i class="fa-solid fa-envelope"></i>
                <span>+ Buat Surat Biasa</span>
            </button>
            <button @click="modalProposal = true" class="inline-flex items-center gap-2 px-3.5 py-2.5 rounded-xl text-xs font-bold text-white bg-slate-700 hover:bg-slate-600 shadow-lg transition-all">
                <i class="fa-solid fa-file-contract"></i>
                <span>+ Buat Surat Proposal</span>
            </button>
        </div>
    </div>

    <!-- Table Container -->
    <div class="bg-slate-900 border border-slate-800 rounded-3xl shadow-xl overflow-hidden">
        
        <!-- Table Filter Bar -->
        <div class="p-6 border-b border-slate-800 flex flex-col sm:flex-row sm:items-center justify-between gap-4">
            <div class="flex flex-wrap items-center gap-2">
                <a href="{{ route('admin.letters.index') }}" class="px-3.5 py-1.5 rounded-xl text-xs font-bold transition-all {{ !request('jenis') ? 'bg-amber-500 text-slate-950' : 'bg-slate-950 text-slate-400 hover:text-white border border-slate-800' }}">
                    Semua Jenis
                </a>
                <a href="{{ route('admin.letters.index', ['jenis' => 'SURAT TUGAS']) }}" class="px-3.5 py-1.5 rounded-xl text-xs font-bold transition-all {{ request('jenis') == 'SURAT TUGAS' ? 'bg-cyan-600 text-white' : 'bg-slate-950 text-slate-400 hover:text-white border border-slate-800' }}">
                    Surat Tugas
                </a>
                <a href="{{ route('admin.letters.index', ['jenis' => 'SURAT AUDENSI']) }}" class="px-3.5 py-1.5 rounded-xl text-xs font-bold transition-all {{ request('jenis') == 'SURAT AUDENSI' ? 'bg-amber-400 text-slate-950' : 'bg-slate-950 text-slate-400 hover:text-white border border-slate-800' }}">
                    Surat Audiensi
                </a>
                <a href="{{ route('admin.letters.index', ['jenis' => 'SURAT BIASA']) }}" class="px-3.5 py-1.5 rounded-xl text-xs font-bold transition-all {{ request('jenis') == 'SURAT BIASA' ? 'bg-emerald-600 text-white' : 'bg-slate-950 text-slate-400 hover:text-white border border-slate-800' }}">
                    Surat Biasa
                </a>
                <a href="{{ route('admin.letters.index', ['jenis' => 'PROPOSAL']) }}" class="px-3.5 py-1.5 rounded-xl text-xs font-bold transition-all {{ request('jenis') == 'PROPOSAL' ? 'bg-slate-700 text-white' : 'bg-slate-950 text-slate-400 hover:text-white border border-slate-800' }}">
                    Proposal
                </a>
            </div>

            <form action="{{ route('admin.letters.index') }}" method="GET" class="w-full sm:w-72">
                @if(request('jenis')) <input type="hidden" name="jenis" value="{{ request('jenis') }}"> @endif
                <div class="relative">
                    <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari nomor / tujuan / perihal..." class="w-full pl-9 pr-4 py-2 rounded-xl bg-slate-950 border border-slate-800 text-xs text-slate-200 focus:ring-2 focus:ring-amber-500 focus:border-amber-500 outline-none">
                    <i class="fa-solid fa-magnifying-glass absolute left-3 top-3 text-slate-500 text-xs"></i>
                </div>
            </form>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-left text-xs text-slate-300">
                <thead class="bg-slate-950/70 text-slate-400 uppercase tracking-wider text-[11px] border-b border-slate-800">
                    <tr>
                        <th class="py-3.5 px-6 text-center w-16">NO</th>
                        <th class="py-3.5 px-6">NOMOR SURAT</th>
                        <th class="py-3.5 px-6">TANGGAL</th>
                        <th class="py-3.5 px-6">JENIS SURAT</th>
                        <th class="py-3.5 px-6">TUJUAN / PENERIMA</th>
                        <th class="py-3.5 px-6">KEPERLUAN / PERIHAL</th>
                        <th class="py-3.5 px-6 text-center w-36">AKSI</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-800/60">
                    @forelse($letters as $index => $item)
                        <tr class="hover:bg-white/[0.02] transition-colors">
                            <td class="py-3.5 px-6 text-center font-bold text-slate-500">{{ $letters->firstItem() + $index }}</td>
                            <td class="py-3.5 px-6 font-mono font-bold text-white">{{ $item->nomor_surat }}</td>
                            <td class="py-3.5 px-6 text-slate-400">{{ $item->tanggal ? $item->tanggal->format('d/m/Y') : '-' }}</td>
                            <td class="py-3.5 px-6">
                                <span class="px-2.5 py-1 rounded-lg text-[10px] font-bold {{ $item->jenis_surat === 'SURAT TUGAS' ? 'bg-cyan-500/10 text-cyan-400 border border-cyan-500/20' : ($item->jenis_surat === 'SURAT AUDENSI' ? 'bg-amber-500/10 text-amber-400 border border-amber-500/20' : ($item->jenis_surat === 'PROPOSAL' ? 'bg-slate-700/50 text-slate-300 border border-slate-600' : 'bg-emerald-500/10 text-emerald-400 border border-emerald-500/20')) }}">
                                    {{ $item->jenis_surat }}
                                </span>
                            </td>
                            <td class="py-3.5 px-6 font-bold text-white">
                                {{ $item->tujuan }}
                                @if($item->member)
                                    <span class="block text-[10px] text-cyan-400 font-normal">Petugas: {{ $item->member->nama }}</span>
                                @endif
                            </td>
                            <td class="py-3.5 px-6 text-slate-300">
                                {{ Str::limit($item->keperluan ?? $item->perihal, 50) }}
                            </td>
                            <td class="py-3.5 px-6 text-center">
                                <div class="flex items-center justify-center gap-1.5">
                                    <a href="{{ route('admin.letters.print', $item->id) }}" target="_blank" class="p-1.5 rounded-lg bg-sky-500/10 hover:bg-sky-500 text-sky-400 hover:text-white border border-sky-500/20 transition-all" title="Cetak Surat Resmi">
                                        <i class="fa-solid fa-print"></i>
                                    </a>
                                    <a href="{{ route('admin.letters.edit', $item->id) }}" class="p-1.5 rounded-lg bg-amber-500/10 hover:bg-amber-500 text-amber-400 hover:text-slate-950 border border-amber-500/20 transition-all" title="Edit Surat">
                                        <i class="fa-solid fa-pen"></i>
                                    </a>
                                    <form action="{{ route('admin.letters.destroy', $item->id) }}" method="POST" onsubmit="return confirm('Hapus surat keluar ini?')" class="inline">
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
                                Belum ada data surat keluar.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="p-6 border-t border-slate-800 flex flex-col sm:flex-row items-center justify-between text-xs text-slate-400 gap-4">
            <div>
                Menampilkan {{ $letters->firstItem() ?? 0 }} s/d {{ $letters->lastItem() ?? 0 }} dari {{ $letters->total() }} surat
            </div>
            <div>
                {{ $letters->withQueryString()->links() }}
            </div>
        </div>

    </div>

    <!-- 1. MODAL GENERATOR: SURAT TUGAS -->
    <div x-show="modalTugas" x-cloak class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-slate-950/80 backdrop-blur-sm">
        <div class="relative w-full max-w-lg bg-slate-900 border border-slate-800 rounded-3xl p-6 sm:p-8 shadow-2xl space-y-6" @click.away="modalTugas = false">
            <div class="flex items-center justify-between border-b border-cyan-500/30 pb-4">
                <h3 class="text-base font-bold text-white flex items-center gap-2">
                    <i class="fa-solid fa-user-tag text-cyan-400"></i> Buat Surat Tugas
                </h3>
                <button @click="modalTugas = false" class="text-slate-400 hover:text-white">
                    <i class="fa-solid fa-xmark"></i>
                </button>
            </div>

            <form action="{{ route('admin.letters.store') }}" method="POST" class="space-y-4">
                @csrf
                <input type="hidden" name="jenis_surat" value="SURAT TUGAS">

                <div>
                    <label class="block text-xs font-bold text-slate-300 uppercase mb-1">Nomor Surat</label>
                    <input type="text" name="nomor_surat" value="{{ \App\Models\Letter::generateNomorSurat('SURAT TUGAS') }}" required class="w-full px-4 py-2.5 rounded-xl bg-slate-950 border border-slate-800 text-xs font-mono text-cyan-400 focus:ring-2 focus:ring-cyan-500 outline-none">
                </div>

                <div>
                    <label class="block text-xs font-bold text-slate-300 uppercase mb-1">Tanggal Surat *</label>
                    <input type="date" name="tanggal" value="{{ date('Y-m-d') }}" required class="w-full px-4 py-2.5 rounded-xl bg-slate-950 border border-slate-800 text-xs text-white focus:ring-2 focus:ring-cyan-500 outline-none">
                </div>

                <div>
                    <label class="block text-xs font-bold text-slate-300 uppercase mb-1">Pilih Anggota yang Ditugaskan *</label>
                    <select name="member_id" required class="w-full px-4 py-2.5 rounded-xl bg-slate-950 border border-slate-800 text-xs text-white focus:ring-2 focus:ring-cyan-500 outline-none">
                        <option value="">-- Pilih Anggota Wartawan --</option>
                        @foreach($members as $m)
                            <option value="{{ $m->id }}">{{ $m->nama }} ({{ $m->jabatan }})</option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <label class="block text-xs font-bold text-slate-300 uppercase mb-1">Tujuan Penugasan *</label>
                    <input type="text" name="tujuan" required class="w-full px-4 py-2.5 rounded-xl bg-slate-950 border border-slate-800 text-xs text-white focus:ring-2 focus:ring-cyan-500 outline-none" placeholder="Contoh: Serang - Provinsi Banten">
                </div>

                <div>
                    <label class="block text-xs font-bold text-slate-300 uppercase mb-1">Keperluan Tugas *</label>
                    <input type="text" name="keperluan" required class="w-full px-4 py-2.5 rounded-xl bg-slate-950 border border-slate-800 text-xs text-white focus:ring-2 focus:ring-cyan-500 outline-none" placeholder="Contoh: Kegiatan Hari Pers Nasional (HPN) 2026">
                </div>

                <div>
                    <label class="block text-xs font-bold text-slate-300 uppercase mb-1">Lokasi Pelaksanaan</label>
                    <input type="text" name="lokasi" class="w-full px-4 py-2.5 rounded-xl bg-slate-950 border border-slate-800 text-xs text-white focus:ring-2 focus:ring-cyan-500 outline-none" placeholder="Contoh: Banten Convention Center">
                </div>

                <div class="grid grid-cols-2 gap-3">
                    <div>
                        <label class="block text-xs font-bold text-slate-300 uppercase mb-1">Tgl Pelaksanaan</label>
                        <input type="date" name="tanggal_mulai" class="w-full px-4 py-2.5 rounded-xl bg-slate-950 border border-slate-800 text-xs text-white focus:ring-2 focus:ring-cyan-500 outline-none">
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-slate-300 uppercase mb-1">Sampai Dengan</label>
                        <input type="date" name="tanggal_selesai" class="w-full px-4 py-2.5 rounded-xl bg-slate-950 border border-slate-800 text-xs text-white focus:ring-2 focus:ring-cyan-500 outline-none">
                    </div>
                </div>

                <div class="flex items-center justify-end gap-3 pt-4 border-t border-slate-800">
                    <button type="button" @click="modalTugas = false" class="px-4 py-2 rounded-xl text-xs font-semibold text-slate-400 hover:text-white bg-slate-950">Batal</button>
                    <button type="submit" class="px-6 py-2 rounded-xl text-xs font-bold text-white bg-cyan-600 hover:bg-cyan-500">Simpan Surat Tugas</button>
                </div>
            </form>
        </div>
    </div>

    <!-- 2. MODAL GENERATOR: SURAT AUDIENSI -->
    <div x-show="modalAudiensi" x-cloak class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-slate-950/80 backdrop-blur-sm">
        <div class="relative w-full max-w-lg bg-slate-900 border border-slate-800 rounded-3xl p-6 sm:p-8 shadow-2xl space-y-6" @click.away="modalAudiensi = false">
            <div class="flex items-center justify-between border-b border-amber-500/30 pb-4">
                <h3 class="text-base font-bold text-white flex items-center gap-2">
                    <i class="fa-solid fa-comments text-amber-400"></i> Surat Permohonan Audensi
                </h3>
                <button @click="modalAudiensi = false" class="text-slate-400 hover:text-white">
                    <i class="fa-solid fa-xmark"></i>
                </button>
            </div>

            <form action="{{ route('admin.letters.store') }}" method="POST" class="space-y-4">
                @csrf
                <input type="hidden" name="jenis_surat" value="SURAT AUDENSI">

                <div>
                    <label class="block text-xs font-bold text-slate-300 uppercase mb-1">Nomor Surat</label>
                    <input type="text" name="nomor_surat" value="{{ \App\Models\Letter::generateNomorSurat('SURAT AUDENSI') }}" required class="w-full px-4 py-2.5 rounded-xl bg-slate-950 border border-slate-800 text-xs font-mono text-amber-400 focus:ring-2 focus:ring-amber-500 outline-none">
                </div>

                <div>
                    <label class="block text-xs font-bold text-slate-300 uppercase mb-1">Tanggal Surat *</label>
                    <input type="date" name="tanggal" value="{{ date('Y-m-d') }}" required class="w-full px-4 py-2.5 rounded-xl bg-slate-950 border border-slate-800 text-xs text-white focus:ring-2 focus:ring-amber-500 outline-none">
                </div>

                <div>
                    <label class="block text-xs font-bold text-slate-300 uppercase mb-1">Prihal / Perihal *</label>
                    <input type="text" name="perihal" value="Permohonan Audiensi Pengurus PWI Banyuasin" required class="w-full px-4 py-2.5 rounded-xl bg-slate-950 border border-slate-800 text-xs text-white focus:ring-2 focus:ring-amber-500 outline-none">
                </div>

                <div class="grid grid-cols-2 gap-3">
                    <div>
                        <label class="block text-xs font-bold text-slate-300 uppercase mb-1">Jabatan Penerima</label>
                        <input type="text" name="jabatan_pejabat" class="w-full px-4 py-2.5 rounded-xl bg-slate-950 border border-slate-800 text-xs text-white focus:ring-2 focus:ring-amber-500 outline-none" placeholder="Contoh: Bupati Banyuasin">
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-slate-300 uppercase mb-1">Nama Pejabat *</label>
                        <input type="text" name="nama_pejabat" required class="w-full px-4 py-2.5 rounded-xl bg-slate-950 border border-slate-800 text-xs text-white focus:ring-2 focus:ring-amber-500 outline-none" placeholder="Contoh: Dr. H. Askolani, S.H., M.H.">
                    </div>
                </div>

                <div>
                    <label class="block text-xs font-bold text-slate-300 uppercase mb-1">Alamat Tujuan</label>
                    <input type="text" name="alamat_tujuan" class="w-full px-4 py-2.5 rounded-xl bg-slate-950 border border-slate-800 text-xs text-white focus:ring-2 focus:ring-amber-500 outline-none" placeholder="Contoh: Komplek Perkantoran Pemkab Banyuasin">
                </div>

                <div>
                    <label class="block text-xs font-bold text-slate-300 uppercase mb-1">Isi Surat Permohonan</label>
                    <textarea name="isi_surat" rows="3" class="w-full px-4 py-2.5 rounded-xl bg-slate-950 border border-slate-800 text-xs text-white focus:ring-2 focus:ring-amber-500 outline-none" placeholder="Tuliskan uraian maksud dan agenda audiensi..."></textarea>
                </div>

                <div class="flex items-center justify-end gap-3 pt-4 border-t border-slate-800">
                    <button type="button" @click="modalAudiensi = false" class="px-4 py-2 rounded-xl text-xs font-semibold text-slate-400 hover:text-white bg-slate-950">Batal</button>
                    <button type="submit" class="px-6 py-2 rounded-xl text-xs font-bold text-slate-950 bg-amber-400 hover:bg-amber-300">Simpan Surat Audensi</button>
                </div>
            </form>
        </div>
    </div>

    <!-- 3. MODAL GENERATOR: SURAT BIASA -->
    <div x-show="modalBiasa" x-cloak class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-slate-950/80 backdrop-blur-sm">
        <div class="relative w-full max-w-lg bg-slate-900 border border-slate-800 rounded-3xl p-6 sm:p-8 shadow-2xl space-y-6" @click.away="modalBiasa = false">
            <div class="flex items-center justify-between border-b border-emerald-500/30 pb-4">
                <h3 class="text-base font-bold text-white flex items-center gap-2">
                    <i class="fa-solid fa-envelope text-emerald-400"></i> Buat Surat Biasa
                </h3>
                <button @click="modalBiasa = false" class="text-slate-400 hover:text-white">
                    <i class="fa-solid fa-xmark"></i>
                </button>
            </div>

            <form action="{{ route('admin.letters.store') }}" method="POST" class="space-y-4">
                @csrf
                <input type="hidden" name="jenis_surat" value="SURAT BIASA">

                <div>
                    <label class="block text-xs font-bold text-slate-300 uppercase mb-1">Nomor Surat</label>
                    <input type="text" name="nomor_surat" value="{{ \App\Models\Letter::generateNomorSurat('SURAT BIASA') }}" required class="w-full px-4 py-2.5 rounded-xl bg-slate-950 border border-slate-800 text-xs font-mono text-emerald-400 focus:ring-2 focus:ring-emerald-500 outline-none">
                </div>

                <div>
                    <label class="block text-xs font-bold text-slate-300 uppercase mb-1">Tanggal Surat *</label>
                    <input type="date" name="tanggal" value="{{ date('Y-m-d') }}" required class="w-full px-4 py-2.5 rounded-xl bg-slate-950 border border-slate-800 text-xs text-white focus:ring-2 focus:ring-emerald-500 outline-none">
                </div>

                <div>
                    <label class="block text-xs font-bold text-slate-300 uppercase mb-1">Prihal / Perihal *</label>
                    <input type="text" name="perihal" required class="w-full px-4 py-2.5 rounded-xl bg-slate-950 border border-slate-800 text-xs text-white focus:ring-2 focus:ring-emerald-500 outline-none" placeholder="Contoh: Pemberitahuan Kegiatan / Pengamanan">
                </div>

                <div class="grid grid-cols-2 gap-3">
                    <div>
                        <label class="block text-xs font-bold text-slate-300 uppercase mb-1">Jabatan Penerima</label>
                        <input type="text" name="jabatan_pejabat" class="w-full px-4 py-2.5 rounded-xl bg-slate-950 border border-slate-800 text-xs text-white focus:ring-2 focus:ring-emerald-500 outline-none" placeholder="Contoh: Kapolres Banyuasin">
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-slate-300 uppercase mb-1">Nama Pejabat *</label>
                        <input type="text" name="nama_pejabat" required class="w-full px-4 py-2.5 rounded-xl bg-slate-950 border border-slate-800 text-xs text-white focus:ring-2 focus:ring-emerald-500 outline-none" placeholder="Nama pejabat / tujuan...">
                    </div>
                </div>

                <div>
                    <label class="block text-xs font-bold text-slate-300 uppercase mb-1">Alamat Tujuan</label>
                    <input type="text" name="alamat_tujuan" class="w-full px-4 py-2.5 rounded-xl bg-slate-950 border border-slate-800 text-xs text-white focus:ring-2 focus:ring-emerald-500 outline-none" placeholder="Di Tempat">
                </div>

                <div>
                    <label class="block text-xs font-bold text-slate-300 uppercase mb-1">Isi Surat</label>
                    <textarea name="isi_surat" rows="4" class="w-full px-4 py-2.5 rounded-xl bg-slate-950 border border-slate-800 text-xs text-white focus:ring-2 focus:ring-emerald-500 outline-none" placeholder="Tuliskan isi surat selengkapnya..."></textarea>
                </div>

                <div class="flex items-center justify-end gap-3 pt-4 border-t border-slate-800">
                    <button type="button" @click="modalBiasa = false" class="px-4 py-2 rounded-xl text-xs font-semibold text-slate-400 hover:text-white bg-slate-950">Batal</button>
                    <button type="submit" class="px-6 py-2 rounded-xl text-xs font-bold text-white bg-emerald-600 hover:bg-emerald-500">Simpan Surat</button>
                </div>
            </form>
        </div>
    </div>

    <!-- 4. MODAL GENERATOR: SURAT PROPOSAL -->
    <div x-show="modalProposal" x-cloak class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-slate-950/80 backdrop-blur-sm">
        <div class="relative w-full max-w-lg bg-slate-900 border border-slate-800 rounded-3xl p-6 sm:p-8 shadow-2xl space-y-6" @click.away="modalProposal = false">
            <div class="flex items-center justify-between border-b border-slate-700 pb-4">
                <h3 class="text-base font-bold text-white flex items-center gap-2">
                    <i class="fa-solid fa-file-contract text-slate-300"></i> Surat Permohonan / Proposal
                </h3>
                <button @click="modalProposal = false" class="text-slate-400 hover:text-white">
                    <i class="fa-solid fa-xmark"></i>
                </button>
            </div>

            <form action="{{ route('admin.letters.store') }}" method="POST" class="space-y-4">
                @csrf
                <input type="hidden" name="jenis_surat" value="PROPOSAL">

                <div>
                    <label class="block text-xs font-bold text-slate-300 uppercase mb-1">Nomor Surat</label>
                    <input type="text" name="nomor_surat" value="{{ \App\Models\Letter::generateNomorSurat('PROPOSAL') }}" required class="w-full px-4 py-2.5 rounded-xl bg-slate-950 border border-slate-800 text-xs font-mono text-slate-300 focus:ring-2 focus:ring-slate-500 outline-none">
                </div>

                <div>
                    <label class="block text-xs font-bold text-slate-300 uppercase mb-1">Tanggal Surat *</label>
                    <input type="date" name="tanggal" value="{{ date('Y-m-d') }}" required class="w-full px-4 py-2.5 rounded-xl bg-slate-950 border border-slate-800 text-xs text-white focus:ring-2 focus:ring-slate-500 outline-none">
                </div>

                <div>
                    <label class="block text-xs font-bold text-slate-300 uppercase mb-1">Prihal / Perihal *</label>
                    <input type="text" name="perihal" value="Permohonan Bantuan Dana Kegiatan Turnamen PWI" required class="w-full px-4 py-2.5 rounded-xl bg-slate-950 border border-slate-800 text-xs text-white focus:ring-2 focus:ring-slate-500 outline-none">
                </div>

                <div class="grid grid-cols-2 gap-3">
                    <div>
                        <label class="block text-xs font-bold text-slate-300 uppercase mb-1">Jabatan Penerima</label>
                        <input type="text" name="jabatan_pejabat" class="w-full px-4 py-2.5 rounded-xl bg-slate-950 border border-slate-800 text-xs text-white focus:ring-2 focus:ring-slate-500 outline-none" placeholder="Direktur / Pimpinan">
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-slate-300 uppercase mb-1">Nama Pejabat *</label>
                        <input type="text" name="nama_pejabat" required class="w-full px-4 py-2.5 rounded-xl bg-slate-950 border border-slate-800 text-xs text-white focus:ring-2 focus:ring-slate-500 outline-none" placeholder="Nama mitra sponsor...">
                    </div>
                </div>

                <div>
                    <label class="block text-xs font-bold text-slate-300 uppercase mb-1">Alamat Tujuan</label>
                    <input type="text" name="alamat_tujuan" class="w-full px-4 py-2.5 rounded-xl bg-slate-950 border border-slate-800 text-xs text-white focus:ring-2 focus:ring-slate-500 outline-none" placeholder="Di Tempat">
                </div>

                <div>
                    <label class="block text-xs font-bold text-slate-300 uppercase mb-1">Isi Permohonan / Pengantar Proposal</label>
                    <textarea name="isi_surat" rows="3" class="w-full px-4 py-2.5 rounded-xl bg-slate-950 border border-slate-800 text-xs text-white focus:ring-2 focus:ring-slate-500 outline-none" placeholder="Tuliskan uraian maksud pengajuan proposal..."></textarea>
                </div>

                <div class="flex items-center justify-end gap-3 pt-4 border-t border-slate-800">
                    <button type="button" @click="modalProposal = false" class="px-4 py-2 rounded-xl text-xs font-semibold text-slate-400 hover:text-white bg-slate-950">Batal</button>
                    <button type="submit" class="px-6 py-2 rounded-xl text-xs font-bold text-white bg-slate-700 hover:bg-slate-600">Simpan Proposal</button>
                </div>
            </form>
        </div>
    </div>

</div>
@endsection
