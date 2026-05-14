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
                'image' => 'arch.png',
            ],
            [
                'title' => 'The Monolith Interior',
                'description' => 'Concept interior for a flagship gallery, utilizing dark walnut, polished Nero Marquina marble, and sculptural furniture.',
                'image' => 'interior.png',
            ],
            [
                'title' => 'Iridescent Form',
                'description' => 'An abstract digital exploration of glass and light, designed for a luxury brand identity concept.',
                'image' => 'abstract.png',
            ],
        ];

        foreach ($samples as $sample) {
            $work = Work::updateOrCreate(
                ['slug' => Str::slug($sample['title'])],
                [
                    'title' => $sample['title'],
                    'description' => $sample['description'],
                ]
            );

            // Attach image if not already attached
            if ($work->getMedia('default')->isEmpty() && file_exists(public_path('samples/' . $sample['image']))) {
                try {
                    $work->addMedia(public_path('samples/' . $sample['image']))
                         ->preservingOriginal()
                         ->toMediaCollection('default');
                } catch (\Exception $e) {
                    // Log media attachment failure but don't fail the seeder
                    \Illuminate\Support\Facades\Log::warning("Failed to attach media for work {$work->id}: " . $e->getMessage());
                }
            }
        }
    }
}
