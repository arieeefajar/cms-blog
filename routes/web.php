<?php

use App\Http\Controllers\ApprovalPostController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\Author\PostController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\KategoryController;
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

        Route::prefix('kategori')->group(function () {
            Route::get('/', [KategoryController::class, 'index'])->name('kategory.index');
            Route::post('/', [KategoryController::class, 'store'])->name('kategory.store');
            Route::put('/{id}', [KategoryController::class, 'update'])->name('kategory.update');
            Route::delete('/{id}', [KategoryController::class, 'destroy'])->name('kategory.destroy');
        });

        Route::prefix('post-data')->group(function () {
            Route::get('/', [AdminPostController::class, 'index'])->name('post-data.index');
            Route::post('/', [AdminPostController::class, 'store'])->name('post-data.store');
            Route::put('/{id}', [AdminPostController::class, 'update'])->name('post-data.update');
            Route::delete('/{id}', [AdminPostController::class, 'destroy'])->name('post-data.destroy');
        });

        Route::prefix('approval-post')->group(function () {
            Route::get('/', [ApprovalPostController::class, 'index'])->name('approval-post.index');
            Route::put('/{id}', [ApprovalPostController::class, 'approve'])->name('approval-post.approve');
            Route::put('/reject/{id}', [ApprovalPostController::class, 'reject'])->name('approval-post.reject');
        });
    });

    Route::middleware(['auth', 'author'])->group(function () {
        Route::get('/dashboard-author', [DashboardController::class, 'author'])->name('dashboard.author');

        Route::prefix('posts')->group(function () {
            Route::get('/', [PostController::class, 'index'])->name('posts.index');
            Route::post('/', [PostController::class, 'store'])->name('posts.store');
            Route::put('/{id}', [PostController::class, 'update'])->name('posts.update');
            Route::delete('/{id}', [PostController::class, 'destroy'])->name('posts.destroy');
        });
    });
});
