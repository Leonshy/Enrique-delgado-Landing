<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // Admin user
        User::updateOrCreate(
            ['email' => 'admin@enriquedelgado.com'],
            [
                'name'     => 'Administrador',
                'email'    => 'admin@enriquedelgado.com',
                'password' => Hash::make('password'),
                'email_verified_at' => now(),
            ]
        );

        $this->call([
            SiteSettingsSeeder::class,
            LandingSectionsSeeder::class,
            ContentSeeder::class,
            SeoSeeder::class,
            LegalPagesSeeder::class,
        ]);
    }
}
