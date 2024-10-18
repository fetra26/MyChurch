<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\DistrictController;
use App\Http\Controllers\EgliseController;
use App\Http\Controllers\StatusController;
use App\Http\Controllers\ServiceController;
use App\Http\Controllers\TypeController;
use App\Http\Controllers\MissionController;
use App\Http\Controllers\FederationController;
use App\Http\Controllers\MembreController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\TransfertController;
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
Route::get('mission/{id}/addDistrict', [MissionController::class, 'addDistrict']);
Route::post('mission/storeDistrict', [MissionController::class, 'storeDistrict'])->name('mission.storeDistrict');
Route::resource('federation', FederationController::class);
Route::get('federation/{id}/addDistrict', [FederationController::class, 'addDistrict']);
Route::post('federation/storeDistrict', [FederationController::class, 'storeDistrict'])->name('federation.storeDistrict');
Route::resource('district', DistrictController::class);
Route::get('district/{id}/asignPasteur', [DistrictController::class, 'asignPasteur']);
Route::post('district/storePasteur', [DistrictController::class, 'storePasteur'])->name('district.storePasteur');

Route::resource('eglise', EgliseController::class);
Route::get('eglise/{id}/addMembre', [EgliseController::class, 'addMembre']);
Route::post('eglise/storeMembre', [EgliseController::class, 'storeMembre'])->name('eglise.storeMembre');

Route::resource('membre', MembreController::class);
Route::get('membre/{id}/addBaptism', [MembreController::class, 'addBaptism']);
Route::post('membre/storeBaptism', [MembreController::class, 'storeBaptism'])->name('membre.storeBaptism');
Route::get('membre/{id}/asignService', [MembreController::class, 'asignService']);
Route::post('membre/storeService', [MembreController::class, 'storeService'])->name('membre.storeService');

Route::resource('role', RoleController::class);
Route::resource('transfert', TransfertController::class);