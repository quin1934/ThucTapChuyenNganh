@extends('layout.admin')
@section('body')
    <div class="container-fluid">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Trang Chủ</a></li>
            <li class="breadcrumb-item active">Quản Lý Khách Thuê</li>
        </ol>
        @if (session('success'))
            <div class="alert alert-success mt-3">{{ session('success') }}</div>
        @endif

        <div class="card shadow">
            <div class="card-header py-3 d-flex justify-content-between align-items-center">
                <h6 class="m-0 font-weight-bold text-primary">Danh sách khách hàng ({{ $khachs->total() }})</h6>
                <a href="{{ route('khach-thue.create') }}" class="btn btn-primary"><i class="fa fa-user-plus"></i> Thêm
                    Khách</a>
            </div>
            <div class="card-body">
                <table class="table table-bordered table-hover">
                    <thead class="thead-light">
                        <tr>
                            <th>ID</th>
                            <th>Họ Tên & Liên Hệ</th>
                            <th>Thông Tin Bằng Lái</th>
                            <th>Địa Chỉ</th>
                            <th>Hành Động</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($khachs as $khach)
                            <tr>
                                <td class="text-center">{{ $khach->Ma_KT }}</td>
                                <td>
                                    <strong class="text-primary">{{ $khach->Ho_Ten }}</strong><br>
                                    <i class="fa fa-phone"></i> {{ $khach->So_Dien_Thoai }}<br>
                                    <small class="text-muted">{{ $khach->Email }}</small>
                                </td>
                                <td>
                                    <span class="badge badge-info">Hạng {{ $khach->Hang_Bang_Lai ?? 'N/A' }}</span>
                                    <div class="mt-1">
                                        @if ($khach->Anh_Bang_Lai_Truoc)
                                            @php
                                                $gplxTruoc = str_contains($khach->Anh_Bang_Lai_Truoc, '/')
                                                    ? asset('storage/' . $khach->Anh_Bang_Lai_Truoc)
                                                    : asset('uploads/gplx/' . $khach->Anh_Bang_Lai_Truoc);
                                            @endphp
                                            <img src="{{ $gplxTruoc }}" height="40" class="border rounded"
                                                title="Mặt trước">
                                        @endif
                                        @if ($khach->Anh_Bang_Lai_Sau)
                                            @php
                                                $gplxSau = str_contains($khach->Anh_Bang_Lai_Sau, '/')
                                                    ? asset('storage/' . $khach->Anh_Bang_Lai_Sau)
                                                    : asset('uploads/gplx/' . $khach->Anh_Bang_Lai_Sau);
                                            @endphp
                                            <img src="{{ $gplxSau }}" height="40" class="border rounded"
                                                title="Mặt sau">
                                        @endif
                                    </div>
                                </td>
                                <td>{{ Str::limit($khach->Dia_Chi, 30) }}</td>
                                <td class="text-center">
                                    <a href="{{ route('khach-thue.edit', $khach->Ma_KT) }}"
                                        class="btn btn-sm btn-warning"><i class="fa fa-edit"></i>
                                    </a>
                                    <form action="{{ route('khach-thue.destroy', $khach->Ma_KT) }}" method="POST"
                                        style="display:inline">
                                        @csrf @method('DELETE')
                                        <button class="btn btn-sm btn-danger" onclick="return confirm('Xóa khách này?')"><i
                                                class="fa fa-trash"></i></button>
                                    </form>
                                    <a href="{{ route('khach-thue.show', $khach->Ma_KT) }}" class="btn btn-sm btn-success"
                                        title="Xem chi tiết">
                                        <i class="fa fa-eye"></i>
                                    </a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="text-center">Chưa có dữ liệu</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
                {{ $khachs->links() }}
            </div>
            <div class="card-footer small text-muted">Cập nhật lúc: {{ date('H:i d/m/Y') }}</div>
        </div>
    </div>
@endsection
