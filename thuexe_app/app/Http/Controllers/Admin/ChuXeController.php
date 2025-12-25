<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Models\ChuXe;
use Illuminate\Support\Facades\Hash;

class ChuXeController extends AdminBaseController
{
    public function index()
    {
        $chuXes = ChuXe::orderBy('created_at', 'desc')->paginate(10);
        return view('admin.chu_xe.index', compact('chuXes'));
    }

    public function create()
    {
        return view('admin.chu_xe.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'Ten_CX' => 'required|max:255',
            'SoDT_CX' => 'required|numeric',
            'Email_CX' => 'required|email|unique:chu_xes,Email_CX',
            'password' => 'required|min:6',
        ], [
            'Ten_CX.required' => 'Vui lòng nhập tên chủ xe',
            'Email_CX.required' => 'Email là bắt buộc để đăng nhập',
            'Email_CX.unique' => 'Email này đã được sử dụng',
            'password.min' => 'Mật khẩu phải ít nhất 6 ký tự'
        ]);

        $data = $request->all();

        $data['password'] = Hash::make($request->password);

        if (!isset($data['Trang_Thai'])) {
            $data['Trang_Thai'] = 'ChoDuyet';
        }

        ChuXe::create($data);

        return redirect()->route('chu-xe.index')->with('success', 'Thêm chủ xe mới thành công!');
    }

    public function show($id)
    {
        $chuXe = ChuXe::with('xes')->findOrFail($id);
        return view('admin.chu_xe.show', compact('chuXe'));
    }

    public function edit($id)
    {
        $chuXe = ChuXe::findOrFail($id);
        return view('admin.chu_xe.edit', compact('chuXe'));
    }

    public function update(Request $request, $id)
    {
        $chuXe = ChuXe::findOrFail($id);

        $request->validate([
            'Ten_CX' => 'required|max:255',
            'SoDT_CX' => 'required|numeric',
            'Email_CX' => 'required|email|unique:chu_xes,Email_CX,' . $id . ',Ma_CX',
        ]);

        $data = $request->except(['password']); 

        if ($request->filled('password')) {
            $request->validate(['password' => 'min:6']);
            $data['password'] = Hash::make($request->password);
        }

        $chuXe->update($data);

        return redirect()->route('chu-xe.index')->with('success', 'Cập nhật thông tin thành công!');
    }

    public function destroy($id)
    {
        $chuXe = ChuXe::findOrFail($id);
        $chuXe->delete();
        return redirect()->route('chu-xe.index')->with('success', 'Đã xóa chủ xe!');
    }
}
