@extends('AMS.backend.faculty-layouts.sidebar')

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
        </div>
    </section>
@endsection
@section('styles')
    <script src="{{ asset('assets/packages/fullcalendar-6.1.8/packages/core/index.global.min.js') }}"></script>
    <script src="{{ asset('assets/packages/fullcalendar-6.1.8/packages/daygrid/index.global.min.js') }}"></script>
@endsection
@section('scripts')
    <script>
            document.addEventListener('DOMContentLoaded', function() {
                var calendarEl = document.getElementById('calendar');
                var calendar = new FullCalendar.Calendar(calendarEl, {
                    initialView: 'dayGridMonth',
                    events: [
                        @foreach ($schedules as $schedule)
                        {
                                    title: '{{ $schedule['title'] }}',
                                    start: '{{ $schedule['start'] }}',
                                    end: '{{ $schedule['end'] }}',
                                    color: '{{  $schedule['color'] }}', // Assign a unique color for each subject
                                    textColor: 'white'
                                },
                        @endforeach
                    ]
                });
                calendar.render();
            });
    </script>
@endsection