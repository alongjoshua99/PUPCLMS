<?php

use App\Models\AttendanceLog;
use App\Models\Computer;
use App\Models\ComputerLog;
use App\Models\SchoolYear;
use App\Models\TeacherClass;
use Carbon\Carbon;
use Illuminate\Http\Request;

if (!function_exists('getSchedules')) {
    function getSchedules(?int $faculty_id = null, ?int $teacher_class_id = null, ?bool $displaySectionName = false, ?bool $isForView = false, ?string $url = '', ?int $semester_id = null, ?int $sy_id = null)
    {

        $schedules = collect();
        $school_year = getCurrentSY();

        $teacher_classes = TeacherClass::query()
            ->with('scheduleDates'); // Eager load subject relationship

        if ($faculty_id) {
            $teacher_classes->where('teacher_id', $faculty_id);
        }
        if ($teacher_class_id) {
            $teacher_classes->where('id', '!=', $teacher_class_id);
            // dd($teacher_classes->get());
        }

        if ($semester_id && $sy_id) {
            $teacher_classes->where('semester_id', $semester_id)
                ->where('sy_id', $sy_id);
        } else {
            $teacher_classes->where('semester_id', $school_year->semester_id)
                ->where('sy_id', $school_year->id);
        }
        if ($isForView) {
            return  $teacher_classes->get();
        }
        foreach ($teacher_classes->get() as $teacher_class) {
            foreach ($teacher_class->scheduleDates as $scheduleDate) {
                $color = (checkIfComputerLaboratoryIsOccupied($teacher_class->id)) ? '#444'  : $teacher_class->color;

                $start = Carbon::parse($scheduleDate->date . ' ' . $scheduleDate->start_time)->format('Y-m-d\TH:i:s'); // Combine date and time, format in Moment.js

                $end = Carbon::parse($scheduleDate->date . ' ' . $scheduleDate->end_time)->format('Y-m-d\TH:i:s'); // Combine date and time, format in Moment.js
                if ($displaySectionName) {
                    $schedules[] = [
                        'title' => "{$teacher_class->subject->subject_code} - {$teacher_class->section->section_name}", // Use subject relationship
                        'start' => $start,
                        'end' => $end,
                        'url' => $url,
                        'color' => $color
                    ];
                } else {
                    $schedules[] = [
                        'title' => "{$teacher_class->subject->subject_code} - {$teacher_class->teacher->full_name}", // Use subject relationship
                        'start' => $start,
                        'end' => $end,
                        'url' => $url,
                        'color' => $color
                    ];
                }
            }
        }

        return $schedules->all(); // Return array instead of object cast
    }
}
if (!function_exists('getSchedulesForSection')) {
    function getSchedulesForSection(int $section_id, ?string $url = '', ?int $semester_id = null, ?int $sy_id = null)
    {

        $schedules = collect();
        $school_year = getCurrentSY();

        $teacher_classes = TeacherClass::query()
            ->with('scheduleDates')  // Eager load subject relationship
            ->where('section_id', $section_id);
      

        if ($semester_id && $sy_id) {
            $teacher_classes->where('semester_id', $semester_id)
                ->where('sy_id', $sy_id);
        } else {
            $teacher_classes->where('semester_id', $school_year->semester_id)
                ->where('sy_id', $school_year->id);
        }
        foreach ($teacher_classes->get() as $teacher_class) {
            foreach ($teacher_class->scheduleDates as $scheduleDate) {
                $color = (checkIfComputerLaboratoryIsOccupied($teacher_class->id)) ? '#444'  : $teacher_class->color;

                $start = Carbon::parse($scheduleDate->date . ' ' . $scheduleDate->start_time)->format('Y-m-d\TH:i:s'); // Combine date and time, format in Moment.js

                $end = Carbon::parse($scheduleDate->date . ' ' . $scheduleDate->end_time)->format('Y-m-d\TH:i:s'); // Combine date and time, format in Moment.js
                
                $schedules[] = [
                    'title' => "{$teacher_class->subject->subject_code} - {$teacher_class->teacher->full_name}", // Use subject relationship
                    'start' => $start,
                    'end' => $end,
                    'url' => $url,
                    'color' => $color
                ];
            }
        }

        return $schedules->all(); // Return array instead of object cast
    }
}
if (!function_exists('formatSchedules')) {
    function formatSchedules($teacher_class, ?bool $displaySectionName = false, ?string $url = '')
    {
        $schedules = collect();
        foreach ($teacher_class->scheduleDates as $scheduleDate) {
            $color = (checkIfComputerLaboratoryIsOccupied($teacher_class->id)) ? '#444'  : $teacher_class->color;

            $start = Carbon::parse($scheduleDate->date . ' ' . $scheduleDate->start_time)->format('Y-m-d\TH:i:s'); // Combine date and time, format in Moment.js

            $end = Carbon::parse($scheduleDate->date . ' ' . $scheduleDate->end_time)->format('Y-m-d\TH:i:s'); // Combine date and time, format in Moment.js
            if ($displaySectionName) {
                $schedules[] = [
                    'title' => "{$teacher_class->subject->subject_code} - {$teacher_class->section->section_name}", // Use subject relationship
                    'start' => $start,
                    'end' => $end,
                    'url' => $url,
                    'color' => $color
                ];
            } else {
                $schedules[] = [
                    'title' => "{$teacher_class->subject->subject_code} - {$teacher_class->teacher->full_name}", // Use subject relationship
                    'start' => $start,
                    'end' => $end,
                    'url' => $url,
                    'color' => $color
                ];
            }
        }

        return $schedules->all(); // Return array instead of object cast
    }
}
if (!function_exists('countStudents')) {
    function countStudents($teacher_class)
    {
    }
}

if (!function_exists('checkIfComputerLaboratoryIsOccupied')) {
    function checkIfComputerLaboratoryIsOccupied($teacher_class_id)
    {
        return AttendanceLog::with('teacherClass') // Eager load Teacher relationship
            ->where('teacher_class_id', $teacher_class_id)
            ->where('faculty_member_id', '!=', null)
            ->whereNotNull('time_in')
            ->whereNull('time_out')
            ->whereDate('created_at', now())
            ->first();
    }
}

if (!function_exists('getCurrentSY')) {
    function getCurrentSY()
    {
        return SchoolYear::where('is_active', 1)->first();
    }
}
if (!function_exists('updateComputerStatus')) {
    function updateComputerStatus(Request $request, $action)
    {
        $ipAddress = $request->ip();
        $computer = Computer::where('ip_address', $ipAddress)->first();
        $computerLog = ComputerLog::where('ip_address', $ipAddress)->where('status', 'pending')->first();
        if ($computer) {
            if ($action == 'login') {
                $computer->update(['status' => 'active']);
            } else {
                $computer->update(['status' => 'offline']);
            }
        }
        // generate a report that this computer is not in the list.
        if ($computerLog) {
            $computerLog->update(['created_at' => now()]);
        } else {
            ComputerLog::create(['ip_address' => $ipAddress]);
        }
    }
}
