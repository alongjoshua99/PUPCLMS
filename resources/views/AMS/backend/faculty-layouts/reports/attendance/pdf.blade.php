@extends('AMS.backend.faculty-layouts.sidebar')

@section('page-title')
    {{ $section->section_name }} - {{ $subject->subject_name }}
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
                            <a href="{{ route('faculty.report.attendance.show', ['id' => $schedule->id, 'schedule_date_id' => $schedule_date->id]) }}"
                                class="btn btn-outline-maroon me-1">
                                <i class="ri-arrow-go-back-line"></i>
                                Back
                            </a>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="d-flex justify-content-center align-items-center mb-3">
                            <div>
                                <button type="button" class="btn btn-maroon"
                                    onclick="generatePDF('{{ $section->section_name }} - {{ $subject->subject_name }}')">
                                    Download
                                </button>
                            </div>
                        </div>
                        <div id="element-to-print">
                            <div class="row">
                                <h3 class="text-center">{{ $subject->subject_name }}</h2>
                                <h4 class="text-center">{{ $section->section_name }}</h4>
                                <h5 class="text-center">{{ $schedule->teacher->full_name }}</h5>
                            </div>
                            <table class="table" id="schedules-table">
                                <thead>
                                    <tr>
                                        <th scope="col">Student</th>
                                        <th scope="col">Computer no.</th>
                                        <th scope="col">Time in</th>
                                        <th scope="col">Time Out</th>
                                        <th scope="col">Remarks</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($logs as $log)
                                        <tr>
                                            <td>
                                                {{ $log->student->getFullName() }}
                                            </td>
                                            <td>
                                                {{ getComputerNumber($log->ip_address) }}
                                            </td>
                                            <td>
                                                {{ date('h:i A', strtotime($log->time_in)) }}
                                            </td>
                                            <td>
                                                @if ($log->time_out != null)
                                                    {{ date('h:i A', strtotime($log->time_out)) }}
                                                @else
                                                    <span class="badge bg-danger">No Data</span>
                                                @endif
                                            </td>
                                            <td>
                                                {{ $log->remarks }}
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        <!-- Table with stripped rows -->

                    </div>
                </div>

            </div>
        </div>
    </section>
@endsection
@section('scripts')
    <script src="{{ asset('assets/packages/html2pdf/html2pdf.bundle.min.js') }}" {{-- integrity="sha512-YcsIPGdhPK4P/uRW6/sruonlYj+Q7UHWeKfTAkBW+g83NKM+jMJFJ4iAPfSnVp7BKD4dKMHmVSvICUbE/V1sSw==" --}}
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script>
        function generatePDF(filename) {
            console.log(filename);
            var element = document.getElementById('element-to-print');
            var opt = {
                margin: .1,
                filename: filename + '.pdf',
                image: {
                    type: 'jpeg',
                    quality: 0.98
                },
                html2canvas: {
                    scale: 2
                },
                jsPDF: {
                    unit: 'in', // Maintain inches for compatibility
                    format: 'a4',
                    orientation: 'portrait'
                }
            };

            // New Promise-based usage:
            html2pdf().set(opt).from(element).save();
        }
    </script>
@endsection
