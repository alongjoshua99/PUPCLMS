<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AttendanceLog;
use App\Models\FacultyMember;
use App\Models\TeacherClass;
use App\Models\Computer;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;


class AdminDashboardController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index($filter = null)
    {
        try {
            // Call the method with a specific date
            // $schedules = getSchedules();
            // dd($schedules);

            return view('AMS.backend.admin-layouts.dashboard.index',
        ['schedules' => getSchedules()]);
        } catch (\Throwable $th) {
            return redirect()->back()->with('errorAlert', $th->getMessage());
        }
    }


    private function getFacultySchedules($specificDate = null)
    {
        try {
            // Enable query logging
            DB::enableQueryLog();

            // Retrieve the authenticated user's faculty member instance
            $facultyMember = Auth::user()->facultyMember;

            // Load the necessary relationships
            $facultyMember->load('teacherClasses.scheduleDates.subject', 'teacherClasses.scheduleDates.section');

            // Retrieve the scheduleDates for the specified date
            $scheduleDates = $facultyMember->teacherClasses->flatMap(function ($teacherClass) use ($specificDate) {
                return $teacherClass->scheduleDates
                    ->where('date', $specificDate)
                    ->map(function ($scheduleDate) use ($teacherClass) {
                        return [
                            'subject_name' => $teacherClass->subject->subject_name,
                            'section_name' => $teacherClass->section->section_name,
                            'date' => $scheduleDate->date,
                            'start_time' => $scheduleDate->start_time,
                            'end_time' => $scheduleDate->end_time,
                            'color' => $teacherClass->color,
                        ];
                    });
            });

            // Log the executed queries
            info(DB::getQueryLog());
            info('Faculty Schedules:', $scheduleDates->toArray());

            return $scheduleDates;
        } catch (\Throwable $th) {
            // Log or handle the exception if needed
            return collect();
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
