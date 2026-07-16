<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Announcement;
use App\Models\User;

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

        // Pastikan user dengan ID=1 ada untuk menghindari error foreign key
        $user = User::find(1);
        if (!$user) {
            $user = User::factory()->create([
                'id' => 1,
                'name' => 'Admin Default',
                'email' => 'admin@example.com',
            ]);
        }

        Announcement::create([
            'title'        => $request->title,
            'content'      => $request->content,
            'audience'     => $request->audience,
            'author_id'    => $user->id,
            'is_published' => true,
            'published_at' => now(),
        ]);

        return redirect()->route('announcements.index')
            ->with('success', 'Pengumuman berhasil ditambahkan.');
    }

    public function show($id)
    {
        $announcement = Announcement::findOrFail($id);
        return view('announcements.show', compact('announcement'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'title'    => 'required|string|max:255',
            'content'  => 'required|string',
            'audience' => 'required|in:all,admin,dosen,mahasiswa',
        ]);

        $announcement = Announcement::findOrFail($id);
        $announcement->update([
            'title'    => $request->title,
            'content'  => $request->content,
            'audience' => $request->audience,
        ]);

        return redirect()->route('announcements.index')
            ->with('success', 'Pengumuman berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $announcement = Announcement::findOrFail($id);
        $announcement->delete();

        return redirect()->route('announcements.index')
            ->with('success', 'Pengumuman berhasil dihapus.');
    }
}
