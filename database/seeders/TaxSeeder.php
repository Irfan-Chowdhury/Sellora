<?php

namespace Database\Seeders;

use App\Models\Tax;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class TaxSeeder extends Seeder
{
    // php artisan db:seed --class=TaxSeeder
    public function run(): void
    {
        Tax::factory()->count(5)->create();
    }
}
