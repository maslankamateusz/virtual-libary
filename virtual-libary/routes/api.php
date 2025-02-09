<?php

use App\Http\Controllers\ReviewController;
use App\Http\Controllers\BookController;
use Illuminate\Support\Facades\Route;

Route::apiResource('reviews', ReviewController::class);
Route::apiResource('books', BookController::class);
Route::get('books/{id}/reviews', [BookController::class, 'reviews']);