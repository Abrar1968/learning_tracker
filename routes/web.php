<?php

use App\Http\Controllers\ActivityController;
use App\Http\Controllers\CertificateController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ProgressController;
use App\Http\Controllers\ResourceController;
use App\Http\Controllers\RoadmapController;
use App\Http\Controllers\TopicController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::middleware(['auth', 'verified'])->group(function () {
    // Dashboard
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // Roadmaps - Full Resource Routes
    Route::resource('roadmaps', RoadmapController::class);

    // Topics - Nested under Roadmaps
    Route::resource('roadmaps.topics', TopicController::class)->except(['index']);

    // Topics - Standalone routes for viewing only (create/edit stay nested)
    Route::get('/topics/{topic}', [TopicController::class, 'show'])->name('topics.show');
    Route::delete('/topics/{topic}', [TopicController::class, 'destroy'])->name('topics.destroy');

    // Resources - Nested under Topics
    Route::resource('topics.resources', ResourceController::class)->except(['index']);

    // Resources - Standalone routes for direct access
    Route::get('/resources/create', [ResourceController::class, 'create'])->name('resources.create');
    Route::post('/resources', [ResourceController::class, 'store'])->name('resources.store');
    Route::get('/resources/{resource}/edit', [ResourceController::class, 'edit'])->name('resources.edit');
    Route::put('/resources/{resource}', [ResourceController::class, 'update'])->name('resources.update');
    Route::delete('/resources/{resource}', [ResourceController::class, 'destroy'])->name('resources.destroy');

    // Progress Routes
    Route::post('/topics/{topic}/progress/start', [ProgressController::class, 'start'])
        ->name('progress.start');
    Route::put('/topics/{topic}/progress', [ProgressController::class, 'update'])
        ->name('progress.update');
    Route::post('/topics/{topic}/progress/time', [ProgressController::class, 'logTime'])
        ->name('progress.logTime');
    Route::post('/topics/{topic}/progress/complete', [ProgressController::class, 'complete'])
        ->name('progress.complete');

    // Certificate Routes
    Route::get('/certificates', [CertificateController::class, 'index'])
        ->name('certificates.index');
    Route::post('/roadmaps/{roadmap}/certificate', [CertificateController::class, 'generate'])
        ->name('certificates.generate');
    Route::get('/certificates/{certificate}', [CertificateController::class, 'show'])
        ->name('certificates.show');

    // Activity Routes
    Route::get('/activities', [ActivityController::class, 'index'])
        ->name('activities.index');

    // Profile Routes
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Attachment Routes
    Route::delete('/attachments/{attachment}', [App\Http\Controllers\AttachmentController::class, 'destroy'])
        ->name('attachments.destroy');
});

// Public Certificate Verification Route
Route::get('/verify/{verificationCode}', [CertificateController::class, 'verify'])
    ->name('certificates.verify');

require __DIR__.'/auth.php';
