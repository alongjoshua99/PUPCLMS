<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SchoolYearSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
            [
                'name' => '2023-2024',
                'start_date' => '2023-06-01',
                'end_date' => '2024-05-31',
                'is_active' => true,
                'semester_id' => 3,
            ],
        ];
        foreach ($data as $key => $value) {
            \App\Models\SchoolYear::create($value);
        }
    }
}
