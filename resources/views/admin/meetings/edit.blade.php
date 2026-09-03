@extends('layouts.admin')

@section('title', 'Edit Notulen Rapat')
@section('page_title', 'Edit Notulen Rapat')

@section('content')
<div class="max-w-6xl mx-auto space-y-6">
    
    <div class="flex items-center justify-between">
        <div>
            <h2 class="text-xl font-extrabold text-white">Edit Notulen Rapat</h2>
            <p class="text-xs text-slate-400 mt-1">{{ $meeting->judul_rapat }}</p>
        </div>
        <a href="{{ route('admin.meetings.index') }}" class="px-4 py-2 rounded-xl text-xs font-semibold text-slate-300 bg-slate-900 border border-slate-800 hover:text-white">
            <i class="fa-solid fa-arrow-left me-1"></i> Kembali
        </a>
    </div>

    <form action="{{ route('admin.meetings.update', $meeting->id) }}" method="POST" enctype="multipart/form-data" class="space-y-6">
        @csrf
        @method('PUT')

        <!-- Details Card -->
        <div class="p-8 rounded-3xl bg-slate-900 border border-slate-800 shadow-xl space-y-6">
            <h3 class="text-sm font-bold text-amber-400 uppercase tracking-wider flex items-center gap-2">
                <i class="fa-solid fa-file-signature"></i> 1. Informasi Rapat
            </h3>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div class="md:col-span-2">
                    <label class="block text-xs font-bold text-slate-300 uppercase mb-2">Judul / Agenda Utama Rapat *</label>
                    <input type="text" name="judul_rapat" value="{{ old('judul_rapat', $meeting->judul_rapat) }}" required class="w-full px-4 py-3 rounded-xl bg-slate-950 border border-slate-800 text-sm text-white focus:ring-2 focus:ring-amber-500 focus:border-amber-500 outline-none">
                </div>

                <div>
                    <label class="block text-xs font-bold text-slate-300 uppercase mb-2">Tanggal Pelaksanaan *</label>
                    <input type="date" name="tanggal" value="{{ old('tanggal', $meeting->tanggal ? $meeting->tanggal->format('Y-m-d') : '') }}" required class="w-full px-4 py-3 rounded-xl bg-slate-950 border border-slate-800 text-sm text-white focus:ring-2 focus:ring-amber-500 focus:border-amber-500 outline-none">
                </div>

                <div class="grid grid-cols-2 gap-3">
                    <div>
                        <label class="block text-xs font-bold text-slate-300 uppercase mb-2">Waktu Mulai</label>
                        <input type="time" name="waktu_mulai" value="{{ old('waktu_mulai', $meeting->waktu_mulai ? substr($meeting->waktu_mulai, 0, 5) : '09:00') }}" class="w-full px-4 py-3 rounded-xl bg-slate-950 border border-slate-800 text-sm text-white focus:ring-2 focus:ring-amber-500 focus:border-amber-500 outline-none">
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-slate-300 uppercase mb-2">Waktu Selesai</label>
                        <input type="time" name="waktu_selesai" value="{{ old('waktu_selesai', $meeting->waktu_selesai ? substr($meeting->waktu_selesai, 0, 5) : '12:00') }}" class="w-full px-4 py-3 rounded-xl bg-slate-950 border border-slate-800 text-sm text-white focus:ring-2 focus:ring-amber-500 focus:border-amber-500 outline-none">
                    </div>
                </div>

                <div class="md:col-span-2">
                    <label class="block text-xs font-bold text-slate-300 uppercase mb-2">Tempat / Lokasi Rapat *</label>
                    <input type="text" name="tempat" value="{{ old('tempat', $meeting->tempat) }}" required class="w-full px-4 py-3 rounded-xl bg-slate-950 border border-slate-800 text-sm text-white focus:ring-2 focus:ring-amber-500 focus:border-amber-500 outline-none">
                </div>

                <div>
                    <label class="block text-xs font-bold text-slate-300 uppercase mb-2">Pemimpin Rapat *</label>
                    <input type="text" name="pemimpin_rapat" value="{{ old('pemimpin_rapat', $meeting->pemimpin_rapat) }}" required class="w-full px-4 py-3 rounded-xl bg-slate-950 border border-slate-800 text-sm text-white focus:ring-2 focus:ring-amber-500 focus:border-amber-500 outline-none">
                </div>

                <div>
                    <label class="block text-xs font-bold text-slate-300 uppercase mb-2">Notulis Rapat *</label>
                    <input type="text" name="notulis" value="{{ old('notulis', $meeting->notulis) }}" required class="w-full px-4 py-3 rounded-xl bg-slate-950 border border-slate-800 text-sm text-white focus:ring-2 focus:ring-amber-500 focus:border-amber-500 outline-none">
                </div>

                <div class="md:col-span-2">
                    <label class="block text-xs font-bold text-slate-300 uppercase mb-2">Agenda Rapat *</label>
                    <textarea name="agenda" rows="3" required class="w-full px-4 py-3 rounded-xl bg-slate-950 border border-slate-800 text-sm text-white focus:ring-2 focus:ring-amber-500 focus:border-amber-500 outline-none">{{ old('agenda', $meeting->agenda) }}</textarea>
                </div>

                <div class="md:col-span-2">
                    <label class="block text-xs font-bold text-slate-300 uppercase mb-2">Jalannya Pembahasan Rapat *</label>
                    <textarea name="pembahasan" rows="6" required class="w-full px-4 py-3 rounded-xl bg-slate-950 border border-slate-800 text-sm text-white focus:ring-2 focus:ring-amber-500 focus:border-amber-500 outline-none">{{ old('pembahasan', $meeting->pembahasan) }}</textarea>
                </div>

                <div class="md:col-span-2">
                    <label class="block text-xs font-bold text-slate-300 uppercase mb-2">Kesimpulan / Hasil Keputusan Rapat *</label>
                    <textarea name="kesimpulan" rows="4" required class="w-full px-4 py-3 rounded-xl bg-slate-950 border border-slate-800 text-sm text-white focus:ring-2 focus:ring-amber-500 focus:border-amber-500 outline-none">{{ old('kesimpulan', $meeting->kesimpulan) }}</textarea>
                </div>

                <div class="md:col-span-2">
                    <label class="block text-xs font-bold text-slate-300 uppercase mb-2">Ganti Lampiran File (Opsional)</label>
                    <input type="file" name="file_lampiran" class="w-full px-4 py-2.5 rounded-xl bg-slate-950 border border-slate-800 text-xs text-slate-400 file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-xs file:font-semibold file:bg-amber-400 file:text-slate-950">
                    @if($meeting->file_lampiran)
                        <div class="mt-2 text-xs text-slate-400">
                            File saat ini: <a href="{{ asset('storage/' . $meeting->file_lampiran) }}" target="_blank" class="text-amber-400 underline">Lihat Lampiran</a>
                        </div>
                    @endif
                </div>
            </div>
        </div>

        <!-- Attendance Card -->
        <div class="p-8 rounded-3xl bg-slate-900 border border-slate-800 shadow-xl space-y-6">
            <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 border-b border-slate-800 pb-4">
                <div>
                    <h3 class="text-sm font-bold text-emerald-400 uppercase tracking-wider flex items-center gap-2">
                        <i class="fa-solid fa-list-check"></i> 2. Checklist Daftar Hadir Anggota Rapat
                    </h3>
                </div>
                <div class="flex items-center gap-2 text-xs">
                    <button type="button" onclick="setAllAttendance('hadir')" class="px-3 py-1.5 rounded-lg bg-emerald-500/10 hover:bg-emerald-500/20 text-emerald-400 border border-emerald-500/30">
                        Set Semua Hadir
                    </button>
                    <button type="button" onclick="setAllAttendance('izin')" class="px-3 py-1.5 rounded-lg bg-amber-500/10 hover:bg-amber-500/20 text-amber-400 border border-amber-500/30">
                        Set Semua Izin
                    </button>
                </div>
            </div>

            <div class="overflow-x-auto max-h-[500px] custom-scrollbar border border-slate-800 rounded-2xl">
                <table class="w-full text-left text-xs text-slate-300">
                    <thead class="sticky top-0 bg-slate-950 text-slate-400 uppercase tracking-wider text-[11px] border-b border-slate-800 z-10">
                        <tr>
                            <th class="py-3 px-4 w-12 text-center">NO</th>
                            <th class="py-3 px-4">NAMA WARTAWAN</th>
                            <th class="py-3 px-4">JABATAN</th>
                            <th class="py-3 px-4 text-center w-64">STATUS KEHADIRAN</th>
                            <th class="py-3 px-4 w-56">KETERANGAN</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-800/60 bg-slate-900/50">
                        @foreach($members as $idx => $m)
                            @php
                                $currentStatus = isset($attendancesMap[$m->id]) ? $attendancesMap[$m->id]->status_kehadiran : 'hadir';
                                $currentKet = isset($attendancesMap[$m->id]) ? $attendancesMap[$m->id]->keterangan : '';
                            @endphp
                            <tr class="hover:bg-white/[0.02]">
                                <td class="py-2.5 px-4 text-center font-bold text-slate-500">{{ $idx + 1 }}</td>
                                <td class="py-2.5 px-4 font-bold text-white">
                                    {{ $m->nama }}
                                    <span class="block text-[10px] text-slate-500 font-mono">{{ $m->nomor_kartu ?? '-' }}</span>
                                </td>
                                <td class="py-2.5 px-4 text-amber-400 font-semibold">{{ $m->jabatan }}</td>
                                <td class="py-2.5 px-4">
                                    <div class="flex items-center justify-center gap-3">
                                        <label class="inline-flex items-center gap-1 cursor-pointer">
                                            <input type="radio" name="attendances[{{ $m->id }}][status]" value="hadir" {{ $currentStatus === 'hadir' ? 'checked' : '' }} class="att-radio text-emerald-500 focus:ring-emerald-400">
                                            <span class="text-emerald-400 font-bold text-[11px]">Hadir</span>
                                        </label>
                                        <label class="inline-flex items-center gap-1 cursor-pointer">
                                            <input type="radio" name="attendances[{{ $m->id }}][status]" value="izin" {{ $currentStatus === 'izin' ? 'checked' : '' }} class="att-radio text-amber-500 focus:ring-amber-400">
                                            <span class="text-amber-400 font-semibold text-[11px]">Izin</span>
                                        </label>
                                        <label class="inline-flex items-center gap-1 cursor-pointer">
                                            <input type="radio" name="attendances[{{ $m->id }}][status]" value="alpa" {{ $currentStatus === 'alpa' ? 'checked' : '' }} class="att-radio text-rose-500 focus:ring-rose-400">
                                            <span class="text-rose-400 font-semibold text-[11px]">Alpa</span>
                                        </label>
                                    </div>
                                </td>
                                <td class="py-2.5 px-4">
                                    <input type="text" name="attendances[{{ $m->id }}][keterangan]" value="{{ $currentKet }}" placeholder="Catatan opsional..." class="w-full px-2.5 py-1 rounded-lg bg-slate-950 border border-slate-800 text-[11px] text-slate-300 focus:ring-1 focus:ring-amber-500 outline-none">
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

        <div class="flex items-center justify-end gap-3 pt-4">
            <a href="{{ route('admin.meetings.index') }}" class="px-6 py-3 rounded-xl text-xs font-bold text-slate-400 hover:text-white bg-slate-900 border border-slate-800">
                Batal
            </a>
            <button type="submit" class="px-8 py-3 rounded-xl text-xs font-bold text-slate-950 bg-amber-400 hover:bg-amber-300 shadow-lg shadow-amber-400/20 transition-all flex items-center gap-2">
                <i class="fa-solid fa-save"></i>
                <span>Simpan Perubahan Notulen</span>
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
