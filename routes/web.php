<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\BookController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\CategoryController;

Route::get('/', function () {
    return view('welcome');
})->name('home');
Route::get('/register', [RegisterController::class, 'showRegistrationForm'])->name('register');
Route::post('/register', [RegisterController::class, 'register']);
Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [LoginController::class, 'login']);
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');
// Protected Routes for Admin
Route::group(['middleware' => ['auth', 'access-level:Admin,User']], function () {
    Route::get('/dashboard', [AdminController::class, 'index'])->name('admin');
    Route::post('/categories', [CategoryController::class, 'store'])->name('categories.store');
    Route::put('/categories/{id}', [CategoryController::class, 'update'])->name('categories.update');
    Route::delete('/categories/{id}', [CategoryController::class, 'destroy'])->name('categories.destroy');
    Route::post('/books', [BookController::class, 'store'])->name('book.store');
    Route::put('/books/{id}', [BookController::class, 'update'])->name('book.update');
    Route::delete('/books/{book}', [BookController::class, 'destroy'])->name('book.destroy');
    Route::get('/categories', [CategoryController::class, 'index'])->name('categories');
    Route::get('/export-pdf', [BookController::class, 'exportPdf'])->name('export.pdf');
    Route::get('/export-excel', [BookController::class, 'exportExcel'])->name('export.excel');
});
