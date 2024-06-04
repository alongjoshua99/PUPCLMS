<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SemesterSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        /* generate a semester data 1st to 4th and add summer */
        $data = [
            [
                'name' => '1st Semester',
                'start_date' => '2023-06-01',
                'end_date' => '2023-10-31',
            ],
            [
                'name' => 'Summer',
                'start_date' => '2023-11-01',
                'end_date' => '2024-03-31',
            ],
            [
                'name' => '2nd Semester',
                'start_date' => '2024-04-01',
                'end_date' => '2024-07-31',
            ],
        ];

        foreach ($data as $key => $value) {
            \App\Models\Semester::create($value);
        }

    }
}
