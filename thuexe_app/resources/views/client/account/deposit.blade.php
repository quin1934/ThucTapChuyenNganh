@extends('layout.home')

@section('body')
    <div class="container-fluid bg-breadcrumb mb-5">
        <div class="container text-center py-5" style="max-width: 900px;">
            <h4 class="text-white display-4 mb-4 wow fadeInDown" data-wow-delay="0.1s">Thanh Toán Đặt Cọc</h4>
            <ol class="breadcrumb d-flex justify-content-center mb-0 wow fadeInDown" data-wow-delay="0.3s">
                <li class="breadcrumb-item"><a href="{{ route('home') }}">Trang Chủ</a></li>
                <li class="breadcrumb-item"><a href="{{ route('client.history') }}">Lịch Sử Thuê Xe</a></li>
                <li class="breadcrumb-item active text-primary">Thanh toán đặt cọc</li>
            </ol>
        </div>
    </div>

    <div class="container py-5">
        @if (session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif
        @if (session('error'))
            <div class="alert alert-danger">{{ session('error') }}</div>
        @endif

        <div class="row justify-content-center">
            <div class="col-lg-10">
                <div class="card shadow-lg border-0 rounded-3 overflow-hidden">
                    <div class="card-header bg-dark text-white py-3">
                        <h3 class="mb-0">Thông tin đặt cọc</h3>
                    </div>

                    <div class="card-body">
                        <div class="row g-4">
                            <div class="col-lg-7">
                                <div class="p-3 rounded-3" style="border: 1px solid #e9ecef;">
                                    <div class="text-muted mb-2">Đơn thuê</div>
                                    <div class="fw-bold" style="font-size: 18px;">#{{ $donThue->Ma_DT }}</div>

                                    <hr>

                                    <div class="d-flex justify-content-between">
                                        <div class="text-muted">Xe</div>
                                        <div class="fw-semibold">{{ $donThue->xe?->Ten_Xe ?? '-' }}</div>
                                    </div>
                                    <div class="d-flex justify-content-between mt-2">
                                        <div class="text-muted">Tiền cọc</div>
                                        <div class="fw-bold text-primary">{{ number_format($tienCoc, 0, ',', '.') }} đ</div>
                                    </div>

                                    <div class="text-muted mt-3" style="font-size: 13px;">
                                        Mô phỏng thanh toán: bấm nút "Thanh toán" để xác nhận đã đặt cọc.
                                    </div>
                                </div>
                            </div>

                            <div class="col-lg-5">
                                <div class="p-3 rounded-3" style="border: 1px solid #e9ecef;">
                                    <div class="text-muted mb-2">Phương thức</div>
                                    <div class="fw-semibold">Chuyển khoản</div>

                                    <hr>

                                    <form method="POST" action="{{ route('client.deposit', $donThue->Ma_DT) }}">
                                        @csrf
                                        <button type="submit" class="btn btn-danger w-100">
                                            Thanh toán
                                        </button>
                                    </form>

                                    <a href="{{ route('client.history') }}" class="btn btn-outline-secondary w-100 mt-2">
                                        Quay lại
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
