<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

use App\Http\Controllers\Api\AuthorController;
use App\Http\Controllers\Api\BookController;
use App\Http\Controllers\Api\CategoryController;
use App\Http\Controllers\Api\StatsController;

// Harus di atas apiResource agar tidak dianggap {book}
Route::get('/books/low-stock', [BookController::class, 'lowStock']);
Route::get('/stats', StatsController::class);

Route::apiResource('authors', AuthorController::class);
Route::apiResource('categories', CategoryController::class)->only(['index', 'store', 'destroy']);
Route::apiResource('books', BookController::class);