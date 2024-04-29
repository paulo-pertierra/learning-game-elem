<?php

use App\Http\Controllers\GameController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\VideoController;
use App\Http\Controllers\WorksheetController;
use App\Models\Worksheet;
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

// Route::get('/games', function() {
//     
// })->middleware(['auth', 'verified'])->name('games');

Route::get('/printables', function() {
    if (Auth::user()->role === 'admin')
        return Inertia::render('Admin/Printables');
    else
        return Inertia::render('Student/Printables');
})->middleware(['auth', 'verified'])->name('printables');

Route::post('/worksheets/add', function() {
    
})->name('worksheet.create');

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

Route::prefix('/videos')->group(function() {
    Route::get('/', [VideoController::class, 'index'])->name('videos');
    Route::get('/{id}', [VideoController::class, 'show'])->name('videos.view');

    Route::middleware('role:admin', 'auth')->group(function() {
        Route::post('/', [VideoController::class, 'store'])->name('videos.create');
        Route::post('/{id}', [VideoController::class, 'update'])->name('videos.update'); // PATCH
        Route::delete('/{id}', [VideoController::class, 'destroy'])->name('videos.delete');
    });
});

require __DIR__.'/auth.php';
