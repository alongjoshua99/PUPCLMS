@extends('AMS.backend.layouts.master')

@section('sidebar')
    <aside id="sidebar" class="sidebar">

        <ul class="sidebar-nav" id="sidebar-nav">

            <li class="nav-item">
                <a class="nav-link {{ Route::is('faculty.dashboard.index') ? 'active' : '' }}"
                    href="{{ route('faculty.dashboard.index') }}">
                    <i class="bi bi-grid"></i>
                    <span>Dashboard</span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link {{ Route::is('faculty.seat-plan.index') ? 'active' : '' }}"
                    href="{{ route('faculty.seat-plan.index') }}">
                    <i class="bi bi-laptop"></i>
                    <span>Seat Plan</span>
                </a>
            </li>
            <!-- End Dashboard Nav -->

            <li class="nav-item">
                <a class="nav-link collapsed" data-bs-target="#facultyReports" data-bs-toggle="collapse" href="#">
                    <i class="ri-booklet-line"></i><span>Reports</span><i class="bi bi-chevron-down ms-auto"></i>
                </a>
                <ul id="facultyReports" class="nav-content collapse p-2" data-bs-parent="#sidebar-nav">
                    <li>
                        <a href="{{ route('faculty.report.attendance.index') }}">
                            <i class="bi bi-circle"></i>
                            <span>Attendance Log</span>
                        </a>
                </ul>

            </li>

            <li class="nav-item">
                <a class="nav-link {{ Route::is('faculty.schedule.*') ? 'active' : '' }}"
                    href="{{ route('faculty.schedule.index') }}">
                    <i class="ri-calendar-todo-line"></i>
                    <span>Schedule</span>
                </a>
            </li>

    </aside>
@endsection
