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
            $school_year = getCurrentSY();
            $schedule = null;

            $teacher_classes = TeacherClass::query()
                ->with('scheduleDates') // Eager load subject relationship
                ->where('teacher_id', Auth::user()->faculty_member_id)
                ->whereHas('scheduleDates', function ($query) {
                    $query->where('date', now()->format('Y-m-d'))
                        ->where(function ($q) {
                            $q->where('start_time', '<', now()->format('H:m:s'))->where('end_time', '>', now()->format('H:m:s'));
                        });
                })
                ->first();
                if ($teacher_classes) {
                    $schedule = $teacher_classes->scheduleDates()->where('date', now()->format('Y-m-d'))
                    ->where(function ($query) {
                        $query->where('start_time', '<', now()->format('H:m:s'))->where('end_time', '>', now()->format('H:m:s'));
                    })->first();
                }


            $recentLogs = AttendanceLog::where('student_id', '!=', null)->orderBy('created_at', 'desc')->take(5)->get();
            $computers = Computer::all();
            return view('AMS.backend.faculty-layouts.dashboard.index', compact('schedule', 'computers'));
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
