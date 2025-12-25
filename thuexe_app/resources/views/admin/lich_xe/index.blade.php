@extends('layout.admin')

@section('body')
    <div class="container-fluid">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Trang Chủ</a></li>
            <li class="breadcrumb-item active">Quản Lý Lịch Xe</li>
        </ol>
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <span class="badge badge-warning p-2 mr-2">⏳ Chờ duyệt</span>
                <span class="badge badge-info p-2 mr-2">✅ Đã duyệt</span>
                <span class="badge badge-primary p-2 mr-2">💰 Đã cọc</span>
                <span class="badge badge-success p-2 mr-2">🚗 Đang chạy</span>
                <span class="badge badge-secondary p-2">🏁 Đã trả</span>
            </div>
        </div>

        <div class="card shadow mb-4">
            <div class="card-body">
                <div id="calendar" data-events-url="{{ url('admin/lich-xe') }}"></div>
            </div>
            <div class="card-footer small text-muted">Cập nhật lúc: {{ date('H:i d/m/Y') }}</div>
        </div>
    </div>

    <link href="https://cdn.jsdelivr.net/npm/fullcalendar@5.11.3/main.min.css" rel="stylesheet" />
    <link href="{{ asset('css/admin/lich-xe.css') }}" rel="stylesheet" />
    <script src="https://cdn.jsdelivr.net/npm/fullcalendar@5.11.3/main.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/fullcalendar@5.11.3/locales/vi.js"></script> 
    <script src="{{ asset('js/admin/lich-xe.js') }}"></script>
@endsection
