<?php

use App\Http\Controllers\Admin\BrandController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\PermissionController;
use App\Http\Controllers\Admin\RoleController;
use App\Http\Controllers\Admin\TagController;
use Illuminate\Support\Facades\Route;



Route::group(['prefix' => 'admin', 'middleware'=>'auth', 'as' => 'admin.'], function () {

    Route::get('/dashboard', function () {
        return view('admin.pages.dashboard.index');
    });

    //--Category--
    Route::group(['prefix' => 'categories'], function () {
        Route::get('/',[CategoryController::class,'index'])->name('category')->middleware('permission:view-category');
        Route::get('/datatable',[CategoryController::class,'dataTable'])->name('category.datatable');
        Route::post('/store',[CategoryController::class,'store'])->name('category.store')->middleware('permission:store-category');
        Route::get('/edit',[CategoryController::class,'edit'])->name('category.edit');
        Route::post('/update',[CategoryController::class,'update'])->name('category.update')->middleware('permission:edit-category');
        Route::get('/active',[CategoryController::class,'active'])->name('category.active')->middleware('permission:category-active-inactive');
        Route::get('/inactive',[CategoryController::class,'inactive'])->name('category.inactive')->middleware('permission:category-active-inactive');
        Route::get('/bulk_action',[CategoryController::class,'bulkAction'])->name('category.bulk_action');
        Route::get('/delete',[CategoryController::class,'delete'])->name('category.delete')->middleware('permission:delete-category');
    });

    Route::resource('/roles', RoleController::class)->except(['show','destroy'])->middleware('permission:role');
    Route::group(['prefix' => 'roles'], function () {
        Route::get('active', [RoleController::class, 'active'])->name('roles.active');
        Route::get('inactive', [RoleController::class, 'inactive'])->name('roles.inactive');
        Route::get('destroy',[RoleController::class,'destroy'])->name('roles.destroy')->middleware('permission:delete-role');
        Route::get('bulk_action',[RoleController::class,'bulkAction'])->name('roles.bulk_action');
        Route::get('assign',[RoleController::class,'roleAssign'])->name('roles.assign')->middleware('permission:assign-role');
        Route::post('assign/{user}', [RoleController::class, 'updateAssignRole'])->name('assign_role')->middleware('permission:assign-role');
        Route::post('mass_assign', [RoleController::class, 'massUpdateAssignRole'])->name('mass_assign_role')->middleware('permission:assign-role');

        Route::get('permission/{id}', [PermissionController::class, 'rolePermission'])->name('roles.permission')->middleware('permission:view-permission');
        Route::get('permission_details/{id}', [PermissionController::class, 'permissionDetails'])->name('permissionDetails');
        Route::post('permission', [PermissionController::class, 'set_permission'])->name('set_permission')->middleware('permission:set-permission');
    });

    Route::get('/brands/bulk_action',[BrandController::class,'bulkAction'])->name('brands.bulk_action');
    Route::resourceWithStatus('brands', BrandController::class);

    Route::get('/tags/bulk_action',[TagController::class,'bulkAction'])->name('tags.bulk_action');
    Route::resourceWithStatus('tags', TagController::class);
});
