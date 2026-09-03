<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Setting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class SettingController extends Controller
{
    public function office()
    {
        $settings = Setting::pluck('value', 'key')->toArray();

        return view('admin.settings.office', compact('settings'));
    }

    public function updateOffice(Request $request)
    {
        $validated = $request->validate([
            'nama_pwi' => 'required|string|max:255',
            'alamat_kantor' => 'required|string',
            'kota' => 'required|string|max:100',
            'no_telp' => 'required|string|max:100',
            'email' => 'nullable|email|max:255',
            'ketua_nama' => 'nullable|string|max:255',
            'ketua_sambutan' => 'nullable|string',
            'visi' => 'nullable|string',
        ]);

        foreach ($validated as $key => $value) {
            Setting::set($key, $value);
        }

        return redirect()->back()->with('success', 'Data kantor PWI berhasil diperbarui.');
    }

    public function password()
    {
        return view('admin.settings.password');
    }

    public function updatePassword(Request $request)
    {
        $request->validate([
            'current_password' => 'required|current_password',
            'password' => 'required|string|min:8|confirmed',
        ], [
            'current_password.required' => 'Kata sandi saat ini wajib diisi.',
            'current_password.current_password' => 'Kata sandi saat ini yang Anda masukkan salah.',
            'password.required' => 'Kata sandi baru wajib diisi.',
            'password.min' => 'Kata sandi baru minimal harus 8 karakter.',
            'password.confirmed' => 'Konfirmasi kata sandi baru tidak cocok.',
        ]);

        $user = Auth::user();
        $user->password = Hash::make($request->password);
        $user->save();

        return redirect()->back()->with('success', 'Kata sandi admin berhasil diperbarui dengan aman.');
    }
}
