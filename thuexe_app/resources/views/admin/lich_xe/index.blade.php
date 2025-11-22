@extends('layout.admin')

@section('body')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center my-3">
        <h3 class="text-dark">Lịch Trình Xe</h3>
        <button class="btn btn-primary"><i class="fa fa-plus"></i> Thêm Lịch Bận</button>
    </div>

    <div class="card mb-3 shadow-sm">
        <div class="card-header">
            <i class="fa fa-calendar"></i> Quản lý trạng thái xe theo ngày
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered table-hover" width="100%" cellspacing="0">
                    <thead class="thead-light">
                        <tr>
                            <th>ID</th>
                            <th>Tên Xe</th>
                            <th>Biển Số</th>
                            <th>Ngày</th>
                            <th>Trạng Thái</th>
                            <th>Hành Động</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($schedules as $lich)
                        <tr>
                            <td>{{ $lich->Ma_Lich }}</td>
                            
                            <td class="font-weight-bold">{{ $lich->xe->Ten_Xe ?? 'Xe đã xóa' }}</td>
                            <td>{{ $lich->xe->BienSo ?? '---' }}</td>
                            
                            <td>{{ \Carbon\Carbon::parse($lich->Ngay)->format('d/m/Y') }}</td>
                            
                            <td class="text-center">
                                @if($lich->TrangThaiNgay == 'DangThue')
                                    <span class="badge badge-danger p-2">Đang Cho Thuê</span>
                                @elseif($lich->TrangThaiNgay == 'BaoTri')
                                    <span class="badge badge-warning p-2">Đang Bảo Trì</span>
                                @elseif($lich->TrangThaiNgay == 'Trong')
                                    <span class="badge badge-success p-2">Trống</span>
                                @else
                                    <span class="badge badge-secondary p-2">{{ $lich->TrangThaiNgay }}</span>
                                @endif
                            </td>
                            
                            <td>
                                <button class="btn btn-sm btn-warning"><i class="fa fa-edit"></i></button>
                                <button class="btn btn-sm btn-danger"><i class="fa fa-trash"></i></button>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="6" class="text-center text-muted py-3">
                                Chưa có lịch trình nào được ghi nhận.
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
                
                <div class="mt-3">{{ $schedules->links() }}</div>
            </div>
        </div>
    </div>
</div>
@endsection