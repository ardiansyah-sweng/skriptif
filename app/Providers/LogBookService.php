<?php
namespace App\Providers;
use App\Models\LogBook;
class LogBookService
{
    /**
     * Get all log books with optional search and status filter.
     */
    public function getAllLogBooks($search = null, $status = null)
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
        ]);
    }
    /**
     * Update existing log book.
     */
    public function updateLogBook($id, array $data)
    {
        $logBook = LogBook::findOrFail($id);
        $logBook->update([
            'student_id'  => $data['student_id'],
            'lecturer_id' => $data['lecturer_id'],
            'date'        => $data['date'],
            'activity'    => $data['activity'],
            'feedback'    => $data['feedback'] ?? null,
            'status'      => $data['status'] ?? 'pending',
        ]);
        return $logBook;
    }
    /**
     * Delete log book.
     */
    public function deleteLogBook($id)
    {
        $logBook = LogBook::findOrFail($id);
        return $logBook->delete();
    }
}
