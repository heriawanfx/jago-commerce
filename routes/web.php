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
});

Route::middleware(['auth','verified'])->group(function () {
    Route::get(RouteServiceProvider::HOME, function () {
        return view('pages.dashboard', ['type_menu' => '']);
    })->can(AuthServiceProvider::ACCESS_DASHBOARD);

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