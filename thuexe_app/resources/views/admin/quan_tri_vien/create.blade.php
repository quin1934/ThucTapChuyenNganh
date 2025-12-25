@extends('layout.admin')
@section('body')
    <div class="container-fluid">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Trang Chủ</a></li>
            <li class="breadcrumb-item active"><a href="{{ route('quan-tri-vien.index') }}">Quản Trị Viên</a></li>
            <li class="breadcrumb-item active">Thêm Quản Trị Viên Mới</li>
        </ol>
        <div class="card shadow" style="max-width: 700px; margin: 0 auto;">
            <div class="card-header bg-primary text-white">
                <h5 class="m-0 font-weight-bold">Thêm Quản Trị Viên</h5>
            </div>
            <div class="card-body">
                <form action="{{ route('quan-tri-vien.store') }}" method="POST">
                    @csrf
                    <div class="form-group">
                        <label>Họ và Tên (Ten_QTV) <span class="text-danger">*</span></label>
                        <input type="text" name="name" class="form-control" required placeholder="Nhập họ tên...">
                    </div>

                    <div class="form-group">
                        <label>Email Liên Hệ (Email_QTV) <span class="text-danger">*</span></label>
                        <input type="email" name="email" class="form-control" required placeholder="email@example.com">
                    </div>

                    <div class="form-group">
                        <label>Mật Khẩu (MatKhau_QTV) <span class="text-danger">*</span></label>
                        <input type="text" name="password" class="form-control" required placeholder="Nhập mật khẩu...">
                    </div>

                    @if (auth()->id() == 1)
                        <div class="form-group">
                            <label>Vai Trò (VaiTro)</label>
                            <input type="text" name="VaiTro" class="form-control"
                                placeholder="VD: Admin, QuanLyXe, QuanLyDonThue...">
                            <small class="text-muted font-italic">* Chỉ Master Admin được gán vai trò.</small>
                        </div>
                    @endif

                    <div class="text-center mt-4">
                        <button type="submit" class="btn btn-success px-5"><i class="fa fa-save"></i> Lưu Lại</button>
                        <a href="{{ route('quan-tri-vien.index') }}" class="btn btn-secondary px-5">Hủy</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
