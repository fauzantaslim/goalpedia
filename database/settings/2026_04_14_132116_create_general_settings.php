<?php

use Spatie\LaravelSettings\Migrations\SettingsMigration;

return new class extends SettingsMigration
{
    public function up(): void
    {
        $this->migrator->add('general.site_name', config('app.name', 'Goalpedia'));
        $this->migrator->add('general.site_description', 'Goalpedia — media informasi sepak bola yang menyajikan wawasan mendalam, analisis pertandingan, dan kabar terbaru dari lapangan hijau untuk pecinta sepak bola sejati.');
        $this->migrator->add('general.logo_url', null);
        $this->migrator->add('general.logo_small_url', null);
        $this->migrator->add('general.logo_large_url', null);
        $this->migrator->add('general.facebook_url', null);
        $this->migrator->add('general.instagram_url', null);
        $this->migrator->add('general.x_url', null);
        $this->migrator->add('general.default_meta_title', 'Goalpedia — Portal Berita & Analisis Sepak Bola');
        $this->migrator->add('general.default_meta_description', 'Baca berita terkini seputar dunia sepak bola, analisis taktik mendalam, dan statistik liga-liga top dunia. Goalpedia membantu Anda memahami permainan lebih dari sekadar skor.');
    }
};
