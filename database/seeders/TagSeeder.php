<?php

namespace Database\Seeders;

use App\Models\Post;
use Illuminate\Database\Seeder;
use Spatie\Tags\Tag;

class TagSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Kumpulan tag editorial seputar dunia sepak bola
        $sportsTags = [
            'Transfer Musim Panas', 'Rumor Transfer', 'Liga Inggris', 
            'Manchester United', 'Real Madrid', 'Barcelona', 'Juventus',
            'AC Milan', 'Inter Milan', 'Bayern Munich', 'PSG',
            'Lionel Messi', 'Cristiano Ronaldo', 'Kylian Mbappe', 
            'Erling Haaland', 'Jude Bellingham', 'Pep Guardiola', 
            'Jurgen Klopp', 'Carlo Ancelotti', 'Jose Mourinho',
            'Liga Champions', 'Europa League', 'Piala Dunia', 
            'Euro 2024', 'Copa America', 'Timnas Indonesia', 
            'Shin Tae-yong', 'Garuda Muda', 'PSSI', 'Analisis Taktik', 
            'Statistik Pertandingan', 'VAR', 'Wonderkid', 'Legenda'
        ];

        // Buat tag ke dalam database terlebih dahulu (opsional, spatie/laravel-tags sebenarnya auto-create)
        // Tapi ini baik agar urutan dan translation terbuat dengan benar.
        foreach ($sportsTags as $tagName) {
            Tag::findOrCreate($tagName);
        }

        // Ambil semua post
        $posts = Post::all();

        if ($posts->isEmpty()) {
            $this->command->warn('Tidak ada Post yang ditemukan. Jalankan PostSeeder terlebih dahulu.');
            return;
        }

        $this->command->info('Memulai seeding Tag untuk ' . $posts->count() . ' artikel...');

        // Pasangkan 3-6 tag random untuk setiap post
        foreach ($posts as $post) {
            // Pilih 3 hingga 6 tag acak
            $randomTags = collect($sportsTags)->random(rand(3, 6))->toArray();
            
            // Sync tags (menghapus yang lama, dan memasukkan yang baru)
            $post->syncTags($randomTags);
        }

        $this->command->info('Tag berhasil dihubungkan ke artikel!');
    }
}
