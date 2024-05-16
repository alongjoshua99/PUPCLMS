<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Imports\StudentMasterListImport;
use App\Models\StudentMasterList;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class StudentMasterListController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('AMS.backend.admin-layouts.user.student.master_list.index', ['masterLists' => StudentMasterList::all()]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {

        try {
             $request->validate([
                 'file' => 'required|file|mimes:csv,xlsx',
             ]);
            Excel::import(new StudentMasterListImport, $request->file('file'));

            return redirect()->back()->with('successToast', 'Student Master List upload successful.');
        } catch (\Exception $e) {
            // If an error occurs during import, redirect back with an error message
            return redirect()->back()->with('errorToast', 'There was an error importing the file:' . $e->getMessage());
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
