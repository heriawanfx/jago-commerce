<?php

use App\Http\Controllers\UserController;
use App\Providers\AuthServiceProvider;
use App\Providers\RouteServiceProvider;
use Illuminate\Support\Facades\Route;
use Laravel\Fortify\Http\Controllers\AuthenticatedSessionController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('auth.login');
})->name('/');

Route::middleware(['auth','verified'])->group(function () {
    
    Route::get(RouteServiceProvider::HOME, fn () => view('pages.dashboard'))
        ->can(AuthServiceProvider::ACCESS_DASHBOARD)
        ->name('dashboard');

    Route::get('/user/profile', fn () => view('pages.user.user-profile'))
        ->can(AuthServiceProvider::ACCESS_PROFILE)
        ->name('user-profile');

    Route::get('/user/management', [UserController::class, 'index'])
        ->can(AuthServiceProvider::ACCESS_USER_MANAGEMENT)
        ->name('user-management');

    //Force logout to fix Expired after login
    Route::get('/logout', [AuthenticatedSessionController::class, 'destroy']);
});