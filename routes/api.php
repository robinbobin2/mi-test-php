<?php

use App\Http\Controllers\SensorController;
use Illuminate\Support\Facades\Route;

Route::prefix('v1')->group(function () {
    Route::post('/sensors/{uuid}/measurements', [SensorController::class, 'storeMeasurement']);
    Route::get('/sensors/{uuid}', [SensorController::class, 'getStatus']);
    Route::get('/sensors/{uuid}/metrics', [SensorController::class, 'getMetrics']);
    Route::get('/sensors/{uuid}/alerts', [SensorController::class, 'getAlerts']);
    Route::get('/sensors', [SensorController::class, 'getSensors']);
});
