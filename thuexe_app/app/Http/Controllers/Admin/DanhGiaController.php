<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\DanhGia;

class DanhGiaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $reviews = DanhGia::with(['khachThue', 'donThue.xe'])
                    ->orderBy('created_at', 'desc')
                    ->paginate(10);

        return view('admin.danh_gia.index', compact('reviews'));
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
        $review = DanhGia::findOrFail($id);
        $review->delete();
        return back()->with('success', 'Đã xóa đánh giá thành công!');
    }
}
