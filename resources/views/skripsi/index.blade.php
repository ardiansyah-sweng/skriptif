<!DOCTYPE html>
<html lang="id">

  <head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar Skripsi - Skriptif</title>

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
          <p class="text-xs text-gray-400 mt-0.5">
            Manajemen Skripsi
          </p>
        </div>

        <nav class="flex flex-col gap-1 mt-6 flex-1">

          <a href="{{ route('dashboard') }}"
            class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm text-gray-600 hover:bg-gray-50">
            <i class="ti ti-layout-dashboard text-lg"></i>
            <span>Dashboard</span>
          </a>

          <a href="{{ route('lecturers.index') }}"
            class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm text-gray-600 hover:bg-gray-50">
            <i class="ti ti-users text-lg"></i>
            <span>Dosen</span>
          </a>

          <a href="{{ route('students.index') }}"
            class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm text-gray-600 hover:bg-gray-50">
            <i class="ti ti-school text-lg"></i>
            <span>Mahasiswa</span>
          </a>

          <a href="{{ route('elective-courses.index') }}"
            class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm text-gray-600 hover:bg-gray-50">
            <i class="ti ti-books text-lg"></i>
            <span>Mata Kuliah Pilihan</span>
          </a>

          <!-- ACTIVE MENU -->
          <a href="{{ route('skripsi.index') }}"
            class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm font-semibold bg-blue-50 text-blue-700">
            <i class="ti ti-file-description text-lg"></i>
            <span>Skripsi</span>
          </a>

          <a href="#" class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm text-gray-600 hover:bg-gray-50">
            <i class="ti ti-settings text-lg"></i>
            <span>Pengaturan</span>
          </a>

        </nav>

      </aside>

      <!-- MAIN -->
      <div class="flex flex-col flex-1 overflow-hidden">

        <!-- TOP BAR -->
        <header class="bg-white border-b border-gray-100 px-6 h-14 flex items-center justify-between">

          <div class="flex items-center">
            <i class="ti ti-file-description text-blue-600 mr-2 text-xl"></i>
            <h2 class="text-xl font-semibold text-gray-800">
              Skripsi
            </h2>
          </div>

          <div class="flex items-center gap-3">
            <div
              class="w-9 h-9 bg-blue-700 rounded-full flex items-center justify-center text-white text-sm font-semibold">
              AD
            </div>

            <span class="text-sm font-medium text-gray-700">
              Admin
            </span>
          </div>

        </header>

        <!-- CONTENT -->
        <main class="flex-1 overflow-y-auto p-6 bg-gray-100">

          <!-- Header -->
          <div class="flex justify-between items-start mb-6">

            <div>
              <div class="flex items-center gap-1.5 text-xs text-gray-400 mb-1.5">
                <i class="ti ti-home text-xs"></i>
                <span>Beranda</span>
                <i class="ti ti-chevron-right text-xs"></i>
                <span class="text-gray-600">Skripsi</span>
              </div>

              <h3 class="text-lg font-semibold text-gray-800">
                Daftar Skripsi
              </h3>

              <p class="text-sm text-gray-500">
                Kelola data pengajuan skripsi mahasiswa
              </p>
            </div>

            <a href="{{ route('skripsi.create') }}"
              class="inline-flex items-center gap-2 px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white text-sm font-medium rounded-lg shadow-sm">
              <i class="ti ti-plus"></i>
              Ajukan Skripsi
            </a>

          </div>

          <!-- Toolbar -->
          <div class="flex justify-between items-center mb-4">

            <div
              class="inline-flex items-center gap-2 bg-white px-4 py-2 rounded-full border border-gray-100 shadow-sm">
              <i class="ti ti-file-description text-gray-400"></i>
              <span class="text-sm text-gray-600">
                1 total skripsi
              </span>
            </div>

            <div class="relative">
              <i class="ti ti-search absolute left-3 top-3 text-gray-400"></i>

              <input type="text" placeholder="Cari judul skripsi..."
                class="pl-10 pr-4 py-2 border border-gray-200 rounded-lg bg-white text-sm focus:outline-none">
            </div>

          </div>

          <!-- Table -->
          <div class="bg-white rounded-xl border border-gray-100 shadow-sm overflow-hidden">

            <table class="w-full">

              <thead class="bg-gray-50">

                <tr class="text-left text-xs text-gray-400 uppercase">

                  <th class="px-5 py-4">No</th>

                  <th class="px-5 py-4">Mahasiswa</th>

                  <th class="px-5 py-4">Judul Skripsi</th>

                  <th class="px-5 py-4">Pembimbing</th>

                  <th class="px-5 py-4">Status</th>

                  <th class="px-5 py-4">Aksi</th>

                </tr>

              </thead>

              <tbody>

                <tr class="border-t">

                  <td class="px-5 py-4">1</td>

                  <td class="px-5 py-4">
                    Aldrion Wijaya
                  </td>

                  <td class="px-5 py-4">
                    Pengaruh Feature Selection Chi-Square terhadap Performa XGBoost pada Prediksi Stunting Balita
                  </td>

                  <td class="px-5 py-4">
                    Belum Ditentukan
                  </td>

                  <td class="px-5 py-4">

                    <span class="px-3 py-1 rounded-full text-xs bg-yellow-100 text-yellow-700">
                      Pending
                    </span>

                  </td>

                  <td class="px-5 py-4">

                    <div class="flex gap-2">

                      <a href="{{ route('skripsi.show', 1) }}"
                        class="px-3 py-1 text-xs border rounded-lg text-blue-600">
                        Detail
                      </a>

                      <a href="{{ route('skripsi.edit', 1) }}"
                        class="px-3 py-1 text-xs border rounded-lg text-orange-500">
                        Edit
                      </a>

                      <button onclick="return confirm('Yakin ingin menghapus data skripsi ini?')"
                        class="px-3 py-1 text-xs border rounded-lg text-red-500">
                        Hapus
                      </button>

                    </div>

                  </td>

                </tr>

              </tbody>

            </table>

          </div>

        </main>

      </div>

    </div>

  </body>

</html>