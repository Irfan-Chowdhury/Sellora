<?php

use App\Http\Controllers\Admin\CategoryController;
use Illuminate\Support\Facades\Route;



Route::group(['prefix' => 'admin'], function () {

    Route::get('/dashboard', function () {
        return view('lte.admin.pages.dashboard.index');
    });

    //--Category--
    Route::group(['prefix' => 'categories'], function () {
        Route::get('/',[CategoryController::class,'index'])->name('admin.category');
        Route::get('/datatable',[CategoryController::class,'dataTable'])->name('admin.category.datatable');
        Route::post('/store',[CategoryController::class,'store'])->name('admin.category.store')->middleware(['demo_check','checkAjax']);
        Route::get('/edit',[CategoryController::class,'edit'])->name('admin.category.edit');
        Route::post('/update',[CategoryController::class,'update'])->name('admin.category.update')->middleware(['demo_check']);
        Route::get('/active',[CategoryController::class,'active'])->name('admin.category.active')->middleware(['demo_check']);
        Route::get('/inactive',[CategoryController::class,'inactive'])->name('admin.category.inactive')->middleware(['demo_check']);
        Route::get('/bulk_action',[CategoryController::class,'bulkAction'])->name('admin.category.bulk_action')->middleware(['demo_check']);
        Route::get('/delete',[CategoryController::class,'delete'])->name('admin.category.delete')->middleware(['demo_check']);
    });
});
