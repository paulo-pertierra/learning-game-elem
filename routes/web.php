<?php

use App\Http\Controllers\GameController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\VideoController;
use App\Http\Controllers\WorksheetController;
use App\Http\Controllers\PrintableController;
use App\Http\Controllers\UserController;
use App\Models\Game;
use App\Models\Printable;
use App\Models\User;
use App\Models\Video;
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
        'phpVersion' => PHP_VERSION
    ]);
});

Route::get('/product', function () {
    return Inertia::render('Product');
});

Route::get('/about', function () {
    return Inertia::render('About');
});

Route::get('/dashboard', function () {
    if (Auth::user()->role === 'admin')
        return Inertia::render('Admin/Dashboard', [
            'statistics' => [
                "users" => User::count(),
                "worksheets" => Worksheet::count(),
                "games" => Game::count(),
                "videos" => Video::count(),
                "printables" => Printable::count()
            ]
        ]);
    else if (Auth::user()->role === 'teacher')
        return Inertia::render('Teacher/Dashboard', [
            'statistics' => [
                "worksheets" => Worksheet::count(),
                "games" => Game::count(),
                "videos" => Video::count(),
                "printables" => Printable::count(),
            ]
        ]);
    else
        return Inertia::render('Student/Dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// Games Routegroup

Route::prefix('/games')->group(function () {
    Route::get('/', [GameController::class, 'index'])->name('games');
    Route::get('/build', [GameController::class, 'build'])->name('games.build');
    Route::get('/{id}', [GameController::class, 'show'])->name('games.view');
    Route::post('/', [GameController::class, 'store'])->name('games.create');
    Route::get('/{id}/question/{item}', [GameController::class, 'question'])->name('question.view');
    Route::post('/{id}', [GameController::class, 'submit'])->name('games.submit');
});

// Worksheets Routegroup

Route::prefix('/worksheets')->group(function () {
    Route::get('/', [WorksheetController::class, 'index'])->name('worksheets');
    Route::get('/{id}', [WorksheetController::class, 'show'])->name('worksheet.view');
    Route::get('/{id}/download-file', [WorksheetController::class, 'download'])->name('worksheet.download');
    Route::get('/{id}/view', [WorksheetController::class, 'preview'])->name('worksheet.preview');

    Route::middleware('role:admin', 'auth')->group(function () {
        Route::post('/', [WorksheetController::class, 'store'])->name('worksheet.create');
        Route::post('/{id}', [WorksheetController::class, 'update'])->name('worksheet.update'); // PATCH
        Route::delete('/{id}', [WorksheetController::class, 'destroy'])->name('worksheet.delete');
    });
});

// Printables Routegroup

Route::prefix('/printables')->group(function () {
    Route::get('/', [PrintableController::class, 'index'])->name('printables');
    Route::get('/{id}', [PrintableController::class, 'show'])->name('printable.view');
    Route::get('/{id}/download-file', [PrintableController::class, 'download'])->name('printable.download');
    Route::get('/{id}/view', [PrintableController::class, 'preview'])->name('printable.preview');

    Route::middleware('role:admin', 'auth')->group(function () {
        Route::post('/', [PrintableController::class, 'store'])->name('printable.create');
        Route::post('/{id}', [PrintableController::class, 'update'])->name('printable.update'); // PATCH
        Route::delete('/{id}', [PrintableController::class, 'destroy'])->name('printable.delete');
    });
});

// Videos Routegroup

Route::prefix('/videos')->group(function () {
    Route::get('/', [VideoController::class, 'index'])->name('videos');
    Route::get('/{id}', [VideoController::class, 'show'])->name('videos.view');

    Route::middleware('role:admin', 'auth')->group(function () {
        Route::post('/', [VideoController::class, 'store'])->name('videos.create');
        Route::post('/{id}', [VideoController::class, 'update'])->name('videos.update'); // PATCH
        Route::delete('/{id}', [VideoController::class, 'destroy'])->name('videos.delete');
    });
});

// Admin Users Routegroup

Route::prefix('/users')->group(function () {
    Route::get('/', [UserController::class, 'index'])->name('users');
    Route::post('/', [UserController::class, 'store'])->name('users.register');
    Route::delete('/{id}', [UserController::class, 'destroy'])->name('users.delete');
});

require __DIR__ . '/auth.php';
