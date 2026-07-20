<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use App\Models\Announcement;
use Illuminate\Foundation\Testing\RefreshDatabase;

class AnnouncementControllerTest extends TestCase
{
    use RefreshDatabase;

    private User $user;

    protected function setUp(): void
    {
        parent::setUp();
        // Buat user dengan ID=1 (atau ID berapapun) agar relasi FK tidak gagal
        $this->user = User::factory()->create(['id' => 1]);
    }

    public function test_index_displays_published_announcements()
    {
        // Buat 1 published & 1 unpublished
        Announcement::factory()->create([
            'author_id' => $this->user->id,
            'is_published' => true,
            'published_at' => now(),
            'title' => 'Published Title',
        ]);

        Announcement::factory()->create([
            'author_id' => $this->user->id,
            'is_published' => false,
            'published_at' => null,
            'title' => 'Draft Title',
        ]);

        $response = $this->get(route('announcements.index'));

        $response->assertStatus(200);
        $response->assertViewHas('announcements');
        $response->assertSee('Published Title');
        $response->assertDontSee('Draft Title');
    }

    public function test_store_announcement_success()
    {
        $response = $this->post(route('announcements.store'), [
            'title' => 'Judul Pengumuman Baru',
            'content' => 'Ini isi konten pengumuman baru untuk tes.',
            'audience' => 'mahasiswa',
        ]);

        $response->assertRedirect(route('announcements.index'));
        $response->assertSessionHas('success');

        $this->assertDatabaseHas('announcements', [
            'title' => 'Judul Pengumuman Baru',
            'audience' => 'mahasiswa',
            'author_id' => 1,
            'is_published' => 1,
        ]);
    }

    public function test_store_announcement_validation_fails()
    {
        $response = $this->post(route('announcements.store'), [
            'title' => '',
            'content' => '',
            'audience' => 'invalid-audience',
        ]);

        $response->assertSessionHasErrors(['title', 'content', 'audience']);
    }

    public function test_update_announcement_success()
    {
        $announcement = Announcement::factory()->create([
            'author_id' => $this->user->id,
            'title' => 'Judul Lama',
            'content' => 'Konten lama',
            'audience' => 'all',
        ]);

        $response = $this->put(route('announcements.update', $announcement->id), [
            'title' => 'Judul Baru Diupdate',
            'content' => 'Konten baru yang sudah diupdate.',
            'audience' => 'dosen',
        ]);

        $response->assertRedirect(route('announcements.index'));
        $response->assertSessionHas('success');

        $this->assertDatabaseHas('announcements', [
            'id' => $announcement->id,
            'title' => 'Judul Baru Diupdate',
            'content' => 'Konten baru yang sudah diupdate.',
            'audience' => 'dosen',
        ]);
    }

    public function test_update_announcement_validation_fails()
    {
        $announcement = Announcement::factory()->create([
            'author_id' => $this->user->id,
        ]);

        $response = $this->put(route('announcements.update', $announcement->id), [
            'title' => '',
            'content' => '',
            'audience' => 'invalid-audience',
        ]);

        $response->assertSessionHasErrors(['title', 'content', 'audience']);
    }

    public function test_show_announcement_displays_correct_data()
    {
        $announcement = Announcement::factory()->create([
            'author_id' => $this->user->id,
            'title' => 'Judul Detail Spesifik',
            'content' => 'Isi detail pengumuman yang lengkap dan panjang untuk pengetesan.',
            'audience' => 'mahasiswa',
        ]);

        $response = $this->get(route('announcements.show', $announcement->id));

        $response->assertStatus(200);
        $response->assertSee('Judul Detail Spesifik');
        $response->assertSee('Isi detail pengumuman yang lengkap');
    }

    public function test_destroy_announcement_success()
    {
        $announcement = Announcement::factory()->create([
            'author_id' => $this->user->id,
        ]);

        $response = $this->delete(route('announcements.destroy', $announcement->id));

        $response->assertRedirect(route('announcements.index'));
        $response->assertSessionHas('success');

        $this->assertDatabaseMissing('announcements', [
            'id' => $announcement->id,
        ]);
    }
}
