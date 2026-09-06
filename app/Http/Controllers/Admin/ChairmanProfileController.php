<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\ChairmanArchiveController;
use App\Http\Controllers\Controller;
use App\Models\Setting;
use App\Services\ImageService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

class ChairmanProfileController extends Controller
{
    /**
     * Tampilkan formulir pengeditan profil dan portofolio ketua
     */
    public function edit(): View
    {
        $profile = ChairmanArchiveController::getChairmanProfile();

        return view('admin.chairman_profile.edit', compact('profile'));
    }

    /**
     * Simpan pembaruan data profil ketua
     */
    public function update(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'title' => 'required|string|max:255',
            'sk_resmi' => 'nullable|string|max:255',
            'badge_top' => 'nullable|string|max:255',
            'tag_status_pers' => 'nullable|string|max:255',
            'tag_organisasi_provinsi' => 'nullable|string|max:255',
            'motto' => 'nullable|string',
            'ttl' => 'nullable|string|max:255',
            'agama' => 'nullable|string|max:100',
            'alamat' => 'nullable|string',
            'lokasi_singkat' => 'nullable|string|max:255',

            // Card di bawah foto
            'badge_bawah_foto' => 'nullable|string|max:100',
            'judul_bawah_foto' => 'nullable|string|max:255',
            'subjudul_bawah_foto' => 'nullable|string|max:255',

            // Kontak
            'telepon' => 'nullable|string|max:50',
            'email' => 'nullable|email|max:255',
            'instagram' => 'nullable|string|max:255',
            'facebook' => 'nullable|string|max:255',

            // Stat counters
            'stat_karya' => 'nullable|string|max:50',
            'stat_karya_label' => 'nullable|string|max:50',
            'stat_kiprah' => 'nullable|string|max:50',
            'stat_kiprah_label' => 'nullable|string|max:50',
            'stat_lisensi' => 'nullable|string|max:50',
            'stat_lisensi_label' => 'nullable|string|max:50',
            'stat_pendidikan' => 'nullable|string|max:50',
            'stat_pendidikan_label' => 'nullable|string|max:50',

            // Narasi & Biografi
            'narasi_judul' => 'nullable|string|max:255',
            'narasi_subjudul' => 'nullable|string|max:255',
            'narasi_paragraf_1' => 'nullable|string',
            'narasi_paragraf_2' => 'nullable|string',
            'narasi_paragraf_3' => 'nullable|string',

            // Pilar Nilai
            'pilar_nilai' => 'nullable|array',
            'pilar_nilai.*.title' => 'nullable|string|max:255',
            'pilar_nilai.*.desc' => 'nullable|string',
            'pilar_nilai.*.icon' => 'nullable|string|max:100',

            // Riwayat Organisasi
            'organisasi' => 'nullable|array',
            'organisasi.*.posisi' => 'nullable|string|max:255',
            'organisasi.*.masa' => 'nullable|string|max:100',
            'organisasi.*.ket' => 'nullable|string',

            // Pendidikan
            'pendidikan' => 'nullable|array',
            'pendidikan.*.tingkat' => 'nullable|string|max:100',
            'pendidikan.*.instansi' => 'nullable|string|max:255',
            'pendidikan.*.prodi' => 'nullable|string|max:255',
            'pendidikan.*.status' => 'nullable|string|max:100',

            // Sertifikasi
            'sertifikasi' => 'nullable|array',
            'sertifikasi.*.bidang' => 'nullable|string|max:255',
            'sertifikasi.*.penerbit' => 'nullable|string|max:255',
            'sertifikasi.*.nomor' => 'nullable|string|max:255',
            'sertifikasi.*.tahun' => 'nullable|string|max:100',
            'sertifikasi.*.keterangan' => 'nullable|string',

            // Footer Banner Kemitraan
            'footer_badge' => 'nullable|string|max:255',
            'footer_title' => 'nullable|string|max:255',
            'footer_desc' => 'nullable|string',

            // Foto
            'foto' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:5120',
            'remove_foto' => 'nullable|in:0,1',
        ]);

        // 1. Penanganan Upload / Hapus Foto Resmi
        $currentPhoto = Setting::get('chairman_profile_photo');

        if ($request->boolean('remove_foto')) {
            if ($currentPhoto && Storage::disk('public')->exists($currentPhoto)) {
                Storage::disk('public')->delete($currentPhoto);
            }
            Setting::set('chairman_profile_photo', null);
        } elseif ($request->hasFile('foto')) {
            if ($currentPhoto && Storage::disk('public')->exists($currentPhoto)) {
                Storage::disk('public')->delete($currentPhoto);
            }

            $uploadedFile = $request->file('foto');
            $photoPath = ImageService::uploadAndConvertToWebp($uploadedFile, 'chairman');
            Setting::set('chairman_profile_photo', $photoPath);

            // Perbarui juga gambar social share square untuk WhatsApp/FB
            $this->updateSocialShareImage($uploadedFile);
        }

        // 2. Sanitasi & Strukturisasi Data Array Profil
        $organisasiClean = [];
        if (! empty($validated['organisasi']) && is_array($validated['organisasi'])) {
            foreach ($validated['organisasi'] as $item) {
                if (! empty($item['posisi'])) {
                    $organisasiClean[] = [
                        'posisi' => trim($item['posisi']),
                        'masa' => trim($item['masa'] ?? ''),
                        'ket' => trim($item['ket'] ?? ''),
                    ];
                }
            }
        }

        $pendidikanClean = [];
        if (! empty($validated['pendidikan']) && is_array($validated['pendidikan'])) {
            foreach ($validated['pendidikan'] as $item) {
                if (! empty($item['instansi']) || ! empty($item['tingkat'])) {
                    $pendidikanClean[] = [
                        'tingkat' => trim($item['tingkat'] ?? ''),
                        'instansi' => trim($item['instansi'] ?? ''),
                        'prodi' => trim($item['prodi'] ?? ''),
                        'status' => trim($item['status'] ?? 'Lulus'),
                        'is_completed' => empty($item['status']) || str_contains(strtolower($item['status']), 'lulus'),
                    ];
                }
            }
        }

        $sertifikasiClean = [];
        if (! empty($validated['sertifikasi']) && is_array($validated['sertifikasi'])) {
            foreach ($validated['sertifikasi'] as $item) {
                if (! empty($item['bidang'])) {
                    $sertifikasiClean[] = [
                        'bidang' => trim($item['bidang']),
                        'penerbit' => trim($item['penerbit'] ?? ''),
                        'nomor' => trim($item['nomor'] ?? ''),
                        'tahun' => trim($item['tahun'] ?? ''),
                        'keterangan' => trim($item['keterangan'] ?? ''),
                    ];
                }
            }
        }

        $pilarClean = [];
        if (! empty($validated['pilar_nilai']) && is_array($validated['pilar_nilai'])) {
            foreach ($validated['pilar_nilai'] as $pilar) {
                if (! empty($pilar['title'])) {
                    $pilarClean[] = [
                        'title' => trim($pilar['title']),
                        'desc' => trim($pilar['desc'] ?? ''),
                        'icon' => trim($pilar['icon'] ?? 'fa-solid fa-award'),
                    ];
                }
            }
        }

        $profileData = [
            'name' => $validated['name'],
            'title' => $validated['title'],
            'sk_resmi' => $validated['sk_resmi'] ?? 'SK PWI Pusat Nomor: 033/PP-PWI/XI/2025',
            'badge_top' => $validated['badge_top'] ?? 'Profil Eksekutif & Personal Branding Resmi',
            'tag_status_pers' => $validated['tag_status_pers'] ?? 'Wartawan Utama Dewan Pers',
            'tag_organisasi_provinsi' => $validated['tag_organisasi_provinsi'] ?? 'Anggota DKP PWI Sumsel',
            'motto' => $validated['motto'] ?? '',
            'ttl' => $validated['ttl'] ?? '',
            'agama' => $validated['agama'] ?? 'Islam',
            'alamat' => $validated['alamat'] ?? '',
            'lokasi_singkat' => $validated['lokasi_singkat'] ?? 'Talang Kelapa, Banyuasin',

            // Card di bawah foto
            'badge_bawah_foto' => $validated['badge_bawah_foto'] ?? 'PWI KABUPATEN BANYUASIN',
            'judul_bawah_foto' => $validated['judul_bawah_foto'] ?? 'Ketua PWI Banyuasin',
            'subjudul_bawah_foto' => $validated['subjudul_bawah_foto'] ?? 'Masa Bakti 2025 – 2028',

            // Kontak
            'kontak' => [
                'telepon' => $validated['telepon'] ?? null,
                'email' => $validated['email'] ?? 'wardianstp@gmail.com',
                'instagram' => $validated['instagram'] ?? 'https://www.instagram.com/wardianstp/',
                'facebook' => $validated['facebook'] ?? 'https://www.facebook.com/ward.wardoyo',
            ],

            // Stat counters
            'stat_karya' => $validated['stat_karya'] ?? '320+',
            'stat_karya_label' => $validated['stat_karya_label'] ?? 'Karya Tulis',
            'stat_kiprah' => $validated['stat_kiprah'] ?? '18+ Th',
            'stat_kiprah_label' => $validated['stat_kiprah_label'] ?? 'Kiprah Jurnalistik',
            'stat_lisensi' => $validated['stat_lisensi'] ?? 'Utama',
            'stat_lisensi_label' => $validated['stat_lisensi_label'] ?? 'Lisensi UKW',
            'stat_pendidikan' => $validated['stat_pendidikan'] ?? 'S.I.Kom.',
            'stat_pendidikan_label' => $validated['stat_pendidikan_label'] ?? 'Ilmu Komunikasi',

            // Narasi
            'narasi_judul' => $validated['narasi_judul'] ?? 'Komitmen Teruji Mengawal Integritas Pers & Pembangunan Banyuasin',
            'narasi_subjudul' => $validated['narasi_subjudul'] ?? 'Tentang Kepemimpinan & Pengabdian',
            'narasi_paragraf_1' => $validated['narasi_paragraf_1'] ?? '',
            'narasi_paragraf_2' => $validated['narasi_paragraf_2'] ?? '',
            'narasi_paragraf_3' => $validated['narasi_paragraf_3'] ?? '',

            // Koleksi Dinamis
            'pilar_nilai' => $pilarClean,
            'organisasi' => $organisasiClean,
            'pendidikan' => $pendidikanClean,
            'sertifikasi' => $sertifikasiClean,

            // Footer Banner Kemitraan
            'footer_badge' => $validated['footer_badge'] ?? 'Silaturahmi & Kemitraan Strategis',
            'footer_title' => $validated['footer_title'] ?? 'Terhubung Langsung dengan Wardoyo, S.I.Kom.',
            'footer_desc' => $validated['footer_desc'] ?? '',
        ];

        Setting::set('chairman_profile_data', json_encode($profileData, JSON_UNESCAPED_UNICODE));

        return redirect()->route('admin.chairman_profile.edit')->with('success', 'Profil dan portofolio Ketua berhasil diperbarui. Seluruh halaman web publik telah disinkronkan secara otomatis.');
    }

    /**
     * Memperbarui file preview media sosial berukuran kotak untuk OpenGraph
     */
    protected function updateSocialShareImage($uploadedFile): void
    {
        try {
            if (! extension_loaded('gd')) {
                return;
            }

            $realPath = $uploadedFile->getRealPath();
            $mime = $uploadedFile->getClientMimeType() ?: $uploadedFile->getMimeType();

            $src = match ($mime) {
                'image/jpeg', 'image/jpg' => @imagecreatefromjpeg($realPath),
                'image/png' => @imagecreatefrompng($realPath),
                'image/webp' => @imagecreatefromwebp($realPath),
                default => false,
            };

            if (! $src) {
                return;
            }

            $w = imagesx($src);
            $h = imagesy($src);

            $size = min($w, $h);
            $srcX = (int) (($w - $size) / 2);
            $srcY = 0; // Prioritaskan wajah bagian atas

            $crop = imagecreatetruecolor(800, 800);
            imagecopyresampled($crop, $src, 0, 0, $srcX, $srcY, 800, 800, $size, $size);

            $outPath = public_path('assets/images/wardoyo-share.jpg');
            imagejpeg($crop, $outPath, 90);

            imagedestroy($src);
            imagedestroy($crop);
        } catch (\Throwable) {
            // Lanjut jika terjadi kendala pada GD
        }
    }
}
