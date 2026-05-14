<?php

namespace Database\Seeders;

use App\Models\Work;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

class WorkSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $samples = [
            ['title' => 'Coastal Brutalism', 'description' => 'A stark, minimalist residential project overlooking the Mediterranean, focusing on raw concrete textures and geometric purity.'],
            ['title' => 'The Monolith Interior', 'description' => 'Concept interior for a flagship gallery, utilizing dark walnut, polished Nero Marquina marble, and sculptural furniture.'],
            ['title' => 'Iridescent Form', 'description' => 'An abstract digital exploration of glass and light, designed for a luxury brand identity concept.'],
        ];

        $images = ['arch.png', 'interior.png', 'abstract.png'];

        foreach ($samples as $sample) {
            $work = Work::updateOrCreate(
                ['slug' => Str::slug($sample['title'])],
                ['title' => $sample['title'], 'description' => $sample['description']]
            );

            for ($i = 0; $i < 7; $i++) {
                $img = $images[$i % count($images)];
                Media::create([
                    'model_type' => Work::class,
                    'model_id' => $work->id,
                    'collection_name' => 'default',
                    'name' => pathinfo($img, PATHINFO_FILENAME),
                    'file_name' => $img,
                    'mime_type' => 'image/png',
                    'disk' => 'public',
                    'size' => 0,
                    'manipulations' => '[]',
                    'custom_properties' => '{}',
                    'generated_conversions' => '{}',
                    'responsive_images' => '[]',
                    'order_column' => $i + 1,
                ]);
            }
        }
    }
}
