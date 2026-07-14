<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();
        $this->call([
            MasterDataSeeder::class,
            LecturerSeeder::class,
            StudentSeeder::class,
            ElectiveCourseSeeder::class,
            SkripsiSeeder::class,
            ExamScheduleSeeder::class,
        ]);

        // Akun admin default untuk login ke sistem
        User::firstOrCreate(
            ['email' => 'admin@skriptif.test'],
            [
                'name'              => 'Administrator',
                'password'          => Hash::make('admin123'),
                'email_verified_at' => now(),
            ]
        );

        User::factory()->create([
            'name' => 'Test User',
            'email' => 'test@example.com',
        ]);

        $this->call([
            AnnouncementSeeder::class,
        ]);
    }
    
}