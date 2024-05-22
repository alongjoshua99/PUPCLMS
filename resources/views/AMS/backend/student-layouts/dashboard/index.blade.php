@extends('AMS.backend.student-layouts.sidebar')

@section('page-title')
    Dashboard
@endsection

@section('contents')
    <section class="section">
        <div class="row">
            <div class="col-6">
                <div class="card">

                    <div class="card-body pb-0" style="height: 40%">
                        <h5 class="card-title">Schedules <span></span></h5>

                        <table class="table table-borderless">
                            <thead>
                                <tr>
                                    <th scope="col">Subject</th>
                                    <th scope="col">Section</th>
                                    <th scope="col">Date & Time</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($schedules as $schedule)
                                    <tr>
                                        <td>
                                            {{ $schedule->subject->subject_name }}
                                        </td>
                                        <td>
                                            {{ $schedule->section->section_name }}
                                        </td>

                                        <td>
                                            <button class="btn btn-sm btn-link text-info" type="button"
                                                data-bs-toggle="modal" data-bs-target="#view{{ $schedule->id }}">
                                                <i class="ri-eye-line"></i>
                                            </button>
                                            <div class="modal fade" id="view{{ $schedule->id }}" tabindex="-1">
                                                <div class="modal-dialog">
                                                    <div class="modal-content">
                                                        <div class="modal-header bg-info">
                                                            <h5 class="modal-title text-white">View Scheduled Dates</h5>
                                                        </div>
                                                        <div class="modal-body my-3">
                                                            <!-- Table with stripped rows -->
                                                            <table class="table" id="schedules-table">
                                                                <thead>
                                                                    <tr>
                                                                        <th scope="col">Date</th>
                                                                        <th scope="col">Time</th>
                                                                    </tr>
                                                                </thead>
                                                                <tbody>
                                                                    @foreach ($schedule->scheduleDates as $schedule_date)
                                                                        <tr>
                                                                            <td>
                                                                                {{ date('F d, Y', strtotime($schedule_date->date)) }}
                                                                            </td>
                                                                            <td>
                                                                                {{ date('h:i A', strtotime($schedule_date->start_time)) }} - {{ date('h:i A', strtotime($schedule_date->end_time)) }}
                                                                            </td>
                                                                        </tr>
                                                                    @endforeach
                                                                </tbody>
                                                            </table>
                                                        </div>
                                                        <div class="modal-footer">
                                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="3" class="text-center">
                                            No schedules
                                        </td>
                                @endforelse
                            </tbody>
                        </table>

                    </div>

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
                ]
            });
            calendar.setOption('weekends', false);
            calendar.render();
        });
    </script>
@endsection
