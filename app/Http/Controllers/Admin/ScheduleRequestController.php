<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ScheduleDate;
use App\Models\ScheduleRequest;
use Illuminate\Http\Request;

class ScheduleRequestController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $requests = ScheduleRequest::with('scheduleDate')->where('status', 'pending')->get();
        return view('AMS.backend.admin-layouts.reports.schedule.index', compact('requests'));
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
    public function update(string $id, string $status)
    {
        try {
            $user = auth()->user();
            $role = optional($user->role);

            $currentScheddate = ScheduleDate::find(3);


            $schedule = ScheduleRequest::with('teacherClass', 'scheduleDate')->find($id);
            info("Id has passed from request: $id");

            info("date value from ScheduleRequest: $schedule->{$schedule->status}");
            
            $schedule->status = $status;
            $schedule->save();
            info("ScheduleRequest with relationship: " . json_encode($schedule->toArray()));

            if ($status == 'approved' && $schedule->teacherClass) {
                $schedule->teacherClass->update([
                    'date' => $schedule->date,
                    'start_time' => $schedule->start_time,
                    'end_time' => $schedule->end_time,
                    'approved_by' => $role->name,
                    'approved_at' => now(),
                ]);
            }
            
            if ($schedule->scheduleDate) {
                info("Updating schedule_date: " . json_encode($schedule->scheduleDate->toArray()));
                $schedule->scheduleDate->update([
                    'start_time' => $schedule->start_time,
                    'end_time' => $schedule->end_time,
                    'date' => $schedule->new_date,
                    'id' => $schedule->date_id,
                ]);
            } else {
                info("No schedule_date associated.");
            }
            
            info("datenow: " . now());

            return redirect()->back()->with('successToast', 'Request ' . $status . ' successfully!');
        } catch (\Throwable $th) {
            return redirect()->back()->with('errorAlert', $th->getMessage());
        }
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id, string $status)
    {
    }
}
