<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Measurement extends Model
{
    protected $fillable = ['co2', 'time'];

    protected $casts = [
        'time' => 'datetime',
    ];

    public function sensor()
    {
        return $this->belongsTo(Sensor::class);
    }
}
