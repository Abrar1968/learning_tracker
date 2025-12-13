<?php

use App\Http\Controllers\Api\PreferencesController;
use Illuminate\Support\Facades\Route;

Route::middleware('auth:sanctum')->group(function () {
    Route::get('/preferences', [PreferencesController::class, 'show']);
    Route::patch('/preferences', [PreferencesController::class, 'update']);
});
