<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\StatusController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');
});
Route::get('redirect',[DashboardController::class, 'redirect']);
Route::resource('status', StatusController::class);
