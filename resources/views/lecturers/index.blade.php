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
        body {
            font-family: 'Inter', sans-serif;
            background-color: #f8fafc;
            color: #334155;
        }

        .main-title {
            font-size: 24px;
            font-weight: 700;
            color: #0f172a;
        }

        .sub-title {
            font-size: 14px;
            color: #64748b;
            margin-top: 4px;
        }

        .content-card {
            background: #ffffff;
            border-radius: 12px;
            border: 1px solid #e2e8f0;
            box-shadow: 0 1px 3px 0 rgba(0, 0, 0, 0.05);
        }

        .card-header-custom {
            padding: 20px 24px;
            border-bottom: 1px solid #e2e8f0;
            border-top-left-radius: 12px;
            border-top-right-radius: 12px;
        }

        .table-custom th {
            font-size: 12px;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.05em;
            color: #64748b;
            background-color: #f8fafc;
            border-bottom: 1px solid #e2e8f0;
            padding: 14px 20px;
        }

        .table-custom td {
            font-size: 14px;
            color: #334155;
            padding: 16px 20px;
            border-bottom: 1px solid #e2e8f0;
            vertical-align: middle;
        }

        .meta-text {
            font-size: 12px;
            color: #64748b;
        }

        .btn-detail-action {
            background-color: #64748b;
            color: white;
            font-size: 13px;
            font-weight: 500;
            border-radius: 6px;
            padding: 6px 14px;
            border: none;
            text-decoration: none;
        }

        .btn-detail-action:hover {
            background-color: #475569;
            color: white;
        }

        .btn-edit-action {
            background-color: #3b82f6;
            color: white;
            font-size: 13px;
            font-weight: 500;
            border-radius: 6px;
            padding: 6px 14px;
            border: none;
            text-decoration: none;
        }

        .btn-edit-action:hover {
            background-color: #2563eb;
            color: white;
        }

        .btn-delete-action {
            background-color: #ef4444;
            color: white;
            font-size: 13px;
            font-weight: 500;
            border-radius: 6px;
            padding: 6px 14px;
            border: none;
        }

        .btn-delete-action:hover {
            background-color: #dc2626;
            color: white;
        }

        .search-input {
            border: 1px solid #e2e8f0;
            border-radius: 8px;
            padding: 8px 14px;
            font-size: 14px;
            width: 280px;
        }

        .search-input:focus {
            outline: none;
            border-color: #3b82f6;
            box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.1);
        }

        .pagination-bar {
            padding: 14px 24px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            flex-wrap: wrap;
            gap: 12px;
            border-bottom-left-radius: 12px;
            border-bottom-right-radius: 12px;
        }

        .page-size-select {
            border: 1px solid #e2e8f0;
            border-radius: 6px;
            padding: 4px 8px;
            font-size: 14px;
            color: #334155;
        }

        .page-size-select:focus {
            outline: none;
            border-color: #3b82f6;
        }

        .page-btn {
            border: 1px solid #e2e8f0;
            background: #fff;
            color: #334155;
            font-size: 13px;
            font-weight: 500;
            border-radius: 6px;
            padding: 5px 12px;
        }

        .page-btn:hover:not(:disabled) {
            background-color: #f1f5f9;
        }

        .page-btn:disabled {
            opacity: 0.5;
            cursor: not-allowed;
        }

        .page-btn.active {
            background-color: #3b82f6;
            border-color: #3b82f6;
            color: #fff;
        }

        .btn-print-action {
            background-color: #ef4444;
            color: white;
            font-size: 13px;
            font-weight: 500;
            border-radius: 6px;
            padding: 6px 14px;
            border: none;
            text-decoration: none;
        }

        .btn-print-action:hover {
            background-color: #dc2626;
            color: white;
        }

        .import-modal-overlay {
            position: fixed;
            inset: 0;
            z-index: 1050;
            background: rgba(15, 23, 42, 0.55);
            backdrop-filter: blur(4px);
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 24px;
        }

        .import-modal-card {
            width: 100%;
            max-width: 520px;
            background: #ffffff;
            border-radius: 28px;
            box-shadow: 0 28px 80px rgba(15, 23, 42, 0.16);
            overflow: hidden;
        }
        .import-modal-header {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            padding: 28px 28px 18px;
            border-bottom: 1px solid #e5e7eb;
        }

        .import-modal-header h2 {
            margin: 0;
            font-size: 24px;
        }

        .import-modal-header p {
            margin: 8px 0 0;
            color: #475569;
            font-size: 14px;
        }

        .import-modal-close {
            border: none;
            background: #f8fafc;
            color: #475569;
            width: 36px;
            height: 36px;
            border-radius: 999px;
            cursor: pointer;
            font-size: 22px;
            line-height: 1;
        }
        .import-modal-body {
            padding: 24px 28px;
        }

        .import-modal-body input[type="file"] {
            width: 100%;
            padding: 12px 14px;
            border: 1px solid #cbd5e1;
            border-radius: 12px;
            background: #f8fafc;
            font-size: 14px;
        }

        .import-label {
            display: block;
            margin-bottom: 12px;
            font-weight: 600;
            color: #0f172a;
        }

        .import-hint {
            margin-top: 10px;
            font-size: 13px;
            color: #64748b;
        }

        .import-modal-footer {
            padding: 20px 28px 28px;
            display: flex;
            justify-content: flex-end;
            gap: 12px;
            background: #f8fafc;
        }

        .import-modal-footer .btn {
            min-width: 140px;
        }
    </style>
