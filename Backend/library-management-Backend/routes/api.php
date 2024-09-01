<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\BookController;
use Illuminate\Support\Facades\Route;

// User signup route
Route::post('/signup', [AuthController::class, 'Signup']);

// User login route
Route::post('/login', [AuthController::class, 'login']);

// Routes that require authentication
Route::middleware('auth:sanctum')->group(function () {

    // User logout route
    Route::post('/logout', [AuthController::class, 'logout']);

    // Route to add a new book
    Route::post('/books', [BookController::class, 'store']);

    // Route to get the list of all books
    Route::get('/books', [BookController::class, 'index']);

    // Route to get details of a specific book by ID
    Route::get('/books/{id}', [BookController::class, 'show']);

    // Route to update a specific book by ID
    Route::put('/books/{id}', [BookController::class, 'update']);

    // Route to delete a specific book by ID
    Route::delete('/books/{id}', [BookController::class, 'destroy']);

    // Route to borrow a specific book by ID
    Route::post('/books/{id}/borrow', [BookController::class, 'borrow']);

    // Route to return a borrowed book by ID
    Route::post('/books/{id}/return', [BookController::class, 'return']);
});
