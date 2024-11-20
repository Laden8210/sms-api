<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\UserFiend;
use App\Models\Order;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use App\Models\SMS;

class OrderController extends Controller
{
    public function createOrder(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255|regex:/^[a-zA-Z\s]+$/',
            'contact_number' => [
                'required',
                'string',
                'unique:users_fiend,contact_number',
                'regex:/^(09|\+639)\d{9}$/'
            ],
            'jersey_name' => 'required|string|max:255',
            'jersey_number' => 'required|min:1',
            'size' => 'required|string',
            'remarks' => 'nullable|string',
        ]);

        $user = UserFiend::firstOrCreate(
            ['contact_number' => $request->contact_number],
            [
                'name' => $request->name,
                'password' => Str::random(8),
            ]
        );

        $order = Order::create([
            'user_id' => $user->id,
            'jersey_name' => $request->jersey_name,
            'jersey_number' => $request->jersey_number,
            'size' => $request->size,
            'remarks' => $request->remarks,
            'order_number' => Str::uuid(),
        ]);

        $message = "Thank you, {$user->name}! Your order with number {$order->order_number} has been placed successfully.";
        SMS::create([
            'phone_number' => $request->contact_number,
            'message' => $message,
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Order created successfully!',
        ]);
    }
}
