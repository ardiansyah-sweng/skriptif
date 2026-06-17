<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Edit Dosen — Skriptif Sistem Manajemen Skripsi">
    <title>Edit Dosen - Skriptif</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@tabler/icons-webfont@latest/tabler-icons.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>
        .form-input:focus { border-color: #3b82f6; box-shadow: 0 0 0 3px rgba(59,130,246,.1); }
    </style>
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
                <div class="mb-6 flex-shrink-0">
                    <div class="flex items-center gap-1.5 text-xs text-gray-400 mb-1.5">
                        <i class="ti ti-home text-xs"></i><span>Beranda</span>
                        <i class="ti ti-chevron-right text-xs"></i><a href="{{ route('lecturers.index') }}" class="hover:text-blue-600">Dosen</a>
                        <i class="ti ti-chevron-right text-xs"></i><span class="text-gray-600">Edit Dosen</span>
                    </div>
                    <h3 class="text-lg font-semibold text-gray-800">Edit Data Dosen</h3>
                </div>

                <div class="bg-white rounded-xl border border-gray-100 shadow-sm p-6 flex flex-col flex-1 w-full">
                    <form action="{{ route('lecturers.update', $lecturer->id) }}" method="POST" class="flex flex-col flex-1">
                        @csrf
                        @method('PUT')
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <label for="lecturer_id" class="block text-xs font-medium text-gray-500 mb-1.5">NIDN</label>
                                <input type="text" id="lecturer_id" name="lecturer_id" value="{{ old('lecturer_id', $lecturer->lecturer_id) }}" class="form-input w-full px-3 py-2 border border-gray-200 rounded-lg text-sm text-gray-800 outline-none transition-all">
                                @error('lecturer_id') <p class="text-xs text-red-500 mt-1">{{ $message }}</p> @enderror
                            </div>
                            <div>
                                <label for="name" class="block text-xs font-medium text-gray-500 mb-1.5">Nama Lengkap</label>
                                <input type="text" id="name" name="name" value="{{ old('name', $lecturer->name) }}" class="form-input w-full px-3 py-2 border border-gray-200 rounded-lg text-sm text-gray-800 outline-none transition-all">
                                @error('name') <p class="text-xs text-red-500 mt-1">{{ $message }}</p> @enderror
                            </div>
                            <div>
                                <label for="email" class="block text-xs font-medium text-gray-500 mb-1.5">Email</label>
                                <input type="email" id="email" name="email" value="{{ old('email', $lecturer->email) }}" class="form-input w-full px-3 py-2 border border-gray-200 rounded-lg text-sm text-gray-800 outline-none transition-all">
                                @error('email') <p class="text-xs text-red-500 mt-1">{{ $message }}</p> @enderror
                            </div>
                            <div>
                                <label for="status" class="block text-xs font-medium text-gray-500 mb-1.5">Status</label>
                                <select id="status" name="status" class="form-input w-full px-3 py-2 border border-gray-200 rounded-lg text-sm text-gray-800 outline-none transition-all bg-white">
                                    <option value="active" {{ old('status', $lecturer->status) == 'active' ? 'selected' : '' }}>Aktif</option>
                                    <option value="inactive" {{ old('status', $lecturer->status) == 'inactive' ? 'selected' : '' }}>Non-aktif</option>
                                </select>
                                @error('status') <p class="text-xs text-red-500 mt-1">{{ $message }}</p> @enderror
                            </div>
                            <div class="md:col-span-2">
                                <label for="expertise" class="block text-xs font-medium text-gray-500 mb-1.5">Bidang Keahlian</label>
                                <input type="text" id="expertise" name="expertise" value="{{ old('expertise', $lecturer->expertise) }}" class="form-input w-full px-3 py-2 border border-gray-200 rounded-lg text-sm text-gray-800 outline-none transition-all">
                                @error('expertise') <p class="text-xs text-red-500 mt-1">{{ $message }}</p> @enderror
                            </div>
                        </div>
                        <div class="flex justify-end gap-3 mt-auto pt-4 border-t border-gray-100">
                            <a href="{{ route('lecturers.index') }}" class="px-4 py-2 text-sm font-medium text-gray-600 bg-white border border-gray-200 rounded-lg hover:bg-gray-50 transition-colors">Batal</a>
                            <button type="submit" class="inline-flex items-center gap-1.5 px-4 py-2 text-sm font-medium text-white bg-blue-600 hover:bg-blue-700 rounded-lg transition-colors shadow-sm">
                                <i class="ti ti-check text-base"></i>Simpan Perubahan
                            </button>
                        </div>
                    </form>
                </div>
            </main>
        </div>
    </div>
</body>
</html>
