<?php

use App\Http\Controllers\ActivityController;
use App\Http\Controllers\BookmarkController;
use App\Http\Controllers\CertificateController;
use App\Http\Controllers\ChallengeController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\FocusSessionController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ProgressController;
use App\Http\Controllers\ResourceController;
use App\Http\Controllers\ReviewController;
use App\Http\Controllers\RoadmapController;
use App\Http\Controllers\SearchController;
use App\Http\Controllers\TemplateController;
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
    Route::patch('/resources/{resource}/complete', [ResourceController::class, 'complete'])->name('resources.complete');
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

    // Search Route
    Route::get('/search', [SearchController::class, 'index'])->name('search');

    // Topic Reordering Route
    Route::post('/roadmaps/{roadmap}/topics/reorder', [TopicController::class, 'reorder'])
        ->name('topics.reorder');

    // Profile Routes
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Attachment Routes
    Route::delete('/attachments/{attachment}', [App\Http\Controllers\AttachmentController::class, 'destroy'])
        ->name('attachments.destroy');

    // Template Gallery Routes
    Route::get('/templates', [TemplateController::class, 'index'])->name('templates.index');
    Route::get('/templates/{template}', [TemplateController::class, 'show'])->name('templates.show');
    Route::post('/templates/{template}/clone', [TemplateController::class, 'clone'])->name('templates.clone');
    Route::post('/templates/{template}/rate', [TemplateController::class, 'rate'])->name('templates.rate');
    Route::post('/roadmaps/{roadmap}/create-template', [TemplateController::class, 'createFromRoadmap'])
        ->name('templates.createFromRoadmap');

    // Focus Session Routes
    Route::get('/focus', [FocusSessionController::class, 'index'])->name('focus.index');
    Route::post('/focus/start', [FocusSessionController::class, 'start'])->name('focus.start');
    Route::post('/focus/{session}/end', [FocusSessionController::class, 'end'])->name('focus.end');
    Route::get('/focus/status', [FocusSessionController::class, 'status'])->name('focus.status');
    Route::get('/focus/history', [FocusSessionController::class, 'history'])->name('focus.history');
    Route::get('/focus/heatmap', [FocusSessionController::class, 'heatmap'])->name('focus.heatmap');

    // Bookmark Routes
    Route::get('/bookmarks', [BookmarkController::class, 'index'])->name('bookmarks.index');
    Route::post('/bookmarks/topics/{topic}', [BookmarkController::class, 'toggleTopic'])->name('bookmarks.topic');
    Route::post('/bookmarks/resources/{resource}', [BookmarkController::class, 'toggleResource'])->name('bookmarks.resource');
    Route::post('/bookmarks/roadmaps/{roadmap}', [BookmarkController::class, 'toggleRoadmap'])->name('bookmarks.roadmap');
    Route::patch('/bookmarks/{bookmark}', [BookmarkController::class, 'update'])->name('bookmarks.update');
    Route::delete('/bookmarks/{bookmark}', [BookmarkController::class, 'destroy'])->name('bookmarks.destroy');

    // Daily Challenges & Weekly Goals Routes
    Route::get('/challenges', [ChallengeController::class, 'index'])->name('challenges.index');
    Route::get('/challenges/daily', [ChallengeController::class, 'getChallenges'])->name('challenges.daily');
    Route::get('/challenges/weekly', [ChallengeController::class, 'getGoals'])->name('challenges.weekly');
    Route::post('/challenges/refresh', [ChallengeController::class, 'refreshChallenges'])->name('challenges.refresh');

    // Spaced Repetition Review Routes
    Route::get('/reviews', [ReviewController::class, 'index'])->name('reviews.index');
    Route::get('/reviews/{review}', [ReviewController::class, 'show'])->name('reviews.show');
    Route::post('/reviews/{review}/record', [ReviewController::class, 'record'])->name('reviews.record');
    Route::post('/reviews/topics/{topic}', [ReviewController::class, 'addTopic'])->name('reviews.addTopic');
    Route::post('/reviews/resources/{resource}', [ReviewController::class, 'addResource'])->name('reviews.addResource');
    Route::post('/reviews/{review}/suspend', [ReviewController::class, 'suspend'])->name('reviews.suspend');
    Route::post('/reviews/{review}/resume', [ReviewController::class, 'resume'])->name('reviews.resume');
    Route::post('/reviews/{review}/reset', [ReviewController::class, 'reset'])->name('reviews.reset');

    // Roadmap Forking
    Route::post('/roadmaps/{roadmap}/fork', [RoadmapController::class, 'fork'])->name('roadmaps.fork');
});

// Public Certificate Verification Route
Route::get('/verify/{verificationCode}', [CertificateController::class, 'verify'])
    ->name('certificates.verify');

require __DIR__.'/auth.php';
