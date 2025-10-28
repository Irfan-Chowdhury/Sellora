<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
// use Spatie\Permission\Models\Role;
use App\Models\Role;

class RoleSeeder extends Seeder
{
    // php artisan db:seed --class=RoleSeeder

    public function run(): void
    {
        Role::factory()->create([
            'name' => 'Admin',
            'guard_name' => 'web',
            'is_active' => true, // custom password
        ]);

        Role::factory()->count(10)->create();
    }
}
