@extends('layout.home')

@section('body')
<div class="container py-5" style="background-color: #f5f5f5;">
    <div class="row justify-content-center">
        <div class="col-lg-6 col-md-8">
            <div class="bg-white rounded shadow-sm p-5">
                
                <h2 class="display-6 text-danger mb-4 text-center fw-bold" id="page-title">Quên Mật Khẩu</h2>
                <p class="text-center text-muted mb-4">Chọn vai trò và nhập email để nhận liên kết đặt lại mật khẩu.</p>

                @if ($errors->any())
                    <div class="alert alert-danger text-center">
                        {{ $errors->first() }}
                    </div>
                @endif
                @if (session('success'))
                    <div class="alert alert-success text-center">
                        <i class="fa fa-check-circle me-2"></i> {{ session('success') }}
                        @if (session('resetLink'))
                            <div class="mt-3 p-3 bg-light border border-success rounded">
                                <small class="text-muted d-block mb-1">Mô phỏng Email gửi về:</small>
                                <a href="{{ session('resetLink') }}" class="fw-bold text-danger text-decoration-underline text-break">
                                    >> BẤM VÀO ĐÂY ĐỂ ĐẶT LẠI MẬT KHẨU <<
                                </a>
                            </div>
                        @endif
                    </div>
                @endif

                <form action="{{ route('client.password.email') }}" method="POST">
                    @csrf
                    
                    <div class="mb-4">
                        <div class="btn-group w-100" role="group">
                            <input type="radio" class="btn-check" name="role" id="role_khach" value="khach" checked onchange="updateTitle()">
                            <label class="btn btn-danger text-white" for="role_khach" id="lbl_khach">
                                <i class="fa fa-user me-1"></i> Khách Thuê
                            </label>

                            <input type="radio" class="btn-check" name="role" id="role_chu_xe" value="chu_xe" onchange="updateTitle()">
                            <label class="btn btn-outline-danger" for="role_chu_xe" id="lbl_chu_xe">
                                <i class="fa fa-car me-1"></i> Chủ Xe
                            </label>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-bold text-secondary">Email đăng ký</label>
                        <input type="email" name="email" class="form-control form-control-lg bg-light border-0" 
                               placeholder="nhap_email_cua_ban@example.com" required value="{{ old('email') }}">
                    </div>

                    <button type="submit" class="btn btn-danger w-100 py-3 fw-bold fs-5 shadow-sm">Gửi Yêu Cầu</button>
                </form>

                <div class="text-center mt-4">
                    <a href="{{ route('client.login') }}" class="text-secondary text-decoration-none">
                        <i class="fa fa-arrow-left me-1"></i> Quay lại Đăng nhập
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    function updateTitle() {
        const isKhach = document.getElementById('role_khach').checked;
        const title = document.getElementById('page-title');
        const lblKhach = document.getElementById('lbl_khach');
        const lblChuXe = document.getElementById('lbl_chu_xe');

        if (isKhach) {
            title.innerText = "Quên Mật Khẩu Khách Thuê";
            lblKhach.className = "btn btn-danger text-white";
            lblChuXe.className = "btn btn-outline-danger";
        } else {
            title.innerText = "Quên Mật Khẩu Chủ Xe";
            lblKhach.className = "btn btn-outline-danger";
            lblChuXe.className = "btn btn-danger text-white";
        }
    }
    document.addEventListener('DOMContentLoaded', updateTitle);
</script>
@endsection