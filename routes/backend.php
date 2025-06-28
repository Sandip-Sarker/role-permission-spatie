<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Backend\Role\PermissionController;
use App\Http\Controllers\Backend\Role\RoleController;

Route::prefix('admin')->group(function () {

    Route::prefix('permission')->group(function () {
        Route::get('/', [PermissionController::class, 'index'])->name('roles.permission.index');
        Route::get('/create', [PermissionController::class, 'create'])->name('roles.permission.create');
        Route::post('/store', [PermissionController::class, 'store'])->name('roles.permission.post');
        Route::get('/edit/{id}', [PermissionController::class, 'edit'])->name('roles.permission.edit');
        Route::post('/update/{id}', [PermissionController::class, 'update'])->name('roles.permission.update');
        Route::get('/delete/{id}', [PermissionController::class, 'destroy'])->name('roles.permission.destroy');
    });


    Route::prefix('role')->group(function () {
        Route::get('/', [RoleController::class, 'index'])->name('roles.index');
        Route::get('/create', [RoleController::class, 'create'])->name('roles.create');
        Route::post('/store', [RoleController::class, 'store'])->name('roles.post');
        Route::get('/edit/{id}', [RoleController::class, 'edit'])->name('roles.edit');
        Route::post('/update/{id}', [RoleController::class, 'update'])->name('roles.update');
        Route::get('/delete/{id}', [RoleController::class, 'destroy'])->name('roles.destroy');
    });

});


