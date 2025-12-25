@extends('layout.admin')
@section('body')
    <div class="container-fluid">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Trang Chủ</a></li>
            <li class="breadcrumb-item active">Quản Lý Chủ Xe</li>
        </ol>
        @if (session('success'))
            <div class="alert alert-success mt-3">{{ session('success') }}</div>
        @endif

        <div class="card shadow">
            <div class="card-header py-3 d-flex justify-content-between align-items-center">
                <h6 class="m-0 font-weight-bold text-primary">Danh sách chủ xe ({{ $chuXes->total() }})</h6>
                <a href="{{ route('chu-xe.create') }}" class="btn btn-sm btn-primary shadow-sm">
                    <i class="fa fa-plus"></i> Thêm Mới
                </a>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered table-hover">
                        <thead class="thead-light">
                            <tr>
                                <th>ID</th>
                                <th>Thông Tin Cá Nhân</th>
                                <th>Tài Khoản Ngân Hàng</th>
                                <th>Trạng Thái</th>
                                <th>Hành Động</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($chuXes as $cx)
                                <tr>
                                    <td class="text-center font-weight-bold">{{ $cx->Ma_CX }}</td>
                                    <td>
                                        <strong class="text-primary">{{ $cx->Ten_CX }}</strong><br>
                                        <small><i class="fa fa-envelope"></i> {{ $cx->Email_CX }} (Login)</small><br>
                                        <small><i class="fa fa-phone"></i> {{ $cx->SoDT_CX }}</small><br>
                                        <small class="text-muted"><i class="fa fa-map-marker"></i>
                                            {{ $cx->DiaChi_CX }}</small>
                                    </td>
                                    <td>
                                        @if ($cx->SoTKNH_CX)
                                            <span class="font-weight-bold text-dark">{{ $cx->SoTKNH_CX }}</span>
                                        @else
                                            <span class="text-muted small">---</span>
                                        @endif
                                    </td>
                                    <td class="text-center">
                                        @if ($cx->Trang_Thai == 'DaDuyet')
                                            <span class="badge badge-success">Đã Duyệt</span>
                                        @elseif($cx->Trang_Thai == 'ChoDuyet')
                                            <span class="badge badge-warning">Chờ Duyệt</span>
                                        @else
                                            <span class="badge badge-danger">Đã Khóa</span>
                                        @endif
                                    </td>
                                    <td class="text-center">
                                        <a href="{{ route('chu-xe.edit', $cx->Ma_CX) }}" class="btn btn-warning btn-sm"
                                            title="Sửa"><i class="fa fa-edit"></i></a>
                                        <form action="{{ route('chu-xe.destroy', $cx->Ma_CX) }}" method="POST"
                                            style="display:inline">
                                            @csrf @method('DELETE')
                                            <button class="btn btn-danger btn-sm"
                                                onclick="return confirm('Xóa chủ xe này?')"><i
                                                    class="fa fa-trash"></i></button>
                                        </form>
                                        <a href="{{ route('chu-xe.show', $cx->Ma_CX) }}" class="btn btn-success btn-sm"
                                            title="Xem"><i class="fa fa-eye"></i></a>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="text-center">Chưa có dữ liệu</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                    <div class="d-flex justify-content-center">{{ $chuXes->links() }}</div>
                </div>
            </div>
            <div class="card-footer small text-muted">Cập nhật lúc: {{ date('H:i d/m/Y') }}</div>
        </div>
    </div>
@endsection
