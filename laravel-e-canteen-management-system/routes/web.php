<?php

use App\Http\Controllers\Auth\ConfirmPasswordController;
use App\Http\Controllers\Auth\ForgotPasswordController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Auth\ResetPasswordController;
use App\Http\Controllers\Auth\VerificationController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\LandingController;
use App\Http\Controllers\MediaController;
use App\Http\Controllers\MenuController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\RestTimeController;
use App\Http\Controllers\SettingsController;
use App\Http\Controllers\StoreController;
use App\Http\Controllers\studentAuth\StudentLoginController;
use App\Http\Controllers\UserManagementController;
use App\Models\Product;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\controllers\studentAuth;
use App\Models\User;

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

Route::get('/', [LandingController::class, 'index'])->name('landing');

//Auth::routes();       //laravel UI default routes

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

// student login routes
Route::get('/student/login', [StudentLoginController::class, 'showLoginForm'])->name('student.login');
Route::post('/student/login', [StudentLoginController::class, 'login']);

//login routes
Route::get('/admin/login', [LoginController::class, 'showloginForm'])->name('login');
Route::post('/admin/login', [LoginController::class, 'login']);

//logout routes
Route::get('/admin/logout', [LoginController::class, 'logout'])->name('logout');

// student logout routes
Route::get('/student/logout', [StudentLoginController::class, 'logout'])->name('student.logout');

//register routes
//Route::get('/register', [RegisterController::class, 'showRegistrationForm'])->name('register');
//Route::post('/register', [RegisterController::class, 'register']);

//reset password routes
Route::get('/admin/password/reset', [ForgotPasswordController::class, 'showLinkRequestForm'])->name('admin.password.request');
Route::post('/admin/password/email', [ForgotPasswordController::class, 'sendResetLinkEmail'])->name('admin.password.email');
Route::get('/admin/password/reset/{token}', [ResetPasswordController::class, 'showResetForm'])->name('admin.password.reset');
Route::post('/admin/password/reset', [ResetPasswordController::class, 'reset'])->name('admin.password.update');

// student reset password routes
Route::get('/student/password/reset', [studentAuth\ForgotPasswordController::class, 'showLinkRequestForm'])->name('student.password.request');
Route::post('/student/password/email', [studentAuth\ForgotPasswordController::class, 'sendResetLinkEmail'])->name('student.password.email');
Route::get('/student/password/reset/{token}', [studentAuth\ResetPasswordController::class, 'showResetForm'])->name('student.password.reset');
Route::post('/student/password/reset', [studentAuth\ResetPasswordController::class, 'reset'])->name('student.password.update');

//password confirmation routes
//Route::get('/password/confirm', [ConfirmPasswordController::class, 'showConfirmForm'])->name('password.confirm');
//Route::post('/password/confirm', [ConfirmPasswordController::class, 'confirm']);

//email verification routes
//Route::get('/email/verify', [VerificationController::class, 'show'])->name('verification.notice');
//Route::get('/email/verify/{id}/{hash}', [VerificationController::class, 'verify'])->name('verification.verify');
//Route::post('/email/resend', [VerificationController::class, 'resend'])->name('verification.resend');

Route::get('/admin/user_management', [UserController::class, 'index'])->name('admin.user');

Route::group(['middleware' => ['guest']], function () {
});

