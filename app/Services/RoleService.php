<?php

declare(strict_types=1);

namespace App\Services;

use App\Models\User;
use Spatie\Permission\Models\Role;
use App\Services\StatusHandlerService;
use Exception;
use Illuminate\Support\Facades\DB;

class RoleService extends StatusHandlerService
{
    public function getAllRoles()
    {
        return Role::orderBy('is_active','DESC')
            ->latest()
            ->get();
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

    public function save($request)
    {
        Role::create([
            'name' => $request->name,
            'is_active' => $request->is_active ?? false,
        ]);
    }

    public function updateRole($request, object $role)
    {
        DB::transaction(function () use ($request, $role) {
            $role->update([
                'name' => $request->name,
                'is_active' => $request->is_active ? true : false,
            ]);
        });

    }

    // public function activeById(int $id): void
    // {
    //     $this->activeData(Role::findOrFail($id));

    // }

    // public function inactiveById(int $id): void
    // {
    //     $this->inactiveData(Role::findOrFail($id));
    // }

    public function active(object $role): void
    {
        $role->update(['is_active'=>true]);
    }

    public function inactive(object $role): void
    {
        $role->update(['is_active'=>false]);
    }

    public function destroy(object $role): void
    {
        $role->delete();
    }

    public function bulkActionByTypeAndIds(string $type, array $ids)
    {
        return $this->bulkActionData($type, Role::whereIn('id',$ids));
    }

    public function roleAssign(int $roleId, object $user)
    {
        if (!$roleId){
            throw new Exception("Please assign a role", 1);
        }

        $user = User::find($user->id);

        $user->syncRoles($roleId);
    }

    public function multipleRoleAssign(array $userIdArray, int $roleId)
    {
        if (!$roleId){
            throw new Exception("Please assign a role", 1);
        }

        $users = User::whereIntegerInRaw('id', $userIdArray)->get();

        foreach ($users as $user) {
            $user->syncRoles($roleId);
        }
    }
}
