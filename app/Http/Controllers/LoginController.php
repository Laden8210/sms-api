<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\UserFiend;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class LoginController extends Controller
{
    public function login(Request $request)
    {
        $request->validate([
            'phone' => [
                'required',
                'string',
                'regex:/^(09|\+639)[0-9]{9}$/', // Corrected regex with valid delimiters
            ],
            'password' => 'required|string|min:6',
        ]);

        $user = UserFiend::where('contact_number', $request->phone)->first();

        if ($user && $request->password == $user->password) {
            // Login successful
            Auth::login($user);

            return response()->json([
                'success' => true,
                'message' => 'Login successful!',
            ]);
        }

        return response()->json([
            'success' => false,
            'message' => 'Invalid phone number or password.',
        ]);
    }
}
