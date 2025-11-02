<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
class CategorySeeder extends Seeder
{
    // php artisan db:seed --class=CategorySeeder
    public function run(): void
    {
        DB::table('categories')->truncate();

        // Top-level categories
        $categories = [
            [
                'name' => 'Electronics',
                'slug' => Str::slug('Electronics'),
                'description' => 'Devices, gadgets, and accessories for everyday use.',
                'icon' => 'fa-solid fa-tv',
                'image' => 'https://placehold.co/600x400?text=Electronics',
                'top' => 1,
                'is_active' => 1,
                'parent_id' => null,
            ],
            [
                'name' => 'Fashion',
                'slug' => Str::slug('Fashion'),
                'description' => 'Clothing, shoes, and accessories for men and women.',
                'icon' => 'fa-solid fa-shirt',
                'image' => 'https://placehold.co/600x400?text=Fashion',
                'top' => 1,
                'is_active' => 1,
                'parent_id' => null,
            ],
            [
                'name' => 'Home & Kitchen',
                'slug' => Str::slug('Home & Kitchen'),
                'description' => 'Furniture, decor, and kitchen appliances.',
                'icon' => 'fa-solid fa-couch',
                'image' => 'https://placehold.co/600x400?text=Home+%26+Kitchen',
                'top' => 1,
                'is_active' => 1,
                'parent_id' => null,
            ],
        ];


        DB::table('categories')->insert($categories);

        // Subcategories (based on inserted top-level categories)
        $subCategories = [
            [
                'name' => 'Mobile Phones',
                'slug' => Str::slug('Mobile Phones'),
                'description' => 'Smartphones from popular brands.',
                'icon' => 'fa-solid fa-mobile',
                'image' => 'https://placehold.co/600x400?text=Mobile+Phones',
                'top' => 0,
                'is_active' => 1,
                'parent_id' => 1, // Electronics
            ],
            [
                'name' => 'Laptops',
                'slug' => Str::slug('Laptops'),
                'description' => 'Laptops and notebooks for work and play.',
                'icon' => 'fa-solid fa-laptop',
                'image' => 'https://placehold.co/600x400?text=Laptops',
                'top' => 0,
                'is_active' => 1,
                'parent_id' => 1, // Electronics
            ],
            [
                'name' => 'Men’s Clothing',
                'slug' => Str::slug('Men’s Clothing'),
                'description' => 'Stylish apparel for men.',
                'icon' => 'fa-solid fa-user-tie',
                'image' => 'https://placehold.co/600x400?text=Men%E2%80%99s+Clothing',
                'top' => 0,
                'is_active' => 1,
                'parent_id' => 2, // Fashion
            ],
            [
                'name' => 'Women’s Clothing',
                'slug' => Str::slug('Women’s Clothing'),
                'description' => 'Latest fashion trends for women.',
                'icon' => 'fa-solid fa-user-dress',
                'image' => 'https://placehold.co/600x400?text=Women%E2%80%99s+Clothing',
                'top' => 0,
                'is_active' => 1,
                'parent_id' => 2, // Fashion
            ],
            [
                'name' => 'Kitchen Appliances',
                'slug' => Str::slug('Kitchen Appliances'),
                'description' => 'Cooking and food prep essentials.',
                'icon' => 'fa-solid fa-blender',
                'image' => 'https://placehold.co/600x400?text=Kitchen+Appliances',
                'top' => 0,
                'is_active' => 1,
                'parent_id' => 3, // Home & Kitchen
            ],
        ];

        DB::table('categories')->insert($subCategories);
    }
}
