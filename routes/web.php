<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\MetrixController;
use App\Http\Controllers\EntityController;
use App\Http\Controllers\DashboardController;

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

Route::prefix('mais')->group(function () {
    // Authentication Routes
    Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [AuthController::class, 'login'])->name('submit.login');
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

    // Routes requiring authentication
    Route::middleware(['auth'])->group(function () {
        // Dashboard Routes
        Route::get('/', [DashboardController::class, 'index'])->name('index');
        Route::get('/district', [DashboardController::class, 'mosquesInCityDetails'])->name('mosquesInCityDetails');

        // Entity Management Routes
        Route::controller(EntityController::class)->group(function () {
            Route::get('/mosques', 'showEntityList')->name('showEntityList');
            Route::get('/mosques/show/{id}', 'showEntity')->name('editEntity');
            Route::put('/mosques/update/{id}', 'updateEntity')->name('updateEntity');

            Route::get('/branches', 'showBranchList')->name('showBranchList');
            Route::get('/branches/show/{id}', 'showBranch')->name('editBranch');
            Route::put('/branches/update/{id}', 'updateBranch')->name('updateBranch');


            Route::get('/admins', 'showAdminList')->name('showAdminList');
            Route::get('/admins/show/{id}', 'showAdmin')->name('editAdmin');
            Route::put('/admins/update/{id}', 'updateAdmin')->name('updateAdmin');


            Route::get('/get_mosque_detail/{id}', 'getMosqueDetails');
            Route::put('/update/mosques/{id}', 'update');
            Route::post('/add/mosques/', 'store');
            Route::get('/getAdminDetails/{id}', 'getDetails');
            Route::post('/updateAdmin/{id}', 'updateAdmin');
            Route::get('/get_branche_detail/{id}', 'getBranchDetails');
            Route::post('/update/branches/{id}', 'updateBranch');
        });

        // Profile Management Routes
        Route::controller(AuthController::class)->group(function () {
            Route::get('/profile', 'profile')->name('profile');
            Route::put('/profile/update', 'updateProfile')->name('updateProfile');
            Route::put('/profile/password', 'updatePassword')->name('updatePassword');
            Route::get('/activity-logs', 'activityLogs')->name('activityLogs');

        });

        // Kaffarah Settings Routes
        Route::controller(MetrixController::class)->group(function () {
            Route::get('/expiation', 'expiationList')->name('compensation.list');
            Route::get('/expiation/create', 'expiationCreate')->name('compensation.create');
            Route::post('/expiation/store', 'expiationStore')->name('compensation.store');
            Route::post('/expiation/mark-as-active/{id}', 'expiationMarkAsActive')->name('compensation.markAsActive');

            Route::get('/compensation', 'compensationList')->name('compensation_.list');
            Route::get('/compensation/create', 'compensationCreate')->name('compensation_.create');
            Route::post('/compensation/store', 'compensationStore')->name('compensation_.store');
            Route::post('/compensation/mark-as-active/{id}', 'compensationMarkAsActive')->name('compensation_.markAsActive');
        });
    });
});

Route::get('/create-institute', [EntityController::class, 'createInstitute'])->name('createInstitute');
Route::get('/create-admin', [EntityController::class, 'createAdmin'])->name('createAdmin');
Route::get('/create-branches', [EntityController::class, 'createBranch'])->name('createBranch');


