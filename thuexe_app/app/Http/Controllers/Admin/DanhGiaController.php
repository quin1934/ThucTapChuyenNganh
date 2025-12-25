<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\DanhGia;
use App\Models\DonThue;

class DanhGiaController extends AdminBaseController
{
    public function index()
    {
        $danhGias = DanhGia::with(['xe', 'khachThue', 'donThue'])
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return view('admin.danh_gia.index', compact('danhGias'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'Ma_DT' => 'required|exists:don_thues,Ma_DT',
            'So_Sao' => 'required|integer|min:1|max:5',
            'Noi_Dung' => 'required|string|max:500',
        ]);

        $donThue = DonThue::findOrFail($request->Ma_DT);

        if ($donThue->Trang_Thai != 'DaTraXe') {
            return back()->with('error', 'Chỉ có thể đánh giá khi đơn hàng đã hoàn tất (Đã trả xe).');
        }

        $exists = DanhGia::where('Ma_DT', $request->Ma_DT)->exists();
        if ($exists) {
            return back()->with('error', 'Đơn hàng này đã được đánh giá rồi!');
        }

        DanhGia::create([
            'Ma_DT' => $donThue->Ma_DT,
            'Ma_Xe' => $donThue->Ma_Xe,
            'Ma_KT' => $donThue->Ma_KT,
            'So_Sao' => $request->So_Sao,
            'Noi_Dung' => $request->Noi_Dung,
            'Trang_Thai' => 'HienThi'
        ]);

        return back()->with('success', 'Cảm ơn! Đánh giá đã được ghi nhận.');
    }

    public function destroy($id)
    {
        $dg = DanhGia::findOrFail($id);
        $dg->delete();
        return back()->with('success', 'Đã xóa đánh giá.');
    }
}
