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

class TeacherClassSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = Factory::create();
        $sy = getCurrentSY();
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
                        $randomDay = rand(1, 5);
                        $days->push($faker->date('l', strtotime("next $randomDay weekday")));
                    }

                    $dates = $this->getDates($start_date->format('Y-m-d'), $end_date->format('Y-m-d'), $days);

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

                        if ($conflicts == 0) {
                            ScheduleDate::create([
                                'teacher_class_id' => $teacherClass->id,
                                'date' => $date,
                                'start_time' => $start_time,
                                'end_time' => $end_time
                            ]);
                        }
                    }
                }
            }
        }
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



    private function generateRandomTime($ranges)
    {
        $rangeIndex = array_rand($ranges);
        $range = $ranges[$rangeIndex];
        $time = Carbon::createFromTimeString($range);
        $randomTime = $time->addMinutes(rand(0, $time->diffInMinutes(Carbon::createFromTimeString($range))));

        return $randomTime->format('H:i:s');
    }

    // Implement your logic to generate a random color for the schedule
    private function generateColor()
    {
        // You can use a library like https://github.com/brendanhedges/php-color to generate random colors
        // Or implement your own logic here
        return '#' . str_pad(dechex(rand(0, 0xFFFFFF)), 6, '0', STR_PAD_LEFT);
    }

    // private function getDates($start_date, $end_date, $days)
    // {
    //     $dates = [];
    //     $start_date = new \DateTime($start_date);
    //     $end_date = new \DateTime($end_date);
    //     $interval = \DateInterval::createFromDateString('1 day');
    //     $period = new \DatePeriod($start_date, $interval, $end_date);
    //     foreach ($period as $dt) {
    //         if ($dt->format('N') >= 6) { // Check if it's Saturday (6) or Sunday (7)
    //             continue; // Skip weekends
    //         }
    //         foreach ($days as $day) {
    //             if ($dt->format("l") === $day) {
    //                 $dates[] = $dt->format("Y-m-d");
    //             }
    //         }
    //     }

    //     return $dates;
    // }
}
