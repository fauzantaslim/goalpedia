<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $admin = \App\Models\User::firstOrCreate(
            ['email' => 'admin@goalpedia.loc'],
            [
                'name' => 'Super Admin',
                'password' => \Illuminate\Support\Facades\Hash::make('password'),
                'email_verified_at' => now(),
                'bio' => 'Platform Administrator',
            ]
        );
        if (!$admin->hasRole('super_admin')) {
            $admin->assignRole('super_admin');
        }

        $editor = \App\Models\User::firstOrCreate(
            ['email' => 'editor@goalpedia.loc'],
            [
                'name' => 'Editor',
                'password' => \Illuminate\Support\Facades\Hash::make('password'),
                'email_verified_at' => now(),
                'bio' => 'Content Editor',
            ]
        );
        if (!$editor->hasRole('editor')) {
            $editor->assignRole('editor');
        }

        $writer = \App\Models\User::firstOrCreate(
            ['email' => 'writer@goalpedia.loc'],
            [
                'name' => 'Writer',
                'password' => \Illuminate\Support\Facades\Hash::make('password'),
                'email_verified_at' => now(),
                'bio' => 'Content Writer',
            ]
        );
        if (!$writer->hasRole('writer')) {
            $writer->assignRole('writer');
        }

        if (\App\Models\User::count() <= 3) {
            \App\Models\User::factory(10)->create()->each(function ($user) {
                $user->assignRole('user');
            });
        }
    }
}
