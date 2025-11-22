@extends('layout/home')
@section('body')

<div class="container-fluid bg-breadcrumb mb-5">
    <div class="container text-center py-5" style="max-width: 900px;">
        <h4 class="text-white display-4 mb-4 wow fadeInDown" data-wow-delay="0.1s">{{ $car->name ?? 'Chi Tiết Xe' }}</h4>
        
        <ol class="breadcrumb d-flex justify-content-center mb-0 wow fadeInDown" data-wow-delay="0.3s">
            <li class="breadcrumb-item"><a href="{{ route('home') }}">Trang chủ</a></li>
            
            <li class="breadcrumb-item"><a href="{{ route('vehicle') }}">Xe nổi bật</a></li>
            
            <li class="breadcrumb-item active text-primary">Chi tiết</li>
        </ol>
    </div>
</div> 
<div class="container-fluid py-5">
    <div class="container">
        <div class="row g-5">
            <div class="col-lg-8">
                <div class="mb-5 wow fadeInUp" data-wow-delay="0.1s">
                    @if(isset($car) && $car->image)
                        <img src="{{ asset('img/' . $car->image) }}" class="img-fluid w-100 rounded" alt="{{ $car->name }}">
                        
                        @else
                        <img src="{{ asset('img/default-car.png') }}" class="img-fluid w-100 rounded" alt="Hình ảnh xe mặc định">
                    @endif
                </div>

                <div class="mb-5 wow fadeInUp" data-wow-delay="0.3s">
                    <h2 class="display-6 text-primary mb-3">name</h2>
                    <h4 class="mb-4">Mô Tả Chi Tiết</h4>
                    <p>{{ $car->description ?? 'Thông tin mô tả đang được cập nhật.' }}</p>

                    <h4 class="mt-5 mb-3">Các Tính Năng Nổi Bật</h4>
                    <ul class="list-unstyled">
                        <li class="mb-2"><i class="fa fa-check text-primary me-2"></i> Hệ thống an toàn chủ động (ABS, EBD)</li>
                        <li class="mb-2"><i class="fa fa-check text-primary me-2"></i> Camera lùi và cảm biến đỗ xe</li>
                        <li class="mb-2"><i class="fa fa-check text-primary me-2"></i> Kết nối Apple CarPlay / Android Auto</li>
                        <li class="mb-2"><i class="fa fa-check text-primary me-2"></i> Ghế da cao cấp và điều hòa tự động</li>
                    </ul>
                </div>
            </div>

            <div class="col-lg-4">
                <div class="wow fadeInUp" data-wow-delay="0.5s">
                    <div class="bg-light rounded p-4 mb-4">
                        <h3 class="text-center text-primary mb-4">Giá Thuê</h3>
                        <div class="d-flex justify-content-center align-items-center mb-4">
                            <h1 class="display-5 text-dark fw-bold mb-0 me-2">{{ $car->price_per_day ?? 'Liên hệ' }}K</h1>
                            <p class="mb-0 fs-5 text-muted">/ ngày</p>
                        </div>

                        <a href="#" class="btn btn-primary rounded-pill w-100 py-3 text-uppercase fw-bold">
                            ĐẶT XE NGAY
                        </a>
                    </div>

                    <div class="bg-light rounded p-4 mb-4">
                        <h4 class="text-center text-primary mb-4">Thông Số Kỹ Thuật</h4>
                        <ul class="list-group list-group-flush">
                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                <span class="fw-bold"><i class="fa fa-users text-primary me-2"></i> Số Chỗ Ngồi:</span>
                                <span>{{ $car->seats ?? '5 chỗ' }}</span>
                            </li>
                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                <span class="fw-bold"><i class="fa fa-car text-primary me-2"></i> Hộp Số:</span>
                                <span>{{ $car->gearbox ?? 'Số tự động' }}</span>
                            </li>
                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                <span class="fw-bold"><i class="fa fa-gas-pump text-primary me-2"></i> Nhiên Liệu:</span>
                                <span>{{ $car->fuel_type ?? 'Xăng' }}</span>
                            </li>
                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                <span class="fw-bold"><i class="fa fa-calendar-alt text-primary me-2"></i> Năm Sản Xuất:</span>
                                <span>{{ $car->year ?? '2023' }}</span>
                            </li>
                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                <span class="fw-bold"><i class="fa fa-road text-primary me-2"></i> Số ODO:</span>
                                <span>{{ $car->mileage ?? '20.000 km' }}</span>
                            </li>
                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                <span class="fw-bold"><i class="fa fa-cogs text-primary me-2"></i> Công Suất:</span>
                                <span>{{ $car->power ?? '150 Mã lực' }}</span>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
    @endsection