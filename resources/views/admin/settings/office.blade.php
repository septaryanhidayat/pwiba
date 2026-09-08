@extends('layouts.admin')

@section('title', 'Data Kantor & Identitas PWI')
@section('page_title', 'Pengaturan Data PWI')

@section('content')
<div class="max-w-4xl mx-auto space-y-6" x-data="{
    currentLogo: '{{ $settings['logo_url'] ?? asset('assets/images/pwi-logo.webp') }}',
    previewUrl: null,
    removeLogo: false,
    hasCustomLogo: {{ !empty($settings['logo']) ? 'true' : 'false' }},
    handleFile(e) {
        const file = e.target.files[0];
        if (file) {
            this.previewUrl = URL.createObjectURL(file);
            this.removeLogo = false;
        }
    },
    resetToDefault() {
        this.removeLogo = true;
        this.previewUrl = '{{ asset('assets/images/pwi-logo.webp') }}';
        if (this.$refs.logoInput) this.$refs.logoInput.value = '';
    },
    cancelReset() {
        this.removeLogo = false;
        this.previewUrl = null;
    }
}">
    
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-3">
        <div>
            <h2 class="text-xl font-extrabold text-[#0B132B] dark:text-white">Pengaturan Identitas Kantor PWI</h2>
            <p class="text-xs text-slate-600 dark:text-slate-400 mt-1 font-medium">
                Pusat data terintegrasi: Edit di sini sekali, otomatis berubah di seluruh halaman website publik, bagan struktur, dan kop surat resmi cetak.
            </p>
        </div>
        <div class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-xl bg-blue-50 text-blue-700 dark:bg-blue-950/60 dark:text-blue-300 border border-blue-200 dark:border-blue-900/40 text-xs font-bold self-start sm:self-auto">
            <i class="fa-solid fa-arrows-rotate"></i>
            <span>Sinkronisasi Otomatis Aktif</span>
        </div>
    </div>

    @if(session('success'))
        <div class="p-4 rounded-2xl bg-emerald-50 dark:bg-emerald-950/50 border border-emerald-200 dark:border-emerald-800/60 flex items-center gap-3 text-emerald-800 dark:text-emerald-200 text-xs font-bold shadow-xs">
            <i class="fa-solid fa-circle-check text-emerald-600 text-base"></i>
            <span>{{ session('success') }}</span>
        </div>
    @endif

    @if($errors->any())
        <div class="p-4 rounded-2xl bg-rose-50 dark:bg-rose-950/50 border border-rose-200 dark:border-rose-800/60 text-rose-800 dark:text-rose-200 text-xs font-bold space-y-1">
            <div class="flex items-center gap-2 mb-1 text-sm font-extrabold">
                <i class="fa-solid fa-circle-exclamation text-rose-600"></i>
                <span>Terdapat kesalahan pengisian:</span>
            </div>
            <ul class="list-disc list-inside space-y-0.5 text-xs font-normal">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('admin.settings.office.update') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
        @csrf

        <div class="p-6 sm:p-8 rounded-2xl bg-white dark:bg-slate-900 border border-slate-300 dark:border-slate-800 shadow-sm space-y-6">
            
            <!-- SECTION 1: LOGO ORGANISASI -->
            <div class="pb-6 border-b border-slate-200 dark:border-slate-800 space-y-4">
                <div class="flex items-center justify-between">
                    <div>
                        <h3 class="text-sm font-bold text-slate-900 dark:text-white flex items-center gap-2">
                            <i class="fa-solid fa-image text-blue-600"></i>
                            <span>Logo Resmi Organisasi</span>
                        </h3>
                        <p class="text-xs text-slate-500 dark:text-slate-400 mt-0.5">
                            Logo ini ditampilkan di Navbar, Footer, Bagan Struktur Organisasi, Lembar Surat Tugas, dan Kop Surat Resmi.
                        </p>
                    </div>
                </div>

                <div class="flex flex-col sm:flex-row items-center gap-6 p-4 rounded-xl bg-slate-50 dark:bg-slate-950/60 border border-slate-200 dark:border-slate-800">
                    <!-- Logo Preview Box -->
                    <div class="relative w-28 h-28 rounded-2xl bg-white dark:bg-slate-900 border-2 border-dashed border-slate-300 dark:border-slate-700 flex items-center justify-center p-2.5 flex-shrink-0 shadow-inner group">
                        <img :src="previewUrl || currentLogo" 
                             alt="Pratinjau Logo PWI" 
                             class="max-w-full max-h-full object-contain drop-shadow-sm transition-transform duration-200 group-hover:scale-105">
                    </div>

                    <!-- Upload Controls & Info -->
                    <div class="flex-1 space-y-2.5 text-center sm:text-left">
                        <div class="flex flex-wrap items-center justify-center sm:justify-start gap-2">
                            <label class="cursor-pointer inline-flex items-center gap-2 px-4 py-2 rounded-xl bg-blue-600 hover:bg-blue-700 text-white text-xs font-bold transition-all shadow-xs">
                                <i class="fa-solid fa-cloud-arrow-up"></i>
                                <span>Pilih File Logo Baru</span>
                                <input type="file" 
                                       name="logo" 
                                       x-ref="logoInput"
                                       @change="handleFile($event)" 
                                       accept="image/png,image/jpeg,image/webp,image/svg+xml" 
                                       class="hidden">
                            </label>

                            <template x-if="hasCustomLogo && !removeLogo">
                                <button type="button" 
                                        @click="resetToDefault()" 
                                        class="inline-flex items-center gap-1.5 px-3 py-2 rounded-xl bg-rose-50 hover:bg-rose-100 text-rose-700 dark:bg-rose-950/50 dark:hover:bg-rose-900/60 dark:text-rose-300 text-xs font-bold border border-rose-200 dark:border-rose-900/40 transition-all">
                                    <i class="fa-solid fa-trash-can"></i>
                                    <span>Hapus & Gunakan Logo Standar</span>
                                </button>
                            </template>

                            <template x-if="removeLogo">
                                <div class="inline-flex items-center gap-2">
                                    <span class="text-[11px] font-bold text-amber-600 dark:text-amber-400">
                                        <i class="fa-solid fa-circle-exclamation"></i> Akan kembali ke logo bawaan PWI
                                    </span>
                                    <button type="button" 
                                            @click="cancelReset()" 
                                            class="text-xs text-blue-600 hover:underline font-bold">
                                        Batal
                                    </button>
                                </div>
                            </template>
                        </div>

                        <!-- Hidden input for remove_logo flag -->
                        <input type="hidden" name="remove_logo" :value="removeLogo ? '1' : '0'">

                        <p class="text-[11px] text-slate-500 dark:text-slate-400 leading-relaxed">
                            Format yang didukung: <strong>PNG (disarankan transparan), WEBP, JPG, atau SVG</strong>. Ukuran maksimum 3MB. Rasio optimal kotak (1:1).
                        </p>
                    </div>
                </div>
            </div>

            <!-- SECTION 2: IDENTITAS DAN ALAMAT KANTOR -->
            <div class="space-y-4">
                <h3 class="text-sm font-bold text-slate-900 dark:text-white flex items-center gap-2">
                    <i class="fa-solid fa-building text-blue-600"></i>
                    <span>Informasi Kantor & Kontak Organisasi</span>
                </h3>

                <div>
                    <label class="block text-xs font-bold text-slate-700 dark:text-slate-300 uppercase tracking-wider mb-1.5">Nama Organisasi *</label>
                    <input type="text" 
                           name="nama_pwi" 
                           value="{{ old('nama_pwi', $settings['nama_pwi'] ?? 'PWI Kabupaten Banyuasin') }}" 
                           required 
                           class="w-full px-4 py-3 rounded-xl bg-white dark:bg-slate-950 border border-slate-300 dark:border-slate-700 text-sm font-semibold text-slate-900 dark:text-white focus:ring-2 focus:ring-blue-600 outline-none shadow-sm">
                </div>

                <div>
                    <label class="block text-xs font-bold text-slate-700 dark:text-slate-300 uppercase tracking-wider mb-1.5">Alamat Lengkap Kantor Sekretariat *</label>
                    <textarea name="alamat_kantor" 
                              rows="3" 
                              required 
                              class="w-full px-4 py-3 rounded-xl bg-white dark:bg-slate-950 border border-slate-300 dark:border-slate-700 text-sm font-semibold text-slate-900 dark:text-white focus:ring-2 focus:ring-blue-600 outline-none shadow-sm leading-relaxed">{{ old('alamat_kantor', $settings['alamat_kantor'] ?? 'Jalan Merdeka NO 3 RT 02 RW 02 Kelurahan Mulya Agung Kecamatan Banyuasin III Kabupaten Banyuasin - Sumatera Selatan (30914)') }}</textarea>
                    <p class="text-[11px] text-slate-400 mt-1">Alamat ini otomatis tampil di footer website, kontak publik, dan kop surat resmi.</p>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-xs font-bold text-slate-700 dark:text-slate-300 uppercase tracking-wider mb-1.5">Kota / Wilayah *</label>
                        <input type="text" 
                               name="kota" 
                               value="{{ old('kota', $settings['kota'] ?? 'Pangkalan Balai') }}" 
                               required 
                               class="w-full px-4 py-2.5 rounded-xl bg-white dark:bg-slate-950 border border-slate-300 dark:border-slate-700 text-xs font-semibold text-slate-900 dark:text-white focus:ring-2 focus:ring-blue-600 outline-none shadow-sm">
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-slate-700 dark:text-slate-300 uppercase tracking-wider mb-1.5">No. Telepon / WhatsApp Sekretariat *</label>
                        <input type="text" 
                               name="no_telp" 
                               value="{{ old('no_telp', $settings['no_telp'] ?? '0853-7799-1976') }}" 
                               required 
                               class="w-full px-4 py-2.5 rounded-xl bg-white dark:bg-slate-950 border border-slate-300 dark:border-slate-700 text-xs font-semibold text-slate-900 dark:text-white focus:ring-2 focus:ring-blue-600 outline-none shadow-sm">
                    </div>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-xs font-bold text-slate-700 dark:text-slate-300 uppercase tracking-wider mb-1.5">Email Resmi Organisasi *</label>
                        <input type="email" 
                               name="email" 
                               value="{{ old('email', $settings['email'] ?? 'sekretariat@pwiba.or.id') }}" 
                               required
                               class="w-full px-4 py-2.5 rounded-xl bg-white dark:bg-slate-950 border border-slate-300 dark:border-slate-700 text-xs font-semibold text-slate-900 dark:text-white focus:ring-2 focus:ring-blue-600 outline-none shadow-sm">
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-slate-700 dark:text-slate-300 uppercase tracking-wider mb-1.5">Nama Ketua PWI</label>
                        <input type="text" 
                               name="ketua_nama" 
                               value="{{ old('ketua_nama', $settings['ketua_nama'] ?? 'Wardoyo, S.I.Kom') }}" 
                               class="w-full px-4 py-2.5 rounded-xl bg-white dark:bg-slate-950 border border-slate-300 dark:border-slate-700 text-xs font-semibold text-slate-900 dark:text-white focus:ring-2 focus:ring-blue-600 outline-none shadow-sm">
                    </div>
                </div>

                <div>
                    <label class="block text-xs font-bold text-slate-700 dark:text-slate-300 uppercase tracking-wider mb-1.5">Teks Sambutan Ketua PWI</label>
                    <textarea name="ketua_sambutan" 
                              rows="4" 
                              class="w-full px-4 py-3 rounded-xl bg-white dark:bg-slate-950 border border-slate-300 dark:border-slate-700 text-sm leading-relaxed text-slate-900 dark:text-white focus:ring-2 focus:ring-blue-600 outline-none shadow-sm">{{ old('ketua_sambutan', $settings['ketua_sambutan'] ?? '') }}</textarea>
                </div>

            </div>

            <!-- SECTION 3: VISI & 4 PILAR MISI ORGANISASI (Tampil di Beranda Website) -->
            <div id="visi-misi" class="pt-6 border-t border-slate-200 dark:border-slate-800 space-y-5 scroll-mt-20">
                <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-2">
                    <h3 class="text-sm font-bold text-slate-900 dark:text-white flex items-center gap-2">
                        <i class="fa-solid fa-bullseye text-amber-500"></i>
                        <span>Visi & 4 Butir Misi Strategis Organisasi</span>
                    </h3>
                    <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-lg bg-amber-50 dark:bg-amber-950/50 text-amber-700 dark:text-amber-300 border border-amber-200 dark:border-amber-800/40 text-[11px] font-bold">
                        <i class="fa-solid fa-globe"></i>
                        <span>Tampil Dinamis di Beranda Publik</span>
                    </span>
                </div>

                <div class="p-4 rounded-xl bg-amber-500/10 border border-amber-500/20 text-slate-700 dark:text-amber-200 text-xs leading-relaxed">
                    <strong class="font-bold text-slate-900 dark:text-amber-300 flex items-center gap-1.5 mb-1">
                        <i class="fa-solid fa-circle-info text-amber-500"></i> Panduan Redaksi Visi & Misi:
                    </strong>
                    Visi dan 4 kartu misi di bawah ini telah diselaraskan dengan masukan Dewan Pers & Tokoh Pers (menegaskan integritas, profesionalitas wartawan/jurnalis, kontribusi mencerdaskan masyarakat, serta kemitraan multipihak). Anda dapat menyesuaikannya kapan pun melalui formulir ini.
                </div>

                <!-- Visi Organisasi Card -->
                <div class="p-5 rounded-2xl bg-slate-50 dark:bg-slate-950/60 border border-slate-200 dark:border-slate-800 space-y-2">
                    <label class="block text-xs font-bold text-slate-800 dark:text-slate-200 uppercase tracking-wider">
                        Visi Organisasi PWI Banyuasin *
                    </label>
                    <textarea name="visi" 
                              rows="3" 
                              placeholder="Masukkan visi resmi organisasi..."
                              class="w-full px-4 py-3 rounded-xl bg-white dark:bg-slate-950 border border-slate-300 dark:border-slate-700 text-xs font-medium leading-relaxed text-slate-900 dark:text-white focus:ring-2 focus:ring-blue-600 outline-none shadow-sm">{{ old('visi', $settings['visi'] ?? 'Memperkuat peran PWI Kabupaten Banyuasin dalam peningkatan integritas dan profesionalitas wartawan/jurnalis melalui pendidikan berkelanjutan, Uji Kompetensi Wartawan (UKW), serta kolaborasi strategis demi kemajuan pers yang merdeka, edukatif, dan bermartabat.') }}</textarea>
                    <p class="text-[11px] text-slate-500 dark:text-slate-400">Tampil menonjol pada kartu utama Visi Organisasi di Beranda Website.</p>
                </div>

                <!-- 4 Butir Kartu Misi -->
                <div>
                    <label class="block text-xs font-bold text-slate-700 dark:text-slate-300 uppercase tracking-wider mb-3">
                        4 Butir Kartu Misi Organisasi (Tampil Sebagai Grid Kartu di Beranda)
                    </label>
                    
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <!-- Kartu Misi 1 -->
                        <div class="p-4 rounded-2xl bg-white dark:bg-slate-950 border border-slate-200 dark:border-slate-800 space-y-3 shadow-xs">
                            <div class="flex items-center gap-2">
                                <div class="w-7 h-7 rounded-lg bg-blue-50 dark:bg-blue-950/60 text-blue-600 dark:text-blue-400 flex items-center justify-center text-xs font-bold">
                                    <i class="fa-solid fa-shield-halved"></i>
                                </div>
                                <span class="text-xs font-bold text-slate-900 dark:text-white">Kartu Misi 1</span>
                            </div>
                            <div>
                                <label class="block text-[10px] font-bold text-slate-600 dark:text-slate-400 uppercase mb-1">Judul Singkat Misi 1</label>
                                <input type="text" 
                                       name="misi_1_title" 
                                       value="{{ old('misi_1_title', $settings['misi_1_title'] ?? '1. Solid, Berintegritas & Berdaya Saing') }}" 
                                       class="w-full px-3 py-2 rounded-lg bg-slate-50 dark:bg-slate-900 border border-slate-300 dark:border-slate-700 text-xs font-semibold text-slate-900 dark:text-white focus:ring-2 focus:ring-blue-600 outline-none">
                            </div>
                            <div>
                                <label class="block text-[10px] font-bold text-slate-600 dark:text-slate-400 uppercase mb-1">Uraian / Deskripsi Misi 1</label>
                                <textarea name="misi_1_desc" 
                                          rows="3" 
                                          class="w-full px-3 py-2 rounded-lg bg-slate-50 dark:bg-slate-900 border border-slate-300 dark:border-slate-700 text-xs font-medium leading-relaxed text-slate-900 dark:text-white focus:ring-2 focus:ring-blue-600 outline-none">{{ old('misi_1_desc', $settings['misi_1_desc'] ?? 'Menjadikan PWI Banyuasin sebagai wadah organisasi pers yang solid, berintegritas tinggi, profesional, dan berdaya saing di era transformasi digital.') }}</textarea>
                            </div>
                        </div>

                        <!-- Kartu Misi 2 -->
                        <div class="p-4 rounded-2xl bg-white dark:bg-slate-950 border border-slate-200 dark:border-slate-800 space-y-3 shadow-xs">
                            <div class="flex items-center gap-2">
                                <div class="w-7 h-7 rounded-lg bg-emerald-50 dark:bg-emerald-950/60 text-emerald-600 dark:text-emerald-400 flex items-center justify-center text-xs font-bold">
                                    <i class="fa-solid fa-newspaper"></i>
                                </div>
                                <span class="text-xs font-bold text-slate-900 dark:text-white">Kartu Misi 2</span>
                            </div>
                            <div>
                                <label class="block text-[10px] font-bold text-slate-600 dark:text-slate-400 uppercase mb-1">Judul Singkat Misi 2</label>
                                <input type="text" 
                                       name="misi_2_title" 
                                       value="{{ old('misi_2_title', $settings['misi_2_title'] ?? '2. Edukasi Publik & Kemerdekaan Pers') }}" 
                                       class="w-full px-3 py-2 rounded-lg bg-slate-50 dark:bg-slate-900 border border-slate-300 dark:border-slate-700 text-xs font-semibold text-slate-900 dark:text-white focus:ring-2 focus:ring-blue-600 outline-none">
                            </div>
                            <div>
                                <label class="block text-[10px] font-bold text-slate-600 dark:text-slate-400 uppercase mb-1">Uraian / Deskripsi Misi 2</label>
                                <textarea name="misi_2_desc" 
                                          rows="3" 
                                          class="w-full px-3 py-2 rounded-lg bg-slate-50 dark:bg-slate-900 border border-slate-300 dark:border-slate-700 text-xs font-medium leading-relaxed text-slate-900 dark:text-white focus:ring-2 focus:ring-blue-600 outline-none">{{ old('misi_2_desc', $settings['misi_2_desc'] ?? 'Berkontribusi tegas mencerdaskan kehidupan masyarakat melalui karya jurnalistik yang berkualitas dan terverifikasi, serta konsisten menjaga kemerdekaan pers.') }}</textarea>
                            </div>
                        </div>

                        <!-- Kartu Misi 3 -->
                        <div class="p-4 rounded-2xl bg-white dark:bg-slate-950 border border-slate-200 dark:border-slate-800 space-y-3 shadow-xs">
                            <div class="flex items-center gap-2">
                                <div class="w-7 h-7 rounded-lg bg-purple-50 dark:bg-purple-950/60 text-purple-600 dark:text-purple-400 flex items-center justify-center text-xs font-bold">
                                    <i class="fa-solid fa-users"></i>
                                </div>
                                <span class="text-xs font-bold text-slate-900 dark:text-white">Kartu Misi 3</span>
                            </div>
                            <div>
                                <label class="block text-[10px] font-bold text-slate-600 dark:text-slate-400 uppercase mb-1">Judul Singkat Misi 3</label>
                                <input type="text" 
                                       name="misi_3_title" 
                                       value="{{ old('misi_3_title', $settings['misi_3_title'] ?? '3. Kesejahteraan & Perlindungan Profesi') }}" 
                                       class="w-full px-3 py-2 rounded-lg bg-slate-50 dark:bg-slate-900 border border-slate-300 dark:border-slate-700 text-xs font-semibold text-slate-900 dark:text-white focus:ring-2 focus:ring-blue-600 outline-none">
                            </div>
                            <div>
                                <label class="block text-[10px] font-bold text-slate-600 dark:text-slate-400 uppercase mb-1">Uraian / Deskripsi Misi 3</label>
                                <textarea name="misi_3_desc" 
                                          rows="3" 
                                          class="w-full px-3 py-2 rounded-lg bg-slate-50 dark:bg-slate-900 border border-slate-300 dark:border-slate-700 text-xs font-medium leading-relaxed text-slate-900 dark:text-white focus:ring-2 focus:ring-blue-600 outline-none">{{ old('misi_3_desc', $settings['misi_3_desc'] ?? 'Meningkatkan kesejahteraan, advokasi perlindungan hukum, dan solidaritas sesama insan pers dengan program dukungan nyata bagi wartawan/jurnalis.') }}</textarea>
                            </div>
                        </div>

                        <!-- Kartu Misi 4 -->
                        <div class="p-4 rounded-2xl bg-white dark:bg-slate-950 border border-slate-200 dark:border-slate-800 space-y-3 shadow-xs">
                            <div class="flex items-center gap-2">
                                <div class="w-7 h-7 rounded-lg bg-rose-50 dark:bg-rose-950/60 text-rose-600 dark:text-rose-400 flex items-center justify-center text-xs font-bold">
                                    <i class="fa-solid fa-handshake"></i>
                                </div>
                                <span class="text-xs font-bold text-slate-900 dark:text-white">Kartu Misi 4</span>
                            </div>
                            <div>
                                <label class="block text-[10px] font-bold text-slate-600 dark:text-slate-400 uppercase mb-1">Judul Singkat Misi 4</label>
                                <input type="text" 
                                       name="misi_4_title" 
                                       value="{{ old('misi_4_title', $settings['misi_4_title'] ?? '4. Kemitraan Strategis Multipihak') }}" 
                                       class="w-full px-3 py-2 rounded-lg bg-slate-50 dark:bg-slate-900 border border-slate-300 dark:border-slate-700 text-xs font-semibold text-slate-900 dark:text-white focus:ring-2 focus:ring-blue-600 outline-none">
                            </div>
                            <div>
                                <label class="block text-[10px] font-bold text-slate-600 dark:text-slate-400 uppercase mb-1">Uraian / Deskripsi Misi 4</label>
                                <textarea name="misi_4_desc" 
                                          rows="3" 
                                          class="w-full px-3 py-2 rounded-lg bg-slate-50 dark:bg-slate-900 border border-slate-300 dark:border-slate-700 text-xs font-medium leading-relaxed text-slate-900 dark:text-white focus:ring-2 focus:ring-blue-600 outline-none">{{ old('misi_4_desc', $settings['misi_4_desc'] ?? 'Membangun sinergi kemitraan strategis bersama instansi pemerintah, perusahaan swasta dan negara, serta organisasi masyarakat yang saling memperkuat penyebaran informasi publik secara akurat dan berimbang.') }}</textarea>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Teks Lengkap Misi Organisasi (Rangkuman Dokumen Resmi / Cetak) -->
                <div class="pt-2">
                    <label class="block text-xs font-bold text-slate-700 dark:text-slate-300 uppercase tracking-wider mb-1.5">
                        Teks Rangkuman Misi Organisasi (Dokumen / Arsip Resmi)
                    </label>
                    <textarea name="misi" 
                              rows="4" 
                              placeholder="1. Menjadikan PWI Banyuasin...&#10;2. Berkontribusi nyata...&#10;3. Meningkatkan kesejahteraan...&#10;4. Menjalin kemitraan..."
                              class="w-full px-4 py-3 rounded-xl bg-white dark:bg-slate-950 border border-slate-300 dark:border-slate-700 text-xs font-medium leading-relaxed text-slate-900 dark:text-white focus:ring-2 focus:ring-blue-600 outline-none shadow-sm">{{ old('misi', $settings['misi'] ?? '') }}</textarea>
                    <p class="text-[11px] text-slate-400 mt-1">Dapat dikosongkan agar otomatis dirangkum dari 4 butir kartu misi di atas.</p>
                </div>
            </div>

            <!-- SUBMIT BUTTON -->
            <div class="flex items-center justify-between pt-6 border-t border-slate-200 dark:border-slate-800">
                <span class="text-xs text-slate-500 dark:text-slate-400">
                    <i class="fa-solid fa-shield-check text-blue-600"></i> Perubahan tersimpan langsung ke basis data
                </span>
                <button type="submit" class="px-8 py-3 rounded-xl text-xs font-bold text-white bg-blue-600 hover:bg-blue-700 shadow-md transition-all flex items-center gap-2 cursor-pointer">
                    <i class="fa-solid fa-save"></i>
                    <span>Simpan Pengaturan Data PWI</span>
                </button>
            </div>

        </div>
    </form>

</div>
@endsection
