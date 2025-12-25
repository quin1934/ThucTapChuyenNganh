@extends('layout.admin')

@section('body')
    <div class="container-fluid">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Trang Chủ</a></li>
            <li class="breadcrumb-item active"><a href="{{ route('xe.index') }}">Quản Lý Xe</a></li>
            <li class="breadcrumb-item active">Chi tiết xe <span class="text-danger">{{ $xe->BienSo }}</span></li>
        </ol>
        <div class="d-flex justify-content-end align-items-center mb-4">
            <a href="{{ route('xe.index') }}" class="btn btn-secondary"><i class="fa fa-arrow-left"></i> Quay lại</a>
        </div>

        <div class="row">
            <div class="col-md-4">
                <div class="card shadow mb-4">
                    <div class="card-header py-3">
                        <h6 class="m-0 font-weight-bold text-primary">Hình ảnh & Trạng thái</h6>
                    </div>
                    <div class="card-body text-center">
                        @if ($xe->HinhAnh)
                            <img src="{{ asset('storage/' . $xe->HinhAnh) }}" class="img-fluid rounded mb-3" alt="Hình xe">
                        @else
                            <div class="bg-secondary text-white d-flex align-items-center justify-content-center rounded mb-3"
                                style="height: 200px;">
                                <i class="fa fa-car fa-3x"></i> <span class="ml-2">Không có ảnh</span>
                            </div>
                        @endif

                        <div class="mb-3">
                            @if ($xe->TrangThai_Xe == 'SanSang')
                                <span class="badge badge-success p-2 w-100">Sẵn sàng hoạt động</span>
                            @elseif($xe->TrangThai_Xe == 'DangThue')
                                <span class="badge badge-primary p-2 w-100">Đang được thuê</span>
                            @elseif($xe->TrangThai_Xe == 'BaoTri')
                                <span class="badge badge-secondary p-2 w-100">Đang bảo trì</span>
                            @elseif($xe->TrangThai_Xe == 'BiCam')
                                <span class="badge badge-danger p-2 w-100">Đang bị cấm</span>
                            @else
                                <span class="badge badge-light border p-2 w-100">{{ $xe->TrangThai_Xe }}</span>
                            @endif
                        </div>

                        <ul class="list-group list-group-flush text-left">
                            <li class="list-group-item"><strong>Tên xe:</strong> {{ $xe->Ten_Xe }}</li>
                            <li class="list-group-item"><strong>Loại xe:</strong> {{ $xe->phanLoaiXe->Ten_PLXe ?? 'N/A' }}
                            </li>
                            <li class="list-group-item"><strong>Năm SX:</strong> {{ $xe->NamSX }}</li>
                            <li class="list-group-item"><strong>Số ghế:</strong> {{ $xe->SoGhe }} chỗ</li>
                        </ul>
                    </div>
                </div>
            </div>

            <div class="col-md-8">
                <div class="card shadow mb-4">
                    <div class="card-header py-3">
                        <h6 class="m-0 font-weight-bold text-success">Thông tin chủ xe (Đối tác)</h6>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6">
                                <p><strong>Họ tên:</strong> {{ $xe->chuXe->Ten_CX ?? 'Chưa cập nhật' }}</p>
                                <p><strong>Số ĐT:</strong> {{ $xe->chuXe->SoDT_CX ?? '---' }}</p>
                            </div>
                            <div class="col-md-6">
                                <p><strong>Email:</strong> {{ $xe->chuXe->Email_CX ?? '---' }}</p>
                                <p><strong>Địa chỉ:</strong> {{ $xe->chuXe->DiaChi_CX ?? '---' }}</p>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="card shadow mb-4">
                    <div class="card-header py-3">
                        <h6 class="m-0 font-weight-bold text-info">Thông số kỹ thuật</h6>
                    </div>
                    <div class="card-body">
                        <table class="table table-striped">
                            <tr>
                                <th width="200">Hộp số:</th>
                                <td>
                                    <span class="badge badge-primary">
                                        {{ optional(optional($xe->thongSo)->hopSo)->Ten_DM ?? 'Chưa cập nhật' }}
                                    </span>
                                </td>
                            </tr>
                            <tr>
                                <th>Nhiên liệu:</th>
                                <td>
                                    <span class="badge badge-success">
                                        {{ optional(optional($xe->thongSo)->nhienLieu)->Ten_DM ?? 'Chưa cập nhật' }}
                                    </span>
                                </td>
                            </tr>
                            <tr>
                                <th>Công suất:</th>
                                <td>{{ $xe->thongSo->Cong_Xuat ?? 'N/A' }}</td>
                            </tr>
                            <tr>
                                <th>Mức tiêu thụ:</th>
                                <td>{{ $xe->thongSo->MucTieuThu ?? 'N/A' }}</td>
                            </tr>
                        </table>
                    </div>
                </div>

                <div class="card shadow mb-4">
                    <div class="card-header py-3">
                        <h6 class="m-0 font-weight-bold text-warning">Tiện ích & Mô tả</h6>
                    </div>
                    <div class="card-body">
                        <p><strong>Các tiện ích được trang bị:</strong></p>
                        <div class="mb-3">
                            @forelse($xe->tienIches as $ti)
                                <span class="badge badge-pill badge-info p-2 mr-2 mb-2">
                                    <i class="fa fa-check-circle"></i> {{ $ti->Ten_TI }}
                                </span>
                            @empty
                                <p class="text-muted font-italic">Không có tiện ích đi kèm.</p>
                            @endforelse
                        </div>

                        <hr>
                        <p><strong>Mô tả chi tiết:</strong></p>
                        <div class="bg-light p-3 rounded">
                            {{ $xe->MoTa_Xe ?: 'Chưa có mô tả nào cho xe này.' }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
