@extends('layout.home')

@section('body')
    <div class="container-fluid bg-breadcrumb mb-5">
        <div class="container text-center py-5" style="max-width: 900px;">
            <h4 class="text-white display-4 mb-2 wow fadeInDown" data-wow-delay="0.1s">Chi Tiết Đơn Thuê</h4>
            <ol class="breadcrumb d-flex justify-content-center mb-0 wow fadeInDown" data-wow-delay="0.3s">
                <li class="breadcrumb-item"><a href="{{ route('home') }}">Trang Chủ</a></li>
                <li class="breadcrumb-item">
                    <a
                        href="{{ isset($viewerRole) && $viewerRole === 'chu_xe' ? route('partner.orders') : route('client.history') }}">
                        {{ isset($viewerRole) && $viewerRole === 'chu_xe' ? 'Danh sách đơn thuê' : 'Lịch Sử Thuê Xe' }}
                    </a>
                </li>
                <li class="breadcrumb-item active text-primary">Chi tiết</li>
            </ol>
        </div>
    </div>

    @php
        $viewerRole = $viewerRole ?? (Auth::guard('chu_xe')->check() ? 'chu_xe' : 'khach');
        $car = $donThue->xe;

        $carImgUrl = !empty($car?->HinhAnh)
            ? \Illuminate\Support\Facades\Storage::url($car->HinhAnh)
            : asset('img/car-1.png');

        $chuXe = $car?->chuXe;
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
            $chuXeAvatar = !empty($chuXeAvatarRaw)
                ? \Illuminate\Support\Facades\Storage::url($chuXeAvatarRaw)
                : asset('img/testimonial-1.jpg');
        }

        $payments = $donThue->thanhToans ?? collect();

        $status = (string) ($donThue->Trang_Thai ?? '');
        $statusBadgeClass = match ($status) {
            'ChoDuyet' => 'bg-warning text-dark',
            'DaDuyet' => 'bg-info text-dark',
            'DaDatCoc' => 'bg-primary',
            'DangDiChuyen', 'DaGiaoXe' => 'bg-info text-dark',
            'HoanThanh', 'DaTraXe' => 'bg-success',
            'DaHuy' => 'bg-danger',
            'QuaHan' => 'bg-dark',
            default => 'bg-secondary',
        };

        $attention = match ($viewerRole) {
            'khach' => match ($status) {
                'DaDuyet' => ['warning', 'Đơn đã được duyệt. Bạn cần đặt cọc để tiếp tục.'],
                'DaDatCoc' => ['info', 'Bạn đã đặt cọc. Khi nhận xe, hãy xác nhận “Đã nhận xe” trong lịch sử thuê xe.'],
                'DangDiChuyen', 'DaGiaoXe' => [
                    'info',
                    'Đơn đang trong thời gian thuê. Khi trả xe, hãy bấm “Trả xe” trong lịch sử thuê xe.',
                ],
                'HoanThanh', 'DaTraXe' => ['success', 'Đơn đã hoàn thành. Cảm ơn bạn đã sử dụng dịch vụ!'],
                'DaHuy' => ['danger', 'Đơn đã hủy.'],
                'QuaHan' => ['danger', 'Đơn đã quá hạn. Vui lòng liên hệ hỗ trợ.'],
                'ChoDuyet' => ['warning', 'Đơn đang chờ chủ xe duyệt.'],
                default => null,
            },
            'chu_xe' => match ($status) {
                'ChoDuyet' => ['warning', 'Đơn đang chờ bạn duyệt.'],
                'DaDuyet' => ['info', 'Đơn đã duyệt. Đang chờ khách thuê đặt cọc.'],
                'DaDatCoc' => ['info', 'Khách đã đặt cọc. Chờ khách xác nhận nhận xe / bắt đầu chuyến.'],
                'DangDiChuyen', 'DaGiaoXe' => ['info', 'Đơn đang trong thời gian thuê. Chờ khách trả xe.'],
                'HoanThanh', 'DaTraXe' => ['success', 'Đơn đã hoàn thành.'],
                'DaHuy' => ['danger', 'Đơn đã hủy.'],
                'QuaHan' => ['danger', 'Đơn đã quá hạn.'],
                default => null,
            },
            default => null,
        };

        $customer = $donThue->khachThue;
        $customerAvatar = !empty($customer?->HinhAnh)
            ? asset('uploads/avatars/' . $customer->HinhAnh)
            : asset('img/testimonial-1.jpg');
    @endphp

    <div class="container py-5">
        <div class="d-flex align-items-center justify-content-between mb-4">
            <div>
                <div>
                    <h1 class="text-danger text-uppercase">Đơn thuê</h1>
                </div>
                <h2 class="mb-0 text-info">#{{ $donThue->Ma_DT }}</h2>
            </div>
            <a href="{{ $viewerRole === 'chu_xe' ? route('partner.orders') : route('client.history') }}"
                class="btn btn-outline-secondary btn-sm">
                <i class="fa fa-arrow-left me-1"></i>Quay lại
            </a>
        </div>

        @if (!empty($attention))
            <div
                class="alert alert-{{ $attention[0] }} border-0 border-start border-4 border-{{ $attention[0] }} shadow-sm">
                <div class="d-flex align-items-start">
                    <div class="me-2">
                        <i class="fa fa-exclamation-circle"></i>
                    </div>
                    <div>
                        <div class="fw-bold mb-1">Cần chú ý</div>
                        <div class="mb-0">{{ $attention[1] }}</div>
                    </div>
                </div>
            </div>
        @endif

        <div class="row g-4">
            <div class="col-lg-7">
                <div class="card shadow-sm border-0 h-100">
                    <div class="card-body">
                        <div class="row g-3">
                            <div class="col-12">
                                <div class="rounded overflow-hidden bg-white">
                                    <img src="{{ $carImgUrl }}" alt="{{ $car?->Ten_Xe ?? 'Xe' }}" class="img-fluid w-100"
                                        style="max-height: 360px; object-fit: cover;">
                                </div>
                            </div>

                            <div class="col-12">
                                <h4 class="mb-2 text-danger">{{ $car?->Ten_Xe ?? '-' }}</h4>
                                <div class="d-flex flex-wrap gap-2">
                                    <span class="badge bg-light text-danger"><i
                                            class="fa fa-id-card me-1"></i>{{ $car?->BienSo ?? '-' }}</span>
                                    <span class="badge bg-light text-dark"><i
                                            class="fa fa-users me-1"></i>{{ $car?->SoGhe ?? '-' }} chỗ</span>
                                    <span class="badge bg-light text-dark"><i
                                            class="fa fa-calendar-alt me-1"></i>{{ $car?->NamSX ?? '-' }}</span>
                                    <span class="badge {{ $statusBadgeClass }}"><i
                                            class="fa fa-flag me-1"></i>{{ $donThue->Trang_Thai }}</span>
                                </div>
                            </div>

                            <div class="col-12">
                                <hr class="my-3">
                                <div class="row g-3">
                                    <div class="col-md-6">
                                        <div class="text-danger mb-1">Thời gian thuê</div>
                                        <div><strong class="text-success">Nhận:</strong> {{ $donThue->Ngay_Bat_Dau }}</div>
                                        <div><strong class="text-primary">Trả:</strong> {{ $donThue->Ngay_Ket_Thuc }}</div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="text-danger mb-1">Chi phí</div>
                                        <div><strong>Tổng tiền:</strong>
                                            <span
                                                class="text-primary fw-bold">{{ number_format((float) $donThue->Tong_Tien) }}
                                                đ</span>
                                        </div>
                                        <div><strong>Tiền cọc:</strong>
                                            <span
                                                class="text-danger fw-bold">{{ number_format((float) $donThue->Tien_Coc) }}
                                                đ</span>
                                            @if ((float) ($donThue->Tien_Coc ?? 0) > 0)
                                                <span class="badge bg-warning text-dark ms-1">Quan trọng</span>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="col-12 d-none"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-lg-5">
                @if ($viewerRole === 'khach')
                    <div class="card shadow-sm border-0 mb-4">
                        <div class="card-header bg-light border-0">
                            <div class="d-flex align-items-center justify-content-between">
                                <h5 class="mb-0 text-danger">Chủ xe</h5>
                                <span class="badge bg-secondary">Liên hệ</span>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="d-flex align-items-center">
                                <img src="{{ $chuXeAvatar }}" alt="Avatar" class="rounded-circle me-3"
                                    style="width: 56px; height: 56px; object-fit: cover;">
                                <div>
                                    <div class="fw-bold text-danger">{{ $chuXe?->Ten_CX ?? '-' }}</div>
                                    <div class="text-muted small">{{ $chuXe?->Email_CX ?? '' }}</div>
                                </div>
                            </div>

                            <hr class="my-3">

                            <div class="small">
                                <div class="mb-2 text-danger"><i class="fa fa-phone me-2"></i>{{ $chuXe?->SoDT_CX ?? '-' }}
                                </div>
                                <div><i class="fa fa-map-marker-alt me-2 text-muted"></i>{{ $chuXe?->DiaChi_CX ?? '-' }}
                                </div>
                            </div>
                        </div>
                    </div>
                @else
                    <div class="card shadow-sm border-0 mb-4">
                        <div class="card-header bg-light border-0">
                            <div class="d-flex align-items-center justify-content-between">
                                <h5 class="mb-0 text-danger">Khách thuê</h5>
                                <span class="badge bg-secondary">Liên hệ</span>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="d-flex align-items-center">
                                <img src="{{ $customerAvatar }}" alt="Avatar" class="rounded-circle me-3"
                                    style="width: 56px; height: 56px; object-fit: cover;">
                                <div>
                                    <div class="fw-bold text-danger">{{ $customer?->Ho_Ten ?? '-' }}</div>
                                    <div class="text-muted small">{{ $customer?->Email ?? '' }}</div>
                                </div>
                            </div>

                            <hr class="my-3">

                            <div class="small">
                                <div class="mb-2 text-danger"><i
                                        class="fa fa-phone me-2"></i>{{ $customer?->So_Dien_Thoai ?? '-' }}</div>
                                <div><i class="fa fa-map-marker-alt me-2 text-muted"></i>{{ $customer?->Dia_Chi ?? '-' }}
                                </div>
                            </div>
                        </div>
                    </div>
                @endif

                <div class="card shadow-sm border-0">
                    <div class="card-header bg-light border-0">
                        <div class="d-flex align-items-center justify-content-between">
                            <h5 class="mb-0 text-danger">Thanh toán</h5>
                            <span class="badge bg-primary">{{ $payments->count() }}</span>
                        </div>
                    </div>
                    <div class="card-body">
                        @if ($payments->count() === 0)
                            <div class="text-muted">Chưa có giao dịch thanh toán.</div>
                        @else
                            <div class="table-responsive">
                                <table class="table table-sm table-striped align-middle mb-0">
                                    <thead>
                                        <tr>
                                            <th>Mã</th>
                                            <th>Loại</th>
                                            <th>Số tiền</th>
                                            <th>Thời gian</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($payments as $p)
                                            @php
                                                $rowClass = match ((string) ($p->Loai_Thanh_Toan ?? '')) {
                                                    'TienCoc' => 'table-warning',
                                                    default => null,
                                                };
                                            @endphp
                                            <tr class="{{ $rowClass }}">
                                                <td>#{{ $p->Ma_TT ?? '-' }}</td>
                                                <td>{{ $p->Loai_Thanh_Toan ?? '-' }}</td>
                                                <td>{{ number_format((float) ($p->So_Tien ?? 0)) }} đ</td>
                                                <td>{{ $p->created_at ?? '-' }}</td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
