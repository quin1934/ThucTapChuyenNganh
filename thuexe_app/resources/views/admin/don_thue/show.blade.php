@extends('layout.admin')
@section('body')
    <div class="container-fluid">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Trang Chủ</a></li>
            <li class="breadcrumb-item active"><a href="{{ route('don-thue.index') }}">Quản Lý Đơn Thuê Xe</a></li>
            <li class="breadcrumb-item active">Xem Chi Tiết Đơn Mới <span class="text-danger">{{ $donThue->Ma_DT }}</span>
            </li>
        </ol>
        <div class="d-flex justify-content-end align-items-center mb-4">
            <div>
                @if (!in_array($donThue->Trang_Thai, ['DaTraXe', 'HoanThanh', 'DaHuy'], true))
                    <a href="{{ route('don-thue.edit', $donThue->Ma_DT) }}" class="btn btn-warning"><i
                            class="fa fa-edit"></i>
                        Sửa Thông Tin</a>
                @endif
                <a href="{{ route('don-thue.index') }}" class="btn btn-secondary"><i class="fa fa-arrow-left"></i> Quay
                    lại</a>
            </div>
        </div>

        @if (session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif
        @if (session('error'))
            <div class="alert alert-danger">{{ session('error') }}</div>
        @endif

        <div class="row">
            <div class="col-lg-8">

                <div class="card shadow mb-4">
                    <div class="card-header bg-primary text-white">
                        <h6 class="m-0 font-weight-bold"><i class="fa fa-file-invoice"></i> Thông Tin Thuê Xe</h6>
                    </div>
                    <div class="card-body">
                        <div class="row mb-3">
                            <div class="col-md-6 border-right">
                                <h6 class="text-primary font-weight-bold">KHÁCH HÀNG</h6>
                                <p class="mb-1"><strong>Họ tên:</strong> {{ $donThue->khachThue->Ho_Ten ?? '---' }}</p>
                                <p class="mb-1"><strong>SĐT:</strong> <a
                                        href="tel:{{ $donThue->khachThue->So_Dien_Thoai ?? '' }}">{{ $donThue->khachThue->So_Dien_Thoai ?? '---' }}</a>
                                </p>
                                <p class="mb-1"><strong>CCCD:</strong> {{ $donThue->khachThue->CCCD ?? '---' }}</p>
                            </div>
                            <div class="col-md-6 pl-4">
                                <h6 class="text-primary font-weight-bold">XE ĐƯỢC THUÊ</h6>
                                <p class="mb-1"><strong>Xe:</strong> <a href="{{ route('xe.show', $donThue->Ma_Xe) }}"
                                        target="_blank">{{ $donThue->xe->Ten_Xe ?? '---' }}</a></p>
                                <p class="mb-1"><strong>Biển Số:</strong> <span
                                        class="badge badge-dark px-2">{{ $donThue->xe->BienSo ?? '---' }}</span></p>
                                <p class="mb-1"><strong>Đơn Giá:</strong>
                                    {{ number_format($donThue->Gia_Thue_Ngay) }}đ/ngày</p>
                            </div>
                        </div>
                        <hr>
                        <div class="row">
                            <div class="col-md-6">
                                <p><strong>Ngày Nhận:</strong> <span
                                        class="text-info">{{ date('d/m/Y H:i', strtotime($donThue->Ngay_Bat_Dau)) }}</span>
                                </p>
                                <p><strong>Ngày Trả:</strong> <span
                                        class="text-info">{{ date('d/m/Y H:i', strtotime($donThue->Ngay_Ket_Thuc)) }}</span>
                                </p>
                                <p><strong>Địa Điểm:</strong> {{ $donThue->Dia_Diem_Nhan ?? 'Tại cửa hàng' }}</p>
                            </div>
                            <div class="col-md-6 text-right">
                                <h4 class="text-gray-800">Tổng Tiền: <span
                                        class="text-danger font-weight-bold">{{ number_format($donThue->Tong_Tien) }}đ</span>
                                </h4>
                                <p class="mb-0"><strong>Cọc Yêu Cầu (30%):</strong>
                                    {{ number_format($donThue->Tien_Coc) }}đ</p>
                                <p><small class="text-muted">(Đã bao gồm VAT nếu có)</small></p>
                            </div>
                        </div>

                        @if ($donThue->Ghi_Chu)
                            <div class="alert alert-warning mt-3">
                                <strong><i class="fa fa-sticky-note"></i> Ghi chú đơn:</strong> {{ $donThue->Ghi_Chu }}
                            </div>
                        @endif
                    </div>
                </div>

                <div class="card shadow mb-4">
                    <div class="card-header bg-success text-white d-flex justify-content-between align-items-center">
                        <h6 class="m-0 font-weight-bold"><i class="fa fa-money-bill-wave"></i> Lịch Sử Thanh Toán</h6>
                        <button class="btn btn-light btn-sm font-weight-bold text-success" data-toggle="modal"
                            data-target="#modalThanhToan">
                            <i class="fa fa-plus"></i> Tạo Phiếu Thu
                        </button>
                    </div>
                    <div class="card-body">
                        @php
                            $daThanhToan = $donThue->thanhToans->sum('So_Tien');
                            $conLai = $donThue->Tong_Tien - $daThanhToan;
                        @endphp

                        <div class="row text-center mb-4">
                            <div class="col-md-4">
                                <div class="p-2 bg-light rounded border">
                                    <small class="text-muted">Tổng giá trị đơn</small>
                                    <h5 class="font-weight-bold text-dark">{{ number_format($donThue->Tong_Tien) }}đ</h5>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="p-2 bg-light rounded border">
                                    <small class="text-muted">Đã thanh toán</small>
                                    <h5 class="font-weight-bold text-success">{{ number_format($daThanhToan) }}đ</h5>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="p-2 bg-light rounded border">
                                    <small class="text-muted">Còn lại phải thu</small>
                                    <h5 class="font-weight-bold {{ $conLai > 0 ? 'text-danger' : 'text-success' }}">
                                        {{ number_format($conLai) }}đ
                                    </h5>
                                </div>
                            </div>
                        </div>

                        <div class="table-responsive">
                            <table class="table table-bordered table-sm">
                                <thead class="thead-light">
                                    <tr>
                                        <th>Thời gian</th>
                                        <th>Loại</th>
                                        <th>Số tiền</th>
                                        <th>Phương thức</th>
                                        <th>Bill</th>
                                        <th>Xóa</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($donThue->thanhToans as $tt)
                                        <tr>
                                            <td>{{ date('d/m H:i', strtotime($tt->created_at)) }}</td>
                                            <td>
                                                @if ($tt->Loai_Thanh_Toan == 'TienCoc')
                                                    <span class="badge badge-warning">Cọc</span>
                                                @elseif($tt->Loai_Thanh_Toan == 'PhatSinh')
                                                    <span class="badge badge-danger">Phạt</span>
                                                @else
                                                    <span class="badge badge-success">Thanh toán</span>
                                                @endif
                                            </td>
                                            <td class="font-weight-bold">{{ number_format($tt->So_Tien) }}đ</td>
                                            <td>
                                                {{ $tt->Phuong_Thuc }}
                                                @if ($tt->Ma_Giao_Dich)
                                                    <br><small class="text-muted">#{{ $tt->Ma_Giao_Dich }}</small>
                                                @endif
                                            </td>
                                            <td class="text-center">
                                                @if ($tt->Hinh_Anh_Bill)
                                                    <a href="{{ asset('storage/' . $tt->Hinh_Anh_Bill) }}"
                                                        target="_blank">Xem ảnh</a>
                                                @else
                                                    -
                                                @endif
                                            </td>
                                            <td class="text-center">
                                                <form action="{{ route('thanh-toan.destroy', $tt->Ma_TT) }}" method="POST"
                                                    onsubmit="return confirm('Xóa phiếu thu này?');">
                                                    @csrf @method('DELETE')
                                                    <button class="btn btn-sm text-danger"><i
                                                            class="fa fa-trash"></i></button>
                                                </form>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="6" class="text-center text-muted">Chưa có giao dịch nào.</td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

                <div class="card shadow mb-4">
                    <div class="card-header py-3 bg-warning text-white">
                        <h6 class="m-0 font-weight-bold"><i class="fa fa-star"></i> Đánh Giá & Phản Hồi</h6>
                    </div>
                    <div class="card-body">
                        @php
                            $review = \App\Models\DanhGia::where('Ma_DT', $donThue->Ma_DT)->first();
                        @endphp

                        @if ($review)
                            <div class="text-center">
                                <div class="h1 text-warning mb-2">
                                    @for ($i = 1; $i <= 5; $i++)
                                        @if ($i <= $review->So_Sao)
                                            <i class="fa fa-star"></i>
                                        @else
                                            <i class="fa fa-star-o text-muted" style="opacity: 0.3"></i>
                                        @endif
                                    @endfor
                                </div>
                                <h5 class="font-weight-bold">{{ $review->So_Sao }}/5 Sao</h5>
                                <p class="font-italic text-muted">"{{ $review->Noi_Dung }}"</p>
                                <small class="text-muted">Đánh giá ngày:
                                    {{ date('d/m/Y H:i', strtotime($review->created_at)) }}</small>
                            </div>
                        @elseif($donThue->Trang_Thai == 'DaTraXe' || $donThue->Trang_Thai == 'HoanThanh')
                            <div class="text-center">
                                <p>Khách hàng chưa để lại đánh giá cho chuyến đi này.</p>
                                <button class="btn btn-warning btn-icon-split" data-toggle="modal"
                                    data-target="#modalDanhGia">
                                    <span class="icon text-white-50"><i class="fa fa-star"></i></span>
                                    <span class="text">Nhập Đánh Giá Ngay</span>
                                </button>
                            </div>
                        @else
                            <div class="text-center text-muted">
                                <i class="fa fa-lock"></i> Chỉ có thể đánh giá khi đơn hàng đã hoàn tất (Đã trả xe).
                            </div>
                        @endif
                    </div>
                </div>

            </div>

            <div class="col-lg-4">

                <div class="card shadow mb-4">
                    <div class="card-header bg-info text-white">
                        <h6 class="m-0 font-weight-bold"><i class="fa fa-tasks"></i> Quy Trình Xử Lý</h6>
                    </div>
                    <div class="card-body text-center">
                        <div class="mb-4">
                            <span class="d-block text-muted small mb-2">Trạng thái hiện tại</span>
                            @if ($donThue->Trang_Thai == 'ChoDuyet')
                                <span class="badge badge-warning p-2 w-100" style="font-size: 1.2em">⏳ Chờ Duyệt</span>
                            @elseif($donThue->Trang_Thai == 'DaDuyet')
                                <span class="badge badge-info p-2 w-100" style="font-size: 1.2em">✅ Đã Duyệt - Chờ
                                    Cọc</span>
                            @elseif($donThue->Trang_Thai == 'DaDatCoc')
                                <span class="badge badge-primary p-2 w-100" style="font-size: 1.2em">💰 Đã Cọc - Chờ Giao
                                    Xe</span>
                            @elseif(
                                $donThue->Trang_Thai == 'DangDiChuyen' ||
                                    $donThue->Trang_Thai == 'DaGiaoXe' ||
                                    $donThue->Trang_Thai == 'DangHoatDong')
                                <span class="badge badge-success p-2 w-100" style="font-size: 1.2em">🚗 Đang di
                                    chuyển</span>
                            @elseif($donThue->Trang_Thai == 'DaTraXe' || $donThue->Trang_Thai == 'HoanThanh')
                                <span class="badge badge-secondary p-2 w-100" style="font-size: 1.2em">🏁 Hoàn tất</span>
                            @elseif($donThue->Trang_Thai == 'QuaHan')
                                <span class="badge badge-dark p-2 w-100" style="font-size: 1.2em">⏰ Quá hạn</span>
                            @elseif($donThue->Trang_Thai == 'DaHuy')
                                <span class="badge badge-danger p-2 w-100" style="font-size: 1.2em">❌ Đã hủy</span>
                            @else
                                <span class="badge badge-light border p-2 w-100"
                                    style="font-size: 1.2em">{{ $donThue->Trang_Thai }}</span>
                            @endif
                        </div>

                        <form action="{{ route('don-thue.update', $donThue->Ma_DT) }}" method="POST">
                            @csrf @method('PUT')

                            @if ($donThue->Trang_Thai == 'ChoDuyet')
                                <button name="Trang_Thai" value="DaDuyet"
                                    class="btn btn-success btn-block mb-2 font-weight-bold">✅ DUYỆT ĐƠN NÀY</button>
                                <button name="Trang_Thai" value="DaHuy" class="btn btn-outline-danger btn-block"
                                    onclick="return confirm('Bạn chắc chắn muốn hủy đơn này?')">❌ Từ Chối / Hủy</button>
                            @elseif($donThue->Trang_Thai == 'DaDuyet')
                                <div class="alert alert-light border p-2 mb-2"><small>Khách đã chuyển khoản cọc
                                        chưa?</small></div>
                                <button name="Trang_Thai" value="DaDatCoc"
                                    class="btn btn-primary btn-block font-weight-bold">💰 XÁC NHẬN ĐÃ CỌC</button>
                                <button name="Trang_Thai" value="DaHuy" class="btn btn-link text-danger mt-2">Hủy
                                    Đơn</button>
                            @elseif($donThue->Trang_Thai == 'DaDatCoc')
                                <div class="alert alert-light border p-2 mb-2"><small>Đến ngày và khách đã nhận xe?</small>
                                </div>
                                <button name="Trang_Thai" value="DangDiChuyen"
                                    class="btn btn-info btn-block font-weight-bold">🔑 XÁC NHẬN ĐÃ NHẬN XE</button>
                            @elseif(
                                $donThue->Trang_Thai == 'DangDiChuyen' ||
                                    $donThue->Trang_Thai == 'DaGiaoXe' ||
                                    $donThue->Trang_Thai == 'DangHoatDong')
                                <div class="alert alert-light border p-2 mb-2"><small>Khách trả xe & thanh toán đủ?</small>
                                </div>
                                <button name="Trang_Thai" value="HoanThanh"
                                    class="btn btn-secondary btn-block font-weight-bold">🏁 XÁC NHẬN TRẢ XE</button>
                            @endif
                        </form>
                    </div>
                </div>



            </div>
        </div>
    </div>

    <div class="modal fade" id="modalThanhToan" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header bg-success text-white">
                    <h5 class="modal-title">Tạo Phiếu Thu Mới</h5>
                    <button type="button" class="close text-white" data-dismiss="modal">&times;</button>
                </div>
                <form action="{{ route('thanh-toan.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" name="Ma_DT" value="{{ $donThue->Ma_DT }}">
                    <div class="modal-body">
                        <div class="form-group">
                            <label>Loại thanh toán</label>
                            <select name="Loai_Thanh_Toan" class="form-control">
                                <option value="TienCoc">Đặt Cọc (30%)</option>
                                <option value="ThanhToan">Thanh Toán (Trả xe)</option>
                                <option value="PhatSinh">Phụ Phí / Phạt</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label>Số tiền thu (VNĐ)</label>
                            <input type="number" name="So_Tien" class="form-control font-weight-bold text-success"
                                value="{{ $conLai > 0 ? $conLai : '' }}" required>
                            <small class="text-muted">Nhập số tiền thực tế nhận được.</small>
                        </div>
                        <div class="form-group">
                            <label>Phương thức</label>
                            <select name="Phuong_Thuc" class="form-control">
                                <option value="TienMat">Tiền Mặt</option>
                                <option value="ChuyenKhoan">Chuyển Khoản</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label>Mã Giao Dịch (Nếu CK)</label>
                            <input type="text" name="Ma_Giao_Dich" class="form-control"
                                placeholder="VD: FT123456...">
                        </div>
                        <div class="form-group">
                            <label>Ảnh Bill (Nếu có)</label>
                            <input type="file" name="Hinh_Anh_Bill" class="form-control-file">
                        </div>
                        <div class="form-group">
                            <label>Ghi chú</label>
                            <textarea name="Ghi_Chu" class="form-control" rows="2"></textarea>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Đóng</button>
                        <button type="submit" class="btn btn-success">Lưu Phiếu Thu</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="modal fade" id="modalDanhGia" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header bg-warning text-white">
                    <h5 class="modal-title">Đánh Giá Chuyến Đi</h5>
                    <button type="button" class="close text-white" data-dismiss="modal">&times;</button>
                </div>
                <form action="{{ route('danh-gia.store') }}" method="POST">
                    @csrf
                    <input type="hidden" name="Ma_DT" value="{{ $donThue->Ma_DT }}">
                    <div class="modal-body">
                        <div class="form-group text-center">
                            <label class="font-weight-bold d-block mb-3">Mức độ hài lòng</label>

                            <div class="btn-group-toggle d-flex justify-content-center" data-toggle="buttons">

                                <label class="btn btn-outline-warning border-0 rounded m-1 font-weight-bold">
                                    <input type="radio" name="So_Sao" value="1" autocomplete="off" required>
                                    1 <i class="fa fa-star"></i>
                                </label>

                                <label class="btn btn-outline-warning border-0 rounded m-1 font-weight-bold">
                                    <input type="radio" name="So_Sao" value="2" autocomplete="off">
                                    2 <i class="fa fa-star"></i>
                                </label>

                                <label class="btn btn-outline-warning border-0 rounded m-1 font-weight-bold">
                                    <input type="radio" name="So_Sao" value="3" autocomplete="off">
                                    3 <i class="fa fa-star"></i>
                                </label>

                                <label class="btn btn-outline-warning border-0 rounded m-1 font-weight-bold">
                                    <input type="radio" name="So_Sao" value="4" autocomplete="off">
                                    4 <i class="fa fa-star"></i>
                                </label>

                                <label class="btn btn-outline-warning border-0 rounded m-1 active font-weight-bold">
                                    <input type="radio" name="So_Sao" value="5" autocomplete="off" checked>
                                    5 <i class="fa fa-star"></i>
                                </label>

                            </div>
                        </div>

                        <div class="form-group mt-4">
                            <label>Nhận xét của khách</label>
                            <textarea name="Noi_Dung" class="form-control" rows="3" placeholder="Nhập nhận xét..." required></textarea>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Đóng</button>
                        <button type="submit" class="btn btn-warning">Gửi Đánh Giá</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

@endsection
