<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\KhachThue;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Hash;

class KhachThueController extends AdminBaseController
{
    public function index()
    {
        $khachs = KhachThue::orderBy('Ma_KT', 'desc')->paginate(10);
        return view('admin.khach_thue.index', compact('khachs'));
    }

    public function create()
    {
        return view('admin.khach_thue.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'Ho_Ten' => 'required',
            'So_Dien_Thoai' => 'required|unique:khach_thues,So_Dien_Thoai',

            'So_GPLX' => 'nullable|string',
            'Hang_Bang_Lai' => 'nullable|string',
            'Ngay_Cap_GPLX' => 'nullable|date',
            'Ngay_Het_Han_GPLX' => 'nullable|date',

            'Anh_Bang_Lai_Truoc' => 'image|max:5120',
            'Anh_Bang_Lai_Sau' => 'image|max:5120',
        ]);

        $data = $request->all();


        KhachThue::create($data);

        return redirect()->route('khach-thue.index')->with('success', 'Thêm thành công!');
    }
    public function edit($id)
    {
        $khach = KhachThue::findOrFail($id);
        return view('admin.khach_thue.edit', compact('khach'));
    }

    public function update(Request $request, $id)
    {
        $khach = KhachThue::findOrFail($id);
        $request->validate([
            'Ho_Ten' => 'required',
            'So_Dien_Thoai' => 'required|unique:khach_thues,So_Dien_Thoai,' . $id . ',Ma_KT',
            'So_GPLX' => 'nullable|string',
            'Hang_Bang_Lai' => 'nullable|string',
            'Ngay_Cap_GPLX' => 'nullable|date',
            'Ngay_Het_Han_GPLX' => 'nullable|date',
            'Anh_Bang_Lai_Truoc' => 'image|max:5120',
            'Anh_Bang_Lai_Sau' => 'image|max:5120',
        ]);

        $data = $request->except(['password', 'new_password']);

        if ($request->filled('new_password')) {
            $data['password'] = Hash::make($request->new_password);
        }

        if ($request->hasFile('Anh_Bang_Lai_Truoc')) {
            if ($khach->Anh_Bang_Lai_Truoc && Storage::disk('public')->exists($khach->Anh_Bang_Lai_Truoc)) {
                Storage::disk('public')->delete($khach->Anh_Bang_Lai_Truoc);
            }
            $data['Anh_Bang_Lai_Truoc'] = $request->file('Anh_Bang_Lai_Truoc')->store('bang_lai', 'public');
        }

        if ($request->hasFile('Anh_Bang_Lai_Sau')) {
            if ($khach->Anh_Bang_Lai_Sau && Storage::disk('public')->exists($khach->Anh_Bang_Lai_Sau)) {
                Storage::disk('public')->delete($khach->Anh_Bang_Lai_Sau);
            }
            $data['Anh_Bang_Lai_Sau'] = $request->file('Anh_Bang_Lai_Sau')->store('bang_lai', 'public');
        }

        $khach->update($data);
        $msg = 'Cập nhật thông tin thành công!';
        if ($request->filled('new_password')) {
            $msg .= ' Mật khẩu cũng đã được thay đổi.';
        }

        return redirect()->route('khach-thue.index')->with('success', $msg);
    }

    public function destroy($id)
    {
        $khach = KhachThue::findOrFail($id);
        if ($khach->Anh_Bang_Lai_Truoc) Storage::disk('public')->delete($khach->Anh_Bang_Lai_Truoc);
        if ($khach->Anh_Bang_Lai_Sau) Storage::disk('public')->delete($khach->Anh_Bang_Lai_Sau);
        $khach->delete();
        return redirect()->route('khach-thue.index')->with('success', 'Đã xóa khách hàng!');
    }

    public function show($id)
    {
        $khach = KhachThue::with(['donThues.xe'])->findOrFail($id);

        return view('admin.khach_thue.show', compact('khach'));
    }
}
