<?php

namespace App\Http\Controllers;

use App\Models\Sensor;
use App\Services\SensorService;
use Illuminate\Http\Request;

class SensorController extends Controller
{
    protected $sensorService;

    public function __construct(SensorService $sensorService)
    {
        $this->sensorService = $sensorService;
    }

    public function storeMeasurement(Request $request, $uuid)
    {
        $this->sensorService->storeMeasurement($uuid, $request->only(['co2', 'time']));
        return response()->json(['message' => 'Measurement stored'], 201);
    }

    public function getStatus($uuid)
    {
        $status = $this->sensorService->getSensorStatus($uuid);
        return response()->json(['status' => $status]);
    }

    public function getMetrics($uuid)
    {
        $metrics = $this->sensorService->getSensorMetrics($uuid);
        return response()->json($metrics);
    }

    public function getAlerts($uuid)
    {
        $alerts = $this->sensorService->getSensorAlerts($uuid);
        return response()->json($alerts);
    }

    public function getSensors()
    {
        $sensors = $this->sensorService->getSensors();
        return response()->json($sensors);
    }
}
