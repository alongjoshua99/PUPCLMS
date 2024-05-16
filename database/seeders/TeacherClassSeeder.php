<?php

namespace Database\Seeders;

use App\Models\FacultyMember;
use App\Models\ScheduleDate;
use App\Models\SchoolYear;
use App\Models\Section;
use App\Models\Semester;
use App\Models\Subject;
use App\Models\TeacherClass;
use Carbon\Carbon;
use Faker\Factory;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Log;

class TeacherClassSeeder extends Seeder
{
    public function run(): void
    {
        $faker = Factory::create();
        $sy = $this->getCurrentSY();
        $semesters = Semester::where('id', '!=', 2)->get();

        foreach ($semesters as $semester) {
            for ($i = 0; $i < 10; $i++) {
                $section = Section::inRandomOrder()->first();
                $subject = Subject::with('schedules')->whereDoesntHave('schedules', function ($query) use ($semester, $section) {
                    $query->where('section_id', $section->id)->where('semester_id', $semester->id);
                })->inRandomOrder()->first();

                if ($section && $subject) {
                    $teacher = FacultyMember::inRandomOrder()->first();
                    $start_date = Carbon::parse($semester->start_date);
                    $end_date = Carbon::parse($semester->end_date);
                    $start_time = $this->generateRandomTime(['07:00:00', '13:00:00', '18:00:00']);
                    $end_time = Carbon::parse($start_time)->addHours(3)->format('H:i:s');
                    $days = collect();

                    for ($e = 0; $e < 3; $e++) {
                        $randomDay = rand(1, 5); // Monday (1) to Friday (5)
                        $days->push(Carbon::createFromFormat('N', $randomDay)->format('l'));
                    }

                    dd($days);
   

                    $dates = $this->getDates($start_date->format('Y-m-d'), $end_date->format('Y-m-d'), $days);

          dd($dates);

                    $teacherClass = TeacherClass::create([
                        'teacher_id' => $teacher->id,
                        'subject_id' => $subject->id,
                        'section_id' => $section->id,
                        'start_date' => $start_date,
                        'end_date' => $end_date,
                        'sy_id' => $sy->id,
                        'semester_id' => $semester->id,
                        'color' => $this->generateColor(),
                    ]);
                    ScheduleDate::create([
                        'teacher_class_id' => $teacherClass->id,
                        'date' => $end_date,
                        'start_time' => '07:00:00',
                        'end_time' => '18:00:00'
                    ]);
                    foreach ($dates as $date) {
                        $conflicts = ScheduleDate::whereHas('schedule', function ($query) use ($sy, $semester) {
                            $query->where('sy_id', $sy->id)->where('semester_id', $semester->id);
                        })->where('date', $date)
                            ->where(function ($query) use ($start_time, $end_time) {
                                $query->whereBetween('start_time', [$start_time, $end_time])
                                    ->orWhereBetween('end_time', [$start_time, $end_time])
                                    ->orWhere(function ($query) use ($start_time, $end_time) {
                                        $query->where('start_time', '<=', $start_time)->where('end_time', '>=', $end_time);
                                    });
                            })->count();

                        Log::info("Checking conflicts for date: $date, start_time: $start_time, end_time: $end_time, conflicts: $conflicts");

                        if ($conflicts == 0) {
                            ScheduleDate::create([
                                'teacher_class_id' => $teacherClass->id,
                                'date' => $date,
                                'start_time' => $start_time,
                                'end_time' => $end_time
                            ]);

                            Log::info("ScheduleDate created for date: $date, start_time: $start_time, end_time: $end_time");
                        }
                    }
                }
            }
        }
    }

    private function getDates($startDate, $endDate, $days)
    {
        $dates = [];
        $currentDate = Carbon::parse($startDate);
        $endDate = Carbon::parse($endDate);

        while ($currentDate->lte($endDate)) {
            $dayOfWeek = $currentDate->format('l');
            if ($days->contains($dayOfWeek) && !$this->isWeekend($currentDate)) {
                $dates[] = $currentDate->toDateString();
            }
            $currentDate->addDay();
        }

        Log::info("Generated Dates: " . implode(', ', $dates));
        return $dates;
    }

    private function isWeekend($date)
    {
        return $date->isSaturday() || $date->isSunday();
    }

    private function generateRandomTime(array $ranges): string
    {
      $rangeIndex = array_rand($ranges);
      $range = $ranges[$rangeIndex];
  
      $startRange = Carbon::parse($range[0]);
      $endRange = Carbon::parse($range[1])->addHours(3);
  
      $randomTime = $startRange->addMinutes(rand(0, $startRange->diffInMinutes($endRange)));
  
      return $randomTime->format('H:i:s');
    }

    private function generateColor()
    {
        return '#' . str_pad(dechex(rand(0, 0xFFFFFF)), 6, '0', STR_PAD_LEFT);
    }

    private function getCurrentSY()
    {
        return SchoolYear::where('is_active', 1)->first();
    }
}
