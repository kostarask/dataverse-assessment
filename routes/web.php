<?php

use App\Http\Controllers\Authentication\LoginController;
use App\Http\Controllers\Authentication\RegistrationController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\LocalizationController;
use App\Http\Controllers\PermissionController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

Route::middleware(['localization', 'httpsEnforce'])->group(function () {

    Route::middleware('auth')->prefix('users')->group( function () {
        Route::get('/index', [UserController::class, 'index'])->name('user.index');
        Route::post('/store', [UserController::class, 'store'])->name('user.store');
        Route::get('/edit/{user}', [UserController::class, 'edit'])->name('user.edit');
        Route::post('/update/{user}', [UserController::class, 'update'])->name('user.update');
        Route::delete('/delete/{user}', [UserController::class, 'destroy'])->name('user.delete');
        Route::post('/getData', [App\Http\Controllers\Async\UserController::class, 'getDatatableData'])->name('users.getDatatableData');
    });

    Route::middleware('auth')->prefix('roles')->group( function () {
        Route::get('/index', [RoleController::class, 'index'])->name('role.index');
        Route::post('/store', [RoleController::class, 'store'])->name('role.store');
        Route::get('/edit/{role}', [RoleController::class, 'edit'])->name('role.edit');
        Route::post('/update/{role}', [RoleController::class, 'update'])->name('role.update');
        Route::delete('/delete/{role}', [RoleController::class, 'destroy'])->name('role.delete');
        Route::post('/getData', [App\Http\Controllers\Async\RoleController::class, 'getDatatableData'])->name('roles.getDatatableData');
    });

    Route::middleware('auth')->prefix('permissions')->group( function () {
        Route::get('/index', [PermissionController::class, 'index'])->name('permission.index');
        Route::post('/store', [PermissionController::class, 'store'])->name('permission.store');
        Route::get('/edit/{permission}', [PermissionController::class, 'edit'])->name('permission.edit');
        Route::post('/update/{permission}', [PermissionController::class, 'update'])->name('permission.update');
        Route::delete('/delete/{permission}', [PermissionController::class, 'destroy'])->name('permission.delete');
        Route::post('/getData', [App\Http\Controllers\Async\PermissionController::class, 'getDatatableData'])->name('permissions.getDatatableData');
    });

    Route::get('/', [HomeController::class, 'home'])->name('home');

    Route::get('/localization/{locale}', LocalizationController::class )->name('localization');
    Route::get('/login', [LoginController::class, 'login'])->name('login');
    Route::post('/authenticate', [LoginController::class, 'authenticate'])->name('user.authenticate');
    Route::post('/logout', [LoginController::class, 'logout'])->name('user.logout');
    Route::get('/registration', [RegistrationController::class, 'registration'])->name('user.registration');
    Route::post('/register', [RegistrationController::class, 'register'])->name('user.register');

});
