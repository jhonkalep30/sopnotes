<?php

namespace Database\Seeders;

use App\Models\Reference\Classifier;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ClassifierSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Classifier::firstOrCreate(['name' => '0']);
        Classifier::firstOrCreate(['name' => 'Kantor Pusat']);
        Classifier::firstOrCreate(['name' => 'Admin PCR']);
        Classifier::firstOrCreate(['name' => 'ATLM']);
        Classifier::firstOrCreate(['name' => 'Bidan']);
        Classifier::firstOrCreate(['name' => 'Front Office']);
        Classifier::firstOrCreate(['name' => 'PJ MCU']);
        Classifier::firstOrCreate(['name' => 'Perawat']);
        Classifier::firstOrCreate(['name' => 'PIC Klinik']);
        Classifier::firstOrCreate(['name' => 'Radiografer']);
        Classifier::firstOrCreate(['name' => 'Sales Executive']);
        Classifier::firstOrCreate(['name' => 'Service Manager']);
    }
}
