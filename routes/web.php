<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\RecipeController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\CommentController as AdminCommentController;
use App\Http\Middleware\IsAdmin;
use App\Http\Middleware\SetLocale;
use App\Http\Controllers\ReviewController;

Route::middleware(['web', SetLocale::class])->group(function () {

    Route::get('/', function () {
        return view('welcome');
    })->name('welcome');

    Route::get('/all-recipes', function () {
        return view('all-recipes');
    })->middleware(['auth', 'verified'])->name('all-recipes');

    Route::get('/all-recipes', [RecipeController::class, 'allRecipes'])->name('recipes.all');

    Route::get('/my-recipes', [RecipeController::class, 'index'])->name('my-recipes')->middleware('auth');
    Route::get('/recipes', [RecipeController::class, 'index'])->name('recipes.index');


    Route::middleware('auth')->group(function () {
        Route::resource('recipes', RecipeController::class)->except(['show']);
        Route::post('/comments', [CommentController::class, 'store'])->name('comments.store');
        Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
        Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
        Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    });
    Route::get('/recipes/{recipe}', [RecipeController::class, 'show'])->name('recipes.show');
    Route::get('/recommended-recipes', [RecipeController::class, 'recommended'])->name('recipes.recommended');
    Route::middleware(['auth', IsAdmin::class])
        ->prefix('admin')
        ->name('admin.')
        ->group(function () {
            Route::get('/', [AdminController::class, 'index'])->name('dashboard');
            Route::get('/users', [UserController::class, 'index'])->name('users.index');
            Route::get('/comments', [AdminCommentController::class, 'index'])->name('comments.index');
            Route::delete('/users/{user}', [UserController::class, 'destroy'])->name('users.destroy');
            Route::delete('/comments/{comment}', [AdminCommentController::class, 'destroy'])->name('comments.destroy');
        });
    Route::get('lang/{locale}', function ($locale) {
        if (! in_array($locale, ['lv', 'en'])) {
            abort(400);
        }
        session(['locale' => $locale]);
        return redirect()->back();
    })->name('lang.switch');

    Route::get('/reviews', [ReviewController::class, 'index'])->name('reviews.index');
    Route::post('/reviews', [ReviewController::class, 'store'])->name('reviews.store');


    require __DIR__.'/auth.php';
});
