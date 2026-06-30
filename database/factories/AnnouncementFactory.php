<?php

namespace Database\Factories;

use App\Models\Announcement;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Announcement>
 */
class AnnouncementFactory extends Factory
{
    protected $model = Announcement::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'title' => $this->faker->sentence(6, true),
            'content' => $this->faker->paragraph(5, true),
            'author_id' => User::factory(),
            'audience' => $this->faker->randomElement(['all', 'admin', 'dosen', 'mahasiswa']),
            'is_published' => true,
            'published_at' => now(),
        ];
    }
}
