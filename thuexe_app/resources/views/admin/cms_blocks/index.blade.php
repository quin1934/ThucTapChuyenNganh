@extends('layout.admin')

@section('body')
    <div class="container-fluid">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Trang Chủ</a></li>
            <li class="breadcrumb-item active">Khối nội dung (CMS)</li>
        </ol>

        <div class="alert alert-info">
            <strong>Hướng dẫn:</strong>
            <ul class="mb-0">
                <li>Mỗi <strong>khối</strong> thuộc về 1 <strong>trang</strong> và có <strong>loại khối (type)</strong> để
                    client biết hiển thị ở vị trí nào.</li>
                <li>Ưu tiên dùng <strong>Thứ tự</strong> để sắp xếp hiển thị khi có nhiều khối cùng type.</li>
                <li><strong>Ảnh</strong>: có thể nhập đường dẫn hoặc tải lên (tải lên sẽ ghi đè đường dẫn ảnh).</li>
            </ul>
        </div>

        @if (session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        <div class="card mb-3 shadow">
            <div class="card-header py-3 d-flex justify-content-between align-items-center">
                <h6 class="m-0 font-weight-bold text-primary">Danh sách khối nội dung ({{ $blocks->total() }})</h6>
                <a href="{{ route('cms-blocks.create', ['page_id' => $pageId]) }}" class="btn btn-sm btn-primary shadow-sm">
                    <i class="fa fa-plus"></i> Thêm block
                </a>
            </div>
            <div class="card-body">
                <form class="mb-3" method="GET" action="{{ route('cms-blocks.index') }}">
                    @php
                        $typeOptions = [
                            'hero_slide_1' => 'Hero - Slide 1',
                            'hero_slide_2' => 'Hero - Slide 2',
                            'about_intro' => 'Giới thiệu - Mở đầu',
                            'about_vision' => 'Giới thiệu - Tầm nhìn',
                            'about_mission' => 'Giới thiệu - Sứ mệnh',
                            'about_story' => 'Giới thiệu - Câu chuyện',
                            'about_years' => 'Giới thiệu - Số năm kinh nghiệm',
                            'about_bullets' => 'Giới thiệu - Gạch đầu dòng',
                            'about_founder' => 'Giới thiệu - Người sáng lập',
                            'about_image_1' => 'Giới thiệu - Ảnh 1',
                            'about_image_2' => 'Giới thiệu - Ảnh 2',
                            'categories_intro' => 'Danh mục xe - Mở đầu',
                            'support_intro' => 'Hỗ trợ - Mở đầu',
                            'footer_about' => 'Footer - Về chúng tôi',
                            'footer_quick_links' => 'Footer - Liên kết nhanh',
                            'footer_working_hours' => 'Footer - Giờ làm việc',
                            'footer_contact_info' => 'Footer - Thông tin liên hệ',
                        ];

                        $selectedType = trim((string) ($type ?? ''));
                        if ($selectedType !== '' && !array_key_exists($selectedType, $typeOptions)) {
                            $typeOptions[$selectedType] = 'Khác: ' . $selectedType;
                        }
                    @endphp
                    <div class="form-row">
                        <div class="form-group col-md-5">
                            <label>Trang</label>
                            <select class="form-control" name="page_id">
                                <option value="">-- Tất cả --</option>
                                @foreach ($pages as $p)
                                    <option value="{{ $p->id }}"
                                        {{ (string) $pageId === (string) $p->id ? 'selected' : '' }}>
                                        {{ $p->slug }} - {{ $p->ten_trang }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group col-md-5">
                            <label>Loại khối (type)</label>
                            <select class="form-control" name="type">
                                <option value="">-- Tất cả --</option>
                                @foreach ($typeOptions as $value => $label)
                                    <option value="{{ $value }}"
                                        {{ $selectedType === (string) $value ? 'selected' : '' }}>
                                        {{ $label }}
                                    </option>
                                @endforeach
                            </select>
                            <small class="text-muted">Type dùng để client map đúng vị trí hiển thị.</small>
                        </div>
                        <div class="form-group col-md-2 d-flex align-items-end">
                            <button class="btn btn-secondary w-100" type="submit">Lọc</button>
                        </div>
                    </div>
                </form>

                <div class="table-responsive">
                    <table class="table table-bordered" width="100%" cellspacing="0">
                        <thead class="bg-light text-dark">
                            <tr>
                                <th>ID</th>
                                <th>Trang</th>
                                <th>Loại (type)</th>
                                <th>Tiêu đề</th>
                                <th>Thứ tự</th>
                                <th>Trạng thái</th>
                                <th>Thời gian</th>
                                <th>Ảnh</th>
                                <th width="160">Thao tác</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($blocks as $b)
                                <tr>
                                    <td>{{ $b->id }}</td>
                                    <td>
                                        <div><code>{{ $b->page?->slug }}</code></div>
                                        <div class="small text-muted">{{ $b->page?->ten_trang }}</div>
                                    </td>
                                    <td><code>{{ $b->type }}</code></td>
                                    <td>
                                        <div><strong>{{ $b->title ?? '—' }}</strong></div>
                                        @if (!empty($b->subtitle))
                                            <div class="small text-muted">{{ $b->subtitle }}</div>
                                        @endif
                                    </td>
                                    <td class="text-center">{{ (int) $b->sort_order }}</td>
                                    <td class="text-center">
                                        @if ($b->is_active)
                                            <span class="badge badge-success">Bật</span>
                                        @else
                                            <span class="badge badge-secondary">Tắt</span>
                                        @endif
                                    </td>
                                    <td class="small">
                                        <div>Bắt đầu:
                                            {{ $b->start_at ? \Carbon\Carbon::parse($b->start_at)->format('d/m/Y H:i') : '—' }}
                                        </div>
                                        <div>Kết thúc:
                                            {{ $b->end_at ? \Carbon\Carbon::parse($b->end_at)->format('d/m/Y H:i') : '—' }}
                                        </div>
                                    </td>
                                    <td class="text-center">
                                        @if (!empty($b->image_path))
                                            <span class="badge badge-info">Có</span>
                                        @else
                                            <span class="text-muted">—</span>
                                        @endif
                                    </td>
                                    <td class="text-center">
                                        <a href="{{ route('cms-blocks.edit', $b) }}" class="btn btn-sm btn-warning">Sửa</a>
                                        <form action="{{ route('cms-blocks.destroy', $b) }}" method="POST"
                                            class="d-inline" onsubmit="return confirm('Xóa block này?')">
                                            @csrf
                                            @method('DELETE')
                                            <button class="btn btn-sm btn-danger" type="submit">Xóa</button>
                                        </form>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="9" class="text-center">Chưa có block CMS.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <div class="d-flex justify-content-center">
                    {{ $blocks->links() }}
                </div>
            </div>
        </div>
    </div>
@endsection
