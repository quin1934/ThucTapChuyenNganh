@extends('layout.admin')
@section('body')
    <div class="container-fluid">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Trang Chủ</a></li>
            <li class="breadcrumb-item active"><a href="{{ route('tien-ich.index') }}">Quản Lý Tiện Ích</a></li>
            <li class="breadcrumb-item active">Cập nhật Tiện Ích</li>
        </ol>
        <div class="card shadow">
            <div class="card-header font-weight-bold text-primary">Cập nhật Tiện Ích</div>
            <div class="card-body">
                <form action="{{ route('tien-ich.update', $tienich->Ma_TI) }}" method="POST">
                    @csrf @method('PUT')
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Tên Tiện Ích <span class="text-danger">*</span></label>
                                <input type="text" name="Ten_TI" class="form-control" value="{{ $tienich->Ten_TI }}"
                                    required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Thuộc Loại <span class="text-danger">*</span></label>
                                <select name="Ma_LTI" class="form-control" required>
                                    @foreach ($loaiTienIches as $loai)
                                        <option value="{{ $loai->Ma_LTI }}"
                                            {{ $tienich->Ma_LTI == $loai->Ma_LTI ? 'selected' : '' }}>
                                            {{ $loai->Ten_LTI }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label>Mô tả</label>
                        <textarea name="MoTa_TI" class="form-control" rows="3">{{ $tienich->MoTa_TI }}</textarea>
                    </div>
                    <button type="submit" class="btn btn-warning"><i class="fa fa-save"></i> Cập nhật</button>
                    <a href="{{ route('tien-ich.index') }}" class="btn btn-secondary">Hủy</a>
                </form>
            </div>
        </div>
    </div>
@endsection
