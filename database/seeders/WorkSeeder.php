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

            // Clear existing media
            $work->clearMediaCollection('default');

            // Create 7 media records in the database (without actual files)
            for ($i = 0; $i < 7; $i++) {
                $imageName = $availableImages[$i % count($availableImages)];

                try {
                    // Create database record directly without file upload
                    \Spatie\MediaLibrary\MediaCollections\Models\Media::create([
                        'model_type' => 'App\\Models\\Work',
                        'model_id' => $work->id,
                        'collection_name' => 'default',
                        'name' => pathinfo($imageName, PATHINFO_FILENAME),
                        'file_name' => $imageName,
                        'mime_type' => 'image/jpeg',
                        'disk' => 'public',
                        'size' => 0,
                        'manipulations' => json_encode([]),
                        'custom_properties' => json_encode([]),
                        'generated_conversions' => json_encode(['thumb' => true, 'preview' => true, 'preview_fallback' => true]),
                        'responsive_images' => json_encode([]),
                        'order_column' => $i + 1,
                    ]);
                } catch (\Exception $e) {
                    \Illuminate\Support\Facades\Log::warning("Failed to create media record for work {$work->id}: " . $e->getMessage());
                }
            }
        }
    }
}