Route::group(['middleware' => ['auth']], function () {

    Route::group(['middleware' => ['can:isAdmin']], function () {

        // profile
        Route::get('/admin/profile', [ProfileController::class, 'index'])->name('admin.profile');
        Route::post('/admin/profile/update_name', [ProfileController::class, 'updateName'])->name('admin.profile.update_name');
        Route::post('/admin/profile/email_verify', [ProfileController::class, 'verifyEmail'])->name('admin.profile.email_verify');
        Route::post('/admin/profile/update_email', [ProfileController::class, 'updateEmail'])->name('admin.profile.update_email');
        Route::post('/admin/profile/update_password', [ProfileController::class, 'updatePassword'])->name('admin.profile.update_password');

        Route::group(['middleware' => 'emailVerified'], function () {

            // home
            Route::get('/admin/home', [HomeController::class, 'index'])->name('admin.home');

            // user management
            Route::get('/admin/user_management', [UserManagementController::class, 'index'])->name('admin.user_management');
            Route::get('/admin/user_management/create', [UserManagementController::class, 'showCreateForm'])->name('admin.user_management.create');
            Route::post('/admin/user_management/save', [UserManagementController::class, 'save'])->name('admin.user_management.save');
            Route::post('/admin/user_management/delete', [UserManagementController::class, 'delete'])->name('admin.user_management.delete');

            // user management - student
            Route::get('/admin/user_management/student/create', [UserManagementController::class, 'showStudentCreateForm'])->name('admin.user_management.student.create');
            Route::post('admin/user_management/student/save', [UserManagementController::class, 'saveStudent'])->name('admin.user_management.student.save');
            Route::post('/admin/user_management/student/delete', [UserManagementController::class, 'deleteStudent'])->name('admin.user_management.student.delete');

            // user management - student - rest time
            Route::get('/admin/user_management/student/rest_time', [RestTimeController::class, 'index'])->name('admin.user_management.student.rest_time');
            Route::post('/admin/user_management/student/rest_time/update', [RestTimeController::class, 'update'])->name('admin.user_management.student.rest_time.update');

            // menus - category
            Route::get('/admin/menus/category', [MenuController::class, 'categoryIndex'])->name('admin.menus.category');
            Route::get('/admin/menus/category/create', [MenuController::class, 'showCategoryCreateForm'])->name('admin.menus.category.create');
            Route::post('/admin/menus/category/save', [MenuController::class, 'saveCategory'])->name('admin.menus.category.save');
            Route::get('/admin/menus/category/{id}/edit', [MenuController::class, 'showCategoryEditForm'])->name('admin.menus.category.edit');
            Route::post('/admin/menus/category/update', [MenuController::class, 'updateCategory'])->name('admin.menus.category.update');
            Route::post('/admin/menus/category/delete', [MenuController::class, 'deleteCategory'])->name('admin.menus.category.delete');

            // payment
            Route::get('/admin/payment', [PaymentController::class, 'index'])->name('admin.payment');
            Route::get('/admin/payment/create', [PaymentController::class, 'showCreateForm'])->name('admin.payment.create');
            Route::post('/admin/payment/save', [PaymentController::class, 'save'])->name('admin.payment.save');
            Route::get('/admin/payment/{id}/edit', [PaymentController::class, 'showEditForm'])->name('admin.payment.edit');
            Route::post('/admin/payment/update', [PaymentController::class, 'update'])->name('admin.payment.update');
            Route::post('/admin/payment/delete', [PaymentController::class, 'delete'])->name('admin.payment.delete');

            // media manager
            Route::get('/admin/media_manager', [MediaController::class, 'index'])->name('admin.media_manager');

            // settings
            Route::get('/admin/settings', [SettingsController::class, 'index'])->name('admin.settings');
            Route::post('/admin/settings/save', [SettingsController::class, 'save'])->name('admin.settings.save');
        });
    });

    Route::group(['middleware' => ['can:isFoodSeller']], function () {

        // profile
        Route::get('/food_seller/profile', [ProfileController::class, 'index'])->name('food_seller.profile');
        Route::post('/food_seller/profile/update_name', [ProfileController::class, 'updateName'])->name('food_seller.profile.update_name');
        Route::post('/food_seller/profile/email_verify', [ProfileController::class, 'verifyEmail'])->name('food_seller.profile.email_verify');
        Route::post('/food_seller/profile/update_email', [ProfileController::class, 'updateEmail'])->name('food_seller.profile.update_email');
        Route::post('/food_seller/profile/update_password', [ProfileController::class, 'updatePassword'])->name('food_seller.profile.update_password');

        Route::group(['middleware' => ['emailVerified']], function () {
            // home
            Route::get('/food_seller/home', [HomeController::class, 'index'])->name('food_seller.home');

            // store
            Route::get('/food_seller/store', [StoreController::class, 'index'])->name('food_seller.store');
            Route::get('/food_seller/store/edit', [StoreController::class, 'showEditForm'])->name('food_seller.store.edit');
            Route::post('/food_seller/store/save', [StoreController::class, 'save'])->name('food_seller.store.save');

            // menu - category
            Route::get('/food_seller/menus/category', [MenuController::class, 'categoryIndex'])->name('food_seller.menus.category');

            // menu - product
            Route::get('/food_seller/menus/product', [MenuController::class, 'productIndex'])->name('food_seller.menus.product');
            Route::get('/food_seller/menus/product/create', [MenuController::class, 'showProductCreateForm'])->name('food_seller.menus.product.create');
            Route::post('/food_seller/menus/product/save', [MenuController::class, 'saveProduct'])->name('food_seller.menus.product.save');
            Route::get('/food_seller/menus/product/{id}/edit', [MenuController::class, 'showProductEditForm'])->name('food_seller.menus.product.edit');
            Route::post('/food_seller/menus/product/update', [MenuController::class, 'updateProduct'])->name('food_seller.menus.product.update');
            Route::post('/food_seller/menus/product/delete', [MenuController::class, 'deleteProduct'])->name('food_seller.menus.product.delete');

            // media manager
            Route::get('/food_seller/media_manager', [MediaController::class, 'index'])->name('food_seller.media_manager');
        });

    });

    Route::group(['prefix' => 'laravel-filemanager', 'middleware' => ['web']], function () {
        \UniSharp\LaravelFilemanager\Lfm::routes();
    });
});

Route::get('/test', function () {
    $user = User::find(1);
    $user->emailVerify()->delete();
});
