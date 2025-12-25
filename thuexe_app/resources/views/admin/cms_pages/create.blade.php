@extends('layout.admin')

@section('body')
    <div class="container-fluid">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Trang Chủ</a></li>
            <li class="breadcrumb-item"><a href="{{ route('cms-pages.index') }}">Trang CMS</a></li>
            <li class="breadcrumb-item active">Thêm trang</li>
        </ol>

        <div class="alert alert-info">
            <strong>Hướng dẫn:</strong>
            <ul class="mb-0">
                <li><strong>Định danh (slug)</strong> là mã trang, không dấu, không khoảng trắng (vd: <code>home</code>).
                </li>
                <li>Sau khi tạo trang, vào <strong>Khối nội dung</strong> để thêm các block cho trang đó.</li>
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
                <h6 class="m-0 font-weight-bold text-primary">Tạo trang CMS</h6>
            </div>
            <div class="card-body">
                <form action="{{ route('cms-pages.store') }}" method="POST">
                    @csrf

                    <div class="form-group">
                        <label>Định danh (slug)</label>
                        <input type="text" name="slug" class="form-control" value="{{ old('slug') }}" required>
                        <small class="text-muted">Ví dụ: <code>home</code>, <code>about</code>, <code>team</code>.</small>
                    </div>

                    <div class="form-group">
                        <label>Tên trang</label>
                        <input type="text" name="ten_trang" class="form-control" value="{{ old('ten_trang') }}" required>
                    </div>

                    <div class="form-group form-check">
                        <input type="checkbox" name="is_active" value="1" class="form-check-input" id="is_active"
                            {{ old('is_active', true) ? 'checked' : '' }}>
                        <label class="form-check-label" for="is_active">Bật trang</label>
                    </div>

                    <button class="btn btn-primary" type="submit">Lưu</button>
                    <a href="{{ route('cms-pages.index') }}" class="btn btn-secondary">Hủy</a>
                </form>
            </div>
        </div>
    </div>
@endsection
