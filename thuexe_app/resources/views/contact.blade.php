@extends('layout/home')
@section('body')

    <div class="container-fluid bg-breadcrumb mb-5">
        <div class="container text-center py-5" style="max-width: 900px;">
            <h4 class="text-white display-4 mb-4 wow fadeInDown" data-wow-delay="0.1s">Đăng Ký Cho Thuê Xe</h4>
            <ol class="breadcrumb d-flex justify-content-center mb-0 wow fadeInDown" data-wow-delay="0.3s">
                <li class="breadcrumb-item"><a href="{{ route('home') }}">Trang Chủ</a></li>
                <li class="breadcrumb-item active text-primary">Đăng Ký Xe</li>
            </ol>
        </div>
    </div>
    <div class="container-fluid contact py-5">
        <div class="container">
            <div class="text-center mx-auto pb-5 wow fadeInUp" data-wow-delay="0.1s" style="max-width: 800px;">
                <h1 class="display-5 text-capitalize text-primary mb-3">Thông Tin Xe Của Bạn</h1>
                <p class="mb-0">Hãy điền đầy đủ thông tin chi tiết về chiếc xe bạn muốn cho thuê. Thông tin càng chi tiết
                    càng giúp khách hàng tin tưởng và đặt xe nhanh hơn.</p>
            </div>

            <div class="row g-5 justify-content-center">
                <div class="col-lg-10 wow fadeInUp" data-wow-delay="0.1s">
                    <div class="bg-secondary p-5 rounded">
                        <h3 class="text-white mb-4">Nhập thông tin xe</h3>

                        @if (session('success'))
                            <div class="alert alert-success">{{ session('success') }}</div>
                        @endif

                        @if ($errors->any())
                            <div class="alert alert-danger">
                                <ul class="mb-0">
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif

                        @if (!Auth::guard('chu_xe')->check())
                            <div class="alert alert-warning mb-0">
                                Vui lòng đăng nhập tài khoản <strong>chủ xe</strong> để đăng xe.
                                <a href="{{ route('client.login') }}" class="text-decoration-underline">Đăng nhập</a>
                            </div>
                        @else
                            <form action="{{ route('partner.car.store') }}" method="POST" enctype="multipart/form-data">
                                @csrf
                                <div class="row g-4">
                                    <div class="col-md-12">
                                        <div class="form-floating">
                                            <input type="text" class="form-control" id="Ten_Xe" name="Ten_Xe"
                                                placeholder="Tên xe (Ví dụ: Toyota Camry 2.5Q)" value="{{ old('Ten_Xe') }}"
                                                required>
                                            <label for="Ten_Xe">Tên xe (Hãng xe + Dòng xe)</label>
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="form-floating">
                                            <input type="text" class="form-control" id="BienSo" name="BienSo"
                                                placeholder="Biển số" value="{{ old('BienSo') }}" required>
                                            <label for="BienSo">Biển số xe (VD: 30A-123.45)</label>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-floating">
                                            <input type="number" class="form-control" id="NamSX" name="NamSX"
                                                placeholder="Năm sản xuất" min="1900" max="{{ date('Y') }}"
                                                value="{{ old('NamSX') }}" required>
                                            <label for="NamSX">Năm sản xuất</label>
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="form-floating">
                                            <input type="number" class="form-control" id="SoGhe" name="SoGhe"
                                                placeholder="Số ghế" min="1" max="60"
                                                value="{{ old('SoGhe') }}" required>
                                            <label for="SoGhe">Số ghế ngồi</label>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-floating">
                                            <select class="form-select" id="LoaiHopSo" name="LoaiHopSo" required>
                                                <option value="" disabled {{ old('LoaiHopSo') ? '' : 'selected' }}>--
                                                    Chọn hộp số --</option>
                                                @foreach ($dsHopSo ?? [] as $hs)
                                                    <option value="{{ $hs->Ma_DM }}"
                                                        {{ (string) old('LoaiHopSo') === (string) $hs->Ma_DM ? 'selected' : '' }}>
                                                        {{ $hs->Ten_DM }}
                                                    </option>
                                                @endforeach
                                            </select>
                                            <label for="LoaiHopSo">Loại hộp số</label>
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="form-floating">
                                            <select class="form-select" id="LoaiNhienLieu" name="LoaiNhienLieu" required>
                                                <option value="" disabled
                                                    {{ old('LoaiNhienLieu') ? '' : 'selected' }}>-- Chọn nhiên liệu --
                                                </option>
                                                @foreach ($dsNhienLieu ?? [] as $nl)
                                                    <option value="{{ $nl->Ma_DM }}"
                                                        {{ (string) old('LoaiNhienLieu') === (string) $nl->Ma_DM ? 'selected' : '' }}>
                                                        {{ $nl->Ten_DM }}
                                                    </option>
                                                @endforeach
                                            </select>
                                            <label for="LoaiNhienLieu">Loại nhiên liệu</label>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-floating">
                                            <input type="text" class="form-control" id="MucTieuThu" name="MucTieuThu"
                                                placeholder="VD: 7L/100km" value="{{ old('MucTieuThu') }}">
                                            <label for="MucTieuThu">Mức tiêu thụ (VD: 7L/100km)</label>
                                        </div>
                                    </div>

                                    <div class="col-md-12">
                                        <div class="form-floating">
                                            <input type="text" class="form-control" id="Cong_Xuat" name="Cong_Xuat"
                                                placeholder="Công suất" value="{{ old('Cong_Xuat') }}">
                                            <label for="Cong_Xuat">Công suất động cơ (VD: 150HP / 2.0L)</label>
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="form-floating">
                                            <select class="form-select" id="Ma_PLXe" name="Ma_PLXe" required>
                                                <option value="" disabled {{ old('Ma_PLXe') ? '' : 'selected' }}>--
                                                    Chọn phân loại xe --</option>
                                                @foreach ($loaiXes ?? [] as $lx)
                                                    <option value="{{ $lx->Ma_PLXe }}"
                                                        {{ (string) old('Ma_PLXe') === (string) $lx->Ma_PLXe ? 'selected' : '' }}>
                                                        {{ $lx->Ten_PLXe }}
                                                    </option>
                                                @endforeach
                                            </select>
                                            <label for="Ma_PLXe">Phân loại xe</label>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-floating">
                                            <input type="number" class="form-control" id="GiaThue" name="GiaThue"
                                                placeholder="Giá thuê" min="0" value="{{ old('GiaThue') }}"
                                                required>
                                            <label for="GiaThue">Giá thuê (VNĐ/ngày)</label>
                                        </div>
                                    </div>

                                    <div class="col-12">
                                        <div class="form-floating">
                                            <textarea class="form-control" placeholder="Mô tả" id="MoTa_Xe" name="MoTa_Xe" style="height: 120px">{{ old('MoTa_Xe') }}</textarea>
                                            <label for="MoTa_Xe">Mô tả xe (tùy chọn)</label>
                                        </div>
                                    </div>

                                    <div class="col-12">
                                        <label class="text-white mb-2">Các tiện ích trên xe:</label>
                                        <div class="row bg-white rounded p-3 mx-0">
                                            @forelse (($tienIches ?? []) as $ti)
                                                <div class="col-md-4 mb-2">
                                                    <div class="form-check">
                                                        <input class="form-check-input" type="checkbox" name="tien_ich[]"
                                                            value="{{ $ti->Ma_TI }}" id="ti_{{ $ti->Ma_TI }}"
                                                            {{ in_array($ti->Ma_TI, old('tien_ich', [])) ? 'checked' : '' }}>
                                                        <label class="form-check-label"
                                                            for="ti_{{ $ti->Ma_TI }}">{{ $ti->Ten_TI }}</label>
                                                    </div>
                                                </div>
                                            @empty
                                                <div class="col-12">
                                                    <small class="text-muted">Chưa có danh sách tiện ích.</small>
                                                </div>
                                            @endforelse
                                        </div>
                                    </div>

                                    <div class="col-12">
                                        <div class="form-group">
                                            <label for="car_image" class="text-white mb-2">Hình ảnh xe (Ảnh chụp thực
                                                tế)</label>
                                            <input type="file" class="form-control bg-white" id="car_image"
                                                name="HinhAnh" accept="image/*" required>
                                        </div>
                                    </div>

                                    <div class="col-12 mt-4">
                                        <button class="btn btn-light w-100 py-3 fw-bold" type="submit">Đăng Ký Cho Thuê
                                            Ngay</button>
                                    </div>
                                </div>
                            </form>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
