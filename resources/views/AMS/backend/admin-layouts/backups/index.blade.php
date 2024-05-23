@extends('AMS.backend.admin-layouts.sidebar')

@section('page-title')
    Backups
@endsection

@section('contents')
    <section class="section">
        <div class="row">
            <div class="col-lg-12">

                <div class="card">
                    <div class="card-header d-flex justify-content-between border-bottom-0">
                        <h3 class="text-maroon">@yield('page-title')</h3>
                        {{-- <button class="btn btn-outline-maroon" data-bs-toggle="modal" data-bs-target="#add">Add
                            Schedule</button>
                    @include('AMS.backend.admin-layouts.academics.schedule.modal._add') --}}

                    </div>
                    <div class="card-body">

                        <!-- Table with stripped rows -->
                        <table class="table" id="schedules-table">
                            <thead>
                                <tr>
                                    <th scope="col">#</th>
                                    <th scope="col">Name</th>
                                    <th scope="col">Size</th>
                                    <th scope="col">Date Created</th>
                                    <th scope="col">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($backups as $backup)
                                <tr>
                                    <td class="border-b px-4 py-2">{{ $loop->iteration }}</td>
                                    <td class="border-b px-4 py-2">{{ $backup['name'] }}</td>
                                    <td class="border-b px-4 py-2">{{ $backup['size'] }}</td>
                                    <td class="border-b px-4 py-2">
                                        {{ \Carbon\Carbon::parse($backup['created_at'])->format('F d, Y') }}</td>
                                    <td class="border-b px-4 py-2">
                                        <a href="{{ route('admin.backups.download', $backup['name']) }}"
                                            class="text-blue-500 hover:text-blue-700">Download</a>
                                        {{-- <a href="{{ route('backup.delete', $backup['name']) }}"
                                                class="text-red-500 hover:text-red-700">Delete</a> --}}
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
            $('#schedules-table').DataTable({
                "ordering": false
            });
        });
    </script>
@endsection
