@extends('layout.home')

@section('body')
    <div class="container-fluid bg-breadcrumb mb-5">
        <div class="container text-center py-5" style="max-width: 900px;">
            <h4 class="text-white display-4 mb-4 wow fadeInDown" data-wow-delay="0.1s">Quản Lý Xe</h4>
            <ol class="breadcrumb d-flex justify-content-center mb-0 wow fadeInDown" data-wow-delay="0.3s">
                <li class="breadcrumb-item"><a href="{{ route('home') }}">Trang Chủ</a></li>
                <li class="breadcrumb-item active text-primary">Danh sách xe</li>
            </ol>
        </div>
    </div>
    <div class="container py-5">
        <div class="d-flex justify-content-end align-items-center mb-4">
            <a href="{{ route('contact') }}" class="btn btn-danger">Thêm xe</a>
        </div>

        @if (session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif
        @if (session('error'))
            <div class="alert alert-danger">{{ session('error') }}</div>
        @endif

        <div class="card shadow-sm border-0">
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table align-middle mb-0">
                        <thead>
                            <tr>
                                <th style="min-width: 280px;">Hình ảnh / Tên xe</th>
                                <th>Biển Số</th>
                                <th>Giá Thuê</th>
                                <th style="min-width: 200px;">Kiểm Duyệt (Admin)</th>
                                <th style="min-width: 200px;">Trạng Thái Xe (Hiển thị)</th>
                                <th class="text-end" style="min-width: 120px;">Hành Động</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($xes as $xe)
                                @php
                                    $imgUrl = !empty($xe->HinhAnh)
                                        ? \Illuminate\Support\Facades\Storage::url($xe->HinhAnh)
                                        : asset('img/car-1.png');

                                    $isPendingOrRejected = in_array($xe->TrangThai_Xe, ['ChoDuyet', 'DaTuChoi'], true);
                                    $isAdminBanned = $xe->TrangThai_Xe === 'BiCam';
                                    $approvalValue = in_array(
                                        $xe->TrangThai_Xe,
                                        ['ChoDuyet', 'DaTuChoi', 'BiCam'],
                                        true,
                                    )
                                        ? $xe->TrangThai_Xe
                                        : 'SanSang';
                                @endphp
                                <tr>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <img src="{{ $imgUrl }}" alt="{{ $xe->Ten_Xe }}"
                                                style="width: 72px; height: 48px; object-fit: cover; border-radius: 10px;">
                                            <div class="ms-3">
                                                <div class="fw-bold">{{ $xe->Ten_Xe ?? '-' }}</div>
                                                <small class="text-muted">
                                                    {{ optional($xe->phanLoaiXe)->Ten_PLXe ?? '---' }} |
                                                    {{ $xe->NamSX ?? '---' }}
                                                </small>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <span class="badge bg-secondary">{{ $xe->BienSo ?? '-' }}</span>
                                    </td>
                                    <td class="text-danger fw-bold">
                                        {{ $xe->GiaThue ? number_format($xe->GiaThue, 0, ',', '.') . ' đ' : '-' }}
                                    </td>
                                    <td>
                                        @if ($approvalValue === 'ChoDuyet')
                                            <span class="badge bg-warning text-dark">Chờ duyệt</span>
                                        @elseif($approvalValue === 'DaTuChoi')
                                            <span class="badge bg-danger">Từ chối</span>
                                        @elseif($approvalValue === 'BiCam')
                                            <span class="badge bg-secondary">Bị ẩn/cấm</span>
                                        @else
                                            <span class="badge bg-success">Đã duyệt</span>
                                        @endif
                                    </td>
                                    <td>
                                        <form method="POST" action="{{ route('partner.cars.update', $xe->Ma_Xe) }}">
                                            @csrf
                                            @method('PATCH')
                                            <input type="hidden" name="_mode" value="status">
                                            <select name="TrangThai_Xe" class="form-select border-success"
                                                onchange="this.form.submit()"
                                                {{ $isPendingOrRejected || $isAdminBanned ? 'disabled' : '' }}>
                                                <option value="SanSang"
                                                    {{ $xe->TrangThai_Xe === 'SanSang' ? 'selected' : '' }}>Sẵn sàng
                                                </option>
                                                <option value="DangThue"
                                                    {{ $xe->TrangThai_Xe === 'DangThue' ? 'selected' : '' }}>Đang thuê
                                                </option>
                                                <option value="BaoTri"
                                                    {{ $xe->TrangThai_Xe === 'BaoTri' ? 'selected' : '' }}>Bảo trì</option>
                                                <option value="TamAn"
                                                    {{ $xe->TrangThai_Xe === 'TamAn' ? 'selected' : '' }}>Ẩn</option>
                                            </select>
                                        </form>
                                        @if ($isPendingOrRejected)
                                            <small class="text-muted d-block mt-1">Xe chưa duyệt nên chưa hiển thị.</small>
                                        @endif
                                        @if ($isAdminBanned)
                                            <small class="text-muted d-block mt-1">Xe bị admin cấm nên không thể chỉnh trạng
                                                thái.</small>
                                        @endif
                                    </td>
                                    <td class="text-end">
                                        @if ($approvalValue !== 'ChoDuyet')
                                            <form method="POST" action="{{ route('partner.cars.update', $xe->Ma_Xe) }}"
                                                class="d-inline">
                                                @csrf
                                                @method('PATCH')
                                                <input type="hidden" name="_mode" value="requestApproval">
                                                <input type="hidden" name="TrangThai_Xe" value="ChoDuyet">
                                                <button type="submit" class="btn btn-outline-success btn-sm me-1"
                                                    title="Gửi admin duyệt">
                                                    <i class="fas fa-paper-plane"></i>
                                                </button>
                                            </form>
                                        @endif
                                        <a href="{{ route('partner.cars.edit', $xe->Ma_Xe) }}"
                                            class="btn btn-outline-danger btn-sm me-1" title="Sửa">
                                            <i class="fas fa-pen"></i>
                                        </a>
                                        <form action="{{ route('partner.cars.destroy', $xe->Ma_Xe) }}" method="POST"
                                            class="d-inline" onsubmit="return confirm('Bạn có chắc muốn xóa xe này?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-outline-danger btn-sm" title="Xóa">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="text-center py-4">Chưa có dữ liệu</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection
