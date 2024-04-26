<?php

namespace Database\Seeders;

use App\Models\ScheduleDate;
use App\Models\SchoolYear;
use App\Models\Section;
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
    $sy = SchoolYear::where('is_active', 1)->first();

    for ($i = 0; $i < 5; $i++) {
        $start_date = Carbon::now()->subDay()->format('Y-m-d');
        $end_date =  Carbon::now()->subDay()->addMonths(1)->format('Y-m-d');

        // Randomly select time within the specified ranges
        $start_time = $this->generateRandomTime(['07:00:00', '13:00:00', '18:00:00']);
        $end_time = Carbon::createFromTimeString($start_time)->addHours(3)->format('H:i:s');

        $validatedData = [
            'teacher_id' => 2,
            'subject_id' => $faker->numberBetween(1, Subject::count()),
            'section_id' => 1,
            'semester_id' => $faker->numberBetween(1, 2),
            'start_date' => $start_date,
            'end_date' => $end_date,
            'start_time' => $start_time,
            'end_time' => $end_time,
        ];

        $days = collect();

        for ($e = 0; $e < 3; $e++) {
            $randomDay = rand(1, 7);
            $days->push($faker->date('l', strtotime("next $randomDay weekday")));
        }

        $dates = $this->getDates($validatedData['start_date'], $validatedData['end_date'], $days);

        $teacherClassId = TeacherClass::create([
            'teacher_id' => $validatedData['teacher_id'],
            'subject_id' => $validatedData['subject_id'],
            'section_id' => $validatedData['section_id'],
            'start_date' => $validatedData['start_date'],
            'end_date' => $validatedData['end_date'],
            'sy_id' => $sy->id,
            'semester_id' => $validatedData['semester_id'],
            'color' => $this->generateColor(),
        ])->id;

        foreach ($dates as $date) {
            $conflicts = ScheduleDate::with('schedule')
                ->whereHas('schedule', function ($query) use ($sy) {
                    $query->where('sy_id', $sy->id)
                        ->where('semester_id', $sy->semester_id);
                })
                ->whereDate('date', $date)
                ->where(function ($query) use ($validatedData) {
                    $query->where(function ($query) use ($validatedData) {
                        $query->where('start_time', '<=', $validatedData['start_time'])
                            ->where('end_time', '>=', $validatedData['start_time']);
                    })->orWhere(function ($query) use ($validatedData) {
                        $query->where('start_time', '<=', $validatedData['end_time'])
                            ->where('end_time', '>=', $validatedData['end_time']);
                    })->orWhere(function ($query) use ($validatedData) {
                        $query->where('start_time', '>=', $validatedData['start_time'])
                            ->where('start_time', '<=', $validatedData['end_time'])
                            ->orWhere('end_time', '>=', $validatedData['start_time'])
                            ->where('end_time', '<=', $validatedData['end_time']);
                    });
                })
                ->get();

            if ($conflicts->count() == 0) {
                ScheduleDate::create([
                    'teacher_class_id' => $teacherClassId,
                    'date' => $date,
                    'start_time' => $start_time,
                    'end_time' => $end_time
                ]);
            }
        }
    }
    for ($i = 0; $i < 10; $i++) {
        $start_date = Carbon::now()->subDay()->format('Y-m-d');
        $end_date =  Carbon::now()->subDay()->addMonths(1)->format('Y-m-d');

        // Randomly select time within the specified ranges
        $start_time = $this->generateRandomTime(['07:00:00', '13:00:00', '18:00:00']);
        $end_time = Carbon::createFromTimeString($start_time)->addHours(3)->format('H:i:s');

        $validatedData = [
            'teacher_id' => 2,
            'subject_id' => $faker->numberBetween(1, Subject::count()),
            'section_id' => $faker->numberBetween(2, Section::count()),
            'semester_id' => $faker->numberBetween(1, 2),
            'start_date' => $start_date,
            'end_date' => $end_date,
            'start_time' => $start_time,
            'end_time' => $end_time,
        ];

        $days = collect();

        for ($e = 0; $e < 3; $e++) {
            $randomDay = rand(1, 7);
            $days->push($faker->date('l', strtotime("next $randomDay weekday")));
        }

        $dates = $this->getDates($validatedData['start_date'], $validatedData['end_date'], $days);

        $teacherClassId = TeacherClass::create([
            'teacher_id' => $validatedData['teacher_id'],
            'subject_id' => $validatedData['subject_id'],
            'section_id' => $validatedData['section_id'],
            'start_date' => $validatedData['start_date'],
            'end_date' => $validatedData['end_date'],
            'sy_id' => $sy->id,
            'semester_id' => $validatedData['semester_id'],
            'color' => $this->generateColor(),
        ])->id;

        foreach ($dates as $date) {
            $conflicts = ScheduleDate::with('schedule')
                ->whereHas('schedule', function ($query) use ($sy) {
                    $query->where('sy_id', $sy->id)
                        ->where('semester_id', $sy->semester_id);
                })
                ->whereDate('date', $date)
                ->where(function ($query) use ($validatedData) {
                    $query->where(function ($query) use ($validatedData) {
                        $query->where('start_time', '<=', $validatedData['start_time'])
                            ->where('end_time', '>=', $validatedData['start_time']);
                    })->orWhere(function ($query) use ($validatedData) {
                        $query->where('start_time', '<=', $validatedData['end_time'])
                            ->where('end_time', '>=', $validatedData['end_time']);
                    })->orWhere(function ($query) use ($validatedData) {
                        $query->where('start_time', '>=', $validatedData['start_time'])
                            ->where('start_time', '<=', $validatedData['end_time'])
                            ->orWhere('end_time', '>=', $validatedData['start_time'])
                            ->where('end_time', '<=', $validatedData['end_time']);
                    });
                })
                ->get();

            if ($conflicts->count() == 0) {
                ScheduleDate::create([
                    'teacher_class_id' => $teacherClassId,
                    'date' => $date,
                    'start_time' => $start_time,
                    'end_time' => $end_time
                ]);
            }
        }
    }
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

    private function getDates($start_date, $end_date, $days)
    {
        $dates = [];
        $start_date = new \DateTime($start_date);
        $end_date = new \DateTime($end_date);
        $interval = \DateInterval::createFromDateString('1 day');
        $period = new \DatePeriod($start_date, $interval, $end_date);
        foreach ($period as $dt) {
            foreach ($days as $day) {
                if ($dt->format("l") === $day) {
                    $dates[] = $dt->format("Y-m-d");
                }
            }
        }

        return $dates;
    }
}
