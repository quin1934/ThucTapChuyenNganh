<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Models\Xe;
use App\Models\DonThue;
use App\Models\KhachThue;
use Carbon\Carbon;

class AdminController extends Controller
{
    public function index()
    {
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        $totalCars = Xe::count();

        $pendingOrders = DonThue::where('Trang_Thai', 'ChoDuyet')->count();

        $currentMonthRevenue = DonThue::whereYear('created_at', Carbon::now()->year)
            ->whereMonth('created_at', Carbon::now()->month)
            ->where('Trang_Thai', '!=', 'DaHuy')
            ->sum('Tong_Tien');

        $totalCustomers = KhachThue::count();

        $recentOrders = DonThue::with(['xe', 'khachThue'])
            ->orderBy('created_at', 'desc')
            ->take(6)
            ->paginate(10);
        return view('admin.dashboard', compact(
            'totalCars',
            'pendingOrders',
            'currentMonthRevenue',
            'totalCustomers',
            'recentOrders'
        ));
    }
}
