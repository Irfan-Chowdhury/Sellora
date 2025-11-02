<?php

namespace Database\Seeders;

use App\Models\Tag;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class TagSeeder extends Seeder
{
    // php artisan db:seed --class=TagSeeder
    public function run(): void
    {
        Tag::factory()->count(20)->create();
    }
}
