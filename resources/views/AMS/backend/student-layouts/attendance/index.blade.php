@extends('AMS.backend.student-layouts.sidebar')

@section('page-title')
    Attendance - For {{ date('F d, Y', strtotime(now())) }}
@endsection

@section('contents')
    <section class="section">
        <div class="col-12">
            {{-- generate a card with button of "take attendance" in the middle --}}
            <div class="card">
                <div class="card-header d-flex justify-content-between border-bottom-0">
                    <h3 class="text-maroon">@yield('page-title')</h3>
                </div>
                <div class="card-body">

                    <!-- Table with stripped rows -->
                    <table class="table" id="courses-table">
                        <thead>
                            <tr>
                                <th scope="col">Subject</th>
                                <th scope="col">Teacher</th>
                                <th scope="col">Scheduled time</th>
                                <th scope="col">Time In</th>
                                <th scope="col">Time Out</th>
                                <th scope="col">Remark</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($schedules as $schedule)
                                <tr>

                                    <td>
                                        {{ $schedule->subject->subject_name }}
                                    </td>
                                    <td>
                                        {{ $schedule->teacher->full_name }}
                                    </td>
                                    <td>
                                        @php
                                            $time = $schedule->getTime();
                                        @endphp
                                        {{ date('h:i A', strtotime($time->start_time)) }}
                                        -
                                        {{ date('h:i A', strtotime($time->end_time)) }}
                                    </td>
                                    <td>
                                        @if (checkIfStudentAlreadyTimeIn($schedule, Auth::user()->student->id))
                                            {{ date('h:i A', strtotime(checkIfStudentAlreadyTimeIn($schedule, Auth::user()->student->id)->time_in)) }}
                                        @endif
                                    </td>
                                    <td>
                                        @if (checkIfStudentAlreadyTimeOut($schedule, Auth::user()->student->id))
                                            {{ date('h:i A', strtotime(checkIfStudentAlreadyTimeOut($schedule, Auth::user()->student->id)->time_out)) }}
                                        @endif
                                    </td>
                                    <td>
                                        @if (checkIfStudentAlreadyTimeIn($schedule, Auth::user()->student->id))
                                            {{ checkIfStudentAlreadyTimeIn($schedule, Auth::user()->student->id)->remarks }}
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                    <!-- End Table with stripped rows -->

                </div>
            </div>
        </div>
    </section>
@endsection
