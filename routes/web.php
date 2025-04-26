<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\SubscriptionController;
use App\Http\Controllers\InstituteController;
use App\Http\Controllers\FinancialStatementController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\SettingController;
use App\Http\Controllers\MetrixController;
use Illuminate\Support\Facades\Response;

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
    Route::match(['get', 'post'], '/reset-password/{id}', [AuthController::class, 'resetPassword'])->name('resetPassword');
    Route::post('/check-email-send-otp', [AuthController::class, 'checkEmailAndSendOtp']);



    // Routes requiring authentication
    Route::middleware(['auth'])->group(function () {

        // Dashboard Routes
        Route::get('/', [DashboardController::class, 'index'])->name('index');
        Route::get('/dashboard', [DashboardController::class, 'dashboard'])->name('dashboard');
        Route::get('/district', [DashboardController::class, 'mosquesInCityDetails'])->name('mosquesInCityDetails');
        Route::get('/get-financial-report', [DashboardController::class, 'getFinancialReport'])->name('getFinancialReport');
        Route::get('/get-statement-report', [DashboardController::class, 'getStatementsReport'])->name('getStatementsReport');


        // Profile Management Routes
        Route::controller(AuthController::class)->group(function () {
            Route::get('/profile', 'profile')->name('profile');
            Route::put('/profile/update', 'updateProfile')->name('updateProfile');
            Route::put('/profile/password', 'updatePassword')->name('updatePassword');
            Route::get('/activity-logs', 'activityLogs')->name('activityLogs');

        });

        Route::controller(SubscriptionController::class)->group(function () {
            Route::get('/active-subscriptions', 'activeSubscriptions')->name('activeSubscriptions');
            Route::get('/request-subscriptions', 'requestSubscriptions')->name('requestSubscriptions');
            Route::get('/outstanding-subscriptions', 'outstandingSubscriptions')->name('outstandingSubscriptions');
            Route::post('/subscription-fee-add', 'subscriptionFeeAdd')->name('subscriptionFeeAdd');
        });
        Route::get('/under-maintainance', [SubscriptionController::class, 'underMaintainance'])->name('underMaintainance');

        Route::get('/institute/list', [InstituteController::class, 'list'])->name('instituteList');
        Route::match(['get', 'post'], '/institute/create', [InstituteController::class, 'create'])->name('instituteCreate');
        Route::match(['get', 'post'], '/institute/edit/{id}', [InstituteController::class, 'edit'])->name('instituteEdit');
        Route::get('/institute/registration-requests', [InstituteController::class, 'registrationRequests'])->name('registrationRequests');
        Route::get('/institute/registration-requests/{id}', [InstituteController::class, 'registrationRequestDetail'])->name('registrationRequestDetail');
        Route::post('/institute/registration-requests/{id}', [InstituteController::class, 'approveRegistrationRequest'])->name('approveRegistrationRequest');

        Route::get('/get-institution-categories', [InstituteController::class, 'getInstitutionCategories'])->name('getInstitutionCategories');
        Route::get('/get-subdistricts', [InstituteController::class, 'getSubDistricts'])->name('getSubDistricts');
        Route::get('/search-bandar', [InstituteController::class, 'getBandar'])->name('search.bandar');

        Route::get('/user/list', [UserController::class, 'list'])->name('userList');
        Route::match(['get', 'post'], '/user/create', [UserController::class, 'create'])->name('userCreate');
        Route::match(['get', 'post'], '/user/edit/{id}', [UserController::class, 'edit'])->name('userEdit');



        Route::get('/financial-statement/list', [FinancialStatementController::class, 'list'])->name('statementList');
        Route::get('/financial-statement/reviewed-list', [FinancialStatementController::class, 'reviewedList'])->name('reviwedStatementList');
        Route::match(['get', 'post'], '/financial-statement/view/{id}', [FinancialStatementController::class, 'view'])->name('viewStatement');
        Route::match(['get', 'post'], '/financial-statement/review/{id}', [FinancialStatementController::class, 'review'])->name('reviewStatement');
        Route::post('/financial-statement/edit-request/approve/{id}', [FinancialStatementController::class, 'approveEditRequest'])->name('approveEditRequest');

        Route::get('/report/submission-count-list', [ReportController::class, 'submissionCount'])->name('submissionCountReport');
        Route::get('/report/submission-status-list', [ReportController::class, 'submissionStatus'])->name('submissionStatusReport');
        Route::get('/report/collection-expense', [ReportController::class, 'collectionAndExpense'])->name('collectionAndExpenseReport');
        Route::get('/report/statement-submission', [ReportController::class, 'submissionDetailed'])->name('submissionDetailedReport');
        Route::match(['get', 'post'], '/report/search-statement', [ReportController::class, 'searchStatement'])->name('searchStatementReport');
        Route::get('/report/export-statement', [ReportController::class, 'exportStatementReport'])->name('exportStatementReport');
        Route::get('/report/filtered-submission', [ReportController::class, 'filteredSubmission'])->name('filteredSubmission');


        Route::get('/setting/list', [SettingController::class, 'list'])->name('settingsList');
        Route::match(['get', 'post'], '/setting/create', [SettingController::class, 'create'])->name('settingsCreate');
        Route::match(['get', 'post'], '/setting/edit/{id}', [SettingController::class, 'edit'])->name('settingsEdit');
        Route::get('/setting/country', [SettingController::class, 'country'])->name('settingsCountry');
        Route::match(['get', 'post'], '/setting/country/create', [SettingController::class, 'countryCreate'])->name('settingsCountryCreate');
        Route::match(['get', 'post'], '/setting/country/edit/{id}', [SettingController::class, 'countryEdit'])->name('settingsCountryEdit');
        Route::get('/setting/institute', [SettingController::class, 'institute'])->name('settingsInstitute');
        Route::match(['get', 'post'], '/setting/institute/create', [SettingController::class, 'instituteCreate'])->name('settingsInstituteCreate');
        Route::match(['get', 'post'], '/setting/institute/edit/{id}', [SettingController::class, 'instituteEdit'])->name('settingsInstituteEdit');


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






    });

    Route::get('/download/attachment/{filename}', function ($filename) {
        $path = '/var/www/static_files/fin_statement_attachments/' . $filename;
        if (file_exists($path)) {
            return response()->file($path);
        }
        return redirect()->back()->with('error', 'File not found');
    })->name('download.attachment');

    Route::get('/tutorial', function () {
        return view('tutorial');
    });
});
