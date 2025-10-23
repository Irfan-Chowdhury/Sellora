<?php

use App\Http\Controllers\Admin\CategoryController;
use Illuminate\Support\Facades\Route;



Route::group(['prefix' => 'admin'], function () {

    Route::get('/dashboard', function () {
        return view('admin.pages.dashboard.index');
    });

    Route::get('/dashboard-new', function () {
        return view('admin_new.pages.dashboard.index');
    });


    //-Products--
    Route::get('products', function () {
        return view('admin_new.products.index');
    })->name('admin.products');
    //--Customers--
    Route::get('customers', function () {
        return view('admin_new.customers.index');
    })->name('admin.customers');
    //--POS--
    Route::get('pos', function () {
        return view('admin_new.sales.index');
    })->name('admin.pos');
    //--Category--
    Route::group(['prefix' => 'categories'], function () {
        Route::get('/',[CategoryController::class,'index'])->name('admin.category');
        Route::get('/datatable',[CategoryController::class,'dataTable'])->name('admin.category.datatable');
        Route::post('/store',[CategoryController::class,'store'])->name('admin.category.store');
        Route::get('/edit',[CategoryController::class,'edit'])->name('admin.category.edit');
        Route::post('/update',[CategoryController::class,'update'])->name('admin.category.update');
        Route::get('/active',[CategoryController::class,'active'])->name('admin.category.active');
        Route::get('/inactive',[CategoryController::class,'inactive'])->name('admin.category.inactive');
        Route::get('/bulk_action',[CategoryController::class,'bulkAction'])->name('admin.category.bulk_action');
        Route::get('/delete',[CategoryController::class,'delete'])->name('admin.category.delete');
    });
});
