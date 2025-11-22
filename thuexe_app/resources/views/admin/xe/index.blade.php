@extends('layout.admin')

@section('body')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center my-3">
        <h3 class="text-dark">Danh Sách Phương Tiện</h3>
        <a href="{{ route('xe.create') }}" class="btn btn-primary"><i class="fa fa-plus"></i> Thêm Xe Mới</a>
    </div>

    <div class="card mb-3">
        <div class="card-header">
            <i class="fa fa-car"></i> Toàn bộ đội xe ({{ $cars->total() }})
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered table-hover" id="dataTable" width="100%" cellspacing="0">
                    <thead class="thead-light">
                        <tr>
                            <th>ID</th>
                            <th>Biển Số</th>
                            <th>Tên Xe</th>
                            <th>Loại Xe</th>
                            <th>Chủ Xe</th>
                            <th>Năm SX</th>
                            <th>Trạng Thái</th>
                            <th>Thao Tác</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($cars as $car)
                        <tr>
                            <td>{{ $car->Ma_Xe }}</td>
                            
                            <td class="font-weight-bold text-primary">{{ $car->BienSo }}</td>
                            
                            <td>{{ $car->Ten_Xe }}</td>
                            
                            <td>{{ $car->phanLoaiXe->Ten_PLXe ?? 'Chưa phân loại' }}</td>
                            
                            <td>{{ $car->chuXe->Ten_CX ?? 'Không rõ' }}</td>
                            
                            <td>{{ $car->NamSX }}</td>
                            
                            <td class="text-center">
                                @if($car->TrangThai_Xe == 'SanSang')
                                    <span class="badge badge-success p-2">Sẵn sàng</span>
                                @elseif($car->TrangThai_Xe == 'DangThue')
                                    <span class="badge badge-primary p-2">Đang thuê</span>
                                @else
                                    <span class="badge badge-secondary p-2">{{ $car->TrangThai_Xe }}</span>
                                @endif
                            </td>
                            
                            <td>
                                <div class="btn-group">
                                    <button class="btn btn-sm btn-info" title="Xem"><i class="fa fa-eye"></i></button>
                                    <button class="btn btn-sm btn-warning" title="Sửa"><i class="fa fa-edit"></i></button>
                                    <form action="{{ route('xe.destroy', $car->Ma_Xe) }}" method="POST" style="display:inline;" onsubmit="return confirm('Xóa xe này?');">
                                        @csrf @method('DELETE')
                                        <button class="btn btn-sm btn-danger" title="Xóa"><i class="fa fa-trash"></i></button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="8" class="text-center text-muted py-4">
                                Chưa có xe nào trong hệ thống. Hãy thêm xe mới!
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>

                <div class="mt-3 d-flex justify-content-center">
                    {{ $cars->links() }}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection