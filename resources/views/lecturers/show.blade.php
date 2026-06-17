<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Detail Dosen — Skriptif Sistem Manajemen Skripsi">
    <title>Detail Dosen - Skriptif</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@tabler/icons-webfont@latest/tabler-icons.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
</head>
<body class="bg-gray-100" style="font-family:'Inter',sans-serif">
    <div class="flex h-screen overflow-hidden">
        
        <!-- SIDEBAR -->
        <aside class="w-64 bg-white border-r border-gray-100 flex flex-col h-full overflow-y-auto px-4 py-5">
            <div class="mb-6">
                <h1 class="font-bold text-lg text-blue-800">Skriptif</h1>
                <p class="text-xs text-gray-400 mt-0.5">Manajemen Skripsi</p>
            </div>
            <nav class="flex flex-col gap-1 mt-6 flex-1">
                <a href="{{ route('dashboard') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm text-gray-600 hover:bg-gray-50 hover:text-gray-900 transition-colors">
                    <i class="ti ti-layout-dashboard text-lg"></i><span>Dashboard</span>
                </a>
                <a href="{{ route('lecturers.index') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm font-semibold bg-blue-50 text-blue-700 transition-colors">
                    <i class="ti ti-users text-lg"></i><span>Dosen</span>
                </a>
                <a href="{{ route('elective-courses.index') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm text-gray-600 hover:bg-gray-50 hover:text-gray-900 transition-colors">
                    <i class="ti ti-books text-lg"></i><span>Mata Kuliah Pilihan</span>
                </a>
            </nav>
        </aside>

        <!-- MAIN AREA -->
        <div class="flex flex-col flex-1 overflow-hidden">
            <!-- TOP BAR -->
            <header class="bg-white border-b border-gray-100 px-6 h-14 flex items-center justify-between flex-shrink-0">
                <div class="flex items-center">
                    <i class="ti ti-users text-blue-600 mr-2 text-xl"></i>
                    <h2 class="text-xl font-semibold text-gray-800">Dosen</h2>
                </div>
                <div class="flex items-center gap-3">
                    <div class="w-9 h-9 bg-blue-700 rounded-full flex items-center justify-center text-white text-sm font-semibold">AD</div>
                    <span class="text-sm font-medium text-gray-700">Admin</span>
                </div>
            </header>

            <!-- CONTENT -->
            <main class="flex-1 overflow-y-auto p-6 bg-gray-100 flex flex-col">
                <div class="flex items-center justify-between mb-6 flex-shrink-0">
                    <div>
                        <div class="flex items-center gap-1.5 text-xs text-gray-400 mb-1.5">
                            <i class="ti ti-home text-xs"></i><span>Beranda</span>
                            <i class="ti ti-chevron-right text-xs"></i><a href="{{ route('lecturers.index') }}" class="hover:text-blue-600">Dosen</a>
                            <i class="ti ti-chevron-right text-xs"></i><span class="text-gray-600">Detail Dosen</span>
                        </div>
                        <h3 class="text-lg font-semibold text-gray-800">Profil Dosen</h3>
                    </div>
                    <div class="flex gap-2">
                        <a href="{{ route('lecturers.index') }}" class="inline-flex items-center gap-2 px-4 py-2 bg-white border border-gray-200 text-gray-700 hover:bg-gray-50 text-sm font-medium rounded-lg transition-colors shadow-sm">
                            <i class="ti ti-arrow-left text-base"></i>Kembali
                        </a>
                        <a href="{{ route('lecturers.edit', $lecturer->id) }}" class="inline-flex items-center gap-2 px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white text-sm font-medium rounded-lg transition-colors shadow-sm">
                            <i class="ti ti-pencil text-base"></i>Edit Dosen
                        </a>
                    </div>
                </div>

                <div class="bg-white rounded-xl border border-gray-100 shadow-sm p-8 flex flex-col flex-1 w-full">
                    <div class="flex items-start gap-6 mb-8 pb-8 border-b border-gray-100">
                        <div class="w-24 h-24 rounded-full bg-blue-50 text-blue-600 flex items-center justify-center flex-shrink-0 text-4xl shadow-sm">
                            <i class="ti ti-user"></i>
                        </div>
                        <div class="flex-1">
                            <h2 class="text-2xl font-bold text-gray-900 mb-1">{{ $lecturer->name }}</h2>
                            <p class="text-gray-500 font-medium mb-3 flex items-center gap-2">
                                <i class="ti ti-id"></i> NIDN: {{ $lecturer->lecturer_id }}
                            </p>
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                        <div>
                            <h4 class="text-xs font-bold text-gray-400 uppercase tracking-wider mb-2">Informasi Kontak</h4>
                            <div class="flex items-center gap-3 text-gray-800">
                                <div class="w-10 h-10 rounded-lg bg-gray-50 flex items-center justify-center text-gray-500">
                                    <i class="ti ti-mail text-xl"></i>
                                </div>
                                <div>
                                    <p class="text-xs text-gray-500 mb-0.5">Email</p>
                                    <p class="font-medium text-sm">{{ $lecturer->email }}</p>
                                </div>
                            </div>
                        </div>

                        <div>
                            <h4 class="text-xs font-bold text-gray-400 uppercase tracking-wider mb-2">Bidang Akademik</h4>
                            <div class="flex items-center gap-3 text-gray-800">
                                <div class="w-10 h-10 rounded-lg bg-purple-50 flex items-center justify-center text-purple-600">
                                    <i class="ti ti-brain text-xl"></i>
                                </div>
                                <div>
                                    <p class="text-xs text-gray-500 mb-0.5">Keahlian Utama</p>
                                    <p class="font-medium text-sm">{{ $lecturer->expertise ?: 'Belum ditentukan' }}</p>
                                </div>
                            </div>
                        </div>

                        <div>
                            <h4 class="text-xs font-bold text-gray-400 uppercase tracking-wider mb-2">Riwayat Sistem</h4>
                            <div class="flex items-center gap-3 text-gray-800">
                                <div class="w-10 h-10 rounded-lg bg-emerald-50 flex items-center justify-center text-emerald-600">
                                    <i class="ti ti-calendar-plus text-xl"></i>
                                </div>
                                <div>
                                    <p class="text-xs text-gray-500 mb-0.5">Didaftarkan Pada</p>
                                    <p class="font-medium text-sm">{{ $lecturer->created_at->translatedFormat('d F Y H:i') }}</p>
                                </div>
                            </div>
                        </div>
                        
                        <div>
                            <h4 class="text-xs font-bold text-gray-400 uppercase tracking-wider mb-2">&nbsp;</h4>
                            <div class="flex items-center gap-3 text-gray-800">
                                <div class="w-10 h-10 rounded-lg bg-amber-50 flex items-center justify-center text-amber-600">
                                    <i class="ti ti-refresh text-xl"></i>
                                </div>
                                <div>
                                    <p class="text-xs text-gray-500 mb-0.5">Pembaruan Terakhir</p>
                                    <p class="font-medium text-sm">{{ $lecturer->updated_at->translatedFormat('d F Y H:i') }}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </main>
        </div>
    </div>
</body>
</html>
