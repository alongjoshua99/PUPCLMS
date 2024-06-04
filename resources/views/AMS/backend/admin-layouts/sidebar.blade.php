@extends('AMS.backend.layouts.master')

@section('sidebar')
    <aside id="sidebar" class="sidebar">

        <ul class="sidebar-nav" id="sidebar-nav">

            <li class="nav-item">
                <a class="nav-link {{ Route::is('admin.dashboard.index') ? 'active' : '' }}"
                    href="{{ route('admin.dashboard.index') }}">
                    <i class="bi bi-grid"></i>
                    <span>Dashboard</span>
                </a>
            </li><!-- End Dashboard Nav -->

            <li class="nav-item">
                <a class="nav-link collapsed {{ Route::is('admin.academic.*') ? 'active' : '' }}" data-bs-target="#academics"
                    data-bs-toggle="collapse" href="#">
                    <i class="ri-book-open-line"></i>
                    <span>Academics</span>
                    <i class="bi bi-chevron-down ms-auto"></i>
                </a>
                <ul id="academics" class="nav-content collapse p-2" data-bs-parent="#sidebar-nav">
                    <li class="{{ Route::is('admin.academic.course.index') ? 'collapse-active' : '' }}">
                        <a href="{{ route('admin.academic.course.index') }}">
                            <i class="bi bi-circle"></i>
                            <span>Course</span>
                        </a>
                    </li>
                    <li class="{{ Route::is('admin.academic.section.index') ? 'collapse-active' : '' }}">
                        <a href="{{ route('admin.academic.section.index') }}">
                            <i class="bi bi-circle"></i>
                            <span>Section</span>
                        </a>
                    </li>
                    <li class="{{ Route::is('admin.academic.subject.index') ? 'collapse-active' : '' }}">
                        <a href="{{ route('admin.academic.subject.index') }}">
                            <i class="bi bi-circle"></i>
                            <span>Subject</span>
                        </a>
                    </li>

                </ul>

            </li>
            <li class="nav-item">
                <a class="nav-link collapsed {{ Route::is('admin.schedules.*') ? 'active' : '' }}" data-bs-target="#schedules"
                    data-bs-toggle="collapse" href="#">
                    <i class="ri-calendar-line"></i>
                    <span>Schedules</span>
                    <i class="bi bi-chevron-down ms-auto"></i>
                </a>
                <ul id="schedules" class="nav-content collapse p-2" data-bs-parent="#sidebar-nav">
                    <li class="{{ Route::is('admin.schedules.index') ? 'collapse-active' : '' }}">
                        <a href="{{ route('admin.schedules.index') }}">
                            <i class="bi bi-circle"></i>
                            <span>Schedule List</span>
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('admin.schedules.request.index') }}">
                            <i class="bi bi-circle"></i>
                            <span>Requests</span>
                        </a>
                    </li>

                </ul>

            </li>


            <li class="nav-item">
                <a class="nav-link {{ Route::is('admin.computer.index') ? 'active' : '' }}"
                    href="{{ route('admin.computer.index') }}">
                    <i class="ri-computer-line"></i>
                    <span>Computers</span>
                </a>

            </li>
            <li class="nav-item">
                <a class="nav-link {{ Route::is('admin.system-settings.index') ? 'active' : '' }}"
                    href="{{ route('admin.system-settings.index') }}">
                    <i class="ri-book-open-line"></i>
                    <span>System Settings</span>
                </a>

            </li>
            <li class="nav-item">
                <a class="nav-link {{ Route::is('admin.backups.index') ? 'active' : '' }}"
                    href="{{ route('admin.backups.index') }}">
                    <i class="ri-database-2-line"></i>
                    <span>Backups</span>
                </a>

            </li>
            <!-- End Components Nav -->

            {{--  <li class="nav-item">
                <a class="nav-link "  href="">
                    <i class="ri-history-line"></i><span>History</span>
                </a>

            </li> --}}
            <!-- End Forms Nav -->

            <li class="nav-item">
                <a class="nav-link collapsed" data-bs-target="#reports" data-bs-toggle="collapse" href="#">
                    <i class="ri-booklet-line"></i><span>Reports</span><i class="bi bi-chevron-down ms-auto"></i>
                </a>
                <ul id="reports" class="nav-content collapse p-2" data-bs-parent="#sidebar-nav">
                    <li>
                        <a href="{{ route('admin.report.attendance.index') }}">
                            <i class="bi bi-circle"></i>
                            <span>Attendance Log</span>
                        </a>
                    </li>
                    {{-- <li>
                        <a href="{{ route('admin.report.computer.index') }}">
                            <i class="bi bi-circle"></i>
                            <span>Computer Log</span>
                        </a>
                    </li> --}}


                </ul>

            </li>
            <!-- End Charts Nav -->
            <li class="nav-item">
                <a class="nav-link collapsed" data-bs-target="#user-dropdown" data-bs-toggle="collapse" href="#">
                    <i class="ri-booklet-line"></i>
                    <span>User - Informations</span>
                    <i class="bi bi-chevron-down ms-auto"></i>
                </a>
                <ul id="user-dropdown" class="nav-content collapse p-2" data-bs-parent="#sidebar-nav">
                    <li>
                        <a href="{{ route('admin.user.information.faculty.index') }}">
                            <i class="bi bi-circle"></i>
                            <span>Faculty Members</span>
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('admin.user.information.student.index') }}">
                            <i class="bi bi-circle"></i>
                            <span>Students</span>
                        </a>
                    </li>
                    {{-- <li>
                        <a href="{{ route('admin.user.information.master_list.index') }}">
                            <i class="bi bi-circle"></i>
                            <span>Student Master Lists</span>
                        </a>
                    </li> --}}
                </ul>
            </li>

            <li class="nav-item">
                <a class="nav-link collapsed" data-bs-target="#users" data-bs-toggle="collapse" href="#">
                    <i class="ri-user-settings-line"></i><span>User - Accounts</span><i class="bi bi-chevron-down ms-auto"></i>
                </a>
                <ul id="users" class="nav-content collapse p-2" data-bs-parent="#sidebar-nav">

                    <li>
                        <a href="{{ route('admin.user.account.faculty.index') }}">
                            <i class="bi bi-circle"></i><span>Faculty</span>
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('admin.user.account.student.index') }}">
                            <i class="bi bi-circle"></i><span>Student</span>
                        </a>
                    </li>
                </ul>

            </li><!-- End Icons Nav -->


    </aside>
@endsection
@section('scripts')

@endsection
