@extends('layouts.admin')

@section('title', 'Struktur Organisasi PWI Banyuasin')
@section('page_title', 'Struktur Organisasi')

@section('content')
<script>
    function orgManager() {
        return {
            tab: 'table',
            modalTambah: false,
            editModal: false,
            structuresData: {
                @foreach($structures as $s)
                    '{{ $s->id }}': {!! json_encode($s) !!},
                @endforeach
            },
            editForm: {
                id: '',
                nama: '',
                nomor_kartu: '',
                tingkat_ukw: 'Wartawan Muda',
                jabatan: '',
                urutan: 1,
                x_twitter: '',
                facebook: '',
                instagram: '',
                youtube: '',
            },
            openEdit(id) {
                const s = this.structuresData[id] || {};
                this.editForm = {
                    id: s.id || id,
                    nama: s.nama || '',
                    nomor_kartu: s.nomor_kartu || '',
                    tingkat_ukw: s.tingkat_ukw || 'Belum UKW',
                    jabatan: s.jabatan || '',
                    urutan: s.urutan || 1,
                    x_twitter: s.x_twitter || '',
                    facebook: s.facebook || '',
                    instagram: s.instagram || '',
                    youtube: s.youtube || '',
                };
                this.editModal = true;
                this.$nextTick(() => {
                    const form = document.getElementById('editOrganizationForm');
                    if (form) {
                        form.action = '{{ url('admin/struktur-organisasi') }}/' + (s.id || id);
                    }
                });
            }
        };
    }
</script>

