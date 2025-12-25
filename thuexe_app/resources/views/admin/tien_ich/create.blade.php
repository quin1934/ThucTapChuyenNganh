@extends('layout.admin')
@section('body')
    <div class="container-fluid">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Trang Chủ</a></li>
            <li class="breadcrumb-item active"><a href="{{ route('tien-ich.index') }}">Quản Lý Tiện Ích</a></li>
            <li class="breadcrumb-item active">Thêm Tiện Ích Mới</li>
        </ol>
        <div class="card shadow">
            <div class="card-header font-weight-bold text-primary">Thêm Tiện Ích Mới</div>
            <div class="card-body">
                <form action="{{ route('tien-ich.store') }}" method="POST">
                    @csrf
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Tên Tiện Ích <span class="text-danger">*</span></label>
                                <input type="text" name="Ten_TI" class="form-control" required
                                    placeholder="VD: Cảm biến lùi...">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Thuộc Loại <span class="text-danger">*</span></label>
                                <select name="Ma_LTI" class="form-control" required>
                                    <option value="">-- Chọn loại --</option>
                                    @foreach ($loaiTienIches as $loai)
                                        <option value="{{ $loai->Ma_LTI }}">{{ $loai->Ten_LTI }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label>Mô tả chi tiết</label>
                        <textarea name="MoTa_TI" class="form-control" rows="3"></textarea>
                    </div>
                    <button type="submit" class="btn btn-success"><i class="fa fa-save"></i> Lưu lại</button>
                    <a href="{{ route('tien-ich.index') }}" class="btn btn-secondary">Hủy</a>
                </form>
            </div>
        </div>
    </div>
@endsection
