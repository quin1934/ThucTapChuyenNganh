@extends('layout.admin')
@section('body')
    <div class="container-fluid">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Trang Chủ</a></li>
            <li class="breadcrumb-item active"><a href="{{ route('danh_muc_thong_so.index') }}">Quản Lý Thông Số</a></li>
            <li class="breadcrumb-item active">Thêm Mới {{ $type == 'NhienLieu' ? 'Loại Nhiên Liệu' : 'Loại Hộp Số' }}</li>
        </ol>
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">
                    Thêm Mới: {{ $type == 'NhienLieu' ? 'Loại Nhiên Liệu' : 'Loại Hộp Số' }}
                </h6>
            </div>
            <div class="card-body">
                <form action="{{ route('danh_muc_thong_so.store') }}" method="POST">
                    @csrf
                    <input type="hidden" name="Loai_DanhMuc" value="{{ $type }}">

                    <div class="form-group">
                        <label>Tên hiển thị <span class="text-danger">*</span></label>
                        <input type="text" name="Ten_DM" class="form-control" required
                            placeholder="VD: Xăng, Số sàn...">
                    </div>

                    <div class="form-group">
                        <label>Mô tả chi tiết</label>
                        <textarea name="MoTa_DM" class="form-control" rows="3"></textarea>
                    </div>

                    <button type="submit" class="btn btn-success"><i class="fa fa-save"></i> Lưu lại</button>
                    <a href="{{ route('danh_muc_thong_so.index', ['type' => $type]) }}" class="btn btn-secondary">Hủy</a>
                </form>
            </div>
        </div>
    </div>
@endsection
