<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PermissionSeeder extends Seeder
{
    // php artisan db:seed --class=PermissionSeeder

    public function run()
    {
		DB::table('permissions')->delete();

		$permissions = array(

			array(
				'id' => 1,
				'guard_name' => 'web',
				'name' => 'customize-setting'
			),
			array(
				'id' => 2,
				'guard_name' => 'web',
				'name' => 'role-access'
			),

			array(
				'id' => 3,
				'guard_name' => 'web',
				'name' => 'role'
			),
			array(
				'id' => 4,
				'guard_name' => 'web',
				'name' => 'view-role'
			),
			array(
				'id' => 5,
				'guard_name' => 'web',
				'name' => 'store-role'
			),
			array(
				'id' => 6,
				'guard_name' => 'web',
				'name' => 'edit-role'
			),
			array(
				'id' => 7,
				'guard_name' => 'web',
				'name' => 'delete-role'
			),

			array(
				'id' => 8,
				'guard_name' => 'web',
				'name' => 'assign-role'
            ),

			array(
				'id' => 9,
				'guard_name' => 'web',
				'name' => 'set-permission'
			)

		);
		DB::table('permissions')->insert($permissions);
    }
}


