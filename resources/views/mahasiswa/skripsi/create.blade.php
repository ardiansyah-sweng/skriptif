@extends('layouts.app')

@section('title', 'Submit Thesis Proposal')

@push('styles')
<style>
    .wrap { max-width: 900px; }
    .page-head { display: flex; justify-content: space-between; align-items: center; margin-bottom: 1.5rem; padding-bottom: 1.25rem; border-bottom: 0.5px solid #e5e7eb; }
    .crumb { font-size: 11px; color: #9ca3af; margin-bottom: 6px; display: flex; align-items: center; gap: 4px; }
    .page-head h1 { font-size: 18px; font-weight: 500; }
    .page-head p { font-size: 13px; color: #6b7280; margin-top: 3px; }
    .card { background: #fff; border: 0.5px solid #e5e7eb; border-radius: 12px; padding: 24px; margin-bottom: 16px; }
    .card-title { font-size: 13px; font-weight: 500; padding-bottom: 12px; margin-bottom: 16px; border-bottom: 0.5px solid #e5e7eb; }
    .form-group { margin-bottom: 16px; }
    .form-group label { display: block; font-size: 13px; font-weight: 500; margin-bottom: 6px; }
    .form-group input, .form-group select, .form-group textarea {
        width: 100%; padding: 9px 12px; border: 0.5px solid #d1d5db; border-radius: 8px;
        font-size: 13px; font-family: inherit; color: #1a1a2e; background: #fff; outline: none;
    }
    .form-group input:focus, .form-group select:focus, .form-group textarea:focus { border-color: #185FA5; }
    .form-hint { font-size: 12px; color: #9ca3af; margin-top: 5px; display: block; }
    .btn-primary { display: inline-flex; align-items: center; gap: 6px; padding: 9px 18px; background: #185FA5; color: #fff; border: none; border-radius: 8px; font-size: 13px; cursor: pointer; font-weight: 500; text-decoration: none; }
    .btn-primary:hover { background: #0C447C; }
    .btn-secondary { display: inline-flex; align-items: center; gap: 6px; padding: 9px 18px; background: transparent; color: #1a1a2e; border: 0.5px solid #e5e7eb; border-radius: 8px; font-size: 13px; cursor: pointer; font-weight: 500; text-decoration: none; }
    .btn-secondary:hover { background: #f9fafb; }
    .course-header { display: flex; gap: 8px; margin-bottom: 6px; }
    .course-header span { font-size: 13px; font-weight: 500; }
    .course-header .col-course { flex: 2; }
    .course-header .col-grade { flex: 1; }
    .course-header .col-spacer { width: 34px; flex-shrink: 0; }
    .course-row { display: flex; gap: 8px; align-items: center; margin-bottom: 8px; }
    .course-row select { flex: 2; }
    .course-row select.grade { flex: 1; }
    .btn-del { width: 34px; height: 34px; padding: 0; display: flex; align-items: center; justify-content: center; background: transparent; border: 0.5px solid #e5e7eb; border-radius: 6px; cursor: pointer; color: #A32D2D; flex-shrink: 0; }
    .btn-del:hover { background: #FCEBEB; border-color: #F09595; }
    @media (max-width: 600px) { .search-box { display: none; } }

    .reco-box {
            margin-top: 10px;
            padding: 14px;
            background: linear-gradient(135deg, #f0f6ff 0%, #f9fafb 100%);
            border: 0.5px solid #d7e6f7;
            border-radius: 10px;
            animation: recoFadeIn 0.25s ease;
        }
        .reco-box-title {
            font-size: 12px;
            font-weight: 600;
            color: #185FA5;
            display: flex;
            align-items: center;
            gap: 6px;
            margin-bottom: 10px;
        }
        .reco-list { display: flex; flex-direction: column; gap: 8px; }
        .reco-item {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 10px 12px;
            background: #fff;
            border: 0.5px solid #e5e7eb;
            border-radius: 8px;
            cursor: pointer;
            transition: all 0.15s ease;
        }
        .reco-item:hover {
            border-color: #185FA5;
            box-shadow: 0 2px 8px rgba(24,95,165,0.12);
            transform: translateY(-1px);
        }
        .reco-item.disabled { opacity: 0.5; cursor: not-allowed; }
        .reco-item.selected { border-color: #185FA5; background: #EAF2FB; }
        .reco-name { font-size: 13px; font-weight: 500; }
        .reco-match { font-size: 11px; color: #6b7280; margin-top: 4px; }
        .reco-match span {
            background: #EAF2FB;
            color: #185FA5;
            padding: 1px 6px;
            border-radius: 4px;
            margin-right: 4px;
            font-weight: 500;
            display: inline-block;
            margin-top: 2px;
        }
        .reco-capacity { font-size: 11px; font-weight: 600; color: #185FA5; white-space: nowrap; }
        .reco-capacity.full { color: #A32D2D; }

        @keyframes recoFadeIn {
            from { opacity: 0; transform: translateY(-4px); }
            to { opacity: 1; transform: translateY(0); }
        }
</style>
@endpush

@section('content')
    <div class="wrap">
        <div class="page-head">
            <div>
                <div class="crumb">
                    <i class="ti ti-home" style="font-size:11px"></i>
                    <span>Home</span>
                    <i class="ti ti-chevron-right" style="font-size:11px"></i>
                    <span>Submit Thesis</span>
                </div>
                <h1>Submit Thesis Proposal</h1>
                <p>Fill out the form below to submit your thesis proposal</p>
            </div>
        </div>

        <form action="{{ route('student.skripsi.store') }}" method="POST">
            @csrf

            <div class="card">
                <div class="card-title">Thesis Information</div>

                <div class="form-group">
                    <label for="title">Thesis Title</label>
                    <input type="text" id="title" name="title" placeholder="Example: Advisor recommendation system based on topic similarity" required autocomplete="off">

                    <div id="reco-box" class="reco-box" style="display:none;">
                        <div class="reco-box-title">
                            <i class="ti ti-sparkles"></i> Rekomendasi Dosen Berdasarkan Judul
                        </div>
                        <div id="reco-list" class="reco-list"></div>
                    </div>
                </div>

                <div class="form-group">
                    <label for="description">Short Description</label>
                    <textarea id="description" name="description" rows="4" placeholder="Briefly explain the background and objectives of the thesis..." required></textarea>
                </div>

                <div class="form-group">
                    <label for="supervisor_id">Preferred Advisor</label>
                    <select id="supervisor_id" name="supervisor_id">
                        <option value="">-- Select Advisor --</option>
                        @foreach($lecturersWithCapacity as $lecturer)
                            <option value="{{ $lecturer['id'] }}"
                                {{ old('supervisor_id') == $lecturer['id'] ? 'selected' : '' }}
                                {{ !$lecturer['is_available'] ? 'disabled' : '' }}>
                                {{ $lecturer['name'] }}
                                ({{ $lecturer['approved_count'] }}/{{ $lecturer['max_supervisors'] }} -
                                {{ $lecturer['remaining_capacity'] }} tersisa)
                                {{ !$lecturer['is_available'] ? '❌' : '' }}
                            </option>
                        @endforeach
                    </select>
                    <span class="form-hint">Menampilkan kapasitas dosen untuk angkatan Anda. Dosen yang sudah penuh ditandai ❌.</span>
                </div>

                <div class="form-group">
                    <label for="suggestion_supervisor">Other Proposed Advisors (Optional)</label>
                    <input type="text" id="suggestion_supervisor" name="suggestion_supervisor">
                    <span class="form-hint">This is only a proposal. The final decision rests with the department.</span>
                </div>
            </div>

            <div class="card">
                <div class="card-title">Elective Course History</div>

                <div class="course-header">
                    <span class="col-course">Course Name</span>
                    <span class="col-grade">Grade</span>
                    <div class="col-spacer"></div>
                </div>

                <div id="courses-wrap">
                    <div class="course-row">
                        <select name="elective_courses[0][id]" required>
                            <option value="">Select course</option>
                            @foreach($electiveCourses as $course)
                                <option value="{{ $course->id }}">{{ $course->courses }}</option>
                            @endforeach
                        </select>
                        <select name="elective_courses[0][grade]" class="grade" required>
                            <option value="A">A</option>
                            <option value="B">B</option>
                            <option value="C">C</option>
                            <option value="D">D</option>
                            <option value="E">E</option>
                        </select>
                        <button type="button" class="btn-del" onclick="removeRow(this)"><i class="ti ti-x" style="font-size:14px"></i></button>
                    </div>
                </div>

                <button type="button" class="btn-secondary" style="margin-top:4px;font-size:13px;padding:7px 14px;" onclick="addRow()">
                    <i class="ti ti-plus" style="font-size:14px"></i> Add Course
                </button>
            </div>

            <div style="display:flex;gap:8px; margin-top: 20px;">
                <a href="/student/dashboard" class="btn-secondary">Cancel</a>
                <button type="submit" class="btn-primary">
                    <i class="ti ti-send"></i> Submit
                </button>
            </div>
        </form>
    </div>

    <script>
        let rowCount = 1;

        function addRow() {
            const wrap = document.getElementById('courses-wrap');
            const div = document.createElement('div');
            div.className = 'course-row';
            div.innerHTML = `
                <select name="elective_courses[${rowCount}][id]" required>
                    <option value="">Select course</option>
                    @foreach($electiveCourses as $course)
                        <option value="{{ $course->id }}">{{ $course->courses }}</option>
                    @endforeach
                </select>
                <select name="elective_courses[${rowCount}][grade]" class="grade" required>
                    <option value="A">A</option>
                    <option value="B">B</option>
                    <option value="C">C</option>
                    <option value="D">D</option>
                    <option value="E">E</option>
                </select>
                <button type="button" class="btn-del" onclick="removeRow(this)"><i class="ti ti-x" style="font-size:14px"></i></button>
            `;
            wrap.appendChild(div);
            rowCount++;
        }

        function removeRow(btn) {
            const rows = document.querySelectorAll('.course-row');
            if (rows.length > 1) {
                btn.closest('.course-row').remove();
            }
        }


        const lecturersData = @json($lecturersWithCapacity);

        const titleInput = document.getElementById('title');
        const recoBox = document.getElementById('reco-box');
        const recoList = document.getElementById('reco-list');
        const supervisorSelect = document.getElementById('supervisor_id');

        let debounceTimer;
        titleInput.addEventListener('input', function () {
            clearTimeout(debounceTimer);
            debounceTimer = setTimeout(() => matchAdvisors(this.value), 350);
        });

        function matchAdvisors(title) {
            if (title.trim().length < 3) {
                recoBox.style.display = 'none';
                return;
            }

            const titleWords = title.toLowerCase().split(/\s+/).filter(w => w.length > 2);

            const scored = lecturersData
                .map(lect => {
                    const keywords = (lect.expertise || '')   // <-- ganti dari lect.keywords
                        .toLowerCase()
                        .split(',')
                        .map(k => k.trim())
                        .filter(Boolean);
                    const matched = keywords.filter(kw => titleWords.some(w => kw.includes(w) || w.includes(kw)));
                    return { ...lect, matched, score: matched.length };
                })
                .filter(l => l.score > 0)
                .sort((a, b) => b.score - a.score)
                .slice(0, 4);

            if (scored.length === 0) {
                recoBox.style.display = 'none';
                return;
            }

            renderReco(scored);
            recoBox.style.display = 'block';
        }

        function renderReco(items) {
            recoList.innerHTML = items.map(lect => `
                <div class="reco-item ${!lect.is_available ? 'disabled' : ''}" data-id="${lect.id}">
                    <div>
                        <div class="reco-name">${lect.name}</div>
                        <div class="reco-match">${lect.matched.map(m => `<span>${m}</span>`).join('')}</div>
                    </div>
                    <div class="reco-capacity ${!lect.is_available ? 'full' : ''}">
                        ${lect.approved_count}/${lect.max_supervisors}
                    </div>
                </div>
            `).join('');

            document.querySelectorAll('.reco-item').forEach(item => {
                item.addEventListener('click', function () {
                    if (this.classList.contains('disabled')) return;

                    supervisorSelect.value = this.dataset.id;
                    supervisorSelect.dispatchEvent(new Event('change'));

                    document.querySelectorAll('.reco-item').forEach(i => i.classList.remove('selected'));
                    this.classList.add('selected');
                });
            });
        }
    </script>
@endsection
