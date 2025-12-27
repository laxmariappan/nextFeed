<?php

use App\Http\Controllers\FeedingLogController;
use App\Http\Controllers\SettingsController;
use App\Http\Controllers\StatsController;
use Illuminate\Support\Facades\Route;

Route::get('/', [FeedingLogController::class, 'index'])->name('feeding-logs.index');
Route::post('/feeding-logs', [FeedingLogController::class, 'store'])->name('feeding-logs.store');
Route::put('/feeding-logs/{feedingLog}', [FeedingLogController::class, 'update'])->name('feeding-logs.update');
Route::delete('/feeding-logs/{feedingLog}', [FeedingLogController::class, 'destroy'])->name('feeding-logs.destroy');
Route::get('/export', [FeedingLogController::class, 'export'])->name('feeding-logs.export');

Route::get('/stats', [StatsController::class, 'index'])->name('stats.index');

Route::get('/settings', [SettingsController::class, 'index'])->name('settings.index');
Route::post('/settings', [SettingsController::class, 'update'])->name('settings.update');

Route::get('/health', function () {
    try {
        $dbStatus = 'disconnected';
        $dbError = null;

        try {
            \DB::connection()->getPdo();
            $dbStatus = 'connected';
        } catch (\Exception $e) {
            $dbError = $e->getMessage();
        }

        return response()->json([
            'status' => 'ok',
            'timestamp' => now()->toIso8601String(),
            'database' => [
                'status' => $dbStatus,
                'error' => $dbError,
                'config' => [
                    'connection' => config('database.default'),
                    'host' => config('database.connections.mysql.host'),
                    'port' => config('database.connections.mysql.port'),
                    'database' => config('database.connections.mysql.database'),
                    'username' => config('database.connections.mysql.username'),
                ]
            ],
            'env' => [
                'app_env' => config('app.env'),
                'app_debug' => config('app.debug'),
                'app_key_set' => !empty(config('app.key')),
            ]
        ]);
    } catch (\Exception $e) {
        return response()->json([
            'status' => 'error',
            'message' => $e->getMessage(),
            'trace' => $e->getTraceAsString(),
        ], 500);
    }
});
