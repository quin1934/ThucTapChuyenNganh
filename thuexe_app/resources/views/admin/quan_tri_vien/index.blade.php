@extends('layout.admin')

@section('body')
    <div class="container-fluid">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Trang Chủ</a></li>
            <li class="breadcrumb-item active">Quản Lý Quản Trị Viên</li>
        </ol>

        @if (session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif
        @if (session('error'))
            <div class="alert alert-danger">{{ session('error') }}</div>
        @endif

        <div class="card mb-3 shadow">
            <div class="card-header py-3 d-flex justify-content-between align-items-center">
                <h6 class="m-0 font-weight-bold text-primary">Tài khoản hệ thống
                    ({{ $admins->total() }})</h6>
                <a href="{{ route('quan-tri-vien.create') }}" class="btn btn-primary"><i class="fa fa-plus"></i> Thêm Admin
                    Mới</a>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                        <thead class="thead-light">
                            <tr>
                                <th>ID</th>
                                <th>Họ Tên</th>
                                <th>Email</th>
                                <th>Vai Trò</th>
                                <th>Ngày Tạo</th>
                                <th width="150px">Hành Động</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($admins as $admin)
                                <tr class="{{ $admin->id == 1 ? 'table-warning' : '' }}">
                                    <td>{{ $admin->id }}</td>
                                    <td>
                                        <strong>{{ $admin->name }}</strong>
                                        @if (auth()->id() == $admin->id)
                                            <span class="badge badge-success ml-1">Bạn</span>
                                        @endif
                                    </td>
                                    <td>{{ $admin->email }}</td>
                                    <td>
                                        @if ($admin->id == 1)
                                            <span class="badge badge-danger text-uppercase">Master Admin</span>
                                        @else
                                            <span class="badge badge-info text-uppercase">
                                                {{ $admin->VaiTro ? $admin->VaiTro : 'Admin' }}
                                            </span>
                                        @endif
                                    </td>
                                    <td>{{ $admin->created_at ? $admin->created_at->format('d/m/Y') : 'N/A' }}</td>
                                    <td>
                                        @php
                                            $isMaster = $admin->id == 1;
                                            $isMe = auth()->id() == $admin->id;
                                            $iAmMaster = auth()->id() == 1;
                                            $canEdit = $isMe || ($iAmMaster && !$isMaster);
                                            $canDelete = !$isMe && !$isMaster;
                                        @endphp

                                        @if ($canEdit)
                                            <a href="{{ route('quan-tri-vien.edit', $admin->id) }}"
                                                class="btn btn-sm btn-warning" title="Sửa"><i class="fa fa-edit"></i></a>
                                        @else
                                            <button class="btn btn-sm btn-secondary" disabled title="Không đủ quyền"><i
                                                    class="fa fa-lock"></i></button>
                                        @endif

                                        @if ($canDelete)
                                            <form action="{{ route('quan-tri-vien.destroy', $admin->id) }}" method="POST"
                                                style="display:inline-block"
                                                onsubmit="return confirm('Bạn có chắc muốn xóa tài khoản này?');">
                                                @csrf
                                                @method('DELETE')
                                                <button class="btn btn-sm btn-danger" title="Xóa"><i
                                                        class="fa fa-trash"></i></button>
                                            </form>
                                        @else
                                            <button class="btn btn-sm btn-secondary" disabled><i
                                                    class="fa fa-trash"></i></button>
                                        @endif
                                        <a href="{{ route('quan-tri-vien.show', $admin->id) }}"
                                            class="btn btn-sm btn-success" title="Xem Chi Tiết"><i
                                                class="fa fa-eye"></i></a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>

                    <div class="mt-3 d-flex justify-content-center">
                        {{ $admins->links() }}
                    </div>
                </div>
            </div>
            <div class="card-footer small text-muted">Cập nhật lúc: {{ date('H:i d/m/Y') }}</div>
        </div>
    </div>
@endsection
