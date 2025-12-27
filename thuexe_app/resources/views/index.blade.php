@extends('layout/home')
@section('body')
    @php
        $cmsHomeBlocks = $cmsHomeBlocks ?? collect();

        $hero1 = ($cmsHomeBlocks->get('hero_slide_1') ?? collect())->first();
        $hero2 = ($cmsHomeBlocks->get('hero_slide_2') ?? collect())->first();

        $aboutIntro = ($cmsHomeBlocks->get('about_intro') ?? collect())->first();
        $aboutVision = ($cmsHomeBlocks->get('about_vision') ?? collect())->first();
        $aboutMission = ($cmsHomeBlocks->get('about_mission') ?? collect())->first();
        $aboutStory = ($cmsHomeBlocks->get('about_story') ?? collect())->first();
        $aboutYears = ($cmsHomeBlocks->get('about_years') ?? collect())->first();
        $aboutBulletsBlocks = $cmsHomeBlocks->get('about_bullets') ?? collect();
        $aboutFounder = ($cmsHomeBlocks->get('about_founder') ?? collect())->first();
        $aboutImg1 = ($cmsHomeBlocks->get('about_image_1') ?? collect())->first();
        $aboutImg2 = ($cmsHomeBlocks->get('about_image_2') ?? collect())->first();

        $categoriesIntro = ($cmsHomeBlocks->get('categories_intro') ?? collect())->first();
        $supportIntro = ($cmsHomeBlocks->get('support_intro') ?? collect())->first();

        $homeSearch = ($cmsHomeBlocks->get('home_search') ?? collect())->first();
        $homeSearchTitle = $homeSearch?->title ?? 'TÌM KIẾM XE THEO YÊU CẦU';
        $homeSearchSelectPlaceholder = $homeSearch?->subtitle ?? 'Chọn Loại Xe';
        $homeSearchInputLabel = $homeSearch?->content ? trim(strip_tags((string) $homeSearch->content)) : 'Nhập Tên Xe';
        $homeSearchInputPlaceholder = $homeSearch?->cta_url ? (string) $homeSearch->cta_url : 'Nhập Tên Xe';
        $homeSearchButtonText = $homeSearch?->cta_text ?? 'Tìm Kiếm';

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

        $founderDisplayName = $masterAdmin?->name ?? ($aboutFounder?->title ?? 'Trần Thị Hổ Mang Chúa');
        $founderDisplaySubtitle = $masterAdmin?->VaiTro ?? ($aboutFounder?->subtitle ?? 'Công Ty 1 Mình Tôi');
    @endphp

    <!-- Carousel Start -->
    <div class="header-carousel mb-5">
        <div id="carouselId" class="carousel slide" data-bs-ride="carousel" data-bs-interval="false">
            @php
                $promos = ($activePromotions ?? collect())->filter(fn($p) => $p && !empty($p->description))->values();

                $resolvePromoImage = function ($promo) use ($hero2, $resolveCmsImage) {
                    $path = trim((string) ($promo?->banner_path ?? ''));
                    if ($path !== '') {
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
                    }

                    return $resolveCmsImage($hero2?->image_path) ?? 'img/carousel-2.jpg';
                };

                $carouselSlides = $promos
                    ->map(function ($promo) use ($resolvePromoImage, $hero2) {
                        return [
                            'image' => $resolvePromoImage($promo),
                            'alt' => 'Khuyến mãi ' . ($promo?->title ?? ''),
                            'titleHtml' => nl2br(e($promo->description)),
                            'subtitle' => $hero2?->subtitle ?? 'Hãy tự thưởng cho mình 1 chuyến đi',
                        ];
                    })
                    ->values();

                if ($carouselSlides->isEmpty()) {
                    $carouselSlides = collect([
                        [
                            'image' => $resolveCmsImage($hero1?->image_path) ?? 'img/carousel-2.jpg',
                            'alt' => 'First slide',
                            'titleHtml' => e($hero1?->title ?? ''),
                            'subtitle' => $hero1?->subtitle ?? 'Hãy tự thưởng cho mình 1 chuyến đi',
                        ],
                    ]);
                }
            @endphp
            <div class="carousel-indicators">
                @foreach ($carouselSlides as $slide)
                    <button type="button" data-bs-target="#carouselId" data-bs-slide-to="{{ $loop->index }}"
                        class="{{ $loop->first ? 'active' : '' }}"
                        @if ($loop->first) aria-current="true" @endif
                        aria-label="Slide {{ $loop->iteration }}"></button>
                @endforeach
            </div>
            <div class="carousel-inner" role="listbox">
                @foreach ($carouselSlides as $slide)
                    @include('partials.home.carousel-slide', [
                        'slide' => $slide,
                        'isActive' => $loop->first,
                    ])
                @endforeach
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
                                        <img src="{{ $resolveCmsImage($aboutVision?->image_path) ?? 'img/about-icon-1.png' }}"
                                            class="img-fluid w-50 h-50" alt="Icon">
                                    </div>
                                    <h5 class="mb-3">{{ $aboutVision?->title ?? 'Tầm Nhìn Của Chúng Tôi' }}</h5>
                                    <p class="mb-0">
                                        {!! $aboutVision?->content ??
                                            'Trở thành nền tảng cho thuê xe tự lái hàng đầu, định hình lại tương lai của giao thông đô thị, giúp việc di chuyển trở nên tiện lợi, an toàn và bền vững hơn cho tất cả mọi người.' !!}
                                    </p>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="about-item-inner border p-4">
                                    <div class="about-icon mb-4">
                                        <img src="{{ $resolveCmsImage($aboutMission?->image_path) ?? 'img/about-icon-2.png' }}"
                                            class="img-fluid h-50 w-50" alt="Icon">
                                    </div>
                                    <h5 class="mb-3">{{ $aboutMission?->title ?? 'Sứ Mệnh Của Chúng Tôi' }}</h5>
                                    <p class="mb-0">
                                        {!! $aboutMission?->content ??
                                            'Cung cấp một dịch vụ cho thuê xe liền mạch và đáng tin cậy. Chúng tôi cam kết tích hợp công nghệ tiên tiến nhất, đảm bảo an toàn tuyệt đối và sự tiện lợi tối đa cho khách hàng..' !!}
                                    </p>
                                </div>
                            </div>
                        </div>
                        <p class="text-item my-4">
                            {!! $aboutStory?->content ??
                                'Tại AUTO CAR, chúng tôi tự hào với đội ngũ chuyên gia và kỹ sư đầy tâm huyết. Với nền tảng vững chắc trong ngành công nghệ và dịch vụ ô tô, chúng tôi thấu hiểu sâu sắc nhu cầu của bạn. Chúng tôi cam kết không ngừng đổi mới để mang đến những chiếc xe hiện đại và an toàn nhất.' !!}
                        </p>
                        <div class="row g-4">
                            <div class="col-lg-6">
                                <div class="text-center rounded bg-secondary p-4">
                                    <h1 class="display-6 text-white">{{ $aboutYears?->title ?? '5' }}</h1>
                                    <h5 class="text-light mb-0">{{ $aboutYears?->subtitle ?? 'Năm Kinh Nghiệm' }}</h5>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="rounded">
                                    @if ($aboutBulletsBlocks->isNotEmpty())
                                        @foreach ($aboutBulletsBlocks as $bullet)
                                            @continue(empty($bullet?->content))
                                            <p class="{{ $loop->last ? 'mb-0' : 'mb-2' }}"><i
                                                    class="fa fa-check-circle text-primary me-1"></i>{!! $bullet->content !!}
                                            </p>
                                        @endforeach
                                    @else
                                        <p class="mb-2"><i class="fa fa-check-circle text-primary me-1"></i> Hệ thống xe
                                            đa
                                            dạng, mới và hiện đại.</p>
                                        <p class="mb-2"><i class="fa fa-check-circle text-primary me-1"></i> Quy trình
                                            đặt
                                            xe nhanh chóng.</p>
                                        <p class="mb-2"><i class="fa fa-check-circle text-primary me-1"></i> Đội ngũ hỗ
                                            trợ
                                            nhiệt tình.</p>
                                        <p class="mb-0"><i class="fa fa-check-circle text-primary me-1"></i> Chi phí
                                            minh
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
                                    <img src="{{ $resolveCmsImage($aboutFounder?->image_path) ?? 'img/attachment-img.jpg' }}"
                                        class="img-fluid rounded-circle border border-4 border-secondary"
                                        style="width: 100px; height: 100px;" alt="Image">
                                    <div class="ms-4">
                                        <h4>{{ $founderDisplayName }}</h4>
                                        <p class="mb-0">{{ $founderDisplaySubtitle }}</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xl-6 wow fadeInRight" data-wow-delay="0.2s">
                    <div class="about-img">
                        <div class="img-1">
                            <img src="{{ $resolveCmsImage($aboutImg1?->image_path) ?? 'img/about-img.jpg' }}"
                                class="img-fluid rounded h-100 w-100" alt="">
                        </div>
                        <div class="img-2">
                            <img src="{{ $resolveCmsImage($aboutImg2?->image_path) ?? 'img/about-img-1.jpg' }}"
                                class="img-fluid rounded w-100" alt="">
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
                <h1 class="display-5 text-capitalize mb-3">
                    {!! $categoriesIntro?->title ?? 'Các Phương Tiện <span class="text-primary">Của Chúng Tôi</span>' !!}
                </h1>
                <p class="mb-0">
                    {{ $categoriesIntro?->content }}
                </p>
            </div>
            <div class="categories-carousel owl-carousel wow fadeInUp" data-wow-delay="0.1s">
                @forelse ($xes as $xe)
                    @php
                        $imgUrl = !empty($xe->HinhAnh)
                            ? \Illuminate\Support\Facades\Storage::url($xe->HinhAnh)
                            : asset('img/car-1.png');

                        $reviewCount = (int) ($xe->so_luong_danh_gia ?? 0);
                        $avgRating = (float) ($xe->diem_trung_binh ?? 0);
                        $avgRating = max(0, min(5, $avgRating));
                        $rounded = round($avgRating * 2) / 2;
                        $fullStars = (int) floor($rounded);
                        $hasHalf = $rounded - $fullStars === 0.5;
                    @endphp

                    <div class="categories-item p-4">
                        <div class="categories-item-inner">
                            <div class="categories-img rounded-top">
                                <img src="{{ $imgUrl }}" class="img-fluid w-100 rounded-top"
                                    alt="{{ $xe->Ten_Xe }}">
                            </div>
                            <div class="categories-content rounded-bottom p-4">
                                <h4>{{ $xe->Ten_Xe }}</h4>
                                <div class="categories-review mb-4">
                                    <div class="me-3">{{ $reviewCount }} Đánh Giá</div>
                                    <div class="d-flex justify-content-center text-warning">
                                        @for ($i = 1; $i <= 5; $i++)
                                            @if ($i <= $fullStars)
                                                <i class="fas fa-star"></i>
                                            @elseif ($hasHalf && $i === $fullStars + 1)
                                                <i class="fas fa-star-half-alt"></i>
                                            @else
                                                <i class="fas fa-star text-body"></i>
                                            @endif
                                        @endfor
                                    </div>
                                </div>
                                <div class="mb-4">
                                    <h4 class="bg-white text-primary rounded-pill py-2 px-4 mb-0">
                                        {{ $xe->GiaThue ? number_format($xe->GiaThue, 0, ',', '.') . 'đ/ngày' : 'Liên hệ' }}
                                    </h4>
                                </div>
                                <div class="row gy-2 gx-0 text-center mb-4">
                                    <div class="col-4 border-end border-white">
                                        <i class="fa fa-users text-dark"></i>
                                        <span class="text-body ms-1">{{ $xe->SoGhe ?? '-' }} Chỗ</span>
                                    </div>
                                    <div class="col-4 border-end border-white">
                                        <i class="fa fa-car text-dark"></i>
                                        <span class="text-body ms-1">
                                            {{ optional(optional($xe->thongSo)->hopSo)->Ten_DM ?? (optional($xe->thongSo)->LoaiHopSo ?? '---') }}
                                        </span>
                                    </div>
                                    <div class="col-4">
                                        <i class="fa fa-gas-pump text-dark"></i>
                                        <span class="text-body ms-1">
                                            {{ optional(optional($xe->thongSo)->nhienLieu)->Ten_DM ?? (optional($xe->thongSo)->LoaiNhienLieu ?? '---') }}
                                        </span>
                                    </div>
                                    <div class="col-4 border-end border-white">
                                        <i class="fa fa-car text-dark"></i>
                                        <span class="text-body ms-1">{{ $xe->NamSX ?? '---' }}</span>
                                    </div>
                                    <div class="col-4 border-end border-white">
                                        <i class="fa fa-cogs text-dark"></i>
                                        <span class="text-body ms-1">{{ $xe->BienSo ?? '---' }}</span>
                                    </div>
                                    <div class="col-4">
                                        <i class="fa fa-road text-dark"></i>
                                        <span
                                            class="text-body ms-1">{{ optional($xe->phanLoaiXe)->Ten_PLXe ?? '---' }}</span>
                                    </div>
                                </div>
                                <a href="{{ route('cardetail', $xe->Ma_Xe) }}"
                                    class="btn btn-primary rounded-pill d-flex justify-content-center py-3">Đặt Ngay</a>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="text-center p-4">Chưa có xe nào sẵn sàng để hiển thị.</div>
                @endforelse
            </div>
        </div>
    </div>
    <!-- Car categories End -->

    <!-- Team Start -->
    <div class="container-fluid team py-5">
        <div class="container">
            <div class="text-center mx-auto pb-5 wow fadeInUp" data-wow-delay="0.1s" style="max-width: 800px;">
                <h1 class="display-5 text-capitalize mb-3">
                    {!! $supportIntro?->title ?? 'Trung Tâm <span class="text-primary">Hỗ Trợ </span> Khách Hàng' !!}
                </h1>
                <p class="mb-0">
                    {!! $teamIntro?->content ??
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
