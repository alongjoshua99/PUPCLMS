@extends('AMS.backend.faculty-layouts.sidebar')

@section('page-title')
    Dashboard
@endsection

@section('contents')
    <section class="section">
        <div class="row mb-3">
            <div class="col-lg-2 col-md-12 px-1">
                <div class="card">
                    <div class="card-body">
                        <div style="height: 70px">
                            <div class="d-flex justify-content-center align-content-center mt-5 flex-column">
                                <h5 class="font-weight-bold text-center">Total No. Of Present</h5>
                                <h6 class="text-center">{{ $present }}</h6>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-2 col-md-12 px-1">
                <div class="card">
                    <div class="card-body">
                        <div style="height: 70px">
                            <div class="d-flex justify-content-center align-content-center mt-5 flex-column">
                                <h5 class="font-weight-bold text-center">Total No. Of Late</h5>
                                <h6 class="text-center">{{ $late }}</h6>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-2 col-md-12 px-1">
                <div class="card">
                    <div class="card-body">
                        <div style="height: 70px">
                            <div class="d-flex justify-content-center align-content-center mt-5 flex-column">
                                <h5 class="font-weight-bold text-center">Total No. Of Absent</h5>
                                <h6 class="text-center">{{ $absent }}</h6>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </section>
@endsection
@section('styles')
    <script src="{{ asset('assets/packages/fullcalendar-6.1.8/dist/index.global.min.js') }}"></script>
@endsection
{{-- @section('scripts')
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
@endsection --}}
