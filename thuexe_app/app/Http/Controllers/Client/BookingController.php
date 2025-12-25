<?php

namespace App\Http\Controllers\Client;

use App\Models\DonThue;
use App\Models\Xe;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BookingController extends RenterBaseController
{
    public function create(Request $request, $id)
    {
        $xe = Xe::with(['chuXe', 'phanLoaiXe', 'thongSo.hopSo', 'thongSo.nhienLieu'])->findOrFail($id);

        $ngayNhanRaw = (string) $request->query('ngay_nhan', '');
        $ngayTraRaw = (string) $request->query('ngay_tra', '');
        $ghiChu = (string) $request->query('ghi_chu', '');

        $ngayNhan = null;
        $ngayTra = null;
        try {
            if ($ngayNhanRaw !== '') {
                $ngayNhan = Carbon::parse($ngayNhanRaw);
            }
            if ($ngayTraRaw !== '') {
                $ngayTra = Carbon::parse($ngayTraRaw);
            }
        } catch (\Throwable $e) {
            $ngayNhan = null;
            $ngayTra = null;
        }

        $soNgay = null;
        $tongTien = null;
        $tienCoc = null;

        if ($ngayNhan && $ngayTra && $ngayTra->greaterThan($ngayNhan) && ($xe->GiaThue ?? 0) > 0) {
            $hours = $ngayTra->diffInHours($ngayNhan);
            $days = (int) ceil($hours / 24);
            if ($days < 1) {
                $days = 1;
            }
            $soNgay = $days;
            $tongTien = $days * (float) $xe->GiaThue;
            $tienCoc = $tongTien * 0.3;
        }

        $user = Auth::guard('khach')->user();

        return view('booking', compact('xe', 'user', 'ngayNhan', 'ngayTra', 'ghiChu', 'soNgay', 'tongTien', 'tienCoc'));
    }

    public function store(Request $request, $id)
    {
        $xe = Xe::findOrFail($id);

        $request->validate([
            'Ngay_Bat_Dau' => ['required', 'date', 'after_or_equal:now'],
            'Ngay_Ket_Thuc' => ['required', 'date', 'after:Ngay_Bat_Dau'],
            'Dia_Diem_Nhan' => ['nullable', 'string', 'max:255'],
            'Ghi_Chu' => ['nullable', 'string'],
        ], [
            'Ngay_Bat_Dau.after_or_equal' => 'Ngày nhận xe không được chọn quá khứ.',
            'Ngay_Ket_Thuc.after' => 'Ngày trả xe phải sau ngày nhận xe.',
        ]);

        if (($xe->GiaThue ?? 0) <= 0) {
            return back()->withInput()->withErrors(['Ngay_Bat_Dau' => 'Xe chưa được cập nhật giá thuê.']);
        }

        $start = Carbon::parse($request->Ngay_Bat_Dau);
        $end = Carbon::parse($request->Ngay_Ket_Thuc);

        $hasOverlap = DonThue::where('Ma_Xe', $xe->Ma_Xe)
            ->where('Ngay_Bat_Dau', '<', $end)
            ->where('Ngay_Ket_Thuc', '>', $start)
            ->where('Trang_Thai', '!=', 'DaHuy')
            ->exists();

        if ($hasOverlap) {
            return back()->withInput()->withErrors(['Ngay_Bat_Dau' => 'Xe đã có lịch thuê trong khoảng thời gian này.']);
        }

        $hours = $end->diffInHours($start);
        $days = (int) ceil($hours / 24);
        if ($days < 1) {
            $days = 1;
        }

        $tongTien = $days * (float) $xe->GiaThue;
        $tienCoc = $tongTien * 0.3;

        $user = Auth::guard('khach')->user();
        if (!$user) {
            return redirect()->route('client.login');
        }

        DonThue::create([
            'Ma_KT' => $user->Ma_KT,
            'Ma_Xe' => $xe->Ma_Xe,
            'Ngay_Bat_Dau' => $start,
            'Ngay_Ket_Thuc' => $end,
            'Dia_Diem_Nhan' => $request->Dia_Diem_Nhan,
            'Gia_Thue_Ngay' => $xe->GiaThue,
            'Tong_Tien' => $tongTien,
            'Tien_Coc' => $tienCoc,
            'Trang_Thai' => 'ChoDuyet',
            'Ghi_Chu' => $request->Ghi_Chu,
        ]);

        return redirect()->route('client.history')->with('success', 'Đã gửi yêu cầu đặt xe. Vui lòng chờ duyệt.');
    }
}
