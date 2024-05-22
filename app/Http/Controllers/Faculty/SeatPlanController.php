<?php

namespace App\Http\Controllers\Faculty;

use App\Http\Controllers\Controller;
use App\Models\Computer;
use App\Models\TeacherClass;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SeatPlanController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        try {
            $school_year = getCurrentSY();
            $schedule = null;

            $teacher_class = TeacherClass::query()
                ->with('scheduleDates') // Eager load subject relationship
                ->where('teacher_id', Auth::user()->faculty_member_id)
                ->whereHas('scheduleDates', function ($query) {
                    $query->where('date', now()->format('Y-m-d'))
                        ->where(function ($q) {
                            $q->where('start_time', '<', now()->format('H:i'))->where('end_time', '>', now()->format('H:i'));
                        });
                })
                ->first();
                if ($teacher_class) {
                    // dd($teacher_class);
                    $schedule = $teacher_class->scheduleDates()->where('date', now()->format('Y-m-d'))
                    ->where(function ($query) {
                        $query->where('start_time', '<', now()->format('H:i'))->where('end_time', '>', now()->format('H:i'));
                    })->first();
                }


            $computers = Computer::all();
            return view('AMS.backend.faculty-layouts.seat-plan.index', compact('schedule','teacher_class', 'computers'));
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
