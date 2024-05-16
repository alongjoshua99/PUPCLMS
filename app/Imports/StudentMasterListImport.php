<?php

namespace App\Imports;

use App\Models\Course;
use App\Models\Section;
use App\Models\Student;
use App\Models\StudentMasterList;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Maatwebsite\Excel\Concerns\ToModel;
use Illuminate\Validation\Rule;
use Maatwebsite\Excel\Concerns\Importable;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;

class StudentMasterListImport implements ToModel, WithValidation, WithHeadingRow
{
    use Importable;
    public function model(array $row)
    {
        // Find section and course by name or code
        $section = Section::where('section_name', 'like', '%' . $row['section'] . '%')->first();
        $course = Course::where('course_code', 'like', '%' . $row['course'] . '%')->first();
        $sy = getCurrentSY();

        $student = Student::where('student_no', $row['student_number'])->first();

        if ($student) {
            // Update existing student
            $student->update([
                'student_no' => $row['student_number'],
                'first_name' => $row['first_name'],
                'last_name' => $row['last_name'],
                'email' => $row['email'],
                'phone' => $row['phone'],
                'address' => $row['address'],
                'section_id' => $section->id,
                'course_id' => $course->id,
                'sy_id' => $sy->id,
            ]);

            // Update user email if exists
            if ($student->user) {
                $student->user()->update([
                    'email' => $row['email'],
                ]);
            } else {
                // Create user for the new student
                User::create([
                    'email' => $row['email'],
                    'password' => Hash::make('password'),
                    'student_id' => $student->id,
                    'role_id' => 4,
                    'force_change_password' => true,
                ]);
            }

            return $student;
        } else {
            // Create new student
            $student = new Student([
                'student_no' => $row['student_number'],
                'first_name' => $row['first_name'],
                'last_name' => $row['last_name'],
                'email' => $row['email'],
                'phone' => $row['phone'],
                'address' => $row['address'],
                'section_id' => $section->id,
                'course_id' => $course->id,
                'sy_id' => $sy->id,
            ]);

            $student->save();

            // Create user for the new student
            User::create([
                'email' => $row['email'],
                'password' => Hash::make('password'),
                'student_id' => $student->id,
                'role_id' => 4,
                'force_change_password' => true,
            ]);

            return $student;
        }
    }


    public function rules(): array
    {
        return [
            //   'student_number' => ['required', Rule::unique('student_master_lists', 'student_id_number')],
            'student_number' => ['required'],
            'first_name' => ['required'],
            'last_name' => ['required'],
            'email' => ['required'],
            'phone' => ['required'],
            'address' => ['required'],
            'section' => ['required'],
            'course' => ['required'],
        ];
    }
}
