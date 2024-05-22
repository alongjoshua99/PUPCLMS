<?php

namespace App\Http\Livewire\Admin\Schedule;

use App\Models\FacultyMember;
use App\Models\ScheduleDate;
use App\Models\SchoolYear;
use App\Models\Section;
use App\Models\Semester;
use App\Models\Subject;
use App\Models\TeacherClass;
use Carbon\Carbon;
use Livewire\Component;

class Add extends Component
{
    public $schedules;

    public $teachers;
    public $subjects;
    public $sections;
    public $semesters;

    public $teacher_id;
    public $subject_id;
    public $section_id;
    public $start_time;
    public $end_time;
    public $day;
    public $days;
    public $semester_id;

    protected $rules = [
        'teacher_id' => 'required',
        'subject_id' => 'required',
        'section_id' => 'required',
        'start_time' => 'required',
        'end_time' => 'required',
        'day' => 'required',
        'semester_id' => 'required',
    ];
    public function updatedDay($value)
    {
        if ($this->days->count() > 0) {
            foreach ($this->days as $key => $day) {
                if ($day == $value) {
                    $this->days->forget($key);
                }
            }
            $this->days->push($value);
        } else {
            $this->days->push($value);
        }
        $this->sortDays();
    }
    public function removeDay($index)
    {
        try {
            $this->days->forget($index);
            $this->reset('day');
            $this->sortDays();
        } catch (\Throwable $th) {
            dd($th->getMessage());
        }
    }
    private function sortDays()
    {
        $daysOfWeek = array('Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday');
        $sorted = collect();
        foreach ($this->days as $k => $v) {
            $key = array_search($v, $daysOfWeek);
            if ($key !== FALSE) {
                $sorted[$key] = $v;
            }
        }
        $sorted->sortKeys();
        $this->days = $sorted;
    }
    private function getDates($start_date, $end_date, $days)
    {
        $dates = [];
        $start_date = Carbon::parse($start_date);
        $end_date = Carbon::parse($end_date);

        while ($start_date->lte($end_date)) {
            if ($days->contains($start_date->englishDayOfWeek)) {
                $dates[] = $start_date->toDateString();
            }
            $start_date->addDay();
        }

        return $dates;
    }
    // Implement your logic to generate a random color for the schedule
    private function generateColor()
    {
        // You can use a library like https://github.com/brendanhedges/php-color to generate random colors
        // Or implement your own logic here
        return '#' . str_pad(dechex(rand(0, 0xFFFFFF)), 6, '0', STR_PAD_LEFT);
    }

    public function updatedSectionId($value)
    {
        if ($value) {
            $this->subjects = Subject::with('schedules')->whereDoesntHave('schedules', function ($query) use ($value) {
                $query
                    ->where('section_id', $value)
                    ->where('semester_id', $this->semester_id);
            })
                ->get();
        }
    }
    public function store()
    {
        $validatedData = $this->validate();
        $semester = Semester::find($this->semester_id);
        $start_date = Carbon::parse($semester->start_date);
        $end_date = Carbon::parse($semester->end_date);
        $dates = $this->getDates($start_date, $end_date, $this->days);
        $key = 'successToast';
        $message = 'Schedule successfully added!';
        $teacher_class_id = null;

        $this->start_time = Carbon::parse( $this->start_time)->addMinutes(1);
        $this->end_time = Carbon::parse( $this->end_time)->subMinutes(1);
        $sy = getCurrentSY();
        foreach ($dates as $date) {
            $conflicts = ScheduleDate::whereHas('schedule', function ($query) use ($sy, $semester) {
                $query->where('sy_id', $sy->id)->where('semester_id', $semester->id);
            })->where('date', $date)
                ->where(function ($query) {
                    $query->whereBetween('start_time', [$this->start_time, $this->end_time])
                        ->orWhereBetween('end_time', [$this->start_time, $this->end_time])
                        ->orWhere(function ($query) {
                            $query->where('start_time', '<', $this->start_time)->where('end_time', '>', $this->end_time);
                        });
                })->count();
            if ($conflicts > 0) {
                $message = 'There is a conflict on Time for date ' . date('F d, Y', strtotime($date)) . ' and ' . $conflicts . ' other date/s';
                $key = 'errorAlert';
            } else {
                if (!$teacher_class_id) {
                    $teacher_class_id = TeacherClass::create([
                        'teacher_id' => $validatedData['teacher_id'],
                        'subject_id' => $validatedData['subject_id'],
                        'section_id' => $validatedData['section_id'],
                        'start_date' => $start_date,
                        'end_date' => $end_date,
                        'sy_id' => getCurrentSY()->id,
                        'semester_id' => $validatedData['semester_id'],
                        'color' => $this->generateColor(),
                    ])->id;
                }

                ScheduleDate::create([
                    'teacher_class_id' => $teacher_class_id,
                    'date' => $date,
                    'start_time' => Carbon::parse($validatedData['start_time'])->format('H:i'),
                    'end_time' => Carbon::parse($validatedData['end_time'])->format('H:i'),
                ]);
            }
        }

        // Perform database operations or other actions with the validated data

        // Reset form fields
        $this->reset();
        $this->days = collect();
        /* redirect back with successToast message */
        return redirect(request()->header('Referer'))->with($key, $message);
    }


    public function mount()
    {
        $this->days = collect();
        $this->teachers = FacultyMember::where('department_id', '!=', 1)->get();
        $this->subjects = Subject::all();
        $this->sections = Section::all();
        $this->semesters = Semester::all();
    }
    public function render()
    {

        return view('livewire.admin.schedule.add');
    }
}
