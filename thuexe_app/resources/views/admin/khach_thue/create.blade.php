@extends('layout.admin')
@section('body')
    <div class="container-fluid">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Trang Chủ</a></li>
            <li class="breadcrumb-item active"><a href="{{ route('khach-thue.index') }}">Quản Lý Khách Thuê</a></li>
            <li class="breadcrumb-item active">Thêm Khách Thuê Mới</li>
        </ol>
        <div class="card shadow mb-4">
            <div class="card-header py-3 bg-primary text-white">
                <h5 class="m-0 font-weight-bold text-center text-uppercase">Thêm Hồ Sơ Khách Hàng Mới</h5>
            </div>
            <div class="card-body">
                <form action="{{ route('khach-thue.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf

                    <h5 class="text-primary border-bottom pb-2 mb-3"><i class="fa fa-user"></i> 1. Thông Tin Cá Nhân</h5>
                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label>Họ và Tên <span class="text-danger">*</span></label>
                            <input type="text" name="Ho_Ten" class="form-control" placeholder="Nguyễn Văn A" required>
                        </div>
                        <div class="form-group col-md-6">
                            <label>Số Điện Thoại <span class="text-danger">*</span> (Sẽ là mật khẩu mặc định)</label>
                            <input type="text" name="So_Dien_Thoai" class="form-control" placeholder="09xxxxxxxx"
                                required>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label>Căn Cước Công Dân (CCCD)</label>
                            <input type="text" name="CCCD" class="form-control" placeholder="Số CCCD...">
                        </div>
                        <div class="form-group col-md-6">
                            <label>Email (Đăng nhập)</label>
                            <input type="email" name="Email" class="form-control" placeholder="email@example.com">
                        </div>
                    </div>
                    <div class="form-group">
                        <label>Địa Chỉ</label>
                        <input type="text" name="Dia_Chi" class="form-control"
                            placeholder="Số nhà, Đường, Quận/Huyện...">
                    </div>

                    <h5 class="text-primary border-bottom pb-2 mb-3 mt-4"><i class="fa fa-id-card"></i> 2. Thông Tin Giấy
                        Phép Lái Xe</h5>
                    <div class="form-row">
                        <div class="form-group col-md-8">
                            <label>Số GPLX</label>
                            <input type="text" name="So_GPLX" class="form-control" placeholder="Số ghi trên bằng lái">
                        </div>
                        <div class="form-group col-md-4">
                            <label>Hạng Bằng</label>
                            <select name="Hang_Bang_Lai" class="form-control">
                                <option value="">-- Chọn hạng --</option>
                                <option value="B1">B1 (Số tự động)</option>
                                <option value="B2">B2 (Số sàn & Tự động)</option>
                                <option value="C">C (Xe tải)</option>
                                <option value="D">D (Xe khách)</option>
                                <option value="A1">A1 (Xe máy)</option>
                            </select>
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label>Ngày Cấp</label>
                            <input type="date" name="Ngay_Cap_GPLX" class="form-control">
                        </div>
                        <div class="form-group col-md-6">
                            <label>Ngày Hết Hạn</label>
                            <input type="date" name="Ngay_Het_Han_GPLX" class="form-control">
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label>Ảnh GPLX Mặt Trước</label>
                            <div class="custom-file">
                                <input type="file" name="Anh_Bang_Lai_Truoc" class="custom-file-input" id="customFile1"
                                    onchange="previewImage(this, 'preview1')">
                                <label class="custom-file-label" for="customFile1">Chọn file...</label>
                            </div>
                            <img id="preview1" class="img-thumbnail mt-2 d-none" style="height: 150px; object-fit: cover;">
                        </div>
                        <div class="form-group col-md-6">
                            <label>Ảnh GPLX Mặt Sau</label>
                            <div class="custom-file">
                                <input type="file" name="Anh_Bang_Lai_Sau" class="custom-file-input" id="customFile2"
                                    onchange="previewImage(this, 'preview2')">
                                <label class="custom-file-label" for="customFile2">Chọn file...</label>
                            </div>
                            <img id="preview2" class="img-thumbnail mt-2 d-none" style="height: 150px; object-fit: cover;">
                        </div>
                    </div>

                    <div class="mt-4 text-center">
                        <button type="submit" class="btn btn-success btn-lg px-5 font-weight-bold">
                            <i class="fa fa-save"></i> LƯU HỒ SƠ
                        </button>
                        <a href="{{ route('khach-thue.index') }}" class="btn btn-secondary btn-lg px-5">Quay Lại</a>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        function previewImage(input, previewId) {
            if (input.files && input.files[0]) {
                var reader = new FileReader();
                reader.onload = function(e) {
                    var img = document.getElementById(previewId);
                    img.src = e.target.result;
                    img.classList.remove('d-none');
                }
                reader.readAsDataURL(input.files[0]);
                var fileName = input.files[0].name;
                input.nextElementSibling.innerHTML = fileName;
            }
        }
    </script>
@endsection
