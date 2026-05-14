<?php

namespace Database\Seeders;

use App\Models\Work;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\File;

class ExpandWorkMediaSeeder extends Seeder
{
    public function run(): void
    {
        $works = Work::all();

        foreach ($works as $work) {
            $workDir = storage_path("app/public/{$work->id}/");
            if (!is_dir($workDir)) {
                continue;
            }

            $existingFiles = File::files($workDir);
            $currentMediaCount = $work->getMedia('default')->count();
            $totalNeeded = 7;

            // Register existing copied files as media
            foreach ($existingFiles as $file) {
                $fileName = $file->getFilename();

                // Only register PNG files and skip those already registered
                if (str_ends_with($fileName, '.png') && str_contains($fileName, '_') && $currentMediaCount < $totalNeeded) {
                    try {
                        $work->addMedia($file->getRealPath())
                            ->preservingOriginal()
                            ->toMediaCollection('default');

                        $currentMediaCount++;
                    } catch (\Exception $e) {
                        \Illuminate\Support\Facades\Log::warning("Failed to add media for work {$work->id}: {$e->getMessage()}");
                    }
                }
            }
        }
    }
}
