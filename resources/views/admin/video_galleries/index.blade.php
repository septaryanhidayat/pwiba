@extends('layouts.admin')

@section('title', 'Galeri Video YouTube PWI')
@section('page_title', 'Galeri Video Liputan')

@section('content')
<div class="space-y-6" x-data="{ 
    modalTambah: false, 
    editData: null, 
    previewVideo: null,
    isFetching: false,
    fetchError: '',
    addForm: {
        youtube_url: '',
        judul: '',
        tanggal: '{{ date('Y-m-d') }}',
        deskripsi: '',
        urutan: 0,
        is_active: 1,
        thumbnail_url: ''
    },
    async fetchYoutubeTitle() {
        if (!this.addForm.youtube_url) return;
        this.isFetching = true;
        this.fetchError = '';
        try {
            const res = await fetch('{{ route('admin.video_galleries.fetch_info') }}?url=' + encodeURIComponent(this.addForm.youtube_url));
            const data = await res.json();
            if (data.success) {
                if (data.title) this.addForm.judul = data.title;
                if (data.thumbnail_url) this.addForm.thumbnail_url = data.thumbnail_url;
            } else {
                this.fetchError = data.message || 'Gagal mengambil info video.';
            }
        } catch (e) {
            this.fetchError = 'Gagal menghubungi server YouTube.';
        } finally {
            this.isFetching = false;
        }
    }
}">
    
    <!-- Top Header & Action -->
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
        <div>
            <div class="inline-flex items-center gap-2 px-2.5 py-1 rounded-md bg-red-100 dark:bg-red-950/60 border border-red-200 dark:border-red-900/50 text-red-600 dark:text-red-400 text-[11px] font-bold tracking-wide uppercase mb-1">
                <i class="fa-brands fa-youtube"></i> Integrasi Multimedia YouTube
            </div>
            <h2 class="text-xl font-extrabold text-[#0B132B] dark:text-white">Galeri Video Kegiatan & Liputan Media</h2>
            <p class="text-xs text-slate-600 dark:text-slate-400 mt-1 font-medium">Kelola tayangan video liputan TVRI, PalTV, dan dokumentasi video resmi PWI Banyuasin</p>
        </div>
        <button @click="modalTambah = true; fetchError = '';" class="w-full sm:w-auto inline-flex items-center justify-center gap-2 px-4 py-2.5 rounded-xl text-xs font-bold text-white bg-red-600 hover:bg-red-700 shadow-sm transition-all cursor-pointer">
            <i class="fa-solid fa-plus"></i>
            <span>Tambah Video Galeri</span>
        </button>
    </div>

    <!-- Alert Success & Error -->
    @if(session('success'))
        <div class="p-4 rounded-xl bg-emerald-50 dark:bg-emerald-950/40 border border-emerald-200 dark:border-emerald-800/60 text-emerald-800 dark:text-emerald-300 text-xs font-semibold flex items-center gap-3">
            <i class="fa-solid fa-circle-check text-emerald-500 text-base"></i>
            <span>{{ session('success') }}</span>
        </div>
    @endif

    @if($errors->any())
        <div class="p-4 rounded-xl bg-rose-50 dark:bg-rose-950/40 border border-rose-200 dark:border-rose-800/60 text-rose-800 dark:text-rose-300 text-xs font-semibold space-y-1">
            <div class="flex items-center gap-2 font-bold text-rose-600 dark:text-rose-400">
                <i class="fa-solid fa-triangle-exclamation"></i>
                <span>Terdapat kesalahan pada formulir:</span>
            </div>
            <ul class="list-disc list-inside pl-2 space-y-0.5">
                @foreach($errors->all() as $err)
                    <li>{{ $err }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <!-- Table Container -->
    <div class="bg-white dark:bg-slate-900 border border-slate-300 dark:border-slate-800 rounded-2xl shadow-sm overflow-hidden">
        
        <div class="p-6 border-b border-slate-200 dark:border-slate-800 flex flex-col sm:flex-row sm:items-center justify-between gap-4 bg-slate-50/50 dark:bg-slate-900/50">
            <div class="text-xs font-semibold text-slate-700 dark:text-slate-300 flex items-center gap-2">
                <span>Total Video:</span>
                <span class="font-extrabold text-red-600 dark:text-amber-400 bg-red-50 dark:bg-slate-800 px-2.5 py-1 rounded-lg border border-red-100 dark:border-slate-700">
                    {{ $videos->total() }} Video
                </span>
            </div>

            <form action="{{ route('admin.video_galleries.index') }}" method="GET" class="w-full sm:w-72">
                <div class="relative">
                    <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari judul liputan..." class="w-full pl-9 pr-4 py-2 rounded-xl bg-white dark:bg-slate-950 border border-slate-300 dark:border-slate-700 text-xs font-medium text-slate-900 dark:text-slate-200 focus:ring-2 focus:ring-red-600 outline-none shadow-sm">
                    <i class="fa-solid fa-magnifying-glass absolute left-3 top-3 text-slate-400 text-xs"></i>
                </div>
            </form>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-left text-xs text-slate-800 dark:text-slate-200 min-w-[750px]">
                <thead class="bg-[#0B132B] dark:bg-[#070D1E] text-white uppercase tracking-wider text-[11px] border-b border-blue-950">
                    <tr>
                        <th class="py-3.5 px-6 text-center w-14 font-bold">NO</th>
                        <th class="py-3.5 px-6 w-36 text-center font-bold">THUMBNAIL</th>
                        <th class="py-3.5 px-6 font-bold">JUDUL VIDEO & DESKRIPSI</th>
                        <th class="py-3.5 px-6 font-bold w-32">TANGGAL</th>
                        <th class="py-3.5 px-6 text-center w-24 font-bold">STATUS</th>
                        <th class="py-3.5 px-6 text-center w-32 font-bold">AKSI</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-200 dark:divide-slate-800">
                    @forelse($videos as $index => $v)
                        <tr class="hover:bg-slate-50 dark:hover:bg-white/[0.02] transition-colors">
                            <td class="py-4 px-6 text-center font-bold text-slate-500 dark:text-slate-400">
                                {{ $videos->firstItem() + $index }}
                            </td>
                            <td class="py-4 px-6 text-center">
                                <div @click="previewVideo = { id: '{{ $v->youtube_id }}', title: '{{ addslashes($v->judul) }}' }" 
                                     class="relative w-28 aspect-video rounded-xl overflow-hidden bg-slate-950 mx-auto shadow-sm ring-1 ring-slate-300 dark:ring-slate-700 cursor-pointer group">
                                    <img src="{{ $v->thumbnail_url }}" alt="{{ $v->judul }}" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300">
                                    <div class="absolute inset-0 bg-black/40 flex items-center justify-center group-hover:bg-black/20 transition-colors">
                                        <div class="w-8 h-8 rounded-full bg-red-600 text-white flex items-center justify-center text-xs shadow-md group-hover:scale-110 transition-transform">
                                            <i class="fa-solid fa-play ml-0.5"></i>
                                        </div>
                                    </div>
                                </div>
                            </td>
                            <td class="py-4 px-6">
                                <div class="font-bold text-slate-900 dark:text-white text-sm hover:text-red-600 transition-colors">
                                    {{ $v->judul }}
                                </div>
                                @if($v->deskripsi)
                                    <p class="text-slate-600 dark:text-slate-400 font-normal text-xs mt-1 line-clamp-2 leading-relaxed">
                                        {{ $v->deskripsi }}
                                    </p>
                                @endif
                                <div class="mt-1.5 flex items-center gap-2">
                                    <a href="{{ $v->youtube_url }}" target="_blank" class="inline-flex items-center gap-1.5 text-[11px] text-red-600 dark:text-red-400 hover:underline font-medium">
                                        <i class="fa-brands fa-youtube"></i>
                                        <span>Buka di YouTube</span>
                                        <i class="fa-solid fa-arrow-up-right-from-square text-[9px]"></i>
                                    </a>
                                </div>
                            </td>
                            <td class="py-4 px-6 text-slate-700 dark:text-slate-300 font-semibold whitespace-nowrap">
                                <div class="flex items-center gap-1.5">
                                    <i class="fa-regular fa-calendar text-slate-400 text-xs"></i>
                                    <span>{{ $v->tanggal ? $v->tanggal->translatedFormat('d M Y') : '-' }}</span>
                                </div>
                                <span class="text-[10px] text-slate-400 block mt-0.5">Urutan: #{{ $v->urutan }}</span>
                            </td>
                            <td class="py-4 px-6 text-center">
                                @if($v->is_active)
                                    <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-full text-[10px] font-extrabold bg-emerald-100 dark:bg-emerald-950/60 text-emerald-700 dark:text-emerald-300 border border-emerald-300 dark:border-emerald-800">
                                        <span class="w-1.5 h-1.5 rounded-full bg-emerald-500 animate-pulse"></span>
                                        <span>Aktif</span>
                                    </span>
                                @else
                                    <span class="inline-flex items-center px-2.5 py-1 rounded-full text-[10px] font-extrabold bg-slate-100 dark:bg-slate-800 text-slate-600 dark:text-slate-400 border border-slate-300 dark:border-slate-700">
                                        Nonaktif
                                    </span>
                                @endif
                            </td>
                            <td class="py-4 px-6 text-center">
                                <div class="flex items-center justify-center gap-1.5">
                                    <button type="button" @click="previewVideo = { id: '{{ $v->youtube_id }}', title: '{{ addslashes($v->judul) }}' }" class="p-1.5 rounded-lg bg-red-600 hover:bg-red-700 text-white shadow-sm transition-all" title="Putar Video">
                                        <i class="fa-solid fa-play text-xs"></i>
                                    </button>
                                    <button type="button" @click="editData = {{ json_encode($v) }}" class="p-1.5 rounded-lg bg-blue-600 hover:bg-blue-700 text-white shadow-sm transition-all" title="Edit">
                                        <i class="fa-solid fa-pen text-xs"></i>
                                    </button>
                                    <form action="{{ route('admin.video_galleries.destroy', $v->id) }}" method="POST" onsubmit="return confirm('Hapus video ini dari galeri?')" class="inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="p-1.5 rounded-lg bg-rose-600 hover:bg-rose-700 text-white shadow-sm transition-all" title="Hapus">
                                            <i class="fa-solid fa-trash text-xs"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="py-12 text-center text-slate-500 dark:text-slate-400 font-medium">
                                Belum ada video galeri tersimpan.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($videos->hasPages())
            <div class="p-4 sm:p-5 border-t border-slate-200 dark:border-slate-800 bg-slate-50/50 dark:bg-slate-900/50">
                {{ $videos->withQueryString()->links() }}
            </div>
        @endif

    </div>

    <!-- Modal Tambah Video Galeri -->
    <div x-show="modalTambah" x-cloak class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-slate-950/80 backdrop-blur-sm">
        <div class="relative w-full max-w-xl bg-white dark:bg-slate-900 border border-slate-300 dark:border-slate-800 rounded-3xl p-6 sm:p-8 shadow-2xl space-y-5 text-slate-900 dark:text-white" @click.away="modalTambah = false">
            
            <div class="flex items-center justify-between border-b border-slate-200 dark:border-slate-800 pb-4">
                <h3 class="text-base font-extrabold text-[#0B132B] dark:text-white flex items-center gap-2">
                    <i class="fa-brands fa-youtube text-red-600"></i> Tambah Video YouTube ke Galeri
                </h3>
                <button @click="modalTambah = false" class="text-slate-400 hover:text-slate-600 dark:hover:text-white">
                    <i class="fa-solid fa-xmark text-base"></i>
                </button>
            </div>

            <form action="{{ route('admin.video_galleries.store') }}" method="POST" class="space-y-4">
                @csrf

                <div>
                    <label class="block text-xs font-bold text-slate-700 dark:text-slate-300 uppercase tracking-wider mb-1">
                        Link / URL YouTube *
                    </label>
                    <div class="flex gap-2">
                        <input type="url" 
                               name="youtube_url" 
                               x-model="addForm.youtube_url"
                               @change="fetchYoutubeTitle()"
                               required 
                               class="w-full px-4 py-2.5 rounded-xl bg-white dark:bg-slate-950 border border-slate-300 dark:border-slate-700 text-xs font-semibold text-slate-900 dark:text-white focus:ring-2 focus:ring-red-600 outline-none shadow-sm" 
                               placeholder="https://www.youtube.com/watch?v=...">
                        <button type="button" 
                                @click="fetchYoutubeTitle()" 
                                :disabled="isFetching || !addForm.youtube_url"
                                class="shrink-0 px-3.5 py-2.5 rounded-xl bg-red-600 hover:bg-red-700 disabled:opacity-50 text-white text-xs font-bold shadow-sm transition-all flex items-center gap-1.5 cursor-pointer">
                            <i class="fa-solid" :class="isFetching ? 'fa-spinner fa-spin' : 'fa-wand-magic-sparkles'"></i>
                            <span class="hidden sm:inline">Ambil Judul</span>
                        </button>
                    </div>
                    <p class="text-[11px] text-slate-500 mt-1">
                        Sistem otomatis mengambil judul dan thumbnail resmi langsung dari YouTube oEmbed.
                    </p>
                    <template x-if="fetchError">
                        <p class="text-[11px] text-rose-500 font-semibold mt-1" x-text="fetchError"></p>
                    </template>
                </div>

                <!-- Preview Thumbnail Auto Fetch -->
                <template x-if="addForm.thumbnail_url">
                    <div class="p-3 bg-slate-50 dark:bg-slate-950/60 rounded-xl border border-slate-200 dark:border-slate-800 flex items-center gap-3">
                        <img :src="addForm.thumbnail_url" class="w-24 aspect-video object-cover rounded-lg shadow-xs">
                        <div class="min-w-0 flex-1">
                            <span class="text-[10px] uppercase font-bold text-red-600 dark:text-red-400 block">Thumbnail Terdeteksi</span>
                            <span class="text-xs font-semibold text-slate-800 dark:text-slate-200 truncate block" x-text="addForm.judul || 'Judul siap disimpan'"></span>
                        </div>
                    </div>
                </template>

                <div>
                    <label class="block text-xs font-bold text-slate-700 dark:text-slate-300 uppercase tracking-wider mb-1">
                        Judul Liputan / Video
                    </label>
                    <input type="text" 
                           name="judul" 
                           x-model="addForm.judul"
                           class="w-full px-4 py-2.5 rounded-xl bg-white dark:bg-slate-950 border border-slate-300 dark:border-slate-700 text-xs font-semibold text-slate-900 dark:text-white focus:ring-2 focus:ring-red-600 outline-none shadow-sm" 
                           placeholder="Kosongkan untuk memakai judul asli YouTube otomatis">
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-xs font-bold text-slate-700 dark:text-slate-300 uppercase tracking-wider mb-1">
                            Tanggal Kegiatan / Publikasi
                        </label>
                        <input type="date" 
                               name="tanggal" 
                               x-model="addForm.tanggal"
                               class="w-full px-4 py-2.5 rounded-xl bg-white dark:bg-slate-950 border border-slate-300 dark:border-slate-700 text-xs font-semibold text-slate-900 dark:text-white focus:ring-2 focus:ring-red-600 outline-none shadow-sm">
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-slate-700 dark:text-slate-300 uppercase tracking-wider mb-1">
                            Urutan Tampil (Opsional)
                        </label>
                        <input type="number" 
                               name="urutan" 
                               x-model="addForm.urutan"
                               class="w-full px-4 py-2.5 rounded-xl bg-white dark:bg-slate-950 border border-slate-300 dark:border-slate-700 text-xs font-semibold text-slate-900 dark:text-white focus:ring-2 focus:ring-red-600 outline-none shadow-sm" 
                               placeholder="0">
                    </div>
                </div>

                <div>
                    <label class="block text-xs font-bold text-slate-700 dark:text-slate-300 uppercase tracking-wider mb-1">Deskripsi Ringkas</label>
                    <textarea name="deskripsi" 
                              x-model="addForm.deskripsi"
                              rows="3" 
                              class="w-full px-4 py-2.5 rounded-xl bg-white dark:bg-slate-950 border border-slate-300 dark:border-slate-700 text-xs font-medium text-slate-900 dark:text-white focus:ring-2 focus:ring-red-600 outline-none shadow-sm" 
                              placeholder="Keterangan liputan media, stasiun TV, atau momentum acara..."></textarea>
                </div>

                <div class="flex items-center gap-2 pt-1">
                    <input type="checkbox" id="add_is_active" name="is_active" value="1" checked class="rounded border-slate-300 text-red-600 focus:ring-red-500">
                    <label for="add_is_active" class="text-xs font-bold text-slate-700 dark:text-slate-300 cursor-pointer">
                        Tampilkan langsung di galeri video website publik
                    </label>
                </div>

                <div class="flex items-center justify-end gap-3 pt-4 border-t border-slate-200 dark:border-slate-800">
                    <button type="button" @click="modalTambah = false" class="px-4 py-2 rounded-xl text-xs font-bold text-slate-600 dark:text-slate-400 hover:bg-slate-100 dark:hover:bg-slate-800 transition-colors">
                        Batal
                    </button>
                    <button type="submit" class="px-6 py-2.5 rounded-xl text-xs font-bold text-white bg-red-600 hover:bg-red-700 shadow-sm transition-all">
                        Simpan ke Galeri
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- Modal Edit Video Galeri -->
    <div x-show="editData" x-cloak class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-slate-950/80 backdrop-blur-sm">
        <div class="relative w-full max-w-xl bg-white dark:bg-slate-900 border border-slate-300 dark:border-slate-800 rounded-3xl p-6 sm:p-8 shadow-2xl space-y-5 text-slate-900 dark:text-white" @click.away="editData = null">
            
            <div class="flex items-center justify-between border-b border-slate-200 dark:border-slate-800 pb-4">
                <h3 class="text-base font-extrabold text-[#0B132B] dark:text-white flex items-center gap-2">
                    <i class="fa-solid fa-pen-to-square text-blue-600"></i> Edit Data Video Galeri
                </h3>
                <button @click="editData = null" class="text-slate-400 hover:text-slate-600 dark:hover:text-white">
                    <i class="fa-solid fa-xmark text-base"></i>
                </button>
            </div>

            <form :action="'{{ url('admin/galeri-video') }}/' + (editData ? editData.id : '')" method="POST" class="space-y-4">
                @csrf
                @method('PUT')

                <div>
                    <label class="block text-xs font-bold text-slate-700 dark:text-slate-300 uppercase tracking-wider mb-1">
                        Link / URL YouTube *
                    </label>
                    <input type="url" 
                           name="youtube_url" 
                           :value="editData ? editData.youtube_url : ''"
                           required 
                           class="w-full px-4 py-2.5 rounded-xl bg-white dark:bg-slate-950 border border-slate-300 dark:border-slate-700 text-xs font-semibold text-slate-900 dark:text-white focus:ring-2 focus:ring-blue-600 outline-none shadow-sm">
                </div>

                <div>
                    <label class="block text-xs font-bold text-slate-700 dark:text-slate-300 uppercase tracking-wider mb-1">
                        Judul Video *
                    </label>
                    <input type="text" 
                           name="judul" 
                           :value="editData ? editData.judul : ''"
                           required 
                           class="w-full px-4 py-2.5 rounded-xl bg-white dark:bg-slate-950 border border-slate-300 dark:border-slate-700 text-xs font-semibold text-slate-900 dark:text-white focus:ring-2 focus:ring-blue-600 outline-none shadow-sm">
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-xs font-bold text-slate-700 dark:text-slate-300 uppercase tracking-wider mb-1">
                            Tanggal Kegiatan / Publikasi
                        </label>
                        <input type="date" 
                               name="tanggal" 
                               :value="editData && editData.tanggal ? editData.tanggal.substring(0,10) : ''"
                               class="w-full px-4 py-2.5 rounded-xl bg-white dark:bg-slate-950 border border-slate-300 dark:border-slate-700 text-xs font-semibold text-slate-900 dark:text-white focus:ring-2 focus:ring-blue-600 outline-none shadow-sm">
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-slate-700 dark:text-slate-300 uppercase tracking-wider mb-1">
                            Urutan Tampil
                        </label>
                        <input type="number" 
                               name="urutan" 
                               :value="editData ? editData.urutan : 0"
                               class="w-full px-4 py-2.5 rounded-xl bg-white dark:bg-slate-950 border border-slate-300 dark:border-slate-700 text-xs font-semibold text-slate-900 dark:text-white focus:ring-2 focus:ring-blue-600 outline-none shadow-sm">
                    </div>
                </div>

                <div>
                    <label class="block text-xs font-bold text-slate-700 dark:text-slate-300 uppercase tracking-wider mb-1">Deskripsi</label>
                    <textarea name="deskripsi" 
                              rows="3" 
                              :value="editData ? editData.deskripsi : ''"
                              class="w-full px-4 py-2.5 rounded-xl bg-white dark:bg-slate-950 border border-slate-300 dark:border-slate-700 text-xs font-medium text-slate-900 dark:text-white focus:ring-2 focus:ring-blue-600 outline-none shadow-sm"></textarea>
                </div>

                <div class="flex items-center gap-2 pt-1">
                    <input type="checkbox" id="edit_is_active" name="is_active" value="1" :checked="editData && editData.is_active" class="rounded border-slate-300 text-blue-600 focus:ring-blue-500">
                    <label for="edit_is_active" class="text-xs font-bold text-slate-700 dark:text-slate-300 cursor-pointer">
                        Aktifkan di galeri website publik
                    </label>
                </div>

                <div class="flex items-center justify-end gap-3 pt-4 border-t border-slate-200 dark:border-slate-800">
                    <button type="button" @click="editData = null" class="px-4 py-2 rounded-xl text-xs font-bold text-slate-600 dark:text-slate-400 hover:bg-slate-100 dark:hover:bg-slate-800 transition-colors">
                        Batal
                    </button>
                    <button type="submit" class="px-6 py-2.5 rounded-xl text-xs font-bold text-white bg-blue-600 hover:bg-blue-700 shadow-sm transition-all">
                        Simpan Perubahan
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- Modal Preview Video YouTube Player -->
    <div x-show="previewVideo" x-cloak class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-slate-950/90 backdrop-blur-md">
        <div class="relative w-full max-w-4xl bg-slate-900 border border-slate-800 rounded-3xl overflow-hidden shadow-2xl" @click.away="previewVideo = null">
            
            <div class="p-4 sm:p-5 flex items-center justify-between border-b border-slate-800 bg-slate-950/60">
                <div class="flex items-center gap-2 text-white font-bold text-sm truncate pr-4">
                    <i class="fa-brands fa-youtube text-red-500 text-lg"></i>
                    <span x-text="previewVideo ? previewVideo.title : 'Pemutar Video'"></span>
                </div>
                <button @click="previewVideo = null" class="w-8 h-8 rounded-full bg-white/10 text-white hover:bg-white/20 flex items-center justify-center cursor-pointer transition-colors">
                    <i class="fa-solid fa-xmark text-sm"></i>
                </button>
            </div>

            <div class="aspect-video w-full bg-black">
                <template x-if="previewVideo">
                    <iframe :src="'https://www.youtube-nocookie.com/embed/' + previewVideo.id + '?autoplay=1&rel=0'" 
                            class="w-full h-full border-0" 
                            allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" 
                            allowfullscreen></iframe>
                </template>
            </div>

            <div class="p-4 bg-slate-900 flex justify-end">
                <button @click="previewVideo = null" class="px-4 py-2 rounded-xl bg-white/10 hover:bg-white/20 text-white text-xs font-bold transition-colors">
                    Tutup Pemutar
                </button>
            </div>
        </div>
    </div>

</div>
@endsection
