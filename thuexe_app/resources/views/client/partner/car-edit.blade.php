@extends('layout.home')

@section('body')
    <div class="container-fluid bg-breadcrumb mb-5">
        <div class="container text-center py-5" style="max-width: 900px;">
            <h4 class="text-white display-4 mb-4 wow fadeInDown" data-wow-delay="0.1s">Chỉnh Sửa Xe</h4>
            <ol class="breadcrumb d-flex justify-content-center mb-0 wow fadeInDown" data-wow-delay="0.3s">
                <li class="breadcrumb-item"><a href="{{ route('home') }}">Trang Chủ</a></li>
                <li class="breadcrumb-item"><a href="{{ route('partner.cars') }}">Quản lý xe</a></li>
                <li class="breadcrumb-item active text-primary">Chỉnh sửa</li>
            </ol>
        </div>
    </div>

    <div class="container py-5">
        <div class="row justify-content-center">
            <div class="col-lg-10">
                <div class="bg-secondary p-5 rounded">
                    <div class="d-flex justify-content-between align-items-center mb-4">
                        <h3 class="text-white mb-0">Cập nhật thông tin xe</h3>
                        <a href="{{ route('partner.cars') }}" class="btn btn-light">Quay lại</a>
                    </div>

                    @if (session('success'))
                        <div class="alert alert-success">{{ session('success') }}</div>
                    @endif

                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul class="mb-0">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form action="{{ route('partner.cars.update', $car->Ma_Xe) }}" method="POST"
                        enctype="multipart/form-data">
                        @csrf
                        @method('PUT')

                        <div class="row g-4">
                            <div class="col-md-12">
                                <div class="form-floating">
                                    <input type="text" class="form-control" id="Ten_Xe" name="Ten_Xe"
                                        value="{{ old('Ten_Xe', $car->Ten_Xe) }}" required>
                                    <label for="Ten_Xe">Tên xe</label>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-floating">
                                    <input type="text" class="form-control" id="BienSo" name="BienSo"
                                        value="{{ old('BienSo', $car->BienSo) }}" required>
                                    <label for="BienSo">Biển số xe</label>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-floating">
                                    <input type="number" class="form-control" id="NamSX" name="NamSX" min="1900"
                                        max="{{ date('Y') }}" value="{{ old('NamSX', $car->NamSX) }}" required>
                                    <label for="NamSX">Năm sản xuất</label>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-floating">
                                    <input type="number" class="form-control" id="SoGhe" name="SoGhe" min="1"
                                        max="60" value="{{ old('SoGhe', $car->SoGhe) }}" required>
                                    <label for="SoGhe">Số ghế</label>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-floating">
                                    <select class="form-select" id="Ma_PLXe" name="Ma_PLXe" required>
                                        @foreach ($loaiXes ?? [] as $lx)
                                            <option value="{{ $lx->Ma_PLXe }}"
                                                {{ (string) old('Ma_PLXe', $car->Ma_PLXe) === (string) $lx->Ma_PLXe ? 'selected' : '' }}>
                                                {{ $lx->Ten_PLXe }}
                                            </option>
                                        @endforeach
                                    </select>
                                    <label for="Ma_PLXe">Phân loại xe</label>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-floating">
                                    <input type="number" class="form-control" id="GiaThue" name="GiaThue" min="0"
                                        value="{{ old('GiaThue', $car->GiaThue) }}" required>
                                    <label for="GiaThue">Giá thuê (VNĐ/ngày)</label>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-floating">
                                    @php
                                        $thongSo = $car->thongSo;
                                        $currentHopSo =
                                            old('LoaiHopSo') ?? ($thongSo->Ma_LHS ?? ($thongSo->LoaiHopSo ?? null));
                                    @endphp
                                    <select class="form-select" id="LoaiHopSo" name="LoaiHopSo" required>
                                        <option value="" disabled {{ $currentHopSo ? '' : 'selected' }}>-- Chọn hộp
                                            số --</option>
                                        @foreach ($dsHopSo ?? [] as $hs)
                                            <option value="{{ $hs->Ma_DM }}"
                                                {{ (string) $currentHopSo === (string) $hs->Ma_DM ? 'selected' : '' }}>
                                                {{ $hs->Ten_DM }}
                                            </option>
                                        @endforeach
                                    </select>
                                    <label for="LoaiHopSo">Loại hộp số</label>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-floating">
                                    @php
                                        $currentNhienLieu =
                                            old('LoaiNhienLieu') ??
                                            ($thongSo->Ma_LNL ?? ($thongSo->LoaiNhienLieu ?? null));
                                    @endphp
                                    <select class="form-select" id="LoaiNhienLieu" name="LoaiNhienLieu" required>
                                        <option value="" disabled {{ $currentNhienLieu ? '' : 'selected' }}>-- Chọn
                                            nhiên liệu --</option>
                                        @foreach ($dsNhienLieu ?? [] as $nl)
                                            <option value="{{ $nl->Ma_DM }}"
                                                {{ (string) $currentNhienLieu === (string) $nl->Ma_DM ? 'selected' : '' }}>
                                                {{ $nl->Ten_DM }}
                                            </option>
                                        @endforeach
                                    </select>
                                    <label for="LoaiNhienLieu">Loại nhiên liệu</label>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-floating">
                                    <input type="text" class="form-control" id="MucTieuThu" name="MucTieuThu"
                                        value="{{ old('MucTieuThu', $thongSo->MucTieuThu ?? '') }}">
                                    <label for="MucTieuThu">Mức tiêu thụ</label>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-floating">
                                    <input type="text" class="form-control" id="Cong_Xuat" name="Cong_Xuat"
                                        value="{{ old('Cong_Xuat', $thongSo->Cong_Xuat ?? '') }}">
                                    <label for="Cong_Xuat">Công suất</label>
                                </div>
                            </div>

                            <div class="col-12">
                                <div class="form-floating">
                                    <textarea class="form-control" id="MoTa_Xe" name="MoTa_Xe" style="height: 120px">{{ old('MoTa_Xe', $car->MoTa_Xe) }}</textarea>
                                    <label for="MoTa_Xe">Mô tả (tùy chọn)</label>
                                </div>
                            </div>

                            <div class="col-12">
                                <label class="text-white mb-2">Các tiện ích trên xe:</label>
                                <div class="row bg-white rounded p-3 mx-0">
                                    @php
                                        $selectedTienIch = old('tien_ich', $car->tienIches->pluck('Ma_TI')->all());
                                    @endphp
                                    @forelse (($tienIches ?? []) as $ti)
                                        <div class="col-md-4 mb-2">
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" name="tien_ich[]"
                                                    value="{{ $ti->Ma_TI }}" id="ti_{{ $ti->Ma_TI }}"
                                                    {{ in_array($ti->Ma_TI, $selectedTienIch) ? 'checked' : '' }}>
                                                <label class="form-check-label"
                                                    for="ti_{{ $ti->Ma_TI }}">{{ $ti->Ten_TI }}</label>
                                            </div>
                                        </div>
                                    @empty
                                        <div class="col-12">
                                            <small class="text-muted">Chưa có danh sách tiện ích.</small>
                                        </div>
                                    @endforelse
                                </div>
                            </div>

                            <div class="col-12">
                                <label class="text-white mb-2">Ảnh xe</label>
                                <div class="bg-white rounded p-3">
                                    @if (!empty($car->HinhAnh))
                                        <div class="mb-3">
                                            <img src="{{ \Illuminate\Support\Facades\Storage::url($car->HinhAnh) }}"
                                                alt="{{ $car->Ten_Xe }}"
                                                style="height: 120px; width: auto; border-radius: 12px;" />
                                        </div>
                                    @endif
                                    <input type="file" class="form-control" name="HinhAnh" accept="image/*">
                                    <small class="text-muted">Chọn ảnh mới nếu muốn thay đổi.</small>
                                </div>
                            </div>

                            <div class="col-12 mt-2">
                                <button class="btn btn-light w-100 py-3 fw-bold" type="submit">Lưu thay đổi</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
