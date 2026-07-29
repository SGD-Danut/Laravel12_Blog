<?php

use App\Http\Controllers\Admin\HomeController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\ProfileController;
use App\Models\User;
use Illuminate\Support\Facades\Route;
use App\Http\Middleware\OnlyAdminHasAccess;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';

// Rute pentru admin scrise normal:
Route::get('/admin', [HomeController::class, 'showHome'])->middleware(['auth'])->name('admin.show-home');

// Rute pentru admin grupate după prefix, middleware și controller:
Route::prefix('admin')->controller(UserController::class)->middleware(['auth', 'onlyAdmin'])->group(function() {
    Route::get('/users','showUsers')->name('admin.show-users');
    Route::get('/add-user','showAddUser')->name('admin.show-add-user');
    Route::post('/create-user','createUser')->name('admin.create-user');
});
