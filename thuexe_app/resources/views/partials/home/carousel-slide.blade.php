<div class="carousel-item {{ $isActive ? 'active' : '' }}">
    <img src="{{ $slide['image'] }}" class="img-fluid w-100" alt="{{ $slide['alt'] ?? 'Slide' }}" />
    <div class="carousel-caption">
        <div class="container py-4">
            <div class="row g-5">
                <div class="col-lg-6 fadeInLeft animated" data-animation="fadeInLeft" data-delay="1s"
                    style="animation-delay: 1s;">
                    <div class="bg-secondary rounded p-5">
                        <h4 class="text-white mb-4">{{ $homeSearchTitle ?? 'TÌM KIẾM XE THEO YÊU CẦU' }}</h4>
                        <form action="{{ route('vehicle') }}" method="GET">
                            <div class="row g-3">
                                <div class="col-12">
                                    <select class="form-select" name="plxe" aria-label="Chọn Loại Xe">
                                        <option value="">{{ $homeSearchSelectPlaceholder ?? 'Chọn Loại Xe' }}
                                        </option>
                                        @foreach ($loaiXes ?? collect() as $loai)
                                            <option value="{{ $loai->Ma_PLXe }}">{{ $loai->Ten_PLXe }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="input-group">
                                    <div class="d-flex align-items-center bg-light text-body rounded-start p-2">
                                        <span class="fas fa-map-marker-alt"></span>
                                        <span class="ms-1">{{ $homeSearchInputLabel ?? 'Nhập Tên Xe' }}</span>
                                    </div>
                                    <input class="form-control" type="text" name="q"
                                        placeholder="{{ $homeSearchInputPlaceholder ?? 'Nhập Tên Xe' }}"
                                        aria-label="Nhập Tên Xe">
                                </div>
                                <div class="col-12">
                                    <button type="submit"
                                        class="btn btn-light w-100 py-2">{{ $homeSearchButtonText ?? 'Tìm Kiếm' }}</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
                <div class="col-lg-6 d-none d-lg-flex fadeInRight animated" data-animation="fadeInRight" data-delay="1s"
                    style="animation-delay: 1s;">
                    <div class="text-start">
                        <h1 class="display-5 text-white">{!! $slide['titleHtml'] !!}</h1>
                        <p>{{ $slide['subtitle'] ?? '' }}</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
