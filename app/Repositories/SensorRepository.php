<?php

namespace App\Repositories;

use App\Models\Sensor;

class SensorRepository
{
    public function findOrCreate($uuid)
    {
        return Sensor::firstOrCreate(['uuid' => $uuid]);
    }

    public function findByUuid($uuid)
    {
        return Sensor::where('uuid', $uuid)->firstOrFail();
    }

    public function updateStatus(Sensor $sensor, $status)
    {
        $sensor->status = $status;
        $sensor->save();
    }

    public function all()
    {
        return Sensor::all();
    }
}
