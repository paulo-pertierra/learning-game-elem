<?php

use App\Http\Controllers\GameController;
use App\Http\Controllers\ProfileController;
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

Route::get('/worksheets', [WorksheetController::class, 'index'])
    ->middleware(['auth', 'verified'])
    ->name('worksheets');

Route::get('/games', [GameController::class, 'index'])
    ->middleware(['auth', 'verified'])
    ->name('games');

// Route::get('/games', function() {
//     
// })->middleware(['auth', 'verified'])->name('games');

Route::get('/videos', function() {
    if (Auth::user()->role === 'admin')
        return Inertia::render('Admin/Videos');
    else
        return Inertia::render('Student/Videos');
})->middleware(['auth', 'verified'])->name('videos');

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

    Route::post('/worksheets', [WorksheetController::class, 'store'])->name('worksheet.create');
    Route::get('/worksheets/{id}', [WorksheetController::class, 'show'])->name('worksheet.view');
    Route::get('/worksheets/{id}/download-file', [WorksheetController::class, 'download'])->name('worksheet.download');
});

require __DIR__.'/auth.php';
