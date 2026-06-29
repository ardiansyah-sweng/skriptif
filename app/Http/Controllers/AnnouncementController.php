<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Announcement;

class AnnouncementController extends Controller
{
    public function index()
    {
        $announcements = Announcement::published()
            ->orderBy('published_at', 'desc')
            ->paginate(10);

        return view('announcements.index', compact('announcements'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'title'    => 'required|string|max:255',
            'content'  => 'required|string',
            'audience' => 'required|in:all,admin,dosen,mahasiswa',
        ]);

        Announcement::create([
            'title'        => $request->title,
            'content'      => $request->content,
            'audience'     => $request->audience,
            'author_id'    => 1,
            'is_published' => true,
            'published_at' => now(),
        ]);

        return redirect()->route('announcements.index')
            ->with('success', 'Pengumuman berhasil ditambahkan.');
    }

    public function destroy($id)
    {
        $announcement = Announcement::findOrFail($id);
        $announcement->delete();

        return redirect()->route('announcements.index')
            ->with('success', 'Pengumuman berhasil dihapus.');
    }
}
