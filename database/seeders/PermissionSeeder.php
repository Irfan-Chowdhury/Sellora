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
				'guard_name' => 'web',
				'name' => 'category'
			),
			array(
				'guard_name' => 'web',
				'name' => 'view-category'
			),
			array(
				'guard_name' => 'web',
				'name' => 'store-category'
			),
			array(
				'guard_name' => 'web',
				'name' => 'edit-category'
			),
			array(
				'guard_name' => 'web',
				'name' => 'delete-category'
			),
			array(
				'guard_name' => 'web',
				'name' => 'category-active-inactive'
			),
			array(
				'guard_name' => 'web',
				'name' => 'customize-setting'
			),
			array(
				'guard_name' => 'web',
				'name' => 'role-access'
			),

			array(
				'guard_name' => 'web',
				'name' => 'role'
			),
			array(
				'guard_name' => 'web',
				'name' => 'view-role'
			),
			array(
				'guard_name' => 'web',
				'name' => 'store-role'
			),
			array(
				'guard_name' => 'web',
				'name' => 'edit-role'
			),
			array(
				'guard_name' => 'web',
				'name' => 'delete-role'
			),
			array(
				'guard_name' => 'web',
				'name' => 'role-active-inactive'
			),
			array(
				'guard_name' => 'web',
				'name' => 'assign-role'
            ),

			array(
				'guard_name' => 'web',
				'name' => 'view-permission'
            ),
			array(
				'guard_name' => 'web',
				'name' => 'set-permission'
			)

		);
		DB::table('permissions')->insert($permissions);
    }
}


