@extends('layout.admin')

@section('body')
<div class="container-fluid">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="#">Quản Trị</a></li>
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
                    <div class="mr-5" style="font-size: 18px; font-weight: bold;">{{ number_format($currentMonthRevenue) }} đ</div>
                    <div class="small">Doanh thu ước tính tháng này</div>
                </div>
                <a class="card-footer text-white clearfix small z-1" href="{{ route('thanh-toan.index') }}">
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
        <div class="card-header">
            <i class="fa fa-table"></i> Đơn Đặt Xe Mới Nhất (Chưa Xử Lý)
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
                            <td class="font-weight-bold">#{{ $order->Ma_Don }}</td>
                            
                            <td>{{ $order->khachThue->Ten_KT ?? 'Khách vãng lai' }}</td>
                            
                            <td>{{ $order->xe->Ten_Xe ?? 'Xe không xác định' }}</td>
                            
                            <td style="font-size: 14px">
                                {{ \Carbon\Carbon::parse($order->NgayBD)->format('d/m') }} - 
                                {{ \Carbon\Carbon::parse($order->NgayKT)->format('d/m/Y') }}
                            </td>
                            
                            <td class="text-danger font-weight-bold">
                                {{ number_format($order->TongTien) }} đ
                            </td>
                            
                            <td class="text-center">
                                @if($order->TrangThai_Don == 'ChoDuyet')
                                    <span class="badge badge-warning p-2">Chờ duyệt</span>
                                @elseif($order->TrangThai_Don == 'DaDuyet')
                                    <span class="badge badge-success p-2">Đang thuê</span>
                                @elseif($order->TrangThai_Don == 'HoanThanh')
                                    <span class="badge badge-secondary p-2">Hoàn thành</span>
                                @else
                                    <span class="badge badge-danger p-2">Đã Hủy</span>
                                @endif
                            </td>
                            
                            <td>
                                @if($order->TrangThai_Don == 'ChoDuyet')
                                    <a href="#" class="btn btn-sm btn-primary">Duyệt</a>
                                    <a href="#" class="btn btn-sm btn-danger">Hủy</a>
                                @else
                                    <a href="#" class="btn btn-sm btn-info">Chi tiết</a>
                                @endif
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="7" class="text-center text-muted py-4">
                                Chưa có đơn đặt xe nào.
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