<?php

namespace Database\Seeders;

use App\Models\SiteSetting;
use App\Settings\GeneralSettings;
use Illuminate\Database\Seeder;

class SiteSettingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Update General Settings (spatie/laravel-settings)
        $settings = app(GeneralSettings::class);
        $settings->site_name = 'Goalpedia';
        $settings->site_description = 'Goalpedia — platform konten sepak bola yang bersih, modern, dan sporty yang menyajikan berita terkini, statistik lengkap, dan analisis mendalam bagi para pecinta sepak bola.';
        $settings->default_meta_title = 'Goalpedia — Platform Berita & Statistik Sepak Bola Terkini';
        $settings->default_meta_description = 'Dapatkan berita sepak bola terbaru, statistik lengkap, dan analisis mendalam dari seluruh dunia. Goalpedia — Teman setia pecinta sepak bola.';
        $settings->save();

        // Ensure the SiteSetting model exists (for media collections if needed)
        if (SiteSetting::count() === 0) {
            SiteSetting::create([]);
        }
    }
}
