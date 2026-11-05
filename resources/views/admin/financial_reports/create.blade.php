@extends('layouts.admin')

@section('title', 'Buat Laporan Keuangan Kegiatan')
@section('page_title', 'Buat Laporan Keuangan Baru')

@section('content')
<div class="space-y-6 max-w-6xl mx-auto">
    
    <!-- Header -->
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
        <div>
            <h2 class="text-xl font-extrabold text-[#0B132B] dark:text-white">Formulir Laporan Keuangan Kegiatan PWI</h2>
            <p class="text-xs text-slate-600 dark:text-slate-400 mt-1 font-medium">Isi rincian penerimaan dan pengeluaran kegiatan. Penjumlahan total dan saldo akan dihitung secara otomatis.</p>
        </div>
        <a href="{{ route('admin.financial-reports.index') }}" class="inline-flex items-center gap-2 px-4 py-2 rounded-xl text-xs font-bold text-slate-700 bg-white dark:bg-slate-800 dark:text-slate-200 border border-slate-300 dark:border-slate-700 hover:bg-slate-50 shadow-sm transition-all">
            <i class="fa-solid fa-arrow-left"></i>
            <span>Kembali ke Daftar</span>
        </a>
    </div>

    @if ($errors->any())
        <div class="p-4 rounded-xl bg-rose-50 border border-rose-200 text-rose-700 text-xs font-semibold space-y-1">
            <div class="font-bold flex items-center gap-2">
                <i class="fa-solid fa-triangle-exclamation"></i>
                <span>Terdapat kesalahan pada input:</span>
            </div>
            <ul class="list-disc pl-5 space-y-0.5">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('admin.financial-reports.store') }}" method="POST" id="financialForm" class="space-y-6">
        @csrf

        <!-- Card 1: Data Identitas Kegiatan -->
        <div class="p-6 sm:p-8 rounded-2xl bg-white dark:bg-slate-900 border border-slate-300 dark:border-slate-800 shadow-sm space-y-6">
            <div class="border-b border-slate-200 dark:border-slate-800 pb-4 flex items-center gap-3">
                <div class="w-8 h-8 rounded-lg bg-blue-600 text-white flex items-center justify-center text-sm font-bold shadow-sm">
                    1
                </div>
                <div>
                    <h3 class="text-sm font-extrabold text-blue-700 dark:text-emerald-400 uppercase tracking-wider">Identitas & Informasi Kegiatan</h3>
                    <p class="text-xs text-slate-500 dark:text-slate-400">Judul laporan dan tanggal pelaksanaan kegiatan resmi PWI</p>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                <div class="md:col-span-2">
                    <label class="block text-xs font-bold text-slate-700 dark:text-slate-300 uppercase tracking-wider mb-2">
                        Judul Kegiatan *
                    </label>
                    <input type="text" name="judul_kegiatan" value="{{ old('judul_kegiatan', 'LAPORAN PERTANGGUNGJAWABAN KEUANGAN') }}" required class="w-full px-4 py-2.5 rounded-xl bg-white dark:bg-slate-950 border border-slate-300 dark:border-slate-700 text-xs font-semibold text-slate-900 dark:text-white focus:ring-2 focus:ring-blue-600 outline-none shadow-sm" placeholder="Contoh: LAPORAN PERTANGGUNGJAWABAN KEUANGAN">
                </div>

                <div class="md:col-span-2">
                    <label class="block text-xs font-bold text-slate-700 dark:text-slate-300 uppercase tracking-wider mb-2">
                        Lanjutan Nama Kegiatan / Tema Kegiatan (Opsional)
                    </label>
                    <input type="text" name="lanjutan_nama_kegiatan" value="{{ old('lanjutan_nama_kegiatan') }}" class="w-full px-4 py-2.5 rounded-xl bg-white dark:bg-slate-950 border border-slate-300 dark:border-slate-700 text-xs font-semibold text-slate-900 dark:text-white focus:ring-2 focus:ring-blue-600 outline-none shadow-sm" placeholder="Contoh: TURNAMEN MINI SOCCER PIALA PWI KABUPATEN BANYUASIN 2026">
                </div>

                <div>
                    <label class="block text-xs font-bold text-slate-700 dark:text-slate-300 uppercase tracking-wider mb-2">
                        Hari / Tanggal / Periode Kegiatan
                    </label>
                    <input type="text" name="hari_tanggal" value="{{ old('hari_tanggal') }}" class="w-full px-4 py-2.5 rounded-xl bg-white dark:bg-slate-950 border border-slate-300 dark:border-slate-700 text-xs font-semibold text-slate-900 dark:text-white focus:ring-2 focus:ring-blue-600 outline-none shadow-sm" placeholder="Contoh: Senin, 10 - 15 Agustus 2026">
                </div>

                <div>
                    <label class="block text-xs font-bold text-slate-700 dark:text-slate-300 uppercase tracking-wider mb-2">
                        Lokasi / Tempat Kegiatan (Opsional)
                    </label>
                    <input type="text" name="tempat" value="{{ old('tempat', 'Pangkalan Balai') }}" class="w-full px-4 py-2.5 rounded-xl bg-white dark:bg-slate-950 border border-slate-300 dark:border-slate-700 text-xs font-semibold text-slate-900 dark:text-white focus:ring-2 focus:ring-blue-600 outline-none shadow-sm" placeholder="Contoh: Lapangan Sedulang Setudung Pangkalan Balai">
                </div>
            </div>
        </div>

        <!-- Live Summary Banner -->
        <div class="p-6 rounded-2xl bg-gradient-to-r from-blue-900 to-[#0B132B] text-white shadow-md border border-blue-800 flex flex-col md:flex-row items-center justify-between gap-6">
            <div class="flex items-center gap-4">
                <div class="w-12 h-12 rounded-2xl bg-white/10 flex items-center justify-center text-xl text-amber-400">
                    <i class="fa-solid fa-calculator"></i>
                </div>
                <div>
                    <div class="text-[11px] font-bold text-amber-400 uppercase tracking-wider">Perhitungan Saldo Otomatis</div>
                    <div class="text-sm font-semibold text-slate-200">Total penerimaan dan pengeluaran dikalkulasi secara otomatis *real-time*</div>
                </div>
            </div>

            <div class="grid grid-cols-3 gap-6 text-center w-full md:w-auto">
                <div>
                    <div class="text-[10px] text-slate-300 font-bold uppercase">Total Penerimaan</div>
                    <div class="text-base font-extrabold text-emerald-400 mt-1" id="livePenerimaan">Rp 0</div>
                </div>
                <div>
                    <div class="text-[10px] text-slate-300 font-bold uppercase">Total Pengeluaran</div>
                    <div class="text-base font-extrabold text-rose-400 mt-1" id="livePengeluaran">Rp 0</div>
                </div>
                <div>
                    <div class="text-[10px] text-slate-300 font-bold uppercase">Saldo Akhir</div>
                    <div class="text-base font-extrabold text-cyan-300 mt-1" id="liveSaldo">Rp 0</div>
                </div>
            </div>
        </div>

        <!-- Card 2: Rincian Penerimaan & Pengeluaran (Side by Side) -->
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
            
            <!-- Sisi Kiri: PENERIMAAN -->
            <div class="p-6 rounded-2xl bg-white dark:bg-slate-900 border border-emerald-300 dark:border-emerald-950/60 shadow-sm space-y-4">
                <div class="flex items-center justify-between border-b border-emerald-100 dark:border-emerald-900/40 pb-3">
                    <div class="flex items-center gap-2">
                        <span class="w-3 h-3 rounded-full bg-emerald-500"></span>
                        <h3 class="text-sm font-extrabold text-emerald-700 dark:text-emerald-400 uppercase tracking-wider">Penerimaan (Kas Masuk)</h3>
                    </div>
                    <button type="button" onclick="addRow('penerimaan')" class="px-3 py-1.5 rounded-lg text-xs font-bold text-white bg-emerald-600 hover:bg-emerald-700 shadow-sm transition-all flex items-center gap-1.5">
                        <i class="fa-solid fa-plus text-[10px]"></i>
                        <span>Tambah Baris</span>
                    </button>
                </div>

                <div class="overflow-x-auto">
                    <table class="w-full text-xs" id="tablePenerimaan">
                        <thead>
                            <tr class="text-slate-500 dark:text-slate-400 uppercase text-[10px] border-b border-slate-200 dark:border-slate-800">
                                <th class="py-2 px-1 text-center w-8">#</th>
                                <th class="py-2 px-2 text-left w-28">Tanggal</th>
                                <th class="py-2 px-2 text-left">Uraian Penerimaan</th>
                                <th class="py-2 px-2 text-right w-36">Jumlah (Rp)</th>
                                <th class="py-2 px-1 text-center w-8"></th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100 dark:divide-slate-800/60" id="bodyPenerimaan">
                            <!-- Default 3 empty rows -->
                            <tr class="row-penerimaan">
                                <td class="py-2 text-center text-slate-400 row-num">1</td>
                                <td class="py-2 px-1">
                                    <input type="text" name="penerimaan[0][tanggal]" class="w-full px-2 py-1.5 rounded-lg border border-slate-300 dark:border-slate-700 bg-white dark:bg-slate-950 text-xs" placeholder="Tgl">
                                </td>
                                <td class="py-2 px-1">
                                    <input type="text" name="penerimaan[0][uraian]" class="w-full px-2 py-1.5 rounded-lg border border-slate-300 dark:border-slate-700 bg-white dark:bg-slate-950 text-xs font-medium" placeholder="Uraian kas masuk...">
                                </td>
                                <td class="py-2 px-1">
                                    <input type="text" name="penerimaan[0][jumlah]" oninput="formatAndCalc(this)" class="w-full px-2 py-1.5 rounded-lg border border-slate-300 dark:border-slate-700 bg-white dark:bg-slate-950 text-xs font-bold text-right text-emerald-600 dark:text-emerald-400 input-jumlah-penerimaan" placeholder="0">
                                </td>
                                <td class="py-2 text-center">
                                    <button type="button" onclick="deleteRow(this, 'penerimaan')" class="text-rose-500 hover:text-rose-700 p-1">
                                        <i class="fa-solid fa-trash-can text-xs"></i>
                                    </button>
                                </td>
                            </tr>
                            <tr class="row-penerimaan">
                                <td class="py-2 text-center text-slate-400 row-num">2</td>
                                <td class="py-2 px-1">
                                    <input type="text" name="penerimaan[1][tanggal]" class="w-full px-2 py-1.5 rounded-lg border border-slate-300 dark:border-slate-700 bg-white dark:bg-slate-950 text-xs" placeholder="Tgl">
                                </td>
                                <td class="py-2 px-1">
                                    <input type="text" name="penerimaan[1][uraian]" class="w-full px-2 py-1.5 rounded-lg border border-slate-300 dark:border-slate-700 bg-white dark:bg-slate-950 text-xs font-medium" placeholder="Uraian kas masuk...">
                                </td>
                                <td class="py-2 px-1">
                                    <input type="text" name="penerimaan[1][jumlah]" oninput="formatAndCalc(this)" class="w-full px-2 py-1.5 rounded-lg border border-slate-300 dark:border-slate-700 bg-white dark:bg-slate-950 text-xs font-bold text-right text-emerald-600 dark:text-emerald-400 input-jumlah-penerimaan" placeholder="0">
                                </td>
                                <td class="py-2 text-center">
                                    <button type="button" onclick="deleteRow(this, 'penerimaan')" class="text-rose-500 hover:text-rose-700 p-1">
                                        <i class="fa-solid fa-trash-can text-xs"></i>
                                    </button>
                                </td>
                            </tr>
                        </tbody>
                        <tfoot>
                            <tr class="border-t-2 border-slate-300 dark:border-slate-700 bg-emerald-50/50 dark:bg-emerald-950/20 font-bold">
                                <td colspan="3" class="py-2.5 px-3 text-right uppercase text-slate-700 dark:text-slate-300">Subtotal Penerimaan:</td>
                                <td class="py-2.5 px-2 text-right text-emerald-700 dark:text-emerald-400 font-extrabold text-sm" id="subtotalPenerimaan">Rp 0</td>
                                <td></td>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>

            <!-- Sisi Kanan: PENGELUARAN -->
            <div class="p-6 rounded-2xl bg-white dark:bg-slate-900 border border-rose-300 dark:border-rose-950/60 shadow-sm space-y-4">
                <div class="flex items-center justify-between border-b border-rose-100 dark:border-rose-900/40 pb-3">
                    <div class="flex items-center gap-2">
                        <span class="w-3 h-3 rounded-full bg-rose-500"></span>
                        <h3 class="text-sm font-extrabold text-rose-700 dark:text-rose-400 uppercase tracking-wider">Pengeluaran (Kas Keluar)</h3>
                    </div>
                    <button type="button" onclick="addRow('pengeluaran')" class="px-3 py-1.5 rounded-lg text-xs font-bold text-white bg-rose-600 hover:bg-rose-700 shadow-sm transition-all flex items-center gap-1.5">
                        <i class="fa-solid fa-plus text-[10px]"></i>
                        <span>Tambah Baris</span>
                    </button>
                </div>

                <div class="overflow-x-auto">
                    <table class="w-full text-xs" id="tablePengeluaran">
                        <thead>
                            <tr class="text-slate-500 dark:text-slate-400 uppercase text-[10px] border-b border-slate-200 dark:border-slate-800">
                                <th class="py-2 px-1 text-center w-8">#</th>
                                <th class="py-2 px-2 text-left w-28">Tanggal</th>
                                <th class="py-2 px-2 text-left">Uraian Pengeluaran</th>
                                <th class="py-2 px-2 text-right w-36">Jumlah (Rp)</th>
                                <th class="py-2 px-1 text-center w-8"></th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100 dark:divide-slate-800/60" id="bodyPengeluaran">
                            <!-- Default 3 empty rows -->
                            <tr class="row-pengeluaran">
                                <td class="py-2 text-center text-slate-400 row-num">1</td>
                                <td class="py-2 px-1">
                                    <input type="text" name="pengeluaran[0][tanggal]" class="w-full px-2 py-1.5 rounded-lg border border-slate-300 dark:border-slate-700 bg-white dark:bg-slate-950 text-xs" placeholder="Tgl">
                                </td>
                                <td class="py-2 px-1">
                                    <input type="text" name="pengeluaran[0][uraian]" class="w-full px-2 py-1.5 rounded-lg border border-slate-300 dark:border-slate-700 bg-white dark:bg-slate-950 text-xs font-medium" placeholder="Uraian belanja/biaya...">
                                </td>
                                <td class="py-2 px-1">
                                    <input type="text" name="pengeluaran[0][jumlah]" oninput="formatAndCalc(this)" class="w-full px-2 py-1.5 rounded-lg border border-slate-300 dark:border-slate-700 bg-white dark:bg-slate-950 text-xs font-bold text-right text-rose-600 dark:text-rose-400 input-jumlah-pengeluaran" placeholder="0">
                                </td>
                                <td class="py-2 text-center">
                                    <button type="button" onclick="deleteRow(this, 'pengeluaran')" class="text-rose-500 hover:text-rose-700 p-1">
                                        <i class="fa-solid fa-trash-can text-xs"></i>
                                    </button>
                                </td>
                            </tr>
                            <tr class="row-pengeluaran">
                                <td class="py-2 text-center text-slate-400 row-num">2</td>
                                <td class="py-2 px-1">
                                    <input type="text" name="pengeluaran[1][tanggal]" class="w-full px-2 py-1.5 rounded-lg border border-slate-300 dark:border-slate-700 bg-white dark:bg-slate-950 text-xs" placeholder="Tgl">
                                </td>
                                <td class="py-2 px-1">
                                    <input type="text" name="pengeluaran[1][uraian]" class="w-full px-2 py-1.5 rounded-lg border border-slate-300 dark:border-slate-700 bg-white dark:bg-slate-950 text-xs font-medium" placeholder="Uraian belanja/biaya...">
                                </td>
                                <td class="py-2 px-1">
                                    <input type="text" name="pengeluaran[1][jumlah]" oninput="formatAndCalc(this)" class="w-full px-2 py-1.5 rounded-lg border border-slate-300 dark:border-slate-700 bg-white dark:bg-slate-950 text-xs font-bold text-right text-rose-600 dark:text-rose-400 input-jumlah-pengeluaran" placeholder="0">
                                </td>
                                <td class="py-2 text-center">
                                    <button type="button" onclick="deleteRow(this, 'pengeluaran')" class="text-rose-500 hover:text-rose-700 p-1">
                                        <i class="fa-solid fa-trash-can text-xs"></i>
                                    </button>
                                </td>
                            </tr>
                        </tbody>
                        <tfoot>
                            <tr class="border-t-2 border-slate-300 dark:border-slate-700 bg-rose-50/50 dark:bg-rose-950/20 font-bold">
                                <td colspan="3" class="py-2.5 px-3 text-right uppercase text-slate-700 dark:text-slate-300">Subtotal Pengeluaran:</td>
                                <td class="py-2.5 px-2 text-right text-rose-700 dark:text-rose-400 font-extrabold text-sm" id="subtotalPengeluaran">Rp 0</td>
                                <td></td>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>

        </div>

        <!-- Card 3: Penandatangan Resmi (Ketua & Bendahara) -->
        <div class="p-6 sm:p-8 rounded-2xl bg-white dark:bg-slate-900 border border-slate-300 dark:border-slate-800 shadow-sm space-y-6">
            <div class="border-b border-slate-200 dark:border-slate-800 pb-4 flex items-center gap-3">
                <div class="w-8 h-8 rounded-lg bg-blue-600 text-white flex items-center justify-center text-sm font-bold shadow-sm">
                    2
                </div>
                <div>
                    <h3 class="text-sm font-extrabold text-blue-700 dark:text-emerald-400 uppercase tracking-wider">Lembar Tanda Tangan Resmi</h3>
                    <p class="text-xs text-slate-500 dark:text-slate-400">Pengesahan oleh Ketua PWI Banyuasin dan Bendahara Pengeluaran</p>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Kolom Tanggal & Tempat TTD -->
                <div class="md:col-span-2">
                    <label class="block text-xs font-bold text-slate-700 dark:text-slate-300 uppercase tracking-wider mb-2">
                        Tempat dan Tanggal Tanda Tangan
                    </label>
                    <input type="text" name="tempat_tanggal_ttd" value="{{ old('tempat_tanggal_ttd', $defaultTtdDate) }}" class="w-full px-4 py-2.5 rounded-xl bg-white dark:bg-slate-950 border border-slate-300 dark:border-slate-700 text-xs font-semibold text-slate-900 dark:text-white focus:ring-2 focus:ring-blue-600 outline-none shadow-sm" placeholder="Contoh: Pangkalan Balai, 15 Agustus 2026">
                </div>

                <!-- Pihak Mengetahui (Ketua) -->
                <div class="p-4 rounded-xl bg-slate-50 dark:bg-slate-950 border border-slate-200 dark:border-slate-800 space-y-4">
                    <div class="text-xs font-bold text-slate-700 dark:text-slate-300 uppercase tracking-wider flex items-center gap-2">
                        <i class="fa-solid fa-signature text-blue-600"></i>
                        <span>Pihak Mengetahui (Kiri)</span>
                    </div>

                    <div>
                        <label class="block text-[11px] font-semibold text-slate-600 dark:text-slate-400 mb-1">Nama Ketua *</label>
                        <input type="text" name="nama_mengetahui" value="{{ old('nama_mengetahui', 'Wardoyo, S.I.Kom') }}" required class="w-full px-3 py-2 rounded-lg bg-white dark:bg-slate-900 border border-slate-300 dark:border-slate-700 text-xs font-bold text-slate-900 dark:text-white">
                    </div>

                    <div>
                        <label class="block text-[11px] font-semibold text-slate-600 dark:text-slate-400 mb-1">Jabatan *</label>
                        <input type="text" name="jabatan_mengetahui" value="{{ old('jabatan_mengetahui', 'Ketua PWI Banyuasin') }}" required class="w-full px-3 py-2 rounded-lg bg-white dark:bg-slate-900 border border-slate-300 dark:border-slate-700 text-xs text-slate-900 dark:text-white">
                    </div>
                </div>

                <!-- Pihak Bendahara (Kanan) -->
                <div class="p-4 rounded-xl bg-slate-50 dark:bg-slate-950 border border-slate-200 dark:border-slate-800 space-y-4">
                    <div class="text-xs font-bold text-slate-700 dark:text-slate-300 uppercase tracking-wider flex items-center gap-2">
                        <i class="fa-solid fa-file-invoice text-emerald-600"></i>
                        <span>Pihak Bendahara (Kanan)</span>
                    </div>

                    <div>
                        <label class="block text-[11px] font-semibold text-slate-600 dark:text-slate-400 mb-1">Nama Bendahara *</label>
                        <input type="text" name="nama_bendahara" value="{{ old('nama_bendahara', 'Ridho Andi Sucipto, M.Pd') }}" required class="w-full px-3 py-2 rounded-lg bg-white dark:bg-slate-900 border border-slate-300 dark:border-slate-700 text-xs font-bold text-slate-900 dark:text-white">
                    </div>

                    <div>
                        <label class="block text-[11px] font-semibold text-slate-600 dark:text-slate-400 mb-1">Jabatan *</label>
                        <input type="text" name="jabatan_bendahara" value="{{ old('jabatan_bendahara', 'Bendahara') }}" required class="w-full px-3 py-2 rounded-lg bg-white dark:bg-slate-900 border border-slate-300 dark:border-slate-700 text-xs text-slate-900 dark:text-white">
                    </div>
                </div>

                <!-- Catatan Tambahan (Opsional) -->
                <div class="md:col-span-2">
                    <label class="block text-xs font-bold text-slate-700 dark:text-slate-300 uppercase tracking-wider mb-2">
                        Catatan Kaki Tambahan (Opsional)
                    </label>
                    <textarea name="keterangan" rows="3" class="w-full px-4 py-2.5 rounded-xl bg-white dark:bg-slate-950 border border-slate-300 dark:border-slate-700 text-xs text-slate-900 dark:text-white focus:ring-2 focus:ring-blue-600 outline-none shadow-sm" placeholder="Tambahkan catatan khusus, lampiran bukti nota kwitansi, atau keterangan saldo kas...">{{ old('keterangan') }}</textarea>
                </div>
            </div>
        </div>

        <!-- Submit Bar -->
        <div class="flex items-center justify-end gap-3 pt-4 border-t border-slate-200 dark:border-slate-800">
            <a href="{{ route('admin.financial-reports.index') }}" class="px-5 py-2.5 rounded-xl text-xs font-bold text-slate-600 dark:text-slate-400 hover:bg-slate-100 dark:hover:bg-slate-800 transition-all">
                Batal
            </a>
            <button type="submit" class="px-6 py-2.5 rounded-xl text-xs font-bold text-white bg-blue-600 hover:bg-blue-700 dark:bg-emerald-500 dark:hover:bg-emerald-400 dark:text-slate-950 shadow-md transition-all flex items-center gap-2">
                <i class="fa-solid fa-floppy-disk"></i>
                <span>Simpan Laporan Keuangan</span>
            </button>
        </div>
    </form>

