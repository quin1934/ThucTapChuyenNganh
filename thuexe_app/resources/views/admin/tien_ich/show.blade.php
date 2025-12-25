@extends('layout.admin')
@section('body')
<div class="container-fluid">
    <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Trang Chủ</a></li>
            <li class="breadcrumb-item active"><a href="{{ route('tien-ich.index') }}">Quản Lý Tiện Ích</a></li>
            <li class="breadcrumb-item active">Chi tiết tiện ích <span class="text-danger">{{ $tienich->Ten_TI }}</span></li>
        </ol>
    <div class="d-flex justify-content-end align-items-center my-3">
        <a href="{{ route('tien-ich.index') }}" class="btn btn-secondary">Quay lại</a>
    </div>

    <div class="row">
        <div class="col-md-4">
            <div class="card shadow mb-4">
                <div class="card-header py-3 bg-info text-white">
                    <h6 class="m-0 font-weight-bold">Thông tin chung</h6>
                </div>
                <div class="card-body text-center">
                    <div class="mb-3">
                        <span class="display-4 font-weight-bold">{{ $tienich->xes_count }}</span><br>
                        <small class="text-muted">Xe đang trang bị</small>
                    </div>
                    <hr>
                    <p class="text-left"><strong>Phân Loại:</strong> 
                        <span class="badge badge-info">{{ $tienich->loaiTienIch->Ten_LTI ?? 'N/A' }}</span>
                    </p>
                    <p class="text-left"><strong>Mô tả:</strong> {{ $tienich->MoTa_TI ?? 'Không có mô tả' }}</p>
                </div>
            </div>
        </div>

        <div class="col-md-8">
            <div class="card shadow mb-4">
                <div class="card-header py-3"><h6 class="m-0 font-weight-bold text-primary">Danh sách xe sử dụng</h6></div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered">
                            <thead class="bg-light">
                                <tr>
                                    <th>Biển Số</th>
                                    <th>Tên Xe</th>
                                    <th>Chủ Xe</th>
                                    <th>Hành động</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($cars as $car)
                                <tr>
                                    <td class="font-weight-bold">{{ $car->BienSo }}</td>
                                    <td>{{ $car->Ten_Xe }}</td>
                                    <td>{{ $car->chuXe->Ten_CX ?? 'N/A' }}</td>
                                    <td>
                                        <a href="{{ route('xe.show', $car->Ma_Xe) }}" class="btn btn-sm btn-primary">
                                            <i class="fa fa-car"></i> Xem Xe
                                        </a>
                                    </td>
                                </tr>
                                @empty
                                <tr><td colspan="4" class="text-center text-muted">Chưa có xe nào trang bị tiện ích này.</td></tr>
                                @endforelse
                            </tbody>
                        </table>
                        <div class="mt-2">{{ $cars->links() }}</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection