<?php

namespace App\Http\Controllers\Admin;

use App\Models\CmsBlock;
use App\Models\CmsPage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class CmsBlockController extends AdminBaseController
{
    private function maybeDeleteStoredImage(?string $path): void
    {
        $path = trim((string) $path);
        if ($path === '') {
            return;
        }

        if (str_starts_with($path, 'cms/') && Storage::disk('public')->exists($path)) {
            Storage::disk('public')->delete($path);
        }
    }

    public function index(Request $request)
    {
        $pages = CmsPage::query()->orderBy('slug')->get(['id', 'slug', 'ten_trang']);

        $query = CmsBlock::query()
            ->with(['page:id,slug,ten_trang'])
            ->orderBy('page_id')
            ->orderBy('type')
            ->orderBy('sort_order');

        $pageId = $request->query('page_id');
        $type = trim((string) $request->query('type', ''));

        if (!empty($pageId)) {
            $query->where('page_id', $pageId);
        }
        if ($type !== '') {
            $query->where('type', $type);
        }

        $blocks = $query->paginate(20)->withQueryString();

        return view('admin.cms_blocks.index', compact('blocks', 'pages', 'pageId', 'type'));
    }

    public function create(Request $request)
    {
        $pages = CmsPage::query()->orderBy('slug')->get(['id', 'slug', 'ten_trang']);
        $prefillPageId = $request->query('page_id');

        return view('admin.cms_blocks.create', compact('pages', 'prefillPageId'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'page_id' => ['required', 'exists:cms_pages,id'],
            'type' => ['required', 'string', 'max:191'],
            'title' => ['nullable', 'string', 'max:191'],
            'subtitle' => ['nullable', 'string', 'max:191'],
            'content' => ['nullable', 'string'],
            'image_path' => ['nullable', 'string', 'max:191'],
            'image_file' => ['nullable', 'image', 'mimes:jpeg,png,jpg,gif,webp', 'max:4096'],
            'cta_text' => ['nullable', 'string', 'max:191'],
            'cta_url' => ['nullable', 'string', 'max:191'],
            'sort_order' => ['nullable', 'integer'],
            'is_active' => ['nullable', 'boolean'],
            'start_at' => ['nullable', 'date'],
            'end_at' => ['nullable', 'date', 'after_or_equal:start_at'],
        ]);

        $validated['sort_order'] = (int) ($validated['sort_order'] ?? 0);
        $validated['is_active'] = (bool) ($validated['is_active'] ?? false);
        $validated['created_by'] = Auth::id();

        if ($request->hasFile('image_file')) {
            $path = $request->file('image_file')->store('cms', 'public');
            $validated['image_path'] = $path;
        }

        CmsBlock::create($validated);

        return redirect()->route('cms-blocks.index', ['page_id' => $validated['page_id']])
            ->with('success', 'Đã tạo block CMS.');
    }

    public function edit(CmsBlock $cmsBlock)
    {
        $pages = CmsPage::query()->orderBy('slug')->get(['id', 'slug', 'ten_trang']);

        return view('admin.cms_blocks.edit', compact('cmsBlock', 'pages'));
    }

    public function update(Request $request, CmsBlock $cmsBlock)
    {
        $validated = $request->validate([
            'page_id' => ['required', 'exists:cms_pages,id'],
            'type' => ['required', 'string', 'max:191'],
            'title' => ['nullable', 'string', 'max:191'],
            'subtitle' => ['nullable', 'string', 'max:191'],
            'content' => ['nullable', 'string'],
            'image_path' => ['nullable', 'string', 'max:191'],
            'image_file' => ['nullable', 'image', 'mimes:jpeg,png,jpg,gif,webp', 'max:4096'],
            'cta_text' => ['nullable', 'string', 'max:191'],
            'cta_url' => ['nullable', 'string', 'max:191'],
            'sort_order' => ['nullable', 'integer'],
            'is_active' => ['nullable', 'boolean'],
            'start_at' => ['nullable', 'date'],
            'end_at' => ['nullable', 'date', 'after_or_equal:start_at'],
        ]);

        $validated['sort_order'] = (int) ($validated['sort_order'] ?? 0);
        $validated['is_active'] = (bool) ($validated['is_active'] ?? false);
        $validated['updated_by'] = Auth::id();

        if ($request->hasFile('image_file')) {
            $this->maybeDeleteStoredImage($cmsBlock->image_path);
            $path = $request->file('image_file')->store('cms', 'public');
            $validated['image_path'] = $path;
        }

        $cmsBlock->update($validated);

        return redirect()->route('cms-blocks.index', ['page_id' => $validated['page_id']])
            ->with('success', 'Đã cập nhật block CMS.');
    }

    public function destroy(CmsBlock $cmsBlock)
    {
        $pageId = $cmsBlock->page_id;
        $this->maybeDeleteStoredImage($cmsBlock->image_path);
        $cmsBlock->delete();

        return redirect()->route('cms-blocks.index', ['page_id' => $pageId])
            ->with('success', 'Đã xóa block CMS.');
    }
}
