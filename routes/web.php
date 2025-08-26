<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\SuratController;
use App\Http\Controllers\WargaController;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::get('/health-check', function () {
    return response()->json([
        'status' => 'ok',
        'timestamp' => now()->toISOString(),
    ]);
})->name('health-check');

// Welcome page
Route::get('/', function () {
    return Inertia::render('welcome');
})->name('home');

// Dashboard and authenticated routes
Route::middleware(['auth', 'verified'])->group(function () {
    // Dashboard
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    
    // Warga management
    Route::resource('wargas', WargaController::class);
    
    // Surat management  
    Route::resource('surats', SuratController::class);
});

require __DIR__.'/settings.php';
require __DIR__.'/auth.php';