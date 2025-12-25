@extends('layout/home')
@section('body')
    @php
        $cmsTeamBlocks = $cmsTeamBlocks ?? collect();
        $pageHeader = ($cmsTeamBlocks->get('page_header') ?? collect())->first();
        $teamIntro = ($cmsTeamBlocks->get('support_intro') ?? collect())->first();
    @endphp

    <!-- Header Start -->
    <div class="container-fluid bg-breadcrumb mb-5">
        <div class="container text-center py-5" style="max-width: 900px;">
            <h4 class="text-white display-4 mb-4 wow fadeInDown" data-wow-delay="0.1s">
                {{ $pageHeader?->title ?? 'Hỗ Trợ Khách Hàng' }}
            </h4>
            <ol class="breadcrumb d-flex justify-content-center mb-0 wow fadeInDown" data-wow-delay="0.3s">
                <li class="breadcrumb-item"><a href="{{ route('home') }}">Trang Chủ</a></li>
                <li class="breadcrumb-item active text-primary">{{ $pageHeader?->subtitle ?? 'Hỗ Trợ Khách Hàng' }}</li>
            </ol>
        </div>
    </div>
    <!-- Header End -->

    <!-- Team Start -->
    <div class="container-fluid team py-5">
        <div class="container">
            <div class="text-center mx-auto pb-5 wow fadeInUp" data-wow-delay="0.1s" style="max-width: 800px;">
                <h1 class="display-5 text-capitalize mb-3">
                    {!! $teamIntro?->title ?? 'Trung Tâm <span class="text-primary">Hỗ Trợ </span>Khách Hàng' !!}
                </h1>
                <p class="mb-0">
                    {!! $teamIntro?->content ??
                        'Sự an toàn và hài lòng của bạn là ưu tiên hàng đầu của chúng tôi. Đội ngũ hỗ trợ chuyên nghiệp luôn túc trực 24/7, sẵn sàng giải đáp mọi thắc mắc về công nghệ tự lái, xử lý yêu cầu đặt xe, hoặc trợ giúp bạn ngay lập tức trong mọi tình huống phát sinh trên hành trình. Hãy yên tâm trải nghiệm, vì chúng tôi luôn đồng hành cùng bạn.' !!}
                </p>
            </div>
            @php
                $supportAdmins = $supportAdmins ?? collect();
            @endphp

            <div class="row g-4">
                @forelse ($supportAdmins as $admin)
                    @php
                        $imgIndex = ($loop->index % 4) + 1;
                        $imgUrl = asset('img/team-' . $imgIndex . '.jpg');
                        $roleLabel = $admin->VaiTro ? $admin->VaiTro : 'Chăm sóc khách hàng';
                    @endphp
                    <div class="col-md-6 col-lg-6 col-xl-3 wow fadeInUp" data-wow-delay="0.1s">
                        <div class="team-item p-4 pt-0">
                            <div class="team-img">
                                <img src="{{ $imgUrl }}" class="img-fluid rounded w-100" alt="{{ $admin->name }}">
                            </div>
                            <div class="team-content pt-4">
                                <h4>{{ $admin->name }}</h4>
                                <p class="mb-2">{{ $roleLabel }}</p>
                                <div class="text-muted small mb-3">
                                    <i class="fa fa-envelope me-1"></i>{{ $admin->email }}
                                </div>
                                <div class="team-icon d-flex justify-content-center">
                                    <a class="btn btn-square btn-light rounded-circle mx-1"
                                        href="mailto:{{ $admin->email }}" title="Email">
                                        <i class="fa fa-envelope"></i>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="col-12">
                        <div class="alert alert-info mb-0">Hiện chưa có nhân sự chăm sóc khách hàng được phân vai trò.</div>
                    </div>
                @endforelse
            </div>
        </div>
    </div>
    <!-- Team End -->
@endsection
