<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Logbook Bimbingan Skripsi - {{ $skripsi->student->name ?? '-' }}</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: {
                        sans: ['Inter', 'sans-serif'],
                    },
                    colors: {
                        brand: {
                            dark: '#0f172a',
                            slate: '#64748b',
                            border: '#e2e8f0',
                            bg: '#f8fafc',
                        }
                    }
                }
            }
        }
    </script>
</head>
<body class="bg-brand-bg text-slate-700 font-sans antialiased min-h-screen">
    <div class="max-w-6xl mx-auto px-4 py-8">

        {{-- Flash Messages --}}
        @if(session('success'))
            <div class="bg-emerald-50 border border-emerald-200 text-emerald-800 px-4 py-3 rounded-lg mb-6 flex items-center justify-between shadow-sm" role="alert">
                <div class="flex items-center">
                    <i class="fa-solid fa-circle-check text-emerald-500 mr-2.5 text-lg"></i>
                    <span class="text-sm font-medium">{{ session('success') }}</span>
                </div>
            </div>
        @endif

        @if($errors->any())
            <div class="bg-rose-50 border border-rose-200 text-rose-800 px-4 py-3 rounded-lg mb-6 shadow-sm" role="alert">
                <div class="flex items-start">
                    <i class="fa-solid fa-circle-xmark text-rose-500 mr-2.5 mt-0.5 text-lg"></i>
                    <div>
                        <strong class="text-sm font-semibold">Gagal menyimpan:</strong>
                        <ul class="list-disc list-inside mt-1 text-xs space-y-1">
                            @foreach($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            </div>
        @endif

        {{-- Header --}}
        <div class="mb-6">
            <a href="{{ route('skripsi.index') }}" class="text-xs text-brand-slate hover:text-brand-dark transition-colors inline-flex items-center gap-1.5 font-medium">
                <i class="fa-solid fa-arrow-left"></i> Kembali ke Daftar Skripsi
            </a>
            <h1 class="text-2xl font-bold text-brand-dark mt-2 tracking-tight">Logbook Bimbingan Skripsi</h1>
            <p class="text-sm text-brand-slate mt-1">Catat dan kelola sesi konsultasi bimbingan dengan mahasiswa secara terstruktur.</p>
        </div>

        {{-- Info Skripsi --}}
        <div class="bg-white border border-brand-border rounded-xl p-5 mb-8 shadow-sm">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <div class="md:col-span-2">
                    <div class="text-[11px] uppercase tracking-wider font-semibold text-brand-slate mb-1">Judul Skripsi</div>
                    <div class="text-sm font-semibold text-brand-dark leading-relaxed">{{ $skripsi->title }}</div>
                </div>
                <div>
                    <div class="text-[11px] uppercase tracking-wider font-semibold text-brand-slate mb-1">Mahasiswa</div>
                    <div class="text-sm font-medium text-brand-dark flex items-center gap-1.5">
                        <i class="fa-solid fa-user-graduate text-brand-slate text-xs"></i>
                        {{ $skripsi->student->name ?? '-' }}
                    </div>
                    <div class="text-xs text-brand-slate mt-0.5">NIM. {{ $skripsi->student->student_id ?? '-' }}</div>
                </div>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-12 gap-8">
            {{-- Tabel Riwayat Bimbingan (Kiri) --}}
            <div class="lg:col-span-7">
                <div class="bg-white border border-brand-border rounded-xl shadow-sm overflow-hidden">
                    <div class="px-5 py-4 border-b border-brand-border flex items-center justify-between bg-white">
                        <div class="flex items-center gap-2">
                            <i class="fa-solid fa-book-open text-brand-slate"></i>
                            <h2 class="font-bold text-brand-dark text-sm">Riwayat Bimbingan</h2>
                        </div>
                        <span class="bg-slate-100 text-brand-dark text-xs font-semibold px-2.5 py-1 rounded-full">
                            {{ $skripsi->bimbingans->count() }} Sesi
                        </span>
                    </div>

                    <div class="overflow-x-auto">
                        <table class="w-full text-left border-collapse">
                            <thead>
                                <tr class="bg-slate-50 border-b border-brand-border text-[11px] uppercase tracking-wider font-semibold text-brand-slate">
                                    <th class="py-3 px-4 w-12 text-center">No</th>
                                    <th class="py-3 px-4 w-32">Tanggal</th>
                                    <th class="py-3 px-4 w-44">Dosen Pencatat</th>
                                    <th class="py-3 px-4">Catatan</th>
                                    <th class="py-3 px-4 w-20 text-center">Aksi</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-brand-border text-sm">
                                @forelse($skripsi->bimbingans as $key => $bimbingan)
                                <tr class="hover:bg-slate-50/50 transition-colors">
                                    <td class="py-4 px-4 text-center text-xs text-brand-slate">{{ $key + 1 }}</td>
                                    <td class="py-4 px-4 font-medium text-brand-dark text-xs whitespace-nowrap">
                                        {{ $bimbingan->tanggal_bimbingan->format('d M Y') }}
                                    </td>
                                    <td class="py-4 px-4 text-xs font-medium text-brand-dark">
                                        {{ $bimbingan->lecturer->name ?? '-' }}
                                    </td>
                                    <td class="py-4 px-4 text-xs text-slate-600 leading-relaxed break-words whitespace-pre-wrap max-w-xs">
                                        {{ $bimbingan->catatan }}
                                    </td>
                                    <td class="py-4 px-4 text-center">
                                        <form action="{{ route('bimbingan.destroy', $bimbingan->id) }}" method="POST"
                                              onsubmit="return confirm('Hapus catatan bimbingan ini?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="bg-rose-500 hover:bg-rose-600 text-white p-1.5 rounded-md transition-colors text-xs inline-flex items-center justify-center w-7 h-7" title="Hapus">
                                                <i class="fa-solid fa-trash"></i>
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="5" class="py-12 text-center text-brand-slate bg-white">
                                        <i class="fa-regular fa-folder-open text-3xl mb-2.5 block text-slate-300"></i>
                                        <span class="text-xs">Belum ada catatan bimbingan.</span>
                                    </td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            {{-- Form Tambah Bimbingan (Kanan) --}}
            <div class="lg:col-span-5">
                <div class="bg-white border border-brand-border rounded-xl shadow-sm overflow-hidden">
                    <div class="px-5 py-4 border-b border-brand-border bg-white flex items-center gap-2">
                        <i class="fa-solid fa-plus-circle text-brand-slate"></i>
                        <h2 class="font-bold text-brand-dark text-sm">Tambah Catatan</h2>
                    </div>

                    <div class="p-6">
                        <form action="{{ route('bimbingan.store', $skripsi->id) }}" method="POST" class="space-y-4">
                            @csrf

                            {{-- Dosen Pencatat --}}
                            <div>
                                <label for="lecturer_id" class="block text-xs font-semibold text-slate-700 mb-1.5">
                                    Dosen Pencatat <span class="text-rose-500">*</span>
                                </label>
                                <select name="lecturer_id" id="lecturer_id"
                                        class="w-full text-xs rounded-lg border border-brand-border bg-white px-3 py-2 text-brand-dark focus:border-brand-dark focus:ring-1 focus:ring-brand-dark focus:outline-none transition-shadow">
                                    <option value="">-- Pilih Dosen --</option>
                                    @foreach($lecturers as $lecturer)
                                        <option value="{{ $lecturer->id }}"
                                            {{ old('lecturer_id', $skripsi->supervisor_id) == $lecturer->id ? 'selected' : '' }}>
                                            {{ $lecturer->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            {{-- Tanggal Bimbingan --}}
                            <div>
                                <label for="tanggal_bimbingan" class="block text-xs font-semibold text-slate-700 mb-1.5">
                                    Tanggal Bimbingan <span class="text-rose-500">*</span>
                                </label>
                                <input type="date" name="tanggal_bimbingan" id="tanggal_bimbingan"
                                       class="w-full text-xs rounded-lg border border-brand-border bg-white px-3 py-2 text-brand-dark focus:border-brand-dark focus:ring-1 focus:ring-brand-dark focus:outline-none transition-shadow"
                                       value="{{ old('tanggal_bimbingan', now()->format('Y-m-d')) }}">
                            </div>

                            {{-- Catatan --}}
                            <div>
                                <label for="catatan" class="block text-xs font-semibold text-slate-700 mb-1.5">
                                    Catatan Bimbingan <span class="text-rose-500">*</span>
                                </label>
                                <textarea name="catatan" id="catatan" rows="5"
                                          class="w-full text-xs rounded-lg border border-brand-border bg-white px-3 py-2 text-brand-dark focus:border-brand-dark focus:ring-1 focus:ring-brand-dark focus:outline-none transition-shadow placeholder:text-slate-400"
                                          placeholder="Tuliskan ringkasan hasil bimbingan, poin revisi, atau tindak lanjut...">{{ old('catatan') }}</textarea>
                            </div>

                            <button type="submit" class="w-full bg-brand-dark hover:bg-slate-800 text-white text-xs font-semibold py-2.5 px-4 rounded-lg transition-colors flex items-center justify-center gap-1.5 shadow-sm">
                                <i class="fa-solid fa-floppy-disk"></i> Simpan Catatan
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>

    </div>
</body>
</html>
