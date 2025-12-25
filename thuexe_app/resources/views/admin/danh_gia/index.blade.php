@extends('layout.admin')
@section('body')
    <div class="container-fluid">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Trang Chủ</a></li>
            <li class="breadcrumb-item active">Quản Lý Đánh Giá</li>
        </ol>

        <div class="card shadow mb-4">
            <div class="card-header py-3 d-flex justify-content-between align-items-center">
                <h6 class="m-0 font-weight-bold text-primary">Danh sách đánh giá từ khách hàng</h6>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered table-hover" width="100%" cellspacing="0">
                        <thead>
                            <tr>
                                <th>Đơn #</th>
                                <th>Khách Hàng</th>
                                <th>Xe</th>
                                <th>Đánh Giá</th>
                                <th>Nội Dung</th>
                                <th>Ngày</th>
                                <th>Hành Động</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($danhGias as $dg)
                                <tr>
                                    <td><a href="{{ route('don-thue.show', $dg->Ma_DT) }}">#{{ $dg->Ma_DT }}</a></td>
                                    <td>{{ $dg->khachThue->Ho_Ten ?? '---' }}</td>
                                    <td>{{ $dg->xe->BienSo ?? '---' }}</td>
                                    <td style="width: 120px">
                                        <span class="text-warning font-weight-bold">
                                            {{ $dg->So_Sao }} <i class="fa fa-star"></i>
                                        </span>
                                    </td>
                                    <td>{{ $dg->Noi_Dung }}</td>
                                    <td>{{ date('d/m/Y', strtotime($dg->created_at)) }}</td>
                                    <td class="text-center">
                                        <form action="{{ route('danh-gia.destroy', $dg->Ma_DG) }}" method="POST"
                                            onsubmit="return confirm('Xóa đánh giá này?');">
                                            @csrf @method('DELETE')
                                            <button class="btn btn-danger btn-sm" title="Xóa"><i
                                                    class="fa fa-trash"></i></button>
                                        </form>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="7" class="text-center text-muted">Chưa có đánh giá nào.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                    <div class="mt-3">
                        {{ $danhGias->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
