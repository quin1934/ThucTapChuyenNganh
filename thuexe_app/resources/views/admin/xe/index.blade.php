@extends('layout.admin')

@section('body')
    <div class="container-fluid">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Trang Chủ</a></li>
            <li class="breadcrumb-item active">Quản Lý Xe</li>
        </ol>
        @if (session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        <div class="card mb-3 shadow">
            <div class="card-header py-3 d-flex justify-content-between align-items-center">
                <h6 class="m-0 font-weight-bold text-primary">Danh sách xe ({{ $cars->total() }})</h6>
                <a href="{{ route('xe.create') }}" class="btn btn-sm btn-primary shadow-sm">
                    <i class="fa fa-plus"></i> Thêm Xe Mới
                </a>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                        <thead class="bg-light text-dark">
                            <tr>
                                <th>ID</th>
                                <th>Thông tin xe</th>
                                <th>Chủ xe</th>
                                <th>Hình Ảnh</th>
                                <th>Trạng Thái</th>
                                <th width="150">Hành động</th>
                                <th width="120">Thao Tác</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($cars as $car)
                                <tr>
                                    <td>{{ $car->Ma_Xe }}</td>
                                    <td>
                                        <strong>{{ $car->Ten_Xe }}</strong><br>
                                        <small class="text-primary">{{ $car->BienSo }}</small><br>
                                        <span class="badge badge-info">{{ $car->phanLoaiXe->Ten_PLXe ?? 'N/A' }}</span>
                                        - {{ $car->NamSX }}
                                        <div class="text-danger font-weight-bold">
                                            {{ number_format($car->GiaThue, 0, ',', '.') }} VNĐ/ngày
                                        </div>
                                    </td>
                                    <td>
                                        {{ $car->chuXe->Ten_CX ?? 'Unknown' }} <br>
                                        <small>{{ $car->chuXe->SoDT_CX ?? '' }}</small>
                                    </td>

                                    <td>
                                        @if ($car->HinhAnh)
                                            <img src="{{ asset('storage/' . $car->HinhAnh) }}" alt="Hình xe"
                                                width="100" class="img-thumbnail">
                                        @else
                                            <img src="{{ asset('images/default-car.png') }}" alt="Chưa có hình"
                                                width="100">
                                        @endif
                                    </td>

                                    <td class="text-center align-middle">
                                        @if ($car->TrangThai_Xe == 'SanSang')
                                            <span class="badge badge-success px-2 py-1">Sẵn sàng</span>
                                        @elseif($car->TrangThai_Xe == 'ChoDuyet')
                                            <span class="badge badge-warning px-2 py-1">Chờ duyệt</span>
                                        @elseif($car->TrangThai_Xe == 'DangThue')
                                            <span class="badge badge-primary px-2 py-1">Đang thuê</span>
                                        @elseif($car->TrangThai_Xe == 'BaoTri')
                                            <span class="badge badge-secondary px-2 py-1">Bảo trì</span>
                                        @elseif($car->TrangThai_Xe == 'BiCam')
                                            <span class="badge badge-danger px-2 py-1">Đang bị cấm</span>
                                        @elseif($car->TrangThai_Xe == 'TamAn')
                                            <span class="badge badge-light border px-2 py-1">Tạm ẩn</span>
                                        @elseif($car->TrangThai_Xe == 'DaTuChoi')
                                            <span class="badge badge-dark px-2 py-1">Đã từ chối</span>
                                        @else
                                            <span class="badge badge-light border">{{ $car->TrangThai_Xe }}</span>
                                        @endif
                                    </td>

                                    <td class="align-middle">
                                        <form action="{{ route('xe.update', $car->Ma_Xe) }}" method="POST">
                                            @csrf
                                            @method('PATCH')
                                            <input type="hidden" name="_mode" value="status">

                                            @if ($car->TrangThai_Xe == 'ChoDuyet')
                                                <button type="submit" name="status" value="SanSang"
                                                    class="btn btn-sm btn-success w-100 mb-1" title="Duyệt xe này">
                                                    <i class="fa fa-check"></i> Duyệt
                                                </button>
                                                <button type="submit" name="status" value="DaTuChoi"
                                                    class="btn btn-sm btn-outline-danger w-100" title="Từ chối đăng ký">
                                                    <i class="fa fa-times"></i> Từ chối
                                                </button>
                                            @elseif($car->TrangThai_Xe == 'SanSang' || $car->TrangThai_Xe == 'TamAn')
                                                <button type="submit" name="status" value="BiCam"
                                                    class="btn btn-sm btn-danger w-100"
                                                    onclick="return confirm('Bạn có chắc muốn cấm xe này hoạt động?')"
                                                    title="Phạt/Cấm xe">
                                                    <i class="fa fa-ban"></i> Cấm xe
                                                </button>
                                            @elseif($car->TrangThai_Xe == 'BiCam')
                                                <button type="submit" name="status" value="SanSang"
                                                    class="btn btn-sm btn-success w-100" title="Mở khóa xe">
                                                    <i class="fa fa-unlock"></i> Gỡ cấm
                                                </button>
                                            @else
                                                <small class="text-muted text-center d-block">Không khả dụng</small>
                                            @endif
                                        </form>
                                    </td>

                                    <td class="align-middle text-center">
                                        <a href="{{ route('xe.edit', $car->Ma_Xe) }}" class="btn btn-sm btn-warning mb-1"
                                            title="Sửa"><i class="fa fa-edit"></i></a>
                                        <form action="{{ route('xe.destroy', $car->Ma_Xe) }}" method="POST"
                                            style="display:inline;" onsubmit="return confirm('Xóa vĩnh viễn xe này?');">
                                            @csrf @method('DELETE')
                                            <button class="btn btn-sm btn-danger" title="Xóa"><i
                                                    class="fa fa-trash"></i></button>
                                        </form>
                                        <a href="{{ route('xe.show', $car->Ma_Xe) }}" class="btn btn-sm btn-success"
                                            title="Xem chi tiết">
                                            <i class="fa fa-eye"></i>
                                        </a>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="7" class="text-center">Chưa có dữ liệu</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                    <div class="d-flex justify-content-center mt-3">{{ $cars->links() }}</div>
                </div>
            </div>
            <div class="card-footer small text-muted">Cập nhật lúc: {{ date('H:i d/m/Y') }}</div>
        </div>
    </div>
@endsection
