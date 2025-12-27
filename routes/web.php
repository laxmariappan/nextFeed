<?php

use App\Http\Controllers\FeedingLogController;
use App\Http\Controllers\SettingsController;
use Illuminate\Support\Facades\Route;

Route::get('/', [FeedingLogController::class, 'index'])->name('feeding-logs.index');
Route::post('/feeding-logs', [FeedingLogController::class, 'store'])->name('feeding-logs.store');
Route::put('/feeding-logs/{feedingLog}', [FeedingLogController::class, 'update'])->name('feeding-logs.update');
Route::delete('/feeding-logs/{feedingLog}', [FeedingLogController::class, 'destroy'])->name('feeding-logs.destroy');
Route::get('/export', [FeedingLogController::class, 'export'])->name('feeding-logs.export');

Route::get('/settings', [SettingsController::class, 'index'])->name('settings.index');
Route::post('/settings', [SettingsController::class, 'update'])->name('settings.update');
