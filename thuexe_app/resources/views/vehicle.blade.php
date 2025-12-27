@extends('layout/home')
@section('body')
    <!-- Header Start -->
    <div class="container-fluid bg-breadcrumb mb-5">
        <div class="container text-center py-5" style="max-width: 900px;">
            <h4 class="text-white display-4 mb-4 wow fadeInDown" data-wow-delay="0.1s">Xe Nổi Bật</h4>
            <ol class="breadcrumb d-flex justify-content-center mb-0 wow fadeInDown" data-wow-delay="0.3s">
                <li class="breadcrumb-item"><a href="{{ route('home') }}">Trang chủ</a></li>
                <li class="breadcrumb-item active text-primary">Xe nổi bật</li>
            </ol>
        </div>
    </div>
    <!-- Header End -->

    <!-- Car categories Start -->
    <div class="container-fluid categories py-5">
        <div class="container">
            <div class="row g-4 fadeInUp">
                @forelse ($xes as $xe)
                    @php
                        $imgUrl = !empty($xe->HinhAnh)
                            ? \Illuminate\Support\Facades\Storage::url($xe->HinhAnh)
                            : asset('img/car-1.png');
                    @endphp
                    <div class="col-12 col-md-6 col-lg-4">
                        <div class="categories-item p-4 h-100">
                            <div class="categories-item-inner h-100">
                                <div class="categories-img rounded-top">
                                    <img src="{{ $imgUrl }}" class="img-fluid w-100 rounded-top"
                                        alt="{{ $xe->Ten_Xe }}">
                                </div>
                                <div class="categories-content rounded-bottom p-4">
                                    <h4>{{ $xe->Ten_Xe }}</h4>
                                    <div class="categories-review mb-4">
                                        @php
                                            $reviewCount = (int) ($xe->so_luong_danh_gia ?? 0);
                                            $avgRating = (float) ($xe->diem_trung_binh ?? 0);
                                            $avgRating = max(0, min(5, $avgRating));
                                            $rounded = round($avgRating * 2) / 2;
                                            $fullStars = (int) floor($rounded);
                                            $hasHalf = $rounded - $fullStars === 0.5;
                                        @endphp
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
                                            <span
                                                class="text-body ms-1">{{ optional($xe->phanLoaiXe)->Ten_PLXe ?? '---' }}</span>
                                        </div>
                                        <div class="col-4">
                                            <i class="fa fa-id-card text-dark"></i>
                                            <span class="text-body ms-1">{{ $xe->BienSo ?? '---' }}</span>
                                        </div>
                                        <div class="col-4 border-end border-white">
                                            <i class="fa fa-car text-dark"></i>
                                            <span class="text-body ms-1">{{ $xe->NamSX ?? '---' }}</span>
                                        </div>
                                        <div class="col-4 border-end border-white">
                                            <i class="fa fa-cogs text-dark"></i>
                                            <span class="text-body ms-1">
                                                {{ optional(optional($xe->thongSo)->hopSo)->Ten_DM ?? (optional($xe->thongSo)->LoaiHopSo ?? '---') }}
                                            </span>
                                        </div>
                                        <div class="col-4">
                                            <i class="fa fa-road text-dark"></i>
                                            <span class="text-body ms-1">
                                                {{ optional(optional($xe->thongSo)->nhienLieu)->Ten_DM ?? (optional($xe->thongSo)->LoaiNhienLieu ?? '---') }}
                                            </span>
                                        </div>
                                    </div>
                                    <a href="{{ route('cardetail', $xe->Ma_Xe) }}"
                                        class="btn btn-primary rounded-pill d-flex justify-content-center py-3">Đặt Ngay</a>
                                </div>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="col-12 p-4 text-center">Chưa có xe nào sẵn sàng để hiển thị.</div>
                @endforelse
            </div>
        </div>
    </div>
    <!-- Car categories End -->
@endsection
