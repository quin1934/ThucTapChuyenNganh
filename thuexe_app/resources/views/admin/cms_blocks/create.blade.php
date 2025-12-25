@extends('layout.admin')

@section('body')
    <div class="container-fluid">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Trang Chủ</a></li>
            <li class="breadcrumb-item"><a href="{{ route('cms-blocks.index') }}">Khối nội dung (CMS)</a></li>
            <li class="breadcrumb-item active">Thêm mới</li>
        </ol>

        <div class="alert alert-info">
            <strong>Hướng dẫn:</strong>
            <ul class="mb-0">
                <li>Mỗi <strong>khối</strong> thuộc về 1 <strong>trang</strong> và có <strong>type</strong> để frontend map
                    đúng vị trí hiển thị.</li>
                <li>Dùng <strong>Thứ tự</strong> để sắp xếp khi có nhiều khối cùng type.</li>
                <li><strong>Ảnh</strong>: có thể nhập đường dẫn hoặc tải lên (tải lên sẽ ưu tiên hơn và ghi đè đường dẫn).
                </li>
            </ul>
        </div>

        @if ($errors->any())
            <div class="alert alert-danger">
                <ul class="mb-0">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <div class="card shadow">
            <div class="card-header">
                <h6 class="m-0 font-weight-bold text-primary">Tạo khối nội dung (CMS)</h6>
            </div>
            <div class="card-body">
                <form action="{{ route('cms-blocks.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf

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
                    @endphp

                    <div class="form-group">
                        <label>Trang</label>
                        <select name="page_id" class="form-control" required>
                            <option value="">-- Chọn trang --</option>
                            @foreach ($pages as $p)
                                <option value="{{ $p->id }}"
                                    {{ (string) old('page_id', $prefillPageId) === (string) $p->id ? 'selected' : '' }}>
                                    {{ $p->slug }} - {{ $p->ten_trang }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="form-group">
                        <label>Loại khối (type)</label>
                        <select name="type" class="form-control" required>
                            <option value="" disabled {{ old('type') ? '' : 'selected' }}>-- Chọn loại --</option>
                            @foreach ($typeOptions as $value => $label)
                                <option value="{{ $value }}"
                                    {{ old('type') === (string) $value ? 'selected' : '' }}>
                                    {{ $label }}
                                </option>
                            @endforeach
                        </select>
                        <small class="text-muted">Nếu cần thêm type mới, hãy báo để bổ sung vào danh sách.</small>
                    </div>

                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label>Tiêu đề</label>
                            <input type="text" name="title" class="form-control" value="{{ old('title') }}">
                        </div>
                        <div class="form-group col-md-6">
                            <label>Phụ đề</label>
                            <input type="text" name="subtitle" class="form-control" value="{{ old('subtitle') }}">
                        </div>
                    </div>

                    <div class="form-group">
                        <label>Nội dung (có thể chứa HTML)</label>
                        <textarea name="content" class="form-control" rows="6">{{ old('content') }}</textarea>
                    </div>

                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label>Đường dẫn ảnh (tuỳ chọn: vd img/xxx.jpg hoặc cms/xxx)</label>
                            <input type="text" name="image_path" class="form-control" value="{{ old('image_path') }}">
                        </div>
                        <div class="form-group col-md-6">
                            <label>Tải ảnh lên (nếu tải lên sẽ ghi đè image_path)</label>
                            <input type="file" name="image_file" class="form-control-file">
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label>Nút bấm - chữ</label>
                            <input type="text" name="cta_text" class="form-control" value="{{ old('cta_text') }}">
                        </div>
                        <div class="form-group col-md-6">
                            <label>Nút bấm - liên kết</label>
                            <input type="text" name="cta_url" class="form-control" value="{{ old('cta_url') }}">
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="form-group col-md-3">
                            <label>Thứ tự</label>
                            <input type="number" name="sort_order" class="form-control"
                                value="{{ old('sort_order', 0) }}">
                        </div>
                        <div class="form-group col-md-3">
                            <label>Trạng thái</label>
                            <select name="is_active" class="form-control">
                                <option value="1" {{ old('is_active', 1) ? 'selected' : '' }}>Bật</option>
                                <option value="0" {{ !old('is_active', 1) ? 'selected' : '' }}>Tắt</option>
                            </select>
                        </div>
                        <div class="form-group col-md-3">
                            <label>Bắt đầu</label>
                            <input type="datetime-local" name="start_at" class="form-control"
                                value="{{ old('start_at') }}">
                        </div>
                        <div class="form-group col-md-3">
                            <label>Kết thúc</label>
                            <input type="datetime-local" name="end_at" class="form-control" value="{{ old('end_at') }}">
                        </div>
                    </div>

                    <button class="btn btn-primary" type="submit">Lưu</button>
                    <a href="{{ route('cms-blocks.index', ['page_id' => $prefillPageId]) }}"
                        class="btn btn-secondary">Hủy</a>
                </form>
            </div>
        </div>
    </div>
@endsection
