<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $permissions = [
            'view_users', 'create_users', 'update_users', 'delete_users',
            'view_roles', 'create_roles', 'update_roles', 'delete_roles',
            'view_categories', 'create_categories', 'update_categories', 'delete_categories',
            'view_posts', 'create_posts', 'update_posts', 'delete_posts', 'publish_posts',
            'manage_settings',
        ];

        foreach ($permissions as $permission) {
            \App\Models\Permission::firstOrCreate(['name' => $permission]);
        }
    }
}
