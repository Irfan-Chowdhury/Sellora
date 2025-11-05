<?php

use App\Http\Controllers\Admin\BrandController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\PermissionController;
use App\Http\Controllers\Admin\RoleController;
use App\Http\Controllers\Admin\TagController;
use App\Http\Controllers\Admin\TaxController;
use Illuminate\Support\Facades\Route;



Route::group(['prefix' => 'admin', 'middleware'=>'auth', 'as' => 'admin.'], function () {

    Route::get('/dashboard', function () {
        return view('admin.pages.dashboard.index');
    });

    Route::get('/categories/bulk_action',[CategoryController::class,'bulkAction'])->name('categories.bulk_action');
    Route::get('/categories/datatable',[CategoryController::class,'dataTable'])->name('categories.datatable');
    Route::resourceWithStatus('categories', CategoryController::class);

    Route::group(['prefix' => 'roles'], function () {
        Route::get('bulk_action',[RoleController::class,'bulkAction'])->name('roles.bulk_action');
        Route::get('assign',[RoleController::class,'roleAssign'])->name('roles.assign')->middleware('permission:assign-role');
        Route::post('assign/{user}', [RoleController::class, 'updateAssignRole'])->name('assign_role')->middleware('permission:assign-role');
        Route::post('mass_assign', [RoleController::class, 'massUpdateAssignRole'])->name('mass_assign_role')->middleware('permission:assign-role');

        Route::get('permission/{id}', [PermissionController::class, 'rolePermission'])->name('roles.permission')->middleware('permission:view-permission');
        Route::get('permission_details/{id}', [PermissionController::class, 'permissionDetails'])->name('permissionDetails');
        Route::post('permission', [PermissionController::class, 'set_permission'])->name('set_permission')->middleware('permission:set-permission');
    });
    Route::resourceWithStatus('roles', RoleController::class);


    Route::get('/brands/bulk_action',[BrandController::class,'bulkAction'])->name('brands.bulk_action');
    Route::resourceWithStatus('brands', BrandController::class);

    Route::get('/tags/bulk_action',[TagController::class,'bulkAction'])->name('tags.bulk_action');
    Route::resourceWithStatus('tags', TagController::class);

    Route::get('/taxes/bulk_action',[TaxController::class,'bulkAction'])->name('taxes.bulk_action');
    Route::resourceWithStatus('taxes', TaxController::class);
});
