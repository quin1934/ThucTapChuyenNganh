@extends('layout.admin')
@section('body')
    <div class="container-fluid">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Trang Chủ</a></li>
            <li class="breadcrumb-item active">Quản Lý Loại Xe</li>
        </ol>
        @if (session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif
        @if (session('error'))
            <div class="alert alert-danger">{{ session('error') }}</div>
        @endif

        <div class="card mb-3 shadow">
            <div class="card-header py-3 d-flex justify-content-between align-items-center">
                <h6 class="m-0 font-weight-bold text-primary">Loại Xe
                    ({{ $types->total() }})</h6>
                <a href="{{ route('phan-loai-xe.create') }}" class="btn btn-primary"><i class="fa fa-plus"></i> Thêm Loại
                    Mới</a>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered table-hover" id="dataTable" width="100%" cellspacing="0">
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
                                    <td class="font-weight-bold text-primary">{{ $type->Ten_PLXe }}</td>
                                    <td>{{ $type->MoTa_PLXe }}</td>
                                    <td class="text-center">
                                        <span class="badge badge-secondary p-2">{{ $type->xes_count }} xe</span>
                                    </td>
                                    <td>
                                        <a href="{{ route('phan-loai-xe.edit', $type->Ma_PLXe) }}"
                                            class="btn btn-sm btn-warning" title="Sửa">
                                            <i class="fa fa-edit"></i>
                                        </a>

                                        <form action="{{ route('phan-loai-xe.destroy', $type->Ma_PLXe) }}" method="POST"
                                            style="display:inline;"
                                            onsubmit="return confirm('Bạn chắc chắn muốn xóa loại xe này?');">
                                            @csrf @method('DELETE')
                                            <button class="btn btn-sm btn-danger" title="Xóa">
                                                <i class="fa fa-trash"></i>
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="text-center">Chưa có loại xe nào.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="card-footer small text-muted">Cập nhật lúc: {{ date('H:i d/m/Y') }}</div>
        </div>
    </div>
@endsection