<div class="space-y-6" x-data="orgManager()">
    
    <!-- Header -->
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
        <div>
            <h2 class="text-xl font-extrabold text-[#0B132B] dark:text-white">Struktur Kepengurusan PWI Banyuasin</h2>
            <p class="text-xs text-slate-600 dark:text-slate-400 mt-1 font-medium">Susunan 32 pejabat pengurus harian dan kepala seksi bidang Masa Bhakti 2025–2028</p>
        </div>

        <div class="flex flex-wrap items-center gap-2.5">
            <!-- Tab Switcher (Tabel vs Bagan) -->
            <div class="inline-flex items-center p-1 rounded-xl bg-white dark:bg-slate-900 border border-slate-300 dark:border-slate-800 shadow-sm">
                <button type="button" 
                        @click="tab = 'table'" 
                        :class="tab === 'table' ? 'bg-blue-600 text-white shadow-sm' : 'text-slate-600 dark:text-slate-300 hover:text-slate-900 dark:hover:text-white'"
                        class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-lg text-xs font-bold transition-all cursor-pointer">
                    <i class="fa-solid fa-table-list"></i>
                    <span>Tabel Data</span>
                </button>
                <button type="button" 
                        @click="tab = 'chart'" 
                        :class="tab === 'chart' ? 'bg-blue-600 text-white shadow-sm' : 'text-slate-600 dark:text-slate-300 hover:text-slate-900 dark:hover:text-white'"
                        class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-lg text-xs font-bold transition-all cursor-pointer">
                    <i class="fa-solid fa-sitemap"></i>
                    <span>Visualisasi Bagan</span>
                </button>
            </div>

            <button @click="modalTambah = true" class="inline-flex items-center gap-2 px-4 py-2.5 rounded-xl text-xs font-bold text-white bg-blue-600 hover:bg-blue-700 dark:bg-amber-400 dark:hover:bg-amber-300 dark:text-slate-950 shadow-sm transition-all cursor-pointer">
                <i class="fa-solid fa-plus"></i>
                <span>+ Tambah Pengurus</span>
            </button>
        </div>
    </div>

    <!-- TAB 1: VISUALISASI BAGAN HIRARKI (ORG CHART) -->
    <div x-show="tab === 'chart'" x-cloak x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 translate-y-2" x-transition:enter-end="opacity-100 translate-y-0">
        @include('partials.organization-chart', ['tree' => $tree])
    </div>

    <!-- TAB 2: TABLE CONTAINER -->
    <div x-show="tab === 'table'" x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 translate-y-2" x-transition:enter-end="opacity-100 translate-y-0" class="bg-white dark:bg-slate-900 border border-slate-300 dark:border-slate-800 rounded-2xl shadow-sm overflow-hidden">
        
        <!-- Filter Bar -->
        <div class="p-6 border-b border-slate-200 dark:border-slate-800 flex flex-col sm:flex-row sm:items-center justify-between gap-4 bg-slate-50/50 dark:bg-slate-900/50">
            <div class="flex items-center gap-2">
                <span class="text-xs font-semibold text-slate-700 dark:text-slate-300">Tampilkan</span>
                <form action="{{ route('admin.organization.index') }}" method="GET">
                    @if(request('search')) <input type="hidden" name="search" value="{{ request('search') }}"> @endif
                    <select name="entries" onchange="this.form.submit()" class="px-3 py-1.5 rounded-xl bg-white dark:bg-slate-950 border border-slate-300 dark:border-slate-700 text-xs font-semibold text-slate-900 dark:text-slate-200 outline-none shadow-sm">
                        <option value="10" {{ request('entries') == 10 ? 'selected' : '' }}>10</option>
                        <option value="25" {{ request('entries') == 25 ? 'selected' : '' }}>25</option>
                        <option value="50" {{ request('entries') == 50 ? 'selected' : '' }}>50</option>
                        <option value="100" {{ request('entries') == 100 ? 'selected' : '' }}>100</option>
                    </select>
                </form>
                <span class="text-xs font-semibold text-slate-700 dark:text-slate-300">pengurus</span>
            </div>

            <form action="{{ route('admin.organization.index') }}" method="GET" class="w-full sm:w-72">
                @if(request('entries')) <input type="hidden" name="entries" value="{{ request('entries') }}"> @endif
                <div class="relative">
                    <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari nama / jabatan..." class="w-full pl-9 pr-4 py-2 rounded-xl bg-white dark:bg-slate-950 border border-slate-300 dark:border-slate-700 text-xs font-medium text-slate-900 dark:text-slate-200 focus:ring-2 focus:ring-blue-600 outline-none shadow-sm">
                    <i class="fa-solid fa-magnifying-glass absolute left-3 top-3 text-slate-400 text-xs"></i>
                </div>
            </form>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-left text-xs text-slate-800 dark:text-slate-200">
                <thead class="bg-[#0B132B] dark:bg-[#070D1E] text-white uppercase tracking-wider text-[11px] border-b border-blue-950">
                    <tr>
                        <th class="py-3.5 px-6 text-center w-16 font-bold">NO</th>
                        <th class="py-3.5 px-6 w-20 text-center font-bold">FOTO</th>
                        <th class="py-3.5 px-6 font-bold">NAMA PENGURUS</th>
                        <th class="py-3.5 px-6 font-bold">NOMOR KARTU</th>
                        <th class="py-3.5 px-6 font-bold">TINGKAT</th>
                        <th class="py-3.5 px-6 font-bold">MASA BERLAKU</th>
                        <th class="py-3.5 px-6 font-bold">JABATAN</th>
                        <th class="py-3.5 px-6 text-center w-36 font-bold">AKSI</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-200 dark:divide-slate-800">
                    @forelse($structures as $index => $s)
                        <tr class="hover:bg-slate-50 dark:hover:bg-white/[0.02] transition-colors">
                            <td class="py-3.5 px-6 text-center font-bold text-slate-500 dark:text-slate-400">{{ $structures->firstItem() + $index }}</td>
                            <td class="py-3.5 px-6 text-center">
                                <div class="w-10 h-10 rounded-xl bg-slate-100 dark:bg-slate-800 ring-1 ring-slate-300 dark:ring-slate-700 overflow-hidden mx-auto shadow-sm">
                                    <img src="{{ $s->foto_url }}" alt="{{ $s->nama }}" class="w-full h-full object-cover">
                                </div>
                            </td>
                            <td class="py-3.5 px-6 font-bold text-slate-900 dark:text-white">{{ $s->nama }}</td>
                            <td class="py-3.5 px-6 font-mono text-slate-800 dark:text-slate-300 font-semibold">{{ $s->nomor_kartu ?? '-' }}</td>
                            <td class="py-3.5 px-6">
                                <span class="inline-block px-2.5 py-1 rounded-lg text-[10px] font-bold {{ $s->ukw_badge_color }}">
                                    {{ $s->tingkat_ukw ?? 'Belum UKW' }}
                                </span>
                            </td>
                            <td class="py-3.5 px-6 text-slate-800 dark:text-slate-300 font-semibold">{{ $s->masa_berlaku ? $s->masa_berlaku->format('d-m-Y') : '-' }}</td>
                            <td class="py-3.5 px-6">
                                <span class="inline-block px-2.5 py-1 rounded-md bg-slate-100 dark:bg-slate-800 border border-slate-300 dark:border-slate-700 text-[#0B132B] dark:text-slate-200 font-bold text-[11px]">
                                    {{ $s->jabatan }}
                                </span>
                            </td>
                            <td class="py-3.5 px-6 text-center">
                                <div class="flex items-center justify-center gap-1.5">
                                    <button type="button" @click="openEdit({{ $s->id }})" class="p-1.5 rounded-lg bg-blue-600 hover:bg-blue-700 text-white shadow-sm transition-all cursor-pointer" title="Edit Pengurus">
                                        <i class="fa-solid fa-pen text-xs"></i>
                                    </button>
                                    <form action="{{ route('admin.organization.destroy', $s->id) }}" method="POST" onsubmit="return confirm('Hapus pengurus {{ $s->nama }}?')" class="inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="p-1.5 rounded-lg bg-rose-600 hover:bg-rose-700 text-white shadow-sm transition-all cursor-pointer" title="Hapus">
                                            <i class="fa-solid fa-trash text-xs"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8" class="py-12 text-center text-slate-500 dark:text-slate-400 font-medium">
                                Tidak ada data pengurus organisasi.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="p-6 border-t border-slate-200 dark:border-slate-800 flex flex-col sm:flex-row items-center justify-between text-xs text-slate-600 dark:text-slate-400 gap-4 bg-slate-50/50 dark:bg-slate-900/50">
            <div>
                Menampilkan {{ $structures->firstItem() ?? 0 }} s/d {{ $structures->lastItem() ?? 0 }} dari {{ $structures->total() }} pengurus
            </div>
            <div>
                {{ $structures->withQueryString()->links() }}
            </div>
        </div>

    </div>

    <!-- Modal Tambah Pengurus -->
    <div x-show="modalTambah" x-cloak class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-slate-950/80 backdrop-blur-sm">
        <div class="relative w-full max-w-lg bg-white dark:bg-slate-900 border border-slate-300 dark:border-slate-800 rounded-3xl p-6 sm:p-8 shadow-2xl space-y-6 text-slate-900 dark:text-white" @click.away="modalTambah = false">
            <div class="flex items-center justify-between border-b border-slate-200 dark:border-slate-800 pb-4">
                <h3 class="text-base font-extrabold text-[#0B132B] dark:text-white flex items-center gap-2">
                    <i class="fa-solid fa-sitemap text-blue-600 dark:text-amber-400"></i> Tambah Pengurus Organisasi
                </h3>
                <button @click="modalTambah = false" class="text-slate-400 hover:text-slate-600 dark:hover:text-white">
                    <i class="fa-solid fa-xmark text-base"></i>
                </button>
            </div>

            <form action="{{ route('admin.organization.store') }}" method="POST" enctype="multipart/form-data" class="space-y-4">
                @csrf

                <div>
                    <label class="block text-xs font-bold text-slate-700 dark:text-slate-300 uppercase tracking-wider mb-1">Nama Lengkap & Gelar *</label>
                    <input type="text" name="nama" required class="w-full px-4 py-2.5 rounded-xl bg-white dark:bg-slate-950 border border-slate-300 dark:border-slate-700 text-xs font-semibold text-slate-900 dark:text-white focus:ring-2 focus:ring-blue-600 outline-none shadow-sm" placeholder="Contoh: Wardoyo, S.I.Kom">
                </div>

                <div class="grid grid-cols-2 gap-3">
                    <div>
                        <label class="block text-xs font-bold text-slate-700 dark:text-slate-300 uppercase tracking-wider mb-1">Nomor Kartu (KTA)</label>
                        <input type="text" name="nomor_kartu" class="w-full px-4 py-2.5 rounded-xl bg-white dark:bg-slate-950 border border-slate-300 dark:border-slate-700 text-xs font-semibold text-slate-900 dark:text-white focus:ring-2 focus:ring-blue-600 outline-none shadow-sm" placeholder="06.00.17208.14B">
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-slate-700 dark:text-slate-300 uppercase tracking-wider mb-1">Tingkat UKW</label>
                        <select name="tingkat_ukw" class="w-full px-4 py-2.5 rounded-xl bg-white dark:bg-slate-950 border border-slate-300 dark:border-slate-700 text-xs font-semibold text-slate-900 dark:text-white focus:ring-2 focus:ring-blue-600 outline-none shadow-sm">
                            <option value="Wartawan Utama">Wartawan Utama</option>
                            <option value="Wartawan Madya">Wartawan Madya</option>
                            <option value="Wartawan Muda">Wartawan Muda</option>
                            <option value="Belum UKW">Belum UKW</option>
                        </select>
                    </div>
                </div>

                <div class="grid grid-cols-2 gap-3">
                    <div>
                        <label class="block text-xs font-bold text-slate-700 dark:text-slate-300 uppercase tracking-wider mb-1">Jabatan Pengurus *</label>
                        <input type="text" name="jabatan" required class="w-full px-4 py-2.5 rounded-xl bg-white dark:bg-slate-950 border border-slate-300 dark:border-slate-700 text-xs font-semibold text-slate-900 dark:text-white focus:ring-2 focus:ring-blue-600 outline-none shadow-sm" placeholder="Contoh: KETUA / SEKRETARIS">
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-slate-700 dark:text-slate-300 uppercase tracking-wider mb-1">Urutan Tampil (No)</label>
                        <input type="number" name="urutan" value="1" class="w-full px-4 py-2.5 rounded-xl bg-white dark:bg-slate-950 border border-slate-300 dark:border-slate-700 text-xs font-semibold text-slate-900 dark:text-white focus:ring-2 focus:ring-blue-600 outline-none shadow-sm">
                    </div>
                </div>

                <div>
                    <label class="block text-xs font-bold text-slate-700 dark:text-slate-300 uppercase tracking-wider mb-1">Foto Formal (Opsional)</label>
                    <input type="file" name="foto" accept="image/*" class="w-full px-3 py-2 rounded-xl bg-white dark:bg-slate-950 border border-slate-300 dark:border-slate-700 text-xs font-semibold text-slate-900 dark:text-white file:mr-3 file:py-1 file:px-3 file:rounded-lg file:border-0 file:text-xs file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100">
                </div>

                <!-- Media Sosial Pengurus -->
                <div class="pt-2 border-t border-slate-200 dark:border-slate-800">
                    <p class="text-[11px] font-bold text-slate-500 dark:text-slate-400 uppercase tracking-wider mb-3">Tautan Media Sosial</p>
                    <div class="grid grid-cols-2 gap-3">
                        <div>
                            <label class="block text-[11px] font-bold text-slate-700 dark:text-slate-300 mb-1">
                                <i class="fa-brands fa-x-twitter text-slate-800 dark:text-white mr-1"></i> X (Twitter)
                            </label>
                            <input type="text" name="x_twitter" class="w-full px-3 py-2 rounded-xl bg-white dark:bg-slate-950 border border-slate-300 dark:border-slate-700 text-xs text-slate-900 dark:text-white focus:ring-2 focus:ring-blue-600 outline-none" placeholder="https://x.com/username">
                        </div>
                        <div>
                            <label class="block text-[11px] font-bold text-slate-700 dark:text-slate-300 mb-1">
                                <i class="fa-brands fa-facebook-f text-blue-600 mr-1"></i> Facebook
                            </label>
                            <input type="text" name="facebook" class="w-full px-3 py-2 rounded-xl bg-white dark:bg-slate-950 border border-slate-300 dark:border-slate-700 text-xs text-slate-900 dark:text-white focus:ring-2 focus:ring-blue-600 outline-none" placeholder="https://facebook.com/username">
                        </div>
                        <div>
                            <label class="block text-[11px] font-bold text-slate-700 dark:text-slate-300 mb-1">
                                <i class="fa-brands fa-instagram text-rose-500 mr-1"></i> Instagram
                            </label>
                            <input type="text" name="instagram" class="w-full px-3 py-2 rounded-xl bg-white dark:bg-slate-950 border border-slate-300 dark:border-slate-700 text-xs text-slate-900 dark:text-white focus:ring-2 focus:ring-blue-600 outline-none" placeholder="https://instagram.com/username">
                        </div>
                        <div>
                            <label class="block text-[11px] font-bold text-slate-700 dark:text-slate-300 mb-1">
                                <i class="fa-brands fa-youtube text-red-600 mr-1"></i> YouTube
                            </label>
                            <input type="text" name="youtube" class="w-full px-3 py-2 rounded-xl bg-white dark:bg-slate-950 border border-slate-300 dark:border-slate-700 text-xs text-slate-900 dark:text-white focus:ring-2 focus:ring-blue-600 outline-none" placeholder="https://youtube.com/@channel">
                        </div>
                    </div>
                </div>

                <div class="flex items-center justify-end gap-3 pt-4 border-t border-slate-200 dark:border-slate-800">
                    <button type="button" @click="modalTambah = false" class="px-4 py-2 rounded-xl text-xs font-bold text-slate-600 dark:text-slate-400 hover:bg-slate-100 dark:hover:bg-slate-800 transition-colors">Batal</button>
                    <button type="submit" class="px-6 py-2.5 rounded-xl text-xs font-bold text-white bg-blue-600 hover:bg-blue-700 shadow-sm transition-all">Simpan Pengurus</button>
                </div>
            </form>
        </div>
    </div>

    <!-- Modal Edit Pengurus -->
    <div x-show="editModal" x-cloak class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-slate-950/80 backdrop-blur-sm">
        <div class="relative w-full max-w-lg bg-white dark:bg-slate-900 border border-slate-300 dark:border-slate-800 rounded-3xl p-6 sm:p-8 shadow-2xl space-y-6 text-slate-900 dark:text-white max-h-[90vh] overflow-y-auto" @click.away="editModal = false">
            <div class="flex items-center justify-between border-b border-slate-200 dark:border-slate-800 pb-4">
                <h3 class="text-base font-extrabold text-[#0B132B] dark:text-white flex items-center gap-2">
                    <i class="fa-solid fa-pen text-blue-600"></i> Edit Pengurus
                </h3>
                <button @click="editModal = false" class="text-slate-400 hover:text-slate-600 dark:hover:text-white">
                    <i class="fa-solid fa-xmark text-base"></i>
                </button>
            </div>

            <form id="editOrganizationForm" :action="'{{ url('admin/struktur-organisasi') }}/' + editForm.id" method="POST" enctype="multipart/form-data" class="space-y-4">
                @csrf
                @method('PUT')

                <div>
                    <label class="block text-xs font-bold text-slate-700 dark:text-slate-300 uppercase tracking-wider mb-1">Nama Lengkap & Gelar *</label>
                    <input type="text" name="nama" x-model="editForm.nama" required class="w-full px-4 py-2.5 rounded-xl bg-white dark:bg-slate-950 border border-slate-300 dark:border-slate-700 text-xs font-semibold text-slate-900 dark:text-white focus:ring-2 focus:ring-blue-600 outline-none shadow-sm">
                </div>

                <div class="grid grid-cols-2 gap-3">
                    <div>
                        <label class="block text-xs font-bold text-slate-700 dark:text-slate-300 uppercase tracking-wider mb-1">Nomor Kartu (KTA)</label>
                        <input type="text" name="nomor_kartu" x-model="editForm.nomor_kartu" class="w-full px-4 py-2.5 rounded-xl bg-white dark:bg-slate-950 border border-slate-300 dark:border-slate-700 text-xs font-semibold text-slate-900 dark:text-white focus:ring-2 focus:ring-blue-600 outline-none shadow-sm">
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-slate-700 dark:text-slate-300 uppercase tracking-wider mb-1">Tingkat UKW</label>
                        <select name="tingkat_ukw" x-model="editForm.tingkat_ukw" class="w-full px-4 py-2.5 rounded-xl bg-white dark:bg-slate-950 border border-slate-300 dark:border-slate-700 text-xs font-semibold text-slate-900 dark:text-white focus:ring-2 focus:ring-blue-600 outline-none shadow-sm">
                            <option value="Wartawan Utama">Wartawan Utama</option>
                            <option value="Wartawan Madya">Wartawan Madya</option>
                            <option value="Wartawan Muda">Wartawan Muda</option>
                            <option value="Belum UKW">Belum UKW</option>
                        </select>
                    </div>
                </div>

                <div class="grid grid-cols-2 gap-3">
                    <div>
                        <label class="block text-xs font-bold text-slate-700 dark:text-slate-300 uppercase tracking-wider mb-1">Jabatan Pengurus *</label>
                        <input type="text" name="jabatan" x-model="editForm.jabatan" required class="w-full px-4 py-2.5 rounded-xl bg-white dark:bg-slate-950 border border-slate-300 dark:border-slate-700 text-xs font-semibold text-slate-900 dark:text-white focus:ring-2 focus:ring-blue-600 outline-none shadow-sm">
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-slate-700 dark:text-slate-300 uppercase tracking-wider mb-1">Urutan Tampil (No)</label>
                        <input type="number" name="urutan" x-model="editForm.urutan" class="w-full px-4 py-2.5 rounded-xl bg-white dark:bg-slate-950 border border-slate-300 dark:border-slate-700 text-xs font-semibold text-slate-900 dark:text-white focus:ring-2 focus:ring-blue-600 outline-none shadow-sm">
                    </div>
                </div>

                <div>
                    <label class="block text-xs font-bold text-slate-700 dark:text-slate-300 uppercase tracking-wider mb-1">Ganti Foto Formal (Opsional)</label>
                    <input type="file" name="foto" accept="image/*" class="w-full px-3 py-2 rounded-xl bg-white dark:bg-slate-950 border border-slate-300 dark:border-slate-700 text-xs font-semibold text-slate-900 dark:text-white file:mr-3 file:py-1 file:px-3 file:rounded-lg file:border-0 file:text-xs file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100">
                </div>

                <!-- Media Sosial Pengurus -->
                <div class="pt-2 border-t border-slate-200 dark:border-slate-800">
                    <p class="text-[11px] font-bold text-slate-500 dark:text-slate-400 uppercase tracking-wider mb-3">Tautan Media Sosial</p>
                    <div class="grid grid-cols-2 gap-3">
                        <div>
                            <label class="block text-[11px] font-bold text-slate-700 dark:text-slate-300 mb-1">
                                <i class="fa-brands fa-x-twitter text-slate-800 dark:text-white mr-1"></i> X (Twitter)
                            </label>
                            <input type="text" name="x_twitter" x-model="editForm.x_twitter" class="w-full px-3 py-2 rounded-xl bg-white dark:bg-slate-950 border border-slate-300 dark:border-slate-700 text-xs text-slate-900 dark:text-white focus:ring-2 focus:ring-blue-600 outline-none" placeholder="https://x.com/username">
                        </div>
                        <div>
                            <label class="block text-[11px] font-bold text-slate-700 dark:text-slate-300 mb-1">
                                <i class="fa-brands fa-facebook-f text-blue-600 mr-1"></i> Facebook
                            </label>
                            <input type="text" name="facebook" x-model="editForm.facebook" class="w-full px-3 py-2 rounded-xl bg-white dark:bg-slate-950 border border-slate-300 dark:border-slate-700 text-xs text-slate-900 dark:text-white focus:ring-2 focus:ring-blue-600 outline-none" placeholder="https://facebook.com/username">
                        </div>
                        <div>
                            <label class="block text-[11px] font-bold text-slate-700 dark:text-slate-300 mb-1">
                                <i class="fa-brands fa-instagram text-rose-500 mr-1"></i> Instagram
                            </label>
                            <input type="text" name="instagram" x-model="editForm.instagram" class="w-full px-3 py-2 rounded-xl bg-white dark:bg-slate-950 border border-slate-300 dark:border-slate-700 text-xs text-slate-900 dark:text-white focus:ring-2 focus:ring-blue-600 outline-none" placeholder="https://instagram.com/username">
                        </div>
                        <div>
                            <label class="block text-[11px] font-bold text-slate-700 dark:text-slate-300 mb-1">
                                <i class="fa-brands fa-youtube text-red-600 mr-1"></i> YouTube
                            </label>
                            <input type="text" name="youtube" x-model="editForm.youtube" class="w-full px-3 py-2 rounded-xl bg-white dark:bg-slate-950 border border-slate-300 dark:border-slate-700 text-xs text-slate-900 dark:text-white focus:ring-2 focus:ring-blue-600 outline-none" placeholder="https://youtube.com/@channel">
                        </div>
                    </div>
                </div>

                <div class="flex items-center justify-end gap-3 pt-4 border-t border-slate-200 dark:border-slate-800">
                    <button type="button" @click="editModal = false" class="px-4 py-2 rounded-xl text-xs font-bold text-slate-600 dark:text-slate-400 hover:bg-slate-100 dark:hover:bg-slate-800 transition-colors">Batal</button>
                    <button type="submit" class="px-6 py-2.5 rounded-xl text-xs font-bold text-white bg-blue-600 hover:bg-blue-700 shadow-sm transition-all">Simpan Perubahan</button>
                </div>
            </form>
        </div>
    </div>

</div>
@endsection
