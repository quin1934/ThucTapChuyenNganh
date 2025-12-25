<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Models\DonThue;
use App\Models\Xe;
use App\Models\KhachThue;
use Carbon\Carbon;

class DonThueController extends AdminBaseController
{
    public function index()
    {
        $donThues = DonThue::with(['xe', 'khachThue'])->orderBy('created_at', 'desc')->paginate(10);
        return view('admin.don_thue.index', compact('donThues'));
    }

    public function create()
    {
        $khachThues = KhachThue::all();
        $xes = Xe::where('TrangThai_Xe', 'SanSang')->get();

        return view('admin.don_thue.create', compact('khachThues', 'xes'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'Ma_KT' => 'required',
            'Ma_Xe' => 'required',
            'Ngay_Bat_Dau' => 'required|date|after_or_equal:today', 
            'Ngay_Ket_Thuc' => 'required|date|after:Ngay_Bat_Dau',
        ], [
            'Ngay_Bat_Dau.after_or_equal' => 'Ngày bắt đầu không được chọn quá khứ.',
            'Ngay_Ket_Thuc.after' => 'Ngày trả xe phải sau ngày nhận xe.',
        ]);

        $xe = Xe::findOrFail($request->Ma_Xe);

        if (!$xe->GiaThue || $xe->GiaThue <= 0) {
            return redirect()->back()
                ->withInput()
                ->withErrors(['Ma_Xe' => 'Chiếc xe này chưa được cập nhật "Giá thuê". Vui lòng vào Quản lý xe để cập nhật giá tiền trước!']);
        }

        $start = Carbon::parse($request->Ngay_Bat_Dau);
        $end = Carbon::parse($request->Ngay_Ket_Thuc);

        $hours = $end->diffInHours($start);
        $days = ceil($hours / 24);
        if ($days < 1) $days = 1;

        $tongTien = $days * $xe->GiaThue;
        $tienCoc = $tongTien * 0.3; 

        DonThue::create([
            'Ma_KT' => $request->Ma_KT,
            'Ma_Xe' => $request->Ma_Xe,
            'Ngay_Bat_Dau' => $request->Ngay_Bat_Dau,
            'Ngay_Ket_Thuc' => $request->Ngay_Ket_Thuc,
            'Dia_Diem_Nhan' => $request->Dia_Diem_Nhan,
            'Gia_Thue_Ngay' => $xe->GiaThue, 
            'Tong_Tien' => $tongTien,
            'Tien_Coc' => $tienCoc,
            'Trang_Thai' => 'ChoDuyet',
            'Ghi_Chu' => $request->Ghi_Chu
        ]);

        return redirect()->route('don-thue.index')->with('success', 'Tạo đơn thuê mới thành công!');
    }

    public function show($id)
    {
        $donThue = DonThue::with(['xe', 'khachThue'])->findOrFail($id);
        return view('admin.don_thue.show', compact('donThue'));
    }

    public function edit($id)
    {
        $donThue = DonThue::findOrFail($id);
        $khachThues = KhachThue::all();
        $xes = Xe::all();

        return view('admin.don_thue.edit', compact('donThue', 'khachThues', 'xes'));
    }

    public function update(Request $request, $id)
    {
        $donThue = DonThue::findOrFail($id);

        if ($request->has('Trang_Thai')) {
            $newStatus = $request->Trang_Thai;

            if ($newStatus === 'DangHoatDong') {
                $newStatus = 'DangDiChuyen';
            }
            if ($newStatus === 'DaTraXe') {
                $newStatus = 'HoanThanh';
            }

            $allowedStatuses = [
                'ChoDuyet',
                'DaDuyet',
                'DaDatCoc',
                'DangDiChuyen',
                'DaGiaoXe',
                'HoanThanh',
                'DaHuy',
                'QuaHan',
            ];

            if (!in_array($newStatus, $allowedStatuses, true)) {
                return back()->with('error', 'Trạng thái không hợp lệ.');
            }

            if (in_array($newStatus, ['DaDuyet', 'DaDatCoc', 'DangDiChuyen', 'DaGiaoXe'], true)) {
                $donThue->xe->update(['TrangThai_Xe' => 'DangThue']);
            }
            if (in_array($newStatus, ['HoanThanh', 'DaHuy'], true)) {
                $donThue->xe->update(['TrangThai_Xe' => 'SanSang']);
            }

            $donThue->Trang_Thai = $newStatus;
            $donThue->save();
            return back()->with('success', 'Đã cập nhật trạng thái đơn hàng!');
        }

        $request->validate([
            'Ngay_Bat_Dau' => 'required|date',
            'Ngay_Ket_Thuc' => 'required|date|after:Ngay_Bat_Dau',
        ]);

        $xe = Xe::findOrFail($request->Ma_Xe);

        if (!$xe->GiaThue || $xe->GiaThue <= 0) {
            return redirect()->back()
                ->withInput()
                ->withErrors(['Ma_Xe' => 'Xe được chọn chưa có giá thuê. Vui lòng cập nhật giá xe trước.']);
        }

        $start = Carbon::parse($request->Ngay_Bat_Dau);
        $end = Carbon::parse($request->Ngay_Ket_Thuc);
        $days = ceil($end->diffInHours($start) / 24);
        if ($days < 1) $days = 1;

        $tongTien = $days * $xe->GiaThue;
        $tienCoc = $tongTien * 0.3;

        $donThue->update([
            'Ma_KT' => $request->Ma_KT,
            'Ma_Xe' => $request->Ma_Xe,
            'Ngay_Bat_Dau' => $request->Ngay_Bat_Dau,
            'Ngay_Ket_Thuc' => $request->Ngay_Ket_Thuc,
            'Dia_Diem_Nhan' => $request->Dia_Diem_Nhan,
            'Gia_Thue_Ngay' => $xe->GiaThue,
            'Tong_Tien' => $tongTien,
            'Tien_Coc' => $tienCoc,
            'Ghi_Chu' => $request->Ghi_Chu
        ]);

        return redirect()->route('don-thue.index')->with('success', 'Cập nhật thông tin đơn thuê thành công!');
    }

    public function destroy($id)
    {
        $donThue = DonThue::findOrFail($id);

        if (!in_array($donThue->Trang_Thai, ['DaHuy', 'QuaHan', 'ChoDuyet'])) {
            return back()->with('error', 'Chỉ có thể xóa các đơn đã hủy hoặc chưa duyệt!');
        }

        $donThue->delete();
        return back()->with('success', 'Đã xóa đơn thuê.');
    }
}
