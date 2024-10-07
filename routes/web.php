<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\DistrictController;
use App\Http\Controllers\StatusController;
use App\Http\Controllers\ServiceController;
use App\Http\Controllers\TypeController;
use App\Http\Controllers\MissionController;
use App\Http\Controllers\FederationController;
use App\Models\District;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    Route::get('/dashboard',[DashboardController::class, 'redirect'])->name('dashboard');
});
Route::get('redirect',[DashboardController::class, 'redirect']);
Route::resource('status', StatusController::class);
Route::resource('service', ServiceController::class);
Route::resource('type', TypeController::class);
Route::resource('mission', MissionController::class);
Route::resource('federation', FederationController::class);
Route::resource('district', DistrictController::class);
