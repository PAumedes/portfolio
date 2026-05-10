<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Work;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        User::factory()->create([
            'name' => 'Admin User',
            'email' => 'admin@example.com',
        ]);

        // Generate 12 works for the masonry grid
        Work::factory(12)->create()->each(function ($work) {
            // Ideally, we would attach media here like:
            // $work->addMediaFromUrl('https://picsum.photos/1200/800')->toMediaCollection('default');
            // But doing so requires active R2 credentials. 
            // We will skip actual file attachment in the seeder to prevent crashes 
            // if Cloudflare credentials are not yet configured in .env.
        });
    }
}
