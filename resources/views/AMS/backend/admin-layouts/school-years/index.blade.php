@extends('AMS.backend.admin-layouts.sidebar')

@section('page-title')
    School Years
@endsection

@section('contents')
    <section class="section">
        <div class="row">
            <div class="col-lg-12">

                <div class="card">
                    <div class="card-header d-flex justify-content-between border-bottom-0">
                        <h3 class="text-maroon">@yield('page-title')</h3>
                        <button class="btn btn-outline-maroon" data-bs-toggle="modal" data-bs-target="#add">
                            Add School Year
                        </button>
                        @include('AMS.backend.admin-layouts.school-years.modals._add')

                    </div>
                    <div class="card-body">

                        <!-- Table with stripped rows -->
                        <table class="table" id="school-years-table">
                            <thead>
                                <tr>
                                    <th scope="col">School Year</th>
                                    <th scope="col">Status</th>
                                    <th scope="col">Semester</th>
                                    <th scope="col">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($school_years as $school_year)
                                    <tr>
                                        <td>
                                            {{ $school_year->name }}
                                        </td>

                                        <td>
                                            @if ($school_year->is_active)
                                                <span class="badge text-bg-primary">Active</span>
                                            @else
                                                <span class="badge text-bg-secondary">Inactive</span>
                                            @endif
                                        </td>
                                        <td>
                                            {{ $school_year->semester->name }}
                                        </td>

                                        <td>
                                            <div class="d-flex justify-content-center">
                                                <button class="btn btn-link text-primary" type="button"
                                                    data-bs-toggle="modal" data-bs-target="#edit{{ $school_year->id }}"
                                                    data-bs-toggle="tooltip" data-bs-placement="top" title="Edit">
                                                    <i class="ri-edit-line text-primary" aria-hidden="true"></i>
                                                </button>
                                                @include('AMS.backend.admin-layouts.school-years.modals._edit')
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>

                    </div>
                </div>

            </div>
        </div>
    </section>
@endsection

@section('scripts')
    <script>
        $(document).ready(function() {
            $('#school-years-table').DataTable({
                "ordering": false
            });
        });
    </script>
@endsection
