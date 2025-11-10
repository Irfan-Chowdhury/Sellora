<?php

namespace Database\Seeders;

use App\Models\Unit;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UnitSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */

    public function run()
    {
        // Predefined data
        // Unit::create([
        //     'name' => 'kg',
        //     'code' => 'Kilogram',
        //     'base_unit' => null,
        //     'operator' => '*',
        //     'operation_value' => 1,
        //     'is_active' => true,
        // ]);

        // Unit::create([
        //     'name' => 'gm',
        //     'code' => 'Gram',
        //     'base_unit' => 4,
        //     'operator' => '/',
        //     'operation_value' => 1000,
        //     'is_active' => true,
        // ]);

        DB::table('units')->insert([
            [
                'code' => 'pc',
                'name' => 'Piece',
                'base_unit' => null,
                'operator' => '*',
                'operation_value' => 1,
                'is_active' => true,
                'created_at' => '2024-01-08 05:37:39',
                'updated_at' => '2024-01-08 05:37:39',
            ],
            [
                'code' => 'dozen',
                'name' => 'Dozen',
                'base_unit' => 1,
                'operator' => '*',
                'operation_value' => 12,
                'is_active' => true,
                'created_at' => '2024-01-08 05:38:27',
                'updated_at' => '2024-01-08 05:38:27',
            ],
            [
                'code' => 'carton',
                'name' => 'Carton',
                'base_unit' => 1,
                'operator' => '*',
                'operation_value' => 24,
                'is_active' => true,
                'created_at' => '2024-01-08 05:39:01',
                'updated_at' => '2024-01-08 05:39:01',
            ],
            [
                'code' => 'kg',
                'name' => 'Kilogram',
                'base_unit' => null,
                'operator' => '*',
                'operation_value' => 1,
                'is_active' => true,
                'created_at' => '2024-01-08 05:39:37',
                'updated_at' => '2024-01-08 05:39:37',
            ],
            [
                'code' => 'gm',
                'name' => 'Gram',
                'base_unit' => 4,
                'operator' => '/',
                'operation_value' => 1000,
                'is_active' => true,
                'created_at' => '2024-01-08 05:40:00',
                'updated_at' => '2024-01-08 05:40:00',
            ],
            [
                'code' => 'L',
                'name' => 'Liter',
                'base_unit' => null,
                'operator' => '*',
                'operation_value' => 1,
                'is_active' => true,
                'created_at' => '2025-05-04 05:41:10',
                'updated_at' => '2025-05-04 05:41:10',
            ],
            [
                'code' => 'ml',
                'name' => 'ML',
                'base_unit' => 6,
                'operator' => '/',
                'operation_value' => 1000,
                'is_active' => true,
                'created_at' => '2025-05-04 05:41:58',
                'updated_at' => '2025-05-04 05:41:58',
            ]
        ]);

        // Using the factory to generate 10 random units
        // Unit::factory()->count(10)->create();
    }

}
