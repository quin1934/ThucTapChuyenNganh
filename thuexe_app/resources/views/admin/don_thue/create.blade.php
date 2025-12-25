@extends('layout.admin')
@section('body')
    <div class="container-fluid">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Trang Chủ</a></li>
            <li class="breadcrumb-item active"><a href="{{ route('don-thue.index') }}">Quản Lý Đơn Thuê Xe</a></li>
            <li class="breadcrumb-item active">Tạo Đơn Mới</li>
        </ol>
        <div class="card shadow mb-4">
            <div class="card-header py-3 bg-primary text-white">
                <h6 class="m-0 font-weight-bold text-center text-uppercase">Tạo Đơn Thuê Mới</h6>
            </div>
            <div class="card-body">
                <form action="{{ route('don-thue.store') }}" method="POST">
                    @csrf
                    <div class="row">
                        <div class="col-md-8">
                            <div class="form-group">
                                <label>Khách Hàng <span class="text-danger">*</span></label>
                                <select name="Ma_KT" class="form-control" required>
                                    <option value="">-- Chọn khách hàng --</option>
                                    @foreach ($khachThues as $kt)
                                        <option value="{{ $kt->Ma_KT }}">{{ $kt->Ho_Ten }} - {{ $kt->So_Dien_Thoai }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="form-group">
                                <label>Chọn Xe <span class="text-danger">*</span></label>
                                <select name="Ma_Xe" id="selectXe" class="form-control" required onchange="tinhTien()">
                                    <option value="" data-price="0">-- Chọn xe --</option>
                                    @foreach ($xes as $xe)
                                        <option value="{{ $xe->Ma_Xe }}" data-price="{{ $xe->GiaThue }}">
                                            {{ $xe->Ten_Xe }} - {{ $xe->BienSo }}
                                            ({{ number_format($xe->GiaThue) }}đ/ngày)
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="form-row">
                                <div class="form-group col-md-6">
                                    <label>Ngày Bắt Đầu <span class="text-danger">*</span></label>
                                    <input type="datetime-local" name="Ngay_Bat_Dau" id="startDate" class="form-control"
                                        required onchange="tinhTien()">
                                </div>
                                <div class="form-group col-md-6">
                                    <label>Ngày Kết Thúc <span class="text-danger">*</span></label>
                                    <input type="datetime-local" name="Ngay_Ket_Thuc" id="endDate" class="form-control"
                                        required onchange="tinhTien()">
                                </div>
                            </div>

                            <div class="form-group">
                                <label>Địa Điểm Nhận Xe</label>
                                <input type="text" name="Dia_Diem_Nhan" class="form-control"
                                    placeholder="Để trống nếu nhận tại cửa hàng">
                            </div>

                            <div class="form-group">
                                <label>Ghi Chú</label>
                                <textarea name="Ghi_Chu" class="form-control" rows="2"></textarea>
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="card bg-light border-left-success shadow h-100 py-2">
                                <div class="card-body">
                                    <div class="font-weight-bold text-success text-uppercase mb-1">Dự Tính Chi Phí</div>
                                    <hr>
                                    <div class="row no-gutters align-items-center mb-2">
                                        <div class="col mr-2">
                                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">Đơn Giá
                                                Xe</div>
                                            <div class="h5 mb-0 font-weight-bold text-gray-800" id="previewPrice">0 VNĐ
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row no-gutters align-items-center mb-2">
                                        <div class="col mr-2">
                                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">Số Ngày
                                                Thuê</div>
                                            <div class="h5 mb-0 font-weight-bold text-gray-800" id="previewDays">0 Ngày
                                            </div>
                                        </div>
                                    </div>
                                    <hr>
                                    <div class="row no-gutters align-items-center">
                                        <div class="col mr-2">
                                            <div class="text-xs font-weight-bold text-danger text-uppercase mb-1">TỔNG TIỀN
                                                (Dự kiến)</div>
                                            <div class="h4 mb-0 font-weight-bold text-danger" id="previewTotal">0 VNĐ</div>
                                        </div>
                                    </div>
                                    <div class="mt-3">
                                        <small>Tiền cọc (30%): <span id="previewDeposit" class="font-weight-bold">0
                                                VNĐ</span></small>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="text-center mt-4">
                        <button type="submit" class="btn btn-success btn-lg px-5"><i class="fa fa-check"></i> Tạo Đơn
                            Ngay</button>
                        <a href="{{ route('don-thue.index') }}" class="btn btn-secondary btn-lg px-5">Hủy</a>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        function formatMoney(number) {
            return number.toLocaleString('vi-VN', {
                style: 'currency',
                currency: 'VND'
            });
        }

        function tinhTien() {
            var selectXe = document.getElementById('selectXe');
            var price = selectXe.options[selectXe.selectedIndex].getAttribute('data-price') || 0;
            var start = new Date(document.getElementById('startDate').value);
            var end = new Date(document.getElementById('endDate').value);

            if (price > 0 && start && end && end > start) {
                var diffTime = Math.abs(end - start);
                var diffDays = Math.ceil(diffTime / (1000 * 60 * 60 * 24));
                if (diffDays < 1) diffDays = 1;
                var total = diffDays * price;
                var deposit = total * 0.3;
                document.getElementById('previewPrice').innerText = formatMoney(Number(price));
                document.getElementById('previewDays').innerText = diffDays + " Ngày";
                document.getElementById('previewTotal').innerText = formatMoney(total);
                document.getElementById('previewDeposit').innerText = formatMoney(deposit);
            }
        }
    </script>
@endsection
