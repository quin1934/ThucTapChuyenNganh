@extends('layout/home')
@section('body')
    @php
        $cmsAboutBlocks = $cmsAboutBlocks ?? collect();

        $aboutIntro = ($cmsAboutBlocks->get('about_intro') ?? collect())->first();
        $aboutVision = ($cmsAboutBlocks->get('about_vision') ?? collect())->first();
        $aboutMission = ($cmsAboutBlocks->get('about_mission') ?? collect())->first();
        $aboutStory = ($cmsAboutBlocks->get('about_story') ?? collect())->first();
        $aboutYears = ($cmsAboutBlocks->get('about_years') ?? collect())->first();
        $aboutBullets = ($cmsAboutBlocks->get('about_bullets') ?? collect())->first();
        $aboutFounder = ($cmsAboutBlocks->get('about_founder') ?? collect())->first();
        $aboutImg1 = ($cmsAboutBlocks->get('about_image_1') ?? collect())->first();
        $aboutImg2 = ($cmsAboutBlocks->get('about_image_2') ?? collect())->first();

        $supportIntro = ($cmsAboutBlocks->get('support_intro') ?? collect())->first();

        $resolveCmsImage = function ($path) {
            $path = trim((string) $path);
            if ($path === '') {
                return null;
            }
            if (preg_match('/^https?:\\/\\//i', $path)) {
                return $path;
            }
            if (
                str_starts_with($path, 'img/') ||
                str_starts_with($path, 'uploads/') ||
                str_starts_with($path, 'storage/')
            ) {
                return asset($path);
            }

            return \Illuminate\Support\Facades\Storage::url($path);
        };
    @endphp

    <!-- Header Start -->
    <div class="container-fluid bg-breadcrumb mb-5">
        <div class="container text-center py-5" style="max-width: 900px;">
            <h4 class="text-white display-4 mb-4 wow fadeInDown" data-wow-delay="0.1s">Về Chúng Tôi</h4>
            <ol class="breadcrumb d-flex justify-content-center mb-0 wow fadeInDown" data-wow-delay="0.3s">
                <li class="breadcrumb-item"><a href="{{ route('home') }}">Trang Chủ</a></li>
                <li class="breadcrumb-item active text-primary">Về Chúng Tôi</li>
            </ol>
        </div>
    </div>
    <!-- Header End -->

    <!-- About Start -->
    <div class="container-fluid overflow-hidden about py-5">
        <div class="container">
            <div class="row g-5">
                <div class="col-xl-6 wow fadeInLeft" data-wow-delay="0.2s">
                    <div class="about-item">
                        <div class="pb-5">
                            <h1 class="display-5 text-capitalize">
                                {!! $aboutIntro?->title ?? 'Giới Thiệu Về <span class="text-primary">Chúng Tôi</span>' !!}
                            </h1>
                            <p class="mb-0">
                                {!! $aboutIntro?->content ??
                                    'Chào mừng bạn đến với AUTO CAR, website tiên phong mang đến giải pháp di chuyển thông minh cho tương lai. Chúng tôi chuyên cung cấp dịch vụ cho thuê xe tự lái, ứng dụng công nghệ tiên tiến nhất để mang lại cho bạn trải nghiệm hành trình an toàn, tiện lợi và hoàn toàn tự chủ. Hãy khám phá sự tự do trên mọi nẻo đường cùng chúng tôi!' !!}
                            </p>
                        </div>
                        <div class="row g-4">
                            <div class="col-lg-6">
                                <div class="about-item-inner border p-4">
                                    <div class="about-icon mb-4">
                                        <img src="{{ $resolveCmsImage($aboutVision?->image_path) ?? asset('img/about-icon-1.png') }}"
                                            class="img-fluid w-50 h-50" alt="Icon">
                                    </div>
                                    <h5 class="mb-3">{{ $aboutVision?->title ?? 'Tầm Nhìn Của Chúng Tôi' }}</h5>
                                    <p class="mb-0">{!! $aboutVision?->content ??
                                        'Trở thành nền tảng cho thuê xe tự lái hàng đầu, định hình lại tương lai của giao thông đô thị, giúp việc di chuyển trở nên tiện lợi, an toàn và bền vững hơn cho tất cả mọi người.' !!}</p>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="about-item-inner border p-4">
                                    <div class="about-icon mb-4">
                                        <img src="{{ $resolveCmsImage($aboutMission?->image_path) ?? asset('img/about-icon-2.png') }}"
                                            class="img-fluid h-50 w-50" alt="Icon">
                                    </div>
                                    <h5 class="mb-3">{{ $aboutMission?->title ?? 'Sứ Mệnh Của Chúng Tôi' }}</h5>
                                    <p class="mb-0">{!! $aboutMission?->content ??
                                        'Cung cấp một dịch vụ cho thuê xe liền mạch và đáng tin cậy. Chúng tôi cam kết tích hợp công nghệ tiên tiến nhất, đảm bảo an toàn tuyệt đối và sự tiện lợi tối đa cho khách hàng..' !!}</p>
                                </div>
                            </div>
                        </div>
                        <p class="text-item my-4">{!! $aboutStory?->content ??
                            'Tại AUTO CAR, chúng tôi tự hào với đội ngũ chuyên gia và kỹ sư đầy tâm huyết. Với nền tảng vững chắc trong ngành công nghệ và dịch vụ ô tô, chúng tôi thấu hiểu sâu sắc nhu cầu của bạn. Chúng tôi cam kết không ngừng đổi mới để mang đến những chiếc xe hiện đại và an toàn nhất.' !!}</p>
                        <div class="row g-4">
                            <div class="col-lg-6">
                                <div class="text-center rounded bg-secondary p-4">
                                    <h1 class="display-6 text-white">{{ $aboutYears?->title ?? '5' }}</h1>
                                    <h5 class="text-light mb-0">{{ $aboutYears?->subtitle ?? 'Năm Kinh Nghiệm' }}</h5>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="rounded">
                                    @if ($aboutBullets && !empty($aboutBullets->content))
                                        {!! $aboutBullets->content !!}
                                    @else
                                        <p class="mb-2"><i class="fa fa-check-circle text-primary me-1"></i> Hệ thống xe
                                            đa
                                            dạng, mới và hiện đại.</p>
                                        <p class="mb-2"><i class="fa fa-check-circle text-primary me-1"></i> Quy trình đặt
                                            xe
                                            nhanh chóng.</p>
                                        <p class="mb-2"><i class="fa fa-check-circle text-primary me-1"></i> Đội ngũ hỗ
                                            trợ
                                            nhiệt tình.</p>
                                        <p class="mb-0"><i class="fa fa-check-circle text-primary me-1"></i> Chi phí minh
                                            bạch.</p>
                                    @endif
                                </div>
                            </div>
                            <div class="col-lg-5 d-flex align-items-center">
                                <a href="{{ $aboutFounder?->cta_url ?? '#' }}" class="btn btn-primary rounded py-3 px-5">
                                    {{ $aboutFounder?->cta_text ?? 'Thông Tin Người Sáng Lập' }}
                                </a>
                            </div>
                            <div class="col-lg-7">
                                <div class="d-flex align-items-center">
                                    <img src="{{ $resolveCmsImage($aboutFounder?->image_path) ?? asset('img/attachment-img.jpg') }}"
                                        class="img-fluid rounded-circle border border-4 border-secondary"
                                        style="width: 100px; height: 100px;" alt="Image">
                                    <div class="ms-4">
                                        <h4>{{ $aboutFounder?->title ?? 'Trần Thị Hổ Mang Chúa' }}</h4>
                                        <p class="mb-0">{{ $aboutFounder?->subtitle ?? 'Công Ty 1 Mình Tôi' }}</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xl-6 wow fadeInRight" data-wow-delay="0.2s">
                    <div class="about-img">
                        <div class="img-1">
                            <img src="{{ $resolveCmsImage($aboutImg1?->image_path) ?? asset('img/about-img.jpg') }}"
                                class="img-fluid rounded h-100 w-100" alt="">
                        </div>
                        <div class="img-2">
                            <img src="{{ $resolveCmsImage($aboutImg2?->image_path) ?? asset('img/about-img-1.jpg') }}"
                                class="img-fluid rounded w-100" alt="">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="container-fluid team py-5">
        <div class="container">
            <div class="text-center mx-auto pb-5 wow fadeInUp" data-wow-delay="0.1s" style="max-width: 800px;">
                <h1 class="display-5 text-capitalize mb-3">
                    {!! $supportIntro?->title ?? 'Trung Tâm <span class="text-primary">Hỗ Trợ </span>Khách Hàng' !!}
                </h1>
                <p class="mb-0">
                    {!! $supportIntro?->content ??
                        'Sự an toàn và hài lòng của bạn là ưu tiên hàng đầu của chúng tôi. Đội ngũ hỗ trợ chuyên nghiệp luôn túc trực 24/7, sẵn sàng giải đáp mọi thắc mắc về công nghệ tự lái, xử lý yêu cầu đặt xe, hoặc trợ giúp bạn ngay lập tức trong mọi tình huống phát sinh trên hành trình. Hãy yên tâm trải nghiệm, vì chúng tôi luôn đồng hành cùng bạn.' !!}
                </p>
            </div>
            <div class="row g-4">
                @php
                    $supportAdmins = $supportAdmins ?? collect();
                @endphp

                @forelse ($supportAdmins as $admin)
                    @php
                        $imgIndex = ($loop->index % 4) + 1;
                        $roleLabel = $admin->VaiTro ? $admin->VaiTro : 'Chăm sóc khách hàng';
                    @endphp
                    <div class="col-md-6 col-lg-6 col-xl-3 wow fadeInUp" data-wow-delay="0.1s">
                        <div class="team-item p-4 pt-0">
                            <div class="team-img">
                                <img src="{{ asset('img/team-' . $imgIndex . '.jpg') }}" class="img-fluid rounded w-100"
                                    alt="{{ $admin->name }}">
                            </div>
                            <div class="team-content pt-4">
                                <h4>{{ $admin->name }}</h4>
                                <p class="mb-2">{{ $roleLabel }}</p>
                                <p class="text-muted small mb-3">
                                    <i class="fa fa-envelope me-1"></i>{{ $admin->email }}
                                </p>
                                <div class="team-icon d-flex justify-content-center">
                                    <a class="btn btn-square btn-light rounded-circle mx-1" href=""><i
                                            class="fab fa-facebook-f"></i></a>
                                    <a class="btn btn-square btn-light rounded-circle mx-1" href=""><i
                                            class="fab fa-twitter"></i></a>
                                    <a class="btn btn-square btn-light rounded-circle mx-1" href=""><i
                                            class="fab fa-instagram"></i></a>
                                    <a class="btn btn-square btn-light rounded-circle mx-1" href=""><i
                                            class="fab fa-linkedin-in"></i></a>
                                </div>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="col-12">
                        <div class="alert alert-info mb-0">Hiện chưa có nhân sự chăm sóc khách hàng được phân vai trò.
                        </div>
                    </div>
                @endforelse
            </div>
        </div>
    </div>
    <!-- Team End -->
@endsection
