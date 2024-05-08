<?php

namespace App\Http\Middleware;

use App\Models\Computer;
use App\Models\Student;
use App\Models\Semester;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;


class isStudentMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Check if the user is a student
        if (Auth::user()->role->name !== 'student') {
            return redirect()->back()->with('errorAlert', ' You are not authorized to access this page');
        }

        // Check if the student has a schedule today
        $student = Student::find(Auth::user()->student_id);

        // Use a similar query to retrieve the semester
        $semester = $student->section->schedules()->first()->semester;

        // Check if the semester is active
        // $currentDate = now()->format('Y-m-d');
        // if (!$semester || !$semester->isActiveOnDate($currentDate)) {
        //     // Perform necessary actions when the semester is not active
        //     return $this->handleInactiveSemester($request);
        // }

        // Check if the student has a schedule today
        $hasScheduleCounter = 0;
        foreach ($student->section->schedules as $schedule) {
            if ($schedule->checkIfStudentHasScheduleToday()) {
                $hasScheduleCounter++;
            }
        }

        // If the student has no schedule, log them out
        if ($hasScheduleCounter > 0) {
            return $this->handleNoSchedule($request);
        }

        // update the ip address of the computer the student using
        updateComputerStatus($request, 'login');


        return $next($request);
    }


    protected function handleInactiveSemester(Request $request): Response
    {
        updateComputerStatus($request, 'logout');
        // Remove last_activity from session
        $request->session()->forget(Auth::id() . "_last_activity");
        // Set the user's status to offline
        Auth::user()->status = "Offline";
        // Regenerate session
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        // Logout the user
        Auth::logout();

        return redirect()->route('home.index')->with('errorAlert', 'You are not currently enrolled for this semester or the semester is not active.');
    }

    protected function handleNoSchedule(Request $request): Response
    {
        // Remove last_activity from session
        $request->session()->forget(Auth::id() . "_last_activity");
        // Set the user's status to offline
        Auth::user()->status = "Offline";
        // Regenerate session
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        // Logout the user
        Auth::logout();

        return redirect()->route('home.index')->with('errorAlert', 'You have no schedule today');
    }

}
