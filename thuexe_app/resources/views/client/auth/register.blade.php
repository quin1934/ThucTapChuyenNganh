@extends('layout.home')

@section('body')
    <div class="container-fluid py-5" style="background-color: #f5f5f5;">
        <div class="container py-5">
            <div class="row justify-content-center">
                <div class="col-lg-8">
                    <div class="bg-white rounded shadow-sm p-5">

                        <h1 class="display-6 text-danger mb-4 text-center fw-bold">Đăng Ký Tài Khoản</h1>

                        @if ($errors->any())
                            <div class="alert alert-danger">
                                <ul class="mb-0">
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif

                        <div class="mb-5">
                            <label class="form-label fw-bold text-muted small text-uppercase text-center w-100">BẠN MUỐN
                                ĐĂNG KÝ LÀM:</label>
                            <div class="btn-group w-100" role="group">
                                <input type="radio" class="btn-check" name="role_selector" id="tab_khach" checked>
                                <label class="btn btn-danger text-white" for="tab_khach" onclick="switchForm('khach')">
                                    <i class="fa fa-user me-2"></i> Khách Thuê
                                </label>

                                <input type="radio" class="btn-check" name="role_selector" id="tab_chu_xe">
                                <label class="btn btn-danger" for="tab_chu_xe" onclick="switchForm('chu_xe')">
                                    <i class="fa fa-car me-2"></i> Chủ Xe (Đối Tác)
                                </label>
                            </div>
                        </div>

                        <form id="form-khach" action="{{ route('client.register.post') }}" method="POST"
                            enctype="multipart/form-data">
                            @csrf
                            <input type="hidden" name="role" value="khach">

                            <div class="row g-3">
                                <div class="col-12">
                                    <h5 class="border-bottom pb-2 text-secondary mb-3">Thông Tin Cá Nhân</h5>
                                </div>

                                <div class="col-md-6">
                                    <label class="form-label fw-bold text-secondary">Họ và Tên *</label>
                                    <input type="text" name="name" class="form-control bg-light border-0"
                                        placeholder="Nguyễn Văn A" value="{{ old('name') }}" required>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label fw-bold text-secondary">Số Điện Thoại *</label>
                                    <input type="text" name="phone" class="form-control bg-light border-0"
                                        placeholder="09xxxxxxxxx" value="{{ old('phone') }}" required>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label fw-bold text-secondary">Căn Cước Công Dân *</label>
                                    <input type="text" name="cccd" class="form-control bg-light border-0"
                                        value="{{ old('cccd') }}" required>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label fw-bold text-secondary">Địa Chỉ</label>
                                    <input type="text" name="address" class="form-control bg-light border-0"
                                        placeholder="Số nhà, Đường, Quận/Huyện..." value="{{ old('address') }}">
                                </div>
                                <div class="col-12 mt-4">
                                    <h5 class="border-bottom pb-2 text-secondary mb-3">Thông Tin Giấy Phép Lái Xe</h5>
                                </div>

                                <div class="col-md-6">
                                    <label class="form-label fw-bold text-secondary">Số GPLX</label>
                                    <input type="text" name="gplx" class="form-control bg-light border-0"
                                        placeholder="Số trên bằng lái" value="{{ old('gplx') }}">
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label fw-bold text-secondary">Hạng Bằng</label>
                                    <input type="text" name="hang_bang_lai" class="form-control bg-light border-0"
                                        placeholder="Ví dụ: B1, B2, C..." value="{{ old('hang_bang_lai') }}">
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label fw-bold text-secondary">Ngày Cấp</label>
                                    <input type="date" name="ngay_cap" class="form-control bg-light border-0">
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label fw-bold text-secondary">Ngày Hết Hạn</label>
                                    <input type="date" name="ngay_het_han" class="form-control bg-light border-0">
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label fw-bold text-secondary">Ảnh GPLX Mặt Trước</label>
                                    <input type="file" name="img_gplx_truoc" class="form-control bg-light border-0"
                                        accept="image/*">
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label fw-bold text-secondary">Ảnh GPLX Mặt Sau</label>
                                    <input type="file" name="img_gplx_sau" class="form-control bg-light border-0"
                                        accept="image/*">
                                </div>
                                <div class="col-12 mt-4">
                                    <h5 class="border-bottom pb-2 text-secondary mb-3">Thông Tin Đăng Nhập</h5>
                                </div>

                                <div class="col-12">
                                    <label class="form-label fw-bold text-secondary">Email *</label>
                                    <input type="email" name="email" class="form-control bg-light border-0"
                                        placeholder="email@example.com" value="{{ old('email') }}" autocomplete="off"
                                        required>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label fw-bold text-secondary">Mật Khẩu *</label>
                                    <input type="password" name="password" class="form-control bg-light border-0"
                                        autocomplete="new-password" required>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label fw-bold text-secondary">Nhập Lại Mật Khẩu *</label>
                                    <input type="password" name="password_confirmation"
                                        class="form-control bg-light border-0" autocomplete="new-password" required>
                                </div>

                                <div class="col-12 mt-4">
                                    <button class="btn btn-danger w-100 py-3 fw-bold fs-5 shadow-sm" type="submit">ĐĂNG
                                        KÝ TÀI KHOẢN</button>
                                </div>
                            </div>
                        </form>
                        <form id="form-chu-xe" action="{{ route('client.register.post') }}" method="POST"
                            style="display: none;">
                            @csrf
                            <input type="hidden" name="role" value="chu_xe">

                            <div class="row g-3">
                                <div class="col-12">
                                    <h5 class="border-bottom pb-2 text-secondary mb-3">Thông Tin Đối Tác</h5>
                                </div>

                                <div class="col-md-6">
                                    <label class="form-label fw-bold text-secondary">Họ và Tên Chủ Xe *</label>
                                    <input type="text" name="name" class="form-control bg-light border-0"
                                        value="{{ old('name') }}" required>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label fw-bold text-secondary">Số Điện Thoại *</label>
                                    <input type="text" name="phone" class="form-control bg-light border-0"
                                        value="{{ old('phone') }}" required>
                                </div>
                                <div class="col-12">
                                    <label class="form-label fw-bold text-secondary">Số Tài Khoản Ngân Hàng (Để nhận tiền)
                                        *</label>
                                    <input type="text" name="banking_number" class="form-control bg-light border-0"
                                        placeholder="Số TK - Tên Ngân Hàng" value="{{ old('banking_number') }}" required>
                                </div>
                                <div class="col-12">
                                    <label class="form-label fw-bold text-secondary">Địa Chỉ</label>
                                    <input type="text" name="address" class="form-control bg-light border-0"
                                        value="{{ old('address') }}">
                                </div>

                                <div class="col-12 mt-4">
                                    <h5 class="border-bottom pb-2 text-secondary mb-3">Thông Tin Đăng Nhập</h5>
                                </div>

                                <div class="col-12">
                                    <label class="form-label fw-bold text-secondary">Email Liên Hệ *</label>
                                    <input type="email" name="email" class="form-control bg-light border-0"
                                        value="{{ old('email') }}" autocomplete="off" required>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label fw-bold text-secondary">Mật Khẩu *</label>
                                    <input type="password" name="password" class="form-control bg-light border-0"
                                        autocomplete="new-password" required>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label fw-bold text-secondary">Nhập Lại Mật Khẩu *</label>
                                    <input type="password" name="password_confirmation"
                                        class="form-control bg-light border-0" autocomplete="new-password" required>
                                </div>

                                <div class="col-12 mt-4">
                                    <button class="btn btn-danger w-100 py-3 fw-bold fs-5 shadow-sm" type="submit">ĐĂNG
                                        KÝ ĐỐI TÁC</button>
                                </div>
                            </div>
                        </form>

                        <div class="col-12 text-center mt-4">
                            <p class="mb-0 text-secondary">Đã có tài khoản? <a href="{{ route('client.login') }}"
                                    class="text-danger fw-bold text-decoration-none">Đăng nhập ngay</a></p>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        function switchForm(role) {
            const formKhach = document.getElementById('form-khach');
            const formChuXe = document.getElementById('form-chu-xe');

            document.querySelector('label[for="tab_khach"]').className = 'btn btn-outline-danger';
            document.querySelector('label[for="tab_chu_xe"]').className = 'btn btn-outline-danger';

            if (role === 'khach') {
                formKhach.style.display = 'block';
                formChuXe.style.display = 'none';
                const btn = document.querySelector('label[for="tab_khach"]');
                btn.className = 'btn btn-danger text-white';
            } else {
                formKhach.style.display = 'none';
                formChuXe.style.display = 'block';
                const btn = document.querySelector('label[for="tab_chu_xe"]');
                btn.className = 'btn btn-danger text-white';
            }
        }
    </script>
@endsection
