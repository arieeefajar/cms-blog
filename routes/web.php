<?php

use App\Http\Controllers\ApprovalPostController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\Author\PostController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\KategoryController;
use App\Http\Controllers\PostController as AdminPostController;
use App\Http\Controllers\UsersController;
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
    Route::get('/', [AuthController::class, 'index'])->name('login');
    Route::post('/login', [AuthController::class, 'prosesLogin'])->name('prosesLogin');

    Route::get('/register', [AuthController::class, 'register'])->name('register');
    Route::post('/proses-register', [AuthController::class, 'prosesRegister'])->name('prosesRegister');
});

Route::middleware(['auth'])->group(function () {
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

    Route::middleware(['auth', 'admin'])->group(function () {
        Route::get('/dashboard', [DashboardController::class, 'admin'])->name('dashboard');

        Route::prefix('users')->group(function () {
            Route::get('/', [UsersController::class, 'index'])->name('users.index');
            Route::post('/', [UsersController::class, 'store'])->name('users.store');
            Route::put('/{id}', [UsersController::class, 'update'])->name('users.update');
            Route::delete('/{id}', [UsersController::class, 'destroy'])->name('users.destroy');
        });

        Route::prefix('kategori')->group(function () {
            Route::get('/', [KategoryController::class, 'index'])->name('kategory.index');
            Route::post('/', [KategoryController::class, 'store'])->name('kategory.store');
            Route::put('/{id}', [KategoryController::class, 'update'])->name('kategory.update');
            Route::delete('/{id}', [KategoryController::class, 'destroy'])->name('kategory.destroy');
        });

        Route::prefix('post-data')->group(function () {
            Route::get('/', [AdminPostController::class, 'index'])->name('post-data.index');
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
