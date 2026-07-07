<?php
namespace App\Providers;
use App\Models\LogBook;
class LogBookService
{
    /**
     * Get all log books with optional search and status filter.
     */
    public function getAllLogBooks($search = null, $status = null, $studentId = null)
    {
        $query = LogBook::with(['student', 'lecturer']);
        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->whereHas('student', function ($sq) use ($search) {
                    $sq->where('name', 'like', '%' . $search . '%')
                       ->orWhere('student_id', 'like', '%' . $search . '%');
                })->orWhereHas('lecturer', function ($lq) use ($search) {
                    $lq->where('name', 'like', '%' . $search . '%');
                })->orWhere('activity', 'like', '%' . $search . '%');
            });
        }
        if ($status && in_array($status, ['pending', 'approved', 'rejected'])) {
            $query->where('status', $status);
        }
        // Filter log book berdasarkan student_id (mahasiswa tertentu)
        if ($studentId) {
            $query->where('student_id', $studentId);
            // Urutkan dari tanggal bimbingan terlama ke terbaru (kronologis) agar urut bimbingan 1, 2, dst.
            return $query->orderBy('date', 'asc')->get();
        }
        // Urutkan dari bimbingan terbaru untuk daftar umum
        return $query->orderBy('date', 'desc')->get();
    }
    /**
     * Get log book by id.
     */
    public function getLogBookById($id)
    {
        return LogBook::with(['student', 'lecturer'])->findOrFail($id);
    }
    /**
     * Store new log book.
     */
    public function storeLogBook(array $data)
    {
        return LogBook::create([
            'student_id'  => $data['student_id'],
            'lecturer_id' => $data['lecturer_id'],
            'date'        => $data['date'],
            'activity'    => $data['activity'],
            'feedback'    => $data['feedback'] ?? null,
            'status'      => $data['status'] ?? 'pending',
            // Simpan nama file lampiran gambar ke kolom database
            'attachment'  => $data['attachment'] ?? null,
        ]);
    }
    /**
     * Update existing log book.
     */
    public function updateLogBook($id, array $data)
    {
        $logBook = LogBook::findOrFail($id);
        $updateData = [
            'student_id'  => $data['student_id'],
            'lecturer_id' => $data['lecturer_id'],
            'date'        => $data['date'],
            'activity'    => $data['activity'],
            'feedback'    => $data['feedback'] ?? null,
            'status'      => $data['status'] ?? 'pending',
        ];

        // Perbarui lampiran jika data attachment dikirim (ada file baru yang diunggah)
        if (array_key_exists('attachment', $data)) {
            $updateData['attachment'] = $data['attachment'];
        }

        $logBook->update($updateData);
        return $logBook;
    }
    /**
     * Delete log book.
     */
    public function deleteLogBook($id)
    {
        $logBook = LogBook::findOrFail($id);
        // Hapus berkas gambar secara permanen dari folder storage jika log book dihapus
        if ($logBook->attachment) {
            \Illuminate\Support\Facades\Storage::disk('public')->delete($logBook->attachment);
        }
        return $logBook->delete();
    }
}
