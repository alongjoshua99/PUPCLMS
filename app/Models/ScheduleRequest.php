<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ScheduleRequest extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function scheduleDate()
    {
        return $this->belongsTo(ScheduleDate::class, 'date_id', 'id')->withDefault();
    }

    public function teacherClass()
    {
        return $this->belongsTo(TeacherClass::class, 'teacher_class_id');
    }

    /* get the latest request of specific teacher_class_id */
    public function getLatestRequest()
    {
        return $this->latest()->first();
    }
}
