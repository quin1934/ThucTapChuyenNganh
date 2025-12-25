<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Models\LoaiTienIch;

class LoaiTienIchController extends AdminBaseController
{
   
    public function store(Request $request)
    {
        $request->validate([
            'Ten_LTI' => 'required|unique:loai_tien_iches,Ten_LTI|max:255',
        ], [
            'Ten_LTI.required' => 'Tên loại không được để trống.',
            'Ten_LTI.unique' => 'Tên loại này đã tồn tại.',
        ]);

        LoaiTienIch::create([
            'Ten_LTI' => $request->Ten_LTI,
            'MoTa_LTI' => $request->MoTa_LTI ?? '' 
        ]);

        return redirect()->back()->with('success', 'Đã thêm nhóm tiện ích mới!');
    }

    
    public function update(Request $request, $id)
    {
        $loai = LoaiTienIch::findOrFail($id);

        $request->validate([
            'Ten_LTI' => 'required|unique:loai_tien_iches,Ten_LTI,' . $id . ',Ma_LTI',
        ], [
            'Ten_LTI.required' => 'Tên loại không được để trống.',
            'Ten_LTI.unique' => 'Tên loại này đã trùng với nhóm khác.',
        ]);

        $loai->update([
            'Ten_LTI' => $request->Ten_LTI
        ]);

        return redirect()->back()->with('success', 'Cập nhật tên nhóm thành công!');
    }

    
    public function destroy($id)
    {
        $loai = LoaiTienIch::withCount('tienIches')->findOrFail($id);       
        $loai->delete();

        return redirect()->back()->with('success', 'Đã xóa nhóm tiện ích!');
    }
}
