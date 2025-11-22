@extends('layout.admin')

@section('body')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center my-3">
        <h3 class="text-dark">Danh Sách Quản Trị Viên</h3>
        <a href="#" class="btn btn-primary"><i class="fa fa-plus"></i> Thêm Admin Mới</a>
    </div>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif
    @if(session('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
    @endif

    <div class="card mb-3">
        <div class="card-header">
            <i class="fa fa-user-circle"></i> Tài khoản có quyền truy cập hệ thống
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered table-hover" width="100%" cellspacing="0">
                    <thead class="thead-light">
                        <tr>
                            <th>ID</th>
                            <th>Họ Tên</th>
                            <th>Email</th>
                            <th>Ngày Tạo</th>
                            <th>Hành Động</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($admins as $admin)
                        <tr>
                            <td>{{ $admin->id }}</td>
                            <td>
                                <strong>{{ $admin->name }}</strong>
                                @if(auth()->id() == $admin->id)
                                    <span class="badge badge-success ml-2">Bạn</span>
                                @endif
                            </td>
                            <td>{{ $admin->email }}</td>
                            <td>{{ $admin->created_at->format('d/m/Y H:i') }}</td>
                            <td>
                                <button class="btn btn-sm btn-warning" title="Sửa"><i class="fa fa-edit"></i></button>
                                
                                @if(auth()->id() != $admin->id)
                                <form action="{{ route('quan-tri-vien.destroy', $admin->id) }}" method="POST" style="display:inline-block" onsubmit="return confirm('Bạn có chắc muốn xóa tài khoản này?');">
                                    @csrf
                                    @method('DELETE')
                                    <button class="btn btn-sm btn-danger" title="Xóa"><i class="fa fa-trash"></i></button>
                                </form>
                                @else
                                    <button class="btn btn-sm btn-secondary" disabled><i class="fa fa-trash"></i></button>
                                @endif
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
                
                <div class="mt-3">
                    {{ $admins->links() }}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection