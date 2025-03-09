@extends('admin.layout_admin.main')

@section('content')
    <div class="container-fluid">
        <div class="row justify-content-center align-items-center" style="min-height: 80vh;">
            <div class="col-md-6">
                <div class="card shadow-sm rounded-3">
                    <div class="card-header bg-primary text-white rounded-top d-flex align-items-center">
                        <a href="javascript:window.history.back();" class="btn btn-light btn-sm me-2">
                            <i class="fas fa-arrow-left"></i>
                        </a>
                        <h5 class="mb-0 flex-grow-1 text-center">Đổi mật khẩu</h5>
                    </div>
                    <div class="card-body p-4">
                        <form method="POST" action="{{ route('admin.handle_update_password') }}">
                            @csrf
                            <div class="mb-3">
                                <label for="current_password" class="form-label">Mật khẩu hiện tại</label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="fas fa-lock"></i></span>
                                    <input type="password" class="form-control @error('current_password') is-invalid @enderror" id="current_password" name="current_password">
                                    @error('current_password')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="mb-3">
                                <label for="new_password" class="form-label">Mật khẩu mới</label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="fas fa-key"></i></span>
                                    <input type="password" class="form-control @error('new_password') is-invalid @enderror" id="new_password" name="new_password">
                                    @error('new_password')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="mb-3">
                                <label for="confirm_password" class="form-label">Xác nhận mật khẩu mới</label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="fas fa-check"></i></span>
                                    <input type="password" class="form-control" id="password_confirmation" name="confirm_password">
                                </div>
                            </div>
                            <button type="submit" class="btn btn-primary w-100 fw-bold shadow-sm">Cập nhật mật khẩu</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
