# Pull Request: Implementasi Fitur Log Book Bimbingan Mahasiswa

## Deskripsi / Description
PR ini mengimplementasikan fitur **Log Book Bimbingan**, yang mendokumentasikan sesi konsultasi/bimbingan antara mahasiswa dan dosen pembimbing. Fitur ini dilengkapi dengan operasi CRUD (Create, Read, Update, Delete) penuh serta sistem verifikasi status bimbingan oleh dosen/admin.

*This PR implements the **Guidance Log Book** feature, documenting consultation sessions between students and supervisors. It features full CRUD operations and a status verification system.*

---

## Perubahan yang Dilakukan / Changes Made

### 1. Database & Seeder
* **Migration:** Membuat tabel `log_books` ([2026_06_23_030000_create_log_books_table.php](file:///c:/Users/acer/Documents/Ajjaa/kuliah/Semester%206/skriptif/database/migrations/2026_06_23_030000_create_log_books_table.php)) dengan relasi foreign key ke `students` dan `lecturers`.
* **Eloquent Model:** Membuat model `LogBook.php` ([LogBook.php](file:///c:/Users/acer/Documents/Ajjaa/kuliah/Semester%206/skriptif/app/Models/LogBook.php)) dengan relasi dan type casting tanggal.
* **Seeder:**
  * Membuat `LogBookSeeder.php` ([LogBookSeeder.php](file:///c:/Users/acer/Documents/Ajjaa/kuliah/Semester%206/skriptif/database/seeders/LogBookSeeder.php)) berisi contoh data bimbingan awal.
  * Mendaftarkan seeder baru di `DatabaseSeeder.php` ([DatabaseSeeder.php](file:///c:/Users/acer/Documents/Ajjaa/kuliah/Semester%206/skriptif/database/seeders/DatabaseSeeder.php)).

### 2. Logika Bisnis & HTTP Layer
* **Service:** Membuat `LogBookService.php` ([LogBookService.php](file:///c:/Users/acer/Documents/Ajjaa/kuliah/Semester%206/skriptif/app/Providers/LogBookService.php)) untuk memisahkan logika query, pencarian NIM/Nama, dan filter status.
* **Controller:** Membuat `LogBookController.php` ([LogBookController.php](file:///c:/Users/acer/Documents/Ajjaa/kuliah/Semester%206/skriptif/app/Http/Controllers/LogBookController.php)) untuk validasi form dan memetakan aksi CRUD.
* **Routes:** Mendaftarkan resource route `/log-books` di `web.php` ([web.php](file:///c:/Users/acer/Documents/Ajjaa/kuliah/Semester%206/skriptif/routes/web.php)).

### 3. Tampilan Antarmuka (Blade Views)
* **Index (`index.blade.php`):** Halaman daftar catatan bimbingan dengan pencarian kata kunci, penyaringan status bimbingan (Pending, Approved, Rejected), badge warna, dan catatan feedback dosen.
* **Tambah & Edit (`create.blade.php`, `edit.blade.php`):** Formulir modern untuk menginput data bimbingan baru atau melakukan verifikasi status/mengisi feedback bimbingan.
* **Welcome page:** Mengintegrasikan tombol navigasi Log Book bimbingan di halaman beranda ([welcome.blade.php](file:///c:/Users/acer/Documents/Ajjaa/kuliah/Semester%206/skriptif/resources/views/welcome.blade.php)).

### 4. Pengujian / Testing
* **Feature Test:** Membuat berkas [LogBookControllerTest.php](file:///c:/Users/acer/Documents/Ajjaa/kuliah/Semester%206/skriptif/tests/Feature/LogBookControllerTest.php) untuk memvalidasi alur simpan, edit, dan hapus log book secara otomatis (100% Passed).

---

## Cara Menguji / How to Test

1. Jalankan migrasi dan seeder database:
   ```bash
   php artisan migrate:fresh --seed
   ```
2. Jalankan perintah test untuk memverifikasi fitur secara otomatis:
   ```bash
   php artisan test --filter=LogBookControllerTest
   ```
3. Akses antarmuka web di `/log-books` untuk menguji alur penambahan bimbingan, pencarian/filter, pengisian feedback, dan penghapusan catatan.
