@extends('layout.admin')

@section('body')
<div class="container-fluid">
    <h3 class="my-3 text-dark">Quản Lý Đánh Giá & Phản Hồi</h3>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <div class="card mb-3 shadow-sm">
        <div class="card-header">
            <i class="fa fa-comments"></i> Ý kiến khách hàng
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered table-hover" width="100%" cellspacing="0">
                    <thead class="thead-light">
                        <tr>
                            <th>ID</th>
                            <th>Khách Hàng</th>
                            <th>Xe Được Thuê</th>
                            <th>Điểm</th>
                            <th>Nội Dung</th>
                            <th>Ngày Đăng</th>
                            <th>Hành Động</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($reviews as $rv)
                        <tr>
                            <td>{{ $rv->Ma_DG }}</td>
                            
                            <td class="font-weight-bold">
                                {{ $rv->khachThue->Ten_KT ?? 'Ẩn danh' }}
                            </td>
                            
                            <td>
                                {{ $rv->donThue->xe->Ten_Xe ?? 'Xe đã xóa' }}
                            </td>
                            
                            <td class="text-warning" style="white-space: nowrap;">
                                @for($i = 1; $i <= 5; $i++)
                                    @if($i <= $rv->DiemSo)
                                        <i class="fa fa-star"></i> @else
                                        <i class="fa fa-star-o"></i> @endif
                                @endfor
                                <span class="text-dark ml-1">({{ $rv->DiemSo }})</span>
                            </td>
                            
                            <td>{{ $rv->NoiDung }}</td>
                            
                            <td>{{ \Carbon\Carbon::parse($rv->NgayTao)->format('d/m/Y') }}</td>
                            
                            <td>
                                <form action="{{ route('danh-gia.destroy', $rv->Ma_DG) }}" method="POST" onsubmit="return confirm('Xóa đánh giá này?');">
                                    @csrf
                                    @method('DELETE')
                                    <button class="btn btn-sm btn-danger" title="Xóa"><i class="fa fa-trash"></i></button>
                                </form>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="7" class="text-center text-muted py-3">
                                Chưa có đánh giá nào từ khách hàng.
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
                
                <div class="mt-3">{{ $reviews->links() }}</div>
            </div>
        </div>
    </div>
</div>
@endsection