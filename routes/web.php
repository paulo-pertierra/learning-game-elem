<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\WorksheetController;
use App\Models\Worksheet;
use Illuminate\Foundation\Application;
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
    return Inertia::render('Dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::get('/worksheets', function() {
    
    $worksheets = Worksheet::paginate(15);
    
    return Inertia::render('Worksheets', [
        'worksheets' => $worksheets
    ]);

})->middleware(['auth', 'verified'])->name('worksheets');

Route::post('/worksheets/add', function() {
    
})->name('worksheet.create');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::post('/worksheets', [WorksheetController::class, 'store'])->name('worksheet.create');
    Route::get('/worksheets/{id}', function(string $id) {
        $worksheet = Worksheet::findOrFail($id);
        return Inertia::render('Worksheets/ById', [
            'worksheet' => $worksheet
        ]);
    });

    Route::get('/worksheets/{id}/download-file', [WorksheetController::class, 'download']);
});

require __DIR__.'/auth.php';
