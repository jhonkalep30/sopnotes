<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Database\Seeders\MasterSeeder;
use Database\Seeders\UserManagementSeeder;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call(MasterSeeder::class);
        $this->call(UserManagementSeeder::class);
    }
}
