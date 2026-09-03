<?php

use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\GalleryController;
use App\Http\Controllers\Admin\InboxController;
use App\Http\Controllers\Admin\IncomingLetterController;
use App\Http\Controllers\Admin\LetterController;
use App\Http\Controllers\Admin\MediaController;
use App\Http\Controllers\Admin\MeetingMinuteController;
use App\Http\Controllers\Admin\MemberController;
use App\Http\Controllers\Admin\OrganizationController;
use App\Http\Controllers\Admin\PostController;
use App\Http\Controllers\Admin\SettingController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\PublicController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Public Routes (Frontend Portal)
|--------------------------------------------------------------------------
*/
Route::get('/', [PublicController::class, 'index'])->name('home');
Route::get('/berita', [PublicController::class, 'news'])->name('news.index');
Route::get('/berita/{slug}', [PublicController::class, 'newsDetail'])->name('news.show');
Route::get('/struktur-organisasi', [PublicController::class, 'organization'])->name('organization.public');
Route::get('/anggota', [PublicController::class, 'members'])->name('members.public');
Route::get('/galeri', [PublicController::class, 'gallery'])->name('gallery.public');
Route::post('/kontak/kirim', [PublicController::class, 'storeInbox'])->name('inbox.store');
Route::get('/verifikasi-surat/{hash}', [PublicController::class, 'verifyLetter'])->name('letter.verify');

/*
|--------------------------------------------------------------------------
| Authentication Routes
|--------------------------------------------------------------------------
*/
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.post');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

