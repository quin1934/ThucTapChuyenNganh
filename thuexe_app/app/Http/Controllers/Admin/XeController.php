<?php

namespace App\Http\Controllers\Admin;

use App\Models\Xe;
use App\Models\PhanLoaiXe; 
use App\Models\ChuXe;      
use App\Models\TienIch;   
use App\Models\DanhMucThongSo; 
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage; 

class XeController extends AdminBaseController
{
    public function index()
    {
        $cars = Xe::with(['chuXe', 'phanLoaiXe'])
            ->orderBy('created_at', 'desc')
            ->paginate(10);
        return view('admin.xe.index', compact('cars'));
    }

    public function create()
    {
        $loaiXes = PhanLoaiXe::all();
        $chuXes = ChuXe::all();
        $tienIches = TienIch::all();
        $dsNhienLieu = DanhMucThongSo::nhienLieu()->get();
        $dsHopSo = DanhMucThongSo::hopSo()->get();
        return view('admin.xe.create', compact('loaiXes', 'chuXes', 'tienIches', 'dsNhienLieu', 'dsHopSo'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'BienSo' => 'required|unique:xes,BienSo',
            'Ten_Xe' => 'required',
            'GiaThue' => 'required|numeric|min:0',
            'Ma_PLXe' => 'required',
            'Ma_CX' => 'required',
            'HinhAnh' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'LoaiHopSo' => 'required',
            'LoaiNhienLieu' => 'required',
        ]);

        $data = $request->all();
        $data['TrangThai_Xe'] = 'SanSang'; 
        if ($request->hasFile('HinhAnh')) {
            $file = $request->file('HinhAnh');
            $fileName = time() . '_' . $file->getClientOriginalName();
            $path = $file->storeAs('xe_images', $fileName, 'public');
            $data['HinhAnh'] = $path;
        }

        $xe = Xe::create($data);

        $xe->thongSo()->create([
            'Ma_LHS' => $request->LoaiHopSo,      
            'Ma_LNL' => $request->LoaiNhienLieu,  
            'MucTieuThu' => $request->MucTieuThu,
            'Cong_Xuat' => $request->Cong_Xuat,
        ]);
        if ($request->has('tien_ich')) {
            $xe->tienIches()->attach($request->tien_ich);
        }

        return redirect()->route('xe.index')->with('success', 'Thêm xe và ảnh thành công!');
    }

    public function edit(Xe $xe)
    {
        $loaiXes = PhanLoaiXe::all();
        $chuXes = ChuXe::all();
        $tienIches = TienIch::all();

        $dsNhienLieu = DanhMucThongSo::nhienLieu()->get();
        $dsHopSo = DanhMucThongSo::hopSo()->get();

        $xe->load('thongSo', 'tienIches');

        return view('admin.xe.edit', compact('xe', 'loaiXes', 'chuXes', 'tienIches', 'dsNhienLieu', 'dsHopSo'));
    }
    public function update(Request $request, Xe $xe)
    {
        if ($request->input('_mode') === 'status') {
            $request->validate([
                'status' => ['required', 'in:SanSang,DaTuChoi,BiCam,ChoDuyet,TamAn,DangThue,BaoTri'],
            ]);

            $xe->TrangThai_Xe = $request->input('status');
            $xe->save();

            return redirect()->back()->with('success', 'Đã cập nhật trạng thái xe!');
        }

        $request->validate([
            'BienSo' => 'required|unique:xes,BienSo,' . $xe->Ma_Xe . ',Ma_Xe',
            'Ten_Xe' => 'required',
            'GiaThue' => 'required|numeric|min:0',
            'HinhAnh' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $data = $request->all();

        if ($request->hasFile('HinhAnh')) {
            if ($xe->HinhAnh && Storage::disk('public')->exists($xe->HinhAnh)) {
                Storage::disk('public')->delete($xe->HinhAnh);
            }

            $file = $request->file('HinhAnh');
            $fileName = time() . '_' . $file->getClientOriginalName();
            $path = $file->storeAs('xe_images', $fileName, 'public');
            $data['HinhAnh'] = $path;
        }
       
        $xe->update($data);
        $xe->thongSo()->updateOrCreate(
            ['Ma_Xe' => $xe->Ma_Xe],
            [
                'Ma_LHS' => $request->LoaiHopSo,
                'Ma_LNL' => $request->LoaiNhienLieu,
                'MucTieuThu' => $request->MucTieuThu,
                'Cong_Xuat' => $request->Cong_Xuat,
            ]
        );

        if ($request->has('tien_ich')) {
            $xe->tienIches()->sync($request->tien_ich);
        } else {
            $xe->tienIches()->detach();
        }

        return redirect()->route('xe.index')->with('success', 'Cập nhật thông tin xe thành công!');
    }

    public function destroy(Xe $xe)
    {
        $xe->delete();
        return redirect()->route('xe.index')->with('success', 'Đã xóa xe!');
    }

    public function show(Xe $xe)
    {
        $xe->load(['chuXe', 'phanLoaiXe', 'thongSo', 'tienIches']);
        return view('admin.xe.show', compact('xe'));
    }
}
