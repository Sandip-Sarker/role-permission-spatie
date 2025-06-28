<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Backend\Role\PermissionController;
use App\Http\Controllers\Backend\Role\RoleController;
use App\Http\Controllers\Backend\Artical\ArticalController;
use App\Http\Controllers\Backend\User\UserController;

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

    Route::prefix('article')->group(function () {
        Route::get('/', [ArticalController::class, 'index'])->name('article.index');
        Route::get('/create', [ArticalController::class, 'create'])->name('article.create');
        Route::post('/store', [ArticalController::class, 'store'])->name('article.post');
        Route::get('/edit/{id}', [ArticalController::class, 'edit'])->name('article.edit');
        Route::post('/update/{id}', [ArticalController::class, 'update'])->name('article.update');
        Route::get('/delete/{id}', [ArticalController::class, 'destroy'])->name('article.destroy');
    });

    Route::prefix('user')->group(function () {
        Route::get('/', [UserController::class, 'index'])->name('user.index');
        Route::get('/edit/{id}', [UserController::class, 'edit'])->name('user.edit');
        Route::post('/update/{id}', [UserController::class, 'update'])->name('user.update');
        Route::get('/delete/{id}', [UserController::class, 'destroy'])->name('user.destroy');
    });

});


