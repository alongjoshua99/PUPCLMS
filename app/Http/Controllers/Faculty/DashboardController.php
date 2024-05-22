<?php

namespace App\Http\Controllers\Faculty;

use App\Http\Controllers\Controller;
use App\Models\TeacherClass;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\AttendanceLog;
use App\Models\Computer;

class DashboardController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index($filter = null)
    {
        try {

            $present = countNumberOfAttendanceBySemester(Auth::user()->faculty_member_id, 'present');
            $late = countNumberOfAttendanceBySemester(Auth::user()->faculty_member_id, 'late');
            $absent = countNumberOfAttendanceBySemester(Auth::user()->faculty_member_id, 'absent');


            return view('AMS.backend.faculty-layouts.dashboard.index', compact('present', 'late', 'absent'));
        } catch (\Throwable $th) {
            return redirect()->back()->with('errorAlert', $th->getMessage());
        }
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
        //
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
