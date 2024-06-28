<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\AircraftController;
use App\Http\Controllers\AirportController;
use App\Http\Controllers\CrewController;
use App\Http\Controllers\FlightController;
use App\Http\Controllers\JobController;
use App\Http\Controllers\ProfileController;
use App\Http\Middleware\EmployeeMiddleware as employee;
use App\Http\Middleware\AdminMiddleware as admin;
use Illuminate\Support\Facades\Route;

//**------------------------------------ Routes Employee ------------------------------------**//

Route::middleware(employee::class)->group(function () {

    // Home Route
    Route::get('/employee/index', function () {
        return view('employee.index');
    });
    Route::resource('job', JobController::class);
    Route::resource('airport', AirportController::class);
    Route::resource('aircraft', AircraftController::class);
    Route::resource('crew', CrewController::class);
    Route::resource('flight', FlightController::class);
    Route::get('/crews-by-job/{job_id}', [FlightController::class, 'getCrewsByJob']);
    Route::get('/jobs-by-type/{type_id}', [CrewController::class, 'getJobsByType']);
    });


// Admin Routes
Route::middleware(admin::class)->group(function () {
    Route::get('/admin/dashboard', function () {
        return view('admin.dashboard');
    });
    Route::resource('admin',AdminController::class);
});


Route::get('/captain/index', function () {
    return view('captain.index');
})->middleware('auth');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__ . '/auth.php';


