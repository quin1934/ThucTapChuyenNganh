@extends('layout/home')
@section('body')
    <div class="container-fluid bg-breadcrumb mb-5">
        <div class="container text-center py-5" style="max-width: 900px;">
            <h4 class="text-white display-4 mb-4 wow fadeInDown" data-wow-delay="0.1s">{{ $xe->Ten_Xe ?? 'Chi Tiết Xe' }}</h4>

            <ol class="breadcrumb d-flex justify-content-center mb-0 wow fadeInDown" data-wow-delay="0.3s">
                <li class="breadcrumb-item"><a href="{{ route('home') }}">Trang chủ</a></li>

                <li class="breadcrumb-item"><a href="{{ route('vehicle') }}">Xe nổi bật</a></li>

                <li class="breadcrumb-item active text-primary">Chi tiết</li>
            </ol>
        </div>
    </div>
    <div class="container-fluid py-5">
        <div class="container">
            @php
                $imgUrl = !empty($xe->HinhAnh)
                    ? \Illuminate\Support\Facades\Storage::url($xe->HinhAnh)
                    : asset('img/car-1.png');

                $gearbox =
                    optional(optional($xe->thongSo)->hopSo)->Ten_DM ?? (optional($xe->thongSo)->LoaiHopSo ?? '-');
                $fuel =
                    optional(optional($xe->thongSo)->nhienLieu)->Ten_DM ??
                    (optional($xe->thongSo)->LoaiNhienLieu ?? '-');
                $consumption = optional($xe->thongSo)->MucTieuThu ?? '-';
                $power = optional($xe->thongSo)->Cong_Xuat ?? '-';

                $chuXe = $xe->chuXe;
                $chuXeAvatarRaw = trim((string) (optional($chuXe)->HinhAnh ?? ''));
                if ($chuXeAvatarRaw === '') {
                    $chuXeAvatar = asset('img/testimonial-1.jpg');
                } elseif (str_starts_with($chuXeAvatarRaw, 'http')) {
                    $chuXeAvatar = $chuXeAvatarRaw;
                } elseif (
                    str_starts_with($chuXeAvatarRaw, 'uploads/') ||
                    str_starts_with($chuXeAvatarRaw, 'img/') ||
                    str_starts_with($chuXeAvatarRaw, 'storage/')
                ) {
                    $chuXeAvatar = asset($chuXeAvatarRaw);
                } elseif (is_file(public_path('uploads/avatars/partners/' . $chuXeAvatarRaw))) {
                    $chuXeAvatar = asset('uploads/avatars/partners/' . $chuXeAvatarRaw);
                } elseif (is_file(public_path('uploads/avatars/' . $chuXeAvatarRaw))) {
                    $chuXeAvatar = asset('uploads/avatars/' . $chuXeAvatarRaw);
                } elseif (is_file(public_path($chuXeAvatarRaw))) {
                    $chuXeAvatar = asset($chuXeAvatarRaw);
                } else {
                    $chuXeAvatar = \Illuminate\Support\Facades\Storage::url($chuXeAvatarRaw);
                }
            @endphp

            <div class="row g-4">
                <div class="col-lg-8">
                    <div class="bg-white rounded p-3 wow fadeInUp" data-wow-delay="0.1s">
                        <img src="{{ $imgUrl }}" class="img-fluid w-100 rounded" alt="{{ $xe->Ten_Xe }}">
                    </div>

                    <div class="mt-4 wow fadeInUp" data-wow-delay="0.2s">
                        <h3 class="text-danger text-uppercase fw-bold mb-2">{{ $xe->Ten_Xe }}</h3>

                        <div class="d-flex flex-wrap gap-2 mb-3">
                            <span class="badge bg-primary"><i
                                    class="fa fa-calendar-alt me-1"></i>{{ $xe->NamSX ?? '-' }}</span>
                            <span class="badge bg-primary"><i class="fa fa-users me-1"></i>{{ $xe->SoGhe ?? '-' }}
                                chỗ</span>
                            <span class="badge bg-primary"><i class="fa fa-cog me-1"></i>{{ $gearbox }}</span>
                        </div>

                        <h5 class="fw-bold mb-2">Mô tả chi tiết:</h5>
                        <p class="mb-0">{{ $xe->MoTa_Xe ?? 'Thông tin mô tả đang được cập nhật.' }}</p>
                    </div>

                    <div class="mt-4 wow fadeInUp" data-wow-delay="0.3s">
                        <h5 class="fw-bold mb-3">Thông Số Kỹ Thuật</h5>

                        <div class="row g-3">
                            <div class="col-md-6">
                                <div class="d-flex align-items-center gap-3">
                                    <div class="d-flex align-items-center">
                                        <i class="fa fa-cogs text-primary me-2"></i>
                                        <span class="fw-bold">Hộp số</span>
                                    </div>
                                    <span>{{ $gearbox }}</span>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="d-flex align-items-center gap-3">
                                    <div class="d-flex align-items-center">
                                        <i class="fa fa-gas-pump text-primary me-2"></i>
                                        <span class="fw-bold">Nhiên liệu</span>
                                    </div>
                                    <span>{{ $fuel }}</span>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="d-flex align-items-center gap-3">
                                    <div class="d-flex align-items-center">
                                        <i class="fa fa-tachometer-alt text-primary me-2"></i>
                                        <span class="fw-bold">Mức tiêu thụ</span>
                                    </div>
                                    <span>{{ $consumption }}</span>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="d-flex align-items-center gap-3">
                                    <div class="d-flex align-items-center">
                                        <i class="fa fa-bolt text-primary me-2"></i>
                                        <span class="fw-bold">Công suất</span>
                                    </div>
                                    <span>{{ $power }}</span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="mt-4 wow fadeInUp" data-wow-delay="0.4s">
                        <h5 class="fw-bold mb-3">Tiện Ích Trang Bị</h5>

                        @if (($xe->tienIches ?? collect())->count() > 0)
                            <div class="row g-2">
                                @foreach ($xe->tienIches as $tienIch)
                                    <div class="col-md-4">
                                        <div class="d-flex align-items-start">
                                            <i class="fa fa-check-circle text-success me-2 mt-1"></i>
                                            <span>{{ $tienIch->Ten_TI ?? '-' }}</span>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        @else
                            <p class="mb-0 text-muted">Đang cập nhật.</p>
                        @endif
                    </div>
                </div>

                <div class="col-lg-4">
                    <div class="bg-white rounded p-4 mb-4 wow fadeInUp" data-wow-delay="0.2s">
                        <h2 class="fw-bold mb-2 text-center text-primary">Đặt Xe Ngay</h2>

                        <div class="d-flex align-items-baseline mb-3">
                            <div class="h4 text-danger fw-bold mb-0">
                                {{ $xe->GiaThue ? number_format($xe->GiaThue, 0, ',', '.') : 'Liên hệ' }}
                            </div>
                            <div class="text-muted ms-2">VNĐ / Ngày</div>
                        </div>

                        <form method="GET" action="{{ route('booking.create', $xe->Ma_Xe) }}">
                            <div class="row g-3">
                                <div class="col-6">
                                    <label class="form-label mb-1">Ngày nhận</label>
                                    <input type="datetime-local" class="form-control" name="ngay_nhan">
                                </div>
                                <div class="col-6">
                                    <label class="form-label mb-1">Ngày trả</label>
                                    <input type="datetime-local" class="form-control" name="ngay_tra">
                                </div>
                                <div class="col-12">
                                    <label class="form-label mb-1">Ghi chú</label>
                                    <textarea class="form-control" rows="3" name="ghi_chu" placeholder="Yêu cầu thêm..."></textarea>
                                </div>
                                <div class="col-12">
                                    <button type="submit" class="btn btn-danger w-100">
                                        <i class="fa fa-paper-plane me-2"></i>Gửi yêu cầu
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>

                    <div class="bg-white rounded p-4 wow fadeInUp" data-wow-delay="0.3s">
                        <h5 class="fw-bold text-center mb-3">Thông Tin Chủ Xe</h5>

                        <div class="text-center mb-3">
                            <img src="{{ $chuXeAvatar }}" class="rounded-circle"
                                style="width: 84px; height: 84px; object-fit: cover;"
                                onerror="this.onerror=null;this.src='{{ asset('img/testimonial-1.jpg') }}';"
                                alt="{{ optional($chuXe)->Ten_CX ?? 'Chủ xe' }}">
                            <div class="fw-bold mt-2">{{ optional($chuXe)->Ten_CX ?? 'Chủ xe' }}</div>
                            <div class="text-warning">
                                <i class="fa fa-star"></i><i class="fa fa-star"></i><i class="fa fa-star"></i><i
                                    class="fa fa-star"></i><i class="fa fa-star"></i>
                                <span class="text-muted">(Uy tín)</span>
                            </div>
                        </div>

                        <div class="small">
                            <div class="d-flex mb-2">
                                <i class="fa fa-map-marker-alt text-danger me-2 mt-1"></i>
                                <div><span class="fw-bold">Địa chỉ:</span> {{ optional($chuXe)->DiaChi_CX ?? '-' }}</div>
                            </div>
                            <div class="d-flex mb-2">
                                <i class="fa fa-phone text-danger me-2 mt-1"></i>
                                <div><span class="fw-bold">Điện thoại:</span> {{ optional($chuXe)->SoDT_CX ?? '-' }}</div>
                            </div>
                            <div class="d-flex mb-3">
                                <i class="fa fa-envelope text-danger me-2 mt-1"></i>
                                <div><span class="fw-bold">Email:</span> {{ optional($chuXe)->Email_CX ?? '-' }}</div>
                            </div>
                        </div>

                        <a href="#" class="btn btn-outline-danger w-100">
                            <i class="fa fa-comment-dots me-2"></i>Gửi Email Ngay
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
