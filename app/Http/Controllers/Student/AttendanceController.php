<?php

namespace App\Http\Controllers\Student;

use Carbon\Carbon;
use App\Models\Computer;
use App\Models\SchoolYear;
use App\Models\ScheduleDate;
use App\Models\TeacherClass;
use Illuminate\Http\Request;
use App\Models\AttendanceLog;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class AttendanceController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $school_year = getCurrentSY();
        $schedules = Auth::user()
        ->student
        ->section
        ->schedules()
        ->whereHas('scheduleDates', function($query){
            $query->whereDate('date' , now());
        })
        ->where('semester_id', $school_year->semester_id)
        ->where('sy_id', $school_year->id)
        ->get();
        // dd($schedules);
        return view('AMS.backend.student-layouts.attendance.index', compact('schedules'));
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
    public function show($choice)
    {
        return view('AMS.backend.student-layouts.attendance.show', compact('choice'));
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
        try {
            $school_year = getCurrentSY();

            $remark = '';
            $schedule = TeacherClass::find($id);
            $now = Carbon::now();
            $date = ScheduleDate::where('teacher_class_id', $id)->where('date', $now->toDateString())->first();
            $timeStart = Carbon::parse($schedule->time_start);
            $timeEnd = Carbon::parse($schedule->time_end);

            /*  if ($now->lt($timeStart)) {
                $remark = 'Early';
            } elseif ($now->gt($timeEnd)) {
                $remark = 'Late';
            } else {
                $remark = 'Present';
            } */

            AttendanceLog::create([
                'teacher_class_id' => $id,
                'student_id' => Auth::user()->student->id,
                'sy_id' => $school_year->id,
                'semester_id' => $school_year->semester_id,
                'remarks' => 'Present',
                'time_in' => now(),
            ]);
            return redirect()->back()->with('successToast', 'Attendance successfully logged!');
        } catch (\Throwable $th) {
            return redirect()->back()->with('errorAlert', $th->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try {
            $log = AttendanceLog::with('teacherClass')
                ->where('teacher_class_id', $id)
                ->where('student_id', Auth::user()->student_id)
                ->where('time_out', null)
                ->whereDate('created_at', now())
                ->firstOrFail();
            $log->update(['time_out' => now()]);
            return redirect()->back()->with('successToast', 'Attendance successfully logged!');
        } catch (\Throwable $th) {
            return redirect()->back()->with('errorAlert', $th->getMessage());
        }
    }
}
