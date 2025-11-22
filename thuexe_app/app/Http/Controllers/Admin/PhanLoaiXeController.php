<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\PhanLoaiXe;
use Illuminate\Http\Request;

class PhanLoaiXeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    
    public function index()
    {     
        $types = PhanLoaiXe::withCount('xes')->get();
        return view('admin.phan_loai_xe.index', compact('types'));
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
    public function show(PhanLoaiXe $phanLoaiXe)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(PhanLoaiXe $phanLoaiXe)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, PhanLoaiXe $phanLoaiXe)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(PhanLoaiXe $phanLoaiXe)
    {
        //
    }
}
