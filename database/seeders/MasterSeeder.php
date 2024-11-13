<?php

namespace Database\Seeders;

use App\Models\ACL\Role;
use App\Models\ACL\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class MasterSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // CREATE MASTER
        $role = Role::updateOrCreate([
            'name' => 'Master',
            'is_master' => 1,
        ]);
        
        $user = User::updateOrCreate([
            'name' => 'Master Admin',
            'email' => 'admin@master.sys',
        ],[
            'role_id' => $role->id, 
            'password' => bcrypt('master123')
        ]);
    }
}
