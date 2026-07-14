<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $announcement->title }} - Detail Pengumuman</title>
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
</head>
<body class="bg-gray-50 font-sans text-gray-800 min-h-screen">

    <div class="max-w-3xl mx-auto px-4 py-10">
        {{-- Back Button --}}
        <div class="mb-6">
            <a 
                href="{{ route('announcements.index') }}" 
                class="inline-flex items-center gap-2 text-sm font-medium text-gray-500 hover:text-indigo-600 transition-colors"
            >
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                </svg>
                Kembali ke Pengumuman
            </a>
        </div>

        {{-- Detail Card --}}
        <div class="bg-white border border-gray-200 rounded-xl p-6 shadow-sm">
            <div class="border-b border-gray-100 pb-4 mb-6">
                @php
                    $badgeColors = [
                        'all' => 'bg-blue-100 text-blue-700',
                        'admin' => 'bg-red-100 text-red-700',
                        'dosen' => 'bg-green-100 text-green-700',
                        'mahasiswa' => 'bg-amber-100 text-amber-700',
                    ];
                    $color = $badgeColors[$announcement->audience] ?? 'bg-gray-100 text-gray-700';
                @endphp
                <span class="inline-block text-xs font-medium px-2.5 py-0.5 rounded-full mb-3 {{ $color }}">
                    Untuk: {{ ucfirst($announcement->audience) }}
                </span>
                
                <h1 class="text-2xl font-bold text-gray-900 leading-tight">
                    {{ $announcement->title }}
                </h1>
                
                <div class="flex items-center gap-2 mt-3 text-xs text-gray-400">
                    <span>Dipublikasikan pada:</span>
                    <span>{{ $announcement->published_at->format('d M Y H:i') }}</span>
                    @if($announcement->author)
                        <span class="text-gray-300">•</span>
                        <span>Oleh: {{ $announcement->author->name }}</span>
                    @endif
                </div>
            </div>

            {{-- Content --}}
            <div class="prose max-w-none text-gray-700 leading-relaxed text-sm whitespace-pre-wrap">
                {{ $announcement->content }}
            </div>
        </div>
    </div>

</body>
</html>
