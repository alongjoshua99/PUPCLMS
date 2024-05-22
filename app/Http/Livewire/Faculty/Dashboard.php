<?php

namespace App\Http\Livewire\Faculty;

use App\Models\Computer;
use App\Models\TeacherClass;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class Dashboard extends Component
{
    public $schedule;
    public $teacher_class;
    public function render()
    {
        $school_year = getCurrentSY();
        $this->schedule = null;

        $this->teacher_class = TeacherClass::query()
            ->with('scheduleDates') // Eager load subject relationship
            ->where('teacher_id', Auth::user()->faculty_member_id)
            ->whereHas('scheduleDates', function ($query) {
                $query->where('date', now()->format('Y-m-d'))
                    ->where(function ($q) {
                        $q->where('start_time', '<', now()->format('H:i'))->where('end_time', '>', now()->format('H:i'));
                    });
            })
            ->first();
        if ($this->teacher_class) {
            $this->schedule = $this->teacher_class->scheduleDates()->where('date', now()->format('Y-m-d'))
                ->where(function ($query) {
                    $query->where('start_time', '<', now()->format('H:i'))->where('end_time', '>', now()->format('H:i'));
                })->first();
        }
        return view('livewire.faculty.dashboard', [
            'computers' => Computer::all()
        ]);
    }
}
