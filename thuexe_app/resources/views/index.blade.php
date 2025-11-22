@extends('layout/home')
@section('body')

<!-- Carousel Start -->
        <div class="header-carousel mb-5">
            <div id="carouselId" class="carousel slide" data-bs-ride="carousel" data-bs-interval="false">
                <ol class="carousel-indicators">
                    <li data-bs-target="#carouselId" data-bs-slide-to="0" class="active" aria-current="true" aria-label="First slide"></li>
                    <li data-bs-target="#carouselId" data-bs-slide-to="1" aria-label="Second slide"></li>
                </ol>
                <div class="carousel-inner" role="listbox">
                    <div class="carousel-item active">
                        <img src="img/carousel-2.jpg" class="img-fluid w-100" alt="First slide"/>
                        <div class="carousel-caption">
                            <div class="container py-4">
                                <div class="row g-5">
                                    <div class="col-lg-6 fadeInLeft animated" data-animation="fadeInLeft" data-delay="1s" style="animation-delay: 1s;">
                                        <div class="bg-secondary rounded p-5">
                                            <h4 class="text-white mb-4">TÌM KIẾM XE THEO YÊU CẦU</h4>
                                            <form>
                                                <div class="row g-3">
                                                    <div class="col-12">
                                                        <select class="form-select" aria-label="Default select example">
                                                             <option selected>Chọn Loại Xe</option>
                                                            <option value="1">Audi</option>
                                                            <option value="2">BMW</option>
                                                            <option value="3">Chevrolet</option>
                                                            <option value="4">Dodge</option>
                                                            <option value="5">Ford</option>
                                                            <option value="6">GMC</option>
                                                            <option value="7">Honda</option>
                                                            <option value="8">Hyundai</option>
                                                            <option value="9">Isuzu</option>
                                                            <option value="10">Isuzu</option>
                                                            <option value="11">Kia</option>
                                                            <option value="12">Maserati</option>
                                                            <option value="13">Mercedes-Benz</option>
                                                            <option value="14">MG</option>
                                                            <option value="15">Mitsubishi</option>
                                                            <option value="16">Nissan</option>
                                                            <option value="17">Peugeot</option>
                                                            <option value="11">Subaru</option>
                                                            <option value="11">Suzuki</option>
                                                            <option value="11">Toyota</option>
                                                            <option value="11">VinFast</option>
                                                            <option value="11">Volkswagen</option>
                                                            <option value="11">Volvo</option>
                                                        </select>
                                                    </div>
                                                    <div class="col-12">
                                                        <div class="input-group">
                                                            <div class="d-flex align-items-center bg-light text-body rounded-start p-2">
                                                                <span class="fas fa-map-marker-alt"></span> <span class="ms-1">Vị Trí Lấy Xe</span>
                                                            </div>
                                                            <input class="form-control" type="text" placeholder="Nhập Thành Phố Hoặc Sân Bay" aria-label="Enter a City or Airport">
                                                        </div>
                                                    </div>
                                                    <div class="col-12">
                                                        <a href="#" class="text-start text-white d-block mb-2">Nhập Vị Trí Trả Xe</a>
                                                        <div class="input-group">
                                                            <div class="d-flex align-items-center bg-light text-body rounded-start p-2">
                                                                <span class="fas fa-map-marker-alt"></span><span class="ms-1">Vị Trí Trả Xe</span>
                                                            </div>
                                                            <input class="form-control" type="text" placeholder="Nhập Thành Phố Hoặc Sân Bay" aria-label="Enter a City or Airport">
                                                        </div>
                                                    </div>
                                                    <div class="col-12">
                                                        <div class="input-group">
                                                            <div class="d-flex align-items-center bg-light text-body rounded-start p-2">
                                                                <span class="fas fa-calendar-alt"></span><span class="ms-1">Thời Gian Lấy</span>
                                                            </div>
                                                            <input class="form-control" type="date">
                                                            <select class="form-select ms-3" aria-label="Default select example">
                                                                <option selected>12:00AM</option>
                                                                <option value="1">1:00AM</option>
                                                                <option value="2">2:00AM</option>
                                                                <option value="3">3:00AM</option>
                                                                <option value="4">4:00AM</option>
                                                                <option value="5">5:00AM</option>
                                                                <option value="6">6:00AM</option>
                                                                <option value="7">7:00AM</option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="col-12">
                                                        <div class="input-group">
                                                            <div class="d-flex align-items-center bg-light text-body rounded-start p-2">
                                                                <span class="fas fa-calendar-alt"></span><span class="ms-1">Thời Gian Trả</span>
                                                            </div>
                                                            <input class="form-control" type="date">
                                                            <select class="form-select ms-3" aria-label="Default select example">
                                                                <option selected>12:00AM</option>
                                                                <option value="1">1:00AM</option>
                                                                <option value="2">2:00AM</option>
                                                                <option value="3">3:00AM</option>
                                                                <option value="4">4:00AM</option>
                                                                <option value="5">5:00AM</option>
                                                                <option value="6">6:00AM</option>
                                                                <option value="7">7:00AM</option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="col-12">
                                                        <button class="btn btn-light w-100 py-2">Đặt Ngay</button>
                                                    </div>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                    <div class="col-lg-6 d-none d-lg-flex fadeInRight animated" data-animation="fadeInRight" data-delay="1s" style="animation-delay: 1s;">
                                        <div class="text-start">
                                            <h1 class="display-5 text-white">Nhận Ngay Khuyến Mãi 15% Cho Lần Đặt Xe Đầu Tiên, Hãy Đặt Ngay Bây Giờ</h1>
                                            <p>Hãy tự thưởng cho mình 1 chuyến đi</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                     <div class="carousel-item">
                        <img src="img/carousel-2.jpg" class="img-fluid w-100" alt="First slide"/>
                        <div class="carousel-caption">
                            <div class="container py-4">
                                <div class="row g-5">
                                    <div class="col-lg-6 fadeInLeft animated" data-animation="fadeInLeft" data-delay="1s" style="animation-delay: 1s;">
                                        <div class="bg-secondary rounded p-5">
                                            <h4 class="text-white mb-4">TÌM KIẾM XE THEO YÊU CẦU</h4>
                                            <form>
                                                <div class="row g-3">
                                                    <div class="col-12">
                                                        <select class="form-select" aria-label="Default select example">
                                                             <option selected>Chọn Loại Xe</option>
                                                            <option value="1">Audi</option>
                                                            <option value="2">BMW</option>
                                                            <option value="3">Chevrolet</option>
                                                            <option value="4">Dodge</option>
                                                            <option value="5">Ford</option>
                                                            <option value="6">GMC</option>
                                                            <option value="7">Honda</option>
                                                            <option value="8">Hyundai</option>
                                                            <option value="9">Isuzu</option>
                                                            <option value="10">Isuzu</option>
                                                            <option value="11">Kia</option>
                                                            <option value="12">Maserati</option>
                                                            <option value="13">Mercedes-Benz</option>
                                                            <option value="14">MG</option>
                                                            <option value="15">Mitsubishi</option>
                                                            <option value="16">Nissan</option>
                                                            <option value="17">Peugeot</option>
                                                            <option value="11">Subaru</option>
                                                            <option value="11">Suzuki</option>
                                                            <option value="11">Toyota</option>
                                                            <option value="11">VinFast</option>
                                                            <option value="11">Volkswagen</option>
                                                            <option value="11">Volvo</option>
                                                        </select>
                                                    </div>
                                                    <div class="col-12">
                                                        <div class="input-group">
                                                            <div class="d-flex align-items-center bg-light text-body rounded-start p-2">
                                                                <span class="fas fa-map-marker-alt"></span> <span class="ms-1">Vị Trí Lấy Xe</span>
                                                            </div>
                                                            <input class="form-control" type="text" placeholder="Nhập Thành Phố Hoặc Sân Bay" aria-label="Enter a City or Airport">
                                                        </div>
                                                    </div>
                                                    <div class="col-12">
                                                        <a href="#" class="text-start text-white d-block mb-2">Nhập Vị Trí Trả Xe</a>
                                                        <div class="input-group">
                                                            <div class="d-flex align-items-center bg-light text-body rounded-start p-2">
                                                                <span class="fas fa-map-marker-alt"></span><span class="ms-1">Vị Trí Trả Xe</span>
                                                            </div>
                                                            <input class="form-control" type="text" placeholder="Nhập Thành Phố Hoặc Sân Bay" aria-label="Enter a City or Airport">
                                                        </div>
                                                    </div>
                                                    <div class="col-12">
                                                        <div class="input-group">
                                                            <div class="d-flex align-items-center bg-light text-body rounded-start p-2">
                                                                <span class="fas fa-calendar-alt"></span><span class="ms-1">Thời Gian Lấy</span>
                                                            </div>
                                                            <input class="form-control" type="date">
                                                            <select class="form-select ms-3" aria-label="Default select example">
                                                                <option selected>12:00AM</option>
                                                                <option value="1">1:00AM</option>
                                                                <option value="2">2:00AM</option>
                                                                <option value="3">3:00AM</option>
                                                                <option value="4">4:00AM</option>
                                                                <option value="5">5:00AM</option>
                                                                <option value="6">6:00AM</option>
                                                                <option value="7">7:00AM</option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="col-12">
                                                        <div class="input-group">
                                                            <div class="d-flex align-items-center bg-light text-body rounded-start p-2">
                                                                <span class="fas fa-calendar-alt"></span><span class="ms-1">Thời Gian Trả</span>
                                                            </div>
                                                            <input class="form-control" type="date">
                                                            <select class="form-select ms-3" aria-label="Default select example">
                                                                <option selected>12:00AM</option>
                                                                <option value="1">1:00AM</option>
                                                                <option value="2">2:00AM</option>
                                                                <option value="3">3:00AM</option>
                                                                <option value="4">4:00AM</option>
                                                                <option value="5">5:00AM</option>
                                                                <option value="6">6:00AM</option>
                                                                <option value="7">7:00AM</option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="col-12">
                                                        <button class="btn btn-light w-100 py-2">Đặt Ngay</button>
                                                    </div>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                    <div class="col-lg-6 d-none d-lg-flex fadeInRight animated" data-animation="fadeInRight" data-delay="1s" style="animation-delay: 1s;">
                                        <div class="text-start">
                                            <h1 class="display-5 text-white">Khuyến Mãi 10% Cho Từng Mẫu Xe, Đặt Ngay Bây Giờ Để Nhận Được Khuyến Mãi</h1>
                                            <p>Hãy tự thưởng cho mình 1 chuyến đi</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Carousel End -->

        <!-- About Start -->
        <div class="container-fluid overflow-hidden about py-5">
            <div class="container">
                <div class="row g-5">
                    <div class="col-xl-6 wow fadeInLeft" data-wow-delay="0.2s">
                        <div class="about-item">
                            <div class="pb-5">
                                <h1 class="display-5 text-capitalize">Giới Thiệu Về <span class="text-primary">Chúng Tôi</span></h1>
                                <p class="mb-0">Chào mừng bạn đến với AUTO CAR, website tiên phong mang đến giải pháp di chuyển thông minh cho tương lai. Chúng tôi chuyên cung cấp dịch vụ cho thuê xe tự lái, ứng dụng công nghệ tiên tiến nhất để mang lại cho bạn trải nghiệm hành trình an toàn, tiện lợi và hoàn toàn tự chủ. Hãy khám phá sự tự do trên mọi nẻo đường cùng chúng tôi!
                                </p>
                            </div>
                            <div class="row g-4">
                                <div class="col-lg-6">
                                    <div class="about-item-inner border p-4">
                                        <div class="about-icon mb-4">
                                            <img src="img/about-icon-1.png" class="img-fluid w-50 h-50" alt="Icon">
                                        </div>
                                        <h5 class="mb-3">Tầm Nhìn Của Chúng Tôi</h5>
                                        <p class="mb-0">Trở thành nền tảng cho thuê xe tự lái hàng đầu, định hình lại tương lai của giao thông đô thị, giúp việc di chuyển trở nên tiện lợi, an toàn và bền vững hơn cho tất cả mọi người.</p>
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="about-item-inner border p-4">
                                        <div class="about-icon mb-4">
                                            <img src="img/about-icon-2.png" class="img-fluid h-50 w-50" alt="Icon">
                                        </div>
                                        <h5 class="mb-3">Sứ Mệnh Của Chúng Tôi</h5>
                                        <p class="mb-0">Cung cấp một dịch vụ cho thuê xe liền mạch và đáng tin cậy. Chúng tôi cam kết tích hợp công nghệ tiên tiến nhất, đảm bảo an toàn tuyệt đối và sự tiện lợi tối đa cho khách hàng..</p>
                                    </div>
                                </div>
                            </div>
                            <p class="text-item my-4">Tại AUTO CAR, chúng tôi tự hào với đội ngũ chuyên gia và kỹ sư đầy tâm huyết. Với nền tảng vững chắc trong ngành công nghệ và dịch vụ ô tô, chúng tôi thấu hiểu sâu sắc nhu cầu của bạn. Chúng tôi cam kết không ngừng đổi mới để mang đến những chiếc xe hiện đại và an toàn nhất.
                            </p>
                            <div class="row g-4">
                                <div class="col-lg-6">
                                    <div class="text-center rounded bg-secondary p-4">
                                        <h1 class="display-6 text-white">5</h1>
                                        <h5 class="text-light mb-0">Năm Kinh Nghiệm</h5>
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="rounded">
                                        <p class="mb-2"><i class="fa fa-check-circle text-primary me-1"></i> Hệ thống xe đa dạng, mới và hiện đại.</p>
                                        <p class="mb-2"><i class="fa fa-check-circle text-primary me-1"></i> Quy trình đặt xe nhanh chóng.</p>
                                        <p class="mb-2"><i class="fa fa-check-circle text-primary me-1"></i> Đội ngũ hỗ trợ nhiệt tình.</p>
                                        <p class="mb-0"><i class="fa fa-check-circle text-primary me-1"></i> Chi phí minh bạch.</p>
                                    </div>
                                </div>
                                <div class="col-lg-5 d-flex align-items-center">
                                    <a href="#" class="btn btn-primary rounded py-3 px-5">Thông Tin Người Sáng Lập</a>
                                </div>
                                <div class="col-lg-7">
                                    <div class="d-flex align-items-center">
                                        <img src="img/attachment-img.jpg" class="img-fluid rounded-circle border border-4 border-secondary" style="width: 100px; height: 100px;" alt="Image">
                                        <div class="ms-4">
                                            <h4>Trần Thị Hổ Mang Chúa</h4>
                                            <p class="mb-0">Công Ty 1 Mình Tôi</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-6 wow fadeInRight" data-wow-delay="0.2s">
                        <div class="about-img">
                            <div class="img-1">
                                <img src="img/about-img.jpg" class="img-fluid rounded h-100 w-100" alt="">
                            </div>
                            <div class="img-2">
                                <img src="img/about-img-1.jpg" class="img-fluid rounded w-100" alt="">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- About End -->

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
                                <img src="img/car-1.png" class="img-fluid w-100 rounded-top" alt="">
                            </div>
                            <div class="categories-content rounded-bottom p-4">
                                <h4>Mercedes Benz R3</h4>
                                <div class="categories-review mb-4">
                                    <div class="me-3">Đánh Giá</div>
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
                                <a href="#" class="btn btn-primary rounded-pill d-flex justify-content-center py-3">Đặt Ngay</a>
                            </div>
                        </div>
                    </div>
                    <div class="categories-item p-4">
                        <div class="categories-item-inner">
                            <div class="categories-img rounded-top">
                                <img src="img/car-2.png" class="img-fluid w-100 rounded-top" alt="">
                            </div>
                            <div class="categories-content rounded-bottom p-4">
                                <h4>Toyota Corolla Cross</h4>
                                <div class="categories-review mb-4">
                                    <div class="me-3">Đánh Giá</div>
                                    <div class="d-flex justify-content-center text-secondary">
                                        <i class="fas fa-star"></i>
                                        <i class="fas fa-star"></i>
                                        <i class="fas fa-star"></i>
                                        <i class="fas fa-star"></i>
                                        <i class="fas fa-star text-body"></i>
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
                    <div class="categories-item p-4">
                        <div class="categories-item-inner">
                            <div class="categories-img rounded-top">
                                <img src="img/car-3.png" class="img-fluid w-100 rounded-top" alt="">
                            </div>
                            <div class="categories-content rounded-bottom p-4">
                                <h4>Tesla Model S Plaid</h4>
                                <div class="categories-review mb-4">
                                    <div class="me-3">Đánh Giá</div>
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
                                <img src="img/car-4.png" class="img-fluid w-100 rounded-top" alt="">
                            </div>
                            <div class="categories-content rounded-bottom p-4">
                                <h4>Hyundai Kona Electric</h4>
                                <div class="categories-review mb-4">
                                    <div class="me-3">Đánh Giá</div>
                                    <div class="d-flex justify-content-center text-secondary">
                                        <i class="fas fa-star"></i>
                                        <i class="fas fa-star"></i>
                                        <i class="fas fa-star"></i>
                                        <i class="fas fa-star"></i>
                                        <i class="fas fa-star"></i>
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
                </div>
            </div>
        </div>
        <!-- Car categories End -->

        <!-- Team Start -->
        <div class="container-fluid team py-5">
            <div class="container">
                <div class="text-center mx-auto pb-5 wow fadeInUp" data-wow-delay="0.1s" style="max-width: 800px;">
                    <h1 class="display-5 text-capitalize mb-3">Trung Tâm <span class="text-primary">Hỗ Trợ </span> Khách Hàng</h1>
                    <p class="mb-0">Sự an toàn và hài lòng của bạn là ưu tiên hàng đầu của chúng tôi. Đội ngũ hỗ trợ chuyên nghiệp luôn túc trực 24/7, sẵn sàng giải đáp mọi thắc mắc về công nghệ tự lái, xử lý yêu cầu đặt xe, hoặc trợ giúp bạn ngay lập tức trong mọi tình huống phát sinh trên hành trình. Hãy yên tâm trải nghiệm, vì chúng tôi luôn đồng hành cùng bạn.
                    </p>
                </div>
                <div class="row g-4">
                    <div class="col-md-6 col-lg-6 col-xl-3 wow fadeInUp" data-wow-delay="0.1s">
                        <div class="team-item p-4 pt-0">
                            <div class="team-img">
                                <img src="img/team-1.jpg" class="img-fluid rounded w-100" alt="Image">
                            </div>
                            <div class="team-content pt-4">
                                <h4>Nguyễn Văn An</h4>
                                <p>Trưởng Nhóm Hỗ Trợ</p>
                                <div class="team-icon d-flex justify-content-center">
                                    <a class="btn btn-square btn-light rounded-circle mx-1" href=""><i class="fab fa-facebook-f"></i></a>
                                    <a class="btn btn-square btn-light rounded-circle mx-1" href=""><i class="fab fa-twitter"></i></a>
                                    <a class="btn btn-square btn-light rounded-circle mx-1" href=""><i class="fab fa-instagram"></i></a>
                                    <a class="btn btn-square btn-light rounded-circle mx-1" href=""><i class="fab fa-linkedin-in"></i></a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6 col-lg-6 col-xl-3 wow fadeInUp" data-wow-delay="0.3s">
                        <div class="team-item p-4 pt-0">
                            <div class="team-img">
                                <img src="img/team-2.jpg" class="img-fluid rounded w-100" alt="Image">
                            </div>
                            <div class="team-content pt-4">
                                <h4>Trần Văn Bình</h4>
                                <p>Chuyên Viên Kỹ Thuật</p>
                                <div class="team-icon d-flex justify-content-center">
                                    <a class="btn btn-square btn-light rounded-circle mx-1" href=""><i class="fab fa-facebook-f"></i></a>
                                    <a class="btn btn-square btn-light rounded-circle mx-1" href=""><i class="fab fa-twitter"></i></a>
                                    <a class="btn btn-square btn-light rounded-circle mx-1" href=""><i class="fab fa-instagram"></i></a>
                                    <a class="btn btn-square btn-light rounded-circle mx-1" href=""><i class="fab fa-linkedin-in"></i></a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6 col-lg-6 col-xl-3 wow fadeInUp" data-wow-delay="0.5s">
                        <div class="team-item p-4 pt-0">
                            <div class="team-img">
                                <img src="img/team-3.jpg" class="img-fluid rounded w-100" alt="Image">
                            </div>
                            <div class="team-content pt-4">
                                <h4>Lê Minh Hùng</h4>
                                <p>Hỗ Trợ Vận Hành</p>
                                <div class="team-icon d-flex justify-content-center">
                                    <a class="btn btn-square btn-light rounded-circle mx-1" href=""><i class="fab fa-facebook-f"></i></a>
                                    <a class="btn btn-square btn-light rounded-circle mx-1" href=""><i class="fab fa-twitter"></i></a>
                                    <a class="btn btn-square btn-light rounded-circle mx-1" href=""><i class="fab fa-instagram"></i></a>
                                    <a class="btn btn-square btn-light rounded-circle mx-1" href=""><i class="fab fa-linkedin-in"></i></a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6 col-lg-6 col-xl-3 wow fadeInUp" data-wow-delay="0.7s">
                        <div class="team-item p-4 pt-0">
                            <div class="team-img">
                                <img src="img/team-4.jpg" class="img-fluid rounded w-100" alt="Image">
                            </div>
                            <div class="team-content pt-4">
                                <h4>Phạm Thu Hà</h4>
                                <p>Chăm Sóc Khách Hàng</p>
                                <div class="team-icon d-flex justify-content-center">
                                    <a class="btn btn-square btn-light rounded-circle mx-1" href=""><i class="fab fa-facebook-f"></i></a>
                                    <a class="btn btn-square btn-light rounded-circle mx-1" href=""><i class="fab fa-twitter"></i></a>
                                    <a class="btn btn-square btn-light rounded-circle mx-1" href=""><i class="fab fa-instagram"></i></a>
                                    <a class="btn btn-square btn-light rounded-circle mx-1" href=""><i class="fab fa-linkedin-in"></i></a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Team End -->
         @endsection
