<?php

namespace Database\Seeders;

use App\Models\Reference\UnitBisnis;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UnitBisnisSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        UnitBisnis::firstOrCreate(['name' => 'FUNGSIONAL RUJUKAN TEKNIS']);
        UnitBisnis::firstOrCreate(['name' => 'KANTOR PUSAT']);
        UnitBisnis::firstOrCreate(['name' => 'RSM - UNIT BISNIS JABAR 1']);
        UnitBisnis::firstOrCreate(['name' => 'RSM - UNIT BISNIS SUMATERA 1']);
        UnitBisnis::firstOrCreate(['name' => 'RSM - UNIT BISNIS SUMATERA 3']);
        UnitBisnis::firstOrCreate(['name' => 'RSM - UNIT NATIONAL SALES']);
        UnitBisnis::firstOrCreate(['name' => 'UNIT BISNIS BALI NUSRA']);
        UnitBisnis::firstOrCreate(['name' => 'UNIT BISNIS BANTEN 1']);
        UnitBisnis::firstOrCreate(['name' => 'UNIT BISNIS BANTEN 2']);
        UnitBisnis::firstOrCreate(['name' => 'UNIT BISNIS JABAR 1']);
        UnitBisnis::firstOrCreate(['name' => 'UNIT BISNIS JABAR 2']);
        UnitBisnis::firstOrCreate(['name' => 'UNIT BISNIS JABAR 3']);
        UnitBisnis::firstOrCreate(['name' => 'UNIT BISNIS JABAR 4']);
        UnitBisnis::firstOrCreate(['name' => 'UNIT BISNIS JABAR 5']);
        UnitBisnis::firstOrCreate(['name' => 'UNIT BISNIS JAKARTA 1']);
        UnitBisnis::firstOrCreate(['name' => 'UNIT BISNIS JAKARTA 2']);
        UnitBisnis::firstOrCreate(['name' => 'UNIT BISNIS JATENG 1']);
        UnitBisnis::firstOrCreate(['name' => 'UNIT BISNIS JATENG 2']);
        UnitBisnis::firstOrCreate(['name' => 'UNIT BISNIS JATIM 1']);
        UnitBisnis::firstOrCreate(['name' => 'UNIT BISNIS JATIM 2']);
        UnitBisnis::firstOrCreate(['name' => 'UNIT BISNIS KALIMANTAN 1']);
        UnitBisnis::firstOrCreate(['name' => 'UNIT BISNIS KALIMANTAN 2']);
        UnitBisnis::firstOrCreate(['name' => 'UNIT BISNIS KALIMANTAN 3']);
        UnitBisnis::firstOrCreate(['name' => 'UNIT BISNIS SULAWESI 1']);
        UnitBisnis::firstOrCreate(['name' => 'UNIT BISNIS SULAWESI 2']);
        UnitBisnis::firstOrCreate(['name' => 'UNIT BISNIS SUMATERA 1']);
        UnitBisnis::firstOrCreate(['name' => 'UNIT BISNIS SUMATERA 2']);
        UnitBisnis::firstOrCreate(['name' => 'UNIT BISNIS SUMATERA 3']);
        UnitBisnis::firstOrCreate(['name' => 'UNIT BISNIS SUMATERA 4']);
        UnitBisnis::firstOrCreate(['name' => 'UNIT BISNIS SUMATERA 5']);
    }
}
