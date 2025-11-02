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

    public function activeById(int $id): void
    {
        $this->activeData(Role::findOrFail($id));

    }

    public function inactiveById(int $id): void
    {
        $this->inactiveData(Role::findOrFail($id));
    }

    public function destroy(int $id): void
    {
        $role = Role::findOrFail($id);

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
