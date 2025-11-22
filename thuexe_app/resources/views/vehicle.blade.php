@extends('layout/home')
@section('body')
<!-- Header Start -->
      <div class="container-fluid bg-breadcrumb mb-5">
        <div class="container text-center py-5" style="max-width: 900px;">
            <h4 class="text-white display-4 mb-4 wow fadeInDown" data-wow-delay="0.1s">Xe Nổi Bật</h4>
            <ol class="breadcrumb d-flex justify-content-center mb-0 wow fadeInDown" data-wow-delay="0.3s">
                <li class="breadcrumb-item"><a href="{{route('home')}}">Trang chủ</a></li>
                <li class="breadcrumb-item active text-primary">Xe nổi bật</li>
            </ol>
        </div>
    </div>
        <!-- Header End -->

        <!-- Car categories Start -->
<div class="container-fluid categories py-5">
    <div class="container">
        <div class="text-center mx-auto pb-5 wow fadeInUp" data-wow-delay="0.1s" style="max-width: 800px;">
            <h1 class="display-5 text-capitalize mb-3">Các Phương Tiện <span class="text-primary">Của Chúng Tôi</span></h1>
            <p class="mb-0">Khám phá bộ sưu tập xe tự lái đa dạng của chúng tôi, từ các dòng sedan linh hoạt, SUV gia đình rộng rãi, đến các mẫu xe điện hiện đại. Mọi phương tiện đều được trang bị công nghệ cao cấp nhất, bảo dưỡng nghiêm ngặt và sẵn sàng mang đến cho bạn một hành trình an toàn và thư thái.
            </p>
        </div>
        <div class="categories-carousel owl-carousel wow fadeInUp" data-wow-delay="0.1s">
            
            <div class="categories-item p-4">
                <div class="categories-item-inner">
                    <div class="categories-img rounded-top">
                        <img src="{{ asset('img/car-1.png') }}" class="img-fluid w-100 rounded-top" alt="">
                    </div>
                    <div class="categories-content rounded-bottom p-4">
                        <h4>Mercedes Benz R3</h4>
                        <div class="categories-review mb-4">
                            <div class="me-3">4.5 Đánh Giá</div>
                            <div class="d-flex justify-content-center text-secondary">
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star text-body"></i>
                            </div>
                        </div>
                        <div class="mb-4">
                            <h4 class="bg-white text-primary rounded-pill py-2 px-4 mb-0">500K/ngày</h4>
                        </div>
                        <div class="row gy-2 gx-0 text-center mb-4">
                            <div class="col-4 border-end border-white">
                                <i class="fa fa-users text-dark"></i> <span class="text-body ms-1">4 Chỗ</span>
                            </div>
                            <div class="col-4 border-end border-white">
                                <i class="fa fa-car text-dark"></i> <span class="text-body ms-1">Số tự động</span>
                            </div>
                            <div class="col-4">
                                <i class="fa fa-gas-pump text-dark"></i> <span class="text-body ms-1">Xăng</span>
                            </div>
                            <div class="col-4 border-end border-white">
                                <i class="fa fa-car text-dark"></i> <span class="text-body ms-1">2015</span>
                            </div>
                            <div class="col-4 border-end border-white">
                                <i class="fa fa-cogs text-dark"></i> <span class="text-body ms-1">2 Chuyến</span>
                            </div>
                            <div class="col-4">
                                <i class="fa fa-road text-dark"></i> <span class="text-body ms-1">27.000 km</span>
                            </div>
                        </div>
                        <a href="{{ route('cardetail') }}" class="btn btn-primary rounded-pill d-flex justify-content-center py-3">Đặt Ngay</a>
                    </div>
                </div>
            </div>

            <div class="categories-item p-4">
                <div class="categories-item-inner">
                    <div class="categories-img rounded-top">
                        <img src="{{ asset('img/car-2.png') }}" class="img-fluid w-100 rounded-top" alt="">
                    </div>
                    <div class="categories-content rounded-bottom p-4">
                        <h4>Toyota Corolla Cross</h4>
                        <div class="categories-review mb-4">
                            <div class="me-3">3.5 Đánh Giá</div>
                            <div class="d-flex justify-content-center text-secondary">
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star text-body"></i>
                            </div>
                        </div>
                        <div class="mb-4">
                            <h4 class="bg-white text-primary rounded-pill py-2 px-4 mb-0">600k/ngày</h4>
                        </div>
                        <div class="row gy-2 gx-0 text-center mb-4">
                            <div class="col-4 border-end border-white">
                                <i class="fa fa-users text-dark"></i> <span class="text-body ms-1">4 Chỗ</span>
                            </div>
                            <div class="col-4 border-end border-white">
                                <i class="fa fa-car text-dark"></i> <span class="text-body ms-1">Số tự động</span>
                            </div>
                            <div class="col-4">
                                <i class="fa fa-gas-pump text-dark"></i> <span class="text-body ms-1">Xăng</span>
                            </div>
                            <div class="col-4 border-end border-white">
                                <i class="fa fa-car text-dark"></i> <span class="text-body ms-1">2025</span>
                            </div>
                            <div class="col-4 border-end border-white">
                                <i class="fa fa-cogs text-dark"></i> <span class="text-body ms-1">5 Chuyến</span>
                            </div>
                            <div class="col-4">
                                <i class="fa fa-road text-dark"></i> <span class="text-body ms-1">20.000 km</span>
                            </div>
                        </div>
                        <a href="#" class="btn btn-primary rounded-pill d-flex justify-content-center py-3">Đặt Ngay</a>
                    </div>
                </div>
            </div>

            <div class="categories-item p-4">
                <div class="categories-item-inner">
                    <div class="categories-img rounded-top">
                        <img src="{{ asset('img/car-3.png') }}" class="img-fluid w-100 rounded-top" alt="">
                    </div>
                    <div class="categories-content rounded-bottom p-4">
                        <h4>Tesla Model S Plaid</h4>
                        <div class="categories-review mb-4">
                            <div class="me-3">3.8 Đánh Giá</div>
                            <div class="d-flex justify-content-center text-secondary">
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star text-body"></i>
                            </div>
                        </div>
                        <div class="mb-4">
                            <h4 class="bg-white text-primary rounded-pill py-2 px-4 mb-0">550k/ngày</h4>
                        </div>
                        <div class="row gy-2 gx-0 text-center mb-4">
                            <div class="col-4 border-end border-white">
                                <i class="fa fa-users text-dark"></i> <span class="text-body ms-1">4 Chỗ</span>
                            </div>
                            <div class="col-4 border-end border-white">
                                <i class="fa fa-car text-dark"></i> <span class="text-body ms-1">Số tự động</span>
                            </div>
                            <div class="col-4">
                                <i class="fa fa-gas-pump text-dark"></i> <span class="text-body ms-1">Điện</span>
                            </div>
                            <div class="col-4 border-end border-white">
                                <i class="fa fa-car text-dark"></i> <span class="text-body ms-1">2025</span>
                            </div>
                            <div class="col-4 border-end border-white">
                                <i class="fa fa-cogs text-dark"></i> <span class="text-body ms-1">7 Chyến</span>
                            </div>
                            <div class="col-4">
                                <i class="fa fa-road text-dark"></i> <span class="text-body ms-1">30.000 km</span>
                            </div>
                        </div>
                        <a href="#" class="btn btn-primary rounded-pill d-flex justify-content-center py-3">Đặt Ngay</a>
                    </div>
                </div>
            </div>

            <div class="categories-item p-4">
                <div class="categories-item-inner">
                    <div class="categories-img rounded-top">
                        <img src="{{ asset('img/car-4.png') }}" class="img-fluid w-100 rounded-top" alt="">
                    </div>
                    <div class="categories-content rounded-bottom p-4">
                        <h4>Hyundai Kona Electric</h4>
                        <div class="categories-review mb-4">
                            <div class="me-3">4.8 Đánh Giá</div>
                            <div class="d-flex justify-content-center text-secondary">
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                            </div>
                        </div>
                        <div class="mb-4">
                            <h4 class="bg-white text-primary rounded-pill py-2 px-4 mb-0">630k/ngày</h4>
                        </div>
                        <div class="row gy-2 gx-0 text-center mb-4">
                            <div class="col-4 border-end border-white">
                                <i class="fa fa-users text-dark"></i> <span class="text-body ms-1">4 Chỗ</span>
                            </div>
                            <div class="col-4 border-end border-white">
                                <i class="fa fa-car text-dark"></i> <span class="text-body ms-1">Số tự động</span>
                            </div>
                            <div class="col-4">
                                <i class="fa fa-gas-pump text-dark"></i> <span class="text-body ms-1">Xăng</span>
                            </div>
                            <div class="col-4 border-end border-white">
                                <i class="fa fa-car text-dark"></i> <span class="text-body ms-1">2022</span>
                            </div>
                            <div class="col-4 border-end border-white">
                                <i class="fa fa-cogs text-dark"></i> <span class="text-body ms-1">5 Chuyến</span>
                            </div>
                            <div class="col-4">
                                <i class="fa fa-road text-dark"></i> <span class="text-body ms-1">27.000 Km</span>
                            </div>
                        </div>
                        <a href="#" class="btn btn-primary rounded-pill d-flex justify-content-center py-3">Đặt Ngay</a>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>
        <!-- Car categories End -->

@endsection