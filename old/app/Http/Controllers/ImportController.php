<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel; // Import the Excel facade
use App\Imports\StudentsImport; // Import your import class

class ImportController extends Controller
{
    public function importExcel(Request $request)
    {
        // Validate the uploaded file
        $request->validate([
            'file' => 'required|mimes:xls,xlsx',
        ]);

        $file = $request->file('file');

        try {
            // Import the Excel file using the StudentsImport class (adjust the class name as needed)
            Excel::import(new StudentsImport, $file);
        } catch (\Exception $e) {
            // Handle any exceptions if the import fails
            return redirect()->back()->with('error', 'An error occurred during the import: ' . $e->getMessage());
        }

        return redirect()->back()->with('success', 'Excel file has been imported successfully.');
    }
}