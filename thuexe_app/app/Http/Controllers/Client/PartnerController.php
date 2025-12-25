<?php

namespace App\Http\Controllers\Client;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\ChuXe;
use App\Models\Xe;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Storage;
use App\Models\DonThue;
use App\Models\LichXe;
use App\Models\PhanLoaiXe;
use App\Models\TienIch;
use App\Models\DanhMucThongSo;
use Carbon\Carbon;

class PartnerController extends PartnerBaseController
{
    public function index()
    {
        /** @var ChuXe|null $user */
        $user = Auth::guard('chu_xe')->user(); 
        if (!$user) {
            return redirect()->route('client.login');
        }
        return view('client.partner.index', compact('user'));
    }

    public function update(Request $request)
    {
        /** @var ChuXe|null $user */
        $user = Auth::guard('chu_xe')->user();
        if (!$user) {
            return redirect()->route('client.login');
        }

        $validated = $request->validate([
            'Ten_CX' => ['required', 'string', 'max:255'],
            'SoDT_CX' => ['required', 'string', 'max:15', 'unique:chu_xes,SoDT_CX,' . $user->Ma_CX . ',Ma_CX'],
            'SoTKNH_CX' => ['nullable', 'string', 'max:255'],
            'DiaChi_CX' => ['nullable', 'string', 'max:255'],
        ], [
            'SoDT_CX.unique' => 'Số điện thoại đã được sử dụng.',
        ]);

        $user->Ten_CX = $validated['Ten_CX'];
        $user->SoDT_CX = $validated['SoDT_CX'];
        $user->SoTKNH_CX = $validated['SoTKNH_CX'] ?? null;
        $user->DiaChi_CX = $validated['DiaChi_CX'] ?? null;
        $user->save();

        return back()->with('success', 'Đã lưu hồ sơ đối tác.');
    }

    public function updateAvatar(Request $request)
    {
        /** @var ChuXe|null $user */
        $user = Auth::guard('chu_xe')->user();
        if (!$user) {
            return redirect()->route('client.login');
        }

        $request->validate([
            'avatar' => ['required', 'image', 'mimes:jpeg,png,jpg,webp', 'max:2048'],
        ]);

        $uploadDir = public_path('uploads/avatars/partners');
        if (!is_dir($uploadDir)) {
            @mkdir($uploadDir, 0755, true);
        }

        if (!empty($user->HinhAnh)) {
            $oldPath = public_path('uploads/avatars/partners/' . $user->HinhAnh);
            if (is_file($oldPath)) {
                @unlink($oldPath);
            }
        }

        $file = $request->file('avatar');
        $filename = time() . '_' . $user->Ma_CX . '.' . $file->extension();
        $file->move($uploadDir, $filename);

        $user->HinhAnh = $filename;
        $user->save();

        return back()->with('success', 'Đã cập nhật ảnh đại diện.');
    }

    public function destroyAccount(Request $request)
    {
        /** @var ChuXe|null $user */
        $user = Auth::guard('chu_xe')->user();
        if (!$user) {
            return redirect()->route('client.login');
        }

        if ($user->xes()->exists()) {
            return back()->with('error', 'Không thể xóa tài khoản vì bạn đang có xe đã đăng.');
        }

        if (!empty($user->HinhAnh)) {
            $avatarPath = public_path('uploads/avatars/partners/' . $user->HinhAnh);
            if (is_file($avatarPath)) {
                @unlink($avatarPath);
            }
        }

        try {
            $user->delete();
        } catch (\Throwable $e) {
            return back()->with('error', 'Không thể xóa tài khoản. Vui lòng liên hệ quản trị viên.');
        }

        Auth::guard('chu_xe')->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('home')->with('success', 'Tài khoản đối tác đã được xóa.');
    }

    public function bookingDetail(Request $request, $order)
    {
        /** @var ChuXe|null $user */
        $user = Auth::guard('chu_xe')->user();
        if (!$user) {
            return redirect()->route('client.login');
        }

        $donThue = DonThue::with(['xe', 'xe.chuXe', 'khachThue', 'thanhToans'])
            ->where('Ma_DT', $order)
            ->whereHas('xe', function ($q) use ($user) {
                $q->where('Ma_CX', $user->Ma_CX);
            })
            ->firstOrFail();

        $viewerRole = 'chu_xe';
        return view('client.account.booking-detail', compact('user', 'donThue', 'viewerRole'));
    }

