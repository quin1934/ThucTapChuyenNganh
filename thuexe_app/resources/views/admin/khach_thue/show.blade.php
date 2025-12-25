@extends('layout.admin')
@section('body')
    <div class="container-fluid">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Trang Chủ</a></li>
            <li class="breadcrumb-item active"><a href="{{ route('khach-thue.index') }}">Quản Lý Khách Thuê</a></li>
            <li class="breadcrumb-item active">Xem Chi Tiết Khách Thuê <span class="text-danger">{{ $khach->Ho_Ten }}</span>
            </li>
        </ol>
        <div class="d-flex justify-content-end align-items-center mb-4">
            <a href="{{ route('khach-thue.index') }}" class="btn btn-secondary"><i class="fa fa-arrow-left"></i> Quay lại</a>
        </div>

        <div class="row">
            <div class="col-xl-4 col-md-6 mb-4">
                <div class="card shadow h-100 py-2 border-left-primary">
                    <div class="card-body">
                        <h5 class="font-weight-bold text-primary mb-3">Thông tin liên hệ</h5>
                        <p><i class="fa fa-phone fa-fw"></i> <strong>SĐT:</strong> {{ $khach->So_Dien_Thoai }}</p>
                        <p><i class="fa fa-envelope fa-fw"></i> <strong>Email:</strong> {{ $khach->Email ?? '---' }}</p>
                        <p><i class="fa fa-id-card fa-fw"></i> <strong>CCCD:</strong> {{ $khach->CCCD ?? '---' }}</p>
                        <p><i class="fa fa-map-marker-alt fa-fw"></i> <strong>Đ/C:</strong> {{ $khach->Dia_Chi ?? '---' }}
                        </p>
                    </div>
                </div>
            </div>

            <div class="col-xl-8 col-md-6 mb-4">
                <div class="card shadow h-100 border-left-success">
                    <div class="card-body">
                        <h5 class="font-weight-bold text-success mb-3">Giấy Phép Lái Xe</h5>
                        <div class="row">
                            <div class="col-md-6">
                                <p><strong>Số GPLX:</strong> {{ $khach->So_GPLX ?? '---' }}</p>
                                <p><strong>Hạng:</strong> {{ $khach->Hang_Bang_Lai ?? '---' }}</p>
                                <p><strong>Ngày cấp:</strong>
                                    {{ $khach->Ngay_Cap_GPLX ? \Carbon\Carbon::parse($khach->Ngay_Cap_GPLX)->format('d/m/Y') : '---' }}
                                </p>
                                <p><strong>Hết hạn:</strong>
                                    @if ($khach->Ngay_Het_Han_GPLX)
                                        {{ \Carbon\Carbon::parse($khach->Ngay_Het_Han_GPLX)->format('d/m/Y') }}
                                        @if (\Carbon\Carbon::parse($khach->Ngay_Het_Han_GPLX)->isPast())
                                            <span class="badge badge-danger">Đã hết hạn</span>
                                        @endif
                                    @else
                                        ---
                                    @endif
                                </p>
                            </div>
                            <div class="col-md-6">
                                <div class="row">
                                    <div class="col-6">
                                        <small>Mặt trước</small><br>
                                        @if ($khach->Anh_Bang_Lai_Truoc)
                                            @php
                                                $gplxTruoc = str_contains($khach->Anh_Bang_Lai_Truoc, '/')
                                                    ? asset('storage/' . $khach->Anh_Bang_Lai_Truoc)
                                                    : asset('uploads/gplx/' . $khach->Anh_Bang_Lai_Truoc);
                                            @endphp
                                            <img src="{{ $gplxTruoc }}" class="img-fluid rounded border">
                                        @else
                                            <span>(Trống)</span>
                                        @endif
                                    </div>
                                    <div class="col-6">
                                        <small>Mặt sau</small><br>
                                        @if ($khach->Anh_Bang_Lai_Sau)
                                            @php
                                                $gplxSau = str_contains($khach->Anh_Bang_Lai_Sau, '/')
                                                    ? asset('storage/' . $khach->Anh_Bang_Lai_Sau)
                                                    : asset('uploads/gplx/' . $khach->Anh_Bang_Lai_Sau);
                                            @endphp
                                            <img src="{{ $gplxSau }}" class="img-fluid rounded border">
                                        @else
                                            <span>(Trống)</span>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
