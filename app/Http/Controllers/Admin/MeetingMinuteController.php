<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\MeetingAttendance;
use App\Models\MeetingMinute;
use App\Models\Member;
use App\Models\Setting;
use Illuminate\Http\Request;

class MeetingMinuteController extends Controller
{
    public function index(Request $request)
    {
        $query = MeetingMinute::withCount('attendances');

        if ($request->filled('search')) {
            $s = $request->search;
            $query->where(function ($q) use ($s) {
                $q->where('judul_rapat', 'like', "%{$s}%")
                    ->orWhere('tempat', 'like', "%{$s}%")
                    ->orWhere('pemimpin_rapat', 'like', "%{$s}%")
                    ->orWhere('agenda', 'like', "%{$s}%");
            });
        }

        $entries = (int) $request->get('entries', 10);
        $meetings = $query->latest('tanggal')->paginate($entries);

        return view('admin.meetings.index', compact('meetings'));
    }

    public function create()
    {
        $members = Member::where('status', 'aktif')->orderBy('nama')->get();

        return view('admin.meetings.create', compact('members'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'judul_rapat' => 'required|string|max:255',
            'tanggal' => 'required|date',
            'tempat' => 'required|string|max:255',
            'pemimpin_rapat' => 'required|string|max:255',
            'notulis' => 'required|string|max:255',
            'agenda' => 'required|string',
            'pembahasan' => 'required|string',
            'kesimpulan' => 'required|string',
            'file_lampiran' => 'nullable|file|mimes:pdf,doc,docx,jpg,jpeg,png|max:10240',
        ]);

        $data = $request->only([
            'judul_rapat', 'tanggal', 'waktu_mulai', 'waktu_selesai',
            'tempat', 'pemimpin_rapat', 'notulis', 'agenda',
            'pembahasan', 'kesimpulan',
        ]);

        if ($request->hasFile('file_lampiran')) {
            $data['file_lampiran'] = $request->file('file_lampiran')->store('meetings', 'public');
        }

        $meeting = MeetingMinute::create($data);

        // Record Attendances
        if ($request->has('attendances') && is_array($request->attendances)) {
            foreach ($request->attendances as $memberId => $attData) {
                MeetingAttendance::create([
                    'meeting_minute_id' => $meeting->id,
                    'member_id' => $memberId,
                    'status_kehadiran' => $attData['status'] ?? 'hadir',
                    'keterangan' => $attData['keterangan'] ?? null,
                ]);
            }
        }

        return redirect()->route('admin.meetings.index')->with('success', 'Notulen rapat dan absensi anggota berhasil dicatat.');
    }

    public function show($id)
    {
        $meeting = MeetingMinute::with(['attendances.member'])->findOrFail($id);

        return view('admin.meetings.show', compact('meeting'));
    }

    public function edit($id)
    {
        $meeting = MeetingMinute::with(['attendances'])->findOrFail($id);
        $members = Member::where('status', 'aktif')->orderBy('nama')->get();

        $attendancesMap = $meeting->attendances->keyBy('member_id');

        return view('admin.meetings.edit', compact('meeting', 'members', 'attendancesMap'));
    }

    public function update(Request $request, $id)
    {
        $meeting = MeetingMinute::findOrFail($id);

        $request->validate([
            'judul_rapat' => 'required|string|max:255',
            'tanggal' => 'required|date',
            'tempat' => 'required|string|max:255',
            'pemimpin_rapat' => 'required|string|max:255',
            'notulis' => 'required|string|max:255',
            'agenda' => 'required|string',
            'pembahasan' => 'required|string',
            'kesimpulan' => 'required|string',
            'file_lampiran' => 'nullable|file|mimes:pdf,doc,docx,jpg,jpeg,png|max:10240',
        ]);

        $data = $request->only([
            'judul_rapat', 'tanggal', 'waktu_mulai', 'waktu_selesai',
            'tempat', 'pemimpin_rapat', 'notulis', 'agenda',
            'pembahasan', 'kesimpulan',
        ]);

        if ($request->hasFile('file_lampiran')) {
            $data['file_lampiran'] = $request->file('file_lampiran')->store('meetings', 'public');
        }

        $meeting->update($data);

        // Sync Attendances
        if ($request->has('attendances') && is_array($request->attendances)) {
            foreach ($request->attendances as $memberId => $attData) {
                MeetingAttendance::updateOrCreate(
                    [
                        'meeting_minute_id' => $meeting->id,
                        'member_id' => $memberId,
                    ],
                    [
                        'status_kehadiran' => $attData['status'] ?? 'hadir',
                        'keterangan' => $attData['keterangan'] ?? null,
                    ]
                );
            }
        }

        return redirect()->route('admin.meetings.index')->with('success', 'Data notulen rapat berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $meeting = MeetingMinute::findOrFail($id);
        $meeting->delete();

        return redirect()->route('admin.meetings.index')->with('success', 'Notulen rapat berhasil dihapus.');
    }

    public function print($id)
    {
        $meeting = MeetingMinute::with(['attendances.member'])->findOrFail($id);
        $settings = Setting::pluck('value', 'key')->all();

        return view('admin.meetings.print', compact('meeting', 'settings'));
    }
}
