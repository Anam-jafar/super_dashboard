<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\MetrixController;
use App\Http\Controllers\EntityController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\SubscriptionController;
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

        // Profile Management Routes
        Route::controller(AuthController::class)->group(function () {
            Route::get('/profile', 'profile')->name('profile');
            Route::put('/profile/update', 'updateProfile')->name('updateProfile');
            Route::put('/profile/password', 'updatePassword')->name('updatePassword');
            Route::get('/activity-logs', 'activityLogs')->name('activityLogs');

        });

        // Entity Management Routes
        Route::controller(EntityController::class)->prefix('/{type}')->whereIn('type', ['mosques', 'branches', 'admins'])->group(function () {
            Route::get('/', 'index')->name('showList');
            Route::get('/create', 'create')->name('create');
            Route::post('/store', 'store')->name('store');
            Route::get('/show/{id}', 'show')->name('edit');
            Route::put('/update/{id}', 'update')->name('update');
        });

        Route::prefix('metrix')->name('metrix.')->group(function () {
            $registerCategoryRoutes = function ($prefix, $type) {
                Route::controller(MetrixController::class)->group(function () use ($prefix, $type) {
                    Route::group([
                        'prefix' => $prefix,
                        'as' => $prefix . '.',
                        'where' => ['type' => $type]
                    ], function () {
                        Route::get('/{type}', 'index')->name('list');
                        Route::get('/{type}/create', 'create')->name('create');
                        Route::post('/{type}', 'store')->name('store');
                        Route::get('/{type}/{id}/edit', 'edit')->name('edit');
                        Route::put('/{type}/{id}', 'update')->name('update');
                        Route::put('/{type}/{id}/active', 'markAsActive')->name('mark-active');
                        Route::put('/{type}/{id}/update-and-activate', 'update')
                            ->name('update-and-activate')
                            ->defaults('markAsActive', true);
                    });
                });
            };

            $registerCategoryRoutes('compensation', 'kaffarah');
            $registerCategoryRoutes('settings', 'fidyah');
        });

        Route::controller(SubscriptionController::class)->group(function () {
            Route::get('/active-subscriptions', 'activeSubscriptions')->name('activeSubscriptions');

        });

    });
});



