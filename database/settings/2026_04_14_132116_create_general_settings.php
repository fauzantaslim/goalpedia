<?php

use Spatie\LaravelSettings\Migrations\SettingsMigration;

return new class extends SettingsMigration
{
    public function up(): void
    {
        $this->migrator->add('general.site_name', config('app.name', 'Finlogy'));
        $this->migrator->add('general.site_description', 'Finlogy — media literasi finansial yang menyajikan wawasan mendalam seputar investasi, keuangan pribadi, dan perencanaan keuangan untuk keputusan finansial yang lebih cerdas.');
        $this->migrator->add('general.logo_url', null);
        $this->migrator->add('general.logo_small_url', null);
        $this->migrator->add('general.logo_large_url', null);
        $this->migrator->add('general.facebook_url', null);
        $this->migrator->add('general.instagram_url', null);
        $this->migrator->add('general.x_url', null);
        $this->migrator->add('general.default_meta_title', 'Finlogy — Blog Literasi Finansial & Investasi');
        $this->migrator->add('general.default_meta_description', 'Baca artikel mendalam seputar literasi finansial, tips investasi, dan perencanaan keuangan pribadi. Finlogy membantu Anda membuat keputusan keuangan yang lebih cerdas.');
    }
};
