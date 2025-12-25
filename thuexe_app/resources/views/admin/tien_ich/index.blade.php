@extends('layout.admin')
@section('body')
    <div class="container-fluid">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Trang Chủ</a></li>
            <li class="breadcrumb-item active">Quản Lý Tiện Ích</li>
        </ol>
        @if (session('success'))
            <div class="alert alert-success mt-3">{{ session('success') }}</div>
        @endif
        @if (session('error'))
            <div class="alert alert-danger mt-3">{{ session('error') }}</div>
        @endif

        <div class="row">
            <div class="col-md-4">
                <div class="card shadow mb-4">
                    <div class="card-header py-3 d-flex justify-content-between align-items-center">
                        <h6 class="m-0 font-weight-bold text-primary"><i class="fa fa-tags"></i> Phân Loại Tiện Ích</h6>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('loai-tien-ich.store') }}" method="POST" class="mb-4">
                            @csrf
                            <div class="input-group">
                                <input type="text" name="Ten_LTI" class="form-control" placeholder="Tên loại mới..."
                                    required>
                                <div class="input-group-append">
                                    <button class="btn btn-primary" type="submit"><i class="fa fa-plus"></i></button>
                                </div>
                            </div>
                        </form>

                        <div class="table-responsive" style="max-height: 400px; overflow-y: auto;">
                            <table class="table table-sm table-bordered" >
                                <thead class="thead-light">
                                    <tr>
                                        <th>Tên Loại</th>
                                        <th class="text-center" width="30%">Xử lý</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($loaiTienIches as $loai)
                                        <tr>
                                            <td>
                                                <span class="font-weight-bold text-primary">{{ $loai->Ten_LTI }}</span><br>
                                                <small class="text-muted">({{ $loai->tien_iches_count }} mục)</small>
                                            </td>
                                            <td class="text-center">
                                                <button type="button" class="btn btn-xs btn-warning btn-sm"
                                                    data-toggle="modal" data-target="#editLoaiModal-{{ $loai->Ma_LTI }}">
                                                    <i class="fa fa-edit"></i>
                                                </button>

                                                <form action="{{ route('loai-tien-ich.destroy', $loai->Ma_LTI) }}"
                                                    method="POST" style="display:inline">
                                                    @csrf @method('DELETE')
                                                    <button class="btn btn-xs btn-danger btn-sm"
                                                        onclick="return confirm('Xóa loại này?')">
                                                        <i class="fa fa-trash"></i>
                                                    </button>
                                                </form>
                                            </td>
                                        </tr>

                                        <div class="modal fade" id="editLoaiModal-{{ $loai->Ma_LTI }}" tabindex="-1"
                                            role="dialog">
                                            <div class="modal-dialog" role="document">
                                                <div class="modal-content">
                                                    <form action="{{ route('loai-tien-ich.update', $loai->Ma_LTI) }}"
                                                        method="POST">
                                                        @csrf @method('PUT')
                                                        <div class="modal-header">
                                                            <h5 class="modal-title">Sửa Tên Loại</h5>
                                                            <button type="button" class="close"
                                                                data-dismiss="modal">&times;</button>
                                                        </div>
                                                        <div class="modal-body">
                                                            <label>Tên Loại</label>
                                                            <input type="text" name="Ten_LTI"
                                                                value="{{ $loai->Ten_LTI }}" class="form-control" required>
                                                        </div>
                                                        <div class="modal-footer">
                                                            <button type="submit" class="btn btn-primary">Lưu</button>
                                                            <button type="button" class="btn btn-secondary"
                                                                data-dismiss="modal">Đóng</button>
                                                        </div>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="card-footer small text-muted">Cập nhật lúc: {{ date('H:i d/m/Y') }}</div>
                </div>
            </div>

            <div class="col-md-8">
                <div class="card shadow mb-4">
                    <div class="card-header py-3 d-flex justify-content-between align-items-center">
                        <h6 class="m-0 font-weight-bold text-primary"><i class="fa fa-list"></i> Danh sách Tiện Ích
                            ({{ $tienichs->total() }})</h6>
                        <a href="{{ route('tien-ich.create') }}" class="btn btn-sm btn-primary shadow-sm">
                            <i class="fa fa-plus"></i> Thêm Tiện Ích
                        </a>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-bordered table-hover" id="dataTable" width="100%" cellspacing="0">
                                <thead class="thead-light">
                                    <tr>
                                        <th>ID</th>
                                        <th>Tên Tiện Ích</th>
                                        <th>Thuộc Loại</th>
                                        <th>Mô Tả</th>
                                        <th>Hành Động</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($tienichs as $ti)
                                        <tr>
                                            <td>{{ $ti->Ma_TI }}</td>
                                            <td class="font-weight-bold text-primary">{{ $ti->Ten_TI }}</td>
                                            <td>
                                                @php
                                                    $colors = [
                                                        'badge-primary',
                                                        'badge-success',
                                                        'badge-info',
                                                        'badge-warning',
                                                        'badge-danger',
                                                        'badge-dark',
                                                    ];

                                                    $id = $ti->loaiTienIch->Ma_LTI ?? 0;
                                                    if ($id > 0) {
                                                        $colorClass = $colors[($id - 1) % count($colors)];
                                                    } else {
                                                        $colorClass = 'badge-secondary';
                                                    }
                                                @endphp

                                                <span class="badge {{ $colorClass }} p-2" style="font-size: 0.9em;">
                                                    {{ $ti->loaiTienIch->Ten_LTI ?? 'Chưa phân loại' }}
                                                </span>
                                            </td>
                                            <td>{{ Str::limit($ti->MoTa_TI, 30) }}</td>
                                            <td>
                                                <a href="{{ route('tien-ich.edit', $ti->Ma_TI) }}"
                                                    class="btn btn-sm btn-warning"><i class="fa fa-edit"></i></a>
                                                <form action="{{ route('tien-ich.destroy', $ti->Ma_TI) }}" method="POST"
                                                    style="display:inline">
                                                    @csrf @method('DELETE')
                                                    <button class="btn btn-sm btn-danger"
                                                        onclick="return confirm('Xóa tiện ích này?')"><i
                                                            class="fa fa-trash"></i></button>
                                                </form>
                                                <a href="{{ route('tien-ich.show', $ti->Ma_TI) }}"
                                                    class="btn btn-sm btn-success"><i class="fa fa-eye"></i></a>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="5" class="text-center">Chưa có dữ liệu</td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                            <div class="mt-2 d-flex justify-content-end">
                                {!! $tienichs->links('pagination::bootstrap-4') !!}
                            </div>
                        </div>
                    </div>
                    <div class="card-footer small text-muted">Cập nhật lúc: {{ date('H:i d/m/Y') }}</div>
                </div>
            </div>
        </div>
    </div>
@endsection
