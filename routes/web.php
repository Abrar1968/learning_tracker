<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    
    // Roadmaps
    Route::get('/roadmaps', function () {
        return view('placeholder');
    })->name('roadmaps.index');
    
    // Resources
    Route::get('/resources', function () {
        return view('placeholder');
    })->name('resources.index');
    
    // Certificates
    Route::get('/certificates', function () {
        return view('placeholder');
    })->name('certificates.index');
});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
