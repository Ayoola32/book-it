<?php

use App\Http\Controllers\Admin\AppointmentController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Auth\PasswordController;
use App\Http\Controllers\FrontendController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;


Route::get('/',[FrontendController::class,'index'])->name('home');
Route::get('/categories/{category}/services', [FrontendController::class, 'getServices'])->name('get.services');
Route::get('/services/{service}/employees', [FrontendController::class, 'getEmployees'])->name('get.employees');
Route::get('/employees/{employee}/availability/{date?}', [FrontendController::class, 'getEmployeeAvailability'])->name('employee.availability');
Route::post('/bookings', [AppointmentController::class, 'store'])->name('bookings.store');





// Authentication routes
Route::middleware('auth')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index2'])->name('dashboard');
    Route::get('/profile', [ProfileController::class, 'index'])->name('profile');
    Route::post('/profile-update', [ProfileController::class, 'profileUpdate'])->name('profile.update');
    Route::put('/password', [PasswordController::class, 'update'])->name('update.password');
    Route::put('employee-bio/{employee}',[ProfileController::class,'updateBio'])->name('employee.bio.update');
    Route::put('employee-availability/{employee}',[ProfileController::class,'updateAvailability'])->name('employee.availability.update');
    Route::put('/profile-pic/{user}',[ProfileController::class,'updateProfileImage'])->name('profile.image.update');
    Route::get('appointments', [AppointmentController::class, 'index2'])->name('employee.appointment.index');
    Route::post('/appointment/update-status', [AppointmentController::class, 'updateStatus'])->name('appointment.update-status');


});





require __DIR__.'/auth.php';
require __DIR__.'/admin.php';
