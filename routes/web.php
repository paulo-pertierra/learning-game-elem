<?php

use App\Http\Controllers\GameController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\VideoController;
use App\Http\Controllers\WorksheetController;
use App\Http\Controllers\PrintableController;
use App\Http\Controllers\UserController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::get('/', function () {
    return Inertia::render('Welcome', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
    ]);
});

Route::get('/dashboard', function () {
    if (Auth::user()->role === 'admin')
        return Inertia::render('Admin/Dashboard');
    else
        return Inertia::render('Student/Dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::get('/games', [GameController::class, 'index'])
    ->middleware(['auth', 'verified'])
    ->name('games');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// Worksheets Routegroup

Route::prefix('/worksheets')->group(function() {
    Route::get('/', [WorksheetController::class, 'index'])->name('worksheets');
    Route::get('/{id}', [WorksheetController::class, 'show'])->name('worksheet.view');
    Route::get('/{id}/download-file', [WorksheetController::class, 'download'])->name('worksheet.download');
    Route::get('/{id}/view', [WorksheetController::class, 'preview'])->name('worksheet.preview');

    Route::middleware('role:admin', 'auth')->group(function() {
        Route::post('/', [WorksheetController::class, 'store'])->name('worksheet.create');
        Route::post('/{id}', [WorksheetController::class, 'update'])->name('worksheet.update'); // PATCH
        Route::delete('/{id}', [WorksheetController::class, 'destroy'])->name('worksheet.delete');
    });
});

// Printables Routegroup

Route::prefix('/printables')->group(function() {
    Route::get('/', [PrintableController::class, 'index'])->name('printables');
    Route::get('/{id}', [PrintableController::class, 'show'])->name('printable.view');
    Route::get('/{id}/download-file', [PrintableController::class, 'download'])->name('printable.download');
    Route::get('/{id}/view', [PrintableController::class, 'preview'])->name('printable.preview');

    Route::middleware('role:admin', 'auth')->group(function() {
        Route::post('/', [PrintableController::class, 'store'])->name('printable.create');
        Route::post('/{id}', [PrintableController::class, 'update'])->name('printable.update'); // PATCH
        Route::delete('/{id}', [PrintableController::class, 'destroy'])->name('printable.delete');
    });
});

// Videos Routegroup

Route::prefix('/videos')->group(function() {
    Route::get('/', [VideoController::class, 'index'])->name('videos');
    Route::get('/{id}', [VideoController::class, 'show'])->name('videos.view');

    Route::middleware('role:admin', 'auth')->group(function() {
        Route::post('/', [VideoController::class, 'store'])->name('videos.create');
        Route::post('/{id}', [VideoController::class, 'update'])->name('videos.update'); // PATCH
        Route::delete('/{id}', [VideoController::class, 'destroy'])->name('videos.delete');
    });
});

// Admin Users Routegroup

Route::prefix('/users')->group(function() {
    Route::get('/',[UserController::class, 'index'])->name('users');
    Route::post('/',[UserController::class, 'store'])->name('users.register');
});

require __DIR__.'/auth.php';
