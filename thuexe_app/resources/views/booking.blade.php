@extends('layout/home')
@section('body')
    <div class="container-fluid bg-breadcrumb mb-5">
        <div class="container text-center py-5" style="max-width: 900px;">
            <h4 class="text-white display-4 mb-4 wow fadeInDown" data-wow-delay="0.1s">Booking</h4>
            <ol class="breadcrumb d-flex justify-content-center mb-0 wow fadeInDown" data-wow-delay="0.3s">
                <li class="breadcrumb-item"><a href="{{ route('home') }}">Trang chủ</a></li>
                <li class="breadcrumb-item"><a href="{{ route('vehicle') }}">Xe nổi bật</a></li>
                <li class="breadcrumb-item active text-primary">Booking</li>
            </ol>
        </div>
    </div>

    @php
        $imgUrl = !empty($xe->HinhAnh)
            ? \Illuminate\Support\Facades\Storage::url($xe->HinhAnh)
            : asset('img/car-1.png');
        $gearbox = optional(optional($xe->thongSo)->hopSo)->Ten_DM ?? (optional($xe->thongSo)->LoaiHopSo ?? '-');
        $fuel = optional(optional($xe->thongSo)->nhienLieu)->Ten_DM ?? (optional($xe->thongSo)->LoaiNhienLieu ?? '-');

        $ngayNhanValue = $ngayNhan ? $ngayNhan->format('Y-m-d\\TH:i') : '';
        $ngayTraValue = $ngayTra ? $ngayTra->format('Y-m-d\\TH:i') : '';
    @endphp

    <div class="container-fluid py-5">
        <div class="container">
            <div class="row g-4">
                <div class="col-lg-8">
                    <div class="bg-white rounded p-4 wow fadeInUp" data-wow-delay="0.1s">
                        <h2 class="fw-bold mb-3 text-center text-primary">Thông tin đặt xe</h2>

                        @if ($errors->any())
                            <div class="alert alert-danger">
                                <ul class="mb-0">
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif

                        <form method="POST" action="{{ route('booking.store', $xe->Ma_Xe) }}">
                            @csrf

                            <div class="row g-3">
                                <div class="col-md-6">
                                    <label class="form-label mb-1">Ngày nhận</label>
                                    <input type="datetime-local" class="form-control" name="Ngay_Bat_Dau"
                                        value="{{ old('Ngay_Bat_Dau', $ngayNhanValue) }}" required>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label mb-1">Ngày trả</label>
                                    <input type="datetime-local" class="form-control" name="Ngay_Ket_Thuc"
                                        value="{{ old('Ngay_Ket_Thuc', $ngayTraValue) }}" required>
                                </div>

                                <div class="col-12">
                                    <label class="form-label mb-1">Địa chỉ nhận xe</label>
                                    <input type="text" class="form-control" name="Dia_Diem_Nhan"
                                        value="{{ old('Dia_Diem_Nhan') }}" placeholder="Ví dụ: 123 Tên đường, Quận ...">
                                </div>

                                <div class="col-12">
                                    <label class="form-label mb-1">Ghi chú</label>
                                    <textarea class="form-control" rows="4" name="Ghi_Chu" placeholder="Yêu cầu thêm...">{{ old('Ghi_Chu', $ghiChu ?? '') }}</textarea>
                                </div>

                                <div class="col-12">
                                    <button type="submit" class="btn btn-danger w-100 py-3">
                                        <i class="fa fa-paper-plane me-2"></i>Xác nhận đặt xe
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>

                <div class="col-lg-4">
                    <div class="bg-white rounded p-4 mb-4 wow fadeInUp" data-wow-delay="0.2s"
                        data-gia-thue="{{ (float) $xe->GiaThue }}">
                        <h2 class="fw-bold mb-3 text-center text-primary">Xe đã chọn</h2>
                        <img src="{{ $imgUrl }}" class="img-fluid rounded mb-3" alt="{{ $xe->Ten_Xe }}">

                        <div class="fw-bold text-uppercase text-danger">{{ $xe->Ten_Xe }}</div>
                        <div class="text-muted mb-2">{{ $gearbox }} • {{ $fuel }} • {{ $xe->SoGhe }} chỗ
                        </div>

                        <div class="d-flex justify-content-between mb-2">
                            <span>Giá / ngày</span>
                            <span class="fw-bold">{{ number_format((float) $xe->GiaThue, 0, ',', '.') }}đ</span>
                        </div>

                        <div class="d-flex justify-content-between mb-2">
                            <span>Số ngày</span>
                            <span class="fw-bold" id="js-so-ngay">{{ $soNgay ?? '-' }}</span>
                        </div>

                        <hr>

                        <div class="d-flex justify-content-between mb-2">
                            <span>Tổng tiền</span>
                            <span class="fw-bold text-danger" id="js-tong-tien">
                                {{ $tongTien ? number_format($tongTien, 0, ',', '.') . 'đ' : '-' }}
                            </span>
                        </div>

                        <div class="d-flex justify-content-between">
                            <span>Tiền cọc (30%)</span>
                            <span class="fw-bold" id="js-tien-coc">
                                {{ $tienCoc ? number_format($tienCoc, 0, ',', '.') . 'đ' : '-' }}
                            </span>
                        </div>
                    </div>

                    <div class="bg-white rounded p-4 wow fadeInUp" data-wow-delay="0.3s">
                        <h2 class="fw-bold mb-3 text-center text-primary">Thông tin người thuê</h2>
                        <div class="small">
                            <div class="d-flex mb-2">
                                <i class="fa fa-user text-danger me-2 mt-1"></i>
                                <div><span class="fw-bold">Họ tên:</span> {{ $user->Ho_Ten ?? '-' }}</div>
                            </div>
                            <div class="d-flex mb-2">
                                <i class="fa fa-phone text-danger me-2 mt-1"></i>
                                <div><span class="fw-bold">SĐT:</span> {{ $user->So_Dien_Thoai ?? '-' }}</div>
                            </div>
                            <div class="d-flex">
                                <i class="fa fa-envelope text-danger me-2 mt-1"></i>
                                <div><span class="fw-bold">Email:</span> {{ $user->Email ?? '-' }}</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        (function() {
            const startInput = document.querySelector('input[name="Ngay_Bat_Dau"]');
            const endInput = document.querySelector('input[name="Ngay_Ket_Thuc"]');
            const summaryBox = document.querySelector('[data-gia-thue]');
            const soNgayEl = document.getElementById('js-so-ngay');
            const tongTienEl = document.getElementById('js-tong-tien');
            const tienCocEl = document.getElementById('js-tien-coc');

            if (!startInput || !endInput || !summaryBox || !soNgayEl || !tongTienEl || !tienCocEl) return;

            const dailyPrice = Number(summaryBox.getAttribute('data-gia-thue') || 0);

            const parseLocalDateTime = (value) => {
                if (!value || typeof value !== 'string') return null;
                const parts = value.split('T');
                if (parts.length !== 2) return null;
                const [y, m, d] = parts[0].split('-').map(Number);
                const [hh, mm] = parts[1].split(':').map(Number);
                if (!y || !m || !d || Number.isNaN(hh) || Number.isNaN(mm)) return null;
                return new Date(y, m - 1, d, hh, mm, 0, 0);
            };

            const formatVnd = (amount) => {
                const n = Math.round(Number(amount) || 0);
                return n.toLocaleString('vi-VN') + 'đ';
            };

            const updateSummary = () => {
                const start = parseLocalDateTime(startInput.value);
                const end = parseLocalDateTime(endInput.value);

                if (!start || !end || !(dailyPrice > 0) || end <= start) {
                    soNgayEl.textContent = '-';
                    tongTienEl.textContent = '-';
                    tienCocEl.textContent = '-';
                    return;
                }

                const diffMs = end.getTime() - start.getTime();
                const dayMs = 24 * 60 * 60 * 1000;
                let days = Math.ceil(diffMs / dayMs);
                if (days < 1) days = 1;

                const total = days * dailyPrice;
                const deposit = total * 0.3;

                soNgayEl.textContent = String(days);
                tongTienEl.textContent = formatVnd(total);
                tienCocEl.textContent = formatVnd(deposit);
            };

            startInput.addEventListener('change', updateSummary);
            endInput.addEventListener('change', updateSummary);
            updateSummary();
        })();
    </script>
@endsection
