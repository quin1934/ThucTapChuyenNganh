@extends('layout.admin')

@section('body')
<div class="container-fluid">
    <h3 class="my-3 text-dark">Lịch Sử Giao Dịch</h3>

    <div class="card mb-3 shadow-sm">
        <div class="card-header">
            <i class="fa fa-money"></i> Danh sách các khoản thu
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered table-hover" width="100%" cellspacing="0">
                    <thead class="thead-light">
                        <tr>
                            <th>Mã GD</th>
                            <th>Mã Đơn Thuê</th>
                            <th>Số Tiền</th>
                            <th>Phương Thức</th>
                            <th>Ngày TT</th>
                            <th>Trạng Thái</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($payments as $pay)
                        <tr>
                            <td>#GD{{ $pay->Ma_TT }}</td>
                            
                            <td>
                                <a href="{{ route('don-thue.show', $pay->Ma_Don) }}">
                                    <strong>#DH{{ $pay->Ma_Don }}</strong>
                                </a>
                            </td>
                            
                            <td class="text-success font-weight-bold">
                                {{ number_format($pay->SoTien) }} VNĐ
                            </td>
                            
                            <td>
                                @if($pay->PhuongThuc_TT == 'ChuyenKhoan')
                                    <span class="badge badge-info"><i class="fa fa-credit-card"></i> Chuyển khoản</span>
                                @else
                                    <span class="badge badge-secondary"><i class="fa fa-money"></i> Tiền mặt</span>
                                @endif
                            </td>
                            
                            <td>{{ \Carbon\Carbon::parse($pay->Ngay_TT)->format('H:i d/m/Y') }}</td>
                            
                            <td class="text-center">
                                @if($pay->TrangThai_TT == 'ThanhCong')
                                    <span class="badge badge-success p-2">Thành công</span>
                                @elseif($pay->TrangThai_TT == 'ThatBai')
                                    <span class="badge badge-danger p-2">Thất bại</span>
                                @else
                                    <span class="badge badge-warning p-2">Chờ xử lý</span>
                                @endif
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="6" class="text-center text-muted py-3">
                                Chưa có giao dịch nào.
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
                
                <div class="mt-3">{{ $payments->links() }}</div>
            </div>
        </div>
    </div>
</div>
@endsection