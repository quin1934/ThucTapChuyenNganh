@extends('layout.admin')
@section('body')
    <div class="container-fluid">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Trang Chủ</a></li>
            <li class="breadcrumb-item active">Quản Lý Thanh Toán</li>
        </ol>
        <div class="card shadow mb-4">
            <div class="card-header py-3 d-flex justify-content-between align-items-center">
                <h6 class="m-0 font-weight-bold text-primary">Lịch Sử Giao Dịch Thanh Toán ({{ $thanhToans->total() }})</h6>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered table-striped" width="100%" cellspacing="0">
                        <thead>
                            <tr>
                                <th>Mã GD</th>
                                <th>Đơn Thuê</th>
                                <th>Khách Hàng</th>
                                <th>Số Tiền</th>
                                <th>Loại / Phương Thức</th>
                                <th>Ngày Thu</th>
                                <th>Chi Tiết</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($thanhToans as $tt)
                                <tr>
                                    <td>#{{ $tt->Ma_TT }}</td>
                                    <td>
                                        <a href="{{ route('don-thue.show', $tt->Ma_DT) }}">Đơn #{{ $tt->Ma_DT }}</a>
                                        <br>
                                        <small>{{ $tt->donThue->xe->BienSo ?? '---' }}</small>
                                    </td>
                                    <td>{{ $tt->donThue->khachThue->Ho_Ten ?? '---' }}</td>
                                    <td class="font-weight-bold text-success">{{ number_format($tt->So_Tien) }}đ</td>
                                    <td>
                                        @if ($tt->Loai_Thanh_Toan == 'TienCoc')
                                            <span class="badge badge-warning">Cọc</span>
                                        @elseif($tt->Loai_Thanh_Toan == 'PhatSinh')
                                            <span class="badge badge-danger">Phạt</span>
                                        @else
                                            <span class="badge badge-success">Thanh toán</span>
                                        @endif
                                        <br>
                                        <small class="text-muted">{{ $tt->Phuong_Thuc }}</small>
                                    </td>
                                    <td>{{ date('d/m/Y H:i', strtotime($tt->created_at)) }}</td>
                                    <td>
                                        <a href="{{ route('don-thue.show', $tt->Ma_DT) }}" class="btn btn-sm btn-success">
                                            <i class="fa fa-eye"></i>
                                        </a>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="7" class="text-center">Chưa có giao dịch nào.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                    <div class="mt-3">
                        {{ $thanhToans->links() }}
                    </div>
                </div>
            </div>
            <div class="card-footer small text-muted">Cập nhật lúc: {{ date('H:i d/m/Y') }}</div>
        </div>
    </div>
@endsection
