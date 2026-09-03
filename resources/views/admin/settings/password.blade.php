@extends('layouts.admin')

@section('title', 'Ganti Kata Sandi Admin')
@section('page_title', 'Keamanan Akun')

@section('content')
<div class="max-w-xl mx-auto space-y-6" x-data="{ showPass: false }">
    
    <div class="flex items-center justify-between">
        <div>
            <h2 class="text-xl font-extrabold text-[#0B132B] dark:text-white">Ganti Kata Sandi Administrator</h2>
            <p class="text-xs text-slate-600 dark:text-slate-400 mt-1 font-medium">Perbarui password akun untuk menjaga keamanan akses ke dashboard MIS</p>
        </div>
    </div>

    <form action="{{ route('admin.settings.password.update') }}" method="POST" class="space-y-6">
        @csrf

        <div class="p-8 rounded-2xl bg-white dark:bg-slate-900 border border-slate-300 dark:border-slate-800 shadow-sm space-y-6">
            
            @if($errors->any())
                <div class="p-4 rounded-xl bg-rose-500/10 border border-rose-500/20 text-rose-600 dark:text-rose-400 text-xs font-semibold">
                    <ul class="list-disc list-inside space-y-1">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <div class="space-y-4">
                <div>
                    <label class="block text-xs font-bold text-slate-700 dark:text-slate-300 uppercase tracking-wider mb-1.5">Kata Sandi Saat Ini *</label>
                    <input :type="showPass ? 'text' : 'password'" name="current_password" required class="w-full px-4 py-2.5 rounded-xl bg-white dark:bg-slate-950 border border-slate-300 dark:border-slate-700 text-xs font-semibold text-slate-900 dark:text-white focus:ring-2 focus:ring-blue-600 outline-none shadow-sm" placeholder="Masukkan kata sandi lama Anda">
                </div>

                <div>
                    <label class="block text-xs font-bold text-slate-700 dark:text-slate-300 uppercase tracking-wider mb-1.5">Kata Sandi Baru *</label>
                    <input :type="showPass ? 'text' : 'password'" name="password" required class="w-full px-4 py-2.5 rounded-xl bg-white dark:bg-slate-950 border border-slate-300 dark:border-slate-700 text-xs font-semibold text-slate-900 dark:text-white focus:ring-2 focus:ring-blue-600 outline-none shadow-sm" placeholder="Minimal 8 karakter">
                </div>

                <div>
                    <label class="block text-xs font-bold text-slate-700 dark:text-slate-300 uppercase tracking-wider mb-1.5">Ulangi Kata Sandi Baru *</label>
                    <input :type="showPass ? 'text' : 'password'" name="password_confirmation" required class="w-full px-4 py-2.5 rounded-xl bg-white dark:bg-slate-950 border border-slate-300 dark:border-slate-700 text-xs font-semibold text-slate-900 dark:text-white focus:ring-2 focus:ring-blue-600 outline-none shadow-sm" placeholder="Ketik ulang kata sandi">
                </div>

                <div class="flex items-center gap-2 pt-1">
                    <input type="checkbox" id="togglePass" @click="showPass = !showPass" class="rounded bg-white dark:bg-slate-950 border-slate-300 dark:border-slate-700 text-blue-600 focus:ring-blue-600 cursor-pointer">
                    <label for="togglePass" class="text-xs text-slate-600 dark:text-slate-400 cursor-pointer select-none font-medium">Tampilkan Kata Sandi</label>
                </div>
            </div>

            <div class="flex items-center justify-end gap-3 pt-6 border-t border-slate-200 dark:border-slate-800">
                <a href="{{ route('admin.dashboard') }}" class="px-6 py-2.5 rounded-xl text-xs font-bold text-slate-600 dark:text-slate-400 hover:bg-slate-100 dark:hover:bg-slate-800 transition-colors">
                    Batal
                </a>
                <button type="submit" class="px-6 py-2.5 rounded-xl text-xs font-bold text-white bg-blue-600 hover:bg-blue-700 shadow-sm transition-all">
                    Simpan Kata Sandi Baru
                </button>
            </div>

        </div>
    </form>

</div>
@endsection
