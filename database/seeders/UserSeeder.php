<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class UserSeeder extends Seeder
{
    // php artisan db:seed --class=UserSeeder

    public function run(): void
    {
        // create a single admin user
        $user = User::factory()->create([
            'name' => 'Admin User',
            'email' => 'admin12345@gmail.com',
            'password' => bcrypt('admin12345'), // custom password
        ]);

        $user->syncRoles(1);
        $role = Role::findById(1);

        $permissionIds = Permission::get()->pluck('id');
        $role->syncPermissions($permissionIds);

        User::factory(10)->create();
    }
}
