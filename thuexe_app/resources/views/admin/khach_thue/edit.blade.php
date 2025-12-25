@extends('layout.admin')
@section('body')
    <div class="container-fluid">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Trang Chủ</a></li>
            <li class="breadcrumb-item active"><a href="{{ route('khach-thue.index') }}">Quản Lý Khách Thuê</a></li>
            <li class="breadcrumb-item active">Cập Nhật Khách Thuê</li>
        </ol>
        <div class="card shadow mb-4">
            <div class="card-header py-3 bg-primary text-white">
                <h5 class="m-0 font-weight-bold text-center text-uppercase">Cập Nhật Hồ Sơ Khách Hàng</h5>
            </div>
            <div class="card-body">
                <form action="{{ route('khach-thue.update', $khach->Ma_KT) }}" method="POST" enctype="multipart/form-data">
                    @csrf @method('PUT')

                    <h5 class="text-primary border-bottom pb-2 mb-3">1. Thông Tin Cá Nhân</h5>
                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label>Họ và Tên <span class="text-danger">*</span></label>
                            <input type="text" name="Ho_Ten" class="form-control" value="{{ $khach->Ho_Ten }}" required>
                        </div>
                        <div class="form-group col-md-6">
                            <label>Số Điện Thoại <span class="text-danger">*</span></label>
                            <input type="text" name="So_Dien_Thoai" class="form-control"
                                value="{{ $khach->So_Dien_Thoai }}" required>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label>CCCD</label>
                            <input type="text" name="CCCD" class="form-control" value="{{ $khach->CCCD }}">
                        </div>
                        <div class="form-group col-md-6">
                            <label>Email</label>
                            <input type="email" name="Email" class="form-control" value="{{ $khach->Email }}">
                        </div>
                    </div>
                    <div class="form-group">
                        <label>Địa Chỉ</label>
                        <input type="text" name="Dia_Chi" class="form-control" value="{{ $khach->Dia_Chi }}">
                    </div>
                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label>CCCD</label>
                            <input type="text" name="CCCD" class="form-control" value="{{ $khach->CCCD }}">
                        </div>
                        <div class="form-group col-md-6">
                            <label>Email</label>
                            <input type="email" name="Email" class="form-control" value="{{ $khach->Email }}">
                        </div>
                    </div>

                    <div class="form-group bg-light p-3 border rounded border-danger">
                        <label class="text-danger font-weight-bold">
                            <i class="fa fa-key"></i> Đổi Mật Khẩu (Tùy chọn)
                        </label>
                        <div class="input-group">
                            <input type="text" name="new_password" class="form-control"
                                placeholder="Nhập mật khẩu mới nếu muốn đổi...">
                            <div class="input-group-append">
                                <span class="input-group-text"><i class="fa fa-lock"></i></span>
                            </div>
                        </div>
                        <small class="text-muted font-italic">
                            * Để trống ô này nếu bạn muốn giữ nguyên mật khẩu hiện tại của khách.
                        </small>
                    </div>
                    <div class="form-group">
                        <label>Địa Chỉ</label>
                        <input type="text" name="Dia_Chi" class="form-control" value="{{ $khach->Dia_Chi }}">
                    </div>
                    <h5 class="text-primary border-bottom pb-2 mb-3 mt-4">2. Thông Tin Giấy Phép Lái Xe</h5>
                    <div class="form-row">
                        <div class="form-group col-md-8">
                            <label>Số GPLX</label>
                            <input type="text" name="So_GPLX" class="form-control" value="{{ $khach->So_GPLX }}">
                        </div>
                        <div class="form-group col-md-4">
                            <label>Hạng Bằng</label>
                            <select name="Hang_Bang_Lai" class="form-control">
                                <option value="">-- Chọn --</option>
                                @foreach (['B1', 'B2', 'C', 'D', 'A1'] as $h)
                                    <option value="{{ $h }}"
                                        {{ $khach->Hang_Bang_Lai == $h ? 'selected' : '' }}>{{ $h }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label>Ngày Cấp</label>
                            <input type="date" name="Ngay_Cap_GPLX" class="form-control"
                                value="{{ $khach->Ngay_Cap_GPLX }}">
                        </div>
                        <div class="form-group col-md-6">
                            <label>Ngày Hết Hạn</label>
                            <input type="date" name="Ngay_Het_Han_GPLX" class="form-control"
                                value="{{ $khach->Ngay_Het_Han_GPLX }}">
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label>Ảnh GPLX Mặt Trước</label>
                            @if ($khach->Anh_Bang_Lai_Truoc)
                                <div class="mb-2"><img src="{{ asset('storage/' . $khach->Anh_Bang_Lai_Truoc) }}"
                                        height="100" class="rounded"></div>
                            @endif
                            <input type="file" name="Anh_Bang_Lai_Truoc" class="form-control-file">
                        </div>
                        <div class="form-group col-md-6">
                            <label>Ảnh GPLX Mặt Sau</label>
                            @if ($khach->Anh_Bang_Lai_Sau)
                                <div class="mb-2"><img src="{{ asset('storage/' . $khach->Anh_Bang_Lai_Sau) }}"
                                        height="100" class="rounded"></div>
                            @endif
                            <input type="file" name="Anh_Bang_Lai_Sau" class="form-control-file">
                        </div>
                    </div>

                    <div class="mt-4 text-center">
                        <button type="submit" class="btn btn-warning btn-lg px-5">Cập Nhật</button>
                        <a href="{{ route('khach-thue.index') }}" class="btn btn-secondary btn-lg px-5">Hủy</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
