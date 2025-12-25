@extends('layout.admin')

@section('body')
    <div class="container-fluid">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Trang Chủ</a></li>
            <li class="breadcrumb-item"><a href="{{ route('promotion.index') }}">Khuyến Mãi</a></li>
            <li class="breadcrumb-item active">Sửa</li>
        </ol>

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
                <h6 class="m-0 font-weight-bold text-primary">Cập nhật khuyến mãi</h6>
            </div>
            <div class="card-body">
                <form action="{{ route('promotion.update', $promotion) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')

                    <div class="form-group">
                        <label>Tiêu đề</label>
                        <input type="text" name="title" class="form-control"
                            value="{{ old('title', $promotion->title) }}" required>
                    </div>

                    <div class="form-group">
                        <label>Mô tả</label>
                        <textarea name="description" class="form-control" rows="4">{{ old('description', $promotion->description) }}</textarea>
                    </div>

                    <div class="form-group">
                        <label>Banner (ảnh)</label>
                        <div class="mb-2">
                            @if ($promotion->banner_path)
                                <img src="{{ asset('storage/' . $promotion->banner_path) }}" alt="Banner"
                                    class="img-thumbnail" style="height: 80px;">
                            @else
                                <span class="text-muted">Chưa có</span>
                            @endif
                        </div>
                        <input type="file" name="banner" class="form-control-file">
                    </div>

                    <div class="form-row">
                        <div class="form-group col-md-4">
                            <label>Loại giảm</label>
                            <select name="discount_type" class="form-control" required>
                                @php
                                    $dt = old('discount_type', $promotion->discount_type ?? 'none');
                                @endphp
                                <option value="none" {{ $dt === 'none' ? 'selected' : '' }}>Không</option>
                                <option value="percent" {{ $dt === 'percent' ? 'selected' : '' }}>%</option>
                                <option value="fixed" {{ $dt === 'fixed' ? 'selected' : '' }}>Cố định (đ)</option>
                            </select>
                        </div>
                        <div class="form-group col-md-4">
                            <label>Giá trị giảm</label>
                            <input type="number" step="0.01" name="discount_value" class="form-control"
                                value="{{ old('discount_value', $promotion->discount_value) }}">
                        </div>
                        <div class="form-group col-md-4">
                            <label>Mã (nếu có)</label>
                            <input type="text" name="code" class="form-control"
                                value="{{ old('code', $promotion->code) }}">
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label>Thời gian bắt đầu</label>
                            <input type="datetime-local" name="start_at" class="form-control"
                                value="{{ old('start_at', $promotion->start_at ? $promotion->start_at->format('Y-m-d\TH:i') : '') }}">
                        </div>
                        <div class="form-group col-md-6">
                            <label>Thời gian kết thúc</label>
                            <input type="datetime-local" name="end_at" class="form-control"
                                value="{{ old('end_at', $promotion->end_at ? $promotion->end_at->format('Y-m-d\TH:i') : '') }}">
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label>Áp dụng cho xe (tùy chọn)</label>
                            <select name="ma_xe" class="form-control">
                                <option value="">-- Tất cả / Không chọn --</option>
                                @foreach ($cars as $c)
                                    <option value="{{ $c->Ma_Xe }}"
                                        {{ (string) old('ma_xe', $promotion->ma_xe) === (string) $c->Ma_Xe ? 'selected' : '' }}>
                                        {{ $c->Ten_Xe }} (ID: {{ $c->Ma_Xe }})
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group col-md-6">
                            <label>Áp dụng cho phân loại xe (tùy chọn)</label>
                            <select name="ma_plxe" class="form-control">
                                <option value="">-- Tất cả / Không chọn --</option>
                                @foreach ($categories as $cat)
                                    <option value="{{ $cat->Ma_PLXe }}"
                                        {{ (string) old('ma_plxe', $promotion->ma_plxe) === (string) $cat->Ma_PLXe ? 'selected' : '' }}>
                                        {{ $cat->Ten_PLXe }} (ID: {{ $cat->Ma_PLXe }})
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="form-group form-check">
                        <input type="checkbox" name="is_active" value="1" class="form-check-input" id="is_active"
                            {{ old('is_active', $promotion->is_active) ? 'checked' : '' }}>
                        <label class="form-check-label" for="is_active">Kích hoạt</label>
                    </div>

                    <button class="btn btn-primary" type="submit">Lưu</button>
                    <a href="{{ route('promotion.index') }}" class="btn btn-secondary">Hủy</a>
                </form>
            </div>
        </div>
    </div>
@endsection
