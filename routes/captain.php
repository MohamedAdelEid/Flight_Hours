<?php


use App\Http\Controllers\CaptainController;
use Illuminate\Support\Facades\Route;
use App\Http\Middleware\CaptainMiddleware as captain;

Route::middleware(captain::class)->group(function () {
    Route::get('/captain/home', [CaptainController::class, 'index'])->name('captain.home');
    Route::post('add-normal-flight',[CaptainController::class,'addNormalFlight'])->name('captain.addNormalFlight');
    Route::post('add-simulate-flight',[CaptainController::class,'addSimulateFlight'])->name('captain.addSimulateFlight');
    Route::post('add-unloaded-flight',[CaptainController::class,'addUnloadedFlight'])->name('captain.addUnloadedFlight');
    Route::post('add-test-flight',[CaptainController::class,'addTestFlight'])->name('captain.addTestFlight');
});
