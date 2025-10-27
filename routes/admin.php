<?php

use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\PermissionController;
use App\Http\Controllers\Admin\RoleController;
use Illuminate\Support\Facades\Route;



Route::group(['prefix' => 'admin', 'middleware'=>'auth', 'as' => 'admin.'], function () {

    Route::get('/dashboard', function () {
        return view('admin.pages.dashboard.index');
    });

    //--Category--
    Route::group(['prefix' => 'categories'], function () {
        Route::get('/',[CategoryController::class,'index'])->name('category');
        Route::get('/datatable',[CategoryController::class,'dataTable'])->name('category.datatable');
        Route::post('/store',[CategoryController::class,'store'])->name('category.store');
        Route::get('/edit',[CategoryController::class,'edit'])->name('category.edit');
        Route::post('/update',[CategoryController::class,'update'])->name('category.update');
        Route::get('/active',[CategoryController::class,'active'])->name('category.active');
        Route::get('/inactive',[CategoryController::class,'inactive'])->name('category.inactive');
        Route::get('/bulk_action',[CategoryController::class,'bulkAction'])->name('category.bulk_action');
        Route::get('/delete',[CategoryController::class,'delete'])->name('category.delete');
    });

    Route::resource('roles', RoleController::class)->except(['show','destroy']);
    Route::get('roles/active', [RoleController::class, 'active'])->name('roles.active');
    Route::get('roles/inactive', [RoleController::class, 'inactive'])->name('roles.inactive');
    Route::get('roles/destroy',[RoleController::class,'destroy'])->name('roles.destroy');
    Route::get('roles/bulk_action',[RoleController::class,'bulkAction'])->name('roles.bulk_action');
    Route::get('roles/assign',[RoleController::class,'roleAssign'])->name('roles.assign');
    Route::post('roles/assign/{user}', [RoleController::class, 'updateAssignRole'])->name('assign_role');
    Route::post('roles/mass_assign', [RoleController::class, 'massUpdateAssignRole'])->name('mass_assign_role');


    Route::get('roles/permission/{id}', [PermissionController::class, 'rolePermission'])->name('roles.permission');
    Route::get('roles/permission_details/{id}', [PermissionController::class, 'permissionDetails'])->name('permissionDetails');
    Route::post('roles/permission', [PermissionController::class, 'set_permission'])->name('set_permission');
});
