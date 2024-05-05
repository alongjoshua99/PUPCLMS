@extends('AMS.backend.faculty-layouts.sidebar')

@section('page-title')
    Reschedule Class - {{ $schedule->subject->subject_name }}({{ $schedule->subject->subject_code }}) -
    {{ $schedule->semester_id == 1 ? $schedule->semester_id . 'st' : $schedule->semester_id . 'nd' }} Semester
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
                            <a href="{{ route('faculty.schedule.index') }}" class="btn btn-maroon me-1">
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
                                <form action="{{ route('faculty.schedule.reschedule') }}" method="POST">
                                    <div class="d-flex flex-column">
                                        @csrf

                                        <div class="row mb-3">
                                            <div class="col-sm-6">
                                                <label for="old_date_id" class="form-label fw-bold text-black">Old Date</label>
                                                <select class="form-select" aria-label="Default select example"
                                                    name="old_date_id" id="old_date_id">
                                                    <option selected value="">----Select date----</option>
                                                    @foreach ($schedule->scheduleDates as $date)
                                                        <option value="{{ $date->id }}">{{ date('M d, Y', strtotime($date->date)) }}</option>
                                                    @endforeach
                                                </select>
                                                @error('date')
                                                    <div class="text-danger">{{ $message }}</div>
                                                @enderror
                                            </div>
                                            <div class="col-sm-6">
                                                <label for="new_date" class="form-label fw-bold text-black">New Date</label>
                                                <input type="date"
                                                    class="form-control  @error('new_date') is-invalid @enderror"
                                                    name="new_date" id="new_date" placeholder="Start">
                                                @error('new_date')
                                                    <div class="text-danger">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="row mb-3">
                                            <div class="col-md-6">
                                                <label for="start_time" class="form-label fw-bold text-black">Start</label>
                                                <input type="time"
                                                    class="form-control  @error('start_time') is-invalid @enderror"
                                                    name="start_time" id="start_time">
                                                @error('start_time')
                                                    <div class="text-danger">{{ $message }}</div>
                                                @enderror
                                            </div>
                                            <div class="col-md-6">
                                                <label for="end_time" class="form-label fw-bold text-black">End</label>
                                                <input type="time"
                                                    class="form-control  @error('end_time') is-invalid @enderror"
                                                    name="end_time" id="end_time">
                                                @error('end_time')
                                                    <div class="text-danger">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="row mb-3">
                                            <div class="col-sm-12">
                                                <label for="reason" class="form-label fw-bold text-black">Reason</label>
                                                <textarea class="form-control  @error('reason') is-invalid @enderror" name="reason" id="reason" cols="30"
                                                    rows="10">{{ old('reason') }}</textarea>
                                                @error('reason')
                                                    <div class="text-danger">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>
                                    <div class="d-flex justify-content-end">
                                        <button type="button" class="btn btn-secondary me-1" data-bs-dismiss="modal">Cancel</button>
                                        <button type="submit" class="btn btn-primary">Request</button>
                                    </div>
                                </form>
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
                initialView: 'dayGridMonth',
                nowIndicator: true,
                headerToolbar: {
                    left: 'prev,next today',
                    center: 'title',
                    right: 'dayGridMonth,timeGridWeek,timeGridDay,listWeek'
                },
                height: 500, // Set height to 500 pixels
                events: [
                    @foreach ($schedules as $schedule)
                        {
                            title: '{{ $schedule['title'] }}',
                            start: '{{ $schedule['start'] }}',
                            end: '{{ $schedule['end'] }}',
                            color: '{{ $schedule['color'] }}', // Assign a unique color for each subject
                            url: '{{ $schedule['url'] }}',
                            textColor: 'white',
                        },
                    @endforeach
                ]
            });
            calendar.render();
        });
    </script>
@endsection
