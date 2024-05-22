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
if (!function_exists('getAllSchedules')) {
    function getAllSchedules(?int $semester_id = null, ?int $sy_id = null, ?bool $displaySectionName = false, ?bool $isForView = false, ?string $url = '',)
    {

        $schedules = collect();

        $teacher_classes = TeacherClass::query()
            ->with('scheduleDates'); // Eager load subject relationship

        if ($semester_id) {
            $teacher_classes->where('semester_id', $semester_id);
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
if (!function_exists('checkIfStudentHasSchedule')) {
    function checkIfStudentHasSchedule($section_id)
    {
        $date = Carbon::now()->format('Y-m-d');
        $time = Carbon::now()->format('H:i');
// dd($time, now()->format('H:i'));
        $school_year = getCurrentSY();
        return  TeacherClass::with('scheduleDates')
            ->whereHas('scheduleDates', function ($query) use ($date, $time) {
                $query->whereDate('date', $date)
                    ->where('start_time', '<=', $time)->where('end_time', '>=', $time);
            })
            ->where('sy_id', $school_year->id)
            ->where('semester_id', $school_year->semester_id)
            ->where('section_id', $section_id)
            ->first();
    }
}
if (!function_exists('getTheScheduleOfStudent')) {
    function getTheScheduleOfStudent($section_id)
    {
        $date = Carbon::now()->format('Y-m-d');
        $time = Carbon::now()->format('H:i');

        $school_year = getCurrentSY();
        return  TeacherClass::with('scheduleDates')
            ->whereHas('scheduleDates', function ($query) use ($date, $time) {
                $query->whereDate('date', $date)
                    ->where('start_time', '<=', $time)->where('end_time', '>=', $time);
            })
            ->where('sy_id', $school_year->id)
            ->where('semester_id', $school_year->semester_id)
            ->where('section_id', $section_id)
            ->first();
    }
}

if (!function_exists('createStudentTimeInAttendance')) {
    function createStudentTimeInAttendance($teacher_class, $student_id, $ip_address)
    {
        $school_year = getCurrentSY();
        $attendance =  AttendanceLog::with('teacherClass') // Eager load Teacher relationship
            ->where('teacher_class_id', $teacher_class->id)
            ->where('student_id', $student_id)
            ->where('sy_id', $school_year->id)
            ->where('semester_id', $school_year->semester_id)
            ->whereDate('date', now())
            ->whereNotNull('time_in')
            ->whereNull('time_out')
            ->first();

        if (!$attendance) {
            $schedule = $teacher_class->scheduleDates()->where('date', now()->format('Y-m-d'))
                ->where(function ($query) {
                    $query->where('start_time', '<', Carbon::now()->format('H:i'))->where('end_time', '>', Carbon::now()->format('H:i'));
                })->first();
            $formatted_time_in = Carbon::parse($schedule->start_time)->addMinutes(10)->format('H:i');
            $remarks = 'Present';
            if (Carbon::now()->format('H:i') > $formatted_time_in) {
                $remarks = 'Late';
            }
            // dd($schedule, $attendance);
            return AttendanceLog::create([
                'teacher_class_id' => $teacher_class->id,
                'student_id' => $student_id,
                'sy_id' => $school_year->id,
                'semester_id' => $school_year->semester_id,
                'date' => Carbon::now()->format('Y-m-d'),
                'time_in' => Carbon::now()->format('H:i'),
                'ip_address' => $ip_address,
                'remarks' => $remarks,
            ]);
        }
    }
}
if (!function_exists('createStudentTimeOutAttendance')) {
    function createStudentTimeOutAttendance($teacher_class, $student_id)
    {
        $school_year = getCurrentSY();
        $attendance =  AttendanceLog::with('teacherClass') // Eager load Teacher relationship
            ->where('teacher_class_id', $teacher_class->id)
            ->where('student_id', $student_id)
            ->where('sy_id', $school_year->id)
            ->where('semester_id', $school_year->semester_id)
            ->whereDate('date', now())
            ->whereNotNull('time_in')
            ->whereNull('time_out')
            ->first();
        if ($attendance) {
            return $attendance->update([
                'time_out' => Carbon::now()->format('H:i')
            ]);
        }
    }
}
if (!function_exists('createTeacherTimeInAttendance')) {
    function createTeacherTimeInAttendance($teacher_class, $faculty_member_id, $ip_address)
    {
        $school_year = getCurrentSY();
        $attendance =  AttendanceLog::with('teacherClass') // Eager load Teacher relationship
            ->where('teacher_class_id', $teacher_class->id)
            ->where('faculty_member_id', $faculty_member_id)
            ->where('sy_id', $school_year->id)
            ->where('semester_id', $school_year->semester_id)
            ->whereDate('date', now())
            ->whereNotNull('time_in')
            ->whereNull('time_out')
            ->orWhereNotNull('time_out')
            ->first();

        if (!$attendance) {
            return AttendanceLog::create([
                'teacher_class_id' => $teacher_class->id,
                'faculty_member_id' => $faculty_member_id,
                'sy_id' => $school_year->id,
                'semester_id' => $school_year->semester_id,
                'date' => now()->format('Y-m-d'),
                'time_in' => Carbon::now()->format('H:i'),
                'ip_address' => $ip_address
            ]);
        }
    }
}
if (!function_exists('createTeacherTimeOutAttendance')) {
    function createTeacherTimeOutAttendance($teacher_class, $faculty_member_id)
    {
        $school_year = getCurrentSY();
        $attendance =  AttendanceLog::with('teacherClass') // Eager load Teacher relationship
            ->where('teacher_class_id', $teacher_class->id)
            ->where('faculty_member_id', $faculty_member_id)
            ->where('sy_id', $school_year->id)
            ->where('semester_id', $school_year->semester_id)
            ->whereDate('date', now())
            ->whereNotNull('time_in')
            ->whereNull('time_out')
            ->first();

        if ($attendance) {
            return $attendance->update([
                'time_out' => Carbon::now()->format('H:i')
            ]);
        }
    }
}
if (!function_exists('checkIfStudentAlreadyTimeIn')) {
    function checkIfStudentAlreadyTimeIn($teacher_class, $student_id)
    {
        $school_year = getCurrentSY();
        // dd(AttendanceLog::with('teacherClass') // Eager load Teacher relationship
        // ->where('teacher_class_id', $teacher_class->id)
        // ->where('student_id', $student_id)
        // ->where('sy_id', $school_year->id)
        // ->where('semester_id', $school_year->semester_id)
        // ->whereDate('date', now()->format('Y-m-d'))
        // ->whereNotNull('time_in')
        // ->whereNull('time_out')
        // ->first());
        return AttendanceLog::with('teacherClass') // Eager load Teacher relationship
            ->where('teacher_class_id', $teacher_class->id)
            ->where('student_id', $student_id)
            ->where('sy_id', $school_year->id)
            ->where('semester_id', $school_year->semester_id)
            ->whereDate('date', now()->format('Y-m-d'))
            ->whereNotNull('time_in')
            ->whereNull('time_out')
            // ->whereNotNull('time_out')
            ->first();
    }
}
if (!function_exists('checkIfStudentAlreadyTimeOut')) {
    function checkIfStudentAlreadyTimeOut($teacher_class, $student_id)
    {
        $school_year = getCurrentSY();
        return AttendanceLog::with('teacherClass') // Eager load Teacher relationship
            ->where('teacher_class_id', $teacher_class->id)
            ->where('student_id', $student_id)
            ->where('sy_id', $school_year->id)
            ->where('semester_id', $school_year->semester_id)
            ->whereDate('date', now())
            ->whereNotNull('time_in')
            ->whereNotNull('time_out')
            ->first();
    }
}
if (!function_exists('checkIfTeacherAlreadyTimeIn')) {
    function checkIfTeacherAlreadyTimeIn($teacher_class, $faculty_member_id)
    {
        $school_year = getCurrentSY();
        return AttendanceLog::with('teacherClass') // Eager load Teacher relationship
            ->where('teacher_class_id', $teacher_class->id)
            ->where('faculty_member_id', $faculty_member_id)
            ->where('sy_id', $school_year->id)
            ->where('semester_id', $school_year->semester_id)
            ->whereDate('date', now())
            ->whereNotNull('time_in')
            ->whereNull('time_out')
            ->first();
    }
}
if (!function_exists('checkIfTeacherAlreadyTimeOut')) {
    function checkIfTeacherAlreadyTimeOut($teacher_class, $faculty_member_id)
    {
        $school_year = getCurrentSY();
        return AttendanceLog::with('teacherClass') // Eager load Teacher relationship
            ->where('teacher_class_id', $teacher_class->id)
            ->where('faculty_member_id', $faculty_member_id)
            ->where('sy_id', $school_year->id)
            ->where('semester_id', $school_year->semester_id)
            ->whereDate('date', now())
            ->whereNotNull('time_in')
            ->whereNotNull('time_out')
            ->first();
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
        // dd($computer, $computerLog , $ipAddress);
        if ($computer) {
            if ($action == 'login') {
                $computer->update(['status' => 'occupied']);
            } else {
                $computer->update(['status' => 'offline']);
            }
        } else {
            // generate a report that this computer is not in the list.
            if ($computerLog) {
                $computerLog->update([
                    'created_at' => now()
                ]);
            } else {
                ComputerLog::create([
                    'report' => 'Invalid IP Address',
                    'ip_address' => $ipAddress
                ]);
            }
        }
    }
}
if (!function_exists('getComputerStatusColor')) {
    function getComputerStatusColor($status)
    {
        switch ($status) {
            case 'active':
                return 'bg-success';
            case 'occupied':
                return 'bg-info';
            case 'offline':
                return 'bg-danger';
            case 'under_maintenance':
                return 'bg-warning';
            default:
                return 'bg-secondary';
        }
    }
}
if (!function_exists('getStudentInThisComputer')) {
    function getStudentInThisComputer($schedule, $ip_address)
    {
        if ($schedule) {
            $school_year = getCurrentSY();
            $attendance =  AttendanceLog::with('teacherClass') // Eager load Teacher relationship
                ->where('teacher_class_id', $schedule->teacher_class_id)
                ->where('sy_id', $school_year->id)
                ->where('semester_id', $school_year->semester_id)
                ->whereDate('date', now())
                ->where('ip_address', $ip_address)
                ->first();
            // dd($attendance);
            if ($attendance) {
                return $attendance->student->getFullName();
            }
        }
        return '';
    }
}
if (!function_exists('getComputerNumber')) {
    function getComputerNumber($ip_address)
    {
        $computer = Computer::where('ip_address', $ip_address)->first();
        if ($computer) {
            return $computer;
        }
    }
}
if (!function_exists('countNumberOfAttendanceBy')) {
    function countNumberOfAttendanceBy($schedule, $schedule_date, $type)
    {
        switch ($type) {
            case 'present':
                return $schedule->attendanceLogs()
                    ->whereDate('date', $schedule_date->date)
                    ->where('student_id', '!=', null)->count();
            case 'late':
                return $schedule->attendanceLogs()
                    ->where('remarks', 'Late')
                    ->whereDate('date', $schedule_date->date)
                    ->where('student_id', '!=', null)
                    ->count();
            case 'absent':
                $count = $schedule->section->students()->count() - $schedule->attendanceLogs()
                    ->whereDate('date', $schedule_date->date)
                    ->where('student_id', '!=', null)
                    ->count();
                if ($count < 0) {
                    $count = 0;
                }
                return  $count;
        }
    }
}
