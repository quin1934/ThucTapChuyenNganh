<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;

class QuanTriVienController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {    
        $admins = User::orderBy('id', 'desc')->paginate(10);
        return view('admin.quan_tri_vien.index', compact('admins'));
    }
    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {        
        if(auth()->id() == $id) {
            return back()->with('error', 'Không thể xóa tài khoản đang đăng nhập!');
        }

        $user = User::findOrFail($id);
        $user->delete();
        
        return back()->with('success', 'Đã xóa quản trị viên thành công!');
    }
}
