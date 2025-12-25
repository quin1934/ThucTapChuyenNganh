<?php

namespace App\Http\Controllers\Client;

use App\Models\ChuXe;
use App\Models\DanhMucThongSo;
use App\Models\DonThue;
use App\Models\PhanLoaiXe;
use App\Models\TienIch;
use App\Models\Xe;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Storage;

class PartnerCarController extends PartnerBaseController
{
    public function index()
    {
        /** @var ChuXe|null $user */
        $user = Auth::guard('chu_xe')->user();
        if (!$user) {
            return redirect()->route('client.login');
        }

        $xes = $user->xes()->with('phanLoaiXe')->latest('Ma_Xe')->get();

        return view('client.partner.cars', compact('user', 'xes'));
    }

    public function store(Request $request)
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

    public function edit($xe)
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

    public function update(Request $request, $xe)
    {
        $mode = $request->input('_mode');
        if ($mode === 'status') {
            return $this->updateCarStatus($request, $xe);
        }
        if ($mode === 'requestApproval') {
            return $this->requestApproval($request, $xe);
        }

        return $this->updateCar($request, $xe);
    }

    public function destroy(Request $request, $xe)
    {
        /** @var ChuXe|null $user */
        $user = Auth::guard('chu_xe')->user();
        if (!$user) {
            return redirect()->route('client.login');
        }

        $car = Xe::where('Ma_Xe', $xe)->where('Ma_CX', $user->Ma_CX)->firstOrFail();

        if ($car->TrangThai_Xe === 'DangThue') {
            return back()->with('error', 'Xe đang được thuê nên không thể xóa.');
        }

        if (DonThue::where('Ma_Xe', $car->Ma_Xe)->exists()) {
            return back()->with('error', 'Không thể xóa xe vì đã phát sinh đơn thuê.');
        }

        if (!empty($car->HinhAnh) && Storage::disk('public')->exists($car->HinhAnh)) {
            Storage::disk('public')->delete($car->HinhAnh);
        }

        $car->delete();

        return back()->with('success', 'Đã xóa xe.');
    }

    private function requestApproval(Request $request, $xe)
    {
        /** @var ChuXe|null $user */
        $user = Auth::guard('chu_xe')->user();
        if (!$user) {
            return redirect()->route('client.login');
        }

        $car = Xe::where('Ma_Xe', $xe)->where('Ma_CX', $user->Ma_CX)->firstOrFail();

        if ($car->TrangThai_Xe === 'DangThue') {
            return back()->with('error', 'Xe đang được thuê nên không thể thay đổi trạng thái.');
        }

        if ($car->TrangThai_Xe === 'BiCam') {
            return back()->with('error', 'Xe đang bị admin cấm nên không thể gửi duyệt.');
        }

        $request->validate([
            'TrangThai_Xe' => ['required', 'in:ChoDuyet'],
        ]);

        $car->TrangThai_Xe = 'ChoDuyet';
        $car->save();

        return back()->with('success', 'Đã gửi xe về trạng thái chờ admin duyệt.');
    }

    private function updateCarStatus(Request $request, $xe)
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

    private function updateCar(Request $request, $xe)
    {
        /** @var ChuXe|null $user */
        $user = Auth::guard('chu_xe')->user();
        if (!$user) {
            return redirect()->route('client.login');
        }

        $car = Xe::with(['thongSo', 'tienIches'])->where('Ma_Xe', $xe)->where('Ma_CX', $user->Ma_CX)->firstOrFail();

        if ($car->TrangThai_Xe === 'DangThue') {
            return back()->with('error', 'Xe đang được thuê nên không thể chỉnh sửa thông tin.');
        }

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
}
