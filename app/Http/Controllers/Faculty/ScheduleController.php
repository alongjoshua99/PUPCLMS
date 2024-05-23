<?php

namespace App\Http\Controllers\Faculty;

use App\Http\Controllers\Controller;
use App\Models\AttendanceLog;
use App\Models\ScheduleDate;
use App\Models\ScheduleRequest;
use App\Models\SchoolYear;
use App\Models\TeacherClass;
use Carbon\Carbon;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ScheduleController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $teacherClasses = getSchedules(Auth::user()->faculty_member_id, null, false, true);
        return view('AMS.backend.faculty-layouts.schedule.index', compact('teacherClasses'));
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
    public function show(TeacherClass $schedule)
    {
        try {
            $section = $schedule->section;
            $subject = $schedule->subject->subject_name;
            return view('AMS.backend.faculty-layouts.schedule.show', compact('schedule', 'section', 'subject'));
        } catch (\Throwable $th) {
            return redirect()->back()->with('errorAlert', $th->getMessage());
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(TeacherClass $schedule)
    {
        $presentDates = [];
        foreach ($schedule->scheduleDates as $scheduleDate) {
            $formattedScheduleDate = Carbon::parse($scheduleDate->date)->format('Y-m-d');
            $today = Carbon::today()->format('Y-m-d');
            if ($formattedScheduleDate >= $today) {
                $presentDates[] = $scheduleDate;
            }
        }
        // dd($presentDates);
        return view('AMS.backend.faculty-layouts.schedule.edit', ['schedule' => $schedule,'presentDates' => $presentDates, 'schedules' => getSchedules(null, $schedule->id, true)]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update($type, TeacherClass $schedule)
    {
        try {
            $sy = getCurrentSY();
            if ($type === "in") {
                AttendanceLog::create([
                    'teacher_class_id' => $schedule->teacher_class_id,
                    'faculty_member_id' => Auth::user()->faculty_member_id,
                    'sy_id' => $sy->id,
                    'semester_id' => $sy->semester_id,
                    'remarks' => 'present',
                    'time_in' => now()
                ]);
            } elseif ($type === "out") {
                $log = AttendanceLog::where('teacher_class_id', $schedule->teacher_class_id)
                    ->where('faculty_member_id', Auth::user()->faculty_member_id)
                    ->where('sy_id', $sy->id)
                    ->where('semester_id', $sy->semester_id)
                    ->whereDate('created_at', now())
                    ->first();
                $log->update([
                    'time_out' => now()
                ]);
            }
            return redirect()->back()->with('successToast', 'Successfully Taken an attendance for ' . $schedule->schedule->subject->name);
        } catch (\Throwable $th) {
            return redirect()->back()->with('errorAlert', $th->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function reschedule(Request $request)
    {
        try {
            $request->validate([
                'old_date_id' => 'required',
                'new_date' => 'required|date|after:today',
                'start_time' => 'required',
                'end_time' => 'required',
                'reason' => 'required',
            ]);
            $sy = getCurrentSY();
            $date = Carbon::parse($request->new_date)->format('Y-m-d');
            $start_time = Carbon::parse($request->start_time)->format('H:i');
            $end_time = Carbon::parse($request->end_time)->format('H:i');
            $conflicts = ScheduleDate::whereHas('schedule', function ($query) use ($sy) {
                $query->where('sy_id', $sy->id)->where('semester_id', $sy->semester_id);
            })->where('date', $date)
                ->where(function ($query) use ($start_time, $end_time) {
                    $query->whereBetween('start_time', [$start_time, $end_time])
                        ->orWhereBetween('end_time', [$start_time, $end_time])
                        ->orWhere(function ($query) use ($start_time, $end_time) {
                            $query->where('start_time', '<', $start_time)->where('end_time', '>', $end_time);
                        });
                })->count();
            if ($conflicts > 0) {
                return redirect()->back()->with('errorAlert', 'There is a conflict on Time for date ' . date('F d, Y', strtotime($date)) . ' and ' . $conflicts . ' other date/s');
            }
            ScheduleRequest::create([
                'date_id' => $request->old_date_id,
                'new_date' => $request->new_date,
                'start_time' => $request->start_time,
                'end_time' => $request->end_time,
                'reason' => $request->reason,
            ]);

            return redirect()->back()->with('successToast', 'Request sent');
        } catch (\Throwable $th) {
            return redirect()->back()->with('errorAlert', $th->getMessage());
        }
    }
}
