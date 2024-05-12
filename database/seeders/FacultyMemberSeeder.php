<?php

namespace Database\Seeders;

use Faker\Factory;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class FacultyMemberSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = Factory::create();
        $data = [
            [
                'first_name' => $faker->firstName(),
                'last_name' => $faker->lastName(),
                'email' => 'pupadmin@app.com',
                'phone' => '09123456789',
                'department_id' => 1,
            ],
            [
                'first_name' => $faker->firstName(),
                'last_name' => $faker->lastName(),
                'email' => 'puphead@app.com',
                'phone' => '09123456789',
                'department_id' => 2,
            ],
            [
                'first_name' => $faker->firstName(),
                'last_name' => $faker->lastName(),
                'email' => 'pupfaculty@app.com',
                'phone' => '09123456789',
                'department_id' => 2,
            ],
            [
                'first_name' => $faker->firstName(),
                'last_name' => $faker->lastName(),
                'email' => 'pupfaculty1@app.com',
                'phone' => '09123456783',
                'department_id' => 3,
            ],
            [
                'first_name' => $faker->firstName(),
                'last_name' => $faker->lastName(),
                'email' => 'pupfaculty2@app.com',
                'phone' => '09123456723',
                'department_id' => 3,
            ],
            [
                'first_name' => $faker->firstName(),
                'last_name' => $faker->lastName(),
                'email' => 'pupfaculty3@app.com',
                'phone' => '09123456781',
                'department_id' => 3,
            ],

        ];
        foreach ($data as $item) {
            \App\Models\FacultyMember::create($item);
        }
    }
}
