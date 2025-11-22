@extends('layout/home')
@section('body')
<!-- Header Start -->
        <div class="container-fluid bg-breadcrumb mb-5">
        <div class="container text-center py-5" style="max-width: 900px;">
            <h4 class="text-white display-4 mb-4 wow fadeInDown" data-wow-delay="0.1s">Hỗ Trợ Khách Hàng</h4>
            <ol class="breadcrumb d-flex justify-content-center mb-0 wow fadeInDown" data-wow-delay="0.3s">
                <li class="breadcrumb-item"><a href="{{route('home')}}">Trang Chủ</a></li>
                <li class="breadcrumb-item active text-primary">Về Chúng Tôi</li>
            </ol>
        </div>
    </div>
        <!-- Header End -->

        <!-- Team Start -->
        <div class="container-fluid team py-5">
    <div class="container">
        <div class="text-center mx-auto pb-5 wow fadeInUp" data-wow-delay="0.1s" style="max-width: 800px;">
            <h1 class="display-5 text-capitalize mb-3">Trung Tâm <span class="text-primary">Hỗ Trợ </span>Khách Hàng</h1>
            <p class="mb-0">Sự an toàn và hài lòng của bạn là ưu tiên hàng đầu của chúng tôi. Đội ngũ hỗ trợ chuyên nghiệp luôn túc trực 24/7, sẵn sàng giải đáp mọi thắc mắc về công nghệ tự lái, xử lý yêu cầu đặt xe, hoặc trợ giúp bạn ngay lập tức trong mọi tình huống phát sinh trên hành trình. Hãy yên tâm trải nghiệm, vì chúng tôi luôn đồng hành cùng bạn.
            </p>
        </div>
        <div class="row g-4">
            <div class="col-md-6 col-lg-6 col-xl-3 wow fadeInUp" data-wow-delay="0.1s">
                <div class="team-item p-4 pt-0">
                    <div class="team-img">
                        <img src="{{ asset('img/team-1.jpg') }}" class="img-fluid rounded w-100" alt="Image">
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
                        <img src="{{ asset('img/team-2.jpg') }}" class="img-fluid rounded w-100" alt="Image">
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
                        <img src="{{ asset('img/team-3.jpg') }}" class="img-fluid rounded w-100" alt="Image">
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
                        <img src="{{ asset('img/team-4.jpg') }}" class="img-fluid rounded w-100" alt="Image">
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