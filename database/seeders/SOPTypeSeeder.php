<?php

namespace Database\Seeders;

use App\Models\Reference\SOPType;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SOPTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        SOPType::firstOrCreate(['name' => 'SOP Bulanan']);
        SOPType::firstOrCreate(['name' => 'SOP Mingguan']);
        SOPType::firstOrCreate(['name' => 'SOP Harian']);
        SOPType::firstOrCreate(['name' => 'SOP Rutin']);
    }
}
