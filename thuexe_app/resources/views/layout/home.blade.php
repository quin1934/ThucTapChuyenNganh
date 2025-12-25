<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <title>AUTO CAR - website, ứng dụng cho thuê xe tự lái</title>
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <meta content="" name="keywords">
    <meta content="" name="description">
    <base href="{{ request()->root() }}/">

    <!-- Google Web Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Lato:ital,wght@0,400;0,700;0,900;1,400;1,700;1,900&family=Montserrat:ital,wght@0,100..900;1,100..900&display=swap"
        rel="stylesheet">

    <!-- Icon Font Stylesheet -->
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.15.4/css/all.css" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.4.1/font/bootstrap-icons.css" rel="stylesheet">

    <!-- Libraries Stylesheet -->
    <link href="lib/animate/animate.min.css" rel="stylesheet">
    <link href="lib/owlcarousel/assets/owl.carousel.min.css" rel="stylesheet">


    <!-- Customized Bootstrap Stylesheet -->
    <link href="css/bootstrap.min.css" rel="stylesheet">

    <!-- Template Stylesheet -->
    <link href="css/style.css" rel="stylesheet">
</head>

<body>

    <!-- Spinner Start -->
    <div id="spinner"
        class="show bg-white position-fixed translate-middle w-100 vh-100 top-50 start-50 d-flex align-items-center justify-content-center">
        <div class="spinner-border text-primary" style="width: 3rem; height: 3rem;" role="status">
            <span class="sr-only">Loading...</span>
        </div>
    </div>
    <!-- Spinner End -->

    <!-- Navbar & Hero Start -->
    <div class="container-fluid nav-bar sticky-top px-0 px-lg-4 py-2 py-lg-0">
        <div class="container">
            <nav class="navbar navbar-expand-lg navbar-light">
                <a href="{{ route('home') }}" class="navbar-brand p-0">
                    <h1 class="display-6 text-primary"><i class="fas fa-car-alt me-3"></i></i>AUTO CAR</h1>
                    <!-- <img src="img/logo.png" alt="Logo"> -->
                </a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
                    data-bs-target="#navbarCollapse">
                    <span class="fa fa-bars"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarCollapse">
                    <div class="navbar-nav mx-auto py-0">
                        @if (Auth::guard('chu_xe')->check())
                            <a href="{{ route('partner.orders') }}" class="nav-item nav-link">Đơn Hàng</a>
                            <a href="{{ route('partner.cars') }}" class="nav-item nav-link">Danh Sách Xe</a>
                            <a href="{{ route('contact') }}" class="nav-item nav-link">Đăng Ký Xe Mới</a>
                            <a href="{{ route('team') }}" class="nav-item nav-link">Trung Tâm Hỗ Trợ</a>
                        @else
                            <a href="{{ route('home') }}" class="nav-item nav-link">Trang Chủ</a>
                            <a href="{{ route('about') }}" class="nav-item nav-link">Về Chúng Tôi</a>
                            <a href="{{ route('vehicle') }}" class="nav-item nav-link">Xe Nổi Bật</a>
                            <a href="{{ route('team') }}" class="nav-item nav-link">Trung Tâm Hỗ Trợ</a>
                        @endif
                    </div>
                    <div class="navbar-nav ms-auto py-0">
                        @if (Auth::guard('khach')->check())
                            @php
                                $navUser = Auth::guard('khach')->user();
                                $navAvatarUrl = !empty($navUser?->HinhAnh)
                                    ? asset('uploads/avatars/' . $navUser->HinhAnh)
                                    : null;
                            @endphp
                            <div class="nav-item dropdown">
                                <a href="#" class="nav-link dropdown-toggle" data-bs-toggle="dropdown">
                                    @if (!empty($navAvatarUrl))
                                        <img src="{{ $navAvatarUrl }}" alt="Avatar" class="rounded-circle me-2"
                                            style="width: 32px; height: 32px; object-fit: cover;">
                                    @else
                                        <i class="fa fa-user me-2"></i>
                                    @endif
                                    {{ $navUser->Ho_Ten }}
                                </a>
                                <div class="dropdown-menu m-0">
                                    <a href="{{ route('client.profile') }}" class="dropdown-item">Hồ sơ cá nhân</a>
                                    <a href="{{ route('client.history') }}" class="dropdown-item">Lịch sử thuê xe</a>
                                    <div class="dropdown-divider"></div>
                                    <form action="{{ route('client.logout') }}" method="POST">
                                        @csrf
                                        <button type="submit" class="dropdown-item text-danger">Đăng xuất</button>
                                    </form>
                                </div>
                            </div>

                            {{-- TRƯỜNG HỢP 2: CHỦ XE ĐANG LOGIN --}}
                        @elseif(Auth::guard('chu_xe')->check())
                            @php
                                $navUser = Auth::guard('chu_xe')->user();
                                $navAvatarUrl = !empty($navUser?->HinhAnh)
                                    ? asset('uploads/avatars/partners/' . $navUser->HinhAnh)
                                    : null;
                            @endphp
                            <div class="nav-item dropdown">
                                <a href="#" class="nav-link dropdown-toggle text-danger"
                                    data-bs-toggle="dropdown">
                                    @if (!empty($navAvatarUrl))
                                        <img src="{{ $navAvatarUrl }}" alt="Avatar" class="rounded-circle me-2"
                                            style="width: 32px; height: 32px; object-fit: cover;">
                                    @else
                                        <i class="fa fa-car me-2"></i>
                                    @endif
                                    {{ $navUser->Ten_CX }}
                                </a>
                                <div class="dropdown-menu m-0">
                                    <a href="{{ route('partner.profile') }}" class="dropdown-item">Hồ sơ cá nhân</a>
                                    <a href="{{ route('partner.orders') }}" class="dropdown-item">Đơn hàng</a>
                                    <div class="dropdown-divider"></div>
                                    <form action="{{ route('client.logout') }}" method="POST">
                                        @csrf
                                        <button type="submit" class="dropdown-item text-danger">Đăng xuất</button>
                                    </form>
                                </div>
                            </div>
                        @else
                            <a href="{{ route('client.login') }}" class="btn btn-primary rounded-pill py-2 px-4">Đăng
                                Nhập</a>
                        @endif
                    </div>
                </div>
            </nav>
        </div>
    </div>
    <!-- Navbar & Hero End -->

    @yield('body')
    <!-- Footer Start -->
    <div class="container-fluid footer py-5 mt-5 wow fadeIn" data-wow-delay="0.2s">
        <div class="container py-5">
            <div class="row g-5">
                <div class="col-md-6 col-lg-6 col-xl-3">
                    <div class="footer-item d-flex flex-column">
                        <div class="footer-item">
                            <h4 class="text-white mb-4">Về Chúng Tôi</h4>
                            <p class="mb-3">AUTO CAR là nhà cung cấp dịch vụ cho thuê xe tự lái hàng đầu, mang đến
                                giải pháp di chuyển an toàn, tiện lợi và thông minh. Sứ mệnh của chúng tôi là làm cho
                                công nghệ của tương lai trở nên dễ tiếp cận với mọi người.</p>
                        </div>
                        <div class="position-relative">
                            <input class="form-control rounded-pill w-100 py-3 ps-4 pe-5" type="text"
                                placeholder="Nhập email của bạn">
                            <button type="button"
                                class="btn btn-secondary rounded-pill position-absolute top-0 end-0 py-2 mt-2 me-2">Đăng
                                Ký</button>
                        </div>
                    </div>
                </div>
                <div class="col-md-6 col-lg-6 col-xl-3">
                    <div class="footer-item d-flex flex-column">
                        <h4 class="text-white mb-4">Liên Kết Nhanh</h4>
                        <a href="{{ route('about') }}"><i class="fas fa-angle-right me-2"></i> Về Chúng Tôi</a>
                        <a href="{{ route('vehicle') }}"><i class="fas fa-angle-right me-2"></i> Dòng Xe</a>
                        <a href="{{ route('team') }}"><i class="fas fa-angle-right me-2"></i> Hỗ Trợ Khách Hàng</a>
                        <a href="{{ route('contact') }}"><i class="fas fa-angle-right me-2"></i> Đăng Ký Cho Thuê
                            Xe</a>
                    </div>
                </div>
                <div class="col-md-6 col-lg-6 col-xl-3">
                    <div class="footer-item d-flex flex-column">
                        <h4 class="text-white mb-4">Giờ Làm Việc</h4>
                        <div class="mb-3">
                            <h6 class="text-muted mb-0">Hỗ Trợ Khách Hàng</h6>
                            <p class="text-white mb-0">24/7</p>
                        </div>
                        <div class="mb-3">
                            <h6 class="text-muted mb-0">Giờ Làm Việc Văn Phòng:</h6>
                            <p class="text-white mb-0">Thứ 2 - Thứ 6: 09:00 - 19:00</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-6 col-lg-6 col-xl-3">
                    <div class="footer-item d-flex flex-column">
                        <h4 class="text-white mb-4">Thông Tin Liên Hệ</h4>
                        <a href="#"><i class="fa fa-map-marker-alt me-2"></i>194, Cao Lỗ, Phường 4, Quận 8,
                            Tp.HCM</a>
                        <a href="mailto:info@example.com"><i
                                class="fas fa-envelope me-2"></i>vtttquynh123@gmail.com</a>
                        <a href="tel:+012 345 67890"><i class="fas fa-phone me-2"></i> 0366741245</a>
                        <a href="tel:+012 345 67890" class="mb-3"><i class="fas fa-print me-2"></i> 0366741245</a>
                        <div class="d-flex">
                            <a class="btn btn-secondary btn-md-square rounded-circle me-3"
                                href="https://www.facebook.com"><i class="fab fa-facebook-f text-white"></i></a>
                            <a class="btn btn-secondary btn-md-square rounded-circle me-3" href="https://x.com"><i
                                    class="fab fa-twitter text-white"></i></a>
                            <a class="btn btn-secondary btn-md-square rounded-circle me-3"
                                href="https://www.instagram.com/"><i class="fab fa-instagram text-white"></i></a>
                            <a class="btn btn-secondary btn-md-square rounded-circle me-0"
                                href="https://www.linkedin.com/"><i class="fab fa-linkedin-in text-white"></i></a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Footer End -->

    <!-- Back to Top -->
    <a href="#" class="btn btn-secondary btn-lg-square rounded-circle back-to-top"><i
            class="fa fa-arrow-up"></i></a>


    <!-- JavaScript Libraries -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="lib/wow/wow.min.js"></script>
    <script src="lib/easing/easing.min.js"></script>
    <script src="lib/waypoints/waypoints.min.js"></script>
    <script src="lib/owlcarousel/owl.carousel.min.js"></script>


    <!-- Template Javascript -->
    <script src="js/main.js"></script>
</body>

</html>
