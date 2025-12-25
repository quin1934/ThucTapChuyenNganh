@extends('layout.home')

@section('body')
    <div class="container-fluid py-5" style="background-color: #f5f5f5;">
        <div class="container py-5">
            <div class="row justify-content-center">
                <div class="col-lg-6 col-md-8">
                    <div class="bg-white rounded shadow-sm p-5">

                        <h1 class="display-6 text-danger mb-4 text-center fw-bold">Đăng Nhập</h1>

                        @if ($errors->any())
                            <div class="alert alert-danger text-center">
                                <ul class="mb-0 list-unstyled">
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif

                        @if (session('success'))
                            <div class="alert alert-success text-center">
                                {{ session('success') }}
                            </div>
                        @endif
                        <form action="{{ route('client.login.post') }}" method="POST" autocomplete="off">
                            @csrf

                            <div class="mb-4">
                                <label class="form-label fw-bold text-muted small text-uppercase">BẠN LÀ:</label>
                                <div class="btn-group w-100" role="group">
                                    <input type="radio" class="btn-check" name="role" id="role_khach" value="khach"
                                        checked>
                                    <label class="btn btn-danger text-white" for="role_khach"
                                        style="background-color: #dc3545; border-color: #dc3545;">
                                        <i class="fa fa-user me-1"></i> Khách Thuê
                                    </label>

                                    <input type="radio" class="btn-check" name="role" id="role_chu_xe" value="chu_xe">
                                    <label class="btn btn-outline-danger" for="role_chu_xe">
                                        <i class="fa fa-car me-1"></i> Chủ Xe
                                    </label>
                                </div>
                            </div>

                            <div class="row g-3">
                                <div class="col-12">
                                    <label class="form-label fw-bold text-secondary">Email</label>
                                    <input type="email" name="email"
                                        class="form-control form-control-lg bg-light border-0"
                                        placeholder="Nhập email của bạn" value="{{ old('email') }}" autocomplete="off"
                                        required>
                                </div>

                                <div class="col-12">
                                    <label class="form-label fw-bold text-secondary">Mật Khẩu</label>
                                    <input type="password" name="password"
                                        class="form-control form-control-lg bg-light border-0" placeholder="Nhập mật khẩu"
                                        autocomplete="new-password" required>
                                </div>

                                <div class="col-12 mt-4">
                                    <button class="btn btn-danger w-100 py-3 fw-bold fs-5" type="submit">Đăng Nhập</button>
                                </div>

                                <div class="col-12 text-end">
                                    <a href="{{ route('client.password.request') }}" class="text-danger small text-decoration-none">Quên mật khẩu?</a>
                                </div>

                                <div class="col-12 text-center mt-3">
                                    <p class="text-secondary">Chưa có tài khoản?
                                        <a href="{{ route('client.register') }}"
                                            class="text-danger fw-bold text-decoration-none">Đăng ký ngay</a>
                                    </p>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const roleRadios = document.querySelectorAll('input[name="role"]');
            roleRadios.forEach(radio => {
                radio.addEventListener('change', function() {
                    document.querySelectorAll('label.btn').forEach(lbl => {
                        lbl.className = 'btn btn-outline-danger';
                        lbl.style = '';
                    });
                    const activeLabel = document.querySelector(`label[for="${this.id}"]`);
                    activeLabel.className = 'btn btn-danger text-white';
                    activeLabel.style = 'background-color: #dc3545; border-color: #dc3545;';
                });
            });
        });
    </script>
@endsection
