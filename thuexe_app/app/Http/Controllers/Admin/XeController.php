<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Xe;
use Illuminate\Http\Request;

class XeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
   public function index()
    {
        $cars = Xe::with(['chuXe', 'phanLoaiXe'])
                  ->orderBy('created_at', 'desc')
                  ->paginate(10);

        return view('admin.xe.index', compact('cars'));
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
    public function show(Xe $xe)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Xe $xe)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Xe $xe)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Xe $xe)
    {
        //
    }
}
