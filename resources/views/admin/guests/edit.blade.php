@extends('admin.layout_admin.main')

@section('content')
<div class="container-fluid">
    <div class="d-flex align-items-center mb-3">
        <a href="{{ route('guests.index') }}" class="btn btn-outline-secondary btn-sm rounded-circle me-2" title="Quay lại">
            <i class="fas fa-arrow-left"></i>
        </a>
        <h2 class="m-0">Sửa khách hàng</h2>
    </div>

    <div class="card shadow-sm">
        <div class="card-body">
            <form action="{{ route('guests.update', $guest->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="name" class="form-label">Họ tên <span class="text-danger">*</span></label>
                        <input type="text" name="name" class="form-control @error('name') is-invalid @enderror"
                               value="{{ old('name', $guest->name) }}">
                        @error('name') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>

                    <div class="col-md-6 mb-3">
                        <label for="email" class="form-label">Email <span class="text-danger">*</span></label>
                        <input type="email" name="email" class="form-control @error('email') is-invalid @enderror"
                               value="{{ old('email', $guest->email) }}">
                        @error('email') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>

                    <div class="col-md-6 mb-3">
                        <label for="phone" class="form-label">Số điện thoại</label>
                        <input type="text" name="phone" class="form-control @error('phone') is-invalid @enderror"
                               value="{{ old('phone', $guest->phone) }}">
                        @error('phone') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>

                    <div class="col-md-6 mb-3">
                        <label for="identity_number" class="form-label">CMND/CCCD</label>
                        <input type="text" name="identity_number" class="form-control @error('identity_number') is-invalid @enderror"
                               value="{{ old('identity_number', $guest->identity_number) }}">
                        @error('identity_number') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>

                    <div class="col-md-6 mb-3">
                        <label for="address" class="form-label">Địa chỉ</label>
                        <textarea name="address" class="form-control @error('address') is-invalid @enderror">{{ old('address', $guest->address) }}</textarea>
                        @error('address') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>

                    <div class="col-md-6 mb-3">
                        <label for="avatar" class="form-label">Ảnh đại diện</label>
                        <input type="file" name="avatar" class="form-control @error('avatar') is-invalid @enderror"
                               onchange="previewAvatar(event)">
                        <img id="avatarPreview"
                             src="{{ $guest->avatar ? asset($guest->avatar) : '#' }}"
                             alt="Preview"
                             class="mt-2 rounded shadow-sm"
                             style="max-height: 100px; {{ $guest->avatar ? '' : 'display:none;' }}">
                        @error('avatar') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>
                </div>

                <div class="text-center">
                    <button type="submit" class="btn btn-primary">Cập nhật khách hàng</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@section('js')
<script>
    function previewAvatar(event) {
        const [file] = event.target.files;
        if (file) {
            const reader = new FileReader();
            reader.onload = function(e) {
                const img = document.getElementById('avatarPreview');
                img.src = e.target.result;
                img.style.display = 'block';
            }
            reader.readAsDataURL(file);
        }
    }
</script>
@endsection
