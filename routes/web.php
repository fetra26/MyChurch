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

Route::get('/status', [StatusController::class, 'index'])->name('status.index');

Route::group(['prefix' => 'status'], function () {
    Route::get('/create', [StatusController::class, 'create'])->name('status.create');
    Route::post('/add', [StatusController::class, 'store'])->name('status.store');
    Route::get('/edit/{id}', [StatusController::class, 'edit'])->name('status.edit');
    Route::post('/update/{id}', [StatusController::class, 'update'])->name('status.update');
    Route::post('/delete', [StatusController::class, 'destroy'])->name('status.delete');
});
