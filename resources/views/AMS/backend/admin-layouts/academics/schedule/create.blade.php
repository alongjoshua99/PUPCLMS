@extends('AMS.backend.admin-layouts.sidebar')

@section('page-title')
    Create schedule
@endsection

@section('contents')
    <section class="section">
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-header d-flex justify-content-between border-bottom-0">
                        <h3 class="text-maroon">@yield('page-title')</h3>
                        {{-- back button --}}
                        <div class="d-flex">
                            <a href="{{ route('admin.schedules.index') }}" class="btn btn-maroon me-1">
                                <i class="ri-arrow-go-back-line"></i>
                                Back
                            </a>
                        </div>
                    </div>
                    <div class="card-body mt-5">
                        <div class="row">
                            <div class="col-6">
                                <div id='calendar'></div>
                            </div>
                            <div class="col-6">
                                <livewire:admin.schedule.add />
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
