@extends('layout.admin')
@section('body')
    <div class="container-fluid">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Trang Chủ</a></li>
            <li class="breadcrumb-item active"><a href="{{ route('quan-tri-vien.index') }}">Quản Trị Viên</a></li>
            <li class="breadcrumb-item active">Chi Tiết Quản Trị Viên</li>
        </ol>
        <div class="card shadow" style="max-width: 600px; margin: 0 auto;">
            <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
                <h5 class="m-0 font-weight-bold">Chi Tiết Quản Trị Viên</h5>
                <a href="{{ route('quan-tri-vien.index') }}" class="btn btn-sm btn-light text-dark"><i
                        class="fa fa-arrow-left"></i> Quay lại</a>
            </div>
            <div class="card-body">
                <div class="text-center mb-4">
                    <h4 class="mt-2 text-dark font-weight-bold">{{ $admin->name }}</h4>
                    @if ($admin->id == 1)
                        <span class="badge badge-danger">MASTER ADMIN</span>
                    @else
                        <span class="badge badge-info text-uppercase">{{ $admin->VaiTro ? $admin->VaiTro : 'Admin' }}</span>
                    @endif
                </div>

                <ul class="list-group list-group-flush">
                    <li class="list-group-item d-flex justify-content-between">
                        <strong>Mã QTV (ID):</strong>
                        <span>{{ $admin->id }}</span>
                    </li>
                    <li class="list-group-item d-flex justify-content-between">
                        <strong>Họ Tên (Ten_QTV):</strong>
                        <span>{{ $admin->name }}</span>
                    </li>
                    <li class="list-group-item d-flex justify-content-between">
                        <strong>Email (Login):</strong>
                        <span>{{ $admin->email }}</span>
                    </li>
                    <li class="list-group-item d-flex justify-content-between">
                        <strong>Vai Trò (VaiTro):</strong>
                        <span>{{ $admin->id == 1 ? 'Master Admin' : ($admin->VaiTro ? $admin->VaiTro : 'Admin') }}</span>
                    </li>
                    <li class="list-group-item d-flex justify-content-between">
                        <strong>Ngày tham gia:</strong>
                        <span>{{ $admin->created_at->format('d/m/Y H:i:s') }}</span>
                    </li>
                </ul>
            </div>
            <div class="card-footer text-center">
                <a href="{{ route('quan-tri-vien.edit', $admin->id) }}" class="btn btn-warning"><i class="fa fa-edit"></i>
                    Chỉnh Sửa</a>
            </div>
        </div>
    </div>
@endsection
