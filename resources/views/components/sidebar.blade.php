<div class="sidebar">
    <div class="sidebar-brand">
        <h3>Skriptif</h3>
        <small>Skripsi Management System</small>
    </div>
    <div class="sidebar-nav">
        <div class="nav-label">Menu Utama</div>
        <a href="{{ route('dashboard') }}" class="{{ request()->routeIs('dashboard') ? 'active' : '' }}">
            <i class="fa-solid fa-chart-pie"></i> Dashboard
        </a>
        <a href="{{ route('students.index') }}" class="{{ request()->routeIs('students.*') ? 'active' : '' }}">
            <i class="fa-solid fa-user-graduate"></i> Mahasiswa
        </a>
        <a href="{{ route('lecturers.index') }}" class="{{ request()->routeIs('lecturers.*') ? 'active' : '' }}">
            <i class="fa-solid fa-chalkboard-user"></i> Dosen
        </a>
        <a href="{{ route('skripsi.index') }}" class="{{ request()->routeIs('skripsi.*') ? 'active' : '' }}">
            <i class="fa-solid fa-book"></i> Skripsi
        </a>
        <a href="{{ route('log-books.index') }}" class="{{ request()->routeIs('log-books.*') ? 'active' : '' }}">
            <i class="fa-solid fa-clipboard-list"></i> Log Book
        </a>
        <a href="{{ route('exam-schedules.index') }}" class="{{ request()->routeIs('exam-schedules.*') ? 'active' : '' }}">
            <i class="fa-solid fa-calendar-check"></i> Jadwal Sidang
        </a>
        <a href="{{ route('elective-courses.index') }}" class="{{ request()->routeIs('elective-courses.*') ? 'active' : '' }}">
            <i class="fa-solid fa-layer-group"></i> MK Pilihan
        </a>

        <div class="nav-label">Mahasiswa</div>
        <a href="{{ route('student.skripsi.create') }}" class="{{ request()->routeIs('student.skripsi.create') ? 'active' : '' }}">
            <i class="fa-solid fa-file-circle-plus"></i> Ajukan Skripsi
        </a>
        <a href="{{ route('student.skripsi.history') }}" class="{{ request()->routeIs('student.skripsi.history') ? 'active' : '' }}">
            <i class="fa-solid fa-clock-rotate-left"></i> Riwayat
        </a>
    </div>
</div>
