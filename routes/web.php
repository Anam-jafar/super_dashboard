<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\AuthController;



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
use App\Http\Controllers\DashboardController;

Route::get('/dashboard/create', [DashboardController::class, 'create'])->name('dashboard.create');
Route::post('/dashboard/store', [DashboardController::class, 'store'])->name('dashboard.store');


Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('submit.login');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');


Route::get('/', [DashboardController::class, 'dashboard'])->name('dashboard');
Route::get('/dashboard', [DashboardController::class, 'index'])->name('index');

Route::get('/report', [ReportController::class, 'showReport'])->name('showReport');
Route::get('/login', function () {
    return view('auth.login');
});

