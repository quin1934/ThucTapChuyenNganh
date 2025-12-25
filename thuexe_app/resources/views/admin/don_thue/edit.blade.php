@extends('layout.admin')
@section('body')
    <div class="container-fluid">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Trang Chủ</a></li>
            <li class="breadcrumb-item active"><a href="{{ route('don-thue.index') }}">Quản Lý Đơn Thuê Xe</a></li>
            <li class="breadcrumb-item active">Cập Nhật Đơn Mới</li>
        </ol>
        <div class="card shadow mb-4">
            <div class="card-header py-3 bg-primary text-white">
                <h6 class="m-0 font-weight-bold text-center text-uppercase">Chỉnh Sửa Đơn Thuê {{ $donThue->Ma_DT }}</h6>
            </div>
            <div class="card-body">
                @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul class="mb-0">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form action="{{ route('don-thue.update', $donThue->Ma_DT) }}" method="POST">
                    @csrf @method('PUT')

                    <div class="alert alert-info">
                        <i class="fa fa-info-circle"></i> <strong>Lưu ý:</strong> Việc thay đổi Xe hoặc Ngày thuê sẽ làm
                        thay
                        đổi <strong>Tổng Tiền</strong> của đơn hàng.
                    </div>

                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label>Khách Hàng</label>
                            <input type="text" class="form-control"
                                value="{{ $donThue->khachThue->Ho_Ten }} - {{ $donThue->khachThue->So_Dien_Thoai }}"
                                readonly style="background-color: #eaecf4; cursor: not-allowed;">

                            <input type="hidden" name="Ma_KT" value="{{ $donThue->Ma_KT }}">

                            <small class="text-muted"><i class="fa fa-lock"></i> Không thể thay đổi khách hàng của đơn đã
                                tạo.</small>
                        </div>
                        <div class="form-group col-md-6">
                            <label>Xe Thuê</label>
                            <select name="Ma_Xe" id="select_xe" class="form-control select2">
                                @foreach ($xes as $xe)
                                    <option value="{{ $xe->Ma_Xe }}" data-price="{{ $xe->GiaThue }}"
                                        {{ $donThue->Ma_Xe == $xe->Ma_Xe ? 'selected' : '' }}>
                                        {{ $xe->Ten_Xe }} - {{ $xe->BienSo }}
                                        ({{ number_format($xe->GiaThue) }}đ/ngày)
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label>Ngày Bắt Đầu</label>
                            <input type="datetime-local" name="Ngay_Bat_Dau" id="start_date" class="form-control"
                                value="{{ date('Y-m-d\TH:i', strtotime($donThue->Ngay_Bat_Dau)) }}" required>
                        </div>
                        <div class="form-group col-md-6">
                            <label>Ngày Kết Thúc</label>
                            <input type="datetime-local" name="Ngay_Ket_Thuc" id="end_date" class="form-control"
                                value="{{ date('Y-m-d\TH:i', strtotime($donThue->Ngay_Ket_Thuc)) }}" required>
                        </div>
                    </div>

                    <div class="card bg-light mb-3">
                        <div class="card-body py-2 text-center">
                            <span class="text-muted mr-3">Dự kiến tổng tiền mới:</span>
                            <strong class="text-danger h5" id="preview_total">---</strong>
                        </div>
                    </div>

                    <div class="form-group">
                        <label>Địa Điểm Nhận Xe</label>
                        <input type="text" name="Dia_Diem_Nhan" class="form-control"
                            value="{{ $donThue->Dia_Diem_Nhan }}">
                    </div>

                    <div class="form-group">
                        <label>Ghi Chú</label>
                        <textarea name="Ghi_Chu" class="form-control" rows="3">{{ $donThue->Ghi_Chu }}</textarea>
                    </div>

                    <div class="text-center mt-4">
                        <button type="submit" class="btn btn-warning btn-lg px-5"><i class="fa fa-save"></i> Cập Nhật
                            Đơn</button>
                        <a href="{{ route('don-thue.index') }}" class="btn btn-secondary btn-lg px-5">Hủy</a>
                    </div>
                </form>
            </div>
        </div>
    </div>

    {{-- Script tính tiền đơn giản để Admin xem trước --}}
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const startInput = document.getElementById('start_date');
            const endInput = document.getElementById('end_date');
            const xeSelect = document.getElementById('select_xe');
            const previewText = document.getElementById('preview_total');

            function calculateTotal() {
                const start = new Date(startInput.value);
                const end = new Date(endInput.value);
                const price = parseFloat(xeSelect.options[xeSelect.selectedIndex].getAttribute('data-price')) || 0;
                if (start && end && end > start) {
                    const hours = Math.abs(end - start) / 36e5;
                    const days = Math.ceil(hours / 24);
                    const total = days * price;
                    previewText.innerText = new Intl.NumberFormat('vi-VN', {
                        style: 'currency',
                        currency: 'VND'
                    }).format(total) + " (" + days + " ngày)";
                } else {
                    previewText.innerText = "---";
                }
            }

            startInput.addEventListener('change', calculateTotal);
            endInput.addEventListener('change', calculateTotal);
            xeSelect.addEventListener('change', calculateTotal);
            calculateTotal();
        });
    </script>
@endsection
