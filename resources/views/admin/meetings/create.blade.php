@extends('layouts.admin')

@section('title', 'Catat Notulen Rapat & Absensi Baru')
@section('page_title', 'Notulen Rapat & Absensi')

@section('content')
<div class="max-w-6xl mx-auto space-y-6">
    
    <div class="flex items-center justify-between">
        <div>
            <h2 class="text-xl font-extrabold text-[#0B132B] dark:text-white">Form Pencatatan Notulen Rapat</h2>
            <p class="text-xs text-slate-600 dark:text-slate-400 mt-1 font-medium">Dokumentasikan agenda, jalannya pembahasan, kesimpulan rapat, dan checklist kehadiran pengurus</p>
        </div>
        <a href="{{ route('admin.meetings.index') }}" class="px-4 py-2 rounded-xl text-xs font-bold text-slate-700 dark:text-slate-200 bg-white dark:bg-slate-800 border border-slate-300 dark:border-slate-700 hover:bg-slate-50 dark:hover:bg-slate-700 shadow-sm transition-all">
            <i class="fa-solid fa-arrow-left me-1"></i> Kembali
        </a>
    </div>

    <form action="{{ route('admin.meetings.store') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
        @csrf

        <!-- Rapat Details Card -->
        <div class="p-8 rounded-2xl bg-white dark:bg-slate-900 border border-slate-300 dark:border-slate-800 shadow-sm space-y-6">
            <h3 class="text-sm font-extrabold text-blue-700 dark:text-amber-400 uppercase tracking-wider flex items-center gap-2">
                <i class="fa-solid fa-file-signature"></i> 1. Informasi Rapat
            </h3>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div class="md:col-span-2">
                    <label class="block text-xs font-bold text-slate-700 dark:text-slate-300 uppercase tracking-wider mb-2">Judul / Agenda Utama Rapat *</label>
                    <input type="text" name="judul_rapat" value="{{ old('judul_rapat') }}" required class="w-full px-4 py-3 rounded-xl bg-white dark:bg-slate-950 border border-slate-300 dark:border-slate-700 text-sm font-semibold text-slate-900 dark:text-white focus:ring-2 focus:ring-blue-600 outline-none shadow-sm" placeholder="Contoh: Rapat Pleno Persiapan Uji Kompetensi Wartawan (UKW) Angkatan VII">
                </div>

                <div>
                    <label class="block text-xs font-bold text-slate-700 dark:text-slate-300 uppercase tracking-wider mb-2">Tanggal Pelaksanaan *</label>
                    <input type="date" name="tanggal" value="{{ old('tanggal', date('Y-m-d')) }}" required class="w-full px-4 py-2.5 rounded-xl bg-white dark:bg-slate-950 border border-slate-300 dark:border-slate-700 text-xs font-semibold text-slate-900 dark:text-white focus:ring-2 focus:ring-blue-600 outline-none shadow-sm">
                </div>

                <div class="grid grid-cols-2 gap-3">
                    <div>
                        <label class="block text-xs font-bold text-slate-700 dark:text-slate-300 uppercase tracking-wider mb-2">Waktu Mulai</label>
                        <input type="time" name="waktu_mulai" value="{{ old('waktu_mulai', '09:00') }}" class="w-full px-4 py-2.5 rounded-xl bg-white dark:bg-slate-950 border border-slate-300 dark:border-slate-700 text-xs font-semibold text-slate-900 dark:text-white focus:ring-2 focus:ring-blue-600 outline-none shadow-sm">
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-slate-700 dark:text-slate-300 uppercase tracking-wider mb-2">Waktu Selesai</label>
                        <input type="time" name="waktu_selesai" value="{{ old('waktu_selesai', '12:00') }}" class="w-full px-4 py-2.5 rounded-xl bg-white dark:bg-slate-950 border border-slate-300 dark:border-slate-700 text-xs font-semibold text-slate-900 dark:text-white focus:ring-2 focus:ring-blue-600 outline-none shadow-sm">
                    </div>
                </div>

                <div class="md:col-span-2">
                    <label class="block text-xs font-bold text-slate-700 dark:text-slate-300 uppercase tracking-wider mb-2">Tempat / Lokasi Rapat *</label>
                    <input type="text" name="tempat" value="{{ old('tempat', 'Sekretariat PWI Banyuasin, Jl. Merdeka No. 3 Pangkalan Balai') }}" required class="w-full px-4 py-2.5 rounded-xl bg-white dark:bg-slate-950 border border-slate-300 dark:border-slate-700 text-xs font-semibold text-slate-900 dark:text-white focus:ring-2 focus:ring-blue-600 outline-none shadow-sm">
                </div>

                <div>
                    <label class="block text-xs font-bold text-slate-700 dark:text-slate-300 uppercase tracking-wider mb-2">Pemimpin Rapat *</label>
                    <input type="text" name="pemimpin_rapat" value="{{ old('pemimpin_rapat', 'Wardoyo, S.I.Kom (Ketua PWI)') }}" required class="w-full px-4 py-2.5 rounded-xl bg-white dark:bg-slate-950 border border-slate-300 dark:border-slate-700 text-xs font-semibold text-slate-900 dark:text-white focus:ring-2 focus:ring-blue-600 outline-none shadow-sm">
                </div>

                <div>
                    <label class="block text-xs font-bold text-slate-700 dark:text-slate-300 uppercase tracking-wider mb-2">Notulis Rapat *</label>
                    <input type="text" name="notulis" value="{{ old('notulis', 'Deni Arianto (Sekretaris PWI)') }}" required class="w-full px-4 py-2.5 rounded-xl bg-white dark:bg-slate-950 border border-slate-300 dark:border-slate-700 text-xs font-semibold text-slate-900 dark:text-white focus:ring-2 focus:ring-blue-600 outline-none shadow-sm">
                </div>

                <div class="md:col-span-2">
                    <label class="block text-xs font-bold text-slate-700 dark:text-slate-300 uppercase tracking-wider mb-2">Agenda Rapat *</label>
                    <textarea name="agenda" rows="3" required class="w-full px-4 py-2.5 rounded-xl bg-white dark:bg-slate-950 border border-slate-300 dark:border-slate-700 text-xs font-medium text-slate-900 dark:text-white focus:ring-2 focus:ring-blue-600 outline-none shadow-sm" placeholder="Tuliskan poin-poin agenda pembahasan...">{{ old('agenda') }}</textarea>
                </div>

                <div class="md:col-span-2">
                    <label class="block text-xs font-bold text-slate-700 dark:text-slate-300 uppercase tracking-wider mb-2 flex items-center justify-between">
                        <span>Jalannya Pembahasan Rapat *</span>
                        <span class="text-[11px] font-normal text-slate-500 lowercase">(dapat diperlebar / ditarik ke bawah jika uraian panjang)</span>
                    </label>
                    <textarea name="pembahasan" rows="12" required class="w-full px-4 py-3.5 rounded-xl bg-white dark:bg-slate-950 border border-slate-300 dark:border-slate-700 text-sm leading-relaxed text-slate-900 dark:text-white focus:ring-2 focus:ring-blue-600 outline-none shadow-sm min-h-[240px] resize-y" placeholder="Uraikan secara lengkap dan rinci poin-poin diskusi, pandangan anggota pengurus, pembahasan topik, serta dinamika rapat...">{{ old('pembahasan') }}</textarea>
                </div>

                <div class="md:col-span-2">
                    <label class="block text-xs font-bold text-slate-700 dark:text-slate-300 uppercase tracking-wider mb-2 flex items-center justify-between">
                        <span>Kesimpulan / Hasil Keputusan Rapat *</span>
                        <span class="text-[11px] font-normal text-slate-500 lowercase">(dapat diperlebar / ditarik ke bawah)</span>
                    </label>
                    <textarea name="kesimpulan" rows="8" required class="w-full px-4 py-3.5 rounded-xl bg-white dark:bg-slate-950 border border-slate-300 dark:border-slate-700 text-sm leading-relaxed text-slate-900 dark:text-white focus:ring-2 focus:ring-blue-600 outline-none shadow-sm min-h-[160px] resize-y" placeholder="Tuliskan butir-butir keputusan bulat rapat, instruksi pimpinan, pembagian tugas, target batas waktu, dan tindak lanjut program...">{{ old('kesimpulan') }}</textarea>
                </div>

                <div class="md:col-span-2">
                    <label class="block text-xs font-bold text-slate-700 dark:text-slate-300 uppercase tracking-wider mb-2">Lampiran File Dokumen / Foto Rapat (Opsional)</label>
                    <input type="file" name="file_lampiran" class="w-full px-4 py-2 rounded-xl bg-white dark:bg-slate-950 border border-slate-300 dark:border-slate-700 text-xs text-slate-600 dark:text-slate-400 file:mr-4 file:py-1.5 file:px-3 file:rounded-lg file:border-0 file:text-xs file:font-semibold file:bg-blue-600 file:text-white">
                </div>
            </div>
        </div>

        <!-- Attendance Checklist Card -->
        <div class="p-8 rounded-2xl bg-white dark:bg-slate-900 border border-slate-300 dark:border-slate-800 shadow-sm space-y-6">
            <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 border-b border-slate-200 dark:border-slate-800 pb-4">
                <div>
                    <h3 class="text-sm font-extrabold text-blue-700 dark:text-emerald-400 uppercase tracking-wider flex items-center gap-2">
                        <i class="fa-solid fa-list-check"></i> 2. Checklist Daftar Hadir Anggota Rapat ({{ count($members) }} Wartawan)
                    </h3>
                    <p class="text-xs text-slate-600 dark:text-slate-400 mt-1 font-medium">Tentukan status kehadiran setiap anggota untuk dimasukkan ke dalam lembar absensi resmi</p>
                </div>
                <div class="flex items-center gap-2 text-xs">
                    <button type="button" onclick="setAllAttendance('hadir')" class="px-3 py-1.5 rounded-lg bg-emerald-50 hover:bg-emerald-100 text-emerald-700 border border-emerald-300 font-bold transition-all cursor-pointer">
                        Set Semua Hadir
                    </button>
                    <button type="button" onclick="setAllAttendance('izin')" class="px-3 py-1.5 rounded-lg bg-amber-50 hover:bg-amber-100 text-amber-700 border border-amber-300 font-bold transition-all cursor-pointer">
                        Set Semua Izin
                    </button>
                </div>
            </div>

            <div class="overflow-x-auto max-h-[500px] custom-scrollbar border border-slate-200 dark:border-slate-800 rounded-2xl">
                <table class="w-full text-left text-xs text-slate-800 dark:text-slate-200">
                    <thead class="sticky top-0 bg-[#0B132B] dark:bg-[#070D1E] text-white uppercase tracking-wider text-[11px] border-b border-blue-950 z-10 font-bold">
                        <tr>
                            <th class="py-3 px-4 w-12 text-center">NO</th>
                            <th class="py-3 px-4">NAMA WARTAWAN</th>
                            <th class="py-3 px-4">JABATAN</th>
                            <th class="py-3 px-4 text-center w-64">STATUS KEHADIRAN</th>
                            <th class="py-3 px-4 w-56">KETERANGAN</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-200 dark:divide-slate-800 bg-white dark:bg-slate-900">
                        @foreach($members as $idx => $m)
                            <tr class="hover:bg-slate-50 dark:hover:bg-white/[0.02]">
                                <td class="py-2.5 px-4 text-center font-bold text-slate-500 dark:text-slate-400">{{ $idx + 1 }}</td>
                                <td class="py-2.5 px-4 font-bold text-slate-900 dark:text-white">
                                    {{ $m->nama }}
                                    <span class="block text-[10px] text-slate-500 font-mono font-medium">{{ $m->nomor_kartu ?? '-' }}</span>
                                </td>
                                <td class="py-2.5 px-4 text-slate-700 dark:text-slate-300 font-semibold">{{ $m->jabatan }}</td>
                                <td class="py-2.5 px-4">
                                    <div class="flex items-center justify-center gap-3">
                                        <label class="inline-flex items-center gap-1 cursor-pointer">
                                            <input type="radio" name="attendances[{{ $m->id }}][status]" value="hadir" checked class="att-radio text-emerald-600 focus:ring-emerald-500">
                                            <span class="text-emerald-700 dark:text-emerald-400 font-bold text-[11px]">Hadir</span>
                                        </label>
                                        <label class="inline-flex items-center gap-1 cursor-pointer">
                                            <input type="radio" name="attendances[{{ $m->id }}][status]" value="izin" class="att-radio text-amber-600 focus:ring-amber-500">
                                            <span class="text-amber-700 dark:text-amber-400 font-semibold text-[11px]">Izin</span>
                                        </label>
                                        <label class="inline-flex items-center gap-1 cursor-pointer">
                                            <input type="radio" name="attendances[{{ $m->id }}][status]" value="alpa" class="att-radio text-rose-600 focus:ring-rose-500">
                                            <span class="text-rose-700 dark:text-rose-400 font-semibold text-[11px]">Alpa</span>
                                        </label>
                                    </div>
                                </td>
                                <td class="py-2.5 px-4">
                                    <input type="text" name="attendances[{{ $m->id }}][keterangan]" placeholder="Catatan opsional..." class="w-full px-2.5 py-1 rounded-lg bg-white dark:bg-slate-950 border border-slate-300 dark:border-slate-700 text-[11px] text-slate-900 dark:text-slate-200 focus:ring-1 focus:ring-blue-600 outline-none shadow-sm">
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

        <div class="flex items-center justify-end gap-3 pt-4">
            <a href="{{ route('admin.meetings.index') }}" class="px-6 py-2.5 rounded-xl text-xs font-bold text-slate-600 dark:text-slate-400 hover:bg-slate-100 dark:hover:bg-slate-800 transition-colors">
                Batal
            </a>
            <button type="submit" class="px-8 py-2.5 rounded-xl text-xs font-bold text-white bg-blue-600 hover:bg-blue-700 shadow-sm transition-all flex items-center gap-2">
                <i class="fa-solid fa-save"></i>
                <span>Simpan Notulen & Absensi</span>
            </button>
        </div>
    </form>

</div>

<script>
function setAllAttendance(status) {
    document.querySelectorAll(`input.att-radio[value="${status}"]`).forEach(el => el.checked = true);
}
</script>
@endsection
