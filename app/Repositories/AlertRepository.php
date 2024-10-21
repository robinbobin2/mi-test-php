<?php

namespace App\Repositories;

use App\Models\Alert;
use App\Models\Sensor;
use Carbon\Carbon;

class AlertRepository
{
    public function create(Sensor $sensor, array $measurements)
    {
        return $sensor->alerts()->create([
            'start_time' => Carbon::now(),
            'measurement1' => $measurements[2],
            'measurement2' => $measurements[1],
            'measurement3' => $measurements[0],
        ]);
    }

    public function closeLastAlert(Sensor $sensor)
    {
        $lastAlert = $sensor->alerts()->whereNull('end_time')->latest()->first();
        if ($lastAlert) {
            $lastAlert->end_time = Carbon::now();
            $lastAlert->save();
        }
    }

    public function getAlerts(Sensor $sensor)
    {
        return $sensor->alerts()->orderBy('start_time', 'desc')->get();
    }
}
