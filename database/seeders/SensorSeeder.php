<?php

namespace Database\Seeders;

use App\Models\Sensor;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SensorSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        for ($i = 0; $i < 10; $i++) {
            Sensor::create([
                'uuid' => \Illuminate\Support\Str::uuid(),
                'status' => $this->getRandomStatus(),
            ]);
        }
    }

    /**
     * Get a random sensor status.
     *
     * @return string
     */
    private function getRandomStatus()
    {
        $statuses = ['OK', 'WARN', 'ALERT'];
        return $statuses[array_rand($statuses)];
    }
}
