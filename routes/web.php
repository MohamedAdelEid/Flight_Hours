<?php

use App\Http\Controllers\AircraftController;
use App\Http\Controllers\AirportController;
use App\Http\Controllers\JobController;
use App\Http\Controllers\ProfileController;
use App\Http\Middleware\EmployeeMiddleware as employee;
use Illuminate\Support\Facades\Route;

//**------------------------------------ Routes Employee ------------------------------------**//

Route::middleware(employee::class)->group(function () {

    // Home Route
    Route::get('/employee/index', function () {
        return view('employee.index');
    });
    // Resource route job
    Route::resource('job', JobController::class);
    // Resource route airport
    Route::resource('airport', AirportController::class);
    // Resource route aircraft
    Route::resource('aircraft', AircraftController::class);
});

Route::get('/admin/dashboard', function () {
    return view('admin.dashboard');
})->middleware('auth');

Route::get('/captain/index', function () {
    return view('captain.index');
})->middleware('auth');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__ . '/auth.php';

Route::get('/welcome' ,function(){
return view ('welcome');
});

