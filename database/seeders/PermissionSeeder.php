<?php

namespace Database\Seeders;

use App\Models\Permission;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $merchantId = 1; // غيّره حسب ID التاجر الذي تريده
        $createdBy = 1;  // ID المستخدم الذي أنشأها

        $permissions = [
            ['key' => 'overview_page'],
            ['key' => 'services_view'],
            ['key' => 'services_create'],
            ['key' => 'services_edit'],
            ['key' => 'services_delete'],

            ['key' => 'check'],
            ['key' => 'ratings'],
            ['key' => 'reservations'],


            ['key' => 'Pos'],
            ['key' => 'Pos_create'],
            ['key' => 'Pos_edit'],
            ['key' => 'Pos_delete'],


            ['key' => 'reports'],
            ['key' => 'notificatons'],
            ['key' => 'messages'],
            ['key' => 'wallet_and_payments'],

            ['key' => 'branchs_view'],
            ['key' => 'branches_create'],
            ['key' => 'branches_edit'],
            ['key' => 'branches_delete'],

            ['key' => 'team_manager_view'],
            ['key' => 'team_manager_actions'],
            ['key' => 'team_manager_create'],
            ['key' => 'team_manager_edit'],
            ['key' => 'team_manager_delete'],

            ['key' => 'setup_page'],
            ['key' => 'languages_view'],
            ['key' => 'languages_create'],
            ['key' => 'languages_edit'],
            ['key' => 'languages_delete'],


            ['key' => 'settings_view'],
            ['key' => 'settings_edit'],
            ['key' => 'history_view'],
        ];

        foreach ($permissions as $permission) {
            Permission::create([
                'key' => $permission['key'],
            ]);
        }
    }
}
