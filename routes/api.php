<?php

use App\Http\Controllers\Api\CategoryController;
use App\Http\Controllers\Api\ProductController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});


Route::get('/popular-products', [ProductController::class, 'popularProducts']);

//Апи продукты

Route::prefix('products')->controller('ProductController')->group( function () {
    Route::get('/', [ProductController::class, 'index'])->name('index');
    Route::post('/', [ProductController::class, 'store'])->name('store');
    Route::get('/{slug}', [ProductController::class, 'show'])->name('show');
    Route::put('/{slug}', [ProductController::class, 'update'])->name('update');
    Route::delete('/{slug}', [ProductController::class, 'destroy'])->name('destroy');
});



// Апи категории

Route::prefix('categories')->controller('CategoryController')->group( function () {
    Route::get('/', [CategoryController::class, 'index'])->name('index');
    Route::post('/', [CategoryController::class, 'store'])->name('store');
    Route::get('/{slug}', [CategoryController::class, 'show'])->name('show');
    Route::put('/{slug}', [CategoryController::class, 'update'])->name('update');
    Route::delete('/{slug}', [CategoryController::class, 'destroy'])->name('destroy');
});


// Админ контроллеры

Route::prefix('admin')->group(function () {
    Route::prefix('products')->group( function () {
        Route::get('/', [App\Http\Controllers\Admin\ProductController::class, 'index']);
        Route::post('/', [App\Http\Controllers\Admin\ProductController::class, 'store']);
        Route::get('/{id}', [App\Http\Controllers\Admin\ProductController::class, 'show']);
        Route::put('/{id}', [App\Http\Controllers\Admin\ProductController::class, 'update']);
        Route::delete('/{id}', [App\Http\Controllers\Admin\ProductController::class, 'destroy']);
    });

    Route::prefix('categories')->group( function () {
        Route::get('/', [App\Http\Controllers\Admin\CategoryController::class, 'index']);
        Route::post('/', [App\Http\Controllers\Admin\CategoryController::class, 'store']);
        Route::get('/{id}', [App\Http\Controllers\Admin\CategoryController::class, 'show']);
        Route::put('/{id}', [App\Http\Controllers\Admin\CategoryController::class, 'update']);
        Route::delete('/{id}', [App\Http\Controllers\Admin\CategoryController::class, 'destroy']);
    });
});

