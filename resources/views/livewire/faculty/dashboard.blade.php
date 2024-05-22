
<section class="section" wire:poll>
    <div class="row mb-3">
        <div class="col-lg-2 col-md-12 px-1">
            <div class="card">
                <div class="card-body">
                    <div style="height: 70px">
                        <div class="d-flex justify-content-center align-content-center mt-5 flex-column">
                            <h5 class="font-weight-bold text-center">No. Of Present</h5>
                            <h6 class="text-center">{{ countNumberOfAttendanceBy($teacher_class,now()->format('Y-m-d'), 'present') }}</h6>
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
                            <h5 class="font-weight-bold text-center">No. Of Late</h5>
                            <h6 class="text-center">{{ countNumberOfAttendanceBy($teacher_class,now()->format('Y-m-d'), 'late') }}</h6>
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
                            <h5 class="font-weight-bold text-center">No. Of Absent</h5>
                            <h6 class="text-center">{{ countNumberOfAttendanceBy($teacher_class,now()->format('Y-m-d'), 'absent') }}</h6>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    @if ($schedule)
                        <h5 class="mb-0">Seat Plan for - {{ $schedule->schedule->subject->subject_name }}
                            ({{ date('h:m A', strtotime($schedule->start_time)) }} -
                            {{ date('h:m A', strtotime($schedule->end_time)) }})</h5>
                    @else
                        <h5 class="mb-0">No Schedule</h5>
                    @endif
                </div>

                <div class="card-body p-3">
                    <div class="container">
                        @php
                            $col_count = 1;
                        @endphp
                        @foreach ($computers as $computer)
                            @if ($col_count > 6)
                                @php
                                    $col_count = 1;
                                @endphp
                            @endif
                            @if ($col_count == 1)
                                <div class="row mb-1">
                            @endif
                            <div class="col-lg-2 col-md-12 px-1">
                                <div style="height: 150px"
                                    class="border rounded text-white {{ getComputerStatusColor($computer->status) }}">
                                    <span class="px-2 mb-5" style="top: 0; right: 0">
                                        {{ $computer->computer_number }}</span>
                                    <br>
                                    <div class="d-flex justify-content-center align-content-center mt-5">
                                        @if ($schedule && $computer->status == "occupied")
                                            <span
                                                class="px-2 text-center">{{ getStudentInThisComputer($schedule, $computer->ip_address) }}</span>
                                        @else
                                            <span class="px-2 text-center">{{ $computer->computer_name }}</span>
                                        @endif
                                    </div>
                                </div>
                            </div>
                            @if ($col_count == 6 || $loop->last)
                    </div>
                    @endif
                    @php
                        $col_count++;
                    @endphp
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</section>
