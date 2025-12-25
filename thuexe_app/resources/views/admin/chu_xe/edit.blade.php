@extends('layout.admin')
@section('body')
    <div class="container-fluid">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Trang Chủ</a></li>
            <li class="breadcrumb-item active"><a href="{{ route('chu-xe.index') }}">Quản Lý Chủ Xe</a></li>
            <li class="breadcrumb-item active">Cập Nhật Chủ Xe</li>
        </ol>
        <div class="card shadow">
            <div class="card-header bg-primary text-white">
                <h5 class="m-0 font-weight-bold">Cập Nhật Thông Tin Chủ Xe</h5>
            </div>
            <div class="card-body">
                <form action="{{ route('chu-xe.update', $chuXe->Ma_CX) }}" method="POST">
                    @csrf @method('PUT')
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Họ và Tên <span class="text-danger">*</span></label>
                                <input type="text" name="Ten_CX" class="form-control" value="{{ $chuXe->Ten_CX }}"
                                    required>
                            </div>
                            <div class="form-group">
                                <label>Số Điện Thoại <span class="text-danger">*</span></label>
                                <input type="text" name="SoDT_CX" class="form-control" value="{{ $chuXe->SoDT_CX }}"
                                    required>
                            </div>
                            <div class="form-group">
                                <label>Email (Đăng nhập) <span class="text-danger">*</span></label>
                                <input type="email" name="Email_CX" class="form-control" value="{{ $chuXe->Email_CX }}"
                                    required>
                            </div>
                            <div class="form-group">
                                <label>Địa Chỉ</label>
                                <input type="text" name="DiaChi_CX" class="form-control" value="{{ $chuXe->DiaChi_CX }}">
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Số Tài Khoản Ngân Hàng</label>
                                <input type="text" name="SoTKNH_CX" class="form-control" value="{{ $chuXe->SoTKNH_CX }}">
                            </div>

                            <div class="form-group">
                                <label>Trạng Thái</label>
                                <select name="Trang_Thai" class="form-control">
                                    <option value="DaDuyet" {{ $chuXe->Trang_Thai == 'DaDuyet' ? 'selected' : '' }}>✅ Đã
                                        Duyệt</option>
                                    <option value="ChoDuyet" {{ $chuXe->Trang_Thai == 'ChoDuyet' ? 'selected' : '' }}>⏳ Chờ
                                        Duyệt</option>
                                    <option value="Khoa" {{ $chuXe->Trang_Thai == 'Khoa' ? 'selected' : '' }}>⛔ Khóa
                                    </option>
                                </select>
                            </div>

                            <div class="form-group bg-light p-3 border rounded border-danger">
                                <label class="text-danger font-weight-bold">Đổi Mật Khẩu (Tùy chọn)</label>
                                <input type="password" name="password" class="form-control"
                                    placeholder="Nhập mật khẩu mới nếu muốn đổi...">
                                <small class="text-muted font-italic">* Để trống nếu muốn giữ nguyên mật khẩu cũ.</small>
                            </div>
                        </div>
                    </div>

                    <div class="text-center mt-3">
                        <button type="submit" class="btn btn-warning px-5"><i class="fa fa-save"></i> Cập Nhật</button>
                        <a href="{{ route('chu-xe.index') }}" class="btn btn-secondary px-5">Hủy</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
