@extends('AMS.backend.admin-layouts.sidebar')

@section('contents')
    <section class="section">
        <div class="row">
            <div class="col-lg-12">

                <div class="card">
                    <div class="card-header d-flex justify-content-between border-bottom-0">
                        <!-- <h3 class="text-maroon">@yield('page-title')
                        </h3>-->
                        <h2>Student's Master List</h2>
                     
                        <div class="d-flex align-items-center">
                      
                            <button class="btn btn-outline-maroon me-1" data-bs-toggle="modal" data-bs-target="#add">Upload master list</button>
                        </div>
                        @include('AMS.backend.admin-layouts.user.student.master_list.modal._add')
                    </div>
                    <div class="card-body">

                        <!-- Table with stripped rows -->
                        <table class="table" id="students-masterlist-table">
 
                                <thead>
                                    <tr>
                                        <th scope="col">Student ID Number</th>
                                        <th scope="col">Name</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($masterLists as $masterList)
                                        <tr>
                                            <td>{{ $masterList->student_id_number }}</td>
                                            <td>{{ $masterList->full_name }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>

                        </table>
                        <!-- End Table with stripped rows -->

                    </div>
                </div>

            </div>

        </div>
    </section>
@endsection
@section('scripts')
    <script>
        $(document).ready(function() {
            $('#students-masterlist-table').DataTable({
                "ordering": false
            });
        });
    </script>

@endsection
