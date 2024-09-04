<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\Employee\AircraftController;
use App\Http\Controllers\Employee\AirportController;
use App\Http\Controllers\Employee\CrewController;
use App\Http\Controllers\Employee\FlightController;
use App\Http\Controllers\Employee\JobController;
use App\Http\Controllers\Employee\OtherFlightsController;
use App\Http\Controllers\Employee\ProfileController;
use App\Http\Middleware\EmployeeMiddleware as employee;
use App\Http\Middleware\AdminMiddleware as admin;
use Illuminate\Support\Facades\Route;

//**------------------------------------ Routes Employee ------------------------------------**//

Route::middleware(employee::class)->group(function () {
    Route::get('/profile', [ProfileController::class, 'index'])->name('employee.profile');
    Route::post('/update-profile', [ProfileController::class, 'update'])->name('employee.update-profile');
    // Home Route
    Route::get('/employee/index', function () {
        return view('employee.index');
    });
    Route::post('/change-photo', [ProfileController::class, 'changePhoto'])->name('employee.changePhoto');
    Route::resource('job', JobController::class);
    Route::resource('airport', AirportController::class);
    Route::resource('aircraft', AircraftController::class);
    Route::resource('crew', CrewController::class);
    // Flights
    Route::get('/flight/createNormalFlight', [FlightController::class, 'createNormalFlight'])->name('flight.createNormalFlight');
    Route::get('/flight/createSimulatedFlight', [FlightController::class, 'createSimulatedFlight'])->name('flight.createSimulatedFlight');
    Route::post('/flight/store-simulated-flight', [OtherFlightsController::class, 'storeSimulatedFlight'])->name('flight.storeSimulatedFlight');
    Route::get('/flight/createUnloadedFlight', [FlightController::class, 'createUnloadedFlight'])->name('flight.createUnloadedFlight');
    Route::post('/flight/store-unloaded-flight', [OtherFlightsController::class, 'storeUnloadedFlight'])->name('flight.storeUnloadedFlight');
    Route::get('/flight/createFlyingTest', [FlightController::class, 'createFlyingTest'])->name('flight.createFlyingTest');
    Route::post('/flight/store-test-flight', [OtherFlightsController::class, 'storeFlyingTest'])->name('flight.storeFlyingTest');

    Route::resource('flight', FlightController::class)->except(['create']);
    Route::get('/crew-by-financial-number/{job_id}', [FlightController::class, 'getCrewsByFinancialNumber']);
    Route::get('/jobs-by-type/{type_id}', [CrewController::class, 'getJobsByType']);

});


// Admin Routes
Route::middleware(admin::class)->group(function () {
    Route::get('/admin/dashboard', function () {
        return view('admin.dashboard');
    });
    Route::get('admin/create-user', [AdminController::class, 'createUser'])->name('admin.createUser');
    Route::post('admin/store-user', [AdminController::class, 'storeUser'])->name('admin.storeUser');
    Route::get('admin/edit-user', [AdminController::class, 'editUser'])->name('admin.editUser');
    Route::post('admin/update-user', [AdminController::class, 'updateUser'])->name('admin.updateUser');
    Route::post('admin/delete-user', [AdminController::class, 'deleteUser'])->name('admin.deleteUser');
});


Route::get('/captain/home', function () {
    return view('captain.home');
})->middleware('auth');

// Route::middleware('auth')->group(function () {
//     Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
//     Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
//     Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
// });

require __DIR__ . '/auth.php';


