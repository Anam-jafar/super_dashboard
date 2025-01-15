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
        Route::controller(EntityController::class)->prefix('/{type}')->whereIn('type', ['mosques', 'branches', 'admins'])->group(function () {
            Route::get('/', 'index')->name('showList');
            Route::get('/create', 'create')->name('create');
            Route::post('/store', 'store')->name('store');
            Route::get('/show/{id}', 'show')->name('edit');
            Route::put('/update/{id}', 'update')->name('update');
        });

        // Profile Management Routes
        Route::controller(AuthController::class)->group(function () {
            Route::get('/profile', 'profile')->name('profile');
            Route::put('/profile/update', 'updateProfile')->name('updateProfile');
            Route::put('/profile/password', 'updatePassword')->name('updatePassword');
            Route::get('/activity-logs', 'activityLogs')->name('activityLogs');

        });

        // Kaffarah Settings Routes
        // Route::controller(MetrixController::class)->group(function () {
        //     Route::get('/expiation', 'expiationList')->name('compensation.list');
        //     Route::get('/expiation/create', 'expiationCreate')->name('compensation.create');
        //     Route::post('/expiation/store', 'expiationStore')->name('compensation.store');
        //     Route::post('/expiation/mark-as-active/{id}', 'expiationMarkAsActive')->name('compensation.markAsActive');

        //     Route::get('/compensation', 'compensationList')->name('compensation_.list');
        //     Route::get('/compensation/create', 'compensationCreate')->name('compensation_.create');
        //     Route::post('/compensation/store', 'compensationStore')->name('compensation_.store');
        //     Route::post('/compensation/mark-as-active/{id}', 'compensationMarkAsActive')->name('compensation_.markAsActive');
        //     Route::get('/compensation/{id}/edit','expiationEdit')->name('compensation.edit');
        //     Route::post('/compensation/{id}/update', 'expiationUpdate')->name('compensation.update');
        //     Route::post('/compensation/update-and-mark-active/{id}', 'expiationUpdateAndMarkAsActive')->name('compensation.updateAndMarkAsActive');


        // });

Route::prefix('metrix')->name('metrix.')->group(function () {
    // Helper function to register common category routes
    $registerCategoryRoutes = function ($prefix, $category) {
        Route::group([
            'prefix' => $prefix,
            'as' => $prefix . '.',
            'where' => ['category' => 'kaffarah|fidyah']
        ], function () use ($category) {
            // Resource routes
            Route::get('/{category}', [MetrixController::class, 'index'])
                ->name('list')
                ->where('category', $category);
            Route::get('/{category}/create', [MetrixController::class, 'create'])
                ->name('create')
                ->where('category', $category);
            Route::post('/{category}', [MetrixController::class, 'store'])
                ->name('store')
                ->where('category', $category);
            Route::get('/{category}/{id}/edit', [MetrixController::class, 'edit'])
                ->name('edit')
                ->where('category', $category);
            Route::put('/{category}/{id}', [MetrixController::class, 'update'])
                ->name('update')
                ->where('category', $category);
            
            // Custom actions
            Route::put('/{category}/{id}/active', [MetrixController::class, 'markAsActive'])
                ->name('mark-active')
                ->where('category', $category);
            Route::put('/{category}/{id}/update-and-activate', [MetrixController::class, 'update'])
                ->name('update-and-activate')
                ->where('category', $category)
                ->defaults('markAsActive', true);
        });
    };

    // Register routes for both categories
    $registerCategoryRoutes('compensation', 'kaffarah');
    $registerCategoryRoutes('settings', 'fidyah');
});
    });
});



