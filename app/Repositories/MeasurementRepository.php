<?php

namespace App\Repositories;

use App\Models\Measurement;
use App\Models\Sensor;
use Carbon\Carbon;

class MeasurementRepository
{
    public function create(Sensor $sensor, array $data)
    {
        return $sensor->measurements()->create($data);
    }

    public function getLastThreeMeasurements(Sensor $sensor)
    {
        return $sensor->measurements()
            ->latest('time')
            ->take(3)
            ->pluck('co2')
            ->toArray();
    }

    public function getMetrics(Sensor $sensor, $days = 30)
    {
        $thirtyDaysAgo = Carbon::now()->subDays($days);

        return $sensor->measurements()
            ->where('time', '>=', $thirtyDaysAgo)
            ->selectRaw('MAX(co2) as maxLast30Days, AVG(co2) as avgLast30Days')
            ->first();
    }
}
