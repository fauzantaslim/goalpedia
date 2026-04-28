<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $structure = [
            'Kompetisi' => [
                'Liga Inggris',
                'Liga Spanyol',
                'Liga Italia',
                'Liga Champions',
                'Liga Europa',
                'Liga Arab',
                'MLS',
            ],
            'Indonesia' => [
                'Liga 1',
                'Timnas Indonesia',
            ],
            'Berita' => [
                'Transfer',
                'Rumor',
                'Highlight',
            ],
            'Statistik' => [
                'Klasemen',
                'Top Skor',
                'Jadwal',
            ],
            'Pemain' => [],
            'Klub' => [],
            'Insight' => [],
        ];

        foreach ($structure as $parentName => $children) {
            $parent = Category::firstOrCreate(
                ['name' => $parentName],
                [
                    'slug' => Str::slug($parentName),
                    'is_visible' => true,
                ]
            );

            foreach ($children as $childName) {
                Category::firstOrCreate(
                    ['name' => $childName, 'parent_id' => $parent->id],
                    [
                        'slug' => Str::slug($childName),
                        'is_visible' => true,
                    ]
                );
            }
        }
    }
}
