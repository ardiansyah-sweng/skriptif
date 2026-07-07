<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Data Dosen</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body { font-family: 'Inter', sans-serif; background-color: #f8fafc; color: #334155; }
        .main-title { font-size: 24px; font-weight: 700; color: #0f172a; }
        .sub-title { font-size: 14px; color: #64748b; margin-top: 4px; }
        .content-card { background: #ffffff; border-radius: 12px; border: 1px solid #e2e8f0; box-shadow: 0 1px 3px 0 rgba(0,0,0,0.05); }
        .card-header-custom { padding: 20px 24px; border-bottom: 1px solid #e2e8f0; border-top-left-radius: 12px; border-top-right-radius: 12px; }
        .table-custom th { font-size: 12px; font-weight: 600; text-transform: uppercase; letter-spacing: 0.05em; color: #64748b; background-color: #f8fafc; border-bottom: 1px solid #e2e8f0; padding: 14px 20px; }
        .table-custom td { font-size: 14px; color: #334155; padding: 16px 20px; border-bottom: 1px solid #e2e8f0; vertical-align: middle; }
        .meta-text { font-size: 12px; color: #64748b; }
        .btn-detail-action { background-color: #64748b; color: white; font-size: 13px; font-weight: 500; border-radius: 6px; padding: 6px 14px; border: none; text-decoration: none; }
        .btn-detail-action:hover { background-color: #475569; color: white; }
        .btn-edit-action { background-color: #3b82f6; color: white; font-size: 13px; font-weight: 500; border-radius: 6px; padding: 6px 14px; border: none; text-decoration: none; }
        .btn-edit-action:hover { background-color: #2563eb; color: white; }
        .btn-delete-action { background-color: #ef4444; color: white; font-size: 13px; font-weight: 500; border-radius: 6px; padding: 6px 14px; border: none; }
        .btn-delete-action:hover { background-color: #dc2626; color: white; }
        .search-input { border: 1px solid #e2e8f0; border-radius: 8px; padding: 8px 14px; font-size: 14px; width: 280px; }
        .search-input:focus { outline: none; border-color: #3b82f6; box-shadow: 0 0 0 3px rgba(59,130,246,0.1); }
        .pagination-bar { padding: 14px 24px; display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 12px; border-bottom-left-radius: 12px; border-bottom-right-radius: 12px; }
        .page-size-select { border: 1px solid #e2e8f0; border-radius: 6px; padding: 4px 8px; font-size: 14px; color: #334155; }
        .page-size-select:focus { outline: none; border-color: #3b82f6; }
        .page-btn { border: 1px solid #e2e8f0; background: #fff; color: #334155; font-size: 13px; font-weight: 500; border-radius: 6px; padding: 5px 12px; }
        .page-btn:hover:not(:disabled) { background-color: #f1f5f9; }
        .page-btn:disabled { opacity: 0.5; cursor: not-allowed; }
        .page-btn.active { background-color: #3b82f6; border-color: #3b82f6; color: #fff; }
        .btn-print-action { background-color: #ef4444; color: white; font-size: 13px; font-weight: 500; border-radius: 6px; padding: 6px 14px; border: none; text-decoration: none; }
        .btn-print-action:hover { background-color: #dc2626; color: white; }
    </style>
</head>
<body>
    <div class="container py-5" style="max-width: 1200px;">

        <div class="crumb mb-3">
            <i class="fa-solid fa-house"></i>
            <a href="{{ route('dashboard') }}" style="color:#64748b;text-decoration:none">Dashboard</a>
            <i class="fa-solid fa-chevron-right" style="font-size:8px"></i>
            <span class="fw-semibold" style="color:#0f172a;">Data Dosen</span>
        </div>

        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show mb-4">
                <i class="fa-solid fa-circle-check me-2"></i> {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        @if($errors->any())
            <div class="alert alert-danger alert-dismissible fade show mb-4">
                <i class="fa-solid fa-circle-xmark me-2"></i> <strong>Terjadi kesalahan:</strong>
                <ul class="mb-0 mt-1">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        <div class="d-flex justify-content-between align-items-start mb-4">
            <div>
                <h1 class="main-title">Data Dosen</h1>
                <p class="sub-title">Kelola data dosen yang terdaftar dalam sistem.</p>
            </div>
            <div class="d-flex gap-2 align-items-center">
                <a href="{{ route('dashboard') }}" class="btn btn-outline-secondary btn-sm d-flex align-items-center gap-1" style="font-size:13px;font-weight:500;padding:8px 16px;border-radius:8px;text-decoration:none">
                    <i class="fa-solid fa-arrow-left"></i> Dashboard
                </a>
                <input type="text" id="q" class="search-input" placeholder="Cari nama dosen..." oninput="filterTable()">
            </div>
        </div>

        <div class="content-card">
            <div class="card-header-custom d-flex justify-content-between align-items-center">
                <div class="d-flex align-items-center gap-3">
                    <span class="fw-bold text-dark">Daftar Dosen</span>
                    <div class="d-flex align-items-center gap-2">
                        <span class="meta-text">Show</span>
                        <select id="pageSize" class="page-size-select" onchange="changePageSize()">
                            <option value="10">10</option>
                            <option value="25">25</option>
                            <option value="50">50</option>
                            <option value="100">100</option>
                        </select>
                        <span class="meta-text">entries</span>
                    </div>
                    <a href="{{ route('lecturers.print') }}" target="_blank" class="btn-print-action">
                        <i class="fa-solid fa-file-pdf"></i> Cetak PDF
                    </a>
                </div>
                <span class="meta-text"><i class="fa-solid fa-users me-1"></i> {{ $lecturers->count() }} dosen terdaftar</span>
            </div>

            <div class="table-responsive">
                <table class="table table-custom mb-0">
                    <thead>
                        <tr>
                            <th style="width: 5%">No</th>
                            <th style="width: 22%">Dosen / ID</th>
                            <th style="width: 18%">Email</th>
                            <th style="width: 25%">Keahlian</th>
                            <th style="width: 30%" class="text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody id="tbody">
                        @forelse($lecturers as $index => $lecturer)
                        <tr>
                            <td>{{ $index + 1 }}</td>
                            <td>
                                <div class="fw-bold lecturer-name">{{ $lecturer->name }}</div>
                                <div class="meta-text">ID. {{ $lecturer->lecturer_id }}</div>
                            </td>
                            <td>
                                <div class="meta-text">
                                    <i class="fa-solid fa-envelope me-1"></i> {{ $lecturer->email }}
                                </div>
                            </td>
                            <td>
                                <div class="meta-text">{{ $lecturer->expertise ?? '-' }}</div>
                            </td>
                            <td class="text-center">
                                <div class="d-flex justify-content-center gap-2">
                                    <a href="{{ route('lecturers.show', $lecturer->id) }}" class="btn-detail-action">
                                        <i class="fa-solid fa-eye"></i> Detail
                                    </a>
                                    <a href="{{ route('lecturers.edit', $lecturer->id) }}" class="btn-edit-action">
                                        <i class="fa-solid fa-pen-to-square"></i> Edit
                                    </a>
                                    <form action="{{ route('lecturers.destroy', $lecturer->id) }}" method="POST" onsubmit="return confirm('Hapus dosen ini?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn-delete-action">
                                            <i class="fa-solid fa-trash"></i> Hapus
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="5" class="text-center py-5 text-muted">
                                <i class="fa-regular fa-folder-open d-block mb-2" style="font-size: 24px;"></i>
                                Tidak ada data dosen.
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="pagination-bar justify-content-end">
                <div id="paginationControls" class="d-flex align-items-center gap-2"></div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        const allRows = Array.from(document.querySelectorAll('#tbody tr')).filter(r => r.querySelector('.lecturer-name'));
        let currentPage = 1;
        let pageSize = 10;

        function filterTable() {
            currentPage = 1;
            renderTable();
        }

        function changePageSize() {
            pageSize = parseInt(document.getElementById('pageSize').value, 10);
            currentPage = 1;
            renderTable();
        }

        function getFilteredRows() {
            const q = document.getElementById('q').value.toLowerCase();
            return allRows.filter(r => r.querySelector('.lecturer-name').textContent.toLowerCase().includes(q));
        }

        function renderTable() {
            const filteredRows = getFilteredRows();
            const totalPages = Math.max(1, Math.ceil(filteredRows.length / pageSize));
            currentPage = Math.min(currentPage, totalPages);

            const start = (currentPage - 1) * pageSize;
            const end = start + pageSize;
            const visible = new Set(filteredRows.slice(start, end));

            allRows.forEach(r => { r.style.display = visible.has(r) ? '' : 'none'; });

            renderPaginationControls(totalPages);
        }

        function renderPaginationControls(totalPages) {
            const container = document.getElementById('paginationControls');
            container.innerHTML = '';

            const prevBtn = document.createElement('button');
            prevBtn.type = 'button';
            prevBtn.className = 'page-btn';
            prevBtn.textContent = 'Previous';
            prevBtn.disabled = currentPage === 1;
            prevBtn.onclick = () => { currentPage--; renderTable(); };
            container.appendChild(prevBtn);

            for (let p = 1; p <= totalPages; p++) {
                const btn = document.createElement('button');
                btn.type = 'button';
                btn.className = 'page-btn' + (p === currentPage ? ' active' : '');
                btn.textContent = p;
                btn.onclick = () => { currentPage = p; renderTable(); };
                container.appendChild(btn);
            }

            const nextBtn = document.createElement('button');
            nextBtn.type = 'button';
            nextBtn.className = 'page-btn';
            nextBtn.textContent = 'Next';
            nextBtn.disabled = currentPage === totalPages;
            nextBtn.onclick = () => { currentPage++; renderTable(); };
            container.appendChild(nextBtn);
        }

        renderTable();
    </script>
</body>
</html>
