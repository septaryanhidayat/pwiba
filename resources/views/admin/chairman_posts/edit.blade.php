@extends('layouts.admin')

@section('title', 'Sunting Karya Tulis Ketua: ' . $post->title)
@section('page_title', 'Sunting Arsip Ketua')

@section('content')
<div class="max-w-5xl mx-auto space-y-6">
    
    <!-- Top Navigation & Breadcrumb -->
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
        <div>
            <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-amber-400/10 border border-amber-400/20 text-amber-600 dark:text-amber-400 text-xs font-bold uppercase tracking-wider mb-2">
                <i class="fa-solid fa-pen-to-square"></i>
                <span>Perbarui Data Arsip</span>
            </div>
            <h2 class="text-xl sm:text-2xl font-black text-[#0B132B] dark:text-white">Sunting Tulisan & Esai Pemikiran Ketua</h2>
            <p class="text-xs text-slate-600 dark:text-slate-400 mt-1 font-medium">
                Ubah konten, kategori, atau metadata tulisan di dalam arsip digital karya tulisan Ketua.
            </p>
        </div>
        <div class="flex items-center gap-2 shrink-0">
            <a href="{{ route('chairman.archive.show', $post->slug) }}" target="_blank" class="px-4 py-2 rounded-xl text-xs font-bold text-blue-700 dark:text-blue-300 bg-blue-50 dark:bg-blue-950/60 border border-blue-200 dark:border-blue-800 hover:bg-blue-100 shadow-xs transition-all flex items-center gap-2">
                <i class="fa-solid fa-arrow-up-right-from-square"></i>
                <span>Tinjau Publik</span>
            </a>
            <a href="{{ route('admin.chairman_posts.index') }}" class="px-4 py-2 rounded-xl text-xs font-bold text-slate-700 dark:text-slate-200 bg-white dark:bg-slate-800 border border-slate-300 dark:border-slate-700 hover:bg-slate-50 dark:hover:bg-slate-700 shadow-xs transition-all flex items-center gap-2">
                <i class="fa-solid fa-arrow-left"></i>
                <span>Kembali</span>
            </a>
        </div>
    </div>

    <!-- Error Validation -->
    @if ($errors->any())
        <div class="p-4 rounded-2xl bg-rose-50 dark:bg-rose-950/50 border border-rose-200 dark:border-rose-800 text-rose-800 dark:text-rose-200 text-xs space-y-1 shadow-xs">
            <div class="font-bold flex items-center gap-2">
                <i class="fa-solid fa-triangle-exclamation text-rose-500"></i>
                <span>Terdapat kesalahan pada isian formulir:</span>
            </div>
            <ul class="list-disc list-inside pl-2 space-y-0.5">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <!-- Form Container -->
    <form action="{{ route('admin.chairman_posts.update', $post->id) }}" method="POST" class="space-y-6">
        @csrf
        @method('PUT')

        <div class="p-6 sm:p-8 rounded-2xl bg-white dark:bg-slate-900 border border-slate-300 dark:border-slate-800 shadow-sm space-y-6">
            
            <div class="grid grid-cols-1 md:grid-cols-12 gap-6">
                
                <!-- Judul Tulisan (8 Cols) -->
                <div class="md:col-span-8">
                    <label class="block text-xs font-bold text-slate-700 dark:text-slate-300 uppercase tracking-wider mb-2">
                        Judul Karya Tulis / Esai / Catatan *
                    </label>
                    <input type="text" name="title" value="{{ old('title', $post->title) }}" required class="w-full px-4 py-3 rounded-xl bg-white dark:bg-slate-950 border border-slate-300 dark:border-slate-700 text-sm font-semibold text-slate-900 dark:text-white focus:ring-2 focus:ring-blue-600 outline-none shadow-xs" placeholder="Masukkan judul artikel...">
                    <div class="text-[11px] text-slate-500 dark:text-slate-400 mt-1 flex items-center gap-2">
                        <span>Slug URL:</span>
                        <code class="font-mono text-blue-600 dark:text-amber-400 bg-slate-100 dark:bg-slate-800 px-2 py-0.5 rounded">{{ $post->slug }}</code>
                    </div>
                </div>

                <!-- Kategori (4 Cols) -->
                <div class="md:col-span-4">
                    <label class="block text-xs font-bold text-slate-700 dark:text-slate-300 uppercase tracking-wider mb-2">
                        Kategori Tulisan *
                    </label>
                    <input type="text" name="category" list="categoryList" value="{{ old('category', $post->category) }}" required class="w-full px-4 py-3 rounded-xl bg-white dark:bg-slate-950 border border-slate-300 dark:border-slate-700 text-sm font-semibold text-slate-900 dark:text-white focus:ring-2 focus:ring-blue-600 outline-none shadow-xs" placeholder="Pilih atau ketik kategori baru...">
                    <datalist id="categoryList">
                        @foreach($existingCategories as $cat)
                            <option value="{{ $cat }}"></option>
                        @endforeach
                        <option value="Jurnalistik & Pers"></option>
                        <option value="Opini & Esai"></option>
                        <option value="Teori Komunikasi"></option>
                        <option value="Hukum & Etika Pers"></option>
                        <option value="Sosial & Budaya"></option>
                        <option value="Politik & Pemerintahan"></option>
                    </datalist>
                </div>

                <!-- Waktu Terbit / Rilis (4 Cols) -->
                <div class="md:col-span-4">
                    <div class="flex items-center justify-between mb-2">
                        <label class="block text-xs font-bold text-slate-700 dark:text-slate-300 uppercase tracking-wider">
                            <i class="fa-regular fa-clock text-amber-500 me-1"></i> Tanggal Rilis
                        </label>
                        <button type="button" onclick="document.getElementById('published_at').value = '{{ now()->format('Y-m-d\TH:i') }}'" class="text-[10px] font-bold text-blue-600 dark:text-amber-400 hover:underline cursor-pointer">
                            Saat Ini
                        </button>
                    </div>
                    <input type="datetime-local" id="published_at" name="published_at" value="{{ old('published_at', $post->published_at ? $post->published_at->format('Y-m-d\TH:i') : '') }}" class="w-full px-4 py-2.5 rounded-xl bg-white dark:bg-slate-950 border border-slate-300 dark:border-slate-700 text-xs font-semibold text-slate-900 dark:text-white focus:ring-2 focus:ring-blue-600 outline-none shadow-xs">
                </div>

                <!-- Estimasi Waktu Baca (4 Cols) -->
                <div class="md:col-span-4">
                    <label class="block text-xs font-bold text-slate-700 dark:text-slate-300 uppercase tracking-wider mb-2">
                        <i class="fa-solid fa-stopwatch text-slate-400 me-1"></i> Estimasi Waktu Baca (Menit)
                    </label>
                    <input type="number" min="1" max="120" name="reading_time" value="{{ old('reading_time', $post->reading_time) }}" class="w-full px-4 py-2.5 rounded-xl bg-white dark:bg-slate-950 border border-slate-300 dark:border-slate-700 text-xs font-semibold text-slate-900 dark:text-white focus:ring-2 focus:ring-blue-600 outline-none shadow-xs" placeholder="Contoh: 3">
                </div>

                <!-- Tautan Sumber Asli (4 Cols) -->
                <div class="md:col-span-4">
                    <label class="block text-xs font-bold text-slate-700 dark:text-slate-300 uppercase tracking-wider mb-2">
                        <i class="fa-brands fa-wordpress text-blue-500 me-1"></i> URL Asli WordPress (Opsional)
                    </label>
                    <input type="url" name="original_url" value="{{ old('original_url', $post->original_url) }}" class="w-full px-4 py-2.5 rounded-xl bg-white dark:bg-slate-950 border border-slate-300 dark:border-slate-700 text-xs font-medium text-slate-900 dark:text-white focus:ring-2 focus:ring-blue-600 outline-none shadow-xs" placeholder="https://wardianst.wordpress.com/...">
                </div>

                <!-- Ringkasan / Lead (12 Cols) -->
                <div class="md:col-span-12">
                    <label class="block text-xs font-bold text-slate-700 dark:text-slate-300 uppercase tracking-wider mb-2">
                        Ringkasan / Cuplikan Singkat (Lead Excerpt)
                    </label>
                    <textarea name="excerpt" rows="2" class="w-full px-4 py-2.5 rounded-xl bg-white dark:bg-slate-950 border border-slate-300 dark:border-slate-700 text-xs font-medium text-slate-900 dark:text-white focus:ring-2 focus:ring-blue-600 outline-none shadow-xs" placeholder="1-2 kalimat pengantar tulisan...">{{ old('excerpt', $post->excerpt) }}</textarea>
                </div>

                <!-- Konten Lengkap (12 Cols) -->
                <div class="md:col-span-12">
                    <label class="block text-xs font-bold text-slate-700 dark:text-slate-300 uppercase tracking-wider mb-2">
                        Isi Lengkap Karya Tulis / Artikel *
                    </label>
                    <textarea name="content" id="content" rows="14" required class="rich-editor w-full px-4 py-3 rounded-xl bg-white dark:bg-slate-950 border border-slate-300 dark:border-slate-700 text-sm leading-relaxed text-slate-900 dark:text-white focus:ring-2 focus:ring-blue-600 outline-none shadow-xs font-sans" placeholder="Tuliskan naskah lengkap...">{{ old('content', $post->content) }}</textarea>
                </div>

            </div>

            <!-- Action Buttons -->
            <div class="flex items-center justify-between pt-6 border-t border-slate-200 dark:border-slate-800">
                <div class="text-xs text-slate-500 dark:text-slate-400">
                    <i class="fa-regular fa-eye text-blue-500 me-1"></i> Total dibaca: <strong>{{ number_format($post->views_count) }} kali</strong>
                </div>
                <div class="flex items-center gap-3">
                    <a href="{{ route('admin.chairman_posts.index') }}" class="px-6 py-2.5 rounded-xl text-xs font-bold text-slate-600 dark:text-slate-400 hover:bg-slate-100 dark:hover:bg-slate-800 transition-colors">
                        Batal
                    </a>
                    <button type="submit" class="px-8 py-2.5 rounded-xl text-xs font-bold text-white bg-blue-600 hover:bg-blue-700 shadow-sm transition-all flex items-center gap-2">
                        <i class="fa-solid fa-floppy-disk"></i>
                        <span>Simpan Perubahan</span>
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
