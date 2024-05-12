<?php

namespace Database\Seeders;

use App\Models\FacultyMember;
use App\Models\Student;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
            [
                'email' => FacultyMember::find(1)->email,
                'password' => Hash::make('password'),
                'role_id' => 1,
                'faculty_member_id' => 1,
            ],
            [
                'email' => FacultyMember::find(2)->email,
                'password' => Hash::make('password'),
                'role_id' => 2,
                'faculty_member_id' => 2,
            ],
            [
                'email' => FacultyMember::find(3)->email,
                'password' => Hash::make('password'),
                'role_id' => 2,
                'faculty_member_id' => 3,
            ],
            [
                'email' => FacultyMember::find(4)->email,
                'password' => Hash::make('password'),
                'role_id' => 2,
                'faculty_member_id' => 4,
            ],
            [
                'email' => FacultyMember::find(5)->email,
                'password' => Hash::make('password'),
                'role_id' => 2,
                'faculty_member_id' => 5,
            ],
            [
                'email' => FacultyMember::find(6)->email,
                'password' => Hash::make('password'),
                'role_id' => 2,
                'faculty_member_id' => 6,
            ],
        ];
        foreach ($data as $item) {
            \App\Models\User::create($item);
        }
    }
}
