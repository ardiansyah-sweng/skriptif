# Todo List

## ✅ Selesai

- [x] Tambah method `index()` di StudentSkripsiController → redirect ke history
- [x] Fix SkripsiController::create() → redirect ke form mahasiswa
- [x] Tambah 3 menu sidebar: Ajukan Skripsi, Riwayat Pengajuan, Skripsiku
- [x] Hapus duplikasi route `/students-print`
- [x] Tambah flash messages di StudentController (store, update, destroy)
- [x] Tambah flash messages di LecturerController (store, update, destroy)
- [x] Tambah flash messages di ElectiveCourseController (store, update, destroy)
- [x] Fix sidebar scroll → simpan/restore posisi pakai sessionStorage

## 🔜 Rencana Selanjutnya (Opsional)

- [ ] Implementasi auth & role (admin/dosen/mahasiswa)
- [ ] Fix `Student::first()` hardcoded → pakai session/login
- [ ] Pagination di semua halaman index
- [ ] Search di Students, Lecturers
