<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Models\TienIch;
use App\Models\LoaiTienIch;

class TienIchController extends AdminBaseController
{
    public function index()
    {
        $tienichs = TienIch::with(['loaiTienIch'])
            ->withCount('xes')
            ->orderBy('Ma_TI', 'desc')
            ->paginate(10);

        $loaiTienIches = LoaiTienIch::withCount('tienIches')->get();

        return view('admin.tien_ich.index', compact('tienichs', 'loaiTienIches'));
    }

    public function create()
    {
        $loaiTienIches = LoaiTienIch::all();
        return view('admin.tien_ich.create', compact('loaiTienIches'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'Ten_TI' => 'required|unique:tien_iches,Ten_TI',
            'Ma_LTI' => 'required' 
        ]);

        TienIch::create($request->all());

        return redirect()->route('tien-ich.index')->with('success', 'Thêm tiện ích thành công!');
    }

    public function show($id)
    {
        $tienich = TienIch::withCount('xes')->findOrFail($id);
        $cars = $tienich->xes()->with('chuXe')->paginate(10);

        return view('admin.tien_ich.show', compact('tienich', 'cars'));
    }

    public function edit($id)
    {
        $tienich = TienIch::findOrFail($id);
        $loaiTienIches = LoaiTienIch::all();
        return view('admin.tien_ich.edit', compact('tienich', 'loaiTienIches'));
    }

    public function update(Request $request, $id)
    {
        $tienich = TienIch::findOrFail($id);
        $request->validate([
            'Ten_TI' => 'required|unique:tien_iches,Ten_TI,' . $id . ',Ma_TI',
            'Ma_LTI' => 'required'
        ]);

        $tienich->update($request->all());

        return redirect()->route('tien-ich.index')->with('success', 'Cập nhật thành công!');
    }

    public function destroy($id)
    {
        $tienich = TienIch::withCount('xes')->findOrFail($id);

        if ($tienich->xes_count > 0) {
            return redirect()->back()->with('error', 'Không thể xóa! Đang có xe sử dụng tiện ích này.');
        }

        $tienich->delete();
        return redirect()->route('tien-ich.index')->with('success', 'Đã xóa tiện ích!');
    }
}
