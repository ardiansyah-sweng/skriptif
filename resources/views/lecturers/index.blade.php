<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Dosen — Skriptif Sistem Manajemen Skripsi">
    <title>Dosen - Skriptif</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@tabler/icons-webfont@latest/tabler-icons.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>
        /* Custom styles not easily done with Tailwind utility */
        .form-input:focus { border-color: #3b82f6; box-shadow: 0 0 0 3px rgba(59,130,246,.1); }
    </style>
</head>
<body class="bg-gray-100" style="font-family:'Inter',sans-serif">
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
                <!-- Dashboard -->
                <a href="{{ route('dashboard') }}"
                   class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm text-gray-600 hover:bg-gray-50 hover:text-gray-900 cursor-pointer transition-colors">
                    <i class="ti ti-layout-dashboard text-lg"></i>
                    <span>Dashboard</span>
                </a>

                <!-- Dosen — AKTIF -->
                <a href="{{ route('lecturers.index') }}"
                   class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm font-semibold bg-blue-50 text-blue-700 cursor-pointer transition-colors">
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
                    <i class="ti ti-users text-blue-600 mr-2 text-xl"></i>
                    <h2 class="text-xl font-semibold text-gray-800">Dosen</h2>
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
                <!-- PAGE HEADER -->
                <!-- ============================== -->
                <div class="flex items-center justify-between mb-6">
                    <div>
                        <!-- Breadcrumb -->
                        <div class="flex items-center gap-1.5 text-xs text-gray-400 mb-1.5">
                            <i class="ti ti-home text-xs"></i>
                            <span>Beranda</span>
                            <i class="ti ti-chevron-right text-xs"></i>
                            <span class="text-gray-600">Dosen</span>
                        </div>
                        <h3 class="text-lg font-semibold text-gray-800">Daftar Dosen</h3>
                        <p class="text-sm text-gray-500 mt-0.5">Kelola data dosen pembimbing skripsi</p>
                    </div>
                    <button onclick="toggleForm()" class="inline-flex items-center gap-2 px-4 py-2.5 bg-blue-600 hover:bg-blue-700 text-white text-sm font-medium rounded-lg transition-colors shadow-sm">
                        <i class="ti ti-plus text-base"></i>
                        Tambah Dosen
                    </button>
                </div>

                <!-- ============================== -->
                <!-- FLASH MESSAGE -->
                <!-- ============================== -->
                @if(session('success'))
                    <div class="flex items-center gap-2.5 px-4 py-3 mb-5 bg-emerald-50 border border-emerald-200 text-emerald-700 rounded-lg text-sm">
                        <i class="ti ti-circle-check text-lg"></i>
                        {{ session('success') }}
                    </div>
                @endif

                <!-- ============================== -->
                <!-- TOOLBAR -->
                <!-- ============================== -->
                <div class="flex items-center justify-between mb-4">
                    <!-- Count pill -->
                    <div class="inline-flex items-center gap-2 px-3 py-1.5 bg-white border border-gray-100 rounded-full text-xs text-gray-500">
                        <i class="ti ti-users text-sm"></i>
                        <span class="font-medium text-gray-800">{{ $lecturers->count() }}</span> dosen terdaftar
                    </div>
                    <!-- Search -->
                    <div class="flex items-center gap-2 px-3 py-2 bg-white border border-gray-200 rounded-lg">
                        <i class="ti ti-search text-gray-400 text-sm"></i>
                        <input type="text" id="q" placeholder="Cari nama dosen..." oninput="filterTable()"
                               class="border-none outline-none bg-transparent text-sm text-gray-700 w-48 placeholder-gray-400">
                    </div>
                </div>

                <!-- ============================== -->
                <!-- FORM TAMBAH DOSEN -->
                <!-- ============================== -->
                <div id="form-tambah" class="bg-white rounded-xl border border-gray-100 shadow-sm p-6 mb-5" style="display: {{ $errors->any() ? 'block' : 'none' }}">
                    <h4 class="text-sm font-semibold text-gray-800 mb-5">Tambah Dosen Baru</h4>
                    <form action="{{ route('lecturers.store') }}" method="POST">
                        @csrf
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <!-- NIDN -->
                            <div>
                                <label for="lecturer_id" class="block text-xs font-medium text-gray-500 mb-1.5">NIDN</label>
                                <input type="text" id="lecturer_id" name="lecturer_id" value="{{ old('lecturer_id') }}"
                                       placeholder="Contoh: 0512345678"
                                       class="form-input w-full px-3 py-2 border border-gray-200 rounded-lg text-sm text-gray-800 outline-none transition-all">
                                @error('lecturer_id') <p class="text-xs text-red-500 mt-1">{{ $message }}</p> @enderror
                            </div>
                            <!-- Nama -->
                            <div>
                                <label for="name" class="block text-xs font-medium text-gray-500 mb-1.5">Nama Lengkap</label>
                                <input type="text" id="name" name="name" value="{{ old('name') }}"
                                       placeholder="Contoh: Dr. Budi Santoso, M.Kom"
                                       class="form-input w-full px-3 py-2 border border-gray-200 rounded-lg text-sm text-gray-800 outline-none transition-all">
                                @error('name') <p class="text-xs text-red-500 mt-1">{{ $message }}</p> @enderror
                            </div>
                            <!-- Email -->
                            <div>
                                <label for="email" class="block text-xs font-medium text-gray-500 mb-1.5">Email</label>
                                <input type="email" id="email" name="email" value="{{ old('email') }}"
                                       placeholder="Contoh: budi@uad.ac.id"
                                       class="form-input w-full px-3 py-2 border border-gray-200 rounded-lg text-sm text-gray-800 outline-none transition-all">
                                @error('email') <p class="text-xs text-red-500 mt-1">{{ $message }}</p> @enderror
                            </div>
                            <!-- Status -->
                            <div>
                                <label for="status" class="block text-xs font-medium text-gray-500 mb-1.5">Status</label>
                                <select id="status" name="status"
                                        class="form-input w-full px-3 py-2 border border-gray-200 rounded-lg text-sm text-gray-800 outline-none transition-all bg-white">
                                    <option value="active" {{ old('status') == 'active' ? 'selected' : '' }}>Aktif</option>
                                    <option value="inactive" {{ old('status') == 'inactive' ? 'selected' : '' }}>Non-aktif</option>
                                </select>
                                @error('status') <p class="text-xs text-red-500 mt-1">{{ $message }}</p> @enderror
                            </div>
                            <!-- Keahlian (full width) -->
                            <div class="md:col-span-2">
                                <label for="expertise" class="block text-xs font-medium text-gray-500 mb-1.5">Bidang Keahlian</label>
                                <input type="text" id="expertise" name="expertise" value="{{ old('expertise') }}"
                                       placeholder="Contoh: Kecerdasan Buatan"
                                       class="form-input w-full px-3 py-2 border border-gray-200 rounded-lg text-sm text-gray-800 outline-none transition-all">
                                @error('expertise') <p class="text-xs text-red-500 mt-1">{{ $message }}</p> @enderror
                            </div>
                        </div>
                        <!-- Actions -->
                        <div class="flex justify-end gap-3 mt-5 pt-4 border-t border-gray-100">
                            <button type="button" onclick="toggleForm()"
                                    class="px-4 py-2 text-sm font-medium text-gray-600 bg-white border border-gray-200 rounded-lg hover:bg-gray-50 transition-colors">
                                Batal
                            </button>
                            <button type="submit"
                                    class="inline-flex items-center gap-1.5 px-4 py-2 text-sm font-medium text-white bg-blue-600 hover:bg-blue-700 rounded-lg transition-colors shadow-sm">
                                <i class="ti ti-check text-base"></i>
                                Simpan
                            </button>
                        </div>
                    </form>
                </div>

                <!-- ============================== -->
                <!-- TABLE -->
                <!-- ============================== -->
                <div class="bg-white rounded-xl border border-gray-100 shadow-sm overflow-hidden">
                    @if($lecturers->isEmpty())
                        <div class="text-center py-16 px-4">
                            <i class="ti ti-user-off text-4xl text-gray-300 block mb-3"></i>
                            <p class="text-sm text-gray-400">Belum ada data dosen.</p>
                        </div>
                    @else
                        <table class="w-full text-sm">
                            <thead class="bg-gray-50/80">
                                <tr>
                                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-400 uppercase tracking-wider" style="width:48px">No</th>
                                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-400 uppercase tracking-wider">Dosen</th>
                                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-400 uppercase tracking-wider">Email</th>
                                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-400 uppercase tracking-wider">Keahlian</th>
                                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-400 uppercase tracking-wider" style="width:90px">Status</th>
                                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-400 uppercase tracking-wider" style="width:90px">Aksi</th>
                                </tr>
                            </thead>
                            <tbody id="tbody" class="divide-y divide-gray-50">
                                @foreach($lecturers as $index => $lecturer)
                                    <tr class="hover:bg-gray-50/50 transition-colors">
                                        <td class="px-4 py-3.5 text-xs text-gray-400">{{ $index + 1 }}</td>
                                        <td class="px-4 py-3.5">
                                            <div class="flex items-center gap-3">
                                                <div class="w-8 h-8 rounded-lg bg-blue-50 flex items-center justify-center flex-shrink-0">
                                                    <i class="ti ti-user text-blue-600 text-base"></i>
                                                </div>
                                                <div>
                                                    <p class="text-xs text-gray-400">{{ $lecturer->lecturer_id }}</p>
                                                    <p class="text-sm font-medium text-gray-800 lecturer-name">{{ $lecturer->name }}</p>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="px-4 py-3.5 text-xs text-gray-500">{{ $lecturer->email }}</td>
                                        <td class="px-4 py-3.5 text-xs text-gray-500">
                                            @if($lecturer->expertise)
                                                {{ $lecturer->expertise }}
                                            @else
                                                <span class="text-gray-300">—</span>
                                            @endif
                                        </td>
                                        <td class="px-4 py-3.5">
                                            @if($lecturer->status === 'active')
                                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-emerald-50 text-emerald-700">
                                                    Aktif
                                                </span>
                                            @else
                                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-50 text-red-600">
                                                    Non-aktif
                                                </span>
                                            @endif
                                        </td>
                                        <td class="px-4 py-3.5">
                                            <form action="{{ route('lecturers.destroy', $lecturer->id) }}" method="POST"
                                                  onsubmit="return confirm('Hapus dosen {{ $lecturer->name }}?')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit"
                                                        class="inline-flex items-center gap-1 px-2.5 py-1.5 text-xs font-medium text-red-500 bg-white border border-gray-200 rounded-lg hover:bg-red-50 hover:border-red-200 transition-colors">
                                                    <i class="ti ti-trash text-sm"></i>
                                                    Hapus
                                                </button>
                                            </form>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    @endif
                </div>

            </main>
        </div>

    </div>

    <script>
        // Toggle form tambah
        function toggleForm() {
            const form = document.getElementById('form-tambah');
            form.style.display = form.style.display === 'none' ? 'block' : 'none';
        }

        // Filter tabel by nama dosen
        function filterTable() {
            const q = document.getElementById('q').value.toLowerCase();
            document.querySelectorAll('#tbody tr').forEach(r => {
                const name = r.querySelector('.lecturer-name')?.textContent.toLowerCase() ?? '';
                r.style.display = name.includes(q) ? '' : 'none';
            });
        }
    </script>
</body>
</html>
