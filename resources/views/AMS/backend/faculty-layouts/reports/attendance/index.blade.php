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
                                    <th scope="col">#</th>
                                    <th scope="col">Section</th>
                                    <th scope="col">Subject</th>
                                    <th scope="col">Dates</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($schedules as $schedule)
                                    <tr>
                                        <td>
                                            {{ $loop->index + 1 }}
                                        </td>
                                        <td>
                                            {{ $schedule->section->section_name }}
                                        </td>
                                        <td>
                                            {{ $schedule->subject->subject_name }}
                                        </td>
                                        <td>
                                            <div class="dropdown">
                                                <button class="btn btn-outline-maroon dropdown-toggle" type="button"
                                                    id="dropdownMenuButton1" data-bs-toggle="dropdown" aria-expanded="false">
                                                    Dates
                                                </button>
                                                <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton1">
                                                    @foreach ($schedule->scheduleDates as $schedule_date)
                                                        <li><a class="dropdown-item"
                                                                href="{{ route('faculty.report.attendance.show', ['id' => $schedule->id, 'schedule_date_id' => $schedule_date->id]) }}">{{ date('F d, Y', strtotime($schedule_date->date)) }}</a>
                                                        </li>
                                                    @endforeach
                                                </ul>

                                            </div>
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
