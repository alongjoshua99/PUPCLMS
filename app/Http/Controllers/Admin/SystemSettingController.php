<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\SchoolYear;
use App\Models\Semester;
use Illuminate\Http\Request;

class SystemSettingController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('AMS.backend.admin-layouts.system-settings.index', [
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
    public function update(Request $request, string $id, $is_semester)
    {
        try {
            $name= date('Y', strtotime($request->start_date)) . '-' . date('Y', strtotime($request->end_date));
            if ($is_semester == 1) {
                $semester = Semester::find($id);
           
                $semester->update([
                    'name' => $name,
                    'start_date' =>  $request->start_date,
                    'end_date' =>  $request->end_date,
                ]);
            }else{
                $school_year = SchoolYear::find($id);
                $school_year->update([
                    'start_date' =>  $request->start_date,
                    'end_date' =>  $request->end_date,
                ]);
            }
            
            return back()->with('successToast', 'Updated Successfully');
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
