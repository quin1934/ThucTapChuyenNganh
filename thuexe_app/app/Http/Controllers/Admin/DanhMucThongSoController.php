<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\DanhMucThongSo;

class DanhMucThongSoController extends AdminBaseController
{
    public function index(Request $request)
    {
        $type = $request->query('type', 'NhienLieu');

        $query = DanhMucThongSo::where('Loai_DanhMuc', $type);

        if ($type == 'NhienLieu') {
            $query->withCount('xeSuDungNhienLieu');
        } else {
            $query->withCount('xeSuDungHopSo');
        }

        $items = $query->orderBy('Ma_DM', 'desc')->paginate(10);

        return view('admin.danh_muc_thong_so.index', compact('items', 'type'));
    }

    public function create(Request $request)
    {
        $type = $request->query('type', 'NhienLieu');
        return view('admin.danh_muc_thong_so.create', compact('type'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'Ten_DM' => 'required',
            'Loai_DanhMuc' => 'required'
        ]);

        DanhMucThongSo::create($request->all());

        return redirect()->route('danh_muc_thong_so.index', ['type' => $request->Loai_DanhMuc])
            ->with('success', 'Thêm dữ liệu thành công!');
    }

    public function edit($id)
    {
        $item = DanhMucThongSo::findOrFail($id);
        return view('admin.danh_muc_thong_so.edit', compact('item'));
    }

    public function update(Request $request, $id)
    {
        $item = DanhMucThongSo::findOrFail($id);
        $item->update($request->all());

        return redirect()->route('danh_muc_thong_so.index', ['type' => $item->Loai_DanhMuc])
            ->with('success', 'Cập nhật thành công!');
    }

    public function destroy($id)
    {
        $item = DanhMucThongSo::findOrFail($id);
        $type = $item->Loai_DanhMuc;

        $item->delete();

        return redirect()->route('danh_muc_thong_so.index', ['type' => $type])
            ->with('success', 'Đã xóa!');
    }
}
