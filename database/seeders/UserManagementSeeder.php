<?php

namespace Database\Seeders;

use App\Models\ACL\Menu;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserManagementSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // ADD SECTION
        $dashboard = Menu::updateOrCreate([
            'type' => 'section',
            'label' => 'Dashboard',
            'order' => -999999,
        ]);

        // ADD LINKS :: DASHBOARD
        $dashboardLink = Menu::updateOrCreate([
            'type' => 'link',
            'label' => 'Dashboard',
            'order' => 1,
            'url' => 'admin/dashboard',
            'parent_id' => $dashboard->id,
            'icon' => '<i class="ki-duotone ki-chart-line">
                         <i class="path1"></i>
                         <i class="path2"></i>
                        </i>'
        ]);

        // ADD SECTION
        $section = Menu::updateOrCreate([
            'type' => 'section',
            'label' => 'User Management',
            'order' => 999999,
        ]);

        // ADD LINKS :: USER
        $userLink = Menu::updateOrCreate([
            'type' => 'link',
            'label' => 'Users',
            'order' => 1,
            'url' => 'admin/user',
            'parent_id' => $section->id,
            'icon' => '<i class="ki-duotone ki-profile-user">
                         <i class="path1"></i>
                         <i class="path2"></i>
                         <i class="path3"></i>
                         <i class="path4"></i>
                        </i>'
        ]);

        // ADD LINKS :: ROLE
        $roleLink = Menu::updateOrCreate([
            'type' => 'link',
            'label' => 'Roles',
            'order' => 2,
            'url' => 'admin/role',
            'parent_id' => $section->id,
            'icon' => '<i class="ki-duotone ki-user-tick">
                         <i class="path1"></i>
                         <i class="path2"></i>
                         <i class="path3"></i>
                        </i>'
        ]);
    }
}