</head>

<body>
    <div class="container py-5" style="max-width: 1200px;">

        @if (session('success'))
            <div class="alert alert-success alert-dismissible fade show mb-4">
                <i class="fa-solid fa-circle-check me-2"></i> {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        @if ($errors->any())
            <div class="alert alert-danger alert-dismissible fade show mb-4">
                <i class="fa-solid fa-circle-xmark me-2"></i> <strong>Terjadi kesalahan:</strong>
                <ul class="mb-0 mt-1">
                    @foreach ($errors->all() as $error)
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
            <div class="d-flex gap-2">
                <input type="text" id="q" class="search-input" placeholder="Cari nama dosen..."
                    oninput="filterTable()">
                <a href="{{ route('lecturers.create') }}" class="btn btn-primary d-flex align-items-center"
                    style="border-radius: 8px; font-size: 14px; font-weight: 500; padding: 8px 16px;">
                    <i class="fa-solid fa-plus me-2"></i> Tambah Dosen
                </a>
                <button type="button" id="openImportModal" class="btn btn-secondary">
                    <i class="fa-solid fa-file-csv me-2"></i> Import CSV
                </button>
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
                <span class="meta-text"><i class="fa-solid fa-users me-1"></i> {{ $lecturers->count() }} dosen
                    terdaftar</span>
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
                                        <a href="{{ route('lecturers.show', $lecturer->id) }}"
                                            class="btn-detail-action">
                                            <i class="fa-solid fa-eye"></i> Detail
                                        </a>
                                        <a href="{{ route('lecturers.edit', $lecturer->id) }}" class="btn-edit-action">
                                            <i class="fa-solid fa-pen-to-square"></i> Edit
                                        </a>
                                        <form action="{{ route('lecturers.destroy', $lecturer->id) }}" method="POST"
                                            onsubmit="return confirm('Hapus dosen ini?')">
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
    
    <div id="importModal" class="import-modal-overlay" style="display: none;">
        <div class="import-modal-card">
            <div class="import-modal-header">
                <div>
                    <h2>Import Dosen</h2>
                    <p>Pilih file CSV (.csv) untuk menambah atau memperbarui data dosen.</p>
                </div>
                <button type="button" id="closeImportModal" class="import-modal-close">&times;</button>
            </div>

            <form action="{{ route('lecturers.import') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="import-modal-body">
                    <label class="import-label" for="import_file">Pilih File CSV (.csv)</label>
                    <input id="import_file" type="file" name="file" accept=".csv,text/csv" required>
                    <p class="import-hint">Header yang dibutuhkan: lecturer_id, name, email, expertise, max_supervisors</p>
                </div>

                <div class="import-modal-footer">
                    <button type="button" id="closeImportModal2" class="btn btn-light">Batal</button>
                    <button type="submit" class="btn btn-primary">
                        <i class="fa-solid fa-upload me-2"></i> Proses Import
                    </button>
                </div>
            </form>
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

            allRows.forEach(r => {
                r.style.display = visible.has(r) ? '' : 'none';
            });

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
            prevBtn.onclick = () => {
                currentPage--;
                renderTable();
            };
            container.appendChild(prevBtn);

            for (let p = 1; p <= totalPages; p++) {
                const btn = document.createElement('button');
                btn.type = 'button';
                btn.className = 'page-btn' + (p === currentPage ? ' active' : '');
                btn.textContent = p;
                btn.onclick = () => {
                    currentPage = p;
                    renderTable();
                };
                container.appendChild(btn);
            }

            const nextBtn = document.createElement('button');
            nextBtn.type = 'button';
            nextBtn.className = 'page-btn';
            nextBtn.textContent = 'Next';
            nextBtn.disabled = currentPage === totalPages;
            nextBtn.onclick = () => {
                currentPage++;
                renderTable();
            };
            container.appendChild(nextBtn);
        }

        renderTable();

        const openImportModal = document.getElementById('openImportModal');
        const closeImportModalButtons = document.querySelectorAll('#closeImportModal, #closeImportModal2');
        const importModal = document.getElementById('importModal');

        if (openImportModal) {
            openImportModal.addEventListener('click', () => {
                importModal.style.display = 'flex';
            });
        }

        closeImportModalButtons.forEach(button => {
            button.addEventListener('click', () => {
                importModal.style.display = 'none';
            });
        });

        importModal.addEventListener('click', (event) => {
            if (event.target === importModal) {
                importModal.style.display = 'none';
            }
        });
        </script>
</body>

</html>
