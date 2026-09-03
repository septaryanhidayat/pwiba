<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Inbox;
use Illuminate\Http\Request;

class InboxController extends Controller
{
    public function index(Request $request)
    {
        $query = Inbox::query();

        if ($request->filled('search')) {
            $s = $request->search;
            $query->where(function ($q) use ($s) {
                $q->where('nama', 'like', "%{$s}%")
                    ->orWhere('tujuan', 'like', "%{$s}%")
                    ->orWhere('keperluan', 'like', "%{$s}%")
                    ->orWhere('email', 'like', "%{$s}%");
            });
        }

        $perPage = $request->get('entries', 10);
        $inboxes = $query->orderBy('tanggal', 'desc')->paginate($perPage);

        return view('admin.inbox.index', compact('inboxes'));
    }

    public function show($id)
    {
        $inbox = Inbox::findOrFail($id);
        if ($inbox->status === 'baru') {
            $inbox->status = 'dibaca';
            $inbox->save();
        }

        return response()->json($inbox);
    }

    public function destroy($id)
    {
        $inbox = Inbox::findOrFail($id);
        $inbox->delete();

        return redirect()->back()->with('success', 'Pesan inbox berhasil dihapus.');
    }
}
