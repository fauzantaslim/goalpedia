<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        $superAdmin = \App\Models\Role::firstOrCreate(['name' => 'super_admin']);
        $editor = \App\Models\Role::firstOrCreate(['name' => 'editor']);
        $writer = \App\Models\Role::firstOrCreate(['name' => 'writer']);
        $user = \App\Models\Role::firstOrCreate(['name' => 'user']);

        $editor->syncPermissions([
            'view_categories', 'create_categories', 'update_categories', 'delete_categories',
            'view_posts', 'create_posts', 'update_posts', 'delete_posts', 'publish_posts',
        ]);

        $writer->syncPermissions([
            'view_posts', 'create_posts', 'update_posts', 'delete_posts',
        ]);

        $superAdmin->syncPermissions(\App\Models\Permission::all());
    }
}
