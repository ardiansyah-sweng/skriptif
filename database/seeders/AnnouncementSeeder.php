<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Carbon;
use App\Models\User;

class AnnouncementSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Pastikan ada user dengan id=1 untuk foreign key author_id
        if (User::count() === 0) {
            User::factory()->create([
                'name'  => 'Admin',
                'email' => 'admin@example.com',
            ]);
        }
        $announcements = [
            [
                'title'        => 'Pengumuman Jadwal UAS Semester Genap 2025/2026',
                'content'      => 'Diberitahukan kepada seluruh mahasiswa bahwa jadwal Ujian Akhir Semester (UAS) Genap 2025/2026 telah dirilis. Silakan cek portal akademik untuk melihat jadwal lengkap.',
                'author_id'    => 1,
                'audience'     => 'mahasiswa',
                'is_published' => true,
                'published_at' => Carbon::now()->subDays(1),
                'created_at'   => Carbon::now()->subDays(1),
                'updated_at'   => Carbon::now()->subDays(1),
            ],
            [
                'title'        => 'Rapat Dosen Prodi Informatika',
                'content'      => 'Seluruh dosen Prodi Informatika diundang menghadiri rapat koordinasi yang akan dilaksanakan pada hari Senin, 7 Juli 2026 pukul 10.00 WIB di Ruang Rapat Lantai 3.',
                'author_id'    => 1,
                'audience'     => 'dosen',
                'is_published' => true,
                'published_at' => Carbon::now()->subDays(2),
                'created_at'   => Carbon::now()->subDays(2),
                'updated_at'   => Carbon::now()->subDays(2),
            ],
            [
                'title'        => 'Pemeliharaan Sistem Informasi Akademik',
                'content'      => 'Sistem Informasi Akademik akan mengalami pemeliharaan rutin pada tanggal 10 Juli 2026 pukul 22.00 - 06.00 WIB. Selama periode tersebut, akses ke sistem akan terganggu.',
                'author_id'    => 1,
                'audience'     => 'all',
                'is_published' => true,
                'published_at' => Carbon::now()->subDays(3),
                'created_at'   => Carbon::now()->subDays(3),
                'updated_at'   => Carbon::now()->subDays(3),
            ],
            [
                'title'        => 'Pendaftaran Wisuda Periode September 2026',
                'content'      => 'Pendaftaran wisuda periode September 2026 dibuka mulai 1 Juli hingga 31 Juli 2026. Mahasiswa yang telah memenuhi syarat kelulusan dapat mendaftar melalui portal akademik.',
                'author_id'    => 1,
                'audience'     => 'mahasiswa',
                'is_published' => true,
                'published_at' => Carbon::now()->subDays(5),
                'created_at'   => Carbon::now()->subDays(5),
                'updated_at'   => Carbon::now()->subDays(5),
            ],
            [
                'title'        => 'Workshop Penulisan Jurnal Ilmiah',
                'content'      => 'Program Studi Informatika menyelenggarakan workshop penulisan jurnal ilmiah internasional. Kegiatan ini terbuka untuk seluruh dosen dan mahasiswa tingkat akhir.',
                'author_id'    => 1,
                'audience'     => 'all',
                'is_published' => true,
                'published_at' => Carbon::now()->subDays(7),
                'created_at'   => Carbon::now()->subDays(7),
                'updated_at'   => Carbon::now()->subDays(7),
            ],
        ];

        foreach ($announcements as $announcement) {
            DB::table('announcements')->insert($announcement);
        }
    }
}