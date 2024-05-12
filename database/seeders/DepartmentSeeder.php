<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DepartmentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
            [
                'department_name' => 'Developer',
                'description' => 'WEbsite Developer',
            ],
            [
                'department_name' => 'Head Director',
                'description' => 'Head Director',
            ],
            [
                'department_name' => 'Teacher',
                'description' => 'Teacher',
            ],
            [
                'department_name' => 'Registrar',
                'description' => 'Registrar',
            ],
            [
                'department_name' => 'IT',
                'description' => 'IT',
            ],
        ];
        foreach ($data as $item) {
            \App\Models\Department::create($item);
        }
    }
}
