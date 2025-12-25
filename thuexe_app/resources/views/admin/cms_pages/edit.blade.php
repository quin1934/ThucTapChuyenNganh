@extends('layout.admin')

@section('body')
    <div class="container-fluid">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Trang Chủ</a></li>
            <li class="breadcrumb-item"><a href="{{ route('cms-pages.index') }}">Trang CMS</a></li>
            <li class="breadcrumb-item active">Cập nhật</li>
        </ol>

        <div class="alert alert-info">
            <strong>Hướng dẫn:</strong>
            <ul class="mb-0">
                <li>Đổi <strong>slug</strong> sẽ ảnh hưởng đến trang được render ở phía client (nếu client map theo slug).
                </li>
                <li>Dùng nút <strong>Quản lý khối nội dung</strong> để thêm/sửa/xóa các block của trang.</li>
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
            <div class="card-header d-flex justify-content-between align-items-center">
                <h6 class="m-0 font-weight-bold text-primary">Cập nhật trang CMS</h6>
                <a class="btn btn-sm btn-outline-primary"
                    href="{{ route('cms-blocks.index', ['page_id' => $cmsPage->id]) }}">
                    Quản lý khối nội dung
                </a>
            </div>
            <div class="card-body">
                <form action="{{ route('cms-pages.update', $cmsPage) }}" method="POST">
                    @csrf
                    @method('PUT')

                    <div class="form-group">
                        <label>Định danh (slug)</label>
                        <input type="text" name="slug" class="form-control" value="{{ old('slug', $cmsPage->slug) }}"
                            required>
                    </div>

                    <div class="form-group">
                        <label>Tên trang</label>
                        <input type="text" name="ten_trang" class="form-control"
                            value="{{ old('ten_trang', $cmsPage->ten_trang) }}" required>
                    </div>

                    <div class="form-group form-check">
                        <input type="checkbox" name="is_active" value="1" class="form-check-input" id="is_active"
                            {{ old('is_active', $cmsPage->is_active) ? 'checked' : '' }}>
                        <label class="form-check-label" for="is_active">Bật trang</label>
                    </div>

                    <button class="btn btn-primary" type="submit">Lưu</button>
                    <a href="{{ route('cms-pages.index') }}" class="btn btn-secondary">Hủy</a>
                </form>
            </div>
        </div>
    </div>
@endsection
