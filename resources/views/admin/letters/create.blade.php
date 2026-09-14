@extends('layouts.admin')

@section('title', 'Buat Surat Keluar Resmi')
@section('page_title', 'Surat Keluar')

@section('content')
<div class="max-w-5xl mx-auto space-y-6">
    
    <!-- Top Bar Navigation -->
    <div class="flex items-center justify-between">
        <div>
            <h2 class="text-xl font-extrabold text-[#0B132B] dark:text-white tracking-tight">Buat Surat Keluar Baru</h2>
            <p class="text-xs text-slate-500 dark:text-slate-400 mt-1 font-medium">Formulir lengkap penerbitan surat resmi PWI Kabupaten Banyuasin dengan editor visual terpadu</p>
        </div>
        <a href="{{ route('admin.letters.index') }}" class="inline-flex items-center gap-2 px-4 py-2 rounded-xl text-xs font-bold text-slate-700 dark:text-slate-200 bg-white dark:bg-slate-800 border border-slate-300 dark:border-slate-700 hover:bg-slate-50 dark:hover:bg-slate-700 shadow-sm transition-all">
            <i class="fa-solid fa-arrow-left text-xs"></i>
            <span>Kembali ke Register</span>
        </a>
    </div>

    <form action="{{ route('admin.letters.store') }}" method="POST" enctype="multipart/form-data" class="space-y-6"
          x-data="{
              jenis: '{{ old('jenis_surat', $jenis) }}',
              nomors: {{ Js::from($nomorPerJenis) }},
              nomorSurat: '{{ old('nomor_surat', $nomorSurat) }}',
              lampiran: '{{ old('lampiran', $jenis === 'PROPOSAL' ? '1 (Satu) Berkas' : '-') }}',
              tujuanPlaceholder: 'Contoh: Bupati Banyuasin / Kapolres Banyuasin',
              onJenisChange() {
                  if (this.nomors[this.jenis]) {
                      this.nomorSurat = this.nomors[this.jenis];
                  }
                  if (this.jenis === 'PROPOSAL') {
                      this.lampiran = '1 (Satu) Berkas';
                      this.tujuanPlaceholder = 'Contoh: Pimpinan PT Bank Sumsel Babel / Mitra Usaha';
                  } else if (this.jenis === 'SURAT TUGAS') {
                      this.lampiran = '-';
                      this.tujuanPlaceholder = 'Contoh: Pangkalan Balai / Palembang / Instansi Acara';
                  } else {
                      this.lampiran = '-';
                      this.tujuanPlaceholder = 'Contoh: Bupati Banyuasin / Kapolres Banyuasin';
                  }
              }
          }">
        @csrf

        @if ($errors->any())
            <div class="p-4 rounded-2xl bg-rose-50 dark:bg-rose-950/40 border border-rose-200 dark:border-rose-800 text-rose-800 dark:text-rose-300 text-xs space-y-1">
                <div class="font-bold flex items-center gap-2">
                    <i class="fa-solid fa-circle-exclamation text-sm"></i>
                    <span>Terdapat beberapa kesalahan pengisian formulir:</span>
                </div>
                <ul class="list-disc list-inside space-y-0.5 pl-2 font-medium">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <div class="space-y-6">
            
            <!-- CARD 1: IDENTITAS & KEPALA SURAT -->
            <div class="p-6 sm:p-7 rounded-2xl bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800 shadow-sm space-y-5">
                <div class="flex items-center gap-2.5 pb-3 border-b border-slate-100 dark:border-slate-800">
                    <div class="w-8 h-8 rounded-lg bg-blue-100 dark:bg-blue-950 text-blue-600 dark:text-blue-400 flex items-center justify-center text-sm font-bold shrink-0">
                        <i class="fa-solid fa-file-invoice"></i>
                    </div>
                    <div>
                        <h3 class="text-sm font-bold text-slate-900 dark:text-white">1. Identitas & Kepala Surat</h3>
                        <p class="text-[11px] text-slate-500 dark:text-slate-400">Kategori, nomor baku surat resmi, tanggal, lampiran, dan perihal</p>
                    </div>
                </div>

                <!-- Baris 1: Kategori, Nomor, Tanggal -->
                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                    <div>
                        <label class="block text-xs font-bold text-slate-700 dark:text-slate-300 uppercase tracking-wider mb-1.5">
                            Kategori / Jenis Surat *
                        </label>
                        <select name="jenis_surat" x-model="jenis" @change="onJenisChange()" required class="w-full px-4 py-2.5 rounded-xl bg-white dark:bg-slate-950 border border-slate-300 dark:border-slate-700 text-xs font-bold text-slate-900 dark:text-white focus:ring-2 focus:ring-blue-600 outline-none shadow-sm">
                            <option value="SURAT BIASA">SURAT BIASA (Kerjasama, Dinas, Undangan)</option>
                            <option value="PROPOSAL">PROPOSAL (Permohonan Dana, RAB, Sinergi)</option>
                            <option value="SURAT KHUSUS">SURAT KHUSUS (Tanda Tangan Ketua Saja)</option>
                            <option value="SURAT TUGAS">SURAT TUGAS (Surat Perintah Anggota Wartawan)</option>
                            <option value="SURAT AUDENSI">SURAT AUDENSI (Permohonan Audiensi Pemkab)</option>
                        </select>
                        <span class="text-[11px] text-slate-500 mt-1 block">Format nomor akan disesuaikan otomatis saat kategori diubah.</span>
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-slate-700 dark:text-slate-300 uppercase tracking-wider mb-1.5">
                            Nomor Surat Resmi *
                        </label>
                        <input type="text" name="nomor_surat" x-model="nomorSurat" required class="w-full px-4 py-2.5 rounded-xl bg-white dark:bg-slate-950 border border-slate-300 dark:border-slate-700 text-xs font-mono font-bold text-blue-700 dark:text-blue-400 focus:ring-2 focus:ring-blue-600 outline-none shadow-sm">
                        <span class="text-[11px] text-slate-500 mt-1 block">Nomor baku organisasi PWI Kabupaten Banyuasin.</span>
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-slate-700 dark:text-slate-300 uppercase tracking-wider mb-1.5">
                            Tanggal Surat *
                        </label>
                        <input type="date" name="tanggal" value="{{ old('tanggal', date('Y-m-d')) }}" required class="w-full px-4 py-2.5 rounded-xl bg-white dark:bg-slate-950 border border-slate-300 dark:border-slate-700 text-xs font-semibold text-slate-900 dark:text-white focus:ring-2 focus:ring-blue-600 outline-none shadow-sm">
                        <span class="text-[11px] text-slate-500 mt-1 block">Tanggal terbit surat resmi.</span>
                    </div>
                </div>

                <!-- Baris 2: Perihal (col-span-2) & Lampiran (col-span-1) -->
                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                    <div class="md:col-span-2">
                        <label class="block text-xs font-bold text-slate-700 dark:text-slate-300 uppercase tracking-wider mb-1.5">
                            Perihal / Hal Surat *
                        </label>
                        <input type="text" name="perihal" value="{{ old('perihal', $jenis === 'SURAT TUGAS' ? 'Surat Tugas Peliputan' : ($jenis === 'SURAT AUDENSI' ? 'Permohonan Audiensi' : ($jenis === 'PROPOSAL' ? 'Permohonan Bantuan Kerjasama Kegiatan' : 'Permohonan Sinergitas & Kemitraan'))) }}" required class="w-full px-4 py-2.5 rounded-xl bg-white dark:bg-slate-950 border border-slate-300 dark:border-slate-700 text-xs font-semibold text-slate-900 dark:text-white focus:ring-2 focus:ring-blue-600 outline-none shadow-sm" placeholder="Contoh: Rencana Anggaran Biaya (RAB) & Kegiatan Persatuan Wartawan Indonesia">
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-slate-700 dark:text-slate-300 uppercase tracking-wider mb-1.5">
                            Lampiran
                        </label>
                        <input type="text" name="lampiran" x-model="lampiran" class="w-full px-4 py-2.5 rounded-xl bg-white dark:bg-slate-950 border border-slate-300 dark:border-slate-700 text-xs font-semibold text-slate-900 dark:text-white focus:ring-2 focus:ring-blue-600 outline-none shadow-sm" placeholder="- / 1 (Satu) Berkas / Rincian RAB">
                    </div>
                </div>

                <!-- Baris 3: Keperluan / Ringkasan Agenda (Opsional) -->
                <div>
                    <label class="block text-xs font-bold text-slate-700 dark:text-slate-300 uppercase tracking-wider mb-1.5">
                        Keperluan / Ringkasan Agenda (Opsional)
                    </label>
                    <input type="text" name="keperluan" value="{{ old('keperluan') }}" class="w-full px-4 py-2.5 rounded-xl bg-white dark:bg-slate-950 border border-slate-300 dark:border-slate-700 text-xs font-semibold text-slate-900 dark:text-white focus:ring-2 focus:ring-blue-600 outline-none shadow-sm" placeholder="Contoh: Usulan Rencana Anggaran Biaya (RAB) & Kegiatan PWI TA 2027">
                    <span class="text-[11px] text-slate-500 mt-1 block">Catatan ringkas keperluan atau judul agenda untuk register buku surat.</span>
                </div>

                <!-- Banner Khusus: SURAT KHUSUS -->
                <div x-show="jenis === 'SURAT KHUSUS'" x-cloak class="p-3.5 rounded-xl bg-purple-50 dark:bg-purple-950/40 border border-purple-200 dark:border-purple-800/60 text-xs text-purple-900 dark:text-purple-300 flex items-start gap-2.5">
                    <i class="fa-solid fa-stamp text-purple-600 text-sm mt-0.5 shrink-0"></i>
                    <div class="leading-relaxed">
                        <span class="font-bold">Ketentuan Surat Khusus:</span> Dokumen ini hanya ditandatangani oleh Ketua PWI Kabupaten Banyuasin. Kolom tanda tangan Sekretaris ditiadakan secara otomatis pada lembar cetak dan pratinjau.
                    </div>
                </div>
            </div>

            <!-- CARD 2: TUJUAN & PENERIMA SURAT (KEPADA YTH) -->
            <div class="p-6 sm:p-7 rounded-2xl bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800 shadow-sm space-y-5">
                <div class="flex items-center gap-2.5 pb-3 border-b border-slate-100 dark:border-slate-800">
                    <div class="w-8 h-8 rounded-lg bg-indigo-100 dark:bg-indigo-950 text-indigo-600 dark:text-indigo-400 flex items-center justify-center text-sm font-bold shrink-0">
                        <i class="fa-solid fa-envelope-open-text"></i>
                    </div>
                    <div>
                        <h3 class="text-sm font-bold text-slate-900 dark:text-white">2. Tujuan & Penerima Surat (Kepada Yth.)</h3>
                        <p class="text-[11px] text-slate-500 dark:text-slate-400">Instansi penerima, pejabat khusus (c.q.), dan lokasi/alamat tujuan</p>
                    </div>
                </div>

                <!-- Baris 1: Tujuan (kiri) & c.q. Penerima Khusus (kanan) -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-xs font-bold text-slate-700 dark:text-slate-300 uppercase tracking-wider mb-1.5">
                            Tujuan / Instansi / Lembaga Penerima *
                        </label>
                        <textarea name="tujuan" rows="3" required :placeholder="tujuanPlaceholder" class="w-full px-4 py-2.5 rounded-xl bg-white dark:bg-slate-950 border border-slate-300 dark:border-slate-700 text-xs font-semibold text-slate-900 dark:text-white focus:ring-2 focus:ring-indigo-600 outline-none shadow-sm leading-relaxed">{{ old('tujuan') }}</textarea>
                        <span class="text-[11px] text-slate-500 mt-1 block">Tulis nama lembaga/instansi yang dituju. Dapat multiline jika ditujukan ke beberapa pihak.</span>
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-slate-700 dark:text-slate-300 uppercase tracking-wider mb-1.5">
                            c.q. / Penerima Khusus (Opsional)
                        </label>
                        <textarea name="cq" rows="3" class="w-full px-4 py-2.5 rounded-xl bg-white dark:bg-slate-950 border border-slate-300 dark:border-slate-700 text-xs font-semibold text-slate-900 dark:text-white focus:ring-2 focus:ring-indigo-600 outline-none shadow-sm leading-relaxed" placeholder="Contoh: Kepala Badan Pengelolaan Keuangan dan Aset Daerah (BPKAD) / Sekretaris Daerah">{{ old('cq') }}</textarea>
                        <span class="text-[11px] text-slate-500 mt-1 block">Tercetak di bawah tujuan: 'c.q. [Pejabat/Instansi Khusus]'.</span>
                    </div>
                </div>

                <!-- Baris 2: Nama Pejabat (u.p.) & Jabatan Pejabat -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-xs font-bold text-slate-700 dark:text-slate-300 uppercase tracking-wider mb-1.5">
                            Nama Penerima / Pejabat (Opsional)
                        </label>
                        <input type="text" name="nama_pejabat" value="{{ old('nama_pejabat') }}" class="w-full px-4 py-2.5 rounded-xl bg-white dark:bg-slate-950 border border-slate-300 dark:border-slate-700 text-xs font-semibold text-slate-900 dark:text-white focus:ring-2 focus:ring-indigo-600 outline-none shadow-sm" placeholder="Contoh: Dr. H. Askolani, SH., MH (u.p. Pejabat)">
                        <span class="text-[11px] text-slate-500 mt-1 block">Nama pejabat perorangan jika surat ditujukan personal (u.p.).</span>
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-slate-700 dark:text-slate-300 uppercase tracking-wider mb-1.5">
                            Jabatan Pejabat (Opsional)
                        </label>
                        <input type="text" name="jabatan_pejabat" value="{{ old('jabatan_pejabat') }}" class="w-full px-4 py-2.5 rounded-xl bg-white dark:bg-slate-950 border border-slate-300 dark:border-slate-700 text-xs font-semibold text-slate-900 dark:text-white focus:ring-2 focus:ring-indigo-600 outline-none shadow-sm" placeholder="Contoh: Kepala Dinas / Pimpinan Cabang">
                    </div>
                </div>

                <!-- Baris 3: Tempat / Kota Tujuan & Alamat Surat -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-xs font-bold text-slate-700 dark:text-slate-300 uppercase tracking-wider mb-1.5">
                            Tempat / Kota Tujuan *
                        </label>
                        <input type="text" name="tempat_tujuan" value="{{ old('tempat_tujuan', 'Pangkalan Balai') }}" class="w-full px-4 py-2.5 rounded-xl bg-white dark:bg-slate-950 border border-slate-300 dark:border-slate-700 text-xs font-semibold text-slate-900 dark:text-white focus:ring-2 focus:ring-indigo-600 outline-none shadow-sm" placeholder="Contoh: Pangkalan Balai / Di Tempat">
                        <span class="text-[11px] text-slate-500 mt-1 block">Tercetak pada lembar surat: 'di - [Tempat Tujuan]'.</span>
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-slate-700 dark:text-slate-300 uppercase tracking-wider mb-1.5">
                            Alamat Surat (Opsional)
                        </label>
                        <input type="text" name="alamat_tujuan" value="{{ old('alamat_tujuan') }}" class="w-full px-4 py-2.5 rounded-xl bg-white dark:bg-slate-950 border border-slate-300 dark:border-slate-700 text-xs font-semibold text-slate-900 dark:text-white focus:ring-2 focus:ring-indigo-600 outline-none shadow-sm" placeholder="Contoh: Komplek Perkantoran Pemkab Banyuasin No. 1">
                    </div>
                </div>
            </div>

            <!-- PANEL KHUSUS: SURAT TUGAS -->
            <div x-show="jenis === 'SURAT TUGAS'" x-cloak class="p-6 sm:p-7 rounded-2xl bg-cyan-50/70 dark:bg-cyan-950/30 border border-cyan-200 dark:border-cyan-800/60 space-y-4">
                <div class="flex items-center gap-2 text-cyan-800 dark:text-cyan-300 font-bold text-xs uppercase tracking-wider">
                    <i class="fa-solid fa-user-tag text-cyan-600"></i>
                    <span>Rincian Penugasan Anggota Wartawan</span>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div class="md:col-span-2">
                        <label class="block text-xs font-bold text-slate-700 dark:text-slate-300 uppercase tracking-wider mb-1">
                            Pilih Anggota yang Ditugaskan
                        </label>
                        <select name="member_id" class="w-full px-4 py-2.5 rounded-xl bg-white dark:bg-slate-950 border border-slate-300 dark:border-slate-700 text-xs font-semibold text-slate-900 dark:text-white focus:ring-2 focus:ring-cyan-500 outline-none shadow-sm">
                            <option value="">-- Pilih Anggota Wartawan --</option>
                            @foreach($members as $m)
                                <option value="{{ $m->id }}" {{ old('member_id') == $m->id ? 'selected' : '' }}>{{ $m->nama }} ({{ $m->jabatan }})</option>
                            @endforeach
                        </select>
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-slate-700 dark:text-slate-300 uppercase tracking-wider mb-1">
                            Lokasi / Tempat Pelaksanaan
                        </label>
                        <input type="text" name="lokasi" value="{{ old('lokasi') }}" class="w-full px-4 py-2.5 rounded-xl bg-white dark:bg-slate-950 border border-slate-300 dark:border-slate-700 text-xs font-semibold text-slate-900 dark:text-white focus:ring-2 focus:ring-cyan-500 outline-none shadow-sm" placeholder="Contoh: Gedung Banyuasin Convention Center / Serang, Banten">
                    </div>

                    <div class="grid grid-cols-2 gap-3">
                        <div>
                            <label class="block text-xs font-bold text-slate-700 dark:text-slate-300 uppercase tracking-wider mb-1">
                                Tgl Mulai
                            </label>
                            <input type="date" name="tanggal_mulai" value="{{ old('tanggal_mulai') }}" class="w-full px-4 py-2.5 rounded-xl bg-white dark:bg-slate-950 border border-slate-300 dark:border-slate-700 text-xs font-semibold text-slate-900 dark:text-white focus:ring-2 focus:ring-cyan-500 outline-none shadow-sm">
                        </div>
                        <div>
                            <label class="block text-xs font-bold text-slate-700 dark:text-slate-300 uppercase tracking-wider mb-1">
                                Sampai Dengan
                            </label>
                            <input type="date" name="tanggal_selesai" value="{{ old('tanggal_selesai') }}" class="w-full px-4 py-2.5 rounded-xl bg-white dark:bg-slate-950 border border-slate-300 dark:border-slate-700 text-xs font-semibold text-slate-900 dark:text-white focus:ring-2 focus:ring-cyan-500 outline-none shadow-sm">
                        </div>
                    </div>
                </div>
            </div>

            <!-- CARD 3: ISI LENGKAP REDAKSI SURAT -->
            <div class="p-6 sm:p-7 rounded-2xl bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800 shadow-sm space-y-4">
                <div class="flex items-center justify-between pb-3 border-b border-slate-100 dark:border-slate-800">
                    <div class="flex items-center gap-2.5">
                        <div class="w-8 h-8 rounded-lg bg-emerald-100 dark:bg-emerald-950 text-emerald-600 dark:text-emerald-400 flex items-center justify-center text-sm font-bold shrink-0">
                            <i class="fa-solid fa-pen-nib"></i>
                        </div>
                        <div>
                            <h3 class="text-sm font-bold text-slate-900 dark:text-white">3. Isi Redaksi Naskah Dokumen</h3>
                            <p class="text-[11px] text-slate-500 dark:text-slate-400">Ketik atau sunting naskah surat / proposal lengkap dengan format visual</p>
                        </div>
                    </div>
                    <span class="text-[11px] text-emerald-600 dark:text-emerald-400 font-semibold hidden sm:inline-flex items-center gap-1">
                        <i class="fa-solid fa-wand-magic-sparkles text-xs"></i> Editor WYSIWYG Modern PWI
                    </span>
                </div>

                <div>
                    <textarea name="isi_surat" id="isi_surat" rows="12" class="rich-editor w-full px-4 py-3 rounded-xl bg-white dark:bg-slate-950 border border-slate-300 dark:border-slate-700 text-sm leading-relaxed text-slate-900 dark:text-white focus:ring-2 focus:ring-emerald-600 outline-none shadow-sm" placeholder="Tuliskan redaksi isi surat secara lengkap di sini...">{{ old('isi_surat', '<p>Dengan hormat,</p><p>Sehubungan dengan program kerja Persatuan Wartawan Indonesia (PWI) Kabupaten Banyuasin dalam rangka meningkatkan sinergitas pers dan pembangunan daerah, bersama ini kami bermaksud untuk menyampaikan...</p><p>Demikian surat ini kami sampaikan, atas perhatian dan kerjasama yang baik kami ucapkan terima kasih.</p>') }}</textarea>
                </div>
            </div>

            <!-- CARD 4: PENGESAHAN, TEMBUSAN & LAMPIRAN BERKAS -->
            <div class="p-6 sm:p-7 rounded-2xl bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800 shadow-sm space-y-5">
                <div class="flex items-center gap-2.5 pb-3 border-b border-slate-100 dark:border-slate-800">
                    <div class="w-8 h-8 rounded-lg bg-purple-100 dark:bg-purple-950 text-purple-600 dark:text-purple-400 flex items-center justify-center text-sm font-bold shrink-0">
                        <i class="fa-solid fa-stamp"></i>
                    </div>
                    <div>
                        <h3 class="text-sm font-bold text-slate-900 dark:text-white">4. Pengesahan & Tembusan Surat</h3>
                        <p class="text-[11px] text-slate-500 dark:text-slate-400">Penandatangan pimpinan PWI, tembusan naskah, dan unggah berkas pendukung</p>
                    </div>
                </div>

                <!-- Penandatangan Resmi -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-xs font-bold text-slate-700 dark:text-slate-300 uppercase tracking-wider mb-1.5">
                            Penandatangan (Ketua) *
                        </label>
                        <input type="text" name="penandatangan_nama" value="{{ old('penandatangan_nama', $defaultKetua ?? 'Wardoyo, S.I.Kom') }}" required class="w-full px-4 py-2.5 rounded-xl bg-white dark:bg-slate-950 border border-slate-300 dark:border-slate-700 text-xs font-semibold text-slate-900 dark:text-white focus:ring-2 focus:ring-purple-600 outline-none shadow-sm">
                    </div>

                    <div x-show="jenis !== 'SURAT KHUSUS'" x-cloak>
                        <label class="block text-xs font-bold text-slate-700 dark:text-slate-300 uppercase tracking-wider mb-1.5">
                            Penandatangan (Sekretaris)
                        </label>
                        <input type="text" name="penandatangan_sekretaris" value="{{ old('penandatangan_sekretaris', $defaultSekretaris ?? 'Deni Arianto') }}" class="w-full px-4 py-2.5 rounded-xl bg-white dark:bg-slate-950 border border-slate-300 dark:border-slate-700 text-xs font-semibold text-slate-900 dark:text-white focus:ring-2 focus:ring-purple-600 outline-none shadow-sm">
                    </div>
                </div>

                <!-- Tembusan Surat Resmi (Kiri Bawah) -->
                <div>
                    <div class="flex items-center justify-between mb-1.5">
                        <label class="block text-xs font-bold text-slate-700 dark:text-slate-300 uppercase tracking-wider">
                            Tembusan Surat (Kiri Bawah)
                        </label>
                        <span class="text-[11px] text-slate-500 dark:text-slate-400 font-medium">
                            Satu baris per tembusan
                        </span>
                    </div>
                    <textarea name="tembusan" rows="3" class="w-full px-4 py-2.5 rounded-xl bg-white dark:bg-slate-950 border border-slate-300 dark:border-slate-700 text-xs font-mono font-medium text-slate-900 dark:text-white focus:ring-2 focus:ring-purple-600 outline-none shadow-sm leading-relaxed" placeholder="Contoh:&#10;1. Bupati Banyuasin (sebagai laporan)&#10;2. Ketua DPRD Kabupaten Banyuasin&#10;3. Arsip.">{{ old('tembusan', "1. Arsip.") }}</textarea>
                    <span class="text-[11px] text-slate-500 mt-0.5 block">Tercetak di sudut kiri bawah lembar surat. Kosongkan atau isikan '-' jika tidak memerlukan tembusan.</span>
                </div>

                <!-- File Lampiran Berkas Eksternal (Opsional) -->
                <div>
                    <label class="block text-xs font-bold text-slate-700 dark:text-slate-300 uppercase tracking-wider mb-1.5">
                        Unggah Berkas Tambahan / Lampiran Asli (Opsional)
                    </label>
                    <input type="file" name="file_dokumen" accept=".pdf,.doc,.docx" class="w-full px-4 py-2.5 rounded-xl bg-white dark:bg-slate-950 border border-slate-300 dark:border-slate-700 text-xs text-slate-600 dark:text-slate-400 file:mr-3 file:py-1.5 file:px-3 file:rounded-lg file:border-0 file:text-xs file:font-semibold file:bg-purple-600 file:text-white hover:file:bg-purple-700 cursor-pointer">
                    <span class="text-[11px] text-slate-500 mt-1 block">Mendukung berkas PDF atau Microsoft Word (.docx, .doc, Maks. 10 MB).</span>
                </div>
            </div>

            <!-- Tombol Aksi Dokumen -->
            <div class="flex flex-wrap items-center justify-between gap-3 p-5 rounded-2xl bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800 shadow-sm">
                <a href="{{ route('admin.letters.index') }}" class="px-5 py-2.5 rounded-xl text-xs font-bold text-slate-600 dark:text-slate-400 hover:bg-slate-100 dark:hover:bg-slate-800 transition-colors">
                    Batal
                </a>

                <div class="flex items-center gap-2.5">
                    <button type="submit" name="status" value="draft" class="px-5 py-2.5 rounded-xl text-xs font-bold text-amber-700 dark:text-amber-300 bg-amber-50 dark:bg-amber-950/60 border border-amber-300 dark:border-amber-800 hover:bg-amber-100 dark:hover:bg-amber-900/50 shadow-sm transition-all flex items-center gap-2 cursor-pointer">
                        <i class="fa-solid fa-file-pen text-xs"></i>
                        <span>Simpan sebagai Draft</span>
                    </button>

                    <button type="submit" name="status" value="published" class="px-6 py-2.5 rounded-xl text-xs font-bold text-white bg-blue-600 hover:bg-blue-700 shadow-sm transition-all flex items-center gap-2 cursor-pointer">
                        <i class="fa-solid fa-paper-plane text-xs"></i>
                        <span>Publish / Terbitkan Surat</span>
                    </button>
                </div>
            </div>

        </div>
    </form>

</div>
@endsection

@push('scripts')
    @include('partials.rich-editor')
@endpush
