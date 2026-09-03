@extends('layouts.admin')

@section('title', 'Edit Artikel Berita')
@section('page_title', 'Edit Berita')

@section('content')
<div class="max-w-5xl mx-auto space-y-6">
    
    <div class="flex items-center justify-between">
        <div>
            <h2 class="text-xl font-extrabold text-white">Edit Artikel Berita</h2>
            <p class="text-xs text-slate-400 mt-1 truncate max-w-lg">{{ $post->judul }}</p>
        </div>
        <a href="{{ $post->status === 'published' ? route('admin.posts.publish') : route('admin.posts.draft') }}" class="px-4 py-2 rounded-xl text-xs font-semibold text-slate-300 bg-slate-900 border border-slate-800 hover:text-white">
            <i class="fa-solid fa-arrow-left me-1"></i> Kembali
        </a>
    </div>

    <form action="{{ route('admin.posts.update', $post->id) }}" method="POST" enctype="multipart/form-data" class="space-y-6">
        @csrf
        @method('PUT')

        <div class="p-8 rounded-3xl bg-slate-900 border border-slate-800 shadow-xl space-y-6">
            
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <div class="md:col-span-2">
                    <label class="block text-xs font-bold text-slate-300 uppercase mb-2">Judul Artikel Berita *</label>
                    <input type="text" name="judul" value="{{ old('judul', $post->judul) }}" required class="w-full px-4 py-3 rounded-xl bg-slate-950 border border-slate-800 text-sm text-white focus:ring-2 focus:ring-amber-500 outline-none">
                </div>

                <div>
                    <label class="block text-xs font-bold text-slate-300 uppercase mb-2">Kategori Berita *</label>
                    <input type="text" name="kategori" value="{{ old('kategori', $post->kategori) }}" required class="w-full px-4 py-3 rounded-xl bg-slate-950 border border-slate-800 text-sm text-white focus:ring-2 focus:ring-amber-500 outline-none">
                </div>

                <div>
                    <label class="block text-xs font-bold text-slate-300 uppercase mb-2">Penulis / Jurnalis *</label>
                    <input type="text" name="penulis" value="{{ old('penulis', $post->penulis) }}" required class="w-full px-4 py-2.5 rounded-xl bg-slate-950 border border-slate-800 text-xs text-white focus:ring-2 focus:ring-amber-500 outline-none">
                </div>

                <div>
                    <label class="block text-xs font-bold text-slate-300 uppercase mb-2">Status Publikasi *</label>
                    <select name="status" class="w-full px-4 py-2.5 rounded-xl bg-slate-950 border border-slate-800 text-xs text-white focus:ring-2 focus:ring-amber-500 outline-none">
                        <option value="published" {{ $post->status === 'published' ? 'selected' : '' }}>Publikasikan (Published)</option>
                        <option value="draft" {{ $post->status === 'draft' ? 'selected' : '' }}>Simpan sebagai Draf (Draft)</option>
                    </select>
                </div>

                <div>
                    <label class="block text-xs font-bold text-slate-300 uppercase mb-2">Ganti Thumbnail (Opsional)</label>
                    <input type="file" name="gambar" class="w-full px-4 py-2 rounded-xl bg-slate-950 border border-slate-800 text-xs text-slate-400 file:mr-3 file:py-1.5 file:px-3 file:rounded-lg file:border-0 file:text-xs file:font-semibold file:bg-amber-400 file:text-slate-950">
                </div>

                <div class="md:col-span-3">
                    <label class="block text-xs font-bold text-slate-300 uppercase mb-2">Ringkasan Berita (Lead Paragraph)</label>
                    <textarea name="ringkasan" rows="2" class="w-full px-4 py-2.5 rounded-xl bg-slate-950 border border-slate-800 text-xs text-white focus:ring-2 focus:ring-amber-500 outline-none">{{ old('ringkasan', $post->ringkasan) }}</textarea>
                </div>

                <div class="md:col-span-3">
                    <label class="block text-xs font-bold text-slate-300 uppercase mb-2">Konten Lengkap Berita *</label>
                    <textarea name="konten" rows="12" required class="w-full px-4 py-3 rounded-xl bg-slate-950 border border-slate-800 text-sm text-white focus:ring-2 focus:ring-amber-500 outline-none font-sans">{{ old('konten', $post->konten) }}</textarea>
                </div>
            </div>

            <div class="flex items-center justify-end gap-3 pt-6 border-t border-slate-800">
                <a href="{{ $post->status === 'published' ? route('admin.posts.publish') : route('admin.posts.draft') }}" class="px-6 py-3 rounded-xl text-xs font-bold text-slate-400 hover:text-white bg-slate-950">
                    Batal
                </a>
                <button type="submit" class="px-8 py-3 rounded-xl text-xs font-bold text-white bg-blue-600 hover:bg-blue-500 shadow-lg shadow-blue-600/20 transition-all flex items-center gap-2">
                    <i class="fa-solid fa-save"></i>
                    <span>Simpan Perubahan</span>
                </button>
            </div>

        </div>
    </form>

</div>
@endsection
