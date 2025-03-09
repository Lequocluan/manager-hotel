@extends('admin.layout_admin.main')

@section('content')
<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card shadow-sm">
                <div class="card-header d-flex align-items-center">
                    <a href="javascript:window.history.back();" class="btn btn-light btn-sm me-2">
                        <i class="fas fa-arrow-left"></i>
                    </a>
                    <h5 class="mb-0 mx-auto">Chỉnh sửa tài khoản</h5>
                </div>
                <div class="card-body">
                    <form method="POST" action="{{ route('admin.handle_edit_account') }}">
                        @csrf
                        <div class="mb-3">
                            <label for="name" class="form-label">Tên</label>
                            <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name" value="{{ $data->name }}">
                            @error('name') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>
                        <div class="mb-3">
                            <label for="email" class="form-label">Email</label>
                            <input type="email" class="form-control @error('email') is-invalid @enderror" id="email" name="email" value="{{ $data->email }}">
                            @error('email') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>
                        <div class="mb-3">
                            <label for="phone" class="form-label">Số điện thoại</label>
                            <input type="text" class="form-control @error('phone') is-invalid @enderror" id="phone" name="phone" value="{{ $data->phone }}">
                            @error('phone') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>
                        <div class="mb-3">
                            <label for="address" class="form-label">Địa chỉ</label>
                            <input type="text" class="form-control @error('address') is-invalid @enderror" id="address" name="address" value="{{ $data->address }}">
                            @error('address') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>
                        <fieldset class="mb-3">
                            <legend class="col-form-label">Giới tính</legend>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" id="male" name="gender" value="1" {{ $data->gender == 1 ? 'checked' : '' }}>
                                <label class="form-check-label" for="male">Nam</label>
                            </div>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" id="female" name="gender" value="2" {{ $data->gender == 2 ? 'checked' : '' }}>
                                <label class="form-check-label" for="female">Nữ</label>
                            </div>
                        </fieldset>
                        <button type="submit" class="btn btn-primary w-100 py-2 fw-bold shadow-sm">Cập nhật</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
