@extends('layout.admin')

@section('body')
    <div class="container-fluid">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Trang Chủ</a></li>
            <li class="breadcrumb-item active"><a href="{{ route('xe.index') }}">Quản Lý Xe</a></li>
            <li class="breadcrumb-item active">Thêm Xe Mới</li>
        </ol>
        @if ($errors->any())
            <div class="alert alert-danger border-left-danger" role="alert">
                <strong><i class="fa fa-exclamation-triangle"></i> Thông tin bị trùng vui lòng kiểm tra lại!!!</strong>
            </div>
        @endif
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">Thêm Xe Mới</h6>
            </div>
            <div class="card-body">
                <form action="{{ route('xe.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Tên Xe <span class="text-danger">*</span></label>
                                <input type="text" name="Ten_Xe" class="form-control" required
                                    placeholder="Ví dụ: VinFast Lux A2.0">
                            </div>
                            <div class="form-group">
                                <label>Biển Số <span class="text-danger">*</span></label>
                                <input type="text" name="BienSo" class="form-control" required placeholder="51H-123.45">
                            </div>

                            <div class="form-group bg-light p-2 border rounded">
                                <label class="font-weight-bold">Hình ảnh đại diện xe</label>
                                <input type="file" name="HinhAnh" class="form-control-file" accept="image/*">
                                <small class="form-text text-muted">Chấp nhận ảnh jpg, png, gif. Tối đa 2MB.</small>
                            </div>
                            <div class="form-group">
                                <label>Năm Sản Xuất</label>
                                <input type="number" name="NamSX" class="form-control" value="2022">
                            </div>
                            <div class="form-group">
                                <label>Số Ghế</label>
                                <input type="number" name="SoGhe" class="form-control" value="4">
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Loại Xe</label>
                                <select name="Ma_PLXe" class="form-control">
                                    @foreach ($loaiXes as $lx)
                                        <option value="{{ $lx->Ma_PLXe }}">{{ $lx->Ten_PLXe }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group">
                                <label>Chủ Xe (Đối tác)</label>
                                <select name="Ma_CX" class="form-control">
                                    @foreach ($chuXes as $cx)
                                        <option value="{{ $cx->Ma_CX }}">{{ $cx->Ten_CX }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group">
                                <label>Giá thuê (VNĐ/Ngày) <span class="text-danger">*</span></label>
                                <input type="number" name="GiaThue" class="form-control" required
                                    placeholder="Ví dụ: 1200000" min="0">
                                <small class="text-muted">Nhập giá tiền cho 1 ngày thuê.</small>
                            </div>
                            <div class="form-group">
                                <label>Mô tả chi tiết</label>
                                <textarea name="MoTa_Xe" class="form-control" rows="4"></textarea>
                            </div>
                        </div>
                        <div class="row mt-4">
                            <div class="col-md-12">
                                <h5 class="text-primary border-bottom pb-2">Thông số kỹ thuật</h5>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Loại Hộp Số <span class="text-danger">*</span></label>
                                            <select name="LoaiHopSo" class="form-control" required>
                                                <option value="">-- Chọn --</option>
                                                @foreach ($dsHopSo as $hs)
                                                    <option value="{{ $hs->Ma_DM }}">{{ $hs->Ten_DM }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Loại Nhiên Liệu <span class="text-danger">*</span></label>
                                            <select name="LoaiNhienLieu" class="form-control" required>
                                                <option value="">-- Chọn --</option>
                                                @foreach ($dsNhienLieu as $nl)
                                                    <option value="{{ $nl->Ma_DM }}">{{ $nl->Ten_DM }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label>Công suất (Mã lực)</label>
                                            <input type="text" name="Cong_Xuat" class="form-control"
                                                placeholder="VD: 180 HP">
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label>Mức tiêu thụ</label>
                                            <input type="text" name="MucTieuThu" class="form-control"
                                                placeholder="VD: 8L/100km">
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-12 mt-3">
                                <label class="font-weight-bold text-primary border-bottom pb-2 mb-3 d-block">Tiện ích đi
                                    kèm</label>
                                <div class="row">
                                    @foreach ($tienIches as $ti)
                                        <div class="col-md-3 col-sm-6">
                                            <div class="form-group form-check custom-control custom-checkbox mb-3">
                                                <input type="checkbox" class="form-check-input"
                                                    id="create_ti_{{ $ti->Ma_TI }}" name="tien_ich[]"
                                                    value="{{ $ti->Ma_TI }}">

                                                <label class="custom-control-label" for="create_ti_{{ $ti->Ma_TI }}">
                                                    {{ $ti->Ten_TI }}
                                                </label>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    </div>

                    <hr>
                    <button type="submit" class="btn btn-success"><i class="fa fa-save"></i> Lưu Xe</button>
                    <a href="{{ route('xe.index') }}" class="btn btn-secondary">Quay lại</a>
                </form>
            </div>
        </div>
    </div>
@endsection
