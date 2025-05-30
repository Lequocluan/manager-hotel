@extends('admin.layout_admin.main')

@section('content')
<div class="container-fluid">
    <div class="d-flex align-items-center mb-3">
        <a href="{{ route('rooms.index') }}" class="btn btn-outline-secondary btn-sm rounded-circle me-2" title="Quay lại">
            <i class="fas fa-arrow-left"></i>
        </a>
        <h2 class="m-0">Chỉnh sửa phòng</h2>
    </div>

    <div class="card shadow-sm">
        <div class="card-body">
            <form action="{{ route('rooms.update', $room->id) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="row">
                    <div class="col-md-4 mb-3">
                        <label for="name" class="form-label fw-bold">Tên phòng</label>
                        <input type="text" name="name" class="form-control @error('name') is-invalid @enderror"
                               value="{{ old('name', $room->name) }}" placeholder="Nhập tên phòng">
                        @error('name')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-4 mb-3">
                        <label for="room_type_id" class="form-label fw-bold">Loại phòng</label>
                        <select name="room_type_id" class="tag-select form-control @error('room_type_id') is-invalid @enderror">
                            @foreach ($roomTypes as $roomType)
                                <option value="{{ $roomType->id }}" {{ $room->room_type_id == $roomType->id ? 'selected' : '' }}>
                                    {{ $roomType->name }}
                                </option>
                            @endforeach
                        </select>
                        @error('room_type_id')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="col-md-4">
                        <label for="status" class="form-label fw-bold">Trạng thái</label>
                        <select name="status" class="form-control @error('status') is-invalid @enderror">
                            <option value="0" {{ $room->status == 0 ? 'selected' : '' }}>Hiển thị</option>
                            <option value="1" {{ $room->status == 1 ? 'selected' : '' }}>Ẩn</option>
                        </select>
                        @error('status')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>


                <div class="row mb-3">
                    <div class="col-md-6">
                        <label for="description" class="form-label fw-bold">Mô tả</label>
                        <textarea name="description" class="form-control @error('description') is-invalid @enderror"
                                rows="3" placeholder="Nhập mô tả về phòng...">{{ old('description', $room->description) }}</textarea>
                        @error('description')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>  
                    <div class="col-md-6">
                        <label for="view" class="form-label fw-bold">Hướng phòng</label>
                        <input type="text" name="view" class="form-control @error('view') is-invalid @enderror"
                               value="{{ old('view', $room->view) }}" placeholder="VD: biển, núi, thành phố...">
                        @error('view')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="text-center">
                    <button type="submit" class="btn btn-primary"> Cập nhật</button>
                </div>
            </form>
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
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
<link rel="stylesheet" href="{{ asset('admin_asset/css/custom/custom.css') }}">
@endsection