<?php

namespace App\Exports;

use App\Models\Course;
use Faker\Factory as Faker;
use Illuminate\Support\Str;
use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\WithHeadings;

class StudentsExport implements FromArray, WithHeadings
{
    public function headings(): array
    {
        return [
            'Student Number', 'First Name', 'Last Name', 'Email', 'Phone', 'Address', 'Section', 'Course'
        ];
    }

    public function array(): array
    {
        $faker = Faker::create();
        $students = [];

        // Define sample sections and courses
        $sections = [
            ['section_name' => 'BSIT-1A', 'course_id' => 1],
            ['section_name' => 'BSIT-1B', 'course_id' => 1],
            ['section_name' => 'BSIT-1C', 'course_id' => 1],
            ['section_name' => 'BSENT-1A', 'course_id' => 2],
            ['section_name' => 'BSENT-1B', 'course_id' => 2],
            ['section_name' => 'BSENT-1C', 'course_id' => 2],
            ['section_name' => 'BSED-1A', 'course_id' => 3],
            ['section_name' => 'BSED-1B', 'course_id' => 3],
            ['section_name' => 'BSED-1C', 'course_id' => 3],
        ];



        for ($i = 0; $i < 100; $i++) {
            $section = $faker->randomElement($sections);
            $students[] = [
                'student_number' => now()->format('Y') . '-' . Str::padLeft($i + 1, 4, 0) . '-CL-0',
                'first_name' => $faker->firstName,
                'last_name' => $faker->lastName,
                'email' => $faker->unique()->safeEmail,
                'phone' => $faker->phoneNumber,
                'address' => $faker->address,
                'section_id' => $section['section_name'],
                'course_id' => Course::find($section['course_id'])->course_code,
            ];
        }

        return $students;
    }
}
