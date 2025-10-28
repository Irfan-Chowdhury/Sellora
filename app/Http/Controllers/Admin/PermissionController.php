<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;

class PermissionController extends Controller
{
    public function rolePermission($id)
    {
        $role = Role::findById($id);

        return view('admin.pages.roles.permission',compact('role'));
	}

    public function permissionDetails($id)
	{
		$role = Role::findById($id);
		$role_permissions = $role->permissions()->select('name')->get();

		$permissions = array();
		foreach ($role_permissions as $permission)
		{
			$permissions[] = $permission->name;
		}
		return json_encode($permissions);
	}

    public function set_permission(Request $request)
	{
        $id = $request['roleId'];
        $role = Role::findById($id);
        $all_permissions = $request['checkedId'];
        $role->syncPermissions($all_permissions);

        // return response()->json(['success' => __('Successfully saved the permission')]);
        return $this->successResponse( 'Successfully saved the permission', []);


	}
}
