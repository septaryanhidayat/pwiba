<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Media;
use App\Models\Member;
use App\Models\Setting;
use App\Services\ImageService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class MemberController extends Controller
{
    /**
     * SQL Order clause to sort Pengurus first by leadership hierarchy, then regular members.
     */
    protected function getPengurusOrderSql(): string
    {
        return "CASE 
            WHEN UPPER(TRIM(jabatan)) = 'KETUA' THEN 1
            WHEN UPPER(TRIM(jabatan)) LIKE 'WAKIL KETUA%' THEN 2
            WHEN UPPER(TRIM(jabatan)) = 'SEKRETARIS' THEN 3
            WHEN UPPER(TRIM(jabatan)) LIKE 'WAKIL SEKRETARIS%' THEN 4
            WHEN UPPER(TRIM(jabatan)) = 'BENDAHARA' THEN 5
            WHEN UPPER(TRIM(jabatan)) LIKE 'WAKIL BENDAHARA%' THEN 6
            WHEN UPPER(TRIM(jabatan)) LIKE 'KABID%' THEN 7
            WHEN UPPER(TRIM(jabatan)) LIKE 'WAKABID%' THEN 8
            WHEN UPPER(TRIM(jabatan)) LIKE 'ANGGOTA BID%' THEN 9
            WHEN UPPER(TRIM(jabatan)) != 'ANGGOTA' THEN 10
            ELSE 20 END";
    }

    public function index(Request $request)
    {
        $query = Member::where('status', 'aktif')->with('media');

        if ($request->filled('search')) {
            $s = $request->search;
            $query->where(function ($q) use ($s) {
                $q->where('nama', 'like', "%{$s}%")
                    ->orWhere('nomor_kartu', 'like', "%{$s}%")
                    ->orWhere('nomor_kartu_ukw', 'like', "%{$s}%")
                    ->orWhere('jabatan', 'like', "%{$s}%")
                    ->orWhere('tingkat_ukw', 'like', "%{$s}%")
                    ->orWhere('nama_media_custom', 'like', "%{$s}%")
                    ->orWhereHas('media', function ($mq) use ($s) {
                        $mq->where('nama_media', 'like', "%{$s}%");
                    });
            });
        }

        $perPage = $request->get('entries', 10);
        $members = $query->orderByRaw($this->getPengurusOrderSql())
            ->orderBy('nama', 'asc')
            ->paginate($perPage);

        $mediaList = Media::orderBy('nama_media', 'asc')->get();
        $showPublicMembers = (Setting::where('key', 'show_public_members')->value('value') ?? '0') === '1';

        return view('admin.members.index', compact('members', 'mediaList', 'showPublicMembers'));
    }

    public function inactive(Request $request)
    {
        $query = Member::where('status', 'tidak_aktif')->with('media');

        if ($request->filled('search')) {
            $s = $request->search;
            $query->where(function ($q) use ($s) {
                $q->where('nama', 'like', "%{$s}%")
                    ->orWhere('nomor_kartu', 'like', "%{$s}%")
                    ->orWhere('nomor_kartu_ukw', 'like', "%{$s}%")
                    ->orWhere('jabatan', 'like', "%{$s}%")
                    ->orWhere('tingkat_ukw', 'like', "%{$s}%")
                    ->orWhere('nama_media_custom', 'like', "%{$s}%")
                    ->orWhereHas('media', function ($mq) use ($s) {
                        $mq->where('nama_media', 'like', "%{$s}%");
                    });
            });
        }

        $perPage = $request->get('entries', 10);
        $members = $query->orderByRaw($this->getPengurusOrderSql())
            ->orderBy('nama', 'asc')
            ->paginate($perPage);

        $mediaList = Media::orderBy('nama_media', 'asc')->get();

        return view('admin.members.inactive', compact('members', 'mediaList'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama' => 'required|string|max:255',
            'nomor_kartu' => 'nullable|string|max:100',
            'nomor_kartu_ukw' => 'nullable|string|max:150',
            'tingkat_ukw' => 'required|in:Belum UKW,Wartawan Muda,Wartawan Madya,Wartawan Utama',
            'masa_berlaku' => 'nullable|date',
            'jabatan' => 'required|string|max:100',
            'media_id' => 'nullable|exists:media,id',
            'nama_media_custom' => 'nullable|string|max:255',
            'no_hp' => 'nullable|string|max:50',
            'email' => 'nullable|email|max:255',
            'alamat' => 'nullable|string',
            'status' => 'required|in:aktif,tidak_aktif',
            'foto' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:3072',
        ]);

        // Handle Media selection or custom media input
        if ($request->filled('media_id')) {
            $med = Media::find($request->media_id);
            if ($med) {
                if ($request->filled('nama_media_custom') && strcasecmp(trim($request->nama_media_custom), $med->nama_media) !== 0) {
                    $mediaName = trim($request->nama_media_custom);
                    $matchedMedia = Media::whereRaw('LOWER(nama_media) = ?', [strtolower($mediaName)])->first();
                    if ($matchedMedia) {
                        $validated['media_id'] = $matchedMedia->id;
                        $validated['nama_media_custom'] = $matchedMedia->nama_media;
                    } else {
                        $newMedia = Media::create([
                            'nama_media' => $mediaName,
                            'website' => str_starts_with($mediaName, 'http') ? $mediaName : (str_contains($mediaName, '.') ? 'https://'.ltrim($mediaName, 'https://') : null),
                        ]);
                        $validated['media_id'] = $newMedia->id;
                        $validated['nama_media_custom'] = $mediaName;
                    }
                } else {
                    $validated['media_id'] = $med->id;
                    $validated['nama_media_custom'] = $med->nama_media;
                }
            }
        } elseif ($request->filled('nama_media_custom')) {
            $mediaName = trim($request->nama_media_custom);
            $matchedMedia = Media::whereRaw('LOWER(nama_media) = ?', [strtolower($mediaName)])->first();
            if ($matchedMedia) {
                $validated['media_id'] = $matchedMedia->id;
                $validated['nama_media_custom'] = $matchedMedia->nama_media;
            } else {
                $newMedia = Media::create([
                    'nama_media' => $mediaName,
                    'website' => str_starts_with($mediaName, 'http') ? $mediaName : (str_contains($mediaName, '.') ? 'https://'.ltrim($mediaName, 'https://') : null),
                ]);
                $validated['media_id'] = $newMedia->id;
                $validated['nama_media_custom'] = $mediaName;
            }
        }

        if ($request->hasFile('foto')) {
            $path = ImageService::uploadAndConvertToWebp($request->file('foto'), 'members');
            $validated['foto'] = $path;
        }

        Member::create($validated);

        return redirect()->back()->with('success', 'Data wartawan berhasil ditambahkan.');
    }

    public function update(Request $request, $id)
    {
        $member = Member::findOrFail($id);

        $validated = $request->validate([
            'nama' => 'required|string|max:255',
            'nomor_kartu' => 'nullable|string|max:100',
            'nomor_kartu_ukw' => 'nullable|string|max:150',
            'tingkat_ukw' => 'required|in:Belum UKW,Wartawan Muda,Wartawan Madya,Wartawan Utama',
            'masa_berlaku' => 'nullable|date',
            'jabatan' => 'required|string|max:100',
            'media_id' => 'nullable|exists:media,id',
            'nama_media_custom' => 'nullable|string|max:255',
            'no_hp' => 'nullable|string|max:50',
            'email' => 'nullable|email|max:255',
            'alamat' => 'nullable|string',
            'status' => 'required|in:aktif,tidak_aktif',
            'foto' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:3072',
        ]);

        // Handle Media selection or custom media input
        if ($request->filled('media_id')) {
            $med = Media::find($request->media_id);
            if ($med) {
                // If custom text was also typed and differs from selected media, check if it's a new or different media
                if ($request->filled('nama_media_custom') && strcasecmp(trim($request->nama_media_custom), $med->nama_media) !== 0) {
                    $mediaName = trim($request->nama_media_custom);
                    $matchedMedia = Media::whereRaw('LOWER(nama_media) = ?', [strtolower($mediaName)])->first();
                    if ($matchedMedia) {
                        $validated['media_id'] = $matchedMedia->id;
                        $validated['nama_media_custom'] = $matchedMedia->nama_media;
                    } else {
                        $newMedia = Media::create([
                            'nama_media' => $mediaName,
                            'website' => str_starts_with($mediaName, 'http') ? $mediaName : (str_contains($mediaName, '.') ? 'https://'.ltrim($mediaName, 'https://') : null),
                        ]);
                        $validated['media_id'] = $newMedia->id;
                        $validated['nama_media_custom'] = $mediaName;
                    }
                } else {
                    $validated['media_id'] = $med->id;
                    $validated['nama_media_custom'] = $med->nama_media;
                }
            }
        } elseif ($request->filled('nama_media_custom')) {
            $mediaName = trim($request->nama_media_custom);
            $matchedMedia = Media::whereRaw('LOWER(nama_media) = ?', [strtolower($mediaName)])->first();
            if ($matchedMedia) {
                $validated['media_id'] = $matchedMedia->id;
                $validated['nama_media_custom'] = $matchedMedia->nama_media;
            } else {
                $newMedia = Media::create([
                    'nama_media' => $mediaName,
                    'website' => str_starts_with($mediaName, 'http') ? $mediaName : (str_contains($mediaName, '.') ? 'https://'.ltrim($mediaName, 'https://') : null),
                ]);
                $validated['media_id'] = $newMedia->id;
                $validated['nama_media_custom'] = $mediaName;
            }
        } else {
            $validated['media_id'] = null;
            $validated['nama_media_custom'] = null;
        }

        if ($request->hasFile('foto')) {
            if ($member->foto && Storage::disk('public')->exists($member->foto)) {
                Storage::disk('public')->delete($member->foto);
            }
            $path = ImageService::uploadAndConvertToWebp($request->file('foto'), 'members');
            $validated['foto'] = $path;
        }

        $member->update($validated);

        return redirect()->back()->with('success', 'Data wartawan & media berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $member = Member::findOrFail($id);
        if ($member->foto && Storage::disk('public')->exists($member->foto)) {
            Storage::disk('public')->delete($member->foto);
        }
        $member->delete();

        return redirect()->back()->with('success', 'Data wartawan berhasil dihapus.');
    }

    public function toggleStatus($id)
    {
        $member = Member::findOrFail($id);
        $member->status = $member->status === 'aktif' ? 'tidak_aktif' : 'aktif';
        $member->save();

        $msg = $member->status === 'aktif' ? 'Wartawan berhasil diaktifkan kembali.' : 'Wartawan berhasil dipindahkan ke daftar tidak aktif.';

        return redirect()->back()->with('success', $msg);
    }

    public function togglePublicDirectory(Request $request)
    {
        $current = Setting::where('key', 'show_public_members')->value('value') ?? '0';
        $newVal = ($current === '1' || $current === 'on') ? '0' : '1';

        Setting::updateOrCreate(
            ['key' => 'show_public_members'],
            ['value' => $newVal]
        );

        $msg = $newVal === '1'
            ? 'Direktori anggota publik berhasil DIAKTIFKAN (tampil di website).'
            : 'Direktori anggota publik berhasil DINONAKTIFKAN (disembunyikan dari website).';

        return redirect()->back()->with('success', $msg);
    }
}
