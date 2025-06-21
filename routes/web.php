<?php

use App\Http\Controllers\Auth\PasswordController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'index'])->name('profile');
    Route::post('/profile-update', [ProfileController::class, 'profileUpdate'])->name('profile.update');
    Route::put('/password', [PasswordController::class, 'update'])->name('update.password');
    Route::put('employee-bio/{employee}',[ProfileController::class,'updateBio'])->name('employee.bio.update');




});

require __DIR__.'/auth.php';
require __DIR__.'/admin.php';