    public function cars()
    {
        /** @var ChuXe|null $user */
        $user = Auth::guard('chu_xe')->user();
        if (!$user) {
            return redirect()->route('client.login');
        }

        $xes = $user->xes()->with('phanLoaiXe')->latest('Ma_Xe')->get();

        return view('client.partner.cars', compact('user', 'xes'));
    }

    public function storeFromContact(Request $request)
    {
        /** @var ChuXe|null $user */
        $user = Auth::guard('chu_xe')->user();
        if (!$user) {
            return redirect()->route('client.login');
        }

        $validated = $request->validate([
            'Ten_Xe' => ['required', 'string', 'max:255'],
            'BienSo' => ['required', 'string', 'max:50', 'unique:xes,BienSo'],
            'NamSX' => ['required', 'integer', 'min:1900', 'max:' . date('Y')],
            'SoGhe' => ['required', 'integer', 'min:1', 'max:60'],
            'Ma_PLXe' => ['required', 'integer'],
            'GiaThue' => ['required', 'numeric', 'min:0'],
            'MoTa_Xe' => ['nullable', 'string'],
            'HinhAnh' => ['required', 'image', 'mimes:jpeg,png,jpg,gif', 'max:2048'],
            'LoaiHopSo' => ['required'],
            'LoaiNhienLieu' => ['required'],
            'MucTieuThu' => ['nullable', 'string', 'max:255'],
            'Cong_Xuat' => ['nullable', 'string', 'max:255'],
            'tien_ich' => ['nullable', 'array'],
            'tien_ich.*' => ['integer'],
        ]);

        $data = [
            'Ma_CX' => $user->Ma_CX,
            'Ma_PLXe' => $validated['Ma_PLXe'],
            'BienSo' => $validated['BienSo'],
            'Ten_Xe' => $validated['Ten_Xe'],
            'TrangThai_Xe' => 'ChoDuyet',
            'MoTa_Xe' => $validated['MoTa_Xe'] ?? null,
            'SoGhe' => $validated['SoGhe'],
            'NamSX' => $validated['NamSX'],
            'GiaThue' => $validated['GiaThue'],
        ];

        if ($request->hasFile('HinhAnh')) {
            $file = $request->file('HinhAnh');
            $fileName = time() . '_' . $file->getClientOriginalName();
            $path = $file->storeAs('xe_images', $fileName, 'public');
            $data['HinhAnh'] = $path;
        }

        $xe = Xe::create($data);

        $thongSoData = [
            'Cong_Xuat' => $validated['Cong_Xuat'] ?? null,
            'MucTieuThu' => $validated['MucTieuThu'] ?? null,
        ];
        if (Schema::hasColumn('thong_so_ky_thuats', 'Ma_LHS')) {
            $thongSoData['Ma_LHS'] = $validated['LoaiHopSo'];
        } elseif (Schema::hasColumn('thong_so_ky_thuats', 'LoaiHopSo')) {
            $thongSoData['LoaiHopSo'] = $validated['LoaiHopSo'];
        }
        if (Schema::hasColumn('thong_so_ky_thuats', 'Ma_LNL')) {
            $thongSoData['Ma_LNL'] = $validated['LoaiNhienLieu'];
        } elseif (Schema::hasColumn('thong_so_ky_thuats', 'LoaiNhienLieu')) {
            $thongSoData['LoaiNhienLieu'] = $validated['LoaiNhienLieu'];
        }

        $xe->thongSo()->create($thongSoData);

        if (!empty($validated['tien_ich'])) {
            $xe->tienIches()->sync($validated['tien_ich']);
        }

        return redirect()->route('partner.cars')->with('success', 'Đăng ký xe thành công!');
    }

    public function requestApproval(Request $request, $xe)
    {
        /** @var ChuXe|null $user */
        $user = Auth::guard('chu_xe')->user();
        if (!$user) {
            return redirect()->route('client.login');
        }

        $car = Xe::where('Ma_Xe', $xe)->where('Ma_CX', $user->Ma_CX)->firstOrFail();

        if ($car->TrangThai_Xe === 'BiCam') {
            return back()->with('error', 'Xe đang bị admin cấm nên không thể gửi duyệt.');
        }

        $validated = $request->validate([
            'TrangThai_Xe' => ['required', 'in:ChoDuyet'],
        ]);

        $car->TrangThai_Xe = 'ChoDuyet';
        $car->save();

        return back()->with('success', 'Đã gửi xe về trạng thái chờ admin duyệt.');
    }

