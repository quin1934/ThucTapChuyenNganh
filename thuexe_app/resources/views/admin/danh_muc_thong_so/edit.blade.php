@extends('layout.admin')
@section('body')
<div class="container-fluid">
    <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Trang Chủ</a></li>
            <li class="breadcrumb-item active"><a href="{{ route('danh_muc_thong_so.index') }}">Quản Lý Thông Số</a></li>
            <li class="breadcrumb-item active">Cập Nhật Thông Số </li>
        </ol>
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Cập nhật thông tin</h6>
        </div>
        <div class="card-body">
            <form action="{{ route('danh_muc_thong_so.update', $item->Ma_DM) }}" method="POST">
                @csrf @method('PUT')
                <input type="hidden" name="Loai_DanhMuc" value="{{ $item->Loai_DanhMuc }}">

                <div class="form-group">
                    <label>Tên hiển thị <span class="text-danger">*</span></label>
                    <input type="text" name="Ten_DM" class="form-control" value="{{ $item->Ten_DM }}" required>
                </div>

                <div class="form-group">
                    <label>Mô tả chi tiết</label>
                    <textarea name="MoTa_DM" class="form-control" rows="3">{{ $item->MoTa_DM }}</textarea>
                </div>

                <button type="submit" class="btn btn-warning"><i class="fa fa-save"></i> Cập nhật</button>
                <a href="{{ route('danh_muc_thong_so.index', ['type' => $item->Loai_DanhMuc]) }}" class="btn btn-secondary">Hủy</a>
            </form>
        </div>
    </div>
</div>
@endsection