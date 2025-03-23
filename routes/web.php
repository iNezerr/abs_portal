<?php

use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use App\Http\Controllers\ApplyController;
use App\Http\Controllers\CompleteController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('session-data/{key}', function ($key) {
    return (session($key) ?? []);
})->name('session.get');
Route::get('/', [ApplyController::class, 'create'])->name('apply.index');
Route::post('personal-info', [ApplyController::class, 'storePersonalInfo'])->name('apply.store-personal-info');
Route::post('church-info', [ApplyController::class, 'storeChurchInfo'])->name('apply.store-church-info');
Route::post('health-info', [ApplyController::class, 'storeHealthInfo'])->name('apply.store-health-info');
Route::post('criminal-info', [ApplyController::class, 'storeCriminalInfo'])->name('apply.store-criminal-info');
Route::post('recommendation-info', [ApplyController::class, 'storeRecommendationInfo'])->name('apply.store-recommendation-info');
Route::post('social-info', [ApplyController::class, 'storeSocialHistory'])->name('apply.store-social-info');
Route::post('confirmation', [ApplyController::class, 'confirmation'])->name('apply.store-confirmation');
Route::get('/complete', CompleteController::class)->name('apply.complete');


Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    Route::get('/dashboard', function () {
        return Inertia::render('Dashboard');
    })->name('dashboard');
});