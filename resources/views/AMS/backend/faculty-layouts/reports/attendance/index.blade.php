@extends('AMS.backend.faculty-layouts.sidebar')

@section('page-title')
    Attendance Logs
@endsection

@section('contents')
    <section class="section">
        <div class="row">
            <div class="col-lg-12">

                <div class="card">
                    <div class="card-header d-flex justify-content-between border-bottom-0">
                        <h3 class="text-maroon">@yield('page-title')</h3>

                    </div>
                    <div class="card-body">

                        <!-- Table with stripped rows -->
                        <table class="table" id="schedules-table">
                            <thead>
                                <tr>
                                    <th scope="col">Teacher</th>
                                    <th scope="col">Students</th>
                                    <th scope="col">Subject</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($schedules as $schedule)
                                    <tr>
                                        <td>
                                            {{ $schedule->teacher->full_name }}
                                        </td>
                                        <td>
                                            <a
                                                href="{{ route('faculty.report.attendance.show', ['id' => $schedule->id]) }}">{{ $schedule->section->section_name }}</a>
                                        </td>
                                        <td>
                                            {{ $schedule->subject->subject_name }}
                                        </td>

                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                        <!-- End Table with stripped rows -->

                    </div>
                </div>

            </div>
        </div>
    </section>
@endsection
@section('scripts')
    <script>
        $(document).ready(function() {
            $('#schedules-table').DataTable({
                "ordering": false

            });
        });
    </script>
@endsection
