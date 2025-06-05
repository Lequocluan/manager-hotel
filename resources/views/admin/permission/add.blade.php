@extends('admin.layout_admin.main')
@section('content')
<div class="container">
    <div class="card shadow-sm m-4">
        <div class="card-header">
            <h5 class="card-title m-0">Thêm quyền mới</h5>
        </div>
        <div class="card-body">
            <form action="{{ route('permissions.store') }}" method="POST">
                @csrf
                <div class="mb-3">
                    <label for="name_permission" class="form-label">Tên quyền <span class="text-danger">*</span></label>
                    <input type="text" name="name_permission" class="form-control @error('name_permission') is-invalid @enderror" value="{{ old('name_permission') }}">
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
