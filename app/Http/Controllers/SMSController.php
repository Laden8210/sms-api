<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\SMS;

class SMSController extends Controller
{
    public function sendSMS(Request $request)
    {
        $request->validate([
            'phone_number' => 'required',
            'message' => 'required'
        ]);

        $sms = SMS::create([
            'phone_number' => $request->phone_number,
            'message' => $request->message
        ]);

        return response()->json(['message' => 'SMS sent successfully']);
    }

    public function getSMS()
    {
        $sms = SMS::where('status', 'pending')->get();

        return response()->json($sms);
    }

    public function updateStatus(Request $request, $id)
    {
        $sms = SMS::find($id);
        $sms->status = 'sent';
        $sms->save();

        return response()->json(['message' => 'Status updated successfully']);
    }
}
