<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Models\Announcement;

class AnnouncementModelTest extends TestCase
{
    public function test_it_has_correct_table_name()
    {
        $announcement = new Announcement();
        $this->assertEquals('announcements', $announcement->getTable());
    }

    public function test_it_has_fillable_attributes()
    {
        $announcement = new Announcement();
        $this->assertEquals([
            'title',
            'content',
            'author_id',
            'audience',
            'is_published',
            'published_at',
        ], $announcement->getFillable());
    }

    public function test_it_has_correct_casts()
    {
        $announcement = new Announcement();
        $casts = $announcement->getCasts();

        $this->assertArrayHasKey('is_published', $casts);
        $this->assertEquals('boolean', $casts['is_published']);

        $this->assertArrayHasKey('published_at', $casts);
        $this->assertEquals('datetime', $casts['published_at']);
    }
}
