<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Post;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class PostSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $writer = User::where('email', 'writer@goalpedia.loc')->first();
        $editor = User::where('email', 'editor@goalpedia.loc')->first();

        // Fallback to first users if not found
        if (! $writer || ! $editor) {
            $writer = User::first();
            $editor = User::orderBy('id', 'desc')->first();
        }

        $postDataList = [
            // ── Kompetisi → Liga Inggris ────────────────────────────────────
            'Liga Inggris' => [
                'Persaingan Gelar Premier League: Mampukah Arsenal Menghentikan Dominasi Man City?',
                'Analisis Taktik Liverpool di Bawah Pelatih Baru: Kembali ke Era Heavy Metal?',
                'Krisis Manchester United: Apa yang Salah di Carrington?',
                'Bintang Muda yang Wajib Diwaspadai di Premier League Musim Ini',
                'Kenapa Premier League Masih Menjadi Liga Terbaik di Dunia?',
            ],
            // ── Kompetisi → Liga Spanyol ────────────────────────────────────
            'Liga Spanyol' => [
                'El Clasico 2025: Peta Kekuatan Real Madrid vs Barcelona Saat Ini',
                'Ancelotti dan Filosofi Pragmatisnya: Mengapa Real Madrid Susah Dikalahkan?',
                'Revolusi Xavi di Barcelona: Generasi Baru Blaugrana Mulai Berbuah',
                'Atletico Madrid — Simeone dan Pertahanan yang Tak Pernah Mati',
                'La Liga Kembali Bersaing Ketat: Siapa Calon Juara Musim Ini?',
            ],
            // ── Kompetisi → Liga Italia ─────────────────────────────────────
            'Liga Italia' => [
                'Inter Milan di Puncak Serie A: Rahasia Konsistensi Inzaghi',
                'Kembalinya Juventus: Apakah La Vecchia Signora Siap Juara Lagi?',
                'AC Milan di Persimpangan: Proyek Jangka Panjang atau Krisis Identitas?',
                'Napoli Pasca-Scudetto: Tantangan Mempertahankan Dominasi',
                'Pemain-Pemain Serie A yang Siap Bersinar di Panggung Eropa',
            ],
            // ── Kompetisi → Liga Champions ──────────────────────────────────
            'Liga Champions' => [
                'Prediksi Final Liga Champions: Siapa yang Akan Mengangkat Si Kuping Besar?',
                'Malam Keajaiban di Bernabeu: Bagaimana Real Madrid Selalu Menang?',
                'Format Baru Liga Champions: Lebih Seru atau Justru Membingungkan?',
                'Tim Kuda Hitam yang Siap Mengejutkan Raksasa Eropa Musim Ini',
            ],
            // ── Kompetisi → Liga Europa ─────────────────────────────────────
            'Liga Europa' => [
                'Liga Europa 2025: Kompetisi yang Kini Semakin Bergengsi',
                'Atalanta dan Seni Bermain di Dua Front: Mampukah Bertahan?',
                'Kejutan Liga Europa: Klub Kecil yang Tak Gentar Melawan Raksasa',
                'Mengapa Feyenoord Menjadi Tim Paling Ditakuti di Liga Europa?',
            ],
            // ── Kompetisi → Liga Arab ───────────────────────────────────────
            'Liga Arab' => [
                'Gelombang Bintang Dunia ke Saudi Pro League: Tren atau Ancaman?',
                'Ronaldo di Al-Nassr: Dampak Nyata bagi Sepak Bola Timur Tengah',
                'Liga Arab vs Liga Eropa: Adu Gengsi Kualitas dan Finansial',
                'Pemain Lokal Saudi yang Mulai Bersinar di Tengah Gempuran Bintang Asing',
            ],
            // ── Kompetisi → MLS ─────────────────────────────────────────────
            'MLS' => [
                'Messi Effect di MLS: Bagaimana Inter Miami Menjadi Fenomena Global?',
                'MLS Menuju Level Berikutnya: Investasi dan Pembangunan Infrastruktur',
                'Pemain Eropa yang Memilih MLS di Akhir Karier: Liburan atau Kompetisi Serius?',
                'Akademi Sepak Bola AS dan Masa Depan Timnas Amerika Serikat',
            ],
            // ── Indonesia → Liga 1 ──────────────────────────────────────────
            'Liga 1' => [
                'Persib vs Persija: Sejarah Rivalitas Terbesar di Sepak Bola Indonesia',
                'Inovasi VAR di Liga 1: Solusi Adil atau Malah Menghambat Permainan?',
                'Dominasi Borneo FC: Rahasia di Balik Konsistensi Pesut Etam Musim Ini',
                'Masa Depan Pemain Muda di Liga 1: Mengapa Menit Bermain Sangat Penting?',
            ],
            // ── Indonesia → Timnas Indonesia ────────────────────────────────
            'Timnas Indonesia' => [
                'Jalan Menuju Piala Dunia: Skenario Timnas Indonesia Lolos Babak Ketiga',
                'Efek Jay Idzes di Lini Belakang: Mengapa Pertahanan Garuda Kini Lebih Solid?',
                'Shin Tae-yong dan Revolusi Mental di Tubuh Timnas Indonesia',
                'Bakat Lokal vs Keturunan: Membangun Kedalaman Skuad Garuda yang Ideal',
                'Dukungan Suporter Indonesia: Pemain Ke-12 yang Paling Ditakuti di Asia',
            ],
            // ── Berita → Transfer ────────────────────────────────────────────
            'Transfer' => [
                'Rekap Bursa Transfer Musim Panas: Siapa Pemenang Terbesarnya?',
                'Bocoran Transfer: Real Madrid Siapkan Dana Fantastis untuk Target Baru',
                'Kenapa Banyak Pemain Bintang Kini Memilih Pindah ke Liga Arab Saudi?',
                'Update Transfer Liga 1: Persebaya Incar Pemain Asing Baru',
            ],
            // ── Berita → Rumor ──────────────────────────────────────────────
            'Rumor' => [
                'Rumor Pasar: 5 Nama Panas yang Dikaitkan dengan Klub Top Eropa',
                'Mbappé ke Mana Setelah Real Madrid? Rumor yang Mengguncang Pasar',
                'Apakah Guardiola Benar-Benar akan Tinggalkan Man City di Akhir Musim?',
                'Nama-Nama Manajer yang Disebut-sebut Akan Gantikan Ten Hag di United',
            ],
            // ── Berita → Highlight ───────────────────────────────────────────
            'Highlight' => [
                'Gol-gol Terbaik Pekan Ini dari Seluruh Liga Top Dunia',
                'Highlight Pertandingan: Comeback Dramatis di Derby London',
                'Aksi Penyelamatan Gemilang Kiper yang Menentukan Hasil Laga',
            ],
            // ── Statistik → Klasemen ─────────────────────────────────────────
            'Klasemen' => [ 
                'Update Klasemen Premier League: Siapa Memimpin Pekan Ini?',
                'Klasemen Sementara Serie A: Persaingan Empat Besar Kian Sengit',
                'Klasemen Liga 1 Terkini: Persib Tetap Kokoh di Puncak',
                'Perbandingan Klasemen Liga Top Eropa: Mana yang Paling Kompetitif?',
            ],
            // ── Statistik → Top Skor ─────────────────────────────────────────
            'Top Skor' => [
                'Daftar Top Skor Premier League: Siapa yang Akan Meraih Sepatu Emas?',
                'Haaland vs Firmino vs Darwin: Siapa Raja Gol Musim Ini?',
                'Top Skor Liga Champions: Mesin Gol yang Menentukan Nasib Klub',
                'Daftar Pencetak Gol Terbanyak Liga 1 Musim Ini',
            ],
            // ── Statistik → Jadwal ───────────────────────────────────────────
            'Jadwal' => [
                'Jadwal Lengkap Liga Champions Pekan Ini: Derbi-Derbi Seru Menanti',
                'Jadwal Liga Inggris Akhir Pekan: Clash of Titans di Anfield',
                'Jadwal Timnas Indonesia: Pertandingan Krusial Menuju Kualifikasi',
                'Jadwal Liga 1 Pekan Depan: Laga Penentu Posisi Klasemen',
            ],
            // ── Pemain (parent, no child) ────────────────────────────────────
            'Pemain' => [
                'Profil Kylian Mbappé: Generasi Terpilih yang Mewarisi Takhta Ronaldo-Messi',
                'Mengintip Dunia Erling Haaland: Mesin Gol Berdarah Dingin dari Norwegia',
                'Vinicius Jr. — Dari Favela ke Panggung El Clasico',
                'Sosok Jude Bellingham: Pemain Serbabisa yang Lahir Sekali Seabad',
                'Pemain Timnas Indonesia yang Berkarier di Luar Negeri: Jejak dan Mimpi Besar',
            ],
            // ── Klub (parent, no child) ──────────────────────────────────────
            'Klub' => [
                'Sejarah Panjang Real Madrid: Lebih dari Sekadar Klub Sepak Bola',
                'Barcelona di Era Post-Messi: Membangun Ulang Identitas Tiki-Taka',
                'Manchester City dan Proyek Ambisius Sheikh Mansour: Dari Gelap ke Cahaya',
                'Klub Sepak Bola Indonesia yang Punya Sejarah Paling Kaya',
                'Persib Bandung: Ibu Kota Kedua Bobotoh yang Tersebar di Seluruh Nusantara',
            ],
            // ── Insight (parent, no child) ───────────────────────────────────
            'Insight' => [
                'Evolusi Formasi Sepak Bola: Dari WM ke False Nine Hingga Inverted Fullback',
                'Bisnis di Balik Sepak Bola: Bagaimana Klub Mengelola Dana Triliunan Rupiah?',
                'Psikologi Pemain: Mengatasi Tekanan di Stadion dengan 80 Ribu Penonton',
                'Pentingnya Sport Science dalam Meningkatkan Performa Atlet Modern',
            ],
        ];

        foreach ($postDataList as $categoryName => $titles) {
            $category = Category::where('name', $categoryName)->first();
            if (! $category) {
                continue;
            }

            foreach ($titles as $index => $title) {
                $status = 'published';

                Post::firstOrCreate(
                    ['title' => $title],
                    [
                        'slug' => Str::slug($title),
                        'category_id' => $category->id,
                        'user_id' => ($index % 2 == 0) ? $writer->id : $editor->id,
                        'excerpt' => $this->generateExcerpt($title),
                        'content' => $this->generateFootballContent($title, $categoryName),
                        'status' => $status,
                        'published_at' => now()->subDays(rand(1, 30))->addHours(rand(1, 24)),
                        'views_count' => rand(1000, 50000),
                    ]
                );
            }
        }
    }

    private function generateExcerpt(string $title): string
    {
        return "Simak ulasan mendalam mengenai {$title}. Dapatkan analisis taktik, statistik pemain, dan informasi terkini hanya di Goalpedia.";
    }

    private function generateFootballContent(string $title, string $categoryName): string
    {
        return <<<HTML
<div class="cms-content">
    <p class="lead" style="font-size: 1.25rem; font-weight: 500; color: #374151;">
        <strong>Sepak bola bukan sekadar permainan 90 menit di lapangan hijau, melainkan drama yang melibatkan emosi, strategi, dan sejarah.</strong>
    </p>

    <p>Membahas tentang <em>{$title}</em> membawa kita pada pemahaman baru bagaimana olahraga ini terus berevolusi. Di Goalpedia, kami percaya bahwa setiap detail kecil—mulai dari pergerakan tanpa bola hingga perubahan formasi di tengah laga—memiliki cerita yang layak untuk diulas.</p>

    <h2 style="color: #093FB4;">Mengapa Topik Ini Menarik?</h2>
    <p>Dalam konstelasi sepak bola modern, data dan statistik menjadi kunci, namun semangat dan determinasi pemain tetap menjadi jiwa dari permainan ini. Fenomena yang terjadi di sektor <strong>{$categoryName}</strong> saat ini menunjukkan betapa dinamisnya dunia sepak bola.</p>

    <blockquote style="border-left: 4px solid #ED3500; padding-left: 1rem; font-style: italic; color: #374151;">
        "Sepak bola adalah hal paling penting dari hal-hal yang tidak penting di dunia."
    </blockquote>

    <h3>3 Analisis Utama yang Perlu Anda Simak</h3>
    <ul>
        <li><strong>Faktor Taktik:</strong> Bagaimana pelatih menyesuaikan strategi menghadapi lawan yang parkir bus atau bermain high-pressing.</li>
        <li><strong>Kondisi Fisik & Mental:</strong> Jadwal yang padat menuntut ketahanan luar biasa dari para atlet top dunia.</li>
        <li><strong>Dampak bagi Klasemen:</strong> Setiap poin sangat berharga dalam persaingan menuju gelar juara atau menghindari degradasi.</li>
    </ul>

    <h2 style="color: #093FB4;">Pandangan Masa Depan</h2>
    <p>Melihat tren yang ada, kita bisa mengharapkan lebih banyak kejutan di masa mendatang. Inovasi teknologi seperti VAR dan sport science akan terus memainkan peran besar dalam menentukan hasil pertandingan.</p>

    <hr style="margin: 2rem 0; border: 1px solid #FFD8D8;" />

    <p style="background-color: #FFFCFB; border: 1px solid #FFD8D8; padding: 1rem; border-radius: 0.5rem; text-align: center; font-weight: bold; color: #000000;">
        Tetaplah bersama Goalpedia untuk informasi sepak bola paling akurat dan mendalam. Karena bagi kita, sepak bola adalah gaya hidup.
    </p>
</div>
HTML;
    }
}
