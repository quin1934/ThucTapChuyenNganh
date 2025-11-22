@extends('layout.admin')

@section('body')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center my-3">
        <h3 class="text-dark">Danh Mục Tiện Ích</h3>
        <button class="btn btn-primary"><i class="fa fa-plus"></i> Thêm Tiện Ích</button>
    </div>

    <div class="card mb-3 shadow-sm">
        <div class="card-header">
            <i class="fa fa-list-ul"></i> Danh sách các tiện ích có sẵn
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered table-hover" width="100%" cellspacing="0">
                    <thead class="thead-light">
                        <tr>
                            <th width="10%">ID</th>
                            <th width="25%">Tên Tiện Ích</th>
                            <th>Mô Tả</th>
                            <th width="15%">Hành Động</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($tienichs as $ti)
                        <tr>
                            <td class="text-center">{{ $ti->Ma_TI }}</td>
                            <td class="font-weight-bold text-primary">{{ $ti->Ten_TI }}</td>
                            <td>{{ $ti->MoTa_TI ?? 'Không có mô tả' }}</td>
                            <td class="text-center">
                                <button class="btn btn-sm btn-warning"><i class="fa fa-edit"></i> Sửa</button>
                                <button class="btn btn-sm btn-danger"><i class="fa fa-trash"></i> Xóa</button>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="4" class="text-center text-muted py-3">
                                Chưa có tiện ích nào. Hãy thêm mới!
                            </td>
                        </tr>
                        @endforelse
                        </tbody>
                </table>
                
                <div class="mt-3">
                    {{ $tienichs->links() }}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection