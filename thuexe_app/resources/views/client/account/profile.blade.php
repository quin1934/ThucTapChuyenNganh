@extends('layout.home')

@section('body')
    <div class="container py-5">
        <div class="row">
            <div class="col-lg-4 mb-4">
                <div class="card shadow-sm border-0">
                    <div class="card-body text-center">
                        @php
                            $avatarUrl = !empty($user->HinhAnh)
                                ? asset('uploads/avatars/' . $user->HinhAnh)
                                : asset('img/team-1.jpg');
                        @endphp

                        <img src="{{ $avatarUrl }}" alt="Avatar" class="rounded-circle mb-3"
                            style="width: 120px; height: 120px; object-fit: cover;">
                        <h5 class="mb-3">{{ $user->Ho_Ten }}</h5>

                        <form action="{{ route('client.profile.avatar') }}" method="POST" enctype="multipart/form-data"
                            class="d-flex align-items-center gap-2 justify-content-center">
                            @csrf
                            <input type="file" name="avatar" class="form-control form-control-sm" accept="image/*"
                                style="max-width: 220px;" required>
                            <button type="submit" class="btn btn-danger btn-sm">Lưu</button>
                        </form>
                        @error('avatar')
                            <div class="text-danger small mt-2">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="card shadow-sm border-0 mt-4">
                    <div class="card-body p-0">
                        <div class="list-group list-group-flush">
                            <a href="{{ route('client.history') }}"
                                class="list-group-item list-group-item-action d-flex align-items-center">
                                <i class="fas fa-history me-2 text-danger"></i> Lịch Sử Đặt Xe
                            </a>
                            <a href="{{ route('client.password.request') }}"
                                class="list-group-item list-group-item-action d-flex align-items-center">
                                <i class="fas fa-key me-2 text-warning"></i> Đổi Mật Khẩu
                            </a>
                            <form action="{{ route('client.profile.destroy') }}" method="POST"
                                onsubmit="return confirm('Bạn chắc chắn muốn xóa tài khoản? Hành động này không thể hoàn tác.');">
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
                    <div class="card-header bg-danger text-white">
                        <h5 class="mb-0">Hồ Sơ Cá Nhân</h5>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('client.profile.update') }}" method="POST" enctype="multipart/form-data">
                            @csrf

                            <div class="row g-3">
                                <div class="col-md-6">
                                    <label class="form-label">Họ Tên</label>
                                    <input type="text" name="Ho_Ten"
                                        class="form-control @error('Ho_Ten') is-invalid @enderror"
                                        value="{{ old('Ho_Ten', $user->Ho_Ten) }}">
                                    @error('Ho_Ten')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">Số Điện Thoại</label>
                                    <input type="text" name="So_Dien_Thoai"
                                        class="form-control @error('So_Dien_Thoai') is-invalid @enderror"
                                        value="{{ old('So_Dien_Thoai', $user->So_Dien_Thoai) }}">
                                    @error('So_Dien_Thoai')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-12">
                                    <label class="form-label">Email (Không đổi)</label>
                                    <input type="email" class="form-control" value="{{ $user->Email }}" disabled>
                                </div>

                                <div class="col-12">
                                    <label class="form-label">Địa Chỉ</label>
                                    <input type="text" name="Dia_Chi"
                                        class="form-control @error('Dia_Chi') is-invalid @enderror"
                                        value="{{ old('Dia_Chi', $user->Dia_Chi) }}">
                                    @error('Dia_Chi')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-md-6">
                                    <label class="form-label">CCCD</label>
                                    <input type="text" name="CCCD"
                                        class="form-control @error('CCCD') is-invalid @enderror"
                                        value="{{ old('CCCD', $user->CCCD) }}">
                                    @error('CCCD')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <hr class="my-4">
                            <h6 class="text-danger mb-3">Giấy Phép Lái Xe</h6>

                            <div class="row g-3">
                                <div class="col-md-6">
                                    <label class="form-label">Số GPLX</label>
                                    <input type="text" name="So_GPLX"
                                        class="form-control @error('So_GPLX') is-invalid @enderror"
                                        value="{{ old('So_GPLX', $user->So_GPLX) }}">
                                    @error('So_GPLX')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">Hạng Bằng</label>
                                    <select name="Hang_Bang_Lai"
                                        class="form-select @error('Hang_Bang_Lai') is-invalid @enderror">
                                        @php
                                            $hangBang = old('Hang_Bang_Lai', $user->Hang_Bang_Lai);
                                            $options = ['A1', 'A2', 'A3', 'A4', 'B1', 'B2', 'C', 'D', 'E', 'F'];
                                        @endphp
                                        <option value="">-- Chọn hạng bằng --</option>
                                        @foreach ($options as $opt)
                                            <option value="{{ $opt }}" @selected($hangBang === $opt)>
                                                {{ $opt }}</option>
                                        @endforeach
                                    </select>
                                    @error('Hang_Bang_Lai')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-md-6">
                                    <label class="form-label">Ngày Cấp</label>
                                    <input type="date" name="Ngay_Cap_GPLX"
                                        class="form-control @error('Ngay_Cap_GPLX') is-invalid @enderror"
                                        value="{{ old('Ngay_Cap_GPLX', !empty($user->Ngay_Cap_GPLX) ? date('Y-m-d', strtotime($user->Ngay_Cap_GPLX)) : '') }}">
                                    @error('Ngay_Cap_GPLX')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">Ngày Hết Hạn</label>
                                    <input type="date" name="Ngay_Het_Han_GPLX"
                                        class="form-control @error('Ngay_Het_Han_GPLX') is-invalid @enderror"
                                        value="{{ old('Ngay_Het_Han_GPLX', !empty($user->Ngay_Het_Han_GPLX) ? date('Y-m-d', strtotime($user->Ngay_Het_Han_GPLX)) : '') }}">
                                    @error('Ngay_Het_Han_GPLX')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-md-6">
                                    <label class="form-label">Ảnh Mặt Trước</label>
                                    <input type="file" name="img_gplx_truoc"
                                        class="form-control @error('img_gplx_truoc') is-invalid @enderror"
                                        accept="image/*">
                                    @error('img_gplx_truoc')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                    @if (!empty($user->Anh_Bang_Lai_Truoc))
                                        @php
                                            $gplxTruoc = str_contains($user->Anh_Bang_Lai_Truoc, '/')
                                                ? asset('storage/' . $user->Anh_Bang_Lai_Truoc)
                                                : asset('uploads/gplx/' . $user->Anh_Bang_Lai_Truoc);
                                        @endphp
                                        <div class="mt-2">
                                            <img src="{{ $gplxTruoc }}" alt="GPLX trước"
                                                style="width: 80px; height: 80px; object-fit: cover; border: 1px solid #eee;" />
                                        </div>
                                    @endif
                                </div>

                                <div class="col-md-6">
                                    <label class="form-label">Ảnh Mặt Sau</label>
                                    <input type="file" name="img_gplx_sau"
                                        class="form-control @error('img_gplx_sau') is-invalid @enderror" accept="image/*">
                                    @error('img_gplx_sau')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                    @if (!empty($user->Anh_Bang_Lai_Sau))
                                        @php
                                            $gplxSau = str_contains($user->Anh_Bang_Lai_Sau, '/')
                                                ? asset('storage/' . $user->Anh_Bang_Lai_Sau)
                                                : asset('uploads/gplx/' . $user->Anh_Bang_Lai_Sau);
                                        @endphp
                                        <div class="mt-2">
                                            <img src="{{ $gplxSau }}" alt="GPLX sau"
                                                style="width: 80px; height: 80px; object-fit: cover; border: 1px solid #eee;" />
                                        </div>
                                    @endif
                                </div>
                            </div>

                            <div class="d-flex justify-content-end mt-4">
                                <button type="submit" class="btn btn-success px-4">Lưu Thay Đổi</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