/*
|--------------------------------------------------------------------------
| Management Information System (MIS Admin Dashboard)
|--------------------------------------------------------------------------
*/
Route::prefix('admin')->middleware('auth')->name('admin.')->group(function () {
    // Dashboard & Laporan
    Route::get('/', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/dashboard', [DashboardController::class, 'index']);
    Route::get('/laporan/cetak', [DashboardController::class, 'printReport'])->name('members.print-report');

    // Modul Anggota
    Route::get('/anggota', [MemberController::class, 'index'])->name('members.index');
    Route::post('/anggota', [MemberController::class, 'store'])->name('members.store');
    Route::get('/anggota/tidak-aktif', [MemberController::class, 'inactive'])->name('members.inactive');
    Route::put('/anggota/{id}', [MemberController::class, 'update'])->name('members.update');
    Route::delete('/anggota/{id}', [MemberController::class, 'destroy'])->name('members.destroy');
    Route::post('/anggota/{id}/toggle-status', [MemberController::class, 'toggleStatus'])->name('members.toggle');

    // Modul Media
    Route::get('/media', [MediaController::class, 'index'])->name('media.index');
    Route::post('/media', [MediaController::class, 'store'])->name('media.store');
    Route::put('/media/{id}', [MediaController::class, 'update'])->name('media.update');
    Route::delete('/media/{id}', [MediaController::class, 'destroy'])->name('media.destroy');

    // Modul Struktur Organisasi
    Route::get('/struktur-organisasi', [OrganizationController::class, 'index'])->name('organization.index');
    Route::post('/struktur-organisasi', [OrganizationController::class, 'store'])->name('organization.store');
    Route::put('/struktur-organisasi/{id}', [OrganizationController::class, 'update'])->name('organization.update');
    Route::delete('/struktur-organisasi/{id}', [OrganizationController::class, 'destroy'])->name('organization.destroy');

    // Modul Surat Keluar (Administrasi)
    Route::get('/surat-keluar', [LetterController::class, 'index'])->name('letters.index');
    Route::get('/surat-keluar/buat', [LetterController::class, 'create'])->name('letters.create');
    Route::post('/surat-keluar', [LetterController::class, 'store'])->name('letters.store');
    Route::get('/surat-keluar/{id}/edit', [LetterController::class, 'edit'])->name('letters.edit');
    Route::put('/surat-keluar/{id}', [LetterController::class, 'update'])->name('letters.update');
    Route::delete('/surat-keluar/{id}', [LetterController::class, 'destroy'])->name('letters.destroy');
    Route::get('/surat-keluar/{id}/cetak', [LetterController::class, 'print'])->name('letters.print');

    // Modul Surat Masuk (Administrasi)
    Route::get('/surat-masuk', [IncomingLetterController::class, 'index'])->name('incoming-letters.index');
    Route::post('/surat-masuk', [IncomingLetterController::class, 'store'])->name('incoming-letters.store');
    Route::put('/surat-masuk/{id}', [IncomingLetterController::class, 'update'])->name('incoming-letters.update');
    Route::delete('/surat-masuk/{id}', [IncomingLetterController::class, 'destroy'])->name('incoming-letters.destroy');

    // Modul Notulen Rapat & Absensi (Fitur Baru PRD v2.0)
    Route::get('/notulen-rapat', [MeetingMinuteController::class, 'index'])->name('meetings.index');
    Route::get('/notulen-rapat/tambah', [MeetingMinuteController::class, 'create'])->name('meetings.create');
    Route::get('/notulen-rapat/create', [MeetingMinuteController::class, 'create']);
    Route::post('/notulen-rapat', [MeetingMinuteController::class, 'store'])->name('meetings.store');
    Route::get('/notulen-rapat/{id}', [MeetingMinuteController::class, 'show'])->name('meetings.show');
    Route::get('/notulen-rapat/{id}/edit', [MeetingMinuteController::class, 'edit'])->name('meetings.edit');
    Route::put('/notulen-rapat/{id}', [MeetingMinuteController::class, 'update'])->name('meetings.update');
    Route::delete('/notulen-rapat/{id}', [MeetingMinuteController::class, 'destroy'])->name('meetings.destroy');
    Route::get('/notulen-rapat/{id}/cetak', [MeetingMinuteController::class, 'print'])->name('meetings.print');

    // Modul Buku Tamu / Inbox
    Route::get('/inbox', [InboxController::class, 'index'])->name('inbox.index');
    Route::get('/inbox/{id}', [InboxController::class, 'show'])->name('inbox.show');
    Route::delete('/inbox/{id}', [InboxController::class, 'destroy'])->name('inbox.destroy');

    // Modul CMS Berita
    Route::get('/berita/publish', [PostController::class, 'publishIndex'])->name('posts.publish');
    Route::get('/berita/draft', [PostController::class, 'draftIndex'])->name('posts.draft');
    Route::get('/berita/tambah', [PostController::class, 'create'])->name('posts.create');
    Route::get('/berita/create', [PostController::class, 'create']);
    Route::post('/berita', [PostController::class, 'store'])->name('posts.store');
    Route::get('/berita/{id}/edit', [PostController::class, 'edit'])->name('posts.edit');
    Route::put('/berita/{id}', [PostController::class, 'update'])->name('posts.update');
    Route::delete('/berita/{id}', [PostController::class, 'destroy'])->name('posts.destroy');
    Route::post('/berita/{id}/toggle-publish', [PostController::class, 'togglePublish'])->name('posts.toggle');

    // Modul Galeri
    Route::get('/galeri', [GalleryController::class, 'index'])->name('galleries.index');
    Route::post('/galeri', [GalleryController::class, 'store'])->name('galleries.store');
    Route::put('/galeri/{id}', [GalleryController::class, 'update'])->name('galleries.update');
    Route::delete('/galeri/{id}', [GalleryController::class, 'destroy'])->name('galleries.destroy');

    // Modul Pengaturan
    Route::get('/pengaturan/data-pwi', [SettingController::class, 'office'])->name('settings.office');
    Route::post('/pengaturan/data-pwi', [SettingController::class, 'updateOffice'])->name('settings.office.update');
    Route::get('/pengaturan/ganti-sandi', [SettingController::class, 'password'])->name('settings.password');
    Route::post('/pengaturan/ganti-sandi', [SettingController::class, 'updatePassword'])->name('settings.password.update');
});