</div>

<script>
    let pIdx = 10;
    let kIdx = 10;

    function addRow(type) {
        const tbody = document.getElementById(type === 'penerimaan' ? 'bodyPenerimaan' : 'bodyPengeluaran');
        const count = tbody.querySelectorAll('tr').length + 1;
        const index = type === 'penerimaan' ? pIdx++ : kIdx++;
        const colorClass = type === 'penerimaan' ? 'text-emerald-600 dark:text-emerald-400 input-jumlah-penerimaan' : 'text-rose-600 dark:text-rose-400 input-jumlah-pengeluaran';

        const tr = document.createElement('tr');
        tr.className = `row-${type}`;
        tr.innerHTML = `
            <td class="py-2 text-center text-slate-400 row-num">${count}</td>
            <td class="py-2 px-1">
                <input type="text" name="${type}[${index}][tanggal]" class="w-full px-2 py-1.5 rounded-lg border border-slate-300 dark:border-slate-700 bg-white dark:bg-slate-950 text-xs" placeholder="Tgl">
            </td>
            <td class="py-2 px-1">
                <input type="text" name="${type}[${index}][uraian]" class="w-full px-2 py-1.5 rounded-lg border border-slate-300 dark:border-slate-700 bg-white dark:bg-slate-950 text-xs font-medium" placeholder="Uraian...">
            </td>
            <td class="py-2 px-1">
                <input type="text" name="${type}[${index}][jumlah]" oninput="formatAndCalc(this)" class="w-full px-2 py-1.5 rounded-lg border border-slate-300 dark:border-slate-700 bg-white dark:bg-slate-950 text-xs font-bold text-right ${colorClass}" placeholder="0">
            </td>
            <td class="py-2 text-center">
                <button type="button" onclick="deleteRow(this, '${type}')" class="text-rose-500 hover:text-rose-700 p-1">
                    <i class="fa-solid fa-trash-can text-xs"></i>
                </button>
            </td>
        `;
        tbody.appendChild(tr);
        recalc();
    }

    function deleteRow(btn, type) {
        const row = btn.closest('tr');
        const tbody = row.parentElement;
        if (tbody.querySelectorAll('tr').length <= 1) {
            // Clear values instead of removing last row
            row.querySelectorAll('input').forEach(i => i.value = '');
        } else {
            row.remove();
        }
        reindex(tbody);
        recalc();
    }

    function reindex(tbody) {
        tbody.querySelectorAll('tr').forEach((r, i) => {
            const numCell = r.querySelector('.row-num');
            if (numCell) numCell.textContent = i + 1;
        });
    }

    function formatNumber(n) {
        return new Intl.NumberFormat('id-ID').format(n);
    }

    function parseAmount(val) {
        if (!val) return 0;
        const cleaned = val.toString().replace(/[^0-9]/g, '');
        return cleaned ? parseFloat(cleaned) : 0;
    }

    function formatAndCalc(input) {
        const raw = parseAmount(input.value);
        if (raw > 0) {
            input.value = formatNumber(raw);
        } else if (input.value.trim() === '0') {
            input.value = '0';
        }
        recalc();
    }

    function recalc() {
        let totalP = 0;
        document.querySelectorAll('.input-jumlah-penerimaan').forEach(el => {
            totalP += parseAmount(el.value);
        });

        let totalK = 0;
        document.querySelectorAll('.input-jumlah-pengeluaran').forEach(el => {
            totalK += parseAmount(el.value);
        });

        const saldo = totalP - totalK;

        document.getElementById('subtotalPenerimaan').textContent = 'Rp ' + formatNumber(totalP);
        document.getElementById('subtotalPengeluaran').textContent = 'Rp ' + formatNumber(totalK);

        document.getElementById('livePenerimaan').textContent = 'Rp ' + formatNumber(totalP);
        document.getElementById('livePengeluaran').textContent = 'Rp ' + formatNumber(totalK);
        
        const liveSaldo = document.getElementById('liveSaldo');
        liveSaldo.textContent = 'Rp ' + formatNumber(saldo);
        if (saldo >= 0) {
            liveSaldo.className = 'text-base font-extrabold text-cyan-300 mt-1';
        } else {
            liveSaldo.className = 'text-base font-extrabold text-rose-400 mt-1';
        }
    }

    // Run on init
    document.addEventListener('DOMContentLoaded', recalc);
</script>
@endsection

