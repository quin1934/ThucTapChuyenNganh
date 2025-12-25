@extends('layout.admin')
@section('body')
    <div class="container-fluid">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Trang Chủ</a></li>
            <li class="breadcrumb-item active">Quản Lý Thông Số</li>
        </ol>
        @if (session('success'))
            <div class="alert alert-success mt-3">{{ session('success') }}</div>
        @endif

        <ul class="nav nav-tabs mb-3">
            <li class="nav-item">
                <a class="nav-link {{ $type == 'NhienLieu' ? 'active font-weight-bold' : '' }}"
                    href="{{ route('danh_muc_thong_so.index', ['type' => 'NhienLieu']) }}">
                    <i class="fa fa-gas-pump"></i> Loại Nhiên Liệu
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link {{ $type == 'HopSo' ? 'active font-weight-bold' : '' }}"
                    href="{{ route('danh_muc_thong_so.index', ['type' => 'HopSo']) }}">
                    <i class="fa fa-cogs"></i> Loại Hộp Số
                </a>
            </li>
        </ul>

        <div class="card shadow">
            <div class="card-header py-3 d-flex justify-content-between align-items-center">
                <h6 class="m-0 font-weight-bold text-primary">Danh sách thông số ({{ $type == 'NhienLieu' ? 'Nhiên Liệu' : 'Hộp Số' }}) ({{ $items->total() }})</h6>
                <a href="{{ route('danh_muc_thong_so.create', ['type' => $type]) }}" class="btn btn-sm btn-primary shadow-sm">
                    <i class="fa fa-plus"></i> Thêm Mới
                </a>
            </div>
            <div class="card-body">
                <table class="table table-bordered table-hover" id="dataTable" width="100%" cellspacing="0">
                    <thead class="thead-light">
                        <tr>
                            <th width="5%" class="text-center">ID</th>
                            <th>Tên Loại</th>
                            <th>Mô tả</th>
                            <th width="15%" class="text-center">Thống kê</th>
                            <th width="15%" class="text-center">Hành động</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($items as $item)
                            <tr>
                                <td class="text-center">{{ $item->Ma_DM }}</td>
                                <td class="font-weight-bold text-primary">{{ $item->Ten_DM }}</td>
                                <td>{{ $item->MoTa_DM }}</td>

                                <td class="text-center">
                                    @if ($type == 'NhienLieu')
                                        <span class="badge badge-info">{{ $item->xe_su_dung_nhien_lieu_count }} xe</span>
                                    @else
                                        <span class="badge badge-info">{{ $item->xe_su_dung_hop_so_count }} xe</span>
                                    @endif
                                </td>

                                <td class="text-center">
                                    <a href="{{ route('danh_muc_thong_so.edit', $item->Ma_DM) }}"
                                        class="btn btn-sm btn-warning"><i class="fa fa-edit"></i></a>
                                    <form action="{{ route('danh_muc_thong_so.destroy', $item->Ma_DM) }}" method="POST"
                                        style="display:inline">
                                        @csrf @method('DELETE')
                                        <button class="btn btn-sm btn-danger"
                                            onclick="return confirm('Bạn chắc chắn muốn xóa? Các xe đang dùng loại này sẽ bị mất thông tin.')"><i
                                                class="fa fa-trash"></i></button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="text-center text-muted">Chưa có dữ liệu</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
                <div class="mt-3">
                    {{ $items->appends(['type' => $type])->links() }}
                </div>
            </div>
            <div class="card-footer small text-muted">Cập nhật lúc: {{ date('H:i d/m/Y') }}</div>
        </div>
    </div>
@endsection
