<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\MetrixController;
use App\Http\Controllers\EntityController;



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

Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('submit.login');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');


Route::middleware(['auth'])->group(function () {
    Route::get('/', [DashboardController::class, 'index'])->name('index');
    Route::get('/district/', [DashboardController::class, 'mosquesInCityDetails'])->name('mosquesInCityDetails');





    Route::get('/mosques/', [EntityController::class, 'showEntityList'])->name('showEntityList');
    Route::get('/branches/', [EntityController::class, 'showBranchList'])->name('showBranchList');
    Route::get('/admins/', [EntityController::class, 'showAdminList'])->name('showAdminList');
    Route::get('/api/mosques/{id}', [EntityController::class, 'getMosqueDetails']);
    Route::put('/update/mosques/{id}', [EntityController::class, 'update']);
    Route::post('/add/mosques/', [EntityController::class, 'store']);

    // Route::get('/getAdminDetails/{id}', [DashboardController::class, 'getAdminDetails']);


    Route::get('/getAdminDetails/{id}', [EntityController::class, 'getDetails']);
    Route::post('/updateAdmin/{id}', [EntityController::class, 'updateAdmin']);

    Route::get('/api/branches/{id}', [EntityController::class, 'getBranchDetails']);
    Route::post('/update/branches/{id}', [EntityController::class, 'updateBranch']);


    Route::get('/profile', [AuthController::class, 'profile'])->name('profile');
    Route::put('/profile/update', [AuthController::class, 'updateProfile'])->name('updateProfile');
    Route::put('/profile/password', [AuthController::class, 'updatePassword'])->name('updatePassword');

    Route::get('/compensation', [MetrixController::class, 'compensationList'])->name('compensation.list');
    Route::get('/compensation/create', [MetrixController::class, 'create'])->name('compensation.create');
    Route::post('/compensation/store', [MetrixController::class, 'store'])->name('compensation.store');
    Route::post('/compensation/mark-as-active/{id}', [MetrixController::class, 'markAsActive'])->name('compensation.markAsActive');


    





});




