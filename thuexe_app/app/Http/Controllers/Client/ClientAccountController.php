<?php

namespace App\Http\Controllers\Client;

use App\Models\KhachThue;
use App\Models\DonThue;
use App\Models\ThanhToan;
use App\Models\Xe;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class ClientAccountController extends RenterBaseController
{
    public function profile()
    {
        /** @var KhachThue|null $user */
        $user = Auth::guard('khach')->user();
        if (!$user) {
            return redirect()->route('client.login');
        }
        return view('client.account.profile', compact('user'));
    }

    public function update(Request $request)
    {
        /** @var KhachThue|null $user */
        $user = Auth::guard('khach')->user();
        if (!$user) {
            return redirect()->route('client.login');
        }

        $validated = $request->validate([
            'Ho_Ten' => ['required', 'string', 'max:255'],
            'So_Dien_Thoai' => ['required', 'string', 'max:15', 'unique:khach_thues,So_Dien_Thoai,' . $user->Ma_KT . ',Ma_KT'],
            'Dia_Chi' => ['nullable', 'string', 'max:255'],
            'CCCD' => ['nullable', 'string', 'max:20'],

            'So_GPLX' => ['nullable', 'string', 'max:50'],
            'Hang_Bang_Lai' => ['nullable', 'string', 'max:20'],
            'Ngay_Cap_GPLX' => ['nullable', 'date'],
            'Ngay_Het_Han_GPLX' => ['nullable', 'date', 'after_or_equal:Ngay_Cap_GPLX'],

            'img_gplx_truoc' => ['nullable', 'image', 'mimes:jpeg,png,jpg', 'max:2048'],
            'img_gplx_sau' => ['nullable', 'image', 'mimes:jpeg,png,jpg', 'max:2048'],
        ], [
            'So_Dien_Thoai.unique' => 'Số điện thoại đã được sử dụng.',
            'Ngay_Het_Han_GPLX.after_or_equal' => 'Ngày hết hạn phải lớn hơn hoặc bằng ngày cấp.',
        ]);

        $user->Ho_Ten = $validated['Ho_Ten'];
        $user->So_Dien_Thoai = $validated['So_Dien_Thoai'];
        $user->Dia_Chi = $validated['Dia_Chi'] ?? null;
        $user->CCCD = $validated['CCCD'] ?? null;
        $user->So_GPLX = $validated['So_GPLX'] ?? null;
        $user->Hang_Bang_Lai = $validated['Hang_Bang_Lai'] ?? null;
        $user->Ngay_Cap_GPLX = $validated['Ngay_Cap_GPLX'] ?? null;
        $user->Ngay_Het_Han_GPLX = $validated['Ngay_Het_Han_GPLX'] ?? null;

        if ($request->hasFile('img_gplx_truoc')) {
            if ($user->Anh_Bang_Lai_Truoc && str_contains($user->Anh_Bang_Lai_Truoc, '/')) {
                Storage::disk('public')->delete($user->Anh_Bang_Lai_Truoc);
            }
            $user->Anh_Bang_Lai_Truoc = $request->file('img_gplx_truoc')->store('bang_lai', 'public');
        }

        if ($request->hasFile('img_gplx_sau')) {
            if ($user->Anh_Bang_Lai_Sau && str_contains($user->Anh_Bang_Lai_Sau, '/')) {
                Storage::disk('public')->delete($user->Anh_Bang_Lai_Sau);
            }
            $user->Anh_Bang_Lai_Sau = $request->file('img_gplx_sau')->store('bang_lai', 'public');
        }

        $user->save();

        return back()->with('success', 'Đã lưu thay đổi hồ sơ.');
    }

    public function updateAvatar(Request $request)
    {
        /** @var KhachThue|null $user */
        $user = Auth::guard('khach')->user();
        if (!$user) {
            return redirect()->route('client.login');
        }

        $request->validate([
            'avatar' => ['required', 'image', 'mimes:jpeg,png,jpg,webp', 'max:2048'],
        ]);

        $uploadDir = public_path('uploads/avatars');
        if (!is_dir($uploadDir)) {
            @mkdir($uploadDir, 0755, true);
        }

        $file = $request->file('avatar');
        $filename = time() . '_' . $user->Ma_KT . '.' . $file->extension();
        $file->move($uploadDir, $filename);

        $user->HinhAnh = $filename;
        $user->save();

        return back()->with('success', 'Đã cập nhật ảnh đại diện.');
    }

    public function history()
    {
        /** @var KhachThue|null $user */
        $user = Auth::guard('khach')->user();
        if (!$user) {
            return redirect()->route('client.login');
        }

        $orders = DonThue::with(['xe'])
            ->where('Ma_KT', $user->Ma_KT)
            ->orderByDesc('created_at')
            ->paginate(10);

        return view('client.account.history', compact('orders'));
    }

    public function destroyAccount(Request $request)
    {
        /** @var KhachThue|null $user */
        $user = Auth::guard('khach')->user();
        if (!$user) {
            return redirect()->route('client.login');
        }

        if ($user->donThues()->exists()) {
            return back()->with('error', 'Không thể xóa tài khoản vì bạn đang có/đã có đơn thuê xe.');
        }

        if (!empty($user->HinhAnh)) {
            $avatarPath = public_path('uploads/avatars/' . $user->HinhAnh);
            if (is_file($avatarPath)) {
                @unlink($avatarPath);
            }
        }

        foreach (['Anh_Bang_Lai_Truoc', 'Anh_Bang_Lai_Sau'] as $field) {
            $value = $user->{$field} ?? null;
            if (empty($value)) {
                continue;
            }

            if (str_contains($value, '/')) {
                Storage::disk('public')->delete($value);
            } else {
                $legacyPath = public_path('uploads/gplx/' . $value);
                if (is_file($legacyPath)) {
                    @unlink($legacyPath);
                }
            }
        }

        try {
            $user->delete();
        } catch (\Throwable $e) {
            return back()->with('error', 'Không thể xóa tài khoản. Vui lòng liên hệ quản trị viên.');
        }

        Auth::guard('khach')->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('home')->with('success', 'Tài khoản đã được xóa.');
    }

    public function payDeposit(Request $request, $order)
    {
        /** @var KhachThue|null $user */
        $user = Auth::guard('khach')->user();
        if (!$user) {
            return redirect()->route('client.login');
        }

        $donThue = DonThue::with(['xe'])->findOrFail($order);

        if ($donThue->Ma_KT != $user->Ma_KT) {
            abort(403);
        }

        if ($donThue->Trang_Thai !== 'DaDuyet') {
            return back()->with('error', 'Đơn thuê chưa ở trạng thái yêu cầu đặt cọc.');
        }

        $alreadyPaidDeposit = ThanhToan::where('Ma_DT', $donThue->Ma_DT)
            ->where('Loai_Thanh_Toan', 'TienCoc')
            ->exists();

        if ($alreadyPaidDeposit) {
            $donThue->Trang_Thai = 'DaDatCoc';
            $donThue->save();
            return redirect()->route('client.history')->with('success', 'Đơn đã được đặt cọc trước đó.');
        }

        $tienCoc = (int) round((float) ($donThue->Tien_Coc ?? 0));
        if ($tienCoc <= 0) {
            return back()->with('error', 'Đơn thuê chưa có số tiền cọc hợp lệ.');
        }

        DB::transaction(function () use ($donThue, $tienCoc) {
            ThanhToan::create([
                'Ma_DT' => $donThue->Ma_DT,
                'So_Tien' => $tienCoc,
                'Ngay_Thanh_Toan' => Carbon::now(),
                'Phuong_Thuc' => 'ChuyenKhoan',
                'Loai_Thanh_Toan' => 'TienCoc',
                'TrangThai_TT' => 'DaThanhToan',
                'Ghi_Chu' => 'Khách thuê đặt cọc',
            ]);

            $donThue->Trang_Thai = 'DaDatCoc';
            $donThue->save();
        });

        return redirect()->route('client.history')->with('success', 'Đặt cọc thành công.');
    }

    public function depositPage(Request $request, $order)
    {
        /** @var KhachThue|null $user */
        $user = Auth::guard('khach')->user();
        if (!$user) {
            return redirect()->route('client.login');
        }

        $donThue = DonThue::with(['xe', 'xe.chuXe'])->findOrFail($order);
        if ($donThue->Ma_KT != $user->Ma_KT) {
            abort(403);
        }

        if ($donThue->Trang_Thai !== 'DaDuyet') {
            return redirect()->route('client.history')->with('error', 'Đơn thuê chưa sẵn sàng để đặt cọc.');
        }

        $tienCoc = (int) round((float) ($donThue->Tien_Coc ?? 0));
        if ($tienCoc <= 0) {
            return redirect()->route('client.history')->with('error', 'Đơn thuê chưa có số tiền cọc hợp lệ.');
        }

        return view('client.account.deposit', compact('user', 'donThue', 'tienCoc'));
    }

    public function confirmReceivedCar(Request $request, $order)
    {
        /** @var KhachThue|null $user */
        $user = Auth::guard('khach')->user();
        if (!$user) {
            return redirect()->route('client.login');
        }

        $donThue = DonThue::with(['xe'])->findOrFail($order);

        if ($donThue->Ma_KT != $user->Ma_KT) {
            abort(403);
        }

        if ($donThue->Trang_Thai !== 'DaDatCoc') {
            return back()->with('error', 'Chỉ có thể nhận xe sau khi đã đặt cọc.');
        }

        $donThue->Trang_Thai = 'DangDiChuyen';
        $donThue->save();

        return back()->with('success', 'Đã nhận xe. Chúc bạn thượng lộ bình an!');
    }

    public function returnCar(Request $request, $order)
    {
        /** @var KhachThue|null $user */
        $user = Auth::guard('khach')->user();
        if (!$user) {
            return redirect()->route('client.login');
        }

        $donThue = DonThue::with(['xe'])->findOrFail($order);
        if ($donThue->Ma_KT != $user->Ma_KT) {
            abort(403);
        }

        if (!in_array($donThue->Trang_Thai, ['DangDiChuyen', 'DaGiaoXe'], true)) {
            return back()->with('error', 'Chỉ có thể trả xe khi đang di chuyển.');
        }

        DB::transaction(function () use ($donThue) {
            $donThue->Trang_Thai = 'HoanThanh';
            $donThue->save();

            if ($donThue->xe) {
                $donThue->xe->update(['TrangThai_Xe' => 'SanSang']);
            }
        });

        return back()->with('success', 'Đã trả xe. Cảm ơn bạn đã sử dụng dịch vụ!');
    }

    public function bookingDetail(Request $request, $order)
    {
        /** @var KhachThue|null $user */
        $user = Auth::guard('khach')->user();
        if (!$user) {
            return redirect()->route('client.login');
        }

        $donThue = DonThue::with(['xe', 'xe.chuXe', 'khachThue', 'thanhToans'])->findOrFail($order);
        if ($donThue->Ma_KT != $user->Ma_KT) {
            abort(403);
        }

        $viewerRole = 'khach';
        return view('client.account.booking-detail', compact('user', 'donThue', 'viewerRole'));
    }
}
