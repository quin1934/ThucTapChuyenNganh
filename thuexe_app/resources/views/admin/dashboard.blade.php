@extends('layout.admin')

@section('body')
    <div class="container-fluid">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Trang Chủ</a></li>
            <li class="breadcrumb-item active">Bảng Điều Khiển Trung Tâm</li>
        </ol>

        <div class="row">
            <div class="col-xl-3 col-sm-6 mb-3">
                <div class="card text-white bg-primary o-hidden h-100">
                    <div class="card-body">
                        <div class="card-body-icon"><i class="fa fa-fw fa-car"></i></div>
                        <div class="mr-5" style="font-size: 20px; font-weight: bold;">{{ $totalCars }} Xe</div>
                        <div class="small">Tổng phương tiện hiện có</div>
                    </div>
                    <a class="card-footer text-white clearfix small z-1" href="{{ route('xe.index') }}">
                        <span class="float-left">Xem chi tiết</span>
                        <span class="float-right"><i class="fa fa-angle-right"></i></span>
                    </a>
                </div>
            </div>

            <div class="col-xl-3 col-sm-6 mb-3">
                <div class="card text-white bg-warning o-hidden h-100">
                    <div class="card-body">
                        <div class="card-body-icon"><i class="fa fa-fw fa-file-text"></i></div>
                        <div class="mr-5" style="font-size: 20px; font-weight: bold;">{{ $pendingOrders }} Đơn Mới</div>
                        <div class="small">Đơn hàng cần duyệt ngay</div>
                    </div>
                    <a class="card-footer text-white clearfix small z-1" href="{{ route('don-thue.index') }}">
                        <span class="float-left">Xử lý ngay</span>
                        <span class="float-right"><i class="fa fa-angle-right"></i></span>
                    </a>
                </div>
            </div>

            <div class="col-xl-3 col-sm-6 mb-3">
                <div class="card text-white bg-success o-hidden h-100">
                    <div class="card-body">
                        <div class="card-body-icon"><i class="fa fa-fw fa-money"></i></div>
                        <div class="mr-5" style="font-size: 18px; font-weight: bold;">
                            {{ number_format($currentMonthRevenue) }} đ</div>
                        <div class="small">Doanh thu ước tính tháng này</div>
                    </div>
                    {{-- Kiểm tra route thanh-toan có tồn tại không để tránh lỗi --}}
                    <a class="card-footer text-white clearfix small z-1"
                        href="{{ Route::has('thanh-toan.index') ? route('thanh-toan.index') : '#' }}">
                        <span class="float-left">Xem báo cáo</span>
                        <span class="float-right"><i class="fa fa-angle-right"></i></span>
                    </a>
                </div>
            </div>

            <div class="col-xl-3 col-sm-6 mb-3">
                <div class="card text-white bg-danger o-hidden h-100">
                    <div class="card-body">
                        <div class="card-body-icon"><i class="fa fa-fw fa-users"></i></div>
                        <div class="mr-5" style="font-size: 20px; font-weight: bold;">{{ $totalCustomers }} Khách</div>
                        <div class="small">Thành viên đăng ký hệ thống</div>
                    </div>
                    <a class="card-footer text-white clearfix small z-1" href="{{ route('khach-thue.index') }}">
                        <span class="float-left">Quản lý user</span>
                        <span class="float-right"><i class="fa fa-angle-right"></i></span>
                    </a>
                </div>
            </div>
        </div>

        <div class="card mb-3">
            <div class="card-header m-0 font-weight-bold text-primary">
                Đơn Đặt Xe Mới Nhất ({{ $recentOrders->total() }})
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered table-hover" id="dataTable" width="100%" cellspacing="0">
                        <thead class="thead-light">
                            <tr>
                                <th>Mã Đơn</th>
                                <th>Khách Hàng</th>
                                <th>Xe Thuê</th>
                                <th>Ngày Nhận - Trả</th>
                                <th>Tổng Tiền</th>
                                <th>Trạng Thái</th>
                                <th>Hành Động</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($recentOrders as $order)
                                <tr>
                                    <td class="font-weight-bold">#{{ $order->Ma_DT }}</td>

                                    <td>{{ $order->khachThue->Ho_Ten ?? '---' }}</td>

                                    <td>
                                        {{ $order->xe->Ten_Xe ?? 'Xe đã xóa' }}
                                        <br>
                                        <small class="text-muted">{{ $order->xe->BienSo ?? '' }}</small>
                                    </td>

                                    <td style="font-size: 14px">
                                        <div><i class="fa fa-calendar-check text-success"></i>Từ:
                                            {{ \Carbon\Carbon::parse($order->Ngay_Bat_Dau)->format('d/m/Y H:i') }}</div>
                                        <div><i class="fa fa-calendar-times text-danger"></i>Đến:
                                            {{ \Carbon\Carbon::parse($order->Ngay_Ket_Thuc)->format('d/m/Y H:i') }}</div>
                                    </td>

                                    <td class="text-danger font-weight-bold">
                                        {{ number_format($order->Tong_Tien) }} đ
                                    </td>

                                    <td class="text-center">
                                        @if ($order->Trang_Thai == 'ChoDuyet')
                                            <span class="badge badge-warning p-2">⏳ Chờ duyệt</span>
                                        @elseif($order->Trang_Thai == 'DaDuyet')
                                            <span class="badge badge-info p-2">✅ Đã duyệt</span>
                                        @elseif($order->Trang_Thai == 'DaDatCoc')
                                            <span class="badge badge-primary p-2">💰 Đã cọc</span>
                                        @elseif($order->Trang_Thai == 'DangDiChuyen' || $order->Trang_Thai == 'DaGiaoXe')
                                            <span class="badge badge-info p-2">🚗 Đang di chuyển</span>
                                        @elseif($order->Trang_Thai == 'DangHoatDong')
                                            <span class="badge badge-success p-2">🚗 Đang thuê</span>
                                        @elseif($order->Trang_Thai == 'DaTraXe' || $order->Trang_Thai == 'HoanThanh')
                                            <span class="badge badge-secondary p-2">🏁 Hoàn thành</span>
                                        @elseif($order->Trang_Thai == 'QuaHan')
                                            <span class="badge badge-dark p-2">⏰ Quá hạn</span>
                                        @elseif($order->Trang_Thai == 'DaHuy')
                                            <span class="badge badge-danger p-2">❌ Đã Hủy</span>
                                        @else
                                            <span class="badge badge-light border p-2">{{ $order->Trang_Thai }}</span>
                                        @endif
                                    </td>

                                    <td class="text-center">
                                        <a href="{{ route('don-thue.show', $order->Ma_DT) }}"
                                            class="btn btn-sm btn-success" title="Xem chi tiết">
                                            <i class="fa fa-eye"></i>
                                        </a>

                                        @if ($order->Trang_Thai == 'ChoDuyet')
                                            <form action="{{ route('don-thue.update', $order->Ma_DT) }}" method="POST"
                                                style="display:inline-block">
                                                @csrf @method('PUT')
                                                <input type="hidden" name="Trang_Thai" value="DaDuyet">
                                                <button type="submit" class="btn btn-sm btn-success" title="Duyệt đơn này">
                                                    <i class="fa fa-check"></i>
                                                </button>
                                            </form>
                                        @endif
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="7" class="text-center text-muted py-4">
                                        Chưa có đơn đặt xe nào trong hệ thống.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="card-footer small text-muted">Cập nhật lúc: {{ date('H:i d/m/Y') }}</div>
        </div>
    </div>
@endsection
