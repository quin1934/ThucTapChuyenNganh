@extends('layout.admin')
@section('body')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center my-3">
        <h3>Danh Mục Loại Xe</h3>
        <button class="btn btn-primary"><i class="fa fa-plus"></i> Thêm Loại Mới</button>
    </div>
    <div class="card mb-3">
        <div class="card-body">
            <table class="table table-bordered">
                <thead class="thead-light">
                    <tr>
                        <th>ID</th>
                        <th>Tên Loại</th>
                        <th>Mô Tả</th>
                        <th>Số Lượng Xe</th>
                        <th>Thao Tác</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($types as $type)
                    <tr>
                        <td>{{ $type->Ma_PLXe }}</td>
                        <td class="font-weight-bold">{{ $type->Ten_PLXe }}</td>
                        <td>{{ $type->MoTa_PLXe }}</td>
                        <td class="text-center"><span class="badge badge-secondary">{{ $type->xes_count }}</span></td>
                        <td>
                            <button class="btn btn-sm btn-warning"><i class="fa fa-edit"></i></button>
                            <button class="btn btn-sm btn-danger"><i class="fa fa-trash"></i></button>
                        </td>
                    </tr>
                    @empty
                    <tr><td colspan="5" class="text-center">Chưa có loại xe nào.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection