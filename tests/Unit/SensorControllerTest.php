<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Models\Sensor;
use App\Services\SensorService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Mockery;

class SensorControllerTest extends TestCase
{
    use RefreshDatabase;

    protected $sensorService;
    protected $uuid;

    protected function setUp(): void
    {
        parent::setUp();
        $this->sensorService = Mockery::mock(SensorService::class);
        $this->app->instance(SensorService::class, $this->sensorService);

        $sensor = Sensor::factory()->create();
        $this->uuid = $sensor->uuid;
    }

    public function testStoreMeasurement()
    {
        $this->sensorService->shouldReceive('storeMeasurement')->once()->andReturn(true);

        $response = $this->postJson("/api/v1/sensors/{$this->uuid}/measurements", [
            'co2' => 1000,
            'time' => '2024-10-20T12:00:00+00:00'
        ]);

        $response->assertStatus(201);
    }
    public function testAlertChangeStatus()
    {
        $this->sensorService->shouldReceive('storeMeasurement')->times(3)->andReturn(true);
        $this->sensorService->shouldReceive('getSensorStatus')->once()->andReturn('ALERT');

        for ($i = 0; $i < 3; $i++) {
            $response = $this->postJson("/api/v1/sensors/{$this->uuid}/measurements", [
                'co2' => 2500,
                'time' => now()->addMinutes($i)->toIso8601String()
            ]);
            $response->assertStatus(201);
        }

        $statusResponse = $this->getJson("/api/v1/sensors/{$this->uuid}");

        $statusResponse->assertStatus(200)
            ->assertJson(['status' => 'ALERT']);
    }

    public function testGetStatus()
    {
        $this->sensorService->shouldReceive('getSensorStatus')->once()->andReturn('OK');

        $response = $this->getJson("/api/v1/sensors/{$this->uuid}");

        $response->assertStatus(200)
            ->assertJson(['status' => 'OK']);
    }
}
