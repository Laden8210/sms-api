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
use Barryvdh\DomPDF\Facade\Pdf;

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

        // Generate a random password for the user
        $generatedPassword = Str::random(8);

        $user = UserFiend::firstOrCreate(
            ['contact_number' => $request->contact_number],
            [
                'name' => $request->name,
                'password' => Hash::make($generatedPassword),
                'user_type' => 2,
            ]
        );

        // Create the order
        $order = Order::create([
            'user_id' => $user->id,
            'jersey_name' => $request->jersey_name,
            'jersey_number' => $request->jersey_number,
            'size' => $request->size,
            'remarks' => $request->remarks,
            'order_number' => Str::uuid(),

        ]);


        $message = "Welcome, {$user->name}! Your journey begins here, just like a Solo Leveling guild member. Your account has been created, and your password is: {$generatedPassword}. Your order #{$order->order_number} has been placed successfully. Gear up and rise to the top! Thank you for choosing FIEND!";
        SMS::create([
            'phone_number' => $request->contact_number,
            'message' => $message,
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Order created successfully! An SMS with the details has been sent.',
            'order' => $order,
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


        $message = "Greetings, Guild Member! Your order #{$order->id} has been updated. Jersey: {$order->jersey_name}, Size: {$order->size}, Number: {$order->jersey_number}. Continue your quest with FIEND!";
        SMS::create([
            'phone_number' => $order->user->contact_number,
            'message' => $message,
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Order updated successfully, and SMS notification sent!',
        ]);
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

        // Send SMS notification for payment submission
        $order = Order::findOrFail($request->order_id);


        $message = "Your payment for Order #{$order->id} has been received. Reference: {$request->reference_number}. Thank you for powering up with FIEND!";
        SMS::create([
            'phone_number' => $order->user->contact_number,
            'message' => $message,
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Payment submitted successfully, and SMS notification sent!',
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'jersey_name' => 'required|string|max:255',
            'size' => 'required|string',
            'jersey_number' => 'required|min:1',
            'remarks' => 'nullable|string|max:500',
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


        $current_user = UserFiend::where('id', $user->id)->first();

        if ($current_user) {
            $message = "Thank you, {$current_user->name}! Your new order #{$order->id} has been created. Jersey: {$order->jersey_name}, Size: {$order->size}. FIEND is honored to assist your guild!";
            SMS::create([
                'phone_number' => $current_user->contact_number,
                'message' => $message,
            ]);
        }


        return response()->json([
            'success' => true,
            'message' => 'Order created successfully, and SMS notification sent!',
            'order' => $order,
        ]);
    }
    public function downloadAllOrders()
    {
        $orders = Order::with('payment')->get();

        $pdf = Pdf::loadView('all-orders-pdf', compact('orders'));

        return $pdf->download("All_Orders.pdf");
    }

    public function destroy($id)
    {
        $order = Order::findOrFail($id);

        // Check and delete associated payment
        if ($order->payment) {
            $order->payment->delete();
        }


        $user = Auth::user();
        $current_user = UserFiend::where('id', $user->id)->first();

        if ($current_user) {

            $message = "Hello, {$current_user->name}. Your order #{$order->id} for Jersey: {$order->jersey_name}, Size: {$order->size}, has been canceled. Thank you for trusting FIEND. Feel free to place a new order anytime!";
            SMS::create([
                'phone_number' => $current_user->contact_number,
                'message' => $message,
            ]);
        }

        // Delete the order
        $order->delete();

        return response()->json([
            'success' => true,
            'message' => 'Order deleted successfully.',
        ]);
    }

}
