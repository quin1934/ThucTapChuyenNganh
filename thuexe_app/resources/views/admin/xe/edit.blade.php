@extends('layout.admin')

@section('body')
    <div class="container-fluid">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Trang Chủ</a></li>
            <li class="breadcrumb-item active"><a href="{{ route('xe.index') }}">Quản Lý Xe</a></li>
            <li class="breadcrumb-item active">Cập Nhật Xe</li>
        </ol>
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">Cập nhật thông tin xe: {{ $xe->BienSo }}</h6>
            </div>
            <div class="card-body">
                <form action="{{ route('xe.update', $xe->Ma_Xe) }}" method="POST" enctype="multipart/form-data">
                    @csrf @method('PUT')
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Tên Xe</label>
                                <input type="text" name="Ten_Xe" class="form-control" value="{{ $xe->Ten_Xe }}"
                                    required>
                            </div>
                            <div class="form-group">
                                <label>Biển Số</label>
                                <input type="text" name="BienSo" class="form-control" value="{{ $xe->BienSo }}"
                                    required>
                            </div>
                            <div class="form-group">
                                <label>Giá thuê (VNĐ/Ngày) <span class="text-danger">*</span></label>
                                <input type="number" name="GiaThue" class="form-control" required
                                    value="{{ $xe->GiaThue }}" min="0">
                            </div>
                            <div class="form-group">
                                <label>Năm Sản Xuất</label>
                                <input type="number" name="NamSX" class="form-control" value="{{ $xe->NamSX }}"
                                    placeholder="VD: 2022">
                            </div>

                            <div class="form-group">
                                <label>Số Ghế</label>
                                <input type="number" name="SoGhe" class="form-control" value="{{ $xe->SoGhe }}"
                                    placeholder="VD: 4">
                            </div>
                            <div class="form-group bg-light p-2 border rounded mb-3">
                                <label class="font-weight-bold">Hình ảnh xe</label>

                                @if ($xe->HinhAnh)
                                    <div class="mb-2 text-center">
                                        <img src="{{ asset('storage/' . $xe->HinhAnh) }}" alt="Ảnh hiện tại"
                                            class="img-thumbnail" style="max-height: 150px;">
                                        <p class="small text-muted mt-1">Ảnh hiện tại</p>
                                    </div>
                                @endif

                                <label>Chọn ảnh mới (Nếu muốn thay đổi):</label>
                                <input type="file" name="HinhAnh" class="form-control-file" accept="image/*">
                            </div>
                            <div class="form-group">
                                <label>Trạng Thái Hiện Tại</label>
                                <select name="TrangThai_Xe" class="form-control">
                                    <option value="SanSang" {{ $xe->TrangThai_Xe == 'SanSang' ? 'selected' : '' }}>Sẵn sàng
                                    </option>
                                    <option value="BaoTri" {{ $xe->TrangThai_Xe == 'BaoTri' ? 'selected' : '' }}>Bảo trì
                                    </option>
                                    <option value="BiCam" {{ $xe->TrangThai_Xe == 'BiCam' ? 'selected' : '' }}>Bị cấm
                                    </option>
                                    <option value="DangThue" {{ $xe->TrangThai_Xe == 'DangThue' ? 'selected' : '' }}>Đang
                                        thuê</option>
                                </select>
                                <small class="text-muted">Lưu ý: Chỉ chỉnh sửa thủ công khi cần thiết.</small>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Loại Xe</label>
                                <select name="Ma_PLXe" class="form-control">
                                    @foreach ($loaiXes as $lx)
                                        <option value="{{ $lx->Ma_PLXe }}"
                                            {{ $xe->Ma_PLXe == $lx->Ma_PLXe ? 'selected' : '' }}>
                                            {{ $lx->Ten_PLXe }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group">
                                <label>Chủ Xe</label>
                                <select name="Ma_CX" class="form-control">
                                    @foreach ($chuXes as $cx)
                                        <option value="{{ $cx->Ma_CX }}"
                                            {{ $xe->Ma_CX == $cx->Ma_CX ? 'selected' : '' }}>
                                            {{ $cx->Ten_CX }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group">
                                <label>Mô tả</label>
                                <textarea name="MoTa_Xe" class="form-control" rows="3">{{ $xe->MoTa_Xe }}</textarea>
                            </div>
                            <div class="row mt-4">
                                <div class="col-md-12">
                                    <h5 class="text-primary border-bottom pb-2">Thông số kỹ thuật</h5>
                                    <div class="row">
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label>Hộp số</label>
                                                <select name="LoaiHopSo" class="form-control">
                                                    @foreach ($dsHopSo as $hs)
                                                        <option value="{{ $hs->Ma_DM }}"
                                                            {{ optional($xe->thongSo)->Ma_LHS == $hs->Ma_DM ? 'selected' : '' }}>
                                                            {{ $hs->Ten_DM }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>

                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label>Nhiên liệu</label>
                                                <select name="LoaiNhienLieu" class="form-control">
                                                    @foreach ($dsNhienLieu as $nl)
                                                        <option value="{{ $nl->Ma_DM }}"
                                                            {{ optional($xe->thongSo)->Ma_LNL == $nl->Ma_DM ? 'selected' : '' }}>
                                                            {{ $nl->Ten_DM }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label>Công suất</label>
                                                <input type="text" name="Cong_Xuat" class="form-control"
                                                    value="{{ $xe->thongSo->Cong_Xuat ?? '' }}">
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label>Mức tiêu thụ</label>
                                                <input type="text" name="MucTieuThu" class="form-control"
                                                    value="{{ $xe->thongSo->MucTieuThu ?? '' }}">
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-12 mt-3">
                                    <label class="font-weight-bold text-primary border-bottom pb-2 mb-3 d-block">Tiện ích đi
                                        kèm (Cập nhật)</label>
                                    <div class="row">
                                        @foreach ($tienIches as $ti)
                                            <div class="col-md-3 col-sm-6">
                                                <div
                                                    class="custom-control form-group form-check custom-control custom-checkbox mb-3">
                                                    <input type="checkbox" class="form-check-input"
                                                        id="edit_ti_{{ $ti->Ma_TI }}" name="tien_ich[]"
                                                        value="{{ $ti->Ma_TI }}"
                                                        {{ $xe->tienIches->contains('Ma_TI', $ti->Ma_TI) ? 'checked' : '' }}>

                                                    <label class="custom-control-label"
                                                        for="edit_ti_{{ $ti->Ma_TI }}">
                                                        {{ $ti->Ten_TI }}
                                                    </label>
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <hr>
                    <button type="submit" class="btn btn-warning"><i class="fa fa-save"></i> Cập nhật</button>
                    <a href="{{ route('xe.index') }}" class="btn btn-secondary">Hủy</a>
                </form>
            </div>
        </div>
    </div>
@endsection
