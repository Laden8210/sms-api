<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\UserFiend;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\SMS;

class LoginController extends Controller
{
    public function login(Request $request)
    {
        $request->validate([
            'phone' => [
                'required',
                'string',
                'regex:/^(09|\+639)[0-9]{9}$/',
            ],
            'password' => 'required|string|min:6',
        ]);

        $user = UserFiend::where('contact_number', $request->phone)->first();

        if ($user && Hash::check($request->password, $user->password)) {
            // Login successful
            Auth::login($user);

            // Send SMS notification for successful login
            $message = "Hello, {$user->name}! You have successfully logged into your FIEND account. Your adventure awaits!";
            SMS::create([
                'phone_number' => $user->contact_number,
                'message' => $message,
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Login successful! A confirmation SMS has been sent.',
            ]);
        }

        return response()->json([
            'success' => false,
            'message' => 'Invalid phone number or password.',
        ]);
    }

}
