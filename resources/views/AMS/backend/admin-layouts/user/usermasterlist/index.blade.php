@extends('AMS.backend.admin-layouts.sidebar')

@section('contents')
    <section class="section">
        <div class="row">
            <div class="col-lg-12">

                <div class="card">
                    <div class="card-header d-flex justify-content-between border-bottom-0">
                        <!-- <h3 class="text-maroon">@yield('page-title')
                        </h3>-->
                        <h2>User's Master List</h2>
                     
                        <div class="d-flex align-items-center">
                      
                        <!-- <button class="btn btn-outline-maroon me-1" data-bs-toggle="modal" data-bs-target="#add">Add Upload master list</button>-->
                     
                        </div>
                        @include('AMS.backend.admin-layouts.user.usermasterlist.modal._add')
                    </div>
                    <div class="card-body">

                        <!-- Table with stripped rows -->
                        <table class="table" id="users-masterlist-table">
 
                                <thead>
                                    <tr>
                                        <th scope="col">User Master Id</th>
                                        <th scope="col">FullName</th>
                                        <th scope="col">Status</th>
                                        <th scope="col">Created_At</th>
                                        <th scope="col">Created_By</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($userMasterList as $user)
                                        <tr>
                                            <td>{{ $user->user_master_id }}</td>
                                            <td>{{ $user->user_full_name }}</td>
                                            <td>
                                                @if ($user->status === 1)
                                                    <span class="badge bg-success">Active</span>
                                                @elseif ($user->status === 0)
                                                    <span class="badge bg-danger">Inactive</span>
                                                @else
                                                    <span class="badge bg-warning">No data</span>
                                                @endif
                                            </td>
                                            <td>{{ $user->updated_at }}</td>
                                            <td>{{ $user->created_by }}</td>
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
            $('#users-masterlist-table').DataTable({
                "ordering": false
            });
        });
    </script>

@endsection
