<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // ── Admin user ────────────────────────────────────────────────────────
        // Change email/password before running in production!
        User::updateOrCreate(
            ['email' => 'admin@portfolio.com'],
            [
                'name'     => 'Mesfin Maru',
                'email'    => 'admin@portfolio.com',
                'password' => Hash::make('Admin@2026!'),
            ]
        );

        // ── Portfolio content ─────────────────────────────────────────────────
        $this->call(PortfolioSeeder::class);
    }
}