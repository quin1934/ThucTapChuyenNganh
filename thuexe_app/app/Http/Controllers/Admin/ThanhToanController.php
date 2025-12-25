<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\ThanhToan;
use App\Models\DonThue;
use Illuminate\Support\Facades\Storage;

class ThanhToanController extends AdminBaseController
{
    public function index()
    {
        $thanhToans = ThanhToan::with(['donThue.khachThue', 'donThue.xe'])
            ->orderBy('created_at', 'desc')
            ->paginate(15);

        return view('admin.thanh_toan.index', compact('thanhToans'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'Ma_DT' => 'required|exists:don_thues,Ma_DT',
            'So_Tien' => 'required|numeric|min:1000',
            'Hinh_Anh_Bill' => 'nullable|image|max:2048' 
        ]);

        $data = $request->all();

        if ($request->hasFile('Hinh_Anh_Bill')) {
            $file = $request->file('Hinh_Anh_Bill');
            $fileName = time() . '_' . $file->getClientOriginalName();
            $path = $file->storeAs('bills', $fileName, 'public');
            $data['Hinh_Anh_Bill'] = $path;
        }

        ThanhToan::create($data);
        $donThue = DonThue::find($request->Ma_DT);

        if ($request->Loai_Thanh_Toan == 'TienCoc' && in_array($donThue->Trang_Thai, ['ChoDuyet', 'DaDuyet'])) {
            $donThue->update(['Trang_Thai' => 'DaDatCoc']);
            return redirect()->back()->with('success', 'Đã thu cọc thành công! Trạng thái đơn đã chuyển sang "Đã Đặt Cọc".');
        }

        return redirect()->back()->with('success', 'Đã lưu giao dịch thanh toán thành công!');
    }

    public function destroy($id)
    {
        $tt = ThanhToan::findOrFail($id);

        if ($tt->Hinh_Anh_Bill && Storage::disk('public')->exists($tt->Hinh_Anh_Bill)) {
            Storage::disk('public')->delete($tt->Hinh_Anh_Bill);
        }

        $tt->delete();
        return redirect()->back()->with('success', 'Đã xóa phiếu thu.');
    }
}
