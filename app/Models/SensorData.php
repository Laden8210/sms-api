<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class SensorData extends Model
{
    use HasFactory;


    protected $table = 'sensor_data';

    protected $fillable = [
        'distX1',
        'distX2',
        'distY1',
        'distY2',
        'moistureAnalog',
        'moistureDigital',
        'maxTemp',
        'relayState',
        'heatmap',
    ];


    protected $casts = [
        'moistureDigital' => 'boolean',
        'relayState' => 'boolean',
        'heatmap' => 'array',
    ];
}
