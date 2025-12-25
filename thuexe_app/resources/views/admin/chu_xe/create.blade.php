@extends('layout.admin')
@section('body')
    <div class="container-fluid">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Trang Chủ</a></li>
            <li class="breadcrumb-item active"><a href="{{ route('chu-xe.index') }}">Quản Lý Chủ Xe</a></li>
            <li class="breadcrumb-item active">Thêm Chủ Xe Mới</li>
        </ol>
        <div class="card shadow">
            <div class="card-header bg-primary text-white">
                <h5 class="m-0 font-weight-bold">Thêm Chủ Xe Mới</h5>
            </div>
            <div class="card-body">
                <form action="{{ route('chu-xe.store') }}" method="POST">
                    @csrf
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Họ và Tên <span class="text-danger">*</span></label>
                                <input type="text" name="Ten_CX" class="form-control" required
                                    placeholder="Nhập họ tên...">
                            </div>
                            <div class="form-group">
                                <label>Số Điện Thoại <span class="text-danger">*</span></label>
                                <input type="text" name="SoDT_CX" class="form-control" required
                                    placeholder="Nhập số điện thoại...">
                            </div>
                            <div class="form-group">
                                <label>Email (Dùng đăng nhập) <span class="text-danger">*</span></label>
                                <input type="email" name="Email_CX" class="form-control" required
                                    placeholder="example@email.com">
                            </div>
                            <div class="form-group">
                                <label>Địa Chỉ</label>
                                <input type="text" name="DiaChi_CX" class="form-control"
                                    placeholder="Địa chỉ liên hệ...">
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Số Tài Khoản Ngân Hàng</label>
                                <input type="text" name="SoTKNH_CX" class="form-control" placeholder="Số TK - Tên NH...">
                            </div>

                            <div class="form-group">
                                <label>Trạng Thái Tài Khoản</label>
                                <select name="Trang_Thai" class="form-control">
                                    <option value="DaDuyet">✅ Đã Duyệt (Hoạt động)</option>
                                    <option value="ChoDuyet">⏳ Chờ Duyệt</option>
                                    <option value="Khoa">⛔ Khóa</option>
                                </select>
                            </div>

                            <div class="form-group bg-light p-3 border rounded">
                                <label class="text-primary font-weight-bold">Thiết Lập Mật Khẩu <span
                                        class="text-danger">*</span></label>
                                <input type="text" name="password" class="form-control" required
                                    placeholder="Nhập mật khẩu đăng nhập...">
                            </div>
                        </div>
                    </div>

                    <div class="text-center mt-3">
                        <button type="submit" class="btn btn-success px-5"><i class="fa fa-save"></i> Lưu Lại</button>
                        <a href="{{ route('chu-xe.index') }}" class="btn btn-secondary px-5">Hủy</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