    public function updateCarStatus(Request $request, $xe)
    {
        /** @var ChuXe|null $user */
        $user = Auth::guard('chu_xe')->user();
        if (!$user) {
            return redirect()->route('client.login');
        }

        $car = Xe::where('Ma_Xe', $xe)->where('Ma_CX', $user->Ma_CX)->firstOrFail();

        if ($car->TrangThai_Xe === 'BiCam') {
            return back()->with('error', 'Xe đang bị admin cấm nên không thể thay đổi trạng thái hiển thị.');
        }

        if (in_array($car->TrangThai_Xe, ['ChoDuyet', 'DaTuChoi'], true)) {
            return back()->with('error', 'Xe chưa được duyệt nên chưa thể thay đổi trạng thái hiển thị.');
        }

        $validated = $request->validate([
            'TrangThai_Xe' => ['required', 'in:SanSang,DangThue,BaoTri,TamAn'],
        ]);

        $car->TrangThai_Xe = $validated['TrangThai_Xe'];
        $car->save();

        return back()->with('success', 'Đã cập nhật trạng thái xe.');
    }

    public function editCar($xe)
    {
        /** @var ChuXe|null $user */
        $user = Auth::guard('chu_xe')->user();
        if (!$user) {
            return redirect()->route('client.login');
        }

        $car = Xe::with(['thongSo', 'tienIches'])->where('Ma_Xe', $xe)->where('Ma_CX', $user->Ma_CX)->firstOrFail();
        $loaiXes = PhanLoaiXe::all();
        $tienIches = TienIch::all();
        $dsNhienLieu = DanhMucThongSo::nhienLieu()->get();
        $dsHopSo = DanhMucThongSo::hopSo()->get();

        return view('client.partner.car-edit', compact('user', 'car', 'loaiXes', 'tienIches', 'dsNhienLieu', 'dsHopSo'));
    }

    public function updateCar(Request $request, $xe)
    {
        /** @var ChuXe|null $user */
        $user = Auth::guard('chu_xe')->user();
        if (!$user) {
            return redirect()->route('client.login');
        }

        $car = Xe::with(['thongSo', 'tienIches'])->where('Ma_Xe', $xe)->where('Ma_CX', $user->Ma_CX)->firstOrFail();

        $validated = $request->validate([
            'Ten_Xe' => ['required', 'string', 'max:255'],
            'BienSo' => ['required', 'string', 'max:50', 'unique:xes,BienSo,' . $car->Ma_Xe . ',Ma_Xe'],
            'NamSX' => ['required', 'integer', 'min:1900', 'max:' . date('Y')],
            'SoGhe' => ['required', 'integer', 'min:1', 'max:60'],
            'Ma_PLXe' => ['required', 'integer'],
            'GiaThue' => ['required', 'numeric', 'min:0'],
            'MoTa_Xe' => ['nullable', 'string'],
            'HinhAnh' => ['nullable', 'image', 'mimes:jpeg,png,jpg,gif', 'max:2048'],
            'LoaiHopSo' => ['required'],
            'LoaiNhienLieu' => ['required'],
            'MucTieuThu' => ['nullable', 'string', 'max:255'],
            'Cong_Xuat' => ['nullable', 'string', 'max:255'],
            'tien_ich' => ['nullable', 'array'],
            'tien_ich.*' => ['integer'],
        ]);

        $data = [
            'Ma_PLXe' => $validated['Ma_PLXe'],
            'BienSo' => $validated['BienSo'],
            'Ten_Xe' => $validated['Ten_Xe'],
            'MoTa_Xe' => $validated['MoTa_Xe'] ?? null,
            'SoGhe' => $validated['SoGhe'],
            'NamSX' => $validated['NamSX'],
            'GiaThue' => $validated['GiaThue'],
        ];

        if ($request->hasFile('HinhAnh')) {
            if (!empty($car->HinhAnh) && Storage::disk('public')->exists($car->HinhAnh)) {
                Storage::disk('public')->delete($car->HinhAnh);
            }

            $file = $request->file('HinhAnh');
            $fileName = time() . '_' . $file->getClientOriginalName();
            $path = $file->storeAs('xe_images', $fileName, 'public');
            $data['HinhAnh'] = $path;
        }

        $car->update($data);

        $thongSoData = [
            'Cong_Xuat' => $validated['Cong_Xuat'] ?? null,
            'MucTieuThu' => $validated['MucTieuThu'] ?? null,
        ];
        if (Schema::hasColumn('thong_so_ky_thuats', 'Ma_LHS')) {
            $thongSoData['Ma_LHS'] = $validated['LoaiHopSo'];
        } elseif (Schema::hasColumn('thong_so_ky_thuats', 'LoaiHopSo')) {
            $thongSoData['LoaiHopSo'] = $validated['LoaiHopSo'];
        }
        if (Schema::hasColumn('thong_so_ky_thuats', 'Ma_LNL')) {
            $thongSoData['Ma_LNL'] = $validated['LoaiNhienLieu'];
        } elseif (Schema::hasColumn('thong_so_ky_thuats', 'LoaiNhienLieu')) {
            $thongSoData['LoaiNhienLieu'] = $validated['LoaiNhienLieu'];
        }

        $car->thongSo()->updateOrCreate(['Ma_Xe' => $car->Ma_Xe], $thongSoData);

        if (isset($validated['tien_ich'])) {
            $car->tienIches()->sync($validated['tien_ich']);
        } else {
            $car->tienIches()->detach();
        }

        return redirect()->route('partner.cars')->with('success', 'Đã cập nhật thông tin xe.');
    }

