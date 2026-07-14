@extends('layouts.app')

@section('title', 'Submit Thesis Proposal')

@section('content')
    <div class="wrap">
        <div class="page-head">
            <div>
                <div class="crumb">
                    <i class="ti ti-home" style="font-size:11px"></i>
                    <a href="{{ route('dashboard') }}" style="color:#9ca3af;text-decoration:none">Home</a>
                    <i class="ti ti-chevron-right" style="font-size:11px"></i>
                    <span>Submit Thesis</span>
                </div>
                <h1>Submit Thesis Proposal</h1>
                <p>Fill out the form below to submit your thesis proposal</p>
            </div>
            <a href="{{ route('dashboard') }}" class="btn-primary" style="background:transparent;color:#6b7280;border:0.5px solid #e5e7eb">
                <i class="ti ti-arrow-left"></i> Dashboard
            </a>
        </div>

        <form action="{{ route('student.skripsi.store') }}" method="POST">
            @csrf

            <div class="card">
                <div class="card-title">Thesis Information</div>

                <div class="form-group">
                    <label for="title">Thesis Title</label>
                    <input type="text" id="title" name="title" placeholder="Example: Advisor recommendation system based on topic similarity" required>
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
                <a href="{{ route('dashboard') }}" class="btn-secondary">Cancel</a>
                <button type="submit" class="btn-primary">
                    <i class="ti ti-send"></i> Submit
                </button>
            </div>
        </form>
    </div>
@endsection

@push('styles')
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@tabler/icons-webfont@latest/tabler-icons.min.css">
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
</style>
@endpush

@push('scripts')
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
</script>
@endpush