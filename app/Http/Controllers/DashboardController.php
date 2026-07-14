<?php

namespace App\Http\Controllers;

use App\Models\Student;
use App\Models\Skripsi;
use App\Providers\SkripsiService;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    protected $skripsiService;
    // Inject SkripsiService ke Controller
    public function __construct(SkripsiService $skripsiService)
    {
        $this->skripsiService = $skripsiService;
    }

    public function index()
    {
        $student = Student::first();
        $skripsi = Skripsi::first();
        
        // Panggil racikan statistik kuota dosen dari Service
        $quotaStats = $this->skripsiService->getLecturerQuotaStats();

        return view('dashboard.index', compact('student', 'skripsi', 'quotaStats'));
    }
}