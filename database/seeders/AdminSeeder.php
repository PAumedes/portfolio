<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $email = env('ADMIN_EMAIL', 'admin@portfolio.test');
        $password = env('ADMIN_PASSWORD', 'password');
        $name = env('ADMIN_NAME', 'Portfolio Admin');

        User::updateOrCreate(
            ['email' => $email],
            [
                'name' => $name,
                'password' => Hash::make($password),
            ]
        );

        if (app()->isProduction()) {
            $this->command?->warn(
                "Admin user created with email: {$email}. " .
                "Change ADMIN_EMAIL, ADMIN_NAME, and ADMIN_PASSWORD in .env immediately."
            );
        }
    }
}
