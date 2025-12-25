@extends('layout.admin')
@section('body')
    <div class="container-fluid">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Trang Chủ</a></li>
            <li class="breadcrumb-item active">Quản Lý Đơn Thuê Xe</li>
        </ol>
        @if (session('success'))
            <div class="alert alert-success mt-3 border-left-success alert-dismissible fade show">
                <i class="fa fa-check-circle"></i> {{ session('success') }}
                <button type="button" class="close" data-dismiss="alert">&times;</button>
            </div>
        @endif
        @if (session('error'))
            <div class="alert alert-danger mt-3 border-left-danger alert-dismissible fade show">
                <i class="fa fa-exclamation-circle"></i> {{ session('error') }}
                <button type="button" class="close" data-dismiss="alert">&times;</button>
            </div>
        @endif

        <div class="card shadow mb-4">
            <div class="card-header py-3 d-flex justify-content-between align-items-center">
                <h6 class="m-0 font-weight-bold text-primary">Danh sách tất cả đơn hàng ({{ $donThues->total() }})</h6>
                <a href="{{ route('don-thue.create') }}" class="btn btn-primary shadow-sm font-weight-bold">
                    <i class="fa fa-plus-circle"></i> Tạo Đơn Mới
                </a>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered table-hover" id="dataTable" width="100%" cellspacing="0">
                        <thead class="thead-light">
                            <tr>
                                <th width="5%">Mã</th>
                                <th width="20%">Khách Hàng</th>
                                <th width="20%">Xe Thuê</th>
                                <th width="20%">Lịch Trình</th>
                                <th width="15%">Tổng Tiền</th>
                                <th width="10%">Trạng Thái</th>
                                <th width="10%">Hành Động</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($donThues as $dt)
                                <tr>
                                    <td class="text-center font-weight-bold align-middle">#{{ $dt->Ma_DT }}</td>

                                    <td class="align-middle">
                                        @if ($dt->khachThue)
                                            <div class="font-weight-bold">{{ $dt->khachThue->Ho_Ten }}</div>
                                            <small class="text-muted"><i class="fa fa-phone"></i>
                                                {{ $dt->khachThue->So_Dien_Thoai }}</small>
                                        @else
                                            <span class="text-danger font-italic">Khách đã bị xóa</span>
                                        @endif
                                    </td>

                                    <td class="align-middle">
                                        @if ($dt->xe)
                                            <div class="text-primary font-weight-bold">{{ $dt->xe->Ten_Xe }}</div>
                                            <span class="badge badge-dark">{{ $dt->xe->BienSo }}</span>
                                        @else
                                            <span class="text-danger font-italic">Xe đã bị xóa</span>
                                        @endif
                                    </td>

                                    <td class="align-middle small">
                                        <div><i class="fa fa-calendar-check text-success"></i> Từ:
                                            {{ date('d/m/Y H:i', strtotime($dt->Ngay_Bat_Dau)) }}</div>
                                        <div><i class="fa fa-calendar-times text-danger"></i> Đến:
                                            {{ date('d/m/Y H:i', strtotime($dt->Ngay_Ket_Thuc)) }}</div>
                                    </td>

                                    <td class="align-middle">
                                        <div class="font-weight-bold text-danger">{{ number_format($dt->Tong_Tien) }}đ
                                        </div>
                                        <small class="text-muted">Cọc: {{ number_format($dt->Tien_Coc) }}đ</small>
                                    </td>

                                    <td class="text-center align-middle">
                                        @if ($dt->Trang_Thai == 'ChoDuyet')
                                            <span class="badge badge-warning px-2 py-1">⏳ Chờ Duyệt</span>
                                        @elseif($dt->Trang_Thai == 'DaDuyet')
                                            <span class="badge badge-info px-2 py-1">✅ Chờ Cọc</span>
                                        @elseif($dt->Trang_Thai == 'DaDatCoc')
                                            <span class="badge badge-primary px-2 py-1">💰 Đã Cọc</span>
                                        @elseif($dt->Trang_Thai == 'DangDiChuyen' || $dt->Trang_Thai == 'DaGiaoXe')
                                            <span class="badge badge-info px-2 py-1">🚗 Đang di chuyển</span>
                                        @elseif($dt->Trang_Thai == 'DangHoatDong')
                                            <span class="badge badge-success px-2 py-1">🚗 Đang Đi</span>
                                        @elseif($dt->Trang_Thai == 'DaTraXe' || $dt->Trang_Thai == 'HoanThanh')
                                            <span class="badge badge-secondary px-2 py-1">🏁 Hoàn Tất</span>
                                        @elseif($dt->Trang_Thai == 'QuaHan')
                                            <span class="badge badge-dark px-2 py-1">⏰ Quá hạn</span>
                                        @elseif($dt->Trang_Thai == 'DaHuy')
                                            <span class="badge badge-danger px-2 py-1">❌ Đã Hủy</span>
                                        @else
                                            <span class="badge badge-light border px-2 py-1">{{ $dt->Trang_Thai }}</span>
                                        @endif
                                    </td>

                                    <td class="text-center">
                                        <div class="btn-group" role="group">
                                            @if (!in_array($dt->Trang_Thai, ['DaTraXe', 'HoanThanh', 'DaHuy'], true))
                                                <a href="{{ route('don-thue.edit', $dt->Ma_DT) }}"
                                                    class="btn btn-warning btn-sm" title="Sửa thông tin">
                                                    <i class="fa fa-edit"></i>
                                                </a>
                                            @endif

                                            @if (in_array($dt->Trang_Thai, ['ChoDuyet', 'DaHuy', 'QuaHan']))
                                                <form action="{{ route('don-thue.destroy', $dt->Ma_DT) }}" method="POST"
                                                    style="display:inline">
                                                    @csrf @method('DELETE')
                                                    <button class="btn btn-danger btn-sm"
                                                        onclick="return confirm('Bạn có chắc muốn xóa vĩnh viễn đơn này không?')"
                                                        title="Xóa">
                                                        <i class="fa fa-trash"></i>
                                                    </button>
                                                </form>
                                            @endif
                                            <a href="{{ route('don-thue.show', $dt->Ma_DT) }}"
                                                class="btn btn-success btn-sm" title="Xem chi tiết">
                                                <i class="fa fa-eye"></i>
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="7" class="text-center text-muted py-4">
                                        <i class="fa fa-folder-open fa-3x mb-3"></i><br>
                                        Chưa có đơn thuê nào trong hệ thống.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <div class="d-flex justify-content-center mt-3">
                    {{ $donThues->links() }}
                </div>
            </div>
            <div class="card-footer small text-muted">Cập nhật lúc: {{ date('H:i d/m/Y') }}</div>
        </div>
    </div>
@endsection
