@extends('layout.home')

@section('body')
<div class="container py-5" style="background-color: #f5f5f5;">
    <div class="row justify-content-center">
        <div class="col-lg-6 col-md-8">
            <div class="bg-white rounded shadow-sm p-5">
                
                <h3 class="display-6 text-danger mb-4 text-center fw-bold">Đặt Lại Mật Khẩu</h3>
                
                @if($role == 'khach')
                    <p class="text-center badge bg-info d-block py-2 mb-4">Tài khoản Khách Thuê: {{ $email }}</p>
                @else
                    <p class="text-center badge bg-warning text-dark d-block py-2 mb-4">Tài khoản Chủ Xe: {{ $email }}</p>
                @endif

                @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul class="mb-0">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form action="{{ route('client.password.update') }}" method="POST">
                    @csrf
                    <input type="hidden" name="token" value="{{ $token }}">
                    <input type="hidden" name="email" value="{{ $email }}">
                    <input type="hidden" name="role" value="{{ $role }}">

                    <div class="mb-3">
                        <label class="form-label fw-bold text-secondary">Mật khẩu mới</label>
                        <input type="password" name="password" class="form-control form-control-lg bg-light border-0" required autofocus>
                    </div>

                    <div class="mb-4">
                        <label class="form-label fw-bold text-secondary">Nhập lại mật khẩu</label>
                        <input type="password" name="password_confirmation" class="form-control form-control-lg bg-light border-0" required>
                    </div>

                    <button type="submit" class="btn btn-danger w-100 py-3 fw-bold fs-5 shadow-sm">Xác Nhận Đổi Mật Khẩu</button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection