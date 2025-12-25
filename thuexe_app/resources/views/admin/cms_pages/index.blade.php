@extends('layout.admin')

@section('body')
    <div class="container-fluid">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Trang Chủ</a></li>
            <li class="breadcrumb-item active">Trang CMS</li>
        </ol>

        <div class="alert alert-info">
            <strong>Hướng dẫn:</strong>
            <ul class="mb-0">
                <li><strong>Slug</strong> là định danh của trang (vd: <code>home</code>, <code>about</code>,
                    <code>team</code>) và phải <strong>duy nhất</strong>.</li>
                <li>Dùng nút <strong>Khối nội dung</strong> để quản lý các block hiển thị trên từng trang.</li>
                <li>Trang <strong>Tắt</strong> sẽ không được hiển thị nội dung CMS (tuỳ logic render ở phía client).</li>
            </ul>
        </div>

        @if (session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        <div class="card mb-3 shadow">
            <div class="card-header py-3 d-flex justify-content-between align-items-center">
                <h6 class="m-0 font-weight-bold text-primary">Danh sách trang ({{ $pages->total() }})</h6>
                <a href="{{ route('cms-pages.create') }}" class="btn btn-sm btn-primary shadow-sm">
                    <i class="fa fa-plus"></i> Thêm trang
                </a>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered" width="100%" cellspacing="0">
                        <thead class="bg-light text-dark">
                            <tr>
                                <th>ID</th>
                                <th>Định danh (slug)</th>
                                <th>Tên trang</th>
                                <th>Khối nội dung</th>
                                <th>Trạng thái</th>
                                <th width="160">Thao tác</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($pages as $p)
                                <tr>
                                    <td>{{ $p->id }}</td>
                                    <td><code>{{ $p->slug }}</code></td>
                                    <td>{{ $p->ten_trang }}</td>
                                    <td class="text-center">
                                        <a class="btn btn-sm btn-outline-primary"
                                            href="{{ route('cms-blocks.index', ['page_id' => $p->id]) }}">
                                            {{ (int) $p->blocks_count }} khối
                                        </a>
                                    </td>
                                    <td class="text-center">
                                        @if ($p->is_active)
                                            <span class="badge badge-success">Bật</span>
                                        @else
                                            <span class="badge badge-secondary">Tắt</span>
                                        @endif
                                    </td>
                                    <td class="text-center">
                                        <a href="{{ route('cms-pages.edit', $p) }}" class="btn btn-sm btn-warning">Sửa</a>
                                        <form action="{{ route('cms-pages.destroy', $p) }}" method="POST" class="d-inline"
                                            onsubmit="return confirm('Xóa trang này? (Sẽ xóa luôn các blocks)')">
                                            @csrf
                                            @method('DELETE')
                                            <button class="btn btn-sm btn-danger" type="submit">Xóa</button>
                                        </form>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="text-center">Chưa có trang CMS.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <div class="d-flex justify-content-center">
                    {{ $pages->links() }}
                </div>
            </div>
        </div>
    </div>
@endsection
