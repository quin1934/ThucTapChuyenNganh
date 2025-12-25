@extends('layout.admin')

@section('body')
    <div class="container-fluid">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Trang Chủ</a></li>
            <li class="breadcrumb-item active">Khuyến Mãi</li>
        </ol>

        @if (session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        <div class="card mb-3 shadow">
            <div class="card-header py-3 d-flex justify-content-between align-items-center">
                <h6 class="m-0 font-weight-bold text-primary">Danh sách khuyến mãi ({{ $promotions->total() }})</h6>
                <a href="{{ route('promotion.create') }}" class="btn btn-sm btn-primary shadow-sm">
                    <i class="fa fa-plus"></i> Thêm khuyến mãi
                </a>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered" width="100%" cellspacing="0">
                        <thead class="bg-light text-dark">
                            <tr>
                                <th>ID</th>
                                <th>Tiêu đề</th>
                                <th>Banner</th>
                                <th>Giảm</th>
                                <th>Mã</th>
                                <th>Thời gian</th>
                                <th>Kích hoạt</th>
                                <th width="140">Thao tác</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($promotions as $p)
                                <tr>
                                    <td>{{ $p->id }}</td>
                                    <td>
                                        <strong>{{ $p->title }}</strong>
                                        @if ($p->ma_xe)
                                            <div class="small text-muted">Áp dụng: 1 xe (ID: {{ $p->ma_xe }})</div>
                                        @elseif ($p->ma_plxe)
                                            <div class="small text-muted">Áp dụng: 1 loại xe (ID: {{ $p->ma_plxe }})</div>
                                        @else
                                            <div class="small text-muted">Áp dụng: Tất cả</div>
                                        @endif
                                    </td>
                                    <td class="text-center">
                                        @if ($p->banner_path)
                                            <img src="{{ asset('storage/' . $p->banner_path) }}" alt="Banner"
                                                style="height: 50px;" class="img-thumbnail">
                                        @else
                                            <span class="text-muted">—</span>
                                        @endif
                                    </td>
                                    <td>
                                        @if ($p->discount_type === 'percent')
                                            {{ rtrim(rtrim(number_format((float) $p->discount_value, 2, '.', ''), '0'), '.') }}%
                                        @elseif($p->discount_type === 'fixed')
                                            {{ $p->discount_value !== null ? number_format($p->discount_value, 0, ',', '.') . 'đ' : '—' }}
                                        @else
                                            —
                                        @endif
                                    </td>
                                    <td>{{ $p->code ?? '—' }}</td>
                                    <td class="small">
                                        <div>BĐ: {{ $p->start_at ? $p->start_at->format('d/m/Y H:i') : '—' }}</div>
                                        <div>KT: {{ $p->end_at ? $p->end_at->format('d/m/Y H:i') : '—' }}</div>
                                    </td>
                                    <td class="text-center">
                                        @if ($p->is_active)
                                            <span class="badge badge-success">ON</span>
                                        @else
                                            <span class="badge badge-secondary">OFF</span>
                                        @endif
                                    </td>
                                    <td class="text-center">
                                        <a href="{{ route('promotion.edit', $p) }}" class="btn btn-sm btn-warning">Sửa</a>
                                        <form action="{{ route('promotion.destroy', $p) }}" method="POST" class="d-inline"
                                            onsubmit="return confirm('Xóa khuyến mãi này?')">
                                            @csrf
                                            @method('DELETE')
                                            <button class="btn btn-sm btn-danger" type="submit">Xóa</button>
                                        </form>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="8" class="text-center">Chưa có khuyến mãi.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <div class="d-flex justify-content-center">
                    {{ $promotions->links() }}
                </div>
            </div>
        </div>
    </div>
@endsection
