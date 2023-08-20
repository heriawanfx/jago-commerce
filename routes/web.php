<?php

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
    Route::get(RouteServiceProvider::HOME, function () {
        return view('pages.dashboard', ['type_menu' => 'dashboard']);
    })->can(AuthServiceProvider::ACCESS_DASHBOARD)->name('dashboard');

    Route::get('/profile', function() {
        return view('pages.user.user-profile');
    })->can(AuthServiceProvider::ACCESS_PROFILE)->name('profile');

    Route::get('/user-management', function () {
        return view('pages.user.user-management', ['type_menu' => 'user']);
    })->can(AuthServiceProvider::ACCESS_USER_MANAGEMENT)->name('user-management');

    //Force logout to fix Expired after login
    Route::get('logout', [AuthenticatedSessionController::class, 'destroy']);
});

/*
Route::get('/login', function () {
    return view('auth.login');
});
Route::get('/register', function () {
    return view('auth.register');
});
 */