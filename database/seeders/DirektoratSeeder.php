<?php

namespace Database\Seeders;

use App\Models\Reference\Direktorat;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DirektoratSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Direktorat::firstOrCreate(['name' => 'DIREKTORAT UTAMA']);
        Direktorat::firstOrCreate(['name' => 'DIREKTORAT KEUANGAN, SDM & UMUM']);
        Direktorat::firstOrCreate(['name' => 'DIREKTORAT OPERASIONAL']);
    }
}
