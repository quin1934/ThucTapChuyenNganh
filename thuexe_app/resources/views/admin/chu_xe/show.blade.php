@extends('layout.admin')
@section('body')
    <div class="container-fluid">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Trang Chủ</a></li>
            <li class="breadcrumb-item active"><a href="{{ route('chu-xe.index') }}">Quản Lý Chủ Xe</a></li>
            <li class="breadcrumb-item active">Chi Tiết Chủ Xe <span class="text-danger">{{ $chuXe->Ten_CX }}</span></li>
        </ol>
        <div class="d-flex justify-content-end align-items-center mb-4">
            <a href="{{ route('chu-xe.index') }}" class="btn btn-secondary"><i class="fa fa-arrow-left"></i> Quay lại</a>
        </div>

        <div class="row">
            <div class="col-xl-4 col-md-5 mb-4">
                <div class="card shadow h-100 border-left-primary">
                    <div class="card-header bg-primary font-weight-bold text-white">
                        Thông Tin Cá Nhân & Tài Khoản
                    </div>
                    <div class="card-body">
                        <p><strong>Họ Tên:</strong> {{ $chuXe->Ten_CX }}</p>
                        <p><strong>Email (Login):</strong> {{ $chuXe->Email_CX }}</p>
                        <p><strong>Số Điện Thoại:</strong> {{ $chuXe->SoDT_CX }}</p>
                        <p><strong>Địa Chỉ:</strong> {{ $chuXe->DiaChi_CX ?? '---' }}</p>
                        <hr>
                        <p><strong>Số TK Ngân Hàng:</strong> <br>
                            <span class="text-success font-weight-bold">{{ $chuXe->SoTKNH_CX ?? 'Chưa cập nhật' }}</span>
                        </p>
                        <p><strong>Trạng Thái:</strong>
                            @if ($chuXe->Trang_Thai == 'DaDuyet')
                                <span class="badge badge-success">Đang hoạt động</span>
                            @elseif($chuXe->Trang_Thai == 'Khoa')
                                <span class="badge badge-danger">Đã khóa</span>
                            @else
                                <span class="badge badge-warning">Chờ duyệt</span>
                            @endif
                        </p>
                    </div>
                </div>
            </div>

            <div class="col-xl-8 col-md-7 mb-4">
                <div class="card shadow h-100">
                    <div class="card-header bg-primary text-white font-weight-bold">
                        Danh Sách Xe Đang Sở Hữu ({{ $chuXe->xes->count() }})
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-bordered table-sm">
                                <thead class="thead-light">
                                    <tr>
                                        <th>Tên Xe</th>
                                        <th>Biển Số</th>
                                        <th>Giá Thuê</th>
                                        <th>Trạng Thái</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($chuXe->xes as $xe)
                                        <tr>
                                            <td>{{ $xe->Ten_Xe }}</td>
                                            <td><span class="badge badge-dark">{{ $xe->BienSo }}</span></td>
                                            <td class="text-danger font-weight-bold">{{ number_format($xe->Gia_Thue) }}đ
                                            </td>
                                            <td>
                                                @if ($xe->Trang_Thai == 'SanSang')
                                                    <span class="badge badge-success">Sẵn sàng</span>
                                                @elseif($xe->Trang_Thai == 'DangThue')
                                                    <span class="badge badge-primary">Đang thuê</span>
                                                @else
                                                    <span class="badge badge-secondary">Bảo trì/Ẩn</span>
                                                @endif
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="4" class="text-center text-muted py-3">Chủ xe này chưa đăng ký
                                                chiếc xe nào.</td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
