<?php

namespace App\Services;

use App\Repositories\SensorRepository;
use App\Repositories\MeasurementRepository;
use App\Repositories\AlertRepository;
use Illuminate\Support\Facades\DB;

class SensorService
{
    protected $sensorRepository;
    protected $measurementRepository;
    protected $alertRepository;

    public function __construct(
        SensorRepository $sensorRepository,
        MeasurementRepository $measurementRepository,
        AlertRepository $alertRepository
    ) {
        $this->sensorRepository = $sensorRepository;
        $this->measurementRepository = $measurementRepository;
        $this->alertRepository = $alertRepository;
    }

    public function storeMeasurement($uuid, $data)
    {
        return DB::transaction(function () use ($uuid, $data) {
            $sensor = $this->sensorRepository->findOrCreate($uuid);
            $measurement = $this->measurementRepository->create($sensor, $data);
            $this->updateSensorStatus($sensor);
            return $measurement;
        });
    }

    public function getSensorStatus($uuid)
    {
        $sensor = $this->sensorRepository->findByUuid($uuid);
        return $sensor->status;
    }

    public function getSensorMetrics($uuid)
    {
        $sensor = $this->sensorRepository->findByUuid($uuid);
        return $this->measurementRepository->getMetrics($sensor);
    }

    public function getSensorAlerts($uuid)
    {
        $sensor = $this->sensorRepository->findByUuid($uuid);
        return $this->alertRepository->getAlerts($sensor);
    }

    protected function updateSensorStatus($sensor)
    {
        $lastThreeMeasurements = $this->measurementRepository->getLastThreeMeasurements($sensor);

        if (count($lastThreeMeasurements) < 3) {
            return;
        }

        if (min($lastThreeMeasurements) > 2000) {
            if ($sensor->status !== 'ALERT') {
                $this->sensorRepository->updateStatus($sensor, 'ALERT');
                $this->alertRepository->create($sensor, $lastThreeMeasurements);
            }
        } elseif (max($lastThreeMeasurements) > 2000) {
            $this->sensorRepository->updateStatus($sensor, 'WARN');
        } elseif ($sensor->status === 'ALERT' && max($lastThreeMeasurements) <= 2000) {
            $this->sensorRepository->updateStatus($sensor, 'OK');
            $this->alertRepository->closeLastAlert($sensor);
        }
    }

    public function getSensors()
    {
        return $this->sensorRepository->all();
    }
}
