@extends('layouts.admin')

@section('title', 'Ganti Kata Sandi Admin')
@section('page_title', 'Keamanan Akun')

@section('content')
<div class="max-w-xl mx-auto space-y-6" x-data="{ showPass: false }">
    
    <div class="flex items-center justify-between">
        <div>
            <h2 class="text-xl font-extrabold text-white">Ganti Kata Sandi Administrator</h2>
            <p class="text-xs text-slate-400 mt-1">Perbarui password akun untuk menjaga keamanan akses ke dashboard MIS</p>
        </div>
    </div>

    <form action="{{ route('admin.settings.password.update') }}" method="POST" class="space-y-6">
        @csrf

        <div class="p-8 rounded-3xl bg-slate-900 border border-slate-800 shadow-xl space-y-6">
            
            <div class="space-y-4">
                <div>
                    <label class="block text-xs font-bold text-slate-300 uppercase mb-1.5">Kata Sandi Baru *</label>
                    <input :type="showPass ? 'text' : 'password'" name="password" required class="w-full px-4 py-2.5 rounded-xl bg-slate-950 border border-slate-800 text-xs text-white focus:ring-2 focus:ring-amber-500 outline-none" placeholder="Minimal 8 karakter">
                </div>

                <div>
                    <label class="block text-xs font-bold text-slate-300 uppercase mb-1.5">Ulangi Kata Sandi Baru *</label>
                    <input :type="showPass ? 'text' : 'password'" name="password_confirmation" required class="w-full px-4 py-2.5 rounded-xl bg-slate-950 border border-slate-800 text-xs text-white focus:ring-2 focus:ring-amber-500 outline-none" placeholder="Ketik ulang kata sandi">
                </div>

                <div class="flex items-center gap-2 pt-1">
                    <input type="checkbox" id="togglePass" @click="showPass = !showPass" class="rounded bg-slate-950 border-slate-800 text-amber-500 focus:ring-amber-500">
                    <label for="togglePass" class="text-xs text-slate-400 cursor-pointer select-none">Tampilkan Kata Sandi</label>
                </div>
            </div>

            <div class="flex items-center justify-end gap-3 pt-6 border-t border-slate-800">
                <a href="{{ route('admin.dashboard') }}" class="px-6 py-2.5 rounded-xl text-xs font-semibold text-slate-400 hover:text-white bg-slate-950">
                    Batal
                </a>
                <button type="submit" class="px-6 py-2.5 rounded-xl text-xs font-bold text-slate-950 bg-amber-400 hover:bg-amber-300 shadow-lg shadow-amber-400/20 transition-all">
                    Simpan Kata Sandi Baru
                </button>
            </div>

        </div>
    </form>

</div>
@endsection
