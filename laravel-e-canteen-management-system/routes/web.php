<?php

use App\Http\Controllers\Auth\ConfirmPasswordController;
use App\Http\Controllers\Auth\ForgotPasswordController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Auth\ResetPasswordController;
use App\Http\Controllers\Auth\VerificationController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\SettingsController;
use App\Http\Controllers\StoreController;
use App\Http\Controllers\UserManagementController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

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

Route::get('/', function () {
    return view('welcome');
});

//Auth::routes();       //laravel UI default routes

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

//login routes
Route::get('/login', [LoginController::class, 'showloginForm'])->name('login');
Route::post('/login', [LoginController::class, 'login']);

//logout routes
Route::get('/logout', [LoginController::class, 'logout'])->name('logout');
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

//register routes
Route::get('/register', [RegisterController::class, 'showRegistrationForm'])->name('register');
Route::post('/register', [RegisterController::class, 'register']);

//reset password routes
Route::get('/password/reset', [ForgotPasswordController::class, 'showLinkRequestForm'])->name('password.request');
Route::post('/password/email', [ForgotPasswordController::class, 'sendResetLinkEnail'])->name('password.email');
Route::get('/password/reset/{token}', [ResetPasswordController::class, 'showResetForm'])->name('password.reset');
Route::post('/password/reset', [ResetPasswordController::class, 'reset'])->name('password.update');

//password confirmation routes
Route::get('/password/confirm', [ConfirmPasswordController::class, 'showConfirmForm'])->name('password.confirm');
Route::post('/password/confirm', [ConfirmPasswordController::class, 'confirm']);

//email verification routes
Route::get('/email/verify', [VerificationController::class, 'show'])->name('verification.notice');
Route::get('/email/verify/{id}/{hash}', [VerificationController::class, 'verify'])->name('verification.verify');
Route::post('/email/resend', [VerificationController::class, 'resend'])->name('verification.resend');

Route::get('/admin/user_management', [UserController::class, 'index'])->name('admin.user');

Route::group(['middleware' => ['guest']], function () {

});

Route::group(['middleware' => ['auth']], function () {

    Route::group(['middleware' => ['can:isAdmin']], function () {

        // home
        Route::get('/admin/home', [HomeController::class, 'index'])->name('admin.home');

        // user management
        Route::get('/admin/user_management', [UserManagementController::class, 'index'])->name('admin.user_management');
        Route::get('/admin/user_management/create', [UserManagementController::class, 'showCreateForm'])->name('admin.user_management.create');
        Route::post('/admin/user_management/save', [UserManagementController::class, 'save'])->name('admin.user_management.save');
        Route::post('/admin/user_management/delete', [UserManagementController::class, 'delete'])->name('admin.user_management.delete');

        // settings
        Route::get('/admin/settings', [SettingsController::class, 'index'])->name('admin.settings');
        Route::post('/admin/settings/save', [SettingsController::class, 'save'])->name('admin.settings.save');
    });

    Route::group(['middleware' => ['can:isFoodSeller']], function () {

        // home
        Route::get('/food_seller/home', [HomeController::class, 'index'])->name('food_seller.home');

        // store
        Route::get('/food_seller/store', [StoreController::class, 'index'])->name('food_seller.store');

    });

});