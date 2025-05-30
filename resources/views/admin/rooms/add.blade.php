@extends('admin.layout_admin.main')

@section('content')
<div class="container-fluid">
    <div class="d-flex align-items-center mb-3">
        <a href="{{ route('rooms.index') }}" class="btn btn-outline-secondary btn-sm rounded-circle me-2" title="Quay lại">
            <i class="fas fa-arrow-left"></i>
        </a>
        <h2 class="m-0">Thêm phòng mới</h2>
    </div>

    <div class="row">
        <div class="col-lg-12">
            <div class="card shadow mb-4">
                <div class="card-body">
                    <form action="{{ route('rooms.store') }}" method="POST">
                        @csrf
                        <div class="row">
                            <div class="col-md-4 mb-3">
                                <label for="name" class="form-label">Tên phòng <span class="text-danger">*</span></label>
                                <input type="text" name="name" class="form-control @error('name') is-invalid @enderror"
                                    value="{{ old('name') }}" placeholder="Nhập tên phòng...">
                                @error('name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-4 mb-3">
                                <label for="room_type_id" class="form-label">Loại phòng <span class="text-danger">*</span></label>
                                <select name="room_type_id" class="tag-select form-control @error('room_type_id') is-invalid @enderror">
                                    <option value="">-- Chọn loại phòng --</option>
                                    @foreach ($roomTypes as $type)
                                        <option value="{{ $type->id }}" {{ old('room_type_id') == $type->id ? 'selected' : '' }}>
                                            {{ $type->name }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('room_type_id')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-4 mb-3">
                                <label for="status" class="form-label">Trạng thái</label>
                                <select name="status" class="form-control @error('status') is-invalid @enderror">
                                    <option value="0" {{ old('status') == '0' ? 'selected' : '' }}>Hiển thị</option>
                                    <option value="1" {{ old('status') == '1' ? 'selected' : '' }}>Ẩn</option>
                                </select>
                                @error('status')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="description" class="form-label">Mô tả</label>
                                <textarea name="description" rows="1" class="form-control @error('description') is-invalid @enderror">{{ old('description') }}</textarea>
                                @error('description')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-6">
                                <label for="view">Hướng phòng</label>
                                <input type="text" name="view" class="form-control @error('view') is-invalid @enderror"
                                    value="{{ old('view') }}" placeholder="VD: biển, núi, thành phố...">
                                @error('view')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="text-center">
                            <button type="submit" class="btn btn-primary">Lưu</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('js')
<script>
    $(".tag-select").select2({
    placeholder: "Chọn loại phòng",
    allowClear: true
});

</script>
@endsection
@section('css')
<link rel="stylesheet" href="{{ asset('admin_asset/css/custom/custom.css') }}">
@endsection