<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Dashboard Skriptif — Sistem Manajemen Skripsi">
    <title>Dashboard - Skriptif</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@tabler/icons-webfont@latest/tabler-icons.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
</head>
<body class="bg-gray-100 font-[Inter]" style="font-family:'Inter',sans-serif">
    <div class="flex h-screen overflow-hidden">

        <!-- ============================================================ -->
        <!-- SIDEBAR -->
        <!-- ============================================================ -->
        <aside class="w-64 bg-white border-r border-gray-100 flex flex-col h-full overflow-y-auto px-4 py-5">
            <!-- Logo -->
            <div class="mb-6">
                <h1 class="font-bold text-lg text-blue-800">Skriptif</h1>
                <p class="text-xs text-gray-400 mt-0.5">Manajemen Skripsi</p>
            </div>

            <!-- Navigation -->
            <nav class="flex flex-col gap-1 mt-6 flex-1">
                <!-- Dashboard — AKTIF -->
                <a href="{{ route('dashboard') }}"
                   class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm font-semibold bg-blue-50 text-blue-700 cursor-pointer transition-colors">
                    <i class="ti ti-layout-dashboard text-lg"></i>
                    <span>Dashboard</span>
                </a>

                <!-- Dosen -->
                <a href="/lecturers"
                   class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm text-gray-600 hover:bg-gray-50 hover:text-gray-900 cursor-pointer transition-colors">
                    <i class="ti ti-users text-lg"></i>
                    <span>Dosen</span>
                </a>

                <!-- Mahasiswa -->
                <a href="#"
                   class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm text-gray-600 hover:bg-gray-50 hover:text-gray-900 cursor-pointer transition-colors">
                    <i class="ti ti-school text-lg"></i>
                    <span>Mahasiswa</span>
                </a>

                <!-- Mata Kuliah Pilihan -->
                <a href="{{ route('elective-courses.index') }}"
                   class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm text-gray-600 hover:bg-gray-50 hover:text-gray-900 cursor-pointer transition-colors">
                    <i class="ti ti-books text-lg"></i>
                    <span>Mata Kuliah Pilihan</span>
                </a>

                <!-- Skripsi -->
                <a href="#"
                   class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm text-gray-600 hover:bg-gray-50 hover:text-gray-900 cursor-pointer transition-colors">
                    <i class="ti ti-file-description text-lg"></i>
                    <span>Skripsi</span>
                </a>

                <!-- Divider -->
                <div class="border-t border-gray-100 my-3"></div>

                <!-- Pengaturan -->
                <a href="#"
                   class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm text-gray-600 hover:bg-gray-50 hover:text-gray-900 cursor-pointer transition-colors">
                    <i class="ti ti-settings text-lg"></i>
                    <span>Pengaturan</span>
                </a>
            </nav>
        </aside>

        <!-- ============================================================ -->
        <!-- MAIN AREA -->
        <!-- ============================================================ -->
        <div class="flex flex-col flex-1 overflow-hidden">

            <!-- TOP BAR -->
            <header class="bg-white border-b border-gray-100 px-6 h-14 flex items-center justify-between flex-shrink-0">
                <!-- Left: Page Title -->
                <div class="flex items-center">
                    <i class="ti ti-trending-up text-blue-600 mr-2 text-xl"></i>
                    <h2 class="text-xl font-semibold text-gray-800">Overview</h2>
                </div>

                <!-- Right: User Info -->
                <div class="flex items-center gap-3">
                    <div class="w-9 h-9 bg-blue-700 rounded-full flex items-center justify-center text-white text-sm font-semibold">
                        AD
                    </div>
                    <span class="text-sm font-medium text-gray-700">Admin</span>
                    <i class="ti ti-chevron-down text-gray-400 text-sm"></i>
                </div>
            </header>

            <!-- CONTENT -->
            <main class="flex-1 overflow-y-auto p-6 bg-gray-100">

                <!-- ============================== -->
                <!-- WIDGET CARDS (Stat Cards) -->
                <!-- ============================== -->
                @php
                    $lecturerPercent = $totalLecturers > 0 ? round($activeLecturers / $totalLecturers * 100) : 0;
                    $studentPercent  = $totalStudents > 0 ? round($activeStudents / $totalStudents * 100) : 0;
                @endphp

                <div class="grid grid-cols-1 md:grid-cols-3 gap-5 mb-8">

                    <!-- Card 1: Dosen -->
                    <div class="bg-white rounded-xl p-5 shadow-sm border border-gray-100">
                        <div class="flex justify-between items-start">
                            <div>
                                <span class="inline-flex items-center gap-1 text-xs font-semibold px-2 py-0.5 rounded-full mb-3 bg-emerald-100 text-emerald-700">
                                    <i class="ti ti-trending-up text-xs"></i>
                                    {{ $lecturerPercent }}%
                                </span>
                                <p class="text-sm text-gray-500 font-medium mb-1">Dosen</p>
                                <p class="text-3xl font-bold text-gray-800">{{ $totalLecturers }}</p>
                            </div>
                            <div class="w-11 h-11 rounded-xl bg-blue-100 text-blue-600 flex items-center justify-center">
                                <i class="ti ti-users text-2xl"></i>
                            </div>
                        </div>
                    </div>

                    <!-- Card 2: Dosen Aktif -->
                    <div class="bg-white rounded-xl p-5 shadow-sm border border-gray-100">
                        <div class="flex justify-between items-start">
                            <div>
                                <span class="inline-flex items-center gap-1 text-xs font-semibold px-2 py-0.5 rounded-full mb-3 bg-emerald-100 text-emerald-700">
                                    <i class="ti ti-trending-up text-xs"></i>
                                    aktif
                                </span>
                                <p class="text-sm text-gray-500 font-medium mb-1">Dosen Aktif</p>
                                <p class="text-3xl font-bold text-gray-800">{{ $activeLecturers }}</p>
                            </div>
                            <div class="w-11 h-11 rounded-xl bg-emerald-100 text-emerald-600 flex items-center justify-center">
                                <i class="ti ti-user-check text-2xl"></i>
                            </div>
                        </div>
                    </div>

                    <!-- Card 3: Mahasiswa -->
                    <div class="bg-white rounded-xl p-5 shadow-sm border border-gray-100">
                        <div class="flex justify-between items-start">
                            <div>
                                <span class="inline-flex items-center gap-1 text-xs font-semibold px-2 py-0.5 rounded-full mb-3 bg-emerald-100 text-emerald-700">
                                    <i class="ti ti-trending-up text-xs"></i>
                                    {{ $studentPercent }}%
                                </span>
                                <p class="text-sm text-gray-500 font-medium mb-1">Mahasiswa</p>
                                <p class="text-3xl font-bold text-gray-800">{{ $totalStudents }}</p>
                            </div>
                            <div class="w-11 h-11 rounded-xl bg-purple-100 text-purple-600 flex items-center justify-center">
                                <i class="ti ti-school text-2xl"></i>
                            </div>
                        </div>
                    </div>

                    <!-- Card 4: Mhs Aktif -->
                    <div class="bg-white rounded-xl p-5 shadow-sm border border-gray-100">
                        <div class="flex justify-between items-start">
                            <div>
                                <span class="inline-flex items-center gap-1 text-xs font-semibold px-2 py-0.5 rounded-full mb-3 bg-emerald-100 text-emerald-700">
                                    <i class="ti ti-trending-up text-xs"></i>
                                    aktif
                                </span>
                                <p class="text-sm text-gray-500 font-medium mb-1">Mhs Aktif</p>
                                <p class="text-3xl font-bold text-gray-800">{{ $activeStudents }}</p>
                            </div>
                            <div class="w-11 h-11 rounded-xl bg-orange-100 text-orange-600 flex items-center justify-center">
                                <i class="ti ti-user-star text-2xl"></i>
                            </div>
                        </div>
                    </div>

                    <!-- Card 5: Mata Kuliah -->
                    <div class="bg-white rounded-xl p-5 shadow-sm border border-gray-100">
                        <div class="flex justify-between items-start">
                            <div>
                                <span class="inline-flex items-center gap-1 text-xs font-semibold px-2 py-0.5 rounded-full mb-3 bg-blue-100 text-blue-700">
                                    <i class="ti ti-database text-xs"></i>
                                    total
                                </span>
                                <p class="text-sm text-gray-500 font-medium mb-1">Mata Kuliah</p>
                                <p class="text-3xl font-bold text-gray-800">{{ $totalCourses }}</p>
                            </div>
                            <div class="w-11 h-11 rounded-xl bg-yellow-100 text-yellow-600 flex items-center justify-center">
                                <i class="ti ti-books text-2xl"></i>
                            </div>
                        </div>
                    </div>

                </div>

                <!-- ============================== -->
                <!-- AKSES CEPAT -->
                <!-- ============================== -->
                <div>
                    <!-- Section Header -->
                    <div class="flex justify-between items-center mb-4">
                        <h3 class="text-base font-semibold text-gray-800">Akses Cepat</h3>
                    </div>

                    <!-- Quick-link Grid -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">

                        <!-- Dosen -->
                        <a href="/lecturers"
                           class="bg-white rounded-xl p-5 border border-gray-100 shadow-sm flex items-center gap-4 hover:shadow-md hover:-translate-y-0.5 transition-all duration-150">
                            <div class="w-12 h-12 rounded-xl bg-blue-100 text-blue-600 flex items-center justify-center flex-shrink-0">
                                <i class="ti ti-users text-2xl"></i>
                            </div>
                            <div class="flex-1">
                                <p class="text-sm font-semibold text-gray-800">Dosen</p>
                                <p class="text-xs text-gray-400 mt-0.5">Kelola data dosen pembimbing</p>
                            </div>
                            <i class="ti ti-chevron-right ml-auto text-gray-300 text-lg"></i>
                        </a>

                        <!-- Mahasiswa -->
                        <a href="#"
                           class="bg-white rounded-xl p-5 border border-gray-100 shadow-sm flex items-center gap-4 hover:shadow-md hover:-translate-y-0.5 transition-all duration-150">
                            <div class="w-12 h-12 rounded-xl bg-purple-100 text-purple-600 flex items-center justify-center flex-shrink-0">
                                <i class="ti ti-school text-2xl"></i>
                            </div>
                            <div class="flex-1">
                                <p class="text-sm font-semibold text-gray-800">Mahasiswa</p>
                                <p class="text-xs text-gray-400 mt-0.5">Data mahasiswa aktif</p>
                            </div>
                            <i class="ti ti-chevron-right ml-auto text-gray-300 text-lg"></i>
                        </a>

                        <!-- Mata Kuliah Pilihan -->
                        <a href="{{ route('elective-courses.index') }}"
                           class="bg-white rounded-xl p-5 border border-gray-100 shadow-sm flex items-center gap-4 hover:shadow-md hover:-translate-y-0.5 transition-all duration-150">
                            <div class="w-12 h-12 rounded-xl bg-yellow-100 text-yellow-600 flex items-center justify-center flex-shrink-0">
                                <i class="ti ti-books text-2xl"></i>
                            </div>
                            <div class="flex-1">
                                <p class="text-sm font-semibold text-gray-800">Mata Kuliah Pilihan</p>
                                <p class="text-xs text-gray-400 mt-0.5">Daftar mata kuliah tersedia</p>
                            </div>
                            <i class="ti ti-chevron-right ml-auto text-gray-300 text-lg"></i>
                        </a>

                        <!-- Skripsi -->
                        <a href="#"
                           class="bg-white rounded-xl p-5 border border-gray-100 shadow-sm flex items-center gap-4 hover:shadow-md hover:-translate-y-0.5 transition-all duration-150">
                            <div class="w-12 h-12 rounded-xl bg-emerald-100 text-emerald-600 flex items-center justify-center flex-shrink-0">
                                <i class="ti ti-file-description text-2xl"></i>
                            </div>
                            <div class="flex-1">
                                <p class="text-sm font-semibold text-gray-800">Skripsi</p>
                                <p class="text-xs text-gray-400 mt-0.5">Manajemen pengajuan skripsi</p>
                            </div>
                            <i class="ti ti-chevron-right ml-auto text-gray-300 text-lg"></i>
                        </a>

                    </div>
                </div>

            </main>
        </div>

    </div>
</body>
</html>
