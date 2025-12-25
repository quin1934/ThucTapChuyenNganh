@extends('layout.home')

@section('body')
    <div class="container-fluid bg-breadcrumb mb-5">
        <div class="container text-center py-5" style="max-width: 900px;">
            <h4 class="text-white display-4 mb-4 wow fadeInDown" data-wow-delay="0.1s">Lịch Sử Thuê Xe</h4>
            <ol class="breadcrumb d-flex justify-content-center mb-0 wow fadeInDown" data-wow-delay="0.3s">
                <li class="breadcrumb-item"><a href="{{ route('home') }}">Trang Chủ</a></li>
                <li class="breadcrumb-item active text-primary">Lịch Sử Thuê Xe</li>
            </ol>
        </div>
    </div>

    <div class="container py-5">
        <div class="row justify-content-center">
            <div class="col-lg-10">
                <div class="card shadow-sm border-0">
                    <div class="card-body p-0">
                        <div class="table-responsive">
                            <table class="table align-middle mb-0">
                                <thead class="bg-white border-bottom">
                                    <tr class="text-uppercase text-muted" style="font-size: 12px; letter-spacing: 0.3px;">
                                        <th class="ps-4" style="min-width: 260px;">Mã Đơn / Xe</th>
                                        <th style="min-width: 220px;">Lịch Trình</th>
                                        <th style="min-width: 140px;">Tổng Tiền</th>
                                        <th style="min-width: 140px;">Trạng Thái</th>
                                        <th class="text-end pe-4" style="min-width: 220px;">Thao Tác</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @php
                                        $orders = $orders ?? collect();
                                    @endphp

                                    @forelse ($orders as $order)
                                        @php
                                            $car = $order->xe;

                                            $carImgUrl = !empty($car?->HinhAnh)
                                                ? \Illuminate\Support\Facades\Storage::url($car->HinhAnh)
                                                : asset('img/car-1.png');

                                            $startAt = $order->Ngay_Bat_Dau
                                                ? \Carbon\Carbon::parse($order->Ngay_Bat_Dau)
                                                : null;
                                            $endAt = $order->Ngay_Ket_Thuc
                                                ? \Carbon\Carbon::parse($order->Ngay_Ket_Thuc)
                                                : null;

                                            $status = $order->Trang_Thai;
                                            $statusLabel = match ($status) {
                                                'ChoDuyet' => 'Chờ duyệt',
                                                'DaDuyet' => 'Chờ đặt cọc',
                                                'DaDatCoc' => 'Đã đặt cọc',
                                                'DangDiChuyen' => 'Đang di chuyển',
                                                'DaGiaoXe' => 'Đang di chuyển',
                                                'DangHoatDong' => 'Đang hoạt động',
                                                'DaTraXe', 'HoanThanh' => 'Hoàn thành',
                                                'DaHuy' => 'Đã hủy',
                                                'QuaHan' => 'Quá hạn',
                                                default => $status,
                                            };

                                            $statusClass = match ($status) {
                                                'ChoDuyet' => 'bg-warning text-dark',
                                                'DaDuyet' => 'bg-info text-dark',
                                                'DaDatCoc' => 'bg-primary',
                                                'DangDiChuyen' => 'bg-info text-dark',
                                                'DaGiaoXe' => 'bg-info text-dark',
                                                'DangHoatDong' => 'bg-primary',
                                                'DaTraXe', 'HoanThanh' => 'bg-success',
                                                'DaHuy' => 'bg-danger',
                                                'QuaHan' => 'bg-dark',
                                                default => 'bg-secondary',
                                            };
                                        @endphp

                                        <tr>
                                            <td class="ps-4">
                                                <div class="text-danger fw-bold">#{{ $order->Ma_DT }}</div>
                                                <div class="d-flex align-items-center mt-2">
                                                    <img src="{{ $carImgUrl }}" alt="{{ $car?->Ten_Xe ?? 'Xe' }}"
                                                        style="width: 56px; height: 36px; object-fit: cover; border-radius: 10px;">
                                                    <div class="ms-3">
                                                        <div class="fw-semibold">{{ $car?->Ten_Xe ?? '-' }}</div>
                                                        @if (!empty($car?->BienSo))
                                                            <div class="text-muted" style="font-size: 13px;">Biển số:
                                                                {{ $car->BienSo }}</div>
                                                        @endif
                                                    </div>
                                                </div>
                                            </td>
                                            <td>
                                                <div class="text-success" style="font-size: 13px;">
                                                    <i class="fa fa-calendar me-1"></i>
                                                    {{ $startAt ? $startAt->format('d/m/Y H:i') : '-' }}
                                                </div>
                                                <div class="text-danger" style="font-size: 13px;">
                                                    <i class="fa fa-calendar me-1"></i>
                                                    {{ $endAt ? $endAt->format('d/m/Y H:i') : '-' }}
                                                </div>
                                            </td>
                                            <td>
                                                <span class="badge rounded-pill bg-light text-dark border px-3 py-2">
                                                    {{ $order->Tong_Tien ? number_format($order->Tong_Tien, 0, ',', '.') . ' đ' : '-' }}
                                                </span>
                                            </td>
                                            <td>
                                                <span class="badge {{ $statusClass }} rounded-pill px-3 py-2">
                                                    {{ $statusLabel }}
                                                </span>
                                            </td>
                                            <td class="text-end pe-4">
                                                <a class="btn btn-outline-secondary btn-sm me-2"
                                                    href="{{ route('client.booking-detail', $order->Ma_DT) }}"
                                                    title="Xem chi tiết đơn">
                                                    <i class="fa fa-eye"></i>
                                                </a>

                                                @if ($order->Trang_Thai === 'DaDuyet')
                                                    <a class="btn btn-outline-primary btn-sm"
                                                        href="{{ route('client.deposit.page', $order->Ma_DT) }}"
                                                        title="Thanh toán đặt cọc">
                                                        <i class="fa fa-credit-card"></i>
                                                    </a>
                                                @elseif ($order->Trang_Thai === 'DaDatCoc')
                                                    <form method="POST"
                                                        action="{{ route('client.received', $order->Ma_DT) }}"
                                                        class="d-inline">
                                                        @csrf
                                                        <button class="btn btn-success btn-sm" type="submit"
                                                            onclick="return confirm('Xác nhận bạn đã nhận xe cho đơn #{{ $order->Ma_DT }}?')">
                                                            Đã nhận xe
                                                        </button>
                                                    </form>
                                                @elseif ($order->Trang_Thai === 'DangDiChuyen' || $order->Trang_Thai === 'DaGiaoXe')
                                                    <form method="POST"
                                                        action="{{ route('client.return', $order->Ma_DT) }}"
                                                        class="d-inline">
                                                        @csrf
                                                        <button class="btn btn-outline-danger btn-sm" type="submit"
                                                            onclick="return confirm('Xác nhận trả xe cho đơn #{{ $order->Ma_DT }}?')">
                                                            Trả xe
                                                        </button>
                                                    </form>
                                                @elseif ($order->Trang_Thai === 'HoanThanh')
                                                    <button class="btn btn-success btn-sm" type="button" disabled>
                                                        Hoàn thành
                                                    </button>
                                                @else
                                                    <button class="btn btn-light btn-sm border text-danger" type="button"
                                                        disabled>
                                                        ---
                                                    </button>
                                                @endif
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="5" class="text-center py-5">
                                                <div class="text-muted mb-3">
                                                    <i class="fa fa-history" style="font-size: 44px;"></i>
                                                </div>
                                                <div class="text-muted mb-3">Bạn chưa thực hiện chuyến đi nào.</div>
                                                <a href="{{ route('vehicle') }}" class="btn btn-danger px-4">Tìm xe
                                                    ngay</a>
                                            </td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

                @if (isset($orders) && method_exists($orders, 'links'))
                    <div class="d-flex justify-content-center mt-4">
                        {{ $orders->links() }}
                    </div>
                @endif
            </div>
        </div>
    </div>
@endsection
