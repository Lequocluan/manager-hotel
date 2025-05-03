@extends('admin.layout_admin.main')

@section('content')
<div class="container-fluid">
    <div class="d-flex align-items-center mb-3">
        <a href="{{ route('room-types.index') }}" class="btn btn-outline-secondary btn-sm rounded-circle me-2" title="Quay lại">
            <i class="fas fa-arrow-left"></i>
        </a>
        <h2 class="m-0">Chỉnh sửa loại phòng</h2>
    </div>

    <div class="card shadow-sm">
        <div class="card-body">
            <form action="{{ route('room-types.update', $roomType->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="name" class="form-label fw-bold">Tên loại phòng</label>
                        <input type="text" name="name" class="form-control @error('name') is-invalid @enderror"
                               value="{{ old('name', $roomType->name) }}" placeholder="Nhập tên loại phòng">
                        @error('name')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-6 mb-3">
                        <label for="price" class="form-label fw-bold">Giá (VNĐ)</label>
                        <input type="number" name="price" class="form-control @error('price') is-invalid @enderror"
                               value="{{ old('price', $roomType->price) }}" placeholder="Nhập giá phòng">
                        @error('price')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="mb-3">
                    <label for="description" class="form-label fw-bold">Mô tả</label>
                    <textarea name="description" class="form-control @error('description') is-invalid @enderror"
                              rows="3" placeholder="Nhập mô tả về loại phòng...">{{ old('description', $roomType->description) }}</textarea>
                    @error('description')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="image" class="form-label fw-bold">Hình ảnh</label>
                        <input type="file" name="image" id="imageInput" class="form-control @error('image') is-invalid @enderror" accept="image/*">
                        @error('image')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                        
                    </div>

                    <div class="col-md-6 mt-4">
                        <label for="status" class="form-label fw-bold">Trạng thái</label>
                        <select name="status" class="form-select">
                            <option value="1" {{ $roomType->status == 1 ? 'selected' : '' }}>Hoạt động</option>
                            <option value="0" {{ $roomType->status == 0 ? 'selected' : '' }}>Không hoạt động</option>
                        </select>
                    </div>
                </div>

                <div class="text-end">
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save me-1"></i>Cập nhật loại phòng
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    document.getElementById('imageInput').addEventListener('change', function(event) {
        let reader = new FileReader();
        reader.onload = function() {
            document.getElementById('previewImage').src = reader.result;
        };
        reader.readAsDataURL(event.target.files[0]);
    });
</script>
@endsection
