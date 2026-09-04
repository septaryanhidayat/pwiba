<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Setting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

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
            'misi' => 'nullable|string',
            'logo' => 'nullable|image|mimes:png,jpg,jpeg,webp,svg|max:3072',
            'remove_logo' => 'nullable|in:0,1',
        ]);

        $currentLogo = Setting::get('logo');

        if ($request->boolean('remove_logo')) {
            if ($currentLogo && Storage::disk('public')->exists($currentLogo)) {
                Storage::disk('public')->delete($currentLogo);
            }
            Setting::set('logo', null);
        } elseif ($request->hasFile('logo')) {
            if ($currentLogo && Storage::disk('public')->exists($currentLogo)) {
                Storage::disk('public')->delete($currentLogo);
            }
            $logoPath = $request->file('logo')->store('settings', 'public');
            Setting::set('logo', $logoPath);
        }

        $textKeys = [
            'nama_pwi',
            'alamat_kantor',
            'kota',
            'no_telp',
            'email',
            'ketua_nama',
            'ketua_sambutan',
            'visi',
            'misi',
        ];

        foreach ($textKeys as $key) {
            if ($request->has($key)) {
                Setting::set($key, $request->input($key));
            }
        }

        return redirect()->back()->with('success', 'Data kantor dan logo PWI berhasil diperbarui. Seluruh halaman web telah disinkronkan.');
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
