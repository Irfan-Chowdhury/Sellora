<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    // php artisan db:seed --class=RoleSeeder
    public function run(): void
    {
        $this->call([
            PermissionSeeder::class,
            RoleSeeder::class,
            CategorySeeder::class,
            BrandSeeder::class,
            UserSeeder::class,
            TagSeeder::class,
            TaxSeeder::class,
            UnitSeeder::class,
        ]);
    }
}
