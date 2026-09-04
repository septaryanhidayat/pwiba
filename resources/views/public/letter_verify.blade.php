@extends('layouts.public')

@section('title', $letter ? 'Verifikasi Keabsahan Surat: ' . $letter->nomor_surat : 'Verifikasi Surat Tidak Ditemukan')

@section('content')
<div class="py-16 bg-slate-50 dark:bg-slate-950 min-h-screen transition-colors duration-200">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">

        @if($letter)
            <!-- Kartu Verifikasi Resmi Sukses -->
            <div class="bg-white dark:bg-slate-900 rounded-3xl shadow-xl border border-slate-200/80 dark:border-slate-800 overflow-hidden">
                
                <!-- Top Header Banner Deep Blue PWI -->
                <div class="bg-[#0B2B68] text-white p-6 sm:p-8 text-center relative overflow-hidden">
                    <div class="relative z-10 flex flex-col items-center">
                        <img src="{{ $settings['logo_url'] ?? asset('assets/images/pwi-logo.png') }}" alt="Logo PWI" width="80" height="80" class="w-20 h-20 mb-3 drop-shadow-md">
                        <span class="px-3.5 py-1 rounded-full text-xs font-extrabold uppercase tracking-widest bg-white/15 text-amber-300 border border-white/20 mb-2">
                            Sistem Verifikasi Digital Dokumen Resmi
                        </span>
                        <h1 class="text-2xl sm:text-3xl font-black tracking-tight uppercase">
                            PERSATUAN WARTAWAN INDONESIA
                        </h1>
                        <h2 class="text-lg sm:text-xl font-bold text-slate-200 mt-0.5">
                            PENGURUS KABUPATEN BANYUASIN
                        </h2>
                        <p class="text-xs text-slate-300 mt-2 max-w-xl">
                            {{ $settings['alamat_kantor'] ?? 'Jalan Merdeka NO 3 RT 02 RW 02 Kelurahan Mulya Agung Kecamatan Banyuasin III Kabupaten Banyuasin - Sumatera Selatan' }}
                        </p>
                    </div>
                </div>

                <!-- Status Keabsahan Badge -->
                <div class="bg-emerald-50 dark:bg-emerald-950/50 border-y border-emerald-200 dark:border-emerald-800/60 p-6 flex flex-col sm:flex-row items-center gap-4 text-center sm:text-left">
                    <div class="w-16 h-16 rounded-2xl bg-emerald-500 text-white flex items-center justify-center text-3xl shadow-lg shadow-emerald-500/30 flex-shrink-0">
                        <i class="fa-solid fa-shield-check"></i>
                    </div>
                    <div>
                        <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full text-xs font-extrabold uppercase tracking-wider bg-emerald-100 dark:bg-emerald-900/60 text-emerald-800 dark:text-emerald-300 border border-emerald-300 dark:border-emerald-700">
                            <i class="fa-solid fa-circle-check text-emerald-600 dark:text-emerald-400"></i> DOKUMEN SAH & TERVERIFIKASI
                        </div>
                        <h3 class="text-lg font-black text-slate-900 dark:text-white mt-1">
                            Surat Resmi Terdaftar di Buku Registrasi PWI Banyuasin
                        </h3>
                        <p class="text-xs text-slate-600 dark:text-slate-300 mt-0.5">
                            Data di bawah ini dicocokkan langsung secara *real-time* dengan basis data arsip surat resmi untuk mencegah pemalsuan dan penyalahgunaan dokumen.
                        </p>
                    </div>
                </div>

                <!-- Rincian Dokumen Surat -->
                <div class="p-6 sm:p-8 space-y-6">
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div class="p-4 rounded-2xl bg-slate-50 dark:bg-slate-800/60 border border-slate-200/80 dark:border-slate-700/60">
                            <span class="text-[11px] font-bold text-slate-400 uppercase tracking-wider block">Nomor Surat Resmi</span>
                            <span class="text-base font-black text-blue-900 dark:text-blue-300 break-all">{{ $letter->nomor_surat }}</span>
                        </div>

                        <div class="p-4 rounded-2xl bg-slate-50 dark:bg-slate-800/60 border border-slate-200/80 dark:border-slate-700/60">
                            <span class="text-[11px] font-bold text-slate-400 uppercase tracking-wider block">Tanggal Diterbitkan</span>
                            <span class="text-base font-bold text-slate-900 dark:text-white">
                                {{ $letter->tanggal ? $letter->tanggal->translatedFormat('d F Y') : '-' }}
                            </span>
                        </div>

                        <div class="p-4 rounded-2xl bg-slate-50 dark:bg-slate-800/60 border border-slate-200/80 dark:border-slate-700/60">
                            <span class="text-[11px] font-bold text-slate-400 uppercase tracking-wider block">Jenis Surat</span>
                            <span class="text-sm font-extrabold px-2.5 py-0.5 rounded-lg bg-blue-100 dark:bg-blue-950 text-blue-800 dark:text-blue-300 border border-blue-200 dark:border-blue-800 inline-block mt-1">
                                {{ $letter->jenis_surat }}
                            </span>
                        </div>

                        <div class="p-4 rounded-2xl bg-slate-50 dark:bg-slate-800/60 border border-slate-200/80 dark:border-slate-700/60">
                            <span class="text-[11px] font-bold text-slate-400 uppercase tracking-wider block">Lampiran</span>
                            <span class="text-sm font-bold text-slate-800 dark:text-slate-200">
                                {{ $letter->lampiran ?? '1 (Satu) Berkas' }}
                            </span>
                        </div>
                    </div>

                    <!-- Penerima & Perihal -->
                    <div class="p-5 rounded-2xl bg-white dark:bg-slate-800/90 border border-slate-200 dark:border-slate-700">
                        <div class="mb-3">
                            <span class="text-[11px] font-bold text-slate-400 uppercase tracking-wider block">Ditujukan Kepada</span>
                            <span class="text-base font-extrabold text-slate-900 dark:text-white">
                                {{ $letter->jabatan_pejabat ?? ($letter->tujuan ?? 'Pihak Terkait') }}
                            </span>
                            @if($letter->nama_pejabat && $letter->nama_pejabat !== $letter->tujuan)
                                <div class="text-sm font-medium text-slate-600 dark:text-slate-400">{{ $letter->nama_pejabat }}</div>
                            @endif
                            <div class="text-xs text-slate-500 dark:text-slate-400 mt-0.5">
                                {{ $letter->tempat_tujuan ?? ($letter->alamat_tujuan ?? 'Di Tempat') }}
                            </div>
                        </div>

                        <div class="pt-3 border-t border-slate-100 dark:border-slate-700">
                            <span class="text-[11px] font-bold text-slate-400 uppercase tracking-wider block">Perihal / Keperluan</span>
                            <p class="text-sm font-bold text-slate-800 dark:text-slate-200 mt-0.5">
                                {{ $letter->perihal ?? $letter->keperluan }}
                            </p>
                        </div>
                    </div>

                    <!-- Penandatangan Sah -->
                    <div class="p-5 rounded-2xl bg-slate-50 dark:bg-slate-800/50 border border-slate-200/80 dark:border-slate-700/60">
                        <span class="text-xs font-extrabold uppercase tracking-wider text-slate-700 dark:text-slate-300 block mb-3">
                            Pejabat Penandatangan Sah Dokumen
                        </span>
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                            <div class="flex items-center gap-3 p-3 rounded-xl bg-white dark:bg-slate-800 border border-slate-200 dark:border-slate-700">
                                <div class="w-10 h-10 rounded-full bg-blue-100 dark:bg-blue-900/60 text-blue-700 dark:text-blue-300 flex items-center justify-center font-bold">
                                    <i class="fa-solid fa-signature"></i>
                                </div>
                                <div>
                                    <div class="text-xs font-black text-slate-900 dark:text-white">{{ $letter->penandatangan_nama ?? 'Wardoyo, S.I.Kom' }}</div>
                                    <div class="text-[11px] text-blue-600 dark:text-blue-400 font-bold">Ketua PWI Kabupaten Banyuasin</div>
                                </div>
                            </div>
                            <div class="flex items-center gap-3 p-3 rounded-xl bg-white dark:bg-slate-800 border border-slate-200 dark:border-slate-700">
                                <div class="w-10 h-10 rounded-full bg-indigo-100 dark:bg-indigo-900/60 text-indigo-700 dark:text-indigo-300 flex items-center justify-center font-bold">
                                    <i class="fa-solid fa-signature"></i>
                                </div>
                                <div>
                                    <div class="text-xs font-black text-slate-900 dark:text-white">{{ $letter->penandatangan_sekretaris ?? 'Deni Arianto' }}</div>
                                    <div class="text-[11px] text-indigo-600 dark:text-indigo-400 font-bold">Sekretaris PWI Kabupaten Banyuasin</div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Hash Integritas Kriptografi -->
                    <div class="p-4 rounded-xl bg-slate-100 dark:bg-slate-800/80 border border-slate-200 dark:border-slate-700 font-mono text-[11px] text-slate-600 dark:text-slate-400 break-all">
                        <span class="font-bold text-slate-800 dark:text-slate-200 block mb-1">
                            <i class="fa-solid fa-fingerprint text-blue-600"></i> Hash Integritas Dokumen (SHA-256):
                        </span>
                        {{ $letter->hash_keabsahan ?? hash('sha256', $letter->nomor_surat . '|' . $letter->tanggal . '|' . $letter->tujuan . '|PWI-BANYUASIN-OFFICIAL') }}
                    </div>

                    <!-- Peringatan Hukum -->
                    <div class="p-4 rounded-2xl bg-amber-50 dark:bg-amber-950/40 border border-amber-200 dark:border-amber-800/60 text-amber-900 dark:text-amber-300 text-xs leading-relaxed flex items-start gap-3">
                        <i class="fa-solid fa-triangle-exclamation text-amber-600 text-base mt-0.5"></i>
                        <div>
                            <strong>Pencegahan Penyalahgunaan Surat:</strong>
                            Surat ini sah bila rincian yang tercetak pada dokumen fisik identik dengan data pada halaman verifikasi resmi ini. Setiap perubahan, pemalsuan nomor surat, atau pemalsuan tanda tangan merupakan pelanggaran hukum dan dapat ditindaklanjuti secara pidana.
                        </div>
                    </div>

                    <!-- Action Buttons -->
                    <div class="pt-4 flex flex-wrap items-center justify-between gap-3">
                        <a href="{{ route('home') }}" class="inline-flex items-center gap-2 px-5 py-2.5 rounded-xl bg-slate-100 dark:bg-slate-800 hover:bg-slate-200 dark:hover:bg-slate-700 text-slate-700 dark:text-slate-200 text-xs font-bold transition-all">
                            <i class="fa-solid fa-arrow-left"></i> Kembali ke Beranda PWI
                        </a>
                        <a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', $settings['no_telp'] ?? '085377991976') }}?text={{ urlencode('Halo Sekretariat PWI Banyuasin, saya ingin mengonfirmasi surat nomor: ' . $letter->nomor_surat) }}" target="_blank" rel="noopener noreferrer" class="inline-flex items-center gap-2 px-5 py-2.5 rounded-xl bg-emerald-600 hover:bg-emerald-700 text-white text-xs font-bold transition-all shadow-md">
                            <i class="fa-brands fa-whatsapp text-sm"></i> Konfirmasi Sekretariat PWI
                        </a>
                    </div>

                </div>

            </div>

        @else
            <!-- Kartu Verifikasi Gagal / Tidak Valid -->
            <div class="bg-white dark:bg-slate-900 rounded-3xl shadow-xl border border-rose-200 dark:border-rose-900 overflow-hidden text-center p-8 sm:p-12">
                <div class="w-20 h-20 rounded-full bg-rose-100 dark:bg-rose-950 text-rose-600 flex items-center justify-center text-4xl mx-auto mb-5">
                    <i class="fa-solid fa-shield-xmark"></i>
                </div>
                <h2 class="text-2xl font-black text-slate-900 dark:text-white">
                    Dokumen Tidak Terdaftar / Tidak Valid
                </h2>
                <p class="text-sm text-slate-600 dark:text-slate-400 mt-2 max-w-lg mx-auto">
                    Kode verifikasi atau nomor surat <span class="font-mono font-bold text-rose-600">"{{ $hash }}"</span> tidak ditemukan dalam basis data resmi register surat keluar PWI Kabupaten Banyuasin.
                </p>

                <div class="p-4 rounded-2xl bg-rose-50 dark:bg-rose-950/40 border border-rose-200 dark:border-rose-800 text-xs text-rose-800 dark:text-rose-300 max-w-xl mx-auto my-6 text-left">
                    <strong>PERINGATAN:</strong> Harap waspada terhadap indikasi surat palsu atau nomor yang tidak terdaftar. Segera laporkan kepada Sekretariat PWI Kabupaten Banyuasin untuk penyelidikan lebih lanjut.
                </div>

                <div class="flex items-center justify-center gap-4">
                    <a href="{{ route('home') }}" class="px-6 py-2.5 rounded-xl bg-slate-900 text-white font-bold text-xs hover:bg-blue-600 transition-colors">
                        Kembali ke Website Resmi
                    </a>
                </div>
            </div>
        @endif

    </div>
</div>
@endsection
