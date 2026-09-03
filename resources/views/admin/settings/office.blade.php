@extends('layouts.admin')

@section('title', 'Data Kantor PWI Banyuasin')
@section('page_title', 'Pengaturan Data PWI')

@section('content')
<div class="max-w-4xl mx-auto space-y-6">
    
    <div class="flex items-center justify-between">
        <div>
            <h2 class="text-xl font-extrabold text-white">Pengaturan Identitas Kantor PWI</h2>
            <p class="text-xs text-slate-400 mt-1">Informasi ini akan ditampilkan secara langsung di website publik dan kop surat resmi</p>
        </div>
    </div>

    <form action="{{ route('admin.settings.office.update') }}" method="POST" class="space-y-6">
        @csrf

        <div class="p-8 rounded-3xl bg-slate-900 border border-slate-800 shadow-xl space-y-6">
            
            <div class="space-y-4">
                <div>
                    <label class="block text-xs font-bold text-slate-300 uppercase mb-1.5">Nama Organisasi *</label>
                    <input type="text" name="nama_pwi" value="{{ old('nama_pwi', $settings['nama_pwi'] ?? 'PWI Kabupaten Banyuasin') }}" required class="w-full px-4 py-3 rounded-xl bg-slate-950 border border-slate-800 text-sm text-white focus:ring-2 focus:ring-amber-500 outline-none">
                </div>

                <div>
                    <label class="block text-xs font-bold text-slate-300 uppercase mb-1.5">Alamat Kantor Sekretariat *</label>
                    <textarea name="alamat_kantor" rows="3" required class="w-full px-4 py-3 rounded-xl bg-slate-950 border border-slate-800 text-sm text-white focus:ring-2 focus:ring-amber-500 outline-none">{{ old('alamat_kantor', $settings['alamat_kantor'] ?? 'Jalan Merdeka NO 3 RT 02 RW 02 Kelurahan Mulya Agung Kecamatan Banyuasin III Kabupaten Banyuasin - Sumatera Selatan (30914)') }}</textarea>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-xs font-bold text-slate-300 uppercase mb-1.5">Kota / Ibukota *</label>
                        <input type="text" name="kota" value="{{ old('kota', $settings['kota'] ?? 'Pangkalan Balai') }}" required class="w-full px-4 py-2.5 rounded-xl bg-slate-950 border border-slate-800 text-xs text-white focus:ring-2 focus:ring-amber-500 outline-none">
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-slate-300 uppercase mb-1.5">No. Telepon / WhatsApp Sekretariat *</label>
                        <input type="text" name="no_telp" value="{{ old('no_telp', $settings['no_telp'] ?? '0853-7799-1976') }}" required class="w-full px-4 py-2.5 rounded-xl bg-slate-950 border border-slate-800 text-xs text-white focus:ring-2 focus:ring-amber-500 outline-none">
                    </div>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-xs font-bold text-slate-300 uppercase mb-1.5">Email Resmi Organisasi</label>
                        <input type="email" name="email" value="{{ old('email', $settings['email'] ?? 'sekretariat@pwibanyuasin.or.id') }}" class="w-full px-4 py-2.5 rounded-xl bg-slate-950 border border-slate-800 text-xs text-white focus:ring-2 focus:ring-amber-500 outline-none">
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-slate-300 uppercase mb-1.5">Nama Ketua PWI</label>
                        <input type="text" name="ketua_nama" value="{{ old('ketua_nama', $settings['ketua_nama'] ?? 'Wardoyo, S.I.Kom') }}" class="w-full px-4 py-2.5 rounded-xl bg-slate-950 border border-slate-800 text-xs text-white focus:ring-2 focus:ring-amber-500 outline-none">
                    </div>
                </div>

                <div>
                    <label class="block text-xs font-bold text-slate-300 uppercase mb-1.5">Teks Sambutan Ketua PWI</label>
                    <textarea name="ketua_sambutan" rows="4" class="w-full px-4 py-3 rounded-xl bg-slate-950 border border-slate-800 text-sm text-white focus:ring-2 focus:ring-amber-500 outline-none">{{ old('ketua_sambutan', $settings['ketua_sambutan'] ?? '') }}</textarea>
                </div>

                <div>
                    <label class="block text-xs font-bold text-slate-300 uppercase mb-1.5">Visi Organisasi</label>
                    <textarea name="visi" rows="2" class="w-full px-4 py-2.5 rounded-xl bg-slate-950 border border-slate-800 text-xs text-white focus:ring-2 focus:ring-amber-500 outline-none">{{ old('visi', $settings['visi'] ?? '') }}</textarea>
                </div>
            </div>

            <div class="flex items-center justify-end pt-6 border-t border-slate-800">
                <button type="submit" class="px-8 py-3 rounded-xl text-xs font-bold text-slate-950 bg-amber-400 hover:bg-amber-300 shadow-lg shadow-amber-400/20 transition-all flex items-center gap-2">
                    <i class="fa-solid fa-save"></i>
                    <span>Simpan Pengaturan Data PWI</span>
                </button>
            </div>

        </div>
    </form>

</div>
@endsection
