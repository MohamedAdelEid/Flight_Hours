<?php


use App\Http\Controllers\CaptainController;
use Illuminate\Support\Facades\Route;
use App\Http\Middleware\CaptainMiddleware as captain;

Route::middleware(captain::class)->group(function () {
    Route::get('/captain/home', [CaptainController::class, 'index'])->name('captain.home');
    Route::post('add-normal-flight',[CaptainController::class,'addNormalFlight'])->name('captain.addNormalFlight');
});
