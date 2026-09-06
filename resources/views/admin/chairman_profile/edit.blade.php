@extends('layouts.admin')

@section('title', 'Edit Profil & Portofolio Ketua')
@section('page_title', 'Profil & Portofolio Ketua')

@section('content')
<div class="space-y-6" x-data="{
    activeTab: 'identitas',
    organisasi: {{ Js::from($profile['organisasi'] ?? []) }},
    pendidikan: {{ Js::from($profile['pendidikan'] ?? []) }},
    sertifikasi: {{ Js::from($profile['sertifikasi'] ?? []) }},
    pilarNilai: {{ Js::from($profile['pilar_nilai'] ?? []) }},
    
    addOrganisasi() {
        this.organisasi.push({ posisi: '', masa: '', ket: '' });
    },
    removeOrganisasi(index) {
        this.organisasi.splice(index, 1);
    },

    addPendidikan() {
        this.pendidikan.push({ tingkat: '', instansi: '', prodi: '', status: 'Lulus' });
    },
    removePendidikan(index) {
        this.pendidikan.splice(index, 1);
    },

    addSertifikasi() {
        this.sertifikasi.push({ bidang: '', penerbit: '', nomor: '', tahun: '', keterangan: '' });
    },
    removeSertifikasi(index) {
        this.sertifikasi.splice(index, 1);
    },

    addPilar() {
        this.pilarNilai.push({ title: '', desc: '', icon: 'fa-solid fa-award' });
    },
    removePilar(index) {
        this.pilarNilai.splice(index, 1);
    }
}">

    <!-- Top Header -->
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
        <div>
            <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-emerald-500/10 border border-emerald-500/20 text-emerald-600 dark:text-emerald-400 text-xs font-bold uppercase tracking-wider mb-2">
                <i class="fa-solid fa-id-card-clip"></i>
                <span>Pengaturan Profil &amp; Portofolio Eksekutif</span>
            </div>
            <h2 class="text-xl sm:text-2xl font-black text-[#0B132B] dark:text-white">Edit Profil &amp; Portofolio Ketua</h2>
            <p class="text-xs text-slate-600 dark:text-slate-400 mt-1 font-medium">
                Sesuaikan seluruh konten portofolio, biografi, riwayat organisasi, pendidikan, sertifikasi, serta foto resmi yang ditampilkan pada halaman publik <a href="{{ route('chairman.archive.index') }}" target="_blank" class="text-blue-600 dark:text-amber-400 font-bold hover:underline">/wardoyo</a>
            </p>
        </div>
        <div class="flex items-center gap-2 shrink-0">
            <a href="{{ route('chairman.archive.index') }}" target="_blank" class="inline-flex items-center gap-2 px-4 py-2.5 rounded-xl text-xs font-bold text-slate-700 dark:text-slate-300 bg-white dark:bg-slate-900 border border-slate-300 dark:border-slate-800 hover:bg-slate-50 dark:hover:bg-slate-800 shadow-xs transition-all">
                <i class="fa-solid fa-arrow-up-right-from-square text-amber-500"></i>
                <span>Lihat Web /wardoyo</span>
            </a>
            <button type="submit" form="profileForm" class="inline-flex items-center gap-2 px-5 py-2.5 rounded-xl text-xs font-bold text-white bg-blue-600 hover:bg-blue-700 dark:bg-amber-400 dark:hover:bg-amber-300 dark:text-slate-950 shadow-md transition-all cursor-pointer">
                <i class="fa-solid fa-floppy-disk"></i>
                <span>Simpan Perubahan</span>
            </button>
        </div>
    </div>

    <!-- Quick Switcher Tabs -->
    <div class="flex items-center gap-2 border-b border-slate-200 dark:border-slate-800 pb-2">
        <a href="{{ route('admin.chairman_posts.index') }}" class="inline-flex items-center gap-2 px-4 py-2 rounded-xl text-xs font-bold text-slate-600 dark:text-slate-400 hover:text-slate-900 dark:hover:text-white hover:bg-slate-100 dark:hover:bg-slate-800 transition-colors">
            <i class="fa-solid fa-newspaper text-amber-500"></i>
            <span>Katalog Tulisan &amp; Karya</span>
        </a>
        <a href="{{ route('admin.chairman_profile.edit') }}" class="inline-flex items-center gap-2 px-4 py-2 rounded-xl text-xs font-bold bg-[#0B132B] text-white dark:bg-amber-400 dark:text-slate-950 shadow-xs">
            <i class="fa-solid fa-id-card-clip text-emerald-400 dark:text-slate-950"></i>
            <span>Edit Profil &amp; Portofolio Ketua</span>
        </a>
    </div>

    <!-- Alert Notifikasi -->
    @if(session('success'))
        <div class="p-4 rounded-2xl bg-emerald-50 dark:bg-emerald-950/50 border border-emerald-200 dark:border-emerald-800/80 text-emerald-900 dark:text-emerald-200 text-xs font-semibold flex items-center justify-between shadow-xs">
            <div class="flex items-center gap-3">
                <i class="fa-solid fa-circle-check text-emerald-600 dark:text-emerald-400 text-base"></i>
                <span>{{ session('success') }}</span>
            </div>
            <button type="button" onclick="this.parentElement.remove()" class="text-emerald-500 hover:text-emerald-700 cursor-pointer">
                <i class="fa-solid fa-xmark"></i>
            </button>
        </div>
    @endif

    @if($errors->any())
        <div class="p-4 rounded-2xl bg-rose-50 dark:bg-rose-950/50 border border-rose-200 dark:border-rose-800/80 text-rose-900 dark:text-rose-200 text-xs font-semibold space-y-1 shadow-xs">
            <div class="flex items-center gap-2 font-bold">
                <i class="fa-solid fa-triangle-exclamation text-rose-500"></i>
                <span>Terdapat kesalahan pengisian data:</span>
            </div>
            <ul class="list-disc list-inside space-y-0.5 text-[11px] font-normal pl-2">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <!-- Form Section -->
    <form id="profileForm" action="{{ route('admin.chairman_profile.update') }}" method="POST" enctype="multipart/form-data">
        @csrf

        <!-- Navigation Tabs -->
        <div class="bg-white dark:bg-slate-900 rounded-2xl border border-slate-200 dark:border-slate-800 p-2 shadow-xs flex flex-wrap gap-1.5 mb-6">
            <button type="button" @click="activeTab = 'identitas'" :class="activeTab === 'identitas' ? 'bg-[#0B132B] text-white dark:bg-amber-400 dark:text-slate-950 shadow-xs' : 'text-slate-600 dark:text-slate-300 hover:bg-slate-100 dark:hover:bg-slate-800'" class="px-4 py-2 rounded-xl text-xs font-bold transition-all flex items-center gap-2 cursor-pointer">
                <i class="fa-solid fa-user-tie"></i>
                <span>1. Identitas &amp; Foto Utama</span>
            </button>
            <button type="button" @click="activeTab = 'narasi'" :class="activeTab === 'narasi' ? 'bg-[#0B132B] text-white dark:bg-amber-400 dark:text-slate-950 shadow-xs' : 'text-slate-600 dark:text-slate-300 hover:bg-slate-100 dark:hover:bg-slate-800'" class="px-4 py-2 rounded-xl text-xs font-bold transition-all flex items-center gap-2 cursor-pointer">
                <i class="fa-solid fa-newspaper"></i>
                <span>2. Biografi &amp; 4 Pilar Nilai</span>
            </button>
            <button type="button" @click="activeTab = 'organisasi'" :class="activeTab === 'organisasi' ? 'bg-[#0B132B] text-white dark:bg-amber-400 dark:text-slate-950 shadow-xs' : 'text-slate-600 dark:text-slate-300 hover:bg-slate-100 dark:hover:bg-slate-800'" class="px-4 py-2 rounded-xl text-xs font-bold transition-all flex items-center gap-2 cursor-pointer">
                <i class="fa-solid fa-sitemap"></i>
                <span>3. Rekam Jejak Organisasi</span>
            </button>
            <button type="button" @click="activeTab = 'pendidikan'" :class="activeTab === 'pendidikan' ? 'bg-[#0B132B] text-white dark:bg-amber-400 dark:text-slate-950 shadow-xs' : 'text-slate-600 dark:text-slate-300 hover:bg-slate-100 dark:hover:bg-slate-800'" class="px-4 py-2 rounded-xl text-xs font-bold transition-all flex items-center gap-2 cursor-pointer">
                <i class="fa-solid fa-graduation-cap"></i>
                <span>4. Pendidikan Formal</span>
            </button>
            <button type="button" @click="activeTab = 'sertifikasi'" :class="activeTab === 'sertifikasi' ? 'bg-[#0B132B] text-white dark:bg-amber-400 dark:text-slate-950 shadow-xs' : 'text-slate-600 dark:text-slate-300 hover:bg-slate-100 dark:hover:bg-slate-800'" class="px-4 py-2 rounded-xl text-xs font-bold transition-all flex items-center gap-2 cursor-pointer">
                <i class="fa-solid fa-certificate"></i>
                <span>5. Sertifikasi &amp; Pelatihan</span>
            </button>
            <button type="button" @click="activeTab = 'footer'" :class="activeTab === 'footer' ? 'bg-[#0B132B] text-white dark:bg-amber-400 dark:text-slate-950 shadow-xs' : 'text-slate-600 dark:text-slate-300 hover:bg-slate-100 dark:hover:bg-slate-800'" class="px-4 py-2 rounded-xl text-xs font-bold transition-all flex items-center gap-2 cursor-pointer">
                <i class="fa-solid fa-handshake"></i>
                <span>6. Banner Kemitraan (Footer)</span>
            </button>
        </div>

        <!-- ========================================================================= -->
        <!-- TAB 1: IDENTITAS & FOTO UTAMA                                             -->
        <!-- ========================================================================= -->
        <div x-show="activeTab === 'identitas'" class="space-y-6">
            
            <div class="grid grid-cols-1 lg:grid-cols-12 gap-6">
                <!-- Foto & Card Bawah Foto -->
                <div class="lg:col-span-4 space-y-6">
                    <div class="bg-white dark:bg-slate-900 rounded-3xl border border-slate-200 dark:border-slate-800 p-6 shadow-xs space-y-4">
                        <h3 class="text-sm font-black text-slate-900 dark:text-white flex items-center gap-2">
                            <i class="fa-solid fa-camera text-amber-500"></i>
                            <span>Foto Resmi &amp; OpenGraph</span>
                        </h3>

                        <div class="w-full aspect-[4/5] rounded-2xl overflow-hidden bg-slate-100 dark:bg-slate-800 border border-slate-200 dark:border-slate-700 relative group">
                            <img src="{{ $profile['foto_url'] }}" alt="{{ $profile['name'] }}" class="w-full h-full object-cover object-top">
                            <div class="absolute inset-0 bg-slate-950/40 opacity-0 group-hover:opacity-100 transition-opacity flex items-center justify-center p-4 text-center">
                                <span class="text-xs font-bold text-white bg-black/60 px-3 py-1.5 rounded-lg backdrop-blur-xs">Foto Saat Ini</span>
                            </div>
                        </div>

                        <div class="space-y-2">
                            <label class="block text-xs font-bold text-slate-700 dark:text-slate-300">Ganti Foto Resmi</label>
                            <input type="file" name="foto" accept="image/*" class="w-full text-xs text-slate-600 dark:text-slate-400 file:mr-3 file:py-2 file:px-3.5 file:rounded-xl file:border-0 file:text-xs file:font-bold file:bg-blue-50 file:text-blue-700 dark:file:bg-slate-800 dark:file:text-amber-400 hover:file:bg-blue-100 cursor-pointer">
                            <p class="text-[11px] text-slate-500 dark:text-slate-400 leading-tight">
                                Format: JPG, PNG, WEBP. Maks 5MB. Sistem otomatis menghasilkan WebP &amp; gambar kotak 800x800 untuk preview WhatsApp.
                            </p>
                        </div>

                        @if(!empty($profile['foto_url']) && !str_contains($profile['foto_url'], 'wardoyo-ketua.webp'))
                            <div class="pt-2 border-t border-slate-100 dark:border-slate-800 flex items-center gap-2">
                                <input type="checkbox" name="remove_foto" id="remove_foto" value="1" class="rounded border-slate-300 text-rose-600 focus:ring-rose-500">
                                <label for="remove_foto" class="text-xs font-semibold text-rose-600 dark:text-rose-400 cursor-pointer">
                                    Hapus foto kustom (kembali ke default)
                                </label>
                            </div>
                        @endif
                    </div>

                    <!-- Pengaturan Teks Card di Bawah Foto -->
                    <div class="bg-white dark:bg-slate-900 rounded-3xl border border-slate-200 dark:border-slate-800 p-6 shadow-xs space-y-4">
                        <h3 class="text-sm font-black text-slate-900 dark:text-white flex items-center gap-2">
                            <i class="fa-solid fa-address-card text-blue-500"></i>
                            <span>Card di Bawah Foto</span>
                        </h3>

                        <div class="space-y-3">
                            <div>
                                <label class="block text-xs font-bold text-slate-700 dark:text-slate-300 mb-1">Badge Atas Card</label>
                                <input type="text" name="badge_bawah_foto" value="{{ old('badge_bawah_foto', $profile['badge_bawah_foto'] ?? 'PWI KABUPATEN BANYUASIN') }}" class="w-full px-3.5 py-2.5 rounded-xl border border-slate-200 dark:border-slate-700 bg-slate-50 dark:bg-slate-800 text-xs font-semibold text-slate-900 dark:text-white outline-none focus:ring-2 focus:ring-amber-500">
                            </div>
                            <div>
                                <label class="block text-xs font-bold text-slate-700 dark:text-slate-300 mb-1">Judul Utama Bawah Foto</label>
                                <input type="text" name="judul_bawah_foto" value="{{ old('judul_bawah_foto', $profile['judul_bawah_foto'] ?? 'Ketua PWI Banyuasin') }}" class="w-full px-3.5 py-2.5 rounded-xl border border-slate-200 dark:border-slate-700 bg-slate-50 dark:bg-slate-800 text-xs font-semibold text-slate-900 dark:text-white outline-none focus:ring-2 focus:ring-amber-500">
                            </div>
                            <div>
                                <label class="block text-xs font-bold text-slate-700 dark:text-slate-300 mb-1">Subjudul / Periode</label>
                                <input type="text" name="subjudul_bawah_foto" value="{{ old('subjudul_bawah_foto', $profile['subjudul_bawah_foto'] ?? 'Masa Bakti 2025 – 2028') }}" class="w-full px-3.5 py-2.5 rounded-xl border border-slate-200 dark:border-slate-700 bg-slate-50 dark:bg-slate-800 text-xs font-semibold text-slate-900 dark:text-white outline-none focus:ring-2 focus:ring-amber-500">
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Kolom Kanan: Nama, Jabatan, SK, Motto, Metrik -->
                <div class="lg:col-span-8 space-y-6">
                    
                    <div class="bg-white dark:bg-slate-900 rounded-3xl border border-slate-200 dark:border-slate-800 p-6 shadow-xs space-y-5">
                        <h3 class="text-sm font-black text-slate-900 dark:text-white flex items-center gap-2">
                            <i class="fa-solid fa-user-shield text-amber-500"></i>
                            <span>Data Identitas Utama &amp; SK Resmi</span>
                        </h3>

                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                            <div>
                                <label class="block text-xs font-bold text-slate-700 dark:text-slate-300 mb-1">Nama Lengkap &amp; Gelar <span class="text-rose-500">*</span></label>
                                <input type="text" name="name" required value="{{ old('name', $profile['name'] ?? 'Wardoyo, S.I.Kom.') }}" class="w-full px-3.5 py-2.5 rounded-xl border border-slate-200 dark:border-slate-700 bg-slate-50 dark:bg-slate-800 text-xs font-bold text-slate-900 dark:text-white outline-none focus:ring-2 focus:ring-amber-500">
                            </div>
                            <div>
                                <label class="block text-xs font-bold text-slate-700 dark:text-slate-300 mb-1">Jabatan Resmi <span class="text-rose-500">*</span></label>
                                <input type="text" name="title" required value="{{ old('title', $profile['title'] ?? 'Ketua Persatuan Wartawan Indonesia (PWI) Kabupaten Banyuasin') }}" class="w-full px-3.5 py-2.5 rounded-xl border border-slate-200 dark:border-slate-700 bg-slate-50 dark:bg-slate-800 text-xs font-bold text-slate-900 dark:text-white outline-none focus:ring-2 focus:ring-amber-500">
                            </div>
                            <div>
                                <label class="block text-xs font-bold text-slate-700 dark:text-slate-300 mb-1">Nomor SK Pengangkatan Resmi</label>
                                <input type="text" name="sk_resmi" value="{{ old('sk_resmi', $profile['sk_resmi'] ?? 'SK PWI Pusat Nomor: 033/PP-PWI/XI/2025') }}" class="w-full px-3.5 py-2.5 rounded-xl border border-slate-200 dark:border-slate-700 bg-slate-50 dark:bg-slate-800 text-xs font-semibold text-slate-900 dark:text-white outline-none focus:ring-2 focus:ring-amber-500">
                            </div>
                            <div>
                                <label class="block text-xs font-bold text-slate-700 dark:text-slate-300 mb-1">Badge Pill Atas Hero</label>
                                <input type="text" name="badge_top" value="{{ old('badge_top', $profile['badge_top'] ?? 'Profil Eksekutif & Personal Branding Resmi') }}" class="w-full px-3.5 py-2.5 rounded-xl border border-slate-200 dark:border-slate-700 bg-slate-50 dark:bg-slate-800 text-xs font-semibold text-slate-900 dark:text-white outline-none focus:ring-2 focus:ring-amber-500">
                            </div>
                            <div>
                                <label class="block text-xs font-bold text-slate-700 dark:text-slate-300 mb-1">Tag Status Dewan Pers</label>
                                <input type="text" name="tag_status_pers" value="{{ old('tag_status_pers', $profile['tag_status_pers'] ?? 'Wartawan Utama Dewan Pers') }}" class="w-full px-3.5 py-2.5 rounded-xl border border-slate-200 dark:border-slate-700 bg-slate-50 dark:bg-slate-800 text-xs font-semibold text-slate-900 dark:text-white outline-none focus:ring-2 focus:ring-amber-500">
                            </div>
                            <div>
                                <label class="block text-xs font-bold text-slate-700 dark:text-slate-300 mb-1">Tag Organisasi Tingkat Provinsi</label>
                                <input type="text" name="tag_organisasi_provinsi" value="{{ old('tag_organisasi_provinsi', $profile['tag_organisasi_provinsi'] ?? 'Anggota DKP PWI Sumsel') }}" class="w-full px-3.5 py-2.5 rounded-xl border border-slate-200 dark:border-slate-700 bg-slate-50 dark:bg-slate-800 text-xs font-semibold text-slate-900 dark:text-white outline-none focus:ring-2 focus:ring-amber-500">
                            </div>
                        </div>

                        <div>
                            <label class="block text-xs font-bold text-slate-700 dark:text-slate-300 mb-1">Motto Kepemimpinan / Visi Pribadi</label>
                            <textarea name="motto" rows="3" class="w-full px-3.5 py-2.5 rounded-xl border border-slate-200 dark:border-slate-700 bg-slate-50 dark:bg-slate-800 text-xs text-slate-900 dark:text-white outline-none focus:ring-2 focus:ring-amber-500 leading-relaxed">{{ old('motto', $profile['motto'] ?? '') }}</textarea>
                        </div>

                        <div class="grid grid-cols-1 sm:grid-cols-3 gap-4 pt-2 border-t border-slate-100 dark:border-slate-800">
                            <div>
                                <label class="block text-xs font-bold text-slate-700 dark:text-slate-300 mb-1">Tempat, Tanggal Lahir</label>
                                <input type="text" name="ttl" value="{{ old('ttl', $profile['ttl'] ?? 'Sragen (Jawa Tengah), 17 Februari 1976') }}" class="w-full px-3.5 py-2.5 rounded-xl border border-slate-200 dark:border-slate-700 bg-slate-50 dark:bg-slate-800 text-xs font-semibold text-slate-900 dark:text-white outline-none focus:ring-2 focus:ring-amber-500">
                            </div>
                            <div>
                                <label class="block text-xs font-bold text-slate-700 dark:text-slate-300 mb-1">Agama</label>
                                <input type="text" name="agama" value="{{ old('agama', $profile['agama'] ?? 'Islam') }}" class="w-full px-3.5 py-2.5 rounded-xl border border-slate-200 dark:border-slate-700 bg-slate-50 dark:bg-slate-800 text-xs font-semibold text-slate-900 dark:text-white outline-none focus:ring-2 focus:ring-amber-500">
                            </div>
                            <div>
                                <label class="block text-xs font-bold text-slate-700 dark:text-slate-300 mb-1">Lokasi Singkat</label>
                                <input type="text" name="lokasi_singkat" value="{{ old('lokasi_singkat', $profile['lokasi_singkat'] ?? 'Talang Kelapa, Banyuasin') }}" class="w-full px-3.5 py-2.5 rounded-xl border border-slate-200 dark:border-slate-700 bg-slate-50 dark:bg-slate-800 text-xs font-semibold text-slate-900 dark:text-white outline-none focus:ring-2 focus:ring-amber-500">
                            </div>
                        </div>

                        <div>
                            <label class="block text-xs font-bold text-slate-700 dark:text-slate-300 mb-1">Alamat Domisili Lengkap</label>
                            <input type="text" name="alamat" value="{{ old('alamat', $profile['alamat'] ?? '') }}" class="w-full px-3.5 py-2.5 rounded-xl border border-slate-200 dark:border-slate-700 bg-slate-50 dark:bg-slate-800 text-xs font-semibold text-slate-900 dark:text-white outline-none focus:ring-2 focus:ring-amber-500">
                        </div>
                    </div>

                    <!-- 4 Counter Statistik Hero -->
                    <div class="bg-white dark:bg-slate-900 rounded-3xl border border-slate-200 dark:border-slate-800 p-6 shadow-xs space-y-4">
                        <h3 class="text-sm font-black text-slate-900 dark:text-white flex items-center gap-2">
                            <i class="fa-solid fa-chart-simple text-blue-500"></i>
                            <span>4 Metrik Statistik Kunci (Hero)</span>
                        </h3>

                        <div class="grid grid-cols-2 sm:grid-cols-4 gap-4">
                            <div class="space-y-2 p-3 rounded-2xl bg-slate-50 dark:bg-slate-800/60 border border-slate-200/60 dark:border-slate-700/60">
                                <label class="block text-[10px] font-extrabold uppercase tracking-wider text-slate-500 dark:text-slate-400">Statistik 1</label>
                                <input type="text" name="stat_karya" value="{{ old('stat_karya', $profile['stat_karya'] ?? '320+') }}" placeholder="320+" class="w-full px-2.5 py-1.5 rounded-lg border border-slate-200 dark:border-slate-700 bg-white dark:bg-slate-900 text-xs font-bold text-amber-500">
                                <input type="text" name="stat_karya_label" value="{{ old('stat_karya_label', $profile['stat_karya_label'] ?? 'Karya Tulis') }}" placeholder="Karya Tulis" class="w-full px-2.5 py-1.5 rounded-lg border border-slate-200 dark:border-slate-700 bg-white dark:bg-slate-900 text-[11px] font-semibold text-slate-700 dark:text-slate-300">
                            </div>
                            <div class="space-y-2 p-3 rounded-2xl bg-slate-50 dark:bg-slate-800/60 border border-slate-200/60 dark:border-slate-700/60">
                                <label class="block text-[10px] font-extrabold uppercase tracking-wider text-slate-500 dark:text-slate-400">Statistik 2</label>
                                <input type="text" name="stat_kiprah" value="{{ old('stat_kiprah', $profile['stat_kiprah'] ?? '18+ Th') }}" placeholder="18+ Th" class="w-full px-2.5 py-1.5 rounded-lg border border-slate-200 dark:border-slate-700 bg-white dark:bg-slate-900 text-xs font-bold text-slate-900 dark:text-white">
                                <input type="text" name="stat_kiprah_label" value="{{ old('stat_kiprah_label', $profile['stat_kiprah_label'] ?? 'Kiprah Jurnalistik') }}" placeholder="Kiprah Jurnalistik" class="w-full px-2.5 py-1.5 rounded-lg border border-slate-200 dark:border-slate-700 bg-white dark:bg-slate-900 text-[11px] font-semibold text-slate-700 dark:text-slate-300">
                            </div>
                            <div class="space-y-2 p-3 rounded-2xl bg-slate-50 dark:bg-slate-800/60 border border-slate-200/60 dark:border-slate-700/60">
                                <label class="block text-[10px] font-extrabold uppercase tracking-wider text-slate-500 dark:text-slate-400">Statistik 3</label>
                                <input type="text" name="stat_lisensi" value="{{ old('stat_lisensi', $profile['stat_lisensi'] ?? 'Utama') }}" placeholder="Utama" class="w-full px-2.5 py-1.5 rounded-lg border border-slate-200 dark:border-slate-700 bg-white dark:bg-slate-900 text-xs font-bold text-emerald-500">
                                <input type="text" name="stat_lisensi_label" value="{{ old('stat_lisensi_label', $profile['stat_lisensi_label'] ?? 'Lisensi UKW') }}" placeholder="Lisensi UKW" class="w-full px-2.5 py-1.5 rounded-lg border border-slate-200 dark:border-slate-700 bg-white dark:bg-slate-900 text-[11px] font-semibold text-slate-700 dark:text-slate-300">
                            </div>
                            <div class="space-y-2 p-3 rounded-2xl bg-slate-50 dark:bg-slate-800/60 border border-slate-200/60 dark:border-slate-700/60">
                                <label class="block text-[10px] font-extrabold uppercase tracking-wider text-slate-500 dark:text-slate-400">Statistik 4</label>
                                <input type="text" name="stat_pendidikan" value="{{ old('stat_pendidikan', $profile['stat_pendidikan'] ?? 'S.I.Kom.') }}" placeholder="S.I.Kom." class="w-full px-2.5 py-1.5 rounded-lg border border-slate-200 dark:border-slate-700 bg-white dark:bg-slate-900 text-xs font-bold text-blue-500">
                                <input type="text" name="stat_pendidikan_label" value="{{ old('stat_pendidikan_label', $profile['stat_pendidikan_label'] ?? 'Ilmu Komunikasi') }}" placeholder="Ilmu Komunikasi" class="w-full px-2.5 py-1.5 rounded-lg border border-slate-200 dark:border-slate-700 bg-white dark:bg-slate-900 text-[11px] font-semibold text-slate-700 dark:text-slate-300">
                            </div>
                        </div>
                    </div>

                </div>
            </div>

        </div>

        <!-- ========================================================================= -->
        <!-- TAB 2: NARASI BIOGRAFI, KONTAK & 4 PILAR NILAI                            -->
        <!-- ========================================================================= -->
        <div x-show="activeTab === 'narasi'" class="space-y-6">
            
            <div class="grid grid-cols-1 lg:grid-cols-12 gap-6">
                <!-- Narasi Biografi -->
                <div class="lg:col-span-7 space-y-6">
                    <div class="bg-white dark:bg-slate-900 rounded-3xl border border-slate-200 dark:border-slate-800 p-6 shadow-xs space-y-4">
                        <h3 class="text-sm font-black text-slate-900 dark:text-white flex items-center gap-2">
                            <i class="fa-solid fa-paragraph text-amber-500"></i>
                            <span>Narasi Biografi &amp; Kepemimpinan</span>
                        </h3>

                        <div>
                            <label class="block text-xs font-bold text-slate-700 dark:text-slate-300 mb-1">Subjudul / Label Narasi</label>
                            <input type="text" name="narasi_subjudul" value="{{ old('narasi_subjudul', $profile['narasi_subjudul'] ?? 'Tentang Kepemimpinan & Pengabdian') }}" class="w-full px-3.5 py-2.5 rounded-xl border border-slate-200 dark:border-slate-700 bg-slate-50 dark:bg-slate-800 text-xs font-semibold text-slate-900 dark:text-white outline-none focus:ring-2 focus:ring-amber-500">
                        </div>

                        <div>
                            <label class="block text-xs font-bold text-slate-700 dark:text-slate-300 mb-1">Judul Utama Narasi</label>
                            <input type="text" name="narasi_judul" value="{{ old('narasi_judul', $profile['narasi_judul'] ?? 'Komitmen Teruji Mengawal Integritas Pers & Pembangunan Banyuasin') }}" class="w-full px-3.5 py-2.5 rounded-xl border border-slate-200 dark:border-slate-700 bg-slate-50 dark:bg-slate-800 text-xs font-bold text-slate-900 dark:text-white outline-none focus:ring-2 focus:ring-amber-500">
                        </div>

                        <div>
                            <label class="block text-xs font-bold text-slate-700 dark:text-slate-300 mb-1">Paragraf 1 (Awal Karier &amp; Pemimpin Redaksi)</label>
                            <textarea name="narasi_paragraf_1" rows="3" class="w-full px-3.5 py-2.5 rounded-xl border border-slate-200 dark:border-slate-700 bg-slate-50 dark:bg-slate-800 text-xs text-slate-900 dark:text-white outline-none focus:ring-2 focus:ring-amber-500 leading-relaxed">{{ old('narasi_paragraf_1', $profile['narasi_paragraf_1'] ?? '') }}</textarea>
                        </div>

                        <div>
                            <label class="block text-xs font-bold text-slate-700 dark:text-slate-300 mb-1">Paragraf 2 (Akademik &amp; Lisensi Utama Dewan Pers)</label>
                            <textarea name="narasi_paragraf_2" rows="3" class="w-full px-3.5 py-2.5 rounded-xl border border-slate-200 dark:border-slate-700 bg-slate-50 dark:bg-slate-800 text-xs text-slate-900 dark:text-white outline-none focus:ring-2 focus:ring-amber-500 leading-relaxed">{{ old('narasi_paragraf_2', $profile['narasi_paragraf_2'] ?? '') }}</textarea>
                        </div>

                        <div>
                            <label class="block text-xs font-bold text-slate-700 dark:text-slate-300 mb-1">Paragraf 3 (Visi Kepemimpinan PWI Banyuasin 2025–2028)</label>
                            <textarea name="narasi_paragraf_3" rows="3" class="w-full px-3.5 py-2.5 rounded-xl border border-slate-200 dark:border-slate-700 bg-slate-50 dark:bg-slate-800 text-xs text-slate-900 dark:text-white outline-none focus:ring-2 focus:ring-amber-500 leading-relaxed">{{ old('narasi_paragraf_3', $profile['narasi_paragraf_3'] ?? '') }}</textarea>
                        </div>
                    </div>

                    <!-- Kontak & Media Sosial -->
                    <div class="bg-white dark:bg-slate-900 rounded-3xl border border-slate-200 dark:border-slate-800 p-6 shadow-xs space-y-4">
                        <h3 class="text-sm font-black text-slate-900 dark:text-white flex items-center gap-2">
                            <i class="fa-solid fa-share-nodes text-emerald-500"></i>
                            <span>Kontak Resmi &amp; Media Sosial</span>
                        </h3>

                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                            <div>
                                <label class="block text-xs font-bold text-slate-700 dark:text-slate-300 mb-1">Nomor WhatsApp Resmi</label>
                                <input type="text" name="telepon" value="{{ old('telepon', $profile['kontak']['telepon'] ?? '0853-7799-1976') }}" class="w-full px-3.5 py-2.5 rounded-xl border border-slate-200 dark:border-slate-700 bg-slate-50 dark:bg-slate-800 text-xs font-semibold text-slate-900 dark:text-white outline-none focus:ring-2 focus:ring-amber-500">
                            </div>
                            <div>
                                <label class="block text-xs font-bold text-slate-700 dark:text-slate-300 mb-1">Email Resmi</label>
                                <input type="email" name="email" value="{{ old('email', $profile['kontak']['email'] ?? 'wardianstp@gmail.com') }}" class="w-full px-3.5 py-2.5 rounded-xl border border-slate-200 dark:border-slate-700 bg-slate-50 dark:bg-slate-800 text-xs font-semibold text-slate-900 dark:text-white outline-none focus:ring-2 focus:ring-amber-500">
                            </div>
                            <div>
                                <label class="block text-xs font-bold text-slate-700 dark:text-slate-300 mb-1">Instagram URL</label>
                                <input type="text" name="instagram" value="{{ old('instagram', $profile['kontak']['instagram'] ?? 'https://www.instagram.com/wardianstp/') }}" class="w-full px-3.5 py-2.5 rounded-xl border border-slate-200 dark:border-slate-700 bg-slate-50 dark:bg-slate-800 text-xs font-semibold text-slate-900 dark:text-white outline-none focus:ring-2 focus:ring-amber-500">
                            </div>
                            <div>
                                <label class="block text-xs font-bold text-slate-700 dark:text-slate-300 mb-1">Facebook URL</label>
                                <input type="text" name="facebook" value="{{ old('facebook', $profile['kontak']['facebook'] ?? 'https://www.facebook.com/ward.wardoyo') }}" class="w-full px-3.5 py-2.5 rounded-xl border border-slate-200 dark:border-slate-700 bg-slate-50 dark:bg-slate-800 text-xs font-semibold text-slate-900 dark:text-white outline-none focus:ring-2 focus:ring-amber-500">
                            </div>
                        </div>
                    </div>
                </div>

                <!-- 4 Pilar Nilai Strategis -->
                <div class="lg:col-span-5 space-y-6">
                    <div class="bg-white dark:bg-slate-900 rounded-3xl border border-slate-200 dark:border-slate-800 p-6 shadow-xs space-y-4">
                        <div class="flex items-center justify-between">
                            <h3 class="text-sm font-black text-slate-900 dark:text-white flex items-center gap-2">
                                <i class="fa-solid fa-gem text-blue-500"></i>
                                <span>Pilar Nilai Strategis</span>
                            </h3>
                            <button type="button" @click="addPilar()" class="px-2.5 py-1.5 rounded-lg text-[11px] font-bold text-blue-600 bg-blue-50 dark:bg-blue-900/40 dark:text-blue-300 hover:bg-blue-100 transition-colors cursor-pointer">
                                + Tambah Pilar
                            </button>
                        </div>

                        <div class="space-y-4">
                            <template x-for="(pilar, index) in pilarNilai" :key="index">
                                <div class="p-4 rounded-2xl bg-slate-50 dark:bg-slate-800/60 border border-slate-200/80 dark:border-slate-700/60 space-y-2.5 relative group">
                                    <div class="flex items-center justify-between gap-2">
                                        <div class="flex items-center gap-2 flex-1">
                                            <input type="text" :name="'pilar_nilai[' + index + '][icon]'" x-model="pilar.icon" placeholder="fa-solid fa-award" class="w-32 px-2.5 py-1.5 rounded-lg border border-slate-200 dark:border-slate-700 bg-white dark:bg-slate-900 text-xs font-mono text-slate-700 dark:text-slate-300">
                                            <input type="text" :name="'pilar_nilai[' + index + '][title]'" x-model="pilar.title" placeholder="Judul Pilar" class="flex-1 px-2.5 py-1.5 rounded-lg border border-slate-200 dark:border-slate-700 bg-white dark:bg-slate-900 text-xs font-bold text-slate-900 dark:text-white">
                                        </div>
                                        <button type="button" @click="removePilar(index)" class="text-slate-400 hover:text-rose-500 p-1 cursor-pointer" title="Hapus Pilar">
                                            <i class="fa-solid fa-trash-can text-xs"></i>
                                        </button>
                                    </div>
                                    <textarea :name="'pilar_nilai[' + index + '][desc]'" x-model="pilar.desc" rows="2" placeholder="Deskripsi ringkas nilai pilar..." class="w-full px-2.5 py-1.5 rounded-lg border border-slate-200 dark:border-slate-700 bg-white dark:bg-slate-900 text-xs text-slate-600 dark:text-slate-300 leading-relaxed"></textarea>
                                </div>
                            </template>
                        </div>
                    </div>
                </div>
            </div>

        </div>

        <!-- ========================================================================= -->
        <!-- TAB 3: REKAM JEJAK ORGANISASI                                             -->
        <!-- ========================================================================= -->
        <div x-show="activeTab === 'organisasi'" class="space-y-6">
            
            <div class="bg-white dark:bg-slate-900 rounded-3xl border border-slate-200 dark:border-slate-800 p-6 sm:p-8 shadow-xs space-y-6">
                <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 pb-4 border-b border-slate-100 dark:border-slate-800">
                    <div>
                        <h3 class="text-base font-black text-slate-900 dark:text-white flex items-center gap-2">
                            <i class="fa-solid fa-sitemap text-amber-500"></i>
                            <span>Rekam Jejak Organisasi &amp; Pengabdian Masyarakat</span>
                        </h3>
                        <p class="text-xs text-slate-500 dark:text-slate-400 mt-1">
                            Daftar riwayat jabatan kepemimpinan di organisasi pers, kepemiluan, asosiasi dunia usaha, olahraga, dan kesenian.
                        </p>
                    </div>
                    <button type="button" @click="addOrganisasi()" class="inline-flex items-center gap-2 px-4 py-2.5 rounded-xl text-xs font-bold text-white bg-blue-600 hover:bg-blue-700 shadow-sm transition-all cursor-pointer shrink-0">
                        <i class="fa-solid fa-plus"></i>
                        <span>+ Tambah Organisasi</span>
                    </button>
                </div>

                <div class="space-y-4">
                    <template x-for="(item, index) in organisasi" :key="index">
                        <div class="p-5 rounded-2xl bg-slate-50 dark:bg-slate-800/60 border border-slate-200/80 dark:border-slate-700/60 grid grid-cols-1 md:grid-cols-12 gap-4 items-start relative">
                            
                            <div class="md:col-span-4 space-y-1">
                                <label class="block text-[11px] font-bold text-slate-600 dark:text-slate-400">Jabatan &amp; Organisasi <span class="text-rose-500">*</span></label>
                                <input type="text" :name="'organisasi[' + index + '][posisi]'" x-model="item.posisi" placeholder="Contoh: Ketua PWI Banyuasin" required class="w-full px-3 py-2 rounded-xl border border-slate-200 dark:border-slate-700 bg-white dark:bg-slate-900 text-xs font-bold text-slate-900 dark:text-white outline-none focus:ring-2 focus:ring-amber-500">
                            </div>

                            <div class="md:col-span-2 space-y-1">
                                <label class="block text-[11px] font-bold text-slate-600 dark:text-slate-400">Masa / Periode</label>
                                <input type="text" :name="'organisasi[' + index + '][masa]'" x-model="item.masa" placeholder="2025 – 2028" class="w-full px-3 py-2 rounded-xl border border-slate-200 dark:border-slate-700 bg-white dark:bg-slate-900 text-xs font-semibold text-slate-900 dark:text-white outline-none focus:ring-2 focus:ring-amber-500">
                            </div>

                            <div class="md:col-span-5 space-y-1">
                                <label class="block text-[11px] font-bold text-slate-600 dark:text-slate-400">Keterangan / Nomor SK / Lembaga</label>
                                <input type="text" :name="'organisasi[' + index + '][ket]'" x-model="item.ket" placeholder="Keterangan SK atau asosiasi..." class="w-full px-3 py-2 rounded-xl border border-slate-200 dark:border-slate-700 bg-white dark:bg-slate-900 text-xs text-slate-700 dark:text-slate-300 outline-none focus:ring-2 focus:ring-amber-500">
                            </div>

                            <div class="md:col-span-1 flex items-center justify-end pt-5">
                                <button type="button" @click="removeOrganisasi(index)" class="w-9 h-9 rounded-xl bg-rose-50 dark:bg-rose-950/40 text-rose-600 dark:text-rose-400 border border-rose-200 dark:border-rose-800 hover:bg-rose-100 flex items-center justify-center transition-colors cursor-pointer" title="Hapus Riwayat">
                                    <i class="fa-solid fa-trash-can text-xs"></i>
                                </button>
                            </div>

                        </div>
                    </template>
                </div>

                <div class="pt-2 flex justify-end">
                    <button type="button" @click="addOrganisasi()" class="inline-flex items-center gap-2 text-xs font-bold text-blue-600 dark:text-amber-400 hover:underline cursor-pointer">
                        <i class="fa-solid fa-plus"></i>
                        <span>Tambah Riwayat Organisasi Lainnya</span>
                    </button>
                </div>
            </div>

        </div>

        <!-- ========================================================================= -->
        <!-- TAB 4: PENDIDIKAN FORMAL                                                  -->
        <!-- ========================================================================= -->
        <div x-show="activeTab === 'pendidikan'" class="space-y-6">
            
            <div class="bg-white dark:bg-slate-900 rounded-3xl border border-slate-200 dark:border-slate-800 p-6 sm:p-8 shadow-xs space-y-6">
                <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 pb-4 border-b border-slate-100 dark:border-slate-800">
                    <div>
                        <h3 class="text-base font-black text-slate-900 dark:text-white flex items-center gap-2">
                            <i class="fa-solid fa-graduation-cap text-blue-500"></i>
                            <span>Pendidikan Formal &amp; Kualifikasi Akademik</span>
                        </h3>
                        <p class="text-xs text-slate-500 dark:text-slate-400 mt-1">
                            Kelola jejak pendidikan mulai dari pascasarjana, sarjana, diploma, hingga pendidikan menengah.
                        </p>
                    </div>
                    <button type="button" @click="addPendidikan()" class="inline-flex items-center gap-2 px-4 py-2.5 rounded-xl text-xs font-bold text-white bg-blue-600 hover:bg-blue-700 shadow-sm transition-all cursor-pointer shrink-0">
                        <i class="fa-solid fa-plus"></i>
                        <span>+ Tambah Pendidikan</span>
                    </button>
                </div>

                <div class="space-y-4">
                    <template x-for="(item, index) in pendidikan" :key="index">
                        <div class="p-5 rounded-2xl bg-slate-50 dark:bg-slate-800/60 border border-slate-200/80 dark:border-slate-700/60 grid grid-cols-1 md:grid-cols-12 gap-4 items-start relative">
                            
                            <div class="md:col-span-2 space-y-1">
                                <label class="block text-[11px] font-bold text-slate-600 dark:text-slate-400">Tingkat</label>
                                <input type="text" :name="'pendidikan[' + index + '][tingkat]'" x-model="item.tingkat" placeholder="Contoh: S1 (Sarjana)" class="w-full px-3 py-2 rounded-xl border border-slate-200 dark:border-slate-700 bg-white dark:bg-slate-900 text-xs font-bold text-slate-900 dark:text-white outline-none focus:ring-2 focus:ring-amber-500">
                            </div>

                            <div class="md:col-span-4 space-y-1">
                                <label class="block text-[11px] font-bold text-slate-600 dark:text-slate-400">Nama Sekolah / Perguruan Tinggi</label>
                                <input type="text" :name="'pendidikan[' + index + '][instansi]'" x-model="item.instansi" placeholder="Contoh: STISIPOL Candradimuka" required class="w-full px-3 py-2 rounded-xl border border-slate-200 dark:border-slate-700 bg-white dark:bg-slate-900 text-xs font-bold text-slate-900 dark:text-white outline-none focus:ring-2 focus:ring-amber-500">
                            </div>

                            <div class="md:col-span-3 space-y-1">
                                <label class="block text-[11px] font-bold text-slate-600 dark:text-slate-400">Program Studi / Jurusan</label>
                                <input type="text" :name="'pendidikan[' + index + '][prodi]'" x-model="item.prodi" placeholder="Ilmu Jurnalistik" class="w-full px-3 py-2 rounded-xl border border-slate-200 dark:border-slate-700 bg-white dark:bg-slate-900 text-xs text-slate-700 dark:text-slate-300 outline-none focus:ring-2 focus:ring-amber-500">
                            </div>

                            <div class="md:col-span-2 space-y-1">
                                <label class="block text-[11px] font-bold text-slate-600 dark:text-slate-400">Status Kelulusan</label>
                                <select :name="'pendidikan[' + index + '][status]'" x-model="item.status" class="w-full px-3 py-2 rounded-xl border border-slate-200 dark:border-slate-700 bg-white dark:bg-slate-900 text-xs font-semibold text-slate-900 dark:text-white outline-none focus:ring-2 focus:ring-amber-500 cursor-pointer">
                                    <option value="Lulus">Lulus</option>
                                    <option value="Sedang Ditempuh">Sedang Ditempuh</option>
                                    <option value="Non-Gelar">Non-Gelar</option>
                                </select>
                            </div>

                            <div class="md:col-span-1 flex items-center justify-end pt-5">
                                <button type="button" @click="removePendidikan(index)" class="w-9 h-9 rounded-xl bg-rose-50 dark:bg-rose-950/40 text-rose-600 dark:text-rose-400 border border-rose-200 dark:border-rose-800 hover:bg-rose-100 flex items-center justify-center transition-colors cursor-pointer" title="Hapus Pendidikan">
                                    <i class="fa-solid fa-trash-can text-xs"></i>
                                </button>
                            </div>

                        </div>
                    </template>
                </div>

                <div class="pt-2 flex justify-end">
                    <button type="button" @click="addPendidikan()" class="inline-flex items-center gap-2 text-xs font-bold text-blue-600 dark:text-amber-400 hover:underline cursor-pointer">
                        <i class="fa-solid fa-plus"></i>
                        <span>Tambah Riwayat Pendidikan Lainnya</span>
                    </button>
                </div>
            </div>

        </div>

        <!-- ========================================================================= -->
        <!-- TAB 5: SERTIFIKASI & PELATIHAN JURNALISTIK                                 -->
        <!-- ========================================================================= -->
        <div x-show="activeTab === 'sertifikasi'" class="space-y-6">
            
            <div class="bg-white dark:bg-slate-900 rounded-3xl border border-slate-200 dark:border-slate-800 p-6 sm:p-8 shadow-xs space-y-6">
                <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 pb-4 border-b border-slate-100 dark:border-slate-800">
                    <div>
                        <h3 class="text-base font-black text-slate-900 dark:text-white flex items-center gap-2">
                            <i class="fa-solid fa-certificate text-amber-500"></i>
                            <span>Sertifikasi &amp; Pelatihan Standarisasi Profesi</span>
                        </h3>
                        <p class="text-xs text-slate-500 dark:text-slate-400 mt-1">
                            Sertifikat Uji Kompetensi Wartawan (UKW) Dewan Pers, diklat investigasi, lokakarya lingkungan hidup, pemantau pemilu, dan keahlian profesi.
                        </p>
                    </div>
                    <button type="button" @click="addSertifikasi()" class="inline-flex items-center gap-2 px-4 py-2.5 rounded-xl text-xs font-bold text-white bg-blue-600 hover:bg-blue-700 shadow-sm transition-all cursor-pointer shrink-0">
                        <i class="fa-solid fa-plus"></i>
                        <span>+ Tambah Sertifikasi</span>
                    </button>
                </div>

                <div class="space-y-4">
                    <template x-for="(item, index) in sertifikasi" :key="index">
                        <div class="p-5 rounded-2xl bg-slate-50 dark:bg-slate-800/60 border border-slate-200/80 dark:border-slate-700/60 grid grid-cols-1 md:grid-cols-12 gap-4 items-start relative">
                            
                            <div class="md:col-span-4 space-y-1">
                                <label class="block text-[11px] font-bold text-slate-600 dark:text-slate-400">Bidang Sertifikasi / Pelatihan <span class="text-rose-500">*</span></label>
                                <input type="text" :name="'sertifikasi[' + index + '][bidang]'" x-model="item.bidang" placeholder="Uji Kompetensi Wartawan (UKW) Utama" required class="w-full px-3 py-2 rounded-xl border border-slate-200 dark:border-slate-700 bg-white dark:bg-slate-900 text-xs font-bold text-slate-900 dark:text-white outline-none focus:ring-2 focus:ring-amber-500">
                            </div>

                            <div class="md:col-span-3 space-y-1">
                                <label class="block text-[11px] font-bold text-slate-600 dark:text-slate-400">Penerbit / Penyelenggara</label>
                                <input type="text" :name="'sertifikasi[' + index + '][penerbit]'" x-model="item.penerbit" placeholder="Dewan Pers & PWI Pusat" class="w-full px-3 py-2 rounded-xl border border-slate-200 dark:border-slate-700 bg-white dark:bg-slate-900 text-xs font-semibold text-slate-700 dark:text-slate-300 outline-none focus:ring-2 focus:ring-amber-500">
                            </div>

                            <div class="md:col-span-2 space-y-1">
                                <label class="block text-[11px] font-bold text-slate-600 dark:text-slate-400">Nomor Registrasi / SK</label>
                                <input type="text" :name="'sertifikasi[' + index + '][nomor]'" x-model="item.nomor" placeholder="Nomor lisensi..." class="w-full px-3 py-2 rounded-xl border border-slate-200 dark:border-slate-700 bg-white dark:bg-slate-900 text-xs font-mono text-slate-700 dark:text-slate-300 outline-none focus:ring-2 focus:ring-amber-500">
                            </div>

                            <div class="md:col-span-2 space-y-1">
                                <label class="block text-[11px] font-bold text-slate-600 dark:text-slate-400">Tahun</label>
                                <input type="text" :name="'sertifikasi[' + index + '][tahun]'" x-model="item.tahun" placeholder="2018" class="w-full px-3 py-2 rounded-xl border border-slate-200 dark:border-slate-700 bg-white dark:bg-slate-900 text-xs font-semibold text-slate-900 dark:text-white outline-none focus:ring-2 focus:ring-amber-500">
                            </div>

                            <div class="md:col-span-1 flex items-center justify-end pt-5">
                                <button type="button" @click="removeSertifikasi(index)" class="w-9 h-9 rounded-xl bg-rose-50 dark:bg-rose-950/40 text-rose-600 dark:text-rose-400 border border-rose-200 dark:border-rose-800 hover:bg-rose-100 flex items-center justify-center transition-colors cursor-pointer" title="Hapus Sertifikasi">
                                    <i class="fa-solid fa-trash-can text-xs"></i>
                                </button>
                            </div>

                            <div class="md:col-span-11 space-y-1">
                                <label class="block text-[11px] font-bold text-slate-600 dark:text-slate-400">Keterangan Tambahan / Penguji</label>
                                <input type="text" :name="'sertifikasi[' + index + '][keterangan]'" x-model="item.keterangan" placeholder="Keterangan pencapaian atau penguji..." class="w-full px-3 py-2 rounded-xl border border-slate-200 dark:border-slate-700 bg-white dark:bg-slate-900 text-xs text-slate-600 dark:text-slate-400 outline-none focus:ring-2 focus:ring-amber-500">
                            </div>

                        </div>
                    </template>
                </div>

                <div class="pt-2 flex justify-end">
                    <button type="button" @click="addSertifikasi()" class="inline-flex items-center gap-2 text-xs font-bold text-blue-600 dark:text-amber-400 hover:underline cursor-pointer">
                        <i class="fa-solid fa-plus"></i>
                        <span>Tambah Sertifikasi / Pelatihan Lainnya</span>
                    </button>
                </div>
            </div>

        </div>

        <!-- ========================================================================= -->
        <!-- TAB 6: BANNER KEMITRAAN (FOOTER)                                          -->
        <!-- ========================================================================= -->
        <div x-show="activeTab === 'footer'" class="space-y-6">
            
            <div class="bg-white dark:bg-slate-900 rounded-3xl border border-slate-200 dark:border-slate-800 p-6 sm:p-8 shadow-xs space-y-5 max-w-4xl">
                <div>
                    <h3 class="text-base font-black text-slate-900 dark:text-white flex items-center gap-2">
                        <i class="fa-solid fa-handshake text-emerald-500"></i>
                        <span>Banner Kemitraan &amp; Jejaring Bawah (Footer)</span>
                    </h3>
                    <p class="text-xs text-slate-500 dark:text-slate-400 mt-1">
                        Sesuaikan judul, badge, dan teks ajakan silaturahmi yang muncul pada bagian bawah halaman portofolio.
                    </p>
                </div>

                <div class="space-y-4 pt-2">
                    <div>
                        <label class="block text-xs font-bold text-slate-700 dark:text-slate-300 mb-1">Badge Banner Kemitraan</label>
                        <input type="text" name="footer_badge" value="{{ old('footer_badge', $profile['footer_badge'] ?? 'Silaturahmi & Kemitraan Strategis') }}" class="w-full px-3.5 py-2.5 rounded-xl border border-slate-200 dark:border-slate-700 bg-slate-50 dark:bg-slate-800 text-xs font-semibold text-slate-900 dark:text-white outline-none focus:ring-2 focus:ring-amber-500">
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-slate-700 dark:text-slate-300 mb-1">Judul Utama Banner</label>
                        <input type="text" name="footer_title" value="{{ old('footer_title', $profile['footer_title'] ?? 'Terhubung Langsung dengan Wardoyo, S.I.Kom.') }}" class="w-full px-3.5 py-2.5 rounded-xl border border-slate-200 dark:border-slate-700 bg-slate-50 dark:bg-slate-800 text-xs font-bold text-slate-900 dark:text-white outline-none focus:ring-2 focus:ring-amber-500">
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-slate-700 dark:text-slate-300 mb-1">Deskripsi &amp; Narasi Ajakan</label>
                        <textarea name="footer_desc" rows="4" class="w-full px-3.5 py-2.5 rounded-xl border border-slate-200 dark:border-slate-700 bg-slate-50 dark:bg-slate-800 text-xs text-slate-900 dark:text-white outline-none focus:ring-2 focus:ring-amber-500 leading-relaxed">{{ old('footer_desc', $profile['footer_desc'] ?? '') }}</textarea>
                    </div>
                </div>
            </div>

        </div>

        <!-- Sticky Bottom Save Bar -->
        <div class="sticky bottom-4 z-20 mt-8 p-4 rounded-2xl bg-[#0B132B] text-white shadow-2xl border border-blue-900/60 flex items-center justify-between gap-4">
            <div class="flex items-center gap-3">
                <span class="w-2.5 h-2.5 rounded-full bg-emerald-400 animate-ping"></span>
                <span class="text-xs font-bold text-slate-200">Perubahan akan langsung terpublikasi di halaman <a href="{{ route('chairman.archive.index') }}" target="_blank" class="text-amber-400 underline">/wardoyo</a></span>
            </div>
            <div class="flex items-center gap-2">
                <button type="submit" class="inline-flex items-center gap-2 px-6 py-2.5 rounded-xl text-xs font-black text-slate-950 bg-amber-400 hover:bg-amber-300 shadow-md transition-all cursor-pointer">
                    <i class="fa-solid fa-floppy-disk"></i>
                    <span>Simpan Seluruh Perubahan</span>
                </button>
            </div>
        </div>

    </form>

</div>
@endsection
