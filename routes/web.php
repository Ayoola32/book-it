<?php

use App\Http\Controllers\Auth\PasswordController;
use App\Http\Controllers\FrontendController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

// Route::get('/', function () {
//     return view('welcome');
// });

Route::get('/',[FrontendController::class,'index'])->name('home');


Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'index'])->name('profile');
    Route::post('/profile-update', [ProfileController::class, 'profileUpdate'])->name('profile.update');
    Route::put('/password', [PasswordController::class, 'update'])->name('update.password');
    Route::put('employee-bio/{employee}',[ProfileController::class,'updateBio'])->name('employee.bio.update');
    Route::put('employee-availability/{employee}',[ProfileController::class,'updateAvailability'])->name('employee.availability.update');
    Route::put('/profile-pic/{user}',[ProfileController::class,'updateProfileImage'])->name('profile.image.update');

});


Route::get('/categories/{category}/services', [FrontendController::class, 'getServices'])->name('get.services');



require __DIR__.'/auth.php';
require __DIR__.'/admin.php';
