<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\SensorData;

class SensorDataController extends Controller
{
    public function store(Request $request)
    {
        $validated = $request->validate([
            'distX1' => 'required|numeric',
            'distX2' => 'required|numeric',
            'distY1' => 'required|numeric',
            'distY2' => 'required|numeric',
            'moistureAnalog' => 'required|integer',
            'moistureDigital' => 'required|boolean',
            'maxTemp' => 'required|numeric',
            'relayState' => 'required|boolean',
            'heatmap' => 'required|array'
        ]);

        SensorData::create($validated);
        return response()->json(['message' => 'Data saved successfully'], 200);
    }

    public function index()
    {
        return response()->json(SensorData::latest()->first());
    }
}
