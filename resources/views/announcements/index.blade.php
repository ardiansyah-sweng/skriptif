@extends('layouts.app')

@section('title', 'Pengumuman')

@push('styles')
<script src="https://cdn.tailwindcss.com"></script>
<link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
<script>
    tailwind.config = {
        theme: {
            extend: {
                fontFamily: {
                    sans: ['Inter', 'sans-serif'],
                },
            }
        }
    }
</script>
@endpush

@section('content')
    <div class="max-w-4xl mx-auto">

        {{-- Header --}}
        <div class="flex items-center justify-between mb-8">
            <div>
                <h1 class="text-2xl font-bold text-gray-900">Pengumuman</h1>
                <p class="text-sm text-gray-500 mt-1">Informasi terbaru untuk civitas akademika</p>
            </div>
            @if(Auth::user()->role === 'admin')
            <button
                onclick="document.getElementById('modalTambah').classList.remove('hidden')"
                class="inline-flex items-center gap-2 bg-indigo-600 hover:bg-indigo-700 text-white text-sm font-medium px-5 py-2.5 rounded-lg transition-colors"
            >
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4" />
                </svg>
                Tambah Pengumuman
            </button>
            @endif
        </div>

        {{-- Modal Form Tambah --}}
        @if(Auth::user()->role === 'admin')
        <div id="modalTambah" class="hidden fixed inset-0 z-50 flex items-center justify-center">
            <div class="absolute inset-0 bg-black/40" onclick="document.getElementById('modalTambah').classList.add('hidden')"></div>
            <div class="relative bg-white rounded-xl shadow-xl w-full max-w-lg mx-4 p-6">
                <div class="flex items-center justify-between mb-5">
                    <h2 class="text-lg font-semibold text-gray-900">Tambah Pengumuman</h2>
                    <button
                        onclick="document.getElementById('modalTambah').classList.add('hidden')"
                        class="text-gray-400 hover:text-gray-600 transition-colors"
                    >
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>
                <form action="{{ route('announcements.store') }}" method="POST" class="space-y-4">
                    @csrf
                    <div>
                        <label for="title" class="block text-sm font-medium text-gray-700 mb-1">Judul</label>
                        <input
                            type="text" id="title" name="title" required maxlength="255"
                            placeholder="Masukkan judul pengumuman"
                            class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent"
                        >
                    </div>
                    <div>
                        <label for="content" class="block text-sm font-medium text-gray-700 mb-1">Isi Pengumuman</label>
                        <textarea
                            id="content" name="content" required rows="4"
                            placeholder="Tulis isi pengumuman..."
                            class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm resize-y focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent"
                        ></textarea>
                    </div>
                    <div>
                        <label for="audience" class="block text-sm font-medium text-gray-700 mb-1">Audience</label>
                        <select
                            id="audience" name="audience" required
                            class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent"
                        >
                            <option value="all">Semua</option>
                            <option value="admin">Admin</option>
                            <option value="dosen">Dosen</option>
                            <option value="mahasiswa">Mahasiswa</option>
                        </select>
                    </div>
                    <div class="flex items-center justify-end gap-3 pt-2">
                        <button
                            type="button"
                            onclick="document.getElementById('modalTambah').classList.add('hidden')"
                            class="px-4 py-2 text-sm font-medium text-gray-600 hover:text-gray-800 transition-colors"
                        >
                            Batal
                        </button>
                        <button
                            type="submit"
                            class="bg-indigo-600 hover:bg-indigo-700 text-white text-sm font-medium px-5 py-2 rounded-lg transition-colors"
                        >
                            Simpan
                        </button>
                    </div>
                </form>
            </div>
        </div>
        @endif

        {{-- List Pengumuman --}}
        @forelse($announcements as $announcement)
            <div class="bg-white border border-gray-200 rounded-xl p-5 mb-4 shadow-sm hover:shadow-md transition-shadow">
                <div class="flex items-start justify-between gap-4">
                    <div class="flex-1 min-w-0">
                        <div class="flex items-center gap-2 mb-1">
                            <h3 class="text-base font-semibold text-gray-900 truncate">
                                <a href="{{ route('announcements.show', $announcement->id) }}" class="hover:text-indigo-600 transition-colors">
                                    {{ $announcement->title }}
                                </a>
                            </h3>
                            @php
                                $badgeColors = [
                                    'all' => 'bg-blue-100 text-blue-700',
                                    'admin' => 'bg-red-100 text-red-700',
                                    'dosen' => 'bg-green-100 text-green-700',
                                    'mahasiswa' => 'bg-amber-100 text-amber-700',
                                ];
                                $color = $badgeColors[$announcement->audience] ?? 'bg-gray-100 text-gray-700';
                            @endphp
                            <span class="shrink-0 inline-block text-xs font-medium px-2.5 py-0.5 rounded-full {{ $color }}">
                                {{ ucfirst($announcement->audience) }}
                            </span>
                        </div>
                        <p class="text-xs text-gray-400 mb-3">
                            {{ $announcement->published_at->format('d M Y H:i') }}
                        </p>
                        <p class="text-sm text-gray-600 leading-relaxed">
                            {{ Str::limit($announcement->content, 200) }}
                            @if(strlen($announcement->content) > 200)
                                <a 
                                    href="{{ route('announcements.show', $announcement->id) }}"
                                    class="text-indigo-600 hover:text-indigo-800 text-xs font-semibold ml-1"
                                >
                                    Baca Selengkapnya
                                </a>
                            @endif
                        </p>
                    </div>
                    @if(Auth::user()->role === 'admin')
                    <div class="flex items-center gap-2 shrink-0">
                        <button
                            type="button"
                            class="edit-btn text-gray-400 hover:text-indigo-600 transition-colors p-1"
                            title="Edit pengumuman"
                            data-id="{{ $announcement->id }}"
                            data-title="{{ $announcement->title }}"
                            data-content="{{ $announcement->content }}"
                            data-audience="{{ $announcement->audience }}"
                            data-action="{{ route('announcements.update', $announcement->id) }}"
                        >
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z" />
                            </svg>
                        </button>
                        <form
                            action="{{ route('announcements.destroy', $announcement->id) }}"
                            method="POST"
                            onsubmit="return confirm('Yakin ingin menghapus pengumuman ini?')"
                            class="inline"
                        >
                            @csrf
                            @method('DELETE')
                            <button
                                type="submit"
                                class="text-gray-400 hover:text-red-500 transition-colors p-1"
                                title="Hapus pengumuman"
                            >
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                </svg>
                            </button>
                        </form>
                    </div>
                    @endif
                </div>
            </div>
        @empty
            <div class="text-center py-16">
                <p class="text-gray-400 text-sm">Belum ada pengumuman.</p>
            </div>
        @endforelse

        {{-- Pagination --}}
        <div class="mt-6">
            {{ $announcements->links() }}
        </div>
    </div>

    <!-- Modal Form Edit -->
    @if(Auth::user()->role === 'admin')
    <div id="modalEdit" class="hidden fixed inset-0 z-50 flex items-center justify-center">
        <div class="absolute inset-0 bg-black/40" onclick="document.getElementById('modalEdit').classList.add('hidden')"></div>
        <div class="relative bg-white rounded-xl shadow-xl w-full max-w-lg mx-4 p-6">
            <div class="flex items-center justify-between mb-5">
                <h2 class="text-lg font-semibold text-gray-900">Edit Pengumuman</h2>
                <button
                    onclick="document.getElementById('modalEdit').classList.add('hidden')"
                    class="text-gray-400 hover:text-gray-600 transition-colors focus:outline-none"
                >
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
            <form id="editForm" action="" method="POST" class="space-y-4">
                @csrf
                @method('PUT')
                <div>
                    <label for="edit_title" class="block text-sm font-medium text-gray-700 mb-1">Judul</label>
                    <input
                        type="text" id="edit_title" name="title" required maxlength="255"
                        placeholder="Masukkan judul pengumuman"
                        class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent"
                    >
                </div>
                <div>
                    <label for="edit_content" class="block text-sm font-medium text-gray-700 mb-1">Isi Pengumuman</label>
                    <textarea
                        id="edit_content" name="content" required rows="4"
                        placeholder="Tulis isi pengumuman..."
                        class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm resize-y focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent"
                    ></textarea>
                </div>
                <div>
                    <label for="edit_audience" class="block text-sm font-medium text-gray-700 mb-1">Audience</label>
                    <select
                        id="edit_audience" name="audience" required
                        class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent"
                    >
                        <option value="all">Semua</option>
                        <option value="admin">Admin</option>
                        <option value="dosen">Dosen</option>
                        <option value="mahasiswa">Mahasiswa</option>
                    </select>
                </div>
                <div class="flex items-center justify-end gap-3 pt-2">
                    <button
                        type="button"
                        onclick="document.getElementById('modalEdit').classList.add('hidden')"
                        class="px-4 py-2 text-sm font-medium text-gray-600 hover:text-gray-800 transition-colors"
                    >
                        Batal
                    </button>
                    <button
                        type="submit"
                        class="bg-indigo-600 hover:bg-indigo-700 text-white text-sm font-medium px-5 py-2 rounded-lg transition-colors"
                    >
                        Simpan Perubahan
                    </button>
                </div>
            </form>
        </div>
    </div>
    @endif

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const editButtons = document.querySelectorAll('.edit-btn');
            const modalEdit = document.getElementById('modalEdit');
            const editForm = document.getElementById('editForm');
            const editTitle = document.getElementById('edit_title');
            const editContent = document.getElementById('edit_content');
            const editAudience = document.getElementById('edit_audience');

            editButtons.forEach(button => {
                button.addEventListener('click', function () {
                    const id = this.getAttribute('data-id');
                    const title = this.getAttribute('data-title');
                    const content = this.getAttribute('data-content');
                    const audience = this.getAttribute('data-audience');
                    const action = this.getAttribute('data-action');

                    editForm.action = action;
                    editTitle.value = title;
                    editContent.value = content;
                    editAudience.value = audience;

                    modalEdit.classList.remove('hidden');
                });
            });
        });
    </script>
@endsection
