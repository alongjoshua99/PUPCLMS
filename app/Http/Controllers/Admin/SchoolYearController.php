<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\SchoolYear;
use App\Models\Semester;
use Illuminate\Http\Request;

class SchoolYearController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // dd(SchoolYear::all());
        return view('AMS.backend.admin-layouts.school-years.index', [
            'school_years' => SchoolYear::all(),
            'semesters' => Semester::all()
        ]);
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
                'start_date' => 'required',
                'end_date' => 'required',
            ]);
            SchoolYear::create([
                'name' => date('Y',  strtotime($request->start_date)) . '-' . date('Y',  strtotime($request->end_date)),
                'start_date' => $request->start_date,
                'end_date' => $request->end_date,
                'semester_id' => 1,
            ]);
            return back()->with('successToast', 'School Year Created Successfully');
        } catch (\Throwable $th) {
            return back()->with('errorAlert', $th->getMessage());
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
    public function update(Request $request, int $id)
    {
        try {
            $school_year = SchoolYear::find($id);
            $current = getCurrentSY();
            if ($current) {
                $current->update(['is_active' => false]);
            }
            $school_year->update([
                'is_active' => ($request->status == true) ? true : false,
                'semester_id' => $request->semester_id,
            ]);
            return back()->with('successToast', 'School Year Created Successfully');
        } catch (\Throwable $th) {
            return back()->with('errorAlert', $th->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
