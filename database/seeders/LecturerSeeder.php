<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Carbon;

class LecturerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $lecturers = [
            [
                'lecturer_id' => 'LCT001',
                'name'        => 'Prof. Drs. Ir. Abdul Fadlil, M.T., Ph.D.',
                'email'       => 'fadlil@mti.uad.ac.id',
                'expertise'   => 'Elektronika & Instrumentasi, Pattern Recognition & Soft Computing',
            ],
            [
                'lecturer_id' => 'LCT002',
                'name'        => 'Adhi Prahara, S.Si., M.Cs.',
                'email'       => 'adhi.prahara@tif.uad.ac.id',
                'expertise'   => 'Sistem Cerdas dan Computer Vision',
            ],
            [
                'lecturer_id' => 'LCT003',
                'name'        => 'Ir. Ahmad Azhari, S.Kom., M.Eng.',
                'email'       => 'ahmad.azhari@tif.uad.ac.id',
                'expertise'   => 'Pattern Recognition & Machine Learning',
            ],
            [
                'lecturer_id' => 'LCT004',
                'name'        => 'Ali Tarmuji, S.T., M.Cs.',
                'email'       => 'alitarmuji@tif.uad.ac.id',
                'expertise'   => 'Software Engineering, Web Engineering',
            ],
            [
                'lecturer_id' => 'LCT005',
                'name'        => 'Andri Pranolo, S.Kom., M.Cs., Ph.D.',
                'email'       => 'andri.pranolo@tif.uad.ac.id',
                'expertise'   => 'Sistem Cerdas / Soft Computing',
            ],
            [
                'lecturer_id' => 'LCT006',
                'name'        => 'Anna Hendri Soleliza Jones, S.Kom., M.Cs.',
                'email'       => 'annahendri@tif.uad.ac.id',
                'expertise'   => 'Sistem Cerdas',
            ],
            [
                'lecturer_id' => 'LCT007',
                'name'        => 'Prof. Ir. Anton Yudhana, S.T., M.T., Ph.D.',
                'email'       => 'eyudhana@mti.uad.ac.id',
                'expertise'   => 'Komunikasi-Multimedia, Pengolahan Isyarat, Wireless Communication',
            ],
            [
                'lecturer_id' => 'LCT008',
                'name'        => 'Dr. Ardiansyah, S.T., M.Cs.',
                'email'       => 'ardiansyah@tif.uad.ac.id',
                'expertise'   => 'Software Engineering',
            ],
            [
                'lecturer_id' => 'LCT009',
                'name'        => 'Dr. Ir. Ardi Pujiyanta, M.T.',
                'email'       => 'ardipujiyanta@tif.uad.ac.id',
                'expertise'   => 'Sistem Cerdas, Pemrograman Komputasi, Grid dan Cloud Computing',
            ],
            [
                'lecturer_id' => 'LCT010',
                'name'        => 'Arfiani Nur Khusna, S.T., M.Kom.',
                'email'       => 'arfiani.khusna@tif.uad.ac.id',
                'expertise'   => 'Sistem Informasi',
            ],
            [
                'lecturer_id' => 'LCT011',
                'name'        => 'Bambang Robi\'in, S.T., M.T.',
                'email'       => 'bambang.robiin@tif.uad.ac.id',
                'expertise'   => 'Multimedia, Mobile Computing',
            ],
            [
                'lecturer_id' => 'LCT012',
                'name'        => 'Dr. Dewi Pramudi Ismi, S.T., M.CompSc.',
                'email'       => 'dewi.ismi@tif.uad.ac.id',
                'expertise'   => 'Machine Learning',
            ],
            [
                'lecturer_id' => 'LCT013',
                'name'        => 'Dewi Soyusiawaty, S.T., M.T.',
                'email'       => 'dewi.soyusiawati@tif.uad.ac.id',
                'expertise'   => 'Softcomputing dan Multimedia, Bahasa Alami',
            ],
            [
                'lecturer_id' => 'LCT014',
                'name'        => 'Ir. Dinan Yulianto, S.T., M.Eng.',
                'email'       => 'dinan.yulianto@tif.uad.ac.id',
                'expertise'   => 'Multimedia, Interaksi Manusia dan Komputer, IT in Education',
            ],
            [
                'lecturer_id' => 'LCT015',
                'name'        => 'Dwi Normawati, S.T., M.Eng.',
                'email'       => 'dwi.normawati@tif.uad.ac.id',
                'expertise'   => 'Data Mining',
            ],
            [
                'lecturer_id' => 'LCT016',
                'name'        => 'Eko Aribowo, S.T., M.Kom.',
                'email'       => 'ekoab@tif.uad.ac.id',
                'expertise'   => 'Kriptografi, Keamanan Komputer',
            ],
            [
                'lecturer_id' => 'LCT017',
                'name'        => 'Faisal Fajri Rahani, S.Si., M.Cs.',
                'email'       => 'faisal.fajri@tif.uad.ac.id',
                'expertise'   => 'Sistem Cerdas, Sistem Kendali, Pengolahan Citra',
            ],
            [
                'lecturer_id' => 'LCT018',
                'name'        => 'Fiftin Noviyanto, S.T., M.Cs.',
                'email'       => 'fiftin.noviyanto@tif.uad.ac.id',
                'expertise'   => 'Web Programming, Multimedia',
            ],
            [
                'lecturer_id' => 'LCT019',
                'name'        => 'Guntur Maulana Zamroni, B.Sc., M.Kom.',
                'email'       => 'guntur.zamroni@tif.uad.ac.id',
                'expertise'   => 'Software Engineering, UI/UX',
            ],
            [
                'lecturer_id' => 'LCT020',
                'name'        => 'Herman, S.Kom., M.Sc., Ph.D.',
                'email'       => 'hermankaha@mti.uad.ac.id',
                'expertise'   => 'Mobile and Multimedia Technologies',
            ],
            [
                'lecturer_id' => 'LCT021',
                'name'        => 'Ir. Herman Yuliansyah, S.T., M.Eng., Ph.D.',
                'email'       => 'herman.yuliansyah@tif.uad.ac.id',
                'expertise'   => 'Social Computing dan Data Mining',
            ],
            [
                'lecturer_id' => 'LCT022',
                'name'        => 'Ir. Ika Arfiani, S.T., M.Cs.',
                'email'       => 'ika.arfiani@tif.uad.ac.id',
                'expertise'   => 'Rekayasa Perangkat Lunak dan Data',
            ],
            [
                'lecturer_id' => 'LCT023',
                'name'        => 'Prof. Dr. Ir. Imam Riadi, M.Kom.',
                'email'       => 'imam.riadi@mti.uad.ac.id',
                'expertise'   => 'Keamanan Informasi, Forensik Digital, Forensik Jaringan dan Cloud',
            ],
            [
                'lecturer_id' => 'LCT024',
                'name'        => 'Jihad Rahmawan, S.T., M.Sc.',
                'email'       => 'jihad@tif.uad.ac.id',
                'expertise'   => 'Robotika, Image Processing, Artificial Intelligence',
            ],
            [
                'lecturer_id' => 'LCT025',
                'name'        => 'Jefree Fahana, S.T., M.Kom.',
                'email'       => 'jefree.fahana@tif.uad.ac.id',
                'expertise'   => 'Sistem Informasi',
            ],
            [
                'lecturer_id' => 'LCT026',
                'name'        => 'Lisna Zahrotun, S.T., M.Cs.',
                'email'       => 'lisna.zahrotun@tif.uad.ac.id',
                'expertise'   => 'Data Mining, Text Mining, Sistem Pendukung Keputusan',
            ],
            [
                'lecturer_id' => 'LCT027',
                'name'        => 'Miftahurrahma Rosyda, S.Kom., M.Eng.',
                'email'       => 'miftahurrahma.rosyda@tif.uad.ac.id',
                'expertise'   => 'Sistem Cerdas, Bioinformatika, Big Data',
            ],
            [
                'lecturer_id' => 'LCT028',
                'name'        => 'Muhammad Aziz, S.T., M.Cs., Ph.D.',
                'email'       => 'moch.aziz@tif.uad.ac.id',
                'expertise'   => 'Computer Architecture, Geographic Information System, GeoInformatics Technology',
            ],
            [
                'lecturer_id' => 'LCT029',
                'name'        => 'Dr. Eng. Ir. Muhammad Kunta Biddinika, S.T., M.Eng.',
                'email'       => 'muhammad.kunta@mti.uad.ac.id',
                'expertise'   => 'Environmental Sciences Technology, Sustainability Development Education',
            ],
            [
                'lecturer_id' => 'LCT030',
                'name'        => 'Murein Miksa Mardhia, S.T., M.T.',
                'email'       => 'murein.miksa@tif.uad.ac.id',
                'expertise'   => 'Rekayasa Perangkat Lunak dan Data',
            ],
            [
                'lecturer_id' => 'LCT031',
                'name'        => 'Dr. Murinto, S.Si., M.Kom.',
                'email'       => 'murintokusno@tif.uad.ac.id',
                'expertise'   => 'Grafika Komputer, Pengolahan Citra, Computer Vision, Sistem Cerdas',
            ],
            [
                'lecturer_id' => 'LCT032',
                'name'        => 'Mushlihudin, S.T., M.T.',
                'email'       => 'mushlihudin@tif.uad.ac.id',
                'expertise'   => 'Security, Web Programming, Basis Data, Computer Networking',
            ],
            [
                'lecturer_id' => 'LCT033',
                'name'        => 'Ninda Khoirunnisa, S.T., M.Sc.',
                'email'       => 'ninda@tif.uad.ac.id',
                'expertise'   => 'Data Science, NLP',
            ],
            [
                'lecturer_id' => 'LCT034',
                'name'        => 'Ir. Nuril Anwar, S.T., M.Kom.',
                'email'       => 'nuril.anwar@tif.uad.ac.id',
                'expertise'   => 'Computer Network & Security, Digital Forensics',
            ],
            [
                'lecturer_id' => 'LCT035',
                'name'        => 'Ir. Nur Rochmah Dyah Puji Astuti, S.T., M.Kom.',
                'email'       => 'rochmahdyah@tif.uad.ac.id',
                'expertise'   => 'Security Computer, Kriptografi',
            ],
            [
                'lecturer_id' => 'LCT036',
                'name'        => 'Rusydi Umar, S.T., M.T., Ph.D.',
                'email'       => 'rusydi.umar@tif.uad.ac.id',
                'expertise'   => 'Grid Computing, Cloud Computing, Software Engineering',
            ],
            [
                'lecturer_id' => 'LCT037',
                'name'        => 'Sheraton Pawestri, S.Kom., M.Cs.',
                'email'       => 'sheraton@tif.uad.ac.id',
                'expertise'   => 'NLP',
            ],
            [
                'lecturer_id' => 'LCT038',
                'name'        => 'Ir. Sri Winiarti, S.T., M.Cs.',
                'email'       => 'sri.winiarti@tif.uad.ac.id',
                'expertise'   => 'Sistem Cerdas',
            ],
            [
                'lecturer_id' => 'LCT039',
                'name'        => 'Prof. Ir. Sunardi, S.T., M.T., Ph.D.',
                'email'       => 'sunardi@mti.uad.ac.id',
                'expertise'   => 'Teknik Elektro/Telekomunikasi, Sistem Informasi Komunikasi, Wireless Communication',
            ],
            [
                'lecturer_id' => 'LCT040',
                'name'        => 'Supriyanto, S.T., M.T.',
                'email'       => 'supriyanto@tif.uad.ac.id',
                'expertise'   => 'Interaction Design, Gamification, Web & Mobile Technology, Game Technology',
            ],
            [
                'lecturer_id' => 'LCT041',
                'name'        => 'Taufiq Ismail, S.T., M.Cs.',
                'email'       => 'taufiq@tif.uad.ac.id',
                'expertise'   => 'Komunikasi Data, Jaringan Komputer, Grafika & Multimedia, Mobile Computing',
            ],
            [
                'lecturer_id' => 'LCT042',
                'name'        => 'Drs. Tedy Setiadi, M.T.',
                'email'       => 'tedy.setiadi@tif.uad.ac.id',
                'expertise'   => 'Sistem Informasi, Basis Data, Teknik Kompilasi, Data Mining',
            ],
            [
                'lecturer_id' => 'LCT043',
                'name'        => 'Drs. Wahyu Pujiyono, M.Kom.',
                'email'       => 'yywahyup@tif.uad.ac.id',
                'expertise'   => 'Multimedia, Mobile, Enterprise System',
            ],
        ];

        foreach ($lecturers as $lecturer) {
            DB::table('lecturers')->insert([
                'lecturer_id' => $lecturer['lecturer_id'],
                'name'        => $lecturer['name'],
                'email'       => $lecturer['email'],
                'expertise'   => $lecturer['expertise'],
                'created_at'  => Carbon::now(),
                'updated_at'  => Carbon::now(),
            ]);
        }
    }
}