<?php

namespace App\Http\Controllers\Admin;

use App\Models\PhanLoaiXe;
use App\Models\Promotion;
use App\Models\Xe;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class PromotionController extends AdminBaseController
{
    public function index()
    {
        $promotions = Promotion::query()
            ->orderByDesc('is_active')
            ->orderByDesc('start_at')
            ->orderByDesc('created_at')
            ->paginate(10);

        return view('admin.promotion.index', compact('promotions'));
    }

    public function create()
    {
        $cars = Xe::query()->orderBy('Ten_Xe')->get(['Ma_Xe', 'Ten_Xe']);
        $categories = PhanLoaiXe::query()->orderBy('Ten_PLXe')->get(['Ma_PLXe', 'Ten_PLXe']);

        return view('admin.promotion.create', compact('cars', 'categories'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => ['required', 'string', 'max:191'],
            'description' => ['nullable', 'string'],
            'banner' => ['nullable', 'image', 'mimes:jpeg,png,jpg,gif,webp', 'max:2048'],
            'discount_type' => ['required', 'in:percent,fixed,none'],
            'discount_value' => ['nullable', 'numeric', 'min:0'],
            'code' => ['nullable', 'string', 'max:191'],
            'start_at' => ['nullable', 'date'],
            'end_at' => ['nullable', 'date', 'after_or_equal:start_at'],
            'is_active' => ['nullable', 'boolean'],
            'ma_xe' => ['nullable', 'integer'],
            'ma_plxe' => ['nullable', 'integer'],
        ]);

        if (!empty($validated['ma_xe']) && !empty($validated['ma_plxe'])) {
            return back()
                ->withErrors(['ma_xe' => 'Chỉ chọn 1 trong 2: Xe hoặc Phân loại xe.', 'ma_plxe' => 'Chỉ chọn 1 trong 2: Xe hoặc Phân loại xe.'])
                ->withInput();
        }

        if (($validated['discount_type'] ?? 'none') === 'none') {
            $validated['discount_value'] = null;
        }

        $validated['is_active'] = (bool) ($validated['is_active'] ?? false);
        $validated['created_by'] = Auth::id();

        if ($request->hasFile('banner')) {
            $path = $request->file('banner')->store('promotions', 'public');
            $validated['banner_path'] = $path;
        }

        Promotion::create($validated);

        return redirect()->route('promotion.index')->with('success', 'Đã tạo khuyến mãi.');
    }

    public function edit(Promotion $promotion)
    {
        $cars = Xe::query()->orderBy('Ten_Xe')->get(['Ma_Xe', 'Ten_Xe']);
        $categories = PhanLoaiXe::query()->orderBy('Ten_PLXe')->get(['Ma_PLXe', 'Ten_PLXe']);

        return view('admin.promotion.edit', compact('promotion', 'cars', 'categories'));
    }

    public function update(Request $request, Promotion $promotion)
    {
        $validated = $request->validate([
            'title' => ['required', 'string', 'max:191'],
            'description' => ['nullable', 'string'],
            'banner' => ['nullable', 'image', 'mimes:jpeg,png,jpg,gif,webp', 'max:2048'],
            'discount_type' => ['required', 'in:percent,fixed,none'],
            'discount_value' => ['nullable', 'numeric', 'min:0'],
            'code' => ['nullable', 'string', 'max:191'],
            'start_at' => ['nullable', 'date'],
            'end_at' => ['nullable', 'date', 'after_or_equal:start_at'],
            'is_active' => ['nullable', 'boolean'],
            'ma_xe' => ['nullable', 'integer'],
            'ma_plxe' => ['nullable', 'integer'],
        ]);

        if (!empty($validated['ma_xe']) && !empty($validated['ma_plxe'])) {
            return back()
                ->withErrors(['ma_xe' => 'Chỉ chọn 1 trong 2: Xe hoặc Phân loại xe.', 'ma_plxe' => 'Chỉ chọn 1 trong 2: Xe hoặc Phân loại xe.'])
                ->withInput();
        }

        if (($validated['discount_type'] ?? 'none') === 'none') {
            $validated['discount_value'] = null;
        }

        $validated['is_active'] = (bool) ($validated['is_active'] ?? false);

        if ($request->hasFile('banner')) {
            if (!empty($promotion->banner_path) && Storage::disk('public')->exists($promotion->banner_path)) {
                Storage::disk('public')->delete($promotion->banner_path);
            }

            $path = $request->file('banner')->store('promotions', 'public');
            $validated['banner_path'] = $path;
        }

        $promotion->update($validated);

        return redirect()->route('promotion.index')->with('success', 'Đã cập nhật khuyến mãi.');
    }

    public function destroy(Promotion $promotion)
    {
        if (!empty($promotion->banner_path) && Storage::disk('public')->exists($promotion->banner_path)) {
            Storage::disk('public')->delete($promotion->banner_path);
        }

        $promotion->delete();

        return redirect()->route('promotion.index')->with('success', 'Đã xóa khuyến mãi.');
    }
}
