<?php

namespace App\Http\Controllers\Admin;

use App\Models\PhanLoaiXe;
use Illuminate\Http\Request;

class PhanLoaiXeController extends AdminBaseController
{
    public function index()
    {
        $types = PhanLoaiXe::withCount('xes')->orderBy('Ma_PLXe', 'DESC')->paginate(10);
        return view('admin.phan_loai_xe.index', compact('types'));
    }

    public function create()
    {
        return view('admin.phan_loai_xe.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'Ten_PLXe' => 'required|unique:phan_loai_xes,Ten_PLXe',
            'MoTa_PLXe' => 'nullable',
        ], [
            'Ten_PLXe.required' => 'Tên loại xe không được để trống.',
            'Ten_PLXe.unique' => 'Tên loại xe này đã tồn tại.',
        ]);

        PhanLoaiXe::create($request->all());

        return redirect()->route('phan-loai-xe.index')->with('success', 'Thêm loại xe thành công!');
    }

    public function show(PhanLoaiXe $phanLoaiXe)
    {
        // Thường không cần trang chi tiết cho loại xe, có thể để trống
    }

    public function edit(PhanLoaiXe $phanLoaiXe)
    {
        return view('admin.phan_loai_xe.edit', compact('phanLoaiXe'));
    }

    public function update(Request $request, PhanLoaiXe $phanLoaiXe)
    {
        $request->validate([
            'Ten_PLXe' => 'required|unique:phan_loai_xes,Ten_PLXe,' . $phanLoaiXe->Ma_PLXe . ',Ma_PLXe',
            'MoTa_PLXe' => 'nullable',
        ]);

        $phanLoaiXe->update($request->all());

        return redirect()->route('phan-loai-xe.index')->with('success', 'Cập nhật thành công!');
    }

    public function destroy(PhanLoaiXe $phanLoaiXe)
    {
        if ($phanLoaiXe->xes()->count() > 0) {
            return redirect()->route('phan-loai-xe.index')
                ->with('error', 'Không thể xóa! Đang có xe thuộc loại này.');
        }

        $phanLoaiXe->delete();

        return redirect()->route('phan-loai-xe.index')->with('success', 'Đã xóa loại xe!');
    }
}
