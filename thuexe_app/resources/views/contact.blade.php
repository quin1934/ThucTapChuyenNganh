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
            <p class="mb-0">Hãy điền đầy đủ thông tin chi tiết về chiếc xe bạn muốn cho thuê. Thông tin càng chi tiết càng giúp khách hàng tin tưởng và đặt xe nhanh hơn.</p>
        </div>
        
        <div class="row g-5 justify-content-center">
            <div class="col-lg-10 wow fadeInUp" data-wow-delay="0.1s">
                <div class="bg-secondary p-5 rounded">
                    <h3 class="text-white mb-4">Nhập thông tin xe</h3>
                    
                    <form action="" method="POST" enctype="multipart/form-data">
                        @csrf <div class="row g-4">
                            <div class="col-md-12">
                                <div class="form-floating">
                                    <input type="text" class="form-control" id="name" name="name" placeholder="Tên xe (Ví dụ: Toyota Camry 2.5Q)" required>
                                    <label for="name">Tên xe (Hãng xe + Dòng xe)</label>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-floating">
                                    <input type="text" class="form-control" id="license_plate" name="license_plate" placeholder="Biển số" required>
                                    <label for="license_plate">Biển số xe (VD: 30A-123.45)</label>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-floating">
                                    <input type="number" class="form-control" id="year" name="year" placeholder="Năm sản xuất" min="2000" max="2025" required>
                                    <label for="year">Năm sản xuất</label>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-floating">
                                    <input type="number" class="form-control" id="seats" name="seats" placeholder="Số ghế" min="2" max="50" required>
                                    <label for="seats">Số ghế ngồi</label>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-floating">
                                    <select class="form-select" id="transmission" name="transmission" required>
                                        <option value="TuDong">Số tự động (Automatic)</option>
                                        <option value="SoSan">Số sàn (Manual)</option>
                                    </select>
                                    <label for="transmission">Loại hộp số</label>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-floating">
                                    <select class="form-select" id="fuel_type" name="fuel_type" required>
                                        <option value="Xang">Xăng</option>
                                        <option value="Dau">Dầu Diesel</option>
                                        <option value="Dien">Điện (EV)</option>
                                    </select>
                                    <label for="fuel_type">Loại nhiên liệu</label>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-floating">
                                    <input type="text" class="form-control" id="consumption" name="consumption" placeholder="VD: 7L/100km" required>
                                    <label for="consumption">Mức tiêu thụ (VD: 7L/100km)</label>
                                </div>
                            </div>

                            <div class="col-md-12">
                                <div class="form-floating">
                                    <input type="text" class="form-control" id="engine_power" name="engine_power" placeholder="Công suất" required>
                                    <label for="engine_power">Công suất động cơ (VD: 150 Mã lực / 2.0L)</label>
                                </div>
                            </div>

                            <div class="col-12">
                                <label class="text-white mb-2">Các tiện ích trên xe:</label>
                                <div class="row bg-white rounded p-3 mx-0">
                                    <div class="col-md-4 mb-2">
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" name="features[]" value="Map" id="feat1">
                                            <label class="form-check-label" for="feat1">Bản đồ / GPS</label>
                                        </div>
                                    </div>
                                    <div class="col-md-4 mb-2">
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" name="features[]" value="Bluetooth" id="feat2">
                                            <label class="form-check-label" for="feat2">Bluetooth / USB</label>
                                        </div>
                                    </div>
                                    <div class="col-md-4 mb-2">
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" name="features[]" value="Camera360" id="feat3">
                                            <label class="form-check-label" for="feat3">Camera 360 / Lùi</label>
                                        </div>
                                    </div>
                                    <div class="col-md-4 mb-2">
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" name="features[]" value="Sunroof" id="feat4">
                                            <label class="form-check-label" for="feat4">Cửa sổ trời</label>
                                        </div>
                                    </div>
                                    <div class="col-md-4 mb-2">
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" name="features[]" value="ETC" id="feat5">
                                            <label class="form-check-label" for="feat5">Thu phí không dừng (ETC)</label>
                                        </div>
                                    </div>
                                    <div class="col-md-4 mb-2">
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" name="features[]" value="Airbag" id="feat6">
                                            <label class="form-check-label" for="feat6">Túi khí an toàn</label>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-12">
                                <div class="form-group">
                                    <label for="car_image" class="text-white mb-2">Hình ảnh xe (Ảnh chụp thực tế)</label>
                                    <input type="file" class="form-control bg-white" id="car_image" name="car_image" accept="image/*" required>
                                </div>
                            </div>

                            <div class="col-12 mt-4">
                                <button class="btn btn-light w-100 py-3 fw-bold" type="submit">Đăng Ký Cho Thuê Ngay</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
