<?php

namespace App\Http\Controllers\Admin;

use App\Models\CmsPage;
use Illuminate\Http\Request;

class CmsPageController extends AdminBaseController
{
    public function index()
    {
        $pages = CmsPage::query()
            ->withCount('blocks')
            ->orderBy('slug')
            ->paginate(20);

        return view('admin.cms_pages.index', compact('pages'));
    }

    public function create()
    {
        return view('admin.cms_pages.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'slug' => ['required', 'string', 'max:191', 'unique:cms_pages,slug'],
            'ten_trang' => ['required', 'string', 'max:191'],
            'is_active' => ['nullable', 'boolean'],
        ]);

        $validated['is_active'] = (bool) ($validated['is_active'] ?? false);

        CmsPage::create($validated);

        return redirect()->route('cms-pages.index')->with('success', 'Đã tạo trang CMS.');
    }

    public function edit(CmsPage $cmsPage)
    {
        return view('admin.cms_pages.edit', compact('cmsPage'));
    }

    public function update(Request $request, CmsPage $cmsPage)
    {
        $validated = $request->validate([
            'slug' => ['required', 'string', 'max:191', 'unique:cms_pages,slug,' . $cmsPage->id],
            'ten_trang' => ['required', 'string', 'max:191'],
            'is_active' => ['nullable', 'boolean'],
        ]);

        $validated['is_active'] = (bool) ($validated['is_active'] ?? false);

        $cmsPage->update($validated);

        return redirect()->route('cms-pages.index')->with('success', 'Đã cập nhật trang CMS.');
    }

    public function destroy(CmsPage $cmsPage)
    {
        $cmsPage->delete();

        return redirect()->route('cms-pages.index')->with('success', 'Đã xóa trang CMS.');
    }
}
