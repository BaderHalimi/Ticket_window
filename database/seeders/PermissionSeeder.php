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
            ['key' => 'services_actions'],
        ];

        foreach ($permissions as $permission) {
            Permission::create([
                'key' => $permission['key'],
                'merchant_id' => $merchantId,
                'created_by' => $createdBy,
            ]);
        }
    }
}
