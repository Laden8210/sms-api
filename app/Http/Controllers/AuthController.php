<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Order;

class AuthController extends Controller
{

    public function showLoginForm()
    {

        $user = Auth::user();

        if ($user) {

            return redirect()->route('dashboard');
        }
        return view('login');
    }

    // Handle login
    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();
            return redirect()->intended('/dashboard'); // Redirect to the intended page
        }

        return back()->withErrors([
            'email' => 'The provided credentials do not match our records.',
        ]);
    }

    public function dashboard()
    {
        $user = Auth::user();

        $orders = Order::with('payment')
            ->where('user_id', $user->id)
            ->get();

        if ($user->user_type === 2) {
            return redirect()->route('admin');
        }

        return view('dashboard', compact('orders'));
    }


    public function logout()
    {
        return null;
    }

    public function admin()
    {
        // Retrieve all orders with related payments
        $orders = Order::with('payment')->latest()->get();

        // Calculate daily orders for the last 7 days
        $dailyOrders = Order::selectRaw('DATE(created_at) as date, COUNT(*) as count')
            ->groupBy('date')
            ->orderBy('date', 'desc')
            ->limit(7)
            ->get()
            ->pluck('count', 'date')
            ->toArray();

        // Ensure all days are represented
        $startDate = now()->subDays(6);
        $endDate = now();
        $dailyOrderStats = collect();

        for ($date = $startDate; $date <= $endDate; $date->addDay()) {
            $formattedDate = $date->format('Y-m-d');
            $dailyOrderStats->put($formattedDate, $dailyOrders[$formattedDate] ?? 0);
        }

        // Pass data to the view
        return view('admin-dashboard', [
            'orders' => $orders,
            'dailyOrderStats' => $dailyOrderStats,
        ]);
    }
}
