@extends('layout.admin')
@section('body')
<div class="container-fluid">
    <h3 class="my-3 text-dark">Quản Lý Khách Thuê</h3>
    <div class="card mb-3 shadow-sm">
        <div class="card-header"><i class="fa fa-users"></i> Danh sách khách hàng ({{ $customers->total() }})</div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered table-hover" width="100%" cellspacing="0">
                    <thead class="thead-light">
                        <tr>
                            <th>ID</th>
                            <th>Họ Tên</th>
                            <th>SĐT / Email</th>
                            <th>CCCD</th>
                            <th>Ngày Đăng Ký</th>
                            <th>Thao Tác</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($customers as $cus)
                        <tr>
                            <td>{{ $cus->Ma_KT }}</td>
                            <td class="font-weight-bold">{{ $cus->Ten_KT }}</td>
                            <td>
                                <div><i class="fa fa-phone"></i> {{ $cus->SoDT_KT }}</div>
                                <small class="text-muted">{{ $cus->Email_KT }}</small>
                            </td>
                            <td>{{ $cus->CCCD_KT }}</td>
                            <td>{{ $cus->created_at ? $cus->created_at->format('d/m/Y') : 'Không rõ' }}</td>          
                            <td>
                                <button class="btn btn-sm btn-info" title="Xem chi tiết"><i class="fa fa-eye"></i></button>
                                <button class="btn btn-sm btn-danger" title="Khóa tài khoản"><i class="fa fa-lock"></i></button>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="6" class="text-center text-muted">Chưa có khách thuê nào.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
                <div class="mt-3">{{ $customers->links() }}</div>
            </div>
        </div>
    </div>
</div>
@endsection