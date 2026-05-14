<?php

namespace Database\Seeders;

use App\Models\Work;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class WorkSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $samples = [
            [
                'title' => 'Coastal Brutalism',
                'description' => 'A stark, minimalist residential project overlooking the Mediterranean, focusing on raw concrete textures and geometric purity.',
                'images' => ['arch.png', 'interior.png', 'abstract.png'],
            ],
            [
                'title' => 'The Monolith Interior',
                'description' => 'Concept interior for a flagship gallery, utilizing dark walnut, polished Nero Marquina marble, and sculptural furniture.',
                'images' => ['interior.png', 'abstract.png', 'arch.png'],
            ],
            [
                'title' => 'Iridescent Form',
                'description' => 'An abstract digital exploration of glass and light, designed for a luxury brand identity concept.',
                'images' => ['abstract.png', 'arch.png', 'interior.png'],
            ],
        ];

        $availableImages = ['arch.png', 'interior.png', 'abstract.png'];

        foreach ($samples as $sample) {
            $work = Work::updateOrCreate(
                ['slug' => Str::slug($sample['title'])],
                [
                    'title' => $sample['title'],
                    'description' => $sample['description'],
                ]
            );

            // Clear existing media and attach 7 images
            $work->clearMediaCollection('default');

            // Attach 7 images (cycle through available images)
            for ($i = 0; $i < 7; $i++) {
                $imageName = $availableImages[$i % count($availableImages)];
                $imagePath = public_path('samples/' . $imageName);

                if (file_exists($imagePath)) {
                    try {
                        $work->addMedia($imagePath)
                             ->preservingOriginal()
                             ->toMediaCollection('default');
                    } catch (\Exception $e) {
                        \Illuminate\Support\Facades\Log::warning("Failed to attach media for work {$work->id}: " . $e->getMessage());
                    }
                }
            }
        }
    }
}
