<?php

declare(strict_types=1);

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Role\RoleStoreRequest;
use App\Http\Requests\Role\RoleUpdateRequest;
use App\Services\RoleService;
use Exception;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use App\Models\User;
use Illuminate\Support\Str;
use function e;

class RoleController extends Controller {
    private $roleService;
    public function __construct(RoleService $roleService){
        $this->roleService = $roleService;
    }

    public function dataTable($roles)
    {
        return datatables()->of($roles)
            ->setRowId(function ($role) {
                return $role->id;
            })
            ->addColumn('name', function ($data){
                return ucfirst ($data->name);
            })
            ->addColumn('action', function ($row){
                $actionBtn = "";
                $actionBtn .= '<a class="show btn btn-primary btn-sm mr-1" href="'.route('admin.roles.permission',$row->id).'">' . trans('file.Permission') . '</a>';

                $actionBtn .= '<button type="button" title="Edit" class="edit btn btn-info btn-sm" title="Edit" data-id="'.$row->id.'"><i class="dripicons-pencil"></i></button>
                                &nbsp; ';

                if ($row->is_active==1) {
                    $actionBtn .= '<button type="button" title="Inactive" class="inactive btn btn-warning btn-sm" data-id="'.$row->id.'"><i class="fa fa-thumbs-down"></i></button>';
                }else {
                    $actionBtn .= '<button type="button" title="Active" class="active btn btn-success btn-sm" data-id="'.$row->id.'"><i class="fa fa-thumbs-up"></i></button>';
                }
                $actionBtn .= '<button type="button" title="Delete" class="delete btn btn-danger btn-sm ml-2" title="Delete" data-id="'.$row->id.'"><i class="dripicons-trash"></i></button>
                &nbsp; ';

                return $actionBtn;
            })
            ->rawColumns(['action'])
            ->make(true);
    }

	public function index()
	{
        $roles =  $this->roleService->getAllRoles();

        if (request()->ajax()) {
            return $this->dataTable($roles);
        }

        return view('admin.pages.roles.index');
	}


	public function store(RoleStoreRequest $request)
	{
        if(!auth()->user()->can('store-role')) {
            abort(403);
        }

        try {

            $this->roleService->save($request);

            return $this->successResponse( 'Role created successfully', []);

        } catch (Exception $e) {

            return $this->errorResponse($e->getMessage());
        }
	}

    public function edit(Role $role)
    {
        return response()->json(['role'=> $role]);
    }

    public function update(RoleUpdateRequest $request, Role $role)
    {
        try {

            $this->roleService->updateRole($request, $role);

            return $this->successResponse( 'Data Updated Successfully', []);

        } catch (Exception $e) {

            return $this->errorResponse($e->getMessage());
        }
    }

    public function active(Request $request)
    {
        try {

            $this->roleService->activeById((int)$request->id);

            return $this->successResponse( 'Data active successfully', []);

        } catch (Exception $e) {

            return $this->errorResponse($e->getMessage());
        }
    }

    public function inactive(Request $request)
    {
        try {

            $this->roleService->inactiveById((int)$request->id);

            return $this->successResponse( 'Data inactive successfully', []);

        } catch (Exception $e) {

            return $this->errorResponse($e->getMessage());
        }
    }

    public function destroy(Request $request)
    {
        try {

            $this->roleService->destroy((int) $request->id);

            return $this->successResponse( 'Data Deleted successfully', []);

        } catch (Exception $e) {

            return $this->errorResponse($e->getMessage());
        }
    }

    public function bulkAction(Request $request)
    {
        try {

            $getMessage = $this->roleService->bulkActionByTypeAndIds((string)$request->action_type, (array)$request->idsArray);

            return $this->successResponse( $getMessage, []);

        } catch (Exception $e) {

            return $this->errorResponse($e->getMessage());
        }
    }


    public function roleAssign()
	{
		$roles = Role::where('is_active',1)->select('id', 'name')->get();

        $users = User::with('roles')->get();

        if (request()->ajax()) {
            return datatables()->of($users)
                ->addColumn('username', function ($row)
                {
                    return $row->name;
                })
                ->addColumn('role_name', function ($row)
                {
                    foreach ($row->roles as $role)
                    {
                        return $role->name;
                    };

                    return null;
                })
                ->setRowId(function ($user)
                {
                    return $user->id;
                })
                ->addColumn('assignRole', function ($row) use ($roles)
                {

                    $dropdown = '<div class="btn-group">
                        <button type="button" class="btn btn-primary btn-sm dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            Assign Role
                        </button>
                        <div class="dropdown-menu">';

                    foreach ($roles as $r) {
                        $dropdown .= '<li class="dropdown-item assign-role" data-user_id="' . $row->id . '" data-role_id="' . $r->id . '">' . htmlspecialchars($r->name, ENT_QUOTES, 'UTF-8') . '</li>';
                    }

                    $dropdown .= '</div></div>';

                    return $dropdown;

                })
                ->rawColumns(['assignRole'])
                ->make(true);
        }


        return view('admin.pages.roles.assign', compact('roles'));

	}


	public function updateAssignRole(Request $request, User $user)
	{
        try {

            $this->roleService->roleAssign((int) $request->roleId, $user);

            return $this->successResponse( 'Role assigned successfully', []);

        } catch (Exception $e) {

            return $this->errorResponse($e->getMessage());
        }
	}


    public function massUpdateAssignRole(Request $request)
	{
        try {
            $this->roleService->multipleRoleAssign($request['userIdArray'], (int) $request['mass_role']);

            return $this->successResponse( 'Role assigned successfully', []);

        } catch (Exception $e) {

            return $this->errorResponse($e->getMessage());
        }
	}
}
