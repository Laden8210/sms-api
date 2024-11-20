<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\UserFiend;
use App\Models\Order;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use App\Models\SMS;
use App\Models\Payment;
use Illuminate\Support\Facades\Auth;

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

    public function updateOrder(Request $request)
    {
        $request->validate([
            'order_id' => 'required|exists:orders,id',
            'jersey_name' => 'required|string|max:255',
            'size' => 'required|string',
            'jersey_number' => 'required|integer|min:1',

        ]);

        $order = Order::findOrFail($request->order_id);
        $order->jersey_name = $request->jersey_name;
        $order->size = $request->size;
        $order->jersey_number = $request->jersey_number;
        $order->save();

        return response()->json(['success' => true, 'message' => 'Order updated successfully.']);
    }

    public function submitPayment(Request $request)
    {
        $request->validate([
            'order_id' => 'required|exists:orders,id',
            'reference_number' => 'required|string|max:255',
            'payment_proof' => 'required|file|mimes:jpg,jpeg,png',
        ]);

        $paymentProofPath = $request->file('payment_proof')->store('payments', 'public');

        Payment::create([
            'order_id' => $request->order_id,
            'reference_number' => $request->reference_number,
            'payment_proof' => $paymentProofPath,
        ]);

        return response()->json(['success' => true, 'message' => 'Payment submitted successfully.']);
    }

    public function store(Request $request)
    {
        $request->validate([
            'jersey_name' => 'required|string|max:255',
            'size' => 'required|string',
            'jersey_number' => 'required|integer|min:1',
            'remarks' => 'nullable|string|max:500',
            'order_number' => Str::uuid(),

        ]);

        $user = Auth::user();


        $order = Order::create([
            'user_id' => $user->id,
            'jersey_name' => $request->jersey_name,
            'size' => $request->size,
            'jersey_number' => $request->jersey_number,
            'remarks' => $request->remarks,
            'order_number' => Str::uuid(),
        ]);


        return response()->json([
            'success' => true,
            'message' => 'Order created successfully!',
            'order' => $order,
        ]);
    }
}
