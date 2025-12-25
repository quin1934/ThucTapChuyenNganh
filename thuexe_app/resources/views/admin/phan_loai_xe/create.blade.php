@extends('layout.admin')

@section('body')
    <div class="container-fluid">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Trang Chủ</a></li>
            <li class="breadcrumb-item active"><a href="{{ route('phan-loai-xe.index') }}">Quản Lý Loại Xe</a></li>
            <li class="breadcrumb-item active">Thêm Loại Xe Mới</li>
        </ol>
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">Thêm Loại Xe Mới</h6>
            </div>
            <div class="card-body">
                <form action="{{ route('phan-loai-xe.store') }}" method="POST">
                    @csrf
                    <div class="form-group">
                        <label>Tên Loại Xe <span class="text-danger">*</span></label>
                        <input type="text" name="Ten_PLXe" class="form-control" required
                            placeholder="Ví dụ: Sedan, SUV...">
                        @error('Ten_PLXe')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label>Mô tả</label>
                        <textarea name="MoTa_PLXe" class="form-control" rows="4"></textarea>
                    </div>

                    <hr>
                    <button type="submit" class="btn btn-success"><i class="fa fa-save"></i> Lưu Lại</button>
                    <a href="{{ route('phan-loai-xe.index') }}" class="btn btn-secondary">Quay lại</a>
                </form>
            </div>
        </div>
    </div>
@endsection
