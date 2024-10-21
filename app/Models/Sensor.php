<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Sensor extends Model
{
    use HasFactory;

    protected $fillable = ['uuid', 'status'];

    public function measurements()
    {
        return $this->hasMany(Measurement::class);
    }

    public function alerts()
    {
        return $this->hasMany(Alert::class);
    }
}
