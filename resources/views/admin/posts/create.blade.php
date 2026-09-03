@extends('layouts.admin')

@section('title', 'Tulis Artikel Berita Baru')
@section('page_title', 'Tulis Berita')

@section('content')
<div class="max-w-5xl mx-auto space-y-6">
    
    <div class="flex items-center justify-between">
        <div>
            <h2 class="text-xl font-extrabold text-white">Tulis Artikel & Publikasi Berita</h2>
            <p class="text-xs text-slate-400 mt-1">Publikasi liputan kegiatan, rilis pers, dan informasi resmi PWI Kabupaten Banyuasin</p>
        </div>
        <a href="{{ route('admin.posts.publish') }}" class="px-4 py-2 rounded-xl text-xs font-semibold text-slate-300 bg-slate-900 border border-slate-800 hover:text-white">
            <i class="fa-solid fa-arrow-left me-1"></i> Kembali
        </a>
    </div>

    <form action="{{ route('admin.posts.store') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
        @csrf

        <div class="p-8 rounded-3xl bg-slate-900 border border-slate-800 shadow-xl space-y-6">
            
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <div class="md:col-span-2">
                    <label class="block text-xs font-bold text-slate-300 uppercase mb-2">Judul Artikel Berita *</label>
                    <input type="text" name="judul" value="{{ old('judul') }}" required class="w-full px-4 py-3 rounded-xl bg-slate-950 border border-slate-800 text-sm text-white focus:ring-2 focus:ring-amber-500 outline-none" placeholder="Masukkan judul berita yang informatif...">
                </div>

                <div>
                    <label class="block text-xs font-bold text-slate-300 uppercase mb-2">Kategori Berita *</label>
                    <input type="text" name="kategori" value="{{ old('kategori', 'Kegiatan') }}" required class="w-full px-4 py-3 rounded-xl bg-slate-950 border border-slate-800 text-sm text-white focus:ring-2 focus:ring-amber-500 outline-none" placeholder="Kegiatan / Kemitraan / Organisasi">
                </div>

                <div>
                    <label class="block text-xs font-bold text-slate-300 uppercase mb-2">Penulis / Jurnalis *</label>
                    <input type="text" name="penulis" value="{{ old('penulis', 'Wardoyo, S.I.Kom') }}" required class="w-full px-4 py-2.5 rounded-xl bg-slate-950 border border-slate-800 text-xs text-white focus:ring-2 focus:ring-amber-500 outline-none">
                </div>

                <div>
                    <label class="block text-xs font-bold text-slate-300 uppercase mb-2">Status Publikasi *</label>
                    <select name="status" class="w-full px-4 py-2.5 rounded-xl bg-slate-950 border border-slate-800 text-xs text-white focus:ring-2 focus:ring-amber-500 outline-none">
                        <option value="published" selected>Publikasikan Langsung (Published)</option>
                        <option value="draft">Simpan sebagai Draf (Draft)</option>
                    </select>
                </div>

                <div>
                    <label class="block text-xs font-bold text-slate-300 uppercase mb-2">Foto / Thumbnail Utama</label>
                    <input type="file" name="gambar" class="w-full px-4 py-2 rounded-xl bg-slate-950 border border-slate-800 text-xs text-slate-400 file:mr-3 file:py-1.5 file:px-3 file:rounded-lg file:border-0 file:text-xs file:font-semibold file:bg-amber-400 file:text-slate-950">
                </div>

                <div class="md:col-span-3">
                    <label class="block text-xs font-bold text-slate-300 uppercase mb-2">Ringkasan Berita (Lead Paragraph)</label>
                    <textarea name="ringkasan" rows="2" class="w-full px-4 py-2.5 rounded-xl bg-slate-950 border border-slate-800 text-xs text-white focus:ring-2 focus:ring-amber-500 outline-none" placeholder="Ringkasan singkat 1-2 kalimat pembuka berita...">{{ old('ringkasan') }}</textarea>
                </div>

                <div class="md:col-span-3">
                    <label class="block text-xs font-bold text-slate-300 uppercase mb-2">Konten Lengkap Berita *</label>
                    <textarea name="konten" rows="12" required class="w-full px-4 py-3 rounded-xl bg-slate-950 border border-slate-800 text-sm text-white focus:ring-2 focus:ring-amber-500 outline-none font-sans" placeholder="Tuliskan isi berita selengkapnya di sini...">{{ old('konten') }}</textarea>
                </div>
            </div>

            <div class="flex items-center justify-end gap-3 pt-6 border-t border-slate-800">
                <a href="{{ route('admin.posts.publish') }}" class="px-6 py-3 rounded-xl text-xs font-bold text-slate-400 hover:text-white bg-slate-950">
                    Batal
                </a>
                <button type="submit" class="px-8 py-3 rounded-xl text-xs font-bold text-slate-950 bg-amber-400 hover:bg-amber-300 shadow-lg shadow-amber-400/20 transition-all flex items-center gap-2">
                    <i class="fa-solid fa-paper-plane"></i>
                    <span>Simpan & Terbitkan Berita</span>
                </button>
            </div>

        </div>
    </form>

</div>
@endsection
