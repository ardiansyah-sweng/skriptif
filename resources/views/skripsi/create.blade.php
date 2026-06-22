<!DOCTYPE html>
<html lang="id">

  <head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ajukan Skripsi - Skriptif</title>

    <script src="https://cdn.tailwindcss.com"></script>

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@tabler/icons-webfont@latest/tabler-icons.min.css">

    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">

    <style>
    .form-input:focus {
      border-color: #3b82f6;
      box-shadow: 0 0 0 3px rgba(59, 130, 246, .1);
    }
    </style>
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

          <a href="{{ route('skripsi.index') }}"
            class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm font-semibold bg-blue-50 text-blue-700">
            <i class="ti ti-file-description text-lg"></i>
            <span>Skripsi</span>
          </a>

        </nav>

      </aside>

      <!-- MAIN -->
      <div class="flex flex-col flex-1 overflow-hidden">

        <!-- HEADER -->
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

          <div class="mb-6">

            <div class="flex items-center gap-1.5 text-xs text-gray-400 mb-1.5">

              <i class="ti ti-home text-xs"></i>

              <span>Beranda</span>

              <i class="ti ti-chevron-right text-xs"></i>

              <a href="{{ route('skripsi.index') }}" class="hover:text-blue-600">
                Skripsi
              </a>

              <i class="ti ti-chevron-right text-xs"></i>

              <span class="text-gray-600">
                Ajukan Skripsi
              </span>

            </div>

            <h3 class="text-lg font-semibold text-gray-800">
              Form Pengajuan Skripsi
            </h3>

          </div>

          <div class="bg-white rounded-xl border border-gray-100 shadow-sm p-6">

            <form action="{{ route('skripsi.store') }}" method="POST">

              @csrf

              <div class="grid grid-cols-1 md:grid-cols-2 gap-4">

                <!-- Mahasiswa -->
                <div>
                  <label class="block text-xs font-medium text-gray-500 mb-1.5">
                    Mahasiswa
                  </label>

                  <select name="student_id" class="form-input w-full px-3 py-2 border border-gray-200 rounded-lg">

                    <option value="">
                      Pilih Mahasiswa
                    </option>

                    @foreach($students as $student)
                    <option value="{{ $student->id }}">
                      {{ $student->name }}
                    </option>
                    @endforeach

                  </select>

                  @error('student_id')
                  <p class="text-red-500 text-xs mt-1">
                    {{ $message }}
                  </p>
                  @enderror
                </div>

                <!-- Dosen Pembimbing -->
                <div>
                  <label class="block text-xs font-medium text-gray-500 mb-1.5">
                    Dosen Pembimbing
                  </label>

                  <select name="supervisor_id" class="form-input w-full px-3 py-2 border border-gray-200 rounded-lg">

                    <option value="">
                      Pilih Dosen
                    </option>

                    @foreach($lecturers as $lecturer)
                    <option value="{{ $lecturer->id }}">
                      {{ $lecturer->name }}
                    </option>
                    @endforeach

                  </select>
                </div>

                <!-- Judul -->
                <div class="md:col-span-2">
                  <label class="block text-xs font-medium text-gray-500 mb-1.5">
                    Judul Skripsi
                  </label>

                  <input type="text" name="title" value="{{ old('title') }}"
                    class="form-input w-full px-3 py-2 border border-gray-200 rounded-lg">

                  @error('title')
                  <p class="text-red-500 text-xs mt-1">
                    {{ $message }}
                  </p>
                  @enderror
                </div>

                <!-- Deskripsi -->
                <div class="md:col-span-2">
                  <label class="block text-xs font-medium text-gray-500 mb-1.5">
                    Deskripsi
                  </label>

                  <textarea name="description" rows="5"
                    class="form-input w-full px-3 py-2 border border-gray-200 rounded-lg">{{ old('description') }}</textarea>
                </div>

                <!-- Dosen Usulan -->
                <div>
                  <label class="block text-xs font-medium text-gray-500 mb-1.5">
                    Dosen Usulan
                  </label>

                  <select name="suggestion_supervisor"
                    class="form-input w-full px-3 py-2 border border-gray-200 rounded-lg">

                    <option value="">
                      Pilih Dosen Usulan
                    </option>

                    @foreach($lecturers as $lecturer)
                    <option value="{{ $lecturer->id }}">
                      {{ $lecturer->name }}
                    </option>
                    @endforeach

                  </select>
                </div>

                <!-- Mata Kuliah Pilihan -->
                <div>
                  <label class="block text-xs font-medium text-gray-500 mb-1.5">
                    Mata Kuliah Pilihan
                  </label>

                  <select name="elective_courses" class="form-input w-full px-3 py-2 border border-gray-200 rounded-lg">

                    <option value="">
                      Pilih Mata Kuliah
                    </option>

                    @foreach($electiveCourses as $course)
                    <option value="{{ $course->id }}">
                      {{ $course->courses }}
                    </option>
                    @endforeach

                  </select>
                </div>

              </div>

              <div class="flex justify-end gap-3 mt-6 pt-4 border-t border-gray-100">

                <a href="{{ route('skripsi.index') }}"
                  class="px-4 py-2 text-sm font-medium text-gray-600 bg-white border border-gray-200 rounded-lg hover:bg-gray-50">
                  Batal
                </a>

                <button type="submit"
                  class="inline-flex items-center gap-1.5 px-4 py-2 text-sm font-medium text-white bg-blue-600 hover:bg-blue-700 rounded-lg shadow-sm">

                  <i class="ti ti-device-floppy"></i>

                  Ajukan Skripsi

                </button>

              </div>

            </form>

          </div>

        </main>

      </div>

    </div>

  </body>

</html>