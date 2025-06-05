@extends('admin.layout_admin.main')
@section('content')
<div class="container-fluid">
    <div class="card shadow-sm m-4">
        <div class="card-header">
            <p class="card-title">
                <a href="{{ route('permissions.index') }}">
                    <button title="Quay lại" class="btn btn-outline-secondary btn-sm rounded-circle">
                        <i class="fas fa-arrow-left" data-bs-toggle="tooltip"></i>
                    </button>
                </a>
                <span class="text-uppercase" style="font-size: 14px">Chỉnh sửa quyền</span>
                <span class="text-primary">"{{ $permission->name }}"</span>
            </p>
        </div>
        <div class="card-body">
            <form action="{{ route('permissions.update', $permission->id) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="mb-3">
                    <label for="name_permission" class="form-label">Tên quyền <span class="text-danger">*</span></label>
                    <input type="text" value="{{ old('name_permission', $permission->name) }}"
                        class="form-control @error('name_permission') is-invalid @enderror" id="name_permission"
                        name="name_permission">
                    @error('name_permission')
                        <div class="message-error text-danger mt-1">{{ $message }}</div>
                    @enderror
                </div>
                <button type="submit" class="btn btn-primary">Lưu lại</button>
            </form>
        </div>
    </div>
</div>
@endsection
