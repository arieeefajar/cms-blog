<?php

use App\Http\Controllers\ApprovalPostController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\Author\PostController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\PostController as AdminPostController;
use App\Http\Controllers\UserController;
use Illuminate\Routing\RouteGroup;
use Illuminate\Support\Facades\Route;

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

// Route::get('/', function () {
//     return view('auth/login');
// });

Route::middleware(['guest'])->group(function () {

    Route::controller(AuthController::class)->group(function () {
        Route::name('login.')->group(function () {
            Route::get('/', 'index')->name('index');
            Route::post('/', 'loginProcess')->name('process');
        });

        Route::name('register.')->group(function () {
            Route::get('/register', 'register')->name('index');
            Route::post('/register-process', 'registerProcess')->name('process');
        });

        Route::name('forgot_password.')->group(function () {
            Route::get('/forgot-password', 'forgotPassword')->name('index');
            Route::post('/forgot-password-process', 'forgotPasswordProcess')->name('process');
        });

        Route::name('validation_forgot_password.')->group(function () {
            Route::get('/validation-forgot-password/{token}', 'validationForgotPassword')->name('index');
            Route::post('/validation-forgot-password-process', 'validationForgotPasswordProcess')->name('process');
        });
    });
});

Route::middleware(['auth'])->group(function () {

    Route::controller(AuthController::class)->group(function () {
        Route::post('/logout', 'logout')->name('logout');
        Route::get('/profile', 'profile')->name('profile');
        Route::post('/update-profile', 'updateProfile')->name('updateProfile');
    });

    Route::middleware(['auth', 'admin'])->group(function () {

        Route::get('/dashboard', [DashboardController::class, 'admin'])->name('dashboard');

        Route::prefix('users')->controller(UserController::class)->name('users.')->group(function () {
            Route::get('/', 'index')->name('index');
            Route::post('/', 'store')->name('store');
            Route::put('/{id}', 'update')->name('update');
            Route::delete('/{id}', 'destroy')->name('destroy');
        });

        Route::prefix('categories')->controller(CategoryController::class)->name('categories.')->group(function () {
            Route::get('/', 'index')->name('index');
            Route::post('/', 'store')->name('store');
            Route::put('/{id}', 'update')->name('update');
            Route::delete('/{id}', 'destroy')->name('destroy');
        });

        Route::prefix('posts-data')->controller(AdminPostController::class)->name('posts-data.')->group(function () {
            Route::get('/', 'index')->name('index');
            Route::post('/', 'store')->name('store');
            Route::put('/{id}', 'update')->name('update');
            Route::delete('/{id}', 'destroy')->name('destroy');
        });

        Route::prefix('approval-posts')->controller(ApprovalPostController::class)->name('approval-posts.')->group(function () {
            Route::get('/', 'index')->name('index');
            Route::put('/{id}', 'approve')->name('approve');
            Route::put('/reject/{id}', 'reject')->name('reject');
        });
    });

    Route::middleware(['auth', 'author'])->group(function () {
        Route::get('/dashboard-author', [DashboardController::class, 'author'])->name('dashboard.author');

        Route::prefix('posts')->controller(PostController::class)->name('posts.')->group(function () {
            Route::get('/', 'index')->name('index');
            Route::post('/', 'store')->name('store');
            Route::put('/{id}', 'update')->name('update');
            Route::delete('/{id}', 'destroy')->name('destroy');
        });
    });
});
