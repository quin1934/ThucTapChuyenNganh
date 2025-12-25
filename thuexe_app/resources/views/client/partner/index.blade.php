@extends('layout.home')

@section('body')
    <div class="container py-5">
        <div class="row">
            <div class="col-lg-4 mb-4">
                <div class="card shadow-sm border-0">
                    <div class="card-body text-center">
                        @php
                            $avatarUrl = !empty($user->HinhAnh)
                                ? asset('uploads/avatars/partners/' . $user->HinhAnh)
                                : asset('img/team-1.jpg');
                        @endphp

                        <img src="{{ $avatarUrl }}" alt="Avatar" class="rounded-circle mb-3"
                            style="width: 120px; height: 120px; object-fit: cover;">
                        <h5 class="mb-1">{{ $user->Ten_CX }}</h5>
                        <div class="text-muted small mb-3">{{ $user->Email_CX }}</div>

                        <form action="{{ route('partner.profile.avatar') }}" method="POST" enctype="multipart/form-data"
                            class="d-flex align-items-center gap-2 justify-content-center">
                            @csrf
                            <input type="file" name="avatar" class="form-control form-control-sm" accept="image/*"
                                style="max-width: 220px;" required>
                            <button type="submit" class="btn btn-danger btn-sm">Lưu Ảnh</button>
                        </form>
                        @error('avatar')
                            <div class="text-danger small mt-2">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="card shadow-sm border-0 mt-4">
                    <div class="card-body p-0">
                        <div class="list-group list-group-flush">
                            <a href="{{ route('partner.cars') }}"
                                class="list-group-item list-group-item-action d-flex align-items-center">
                                <i class="fas fa-car me-2 text-danger"></i> Quản Lý Xe
                            </a>
                            <a href="{{ route('client.password.request') }}"
                                class="list-group-item list-group-item-action d-flex align-items-center">
                                <i class="fas fa-key me-2 text-warning"></i> Đổi Mật Khẩu
                            </a>
                            <form action="{{ route('partner.profile.destroy') }}" method="POST"
                                onsubmit="return confirm('Bạn chắc chắn muốn xóa tài khoản đối tác? Hành động này không thể hoàn tác.');">
                                @csrf
                                @method('DELETE')
                                <button type="submit"
                                    class="list-group-item list-group-item-action d-flex align-items-center text-danger border-0 w-100 text-start">
                                    <i class="fas fa-trash me-2"></i> Xóa Tài Khoản
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-lg-8">
                @if (session('success'))
                    <div class="alert alert-success">{{ session('success') }}</div>
                @endif
                @if (session('error'))
                    <div class="alert alert-danger">{{ session('error') }}</div>
                @endif

                <div class="card shadow-sm border-0">
                    <div class="card-body">
                        <form action="{{ route('partner.profile.update') }}" method="POST">
                            @csrf
                            <div class="row g-3">
                                <div class="col-md-6">
                                    <label class="form-label">Họ tên Chủ xe</label>
                                    <input type="text" name="Ten_CX"
                                        class="form-control @error('Ten_CX') is-invalid @enderror"
                                        value="{{ old('Ten_CX', $user->Ten_CX) }}">
                                    @error('Ten_CX')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-md-6">
                                    <label class="form-label">Số Điện Thoại</label>
                                    <input type="text" name="SoDT_CX"
                                        class="form-control @error('SoDT_CX') is-invalid @enderror"
                                        value="{{ old('SoDT_CX', $user->SoDT_CX) }}">
                                    @error('SoDT_CX')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-12">
                                    <label class="form-label">Email (Không thể thay đổi)</label>
                                    <input type="email" class="form-control" value="{{ $user->Email_CX }}" disabled>
                                </div>

                                <div class="col-12">
                                    <label class="form-label">Số Tài Khoản Ngân Hàng (Để nhận doanh thu)</label>
                                    <input type="text" name="SoTKNH_CX"
                                        class="form-control @error('SoTKNH_CX') is-invalid @enderror"
                                        value="{{ old('SoTKNH_CX', $user->SoTKNH_CX) }}">
                                    @error('SoTKNH_CX')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                    <div class="form-text">Vui lòng nhập chính xác: Số TK - Tên Ngân Hàng - Chi Nhánh.</div>
                                </div>

                                <div class="col-12">
                                    <label class="form-label">Địa Chỉ Liên Hệ</label>
                                    <input type="text" name="DiaChi_CX"
                                        class="form-control @error('DiaChi_CX') is-invalid @enderror"
                                        value="{{ old('DiaChi_CX', $user->DiaChi_CX) }}">
                                    @error('DiaChi_CX')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="d-flex justify-content-end mt-4">
                                <button type="submit" class="btn btn-success px-4">
                                    <i class="fas fa-save me-1"></i> Lưu Hồ Sơ
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
