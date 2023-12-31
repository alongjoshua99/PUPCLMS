@extends('AMS.backend.admin-layouts.sidebar')

@section('content')
    <div class="container">
        <h1>Masterlist Page</h1>
        
        <!-- Form for Excel file upload -->
        <form method="POST" action="{{ route('import.excel') }}" enctype="multipart/form-data">
            @csrf
            <div class="form-group">
                <label for="excelFile">Upload Excel File:</label>
                <input type="file" name="excelFile" id="excelFile" accept=".xlsx, .xls">
                <button type="submit">Import</button>
            </div>
        </form>

        <!-- Display imported data in a table -->
        @if(isset($importedData) && count($importedData) > 0)
            <table>
                <thead>
                    <tr>
                        <th>Student Number</th>
                        <!-- Add other column headers here -->
                    </tr>
                </thead>
                <tbody>
                    @foreach($importedData as $data)
                        <tr>
                            <td>{{ $data['student_number'] }}</td>
                            <!-- Display other columns' data here -->
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @endif
    </div>
@endsection