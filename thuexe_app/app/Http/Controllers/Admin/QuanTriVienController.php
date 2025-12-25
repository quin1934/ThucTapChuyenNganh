<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class QuanTriVienController extends AdminBaseController
{
    private function isMaster(): bool
    {
        return Auth::id() === 1;
    }

    public function index()
    {
        $admins = User::orderByRaw('id = 1 DESC')->orderBy('id', 'desc')->paginate(10);
        return view('admin.quan_tri_vien.index', compact('admins'));
    }

    public function create()
    {
        return view('admin.quan_tri_vien.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:6',
            'VaiTro' => 'nullable|string|max:255',
        ], [
            'name.required' => 'Vui lòng nhập họ tên',
            'email.unique' => 'Email này đã được sử dụng',
            'password.min' => 'Mật khẩu phải từ 6 ký tự',
        ]);

        $data = [
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ];

        if ($this->isMaster()) {
            $data['VaiTro'] = $request->filled('VaiTro') ? $request->VaiTro : ($data['VaiTro'] ?? 'Admin');
        } else {
            $data['VaiTro'] = $data['VaiTro'] ?? 'Admin';
        }

        User::create($data);

        return redirect()->route('quan-tri-vien.index')->with('success', 'Thêm quản trị viên thành công!');
    }

    public function show($id)
    {
        $admin = User::findOrFail($id);
        return view('admin.quan_tri_vien.show', compact('admin'));
    }

    public function edit($id)
    {
        if (!$this->isMaster() && Auth::id() != $id) {
            return redirect()->route('quan-tri-vien.index')->with('error', 'Bạn không có quyền sửa tài khoản này!');
        }

        if ($id == 1 && !$this->isMaster()) {
            return redirect()->route('quan-tri-vien.index')->with('error', 'Bạn không có quyền sửa Master Admin!');
        }
        $admin = User::findOrFail($id);
        return view('admin.quan_tri_vien.edit', compact('admin'));
    }

    public function update(Request $request, $id)
    {
        if (!$this->isMaster() && Auth::id() != $id) {
            return redirect()->route('quan-tri-vien.index')->with('error', 'Bạn không có quyền cập nhật tài khoản này!');
        }

        if ($id == 1 && !$this->isMaster()) {
            return redirect()->route('quan-tri-vien.index')->with('error', 'Không được phép tác động Master Admin!');
        }

        $admin = User::findOrFail($id);

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $id,
            'password' => 'nullable|string|min:6',
            'VaiTro' => 'nullable|string|max:255',
        ]);

        $data = [
            'name' => $request->name,
            'email' => $request->email,
        ];

        if ($request->filled('password')) {
            $data['password'] = Hash::make($request->password);
        }

        if ($this->isMaster() && (int) $id !== 1) {
            $data['VaiTro'] = $request->filled('VaiTro') ? $request->VaiTro : null;
        }

        $admin->update($data);

        return redirect()->route('quan-tri-vien.index')->with('success', 'Cập nhật thành công!');
    }

    public function destroy($id)
    {
        if (Auth::id() == $id) return back()->with('error', 'Không thể tự xóa chính mình!');
        if (!$this->isMaster()) {
            return back()->with('error', 'Bạn không có quyền xóa tài khoản này!');
        }

        if ($id == 1) return back()->with('error', 'Không thể xóa Master Admin!');

        User::findOrFail($id)->delete();

        return back()->with('success', 'Đã xóa quản trị viên!');
    }
}