    public function destroyCar(Request $request, $xe)
    {
        /** @var ChuXe|null $user */
        $user = Auth::guard('chu_xe')->user();
        if (!$user) {
            return redirect()->route('client.login');
        }

        $car = Xe::where('Ma_Xe', $xe)->where('Ma_CX', $user->Ma_CX)->firstOrFail();

        if (DonThue::where('Ma_Xe', $car->Ma_Xe)->exists()) {
            return back()->with('error', 'Không thể xóa xe vì đã phát sinh đơn thuê.');
        }

        if (!empty($car->HinhAnh) && Storage::disk('public')->exists($car->HinhAnh)) {
            Storage::disk('public')->delete($car->HinhAnh);
        }

        $car->delete();

        return back()->with('success', 'Đã xóa xe.');
    }

    public function orders()
    {
        /** @var ChuXe|null $user */
        $user = Auth::guard('chu_xe')->user();
        if (!$user) {
            return redirect()->route('client.login');
        }

        $orders = DonThue::with([
            'xe',
            'khachThue',
        ])
            ->whereHas('xe', function ($query) use ($user) {
                $query->where('Ma_CX', $user->Ma_CX);
            })
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return view('client.partner.orders', compact('orders'));
    }

    public function updateOrderStatus(Request $request, $order)
    {
        /** @var ChuXe|null $user */
        $user = Auth::guard('chu_xe')->user();
        if (!$user) {
            return redirect()->route('client.login');
        }

        $validated = $request->validate([
            'action' => ['required', 'in:approve,reject'],
            'Ly_Do_Huy' => ['nullable', 'string', 'max:500'],
        ]);

        $donThue = DonThue::with(['xe'])->findOrFail($order);

        if (!$donThue->xe || $donThue->xe->Ma_CX != $user->Ma_CX) {
            abort(403);
        }

        if ($donThue->Trang_Thai !== 'ChoDuyet') {
            return back()->with('error', 'Chỉ có thể xử lý đơn ở trạng thái "Chờ duyệt".');
        }

        if ($validated['action'] === 'approve') {
            $donThue->Trang_Thai = 'DaDuyet';
            $donThue->save();

            try {
                $donThue->xe->update(['TrangThai_Xe' => 'DangThue']);
            } catch (\Throwable $e) {
                // ignore
            }

            try {
                $exists = LichXe::where('Ma_Xe', $donThue->Ma_Xe)
                    ->where('Ngay_Bat_Dau', $donThue->Ngay_Bat_Dau)
                    ->where('Ngay_Ket_Thuc', $donThue->Ngay_Ket_Thuc)
                    ->where('Trang_Thai', 'DangThue')
                    ->exists();

                if (!$exists) {
                    LichXe::create([
                        'Ma_Xe' => $donThue->Ma_Xe,
                        'Ngay_Bat_Dau' => $donThue->Ngay_Bat_Dau,
                        'Ngay_Ket_Thuc' => $donThue->Ngay_Ket_Thuc,
                        'Trang_Thai' => 'DangThue',
                        'Ghi_Chu' => 'Đơn thuê #' . $donThue->Ma_DT,
                    ]);
                }
            } catch (\Throwable $e) {
                // ignore
            }

            return back()->with('success', 'Đã duyệt đơn thuê.');
        }

        $donThue->Trang_Thai = 'DaHuy';
        $donThue->Ly_Do_Huy = $validated['Ly_Do_Huy'] ?? null;
        $donThue->save();

        try {
            $donThue->xe->update(['TrangThai_Xe' => 'SanSang']);
        } catch (\Throwable $e) {
            // ignore
        }

        return back()->with('success', 'Đã từ chối đơn thuê.');
    }
}
