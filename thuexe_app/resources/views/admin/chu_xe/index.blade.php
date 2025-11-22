@extends('layout.admin')
@section('body')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center my-3">
        <h3>Danh Sách Chủ Xe</h3>
        <button class="btn btn-primary"><i class="fa fa-plus"></i> Thêm Chủ Xe</button>
    </div>
    <div class="card mb-3 shadow-sm">
        <div class="card-header"><i class="fa fa-user-secret"></i> Đối tác cho thuê</div>
        <div class="card-body">
            <table class="table table-bordered table-hover">
                <thead class="thead-light">
                    <tr>
                        <th>ID</th>
                        <th>Tên Chủ Xe</th>
                        <th>Liên Hệ</th>
                        <th>Địa Chỉ</th>
                        <th>Số Xe Sở Hữu</th>
                        <th>Thao Tác</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($owners as $owner)
                    <tr>
                        <td>{{ $owner->Ma_CX }}</td>
                        <td class="font-weight-bold text-primary">{{ $owner->Ten_CX }}</td>
                        <td>
                            <div>{{ $owner->SoDT_CX }}</div>
                            <small>{{ $owner->Email_CX }}</small>
                        </td>
                        <td>{{ $owner->DiaChi_CX }}</td>
                        <td class="text-center">
                            <span class="badge badge-info" style="font-size: 14px">{{ $owner->xes_count }} Xe</span>
                        </td>
                        <td>
                            <button class="btn btn-sm btn-warning"><i class="fa fa-edit"></i></button>
                            <button class="btn btn-sm btn-danger"><i class="fa fa-trash"></i></button>
                        </td>
                    </tr>
                    @empty
                    <tr><td colspan="6" class="text-center">Chưa có chủ xe nào.</td></tr>
                    @endforelse
                </tbody>
            </table>
            <div class="mt-3">{{ $owners->links() }}</div>
        </div>
    </div>
</div>
@endsection