@extends('AMS.backend.admin-layouts.sidebar')

@section('page-title')
    Dashboard
@endsection

@section('contents')
    <section class="section">
        <div class="row">
            <div class="col-12">
                <div class="card">

                    <div class="card-header">
                        <h5 class="mb-0">Schedules</h5>
                    </div>

                    <div class="card-body p-3">

                        <div id='calendar'></div>

                    </div>
                </div>


            </div>
            {{-- <div class="card top-selling overflow-auto">

                    <div class="filter">
                        <a class="icon" href="#" data-bs-toggle="dropdown"><i class="bi bi-three-dots"></i></a>
                        <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow">
                            <li class="dropdown-header text-start">
                                <h6>Filter</h6>
                            </li>

                            <li><a class="dropdown-item"
                                    href="{{ route('admin.dashboard.index',['filter' => 'today']) }}">Today</a></li>
                            <li><a class="dropdown-item"
                                    href="{{ route('admin.dashboard.index', ['filter' => 'week']) }}">This Week</a></li>
                            <li><a class="dropdown-item"
                                    href="{{ route('admin.dashboard.index', ['filter' => 'month']) }}">This Month</a></li>
                        </ul>
                    </div>

                    <div class="card-body pb-0" style="height: 40%">
                        <h5 class="card-title">Schedules <span>| {{ Str::ucfirst($filter) }}</span></h5>

                        <table class="table table-borderless">
                            <thead>
                                <tr>
                                    <th scope="col">Subject</th>
                                    <th scope="col">Section</th>
                                    <th scope="col">Date</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($schedules as $schedule)
                                    <tr>
                                        <td>
                                            wew
                                        </td>
                                        <td>
                                            test
                                        </td>

                                        <td>
                                            {{ date('F d, Y', strtotime($schedule->date)) }}
                                            <br>
                                            At {{ date('h:i:a', strtotime($schedule->start_time)) }} -
                                            {{ date('h:i:a', strtotime($schedule->end_time)) }}
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="3" class="text-center">
                                            No schedules for {{ $filter }}.
                                        </td>
                                @endforelse
                            </tbody>
                        </table>

                    </div>

                </div> --}}
        </div>
        </div>
    </section>
@endsection
@section('styles')
    <script src="{{ asset('assets/packages/fullcalendar-6.1.8/dist/index.global.min.js') }}"></script>
@endsection
@section('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            var calendarEl = document.getElementById('calendar');
            var calendar = new FullCalendar.Calendar(calendarEl, {
                initialView: 'timeGridWeek',
                nowIndicator: true,
                slotMinTime: '08:00', // 8 AM
                slotMaxTime: '22:00', // 9 PM
                headerToolbar: {
                    left: 'prev,next today',
                    center: 'title',
                    right: 'dayGridMonth,timeGridWeek,timeGridDay,listWeek'
                },
                events: [
                    @foreach ($schedules as $schedule)
                        {
                            title: '{{ $schedule['title'] }}',
                            start: '{{ $schedule['start'] }}',
                            end: '{{ $schedule['end'] }}',
                            color: '{{ $schedule['color'] }}', // Assign a unique color for each subject
                            textColor: 'white'
                        },
                    @endforeach
                ],

            });
            calendar.render();
        });
    </script>
@endsection
