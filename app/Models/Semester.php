<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class Semester extends Model
{
    use HasFactory;
    protected $guarded = [];

    // Semester model
    public function teacherClasses()
    {
        return $this->hasMany(TeacherClass::class, 'id');
    }

    public function schoolYears()
    {
        return $this->hasMany(SchoolYear::class, 'semester_id');
    }
    public function attendanceLogs()
    {
        return $this->hasMany(AttendanceLog::class, 'semester_id');
    }
   // Inside the Semester model
    public function isActiveOnDate($date)
    {
        $startDate = \Carbon\Carbon::parse($this->start_date)->startOfDay();
        $endDate = \Carbon\Carbon::parse($this->end_date)->endOfDay();
        $compareDate = \Carbon\Carbon::parse($date)->startOfDay();

        // Debug statements
        info("Start date: $startDate");
        info("End date: $endDate");
        info("Compare date: $compareDate");

        // Additional debug statement
        info("Is active on date: " . ($startDate <= $compareDate && $endDate >= $compareDate ? 'Yes' : 'No'));

        return $startDate <= $compareDate && $endDate >= $compareDate;
    }

}
