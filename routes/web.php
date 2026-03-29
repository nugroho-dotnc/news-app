<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\PublicArticleController;
use App\Http\Controllers\PublicCategoryController;
use App\Http\Controllers\SearchController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\ArticleController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\TagController;
use App\Http\Controllers\Admin\CommentController;
use App\Http\Controllers\Admin\MediaController;
use App\Http\Controllers\Admin\UserController;

// ─── Public Routes ────────────────────────────────────────────────────────────
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/cari', [SearchController::class, 'index'])->name('search');
Route::get('/kategori/{slug}', [PublicCategoryController::class, 'show'])->name('category.show');
Route::get('/artikel/{slug}', [PublicArticleController::class, 'show'])->name('article.show');
Route::post('/artikel/{slug}/komentar', [PublicArticleController::class, 'storeComment'])->name('article.comment');

// ─── Auth Routes ──────────────────────────────────────────────────────────────
Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login'])->name('login.post');
});

Route::post('/logout', [AuthController::class, 'logout'])->name('logout')->middleware('auth');

// ─── Admin Routes (Admin & Editor) ────────────────────────────────────────────
Route::prefix('admin')->name('admin.')->middleware(['auth', 'role:admin,editor'])->group(function () {

    // Dashboard
    Route::get('/', [DashboardController::class, 'index'])->name('dashboard');

    // Articles
    Route::get('/artikel', [ArticleController::class, 'index'])->name('articles.index');
    Route::get('/artikel/buat', [ArticleController::class, 'create'])->name('articles.create');
    Route::post('/artikel', [ArticleController::class, 'store'])->name('articles.store');
    Route::get('/artikel/{article}', [ArticleController::class, 'show'])->name('articles.show');
    Route::get('/artikel/{article}/edit', [ArticleController::class, 'edit'])->name('articles.edit');
    Route::put('/artikel/{article}', [ArticleController::class, 'update'])->name('articles.update');
    Route::delete('/artikel/{article}', [ArticleController::class, 'destroy'])->name('articles.destroy');
    Route::patch('/artikel/{id}/restore', [ArticleController::class, 'restore'])->name('articles.restore');
    Route::delete('/artikel/{id}/force-delete', [ArticleController::class, 'forceDelete'])->name('articles.forceDelete');
    Route::patch('/artikel/{article}/toggle-status', [ArticleController::class, 'toggleStatus'])->name('articles.toggleStatus');

    // Categories
    Route::get('/kategori', [CategoryController::class, 'index'])->name('categories.index');
    Route::get('/kategori/buat', [CategoryController::class, 'create'])->name('categories.create');
    Route::post('/kategori', [CategoryController::class, 'store'])->name('categories.store');
    Route::get('/kategori/{category}/edit', [CategoryController::class, 'edit'])->name('categories.edit');
    Route::put('/kategori/{category}', [CategoryController::class, 'update'])->name('categories.update');
    Route::delete('/kategori/{category}', [CategoryController::class, 'destroy'])->name('categories.destroy');

    // Tags
    Route::get('/tag', [TagController::class, 'index'])->name('tags.index');
    Route::get('/tag/buat', [TagController::class, 'create'])->name('tags.create');
    Route::post('/tag', [TagController::class, 'store'])->name('tags.store');
    Route::get('/tag/{tag}/edit', [TagController::class, 'edit'])->name('tags.edit');
    Route::put('/tag/{tag}', [TagController::class, 'update'])->name('tags.update');
    Route::delete('/tag/{tag}', [TagController::class, 'destroy'])->name('tags.destroy');

    // Comments (moderation)
    Route::get('/komentar', [CommentController::class, 'index'])->name('comments.index');
    Route::patch('/komentar/{comment}/approve', [CommentController::class, 'approve'])->name('comments.approve');
    Route::patch('/komentar/{comment}/reject', [CommentController::class, 'reject'])->name('comments.reject');
    Route::delete('/komentar/{comment}', [CommentController::class, 'destroy'])->name('comments.destroy');

    // Media
    Route::get('/media', [MediaController::class, 'index'])->name('media.index');
    Route::post('/media', [MediaController::class, 'store'])->name('media.store');
    Route::delete('/media/{media}', [MediaController::class, 'destroy'])->name('media.destroy');

    // Users — Admin only
    Route::middleware('role:admin')->group(function () {
        Route::get('/pengguna', [UserController::class, 'index'])->name('users.index');
        Route::get('/pengguna/buat', [UserController::class, 'create'])->name('users.create');
        Route::post('/pengguna', [UserController::class, 'store'])->name('users.store');
        Route::get('/pengguna/{user}/edit', [UserController::class, 'edit'])->name('users.edit');
        Route::put('/pengguna/{user}', [UserController::class, 'update'])->name('users.update');
        Route::delete('/pengguna/{user}', [UserController::class, 'destroy'])->name('users.destroy');
    });
});
