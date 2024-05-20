<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ComputerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        for ($i=1; $i <=36; $i++) {
            \App\Models\Computer::create([
                'computer_number' => $i,
                'computer_name' => 'Computer '. $i,
                'os' => 'Windows 10',
                'processor' => 'Intel Core i5',
                'memory' => '8GB',
                'storage' => '500GB',
                'graphics' => 'Nvidia GTX 1050',
            ]);
        }
    }
}
