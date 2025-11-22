@extends('layout.admin')
@section('body')
<div class="container-fluid">
    <h3 class="my-3">Quản Lý Đơn Đặt Xe</h3>
    <div class="card mb-3 shadow-sm">
        <div class="card-header"><i class="fa fa-shopping-cart"></i> Danh sách đơn hàng</div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-striped" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>Mã Đơn</th>
                            <th>Khách Hàng</th>
                            <th>Xe Thuê</th>
                            <th>Lịch Trình</th>
                            <th>Tổng Tiền</th>
                            <th>Trạng Thái</th>
                            <th>Xử Lý</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($bookings as $book)
                        <tr>
                            <td><strong>#{{ $book->Ma_Don }}</strong></td>
                            <td>
                                {{ $book->khachThue->Ten_KT ?? 'Khách vãng lai' }}<br>
                                <small>{{ $book->khachThue->SoDT_KT ?? '' }}</small>
                            </td>
                            <td>{{ $book->xe->Ten_Xe ?? 'Xe đã xóa' }}</td>
                            <td>
                                <small>Từ: {{ \Carbon\Carbon::parse($book->NgayBD)->format('d/m/Y H:i') }}</small><br>
                                <small>Đến: {{ \Carbon\Carbon::parse($book->NgayKT)->format('d/m/Y H:i') }}</small>
                            </td>
                            <td class="text-danger font-weight-bold">{{ number_format($book->TongTien) }} đ</td>
                            <td>
                                @if($book->TrangThai_Don == 'ChoDuyet')
                                    <span class="badge badge-warning">Chờ duyệt</span>
                                @elseif($book->TrangThai_Don == 'DaDuyet')
                                    <span class="badge badge-primary">Đã duyệt</span>
                                @elseif($book->TrangThai_Don == 'HoanThanh')
                                    <span class="badge badge-success">Hoàn thành</span>
                                @else
                                    <span class="badge badge-danger">{{ $book->TrangThai_Don }}</span>
                                @endif
                            </td>
                            <td>
                                <button class="btn btn-sm btn-success" title="Duyệt"><i class="fa fa-check"></i></button>
                                <button class="btn btn-sm btn-secondary" title="Chi tiết"><i class="fa fa-list"></i></button>
                            </td>
                        </tr>
                        @empty
                        <tr><td colspan="7" class="text-center text-muted">Chưa có đơn hàng nào.</td></tr>
                        @endforelse
                    </tbody>
                </table>
                <div class="mt-3">{{ $bookings->links() }}</div>
            </div>
        </div>
    </div>
</div>
@endsection