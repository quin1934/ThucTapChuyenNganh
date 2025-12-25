@extends('layout.admin')
@section('body')
    <div class="container-fluid">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Trang Chủ</a></li>
            <li class="breadcrumb-item active"><a href="{{ route('quan-tri-vien.index') }}">Quản Trị Viên</a></li>
            <li class="breadcrumb-item active">Cập Nhật Thông Tin Admin</li>
        </ol>
        <div class="card shadow" style="max-width: 700px; margin: 0 auto;">
            <div class="card-header bg-primary text-white">
                <h5 class="m-0 font-weight-bold">Cập Nhật Thông Tin Admin</h5>
            </div>
            <div class="card-body">
                <form action="{{ route('quan-tri-vien.update', $admin->id) }}" method="POST">
                    @csrf @method('PUT')

                    <div class="form-group">
                        <label>Họ và Tên</label>
                        <input type="text" name="name" class="form-control" value="{{ $admin->name }}" required>
                    </div>

                    <div class="form-group">
                        <label>Email (Đăng nhập)</label>
                        <input type="email" name="email" class="form-control" value="{{ $admin->email }}" required>
                    </div>

                    <div class="form-group bg-light p-3 border rounded border-danger mt-3">
                        <label class="text-danger font-weight-bold">Đổi Mật Khẩu (Tùy chọn)</label>
                        <input type="text" name="password" class="form-control"
                            placeholder="Nhập mật khẩu mới nếu muốn đổi...">
                        <small class="text-muted font-italic">* Để trống nếu muốn giữ nguyên mật khẩu cũ.</small>
                    </div>

                    @if (auth()->id() == 1 && $admin->id != 1)
                        <div class="form-group mt-3">
                            <label class="font-weight-bold">Vai Trò (VaiTro)</label>
                            <input type="text" name="VaiTro" class="form-control"
                                value="{{ old('VaiTro', $admin->VaiTro) }}"
                                placeholder="VD: Admin, QuanLyXe, QuanLyDonThue...">
                            <small class="text-muted font-italic">* Chỉ Master Admin được chỉnh vai trò.</small>
                        </div>
                    @endif

                    <div class="text-center mt-4">
                        <button type="submit" class="btn btn-warning px-5"><i class="fa fa-save"></i> Cập Nhật</button>
                        <a href="{{ route('quan-tri-vien.index') }}" class="btn btn-secondary px-5">Hủy</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
