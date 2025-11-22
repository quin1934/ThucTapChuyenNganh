<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Xe;          
use App\Models\ChuXe;       
use App\Models\User;  
use App\Models\KhachThue;      
use App\Models\PhanLoaiXe; 
use App\Models\DonThue;  
use App\Models\DanhGia;  
use App\Models\ThanhToan;
use Carbon\Carbon;

class AdminController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $totalCars = Xe::count();

        $pendingOrders = DonThue::where('TrangThai_Don', 'ChoDuyet')->count();

        $currentMonthRevenue = ThanhToan::where('TrangThai_TT', 'ThanhCong')
                                ->whereMonth('Ngay_TT', Carbon::now()->month)
                                ->whereYear('Ngay_TT', Carbon::now()->year)
                                ->sum('SoTien');

        $totalCustomers = KhachThue::count();
        $recentOrders = DonThue::with(['khachThue', 'xe'])
                        ->orderBy('created_at', 'desc')
                        ->take(5)
                        ->get();

        return view('admin.dashboard', compact(
            'totalCars', 
            'pendingOrders', 
            'currentMonthRevenue', 
            'totalCustomers', 
            'recentOrders'
        ));
    }

}